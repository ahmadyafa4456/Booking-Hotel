<?php
namespace App\Service;

use App\Repository\HotelRespository;
use App\Exception\ValidationException;

class HotelService
{
    private HotelRespository $hotelRespository;
    public function __construct(HotelRespository $hotelRespository)
    {
        $this->hotelRespository = $hotelRespository;
    }

    public function validatedInput($request)
    {
        if (is_object($request)) {
            $request = (array) $request;
        }
        if (is_array($request)) {
            $data = [];
            foreach ($request as $key => $value) {
                $value = trim($value);
                $value = strip_tags($value);
                $value = stripcslashes($value);
                $value = htmlspecialchars($value);
                $data[$key] = $value;
            }
            return $data;
        } else {
            return null;
        }
    }

    public function Validated($data)
    {
        $data = $this->validatedInput($data);
        if ($data['nama'] == null || $data['nama'] == "" || $data['alamat'] == null || $data['alamat'] == "" || $data['kota'] == null || $data['kota'] == "") {
            throw new ValidationException("nama, alamat, kota tidak boleh kosong");
        } else if (strlen($data['nama']) < 4) {
            throw new ValidationException("nama harus lebih dari 4 karakter");
        } else if (strlen($data['alamat']) < 4) {
            throw new ValidationException("alamat harus lebih dari 4 karakter");
        } else if (strlen($data['kota']) < 4) {
            throw new ValidationException("kota harus lebih dari 4 karakter");
        }
        return $data;
    }

    public function save($hotel)
    {
        $data = $this->Validated($hotel);
        return $this->hotelRespository->create($data);
    }

    public function saveImageHotel($imageHotel)
    {
        $data = $this->validatedInput($imageHotel);
        $this->hotelRespository->createImageHotel($data);
        move_uploaded_file($_FILES['image']['tmp_name'], $data['url']);
    }
    public function saveRoomHotel($room)
    {
        $data = $this->validatedInput($room);
        $this->hotelRespository->createRoomHotel($data);
        move_uploaded_file($_FILES['image']['tmp_name'], $data['url']);
    }

    public function hotelLocation($lokasi)
    {
        return $this->hotelRespository->hotelByLocation($lokasi);
    }

    public function detailHotel($id)
    {
        return $this->hotelRespository->detailHotelById($id);
    }

    public function imageHotel($id)
    {
        return $this->hotelRespository->imageHotel($id);
    }

    public function booking($booking)
    {
        $_SESSION['booking_id'] = $booking->id;
        return $this->hotelRespository->booking($booking);
    }

    public function findById($id)
    {
        return $this->hotelRespository->findById($id);
    }

    public function update($idBooking)
    {
        $this->hotelRespository->update($idBooking);
    }

    public function bookingPaid($id)
    {
        return $this->hotelRespository->bookingPaid($id);
    }

    public function deleteBooking($id)
    {
        $this->hotelRespository->deleteBooking($id);
    }

    public function deleteBookingWhereStatusUnpaid($id)
    {
        $this->hotelRespository->deleteBookingWhereStatusUnpaid($id);
    }
}