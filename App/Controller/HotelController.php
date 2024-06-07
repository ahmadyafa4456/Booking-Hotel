<?php
namespace App\Controller;

use DateTime;
use App\Cores\View;
use App\Model\Booking;
use App\Cores\Database;
use App\Service\AuthService;
use App\Request\HotelRequest;
use App\Service\HotelService;
use App\Request\RoomHotelRequest;
use App\Repository\AuthRepository;
use App\Request\ImageHotelRequest;
use App\Repository\HotelRespository;
use App\Exception\ValidationException;

require_once __DIR__ . '/../Cores/midtrans/midtrans-php/Midtrans.php';


class HotelController
{
    private HotelService $hotelService;
    private AuthService $authService;
    public function __construct()
    {
        $connection = Database::getConnection();
        $hotelRepository = new HotelRespository($connection);
        $this->hotelService = new HotelService($hotelRepository);

        $authRepository = new AuthRepository($connection);
        $this->authService = new AuthService($authRepository);
    }
    public function hotelPage()
    {
        $lokasi = $_GET['lokasi'];
        $data = $this->hotelService->hotelLocation($lokasi);
        $checkIn = $_GET['checkIn'];
        $checkOut = $_GET['checkOut'];
        if (empty($lokasi)) {
            $e = "Lokasi tidak boleh kosong";
            return View::Render("Home", [
                'title' => 'Home',
                'error' => $e,
            ]);
        } else {
            return View::Render("HotelPage", [
                "title" => 'Hotel',
                "hotel" => $data,
                "checkIn" => $checkIn,
                "checkOut" => $checkOut,
                "lokasi" => $lokasi
            ]);
        }
    }

    public function detailHotel($id)
    {
        $data = $this->hotelService->detailHotel($id);
        $image = $this->hotelService->imageHotel($id);
        $checkIn = $_GET['checkIn'];
        $checkOut = $_GET['checkOut'];
        $filteredImages = array_slice($image, 1, 3);
        return View::Render("HotelExam", [
            "title" => "Hotel",
            "hotel" => $data,
            "image" => $image,
            "filteredImage" => $filteredImages,
            "id" => $id,
            "checkIn" => $checkIn,
            "checkOut" => $checkOut,
        ]);
    }

    public function paymentHotel()
    {
        $idBooking = $_SESSION['booking_id'];
        $hotel = $this->hotelService->findById($idBooking);
        $checkIn = new DateTime($hotel->check_in);
        $checkOut = new DateTime($hotel->check_out);
        $interval = $checkOut->diff($checkIn);
        $numberOfNight = $interval->days;
        $total = $numberOfNight * $hotel->harga;
        return View::Render("HotelPayment", [
            "title" => "Hotel Payment",
            "total" => $total,
            "hotel" => $hotel,
            "numberOfNight" => $numberOfNight,
        ]);
    }

    public function booking()
    {
        $user = $this->authService->current();
        $hotel = $this->hotelService->bookingPaid($user->id);
        return View::Render("HotelBooking", [
            "title" => "Booking",
            "hotel" => $hotel,
            "nama" => $user->name,
        ]);
    }


    public function createHotel()
    {
        $hotel = new HotelRequest();
        $hotel->nama = $_POST['nama'];
        $hotel->alamat = $_POST['alamat'];
        $hotel->kota = $_POST['kota'];
        $this->hotelService->save($hotel);
    }

    public function createImageHotel()
    {
        $imageExtension = ["png", "jpg", "jpeg", "svn"];
        $gambarExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $target = "img/";
        if (!in_array($gambarExtension, $imageExtension)) {
            throw new ValidationException("gambar harus dalam format png, jpg, jpeg, svn");
        }
        if (!empty($_FILES['image']['tmp_name'])) {
            $targerFile = $target . uniqid() . "." . $gambarExtension;
        } else {
            $targerFile = "";
        }
        $imageHotel = new ImageHotelRequest();
        $imageHotel->hotel_id = $_POST["hotel_id"];
        $imageHotel->url = $targerFile;
        try {
            $this->hotelService->saveImageHotel($imageHotel);
            echo "Berhasil";
        } catch (ValidationException $exception) {
            echo $exception;
        }
    }

    public function createRoomHotel()
    {
        $imageExtension = ["png", "jpg", "jpeg", "svn"];
        $gambarExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $target = "img/";
        if (!in_array($gambarExtension, $imageExtension)) {
            throw new ValidationException("gambar harus dalam format png, jpg, jpeg, svn");
        }
        if (!empty($_FILES['image']['tmp_name'])) {
            $targerFile = $target . uniqid() . "." . $gambarExtension;
        } else {
            $targerFile = "";
        }
        $room = new RoomHotelRequest();
        $room->nama_kamar = $_POST['nama_kamar'];
        $room->jumlah_kasur = $_POST['jumlah_kasur'];
        $room->hotel_id = $_POST['hotel_id'];
        $room->url = $targerFile;
        $room->max = $_POST['max'];
        $room->harga = $_POST['harga'];
        try {
            $this->hotelService->saveRoomHotel($room);
            echo "Berhasil";
        } catch (ValidationException $exception) {
            echo $exception;
        }
    }

    public function userBooking()
    {
        $user = $this->authService->current();
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $booking = new Booking();
            $booking->id = uniqid();
            $booking->user_id = $user->id;
            $booking->hotel_id = $data['hotel_id'];
            $booking->kamar_id = $data['kamar_id'];
            $booking->check_in = $data['check_in'];
            $booking->check_out = $data['check_out'];
            $booking->status = "unpaid";
            $this->hotelService->booking($booking);
        } else {
            echo "gagal";
        }
    }

    public function payment()
    {
        $user = $this->authService->current();
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        \Midtrans\Config::$serverKey = 'SB-Mid-server-lCxBcvK2kDQDW5XBSU7go_-k';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $data['total'],
            ),
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            echo json_encode($snapToken);
        } catch (ValidationException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function paymentSuccess()
    {
        $idBooking = $_SESSION['booking_id'];
        $this->hotelService->update($idBooking);
        $user = $this->authService->current();
        $this->hotelService->deleteBookingWhereStatusUnpaid($user->id);
    }

    public function deleteBooking()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $id = (string) $data['id'];
        $this->hotelService->deleteBooking($id);
    }
}