<?php
namespace App\Model;

class Booking
{
    public string $id;
    public int $user_id;
    public int $hotel_id;
    public int $kamar_id;
    public string $check_in;
    public string $check_out;
    public string $status;
}