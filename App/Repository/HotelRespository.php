<?php
namespace App\Repository;

use PDO;

class HotelRespository
{
    private \PDO $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create($data)
    {
        $statement = $this->connection->prepare("insert into hotel(nama, alamat, kota) values(?, ?, ?)");
        $statement->execute([
            $data['nama'],
            $data['alamat'],
            $data['kota']
        ]);
    }
    public function createImageHotel($data)
    {
        $statement = $this->connection->prepare("insert into image(hotel_id, url) values( ?, ?)");
        $statement->execute([
            $data['hotel_id'],
            $data['url']
        ]);
    }
    public function createRoomHotel($data)
    {
        $statement = $this->connection->prepare("insert into kamar(nama_kamar, jumlah_kasur, hotel_id, url, max, harga) values( ?, ?, ?, ?, ?, ?)");
        $statement->execute([
            $data['nama_kamar'],
            $data['jumlah_kasur'],
            $data['hotel_id'],
            $data['url'],
            $data['max'],
            $data['harga'],
        ]);
    }

    public function hotelByLocation($lokasi)
    {
        $statement = $this->connection->prepare("select h.id, h.nama, h.kota, i.url, k.harga_termurah from hotel h left join (select hotel_id, url from image where id in (select min(id) from image group by hotel_id)) i on h.id = i.hotel_id left join (Select hotel_id, min(harga) as harga_termurah from kamar group by hotel_id) k on h.id = k.hotel_id where h.kota = ? order by h.kota");
        $statement->execute([$lokasi]);
        $data = $statement->fetchAll();
        return $data;
    }

    public function detailHotelById($id)
    {
        $statement = $this->connection->prepare("select h.id, h.nama, h.kota, h.alamat, k.id, k.nama_kamar, k.jumlah_kasur, k.max, k.harga, k.url from hotel h left join kamar k on h.id = k.hotel_id where h.id = ?");
        $statement->execute([$id]);
        $data = $statement->fetchAll();
        return $data;
    }

    public function imageHotel($id)
    {
        $statement = $this->connection->prepare("select url from image where hotel_id = ?");
        $statement->execute([$id]);
        $data = $statement->fetchAll();
        return $data;
    }

    public function booking($booking)
    {
        $statement = $this->connection->prepare("insert into booking(id, user_id, hotel_id, kamar_id, check_in, check_out, status) values(?, ?, ?, ?, ?, ?, ?)");
        $statement->execute([
            $booking->id,
            $booking->user_id,
            $booking->hotel_id,
            $booking->kamar_id,
            $booking->check_in,
            $booking->check_out,
            $booking->status,
        ]);
    }

    public function findById($id)
    {
        $statement = $this->connection->prepare("SELECT 
        h.nama, 
        h.alamat, 
        b.check_in, 
        b.check_out, 
        k.nama_kamar, 
        k.jumlah_kasur, 
        k.harga,
        (SELECT i.url 
         FROM image i 
         WHERE i.hotel_id = h.id 
         ORDER BY i.id ASC 
         LIMIT 1) AS gambar_pertama
    FROM 
        booking b 
    LEFT JOIN 
        hotel h ON h.id = b.hotel_id 
    LEFT JOIN 
        kamar k ON k.id = b.kamar_id 
    WHERE 
        b.id = ?;
    ");
        $statement->execute([$id]);
        $data = $statement->fetch(PDO::FETCH_OBJ);
        return $data;
    }

    public function update($id)
    {
        $statement = $this->connection->prepare("update booking set status = 'paid' where id = ?");
        $statement->execute([$id]);
    }

    public function bookingPaid($id)
    {
        $statement = $this->connection->prepare("SELECT
        b.id, 
        h.nama, 
        h.alamat, 
        b.check_in, 
        b.check_out, 
        k.nama_kamar, 
        k.jumlah_kasur, 
        (SELECT i.url 
         FROM image i 
         WHERE i.hotel_id = h.id 
         ORDER BY i.id ASC 
         LIMIT 1) AS gambar_pertama
    FROM 
        booking b 
    LEFT JOIN 
        hotel h ON h.id = b.hotel_id 
    LEFT JOIN 
        kamar k ON k.id = b.kamar_id 
    WHERE 
        b.status = 'paid' AND b.user_id = ?
    ");
        $statement->execute([$id]);
        $data = $statement->fetchAll();
        return $data;
    }

    public function deleteBooking($id)
    {
        $statement = $this->connection->prepare("delete from booking where id = ?");
        $statement->execute([$id]);
    }

    public function deleteBookingWhereStatusUnpaid($id)
    {
        $statement = $this->connection->prepare("delete from booking where status = 'unpaid' AND user_id = ? ");
        $statement->execute([$id]);
    }
}