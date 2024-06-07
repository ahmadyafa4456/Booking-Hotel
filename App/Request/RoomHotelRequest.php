<?php
namespace App\Request;

class RoomHotelRequest
{
    public string $nama_kamar;
    public int $jumlah_kasur;
    public int $hotel_id;
    public string $url;
    public int $max;
    public int $harga;
}