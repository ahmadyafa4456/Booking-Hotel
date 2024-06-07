<?php
session_start();

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\HotelController;
use App\Controller\ProfileController;
use App\Cores\Router;
use App\Middleware\Authmiddleware;
use App\Middleware\Guestmiddleware;

require_once __DIR__ . "/../vendor/autoload.php";

Router::add("GET", "/", HomeController::class, 'home');
Router::add("GET", "/daftar", AuthController::class, 'daftar', [Guestmiddleware::class]);
Router::add("GET", "/login", AuthController::class, 'login', [Guestmiddleware::class]);
Router::add("GET", "/hotel", HotelController::class, 'hotelPage', [Authmiddleware::class]);
Router::add("GET", "/hotel/(:id)", HotelController::class, 'detailHotel', [Authmiddleware::class]);
Router::add("GET", "/payment", HotelController::class, 'paymentHotel', [Authmiddleware::class]);
Router::add("GET", "/profile", ProfileController::class, 'profile', [Authmiddleware::class]);
Router::add("GET", "/booking", HotelController::class, 'booking', [Authmiddleware::class]);

Router::add("POST", "/updateProfile", ProfileController::class, "updateProfile", [Authmiddleware::class]);
Router::add("POST", "/hotel", HotelController::class, "createHotel", [Authmiddleware::class]);
Router::add("POST", "/hotel/image", HotelController::class, "createImageHotel", [Authmiddleware::class]);
Router::add("POST", "/hotel/room", HotelController::class, "createRoomHotel", [Authmiddleware::class]);
Router::add("POST", "/daftar", AuthController::class, "daftarUser", [Guestmiddleware::class]);
Router::add("POST", "/login", AuthController::class, "loginUser", [Guestmiddleware::class]);
Router::add("POST", "/logout", AuthController::class, "logout", [Authmiddleware::class]);
Router::add("POST", "/booking", HotelController::class, 'userBooking', [Authmiddleware::class]);
Router::add("POST", "/payment", HotelController::class, 'payment', [Authmiddleware::class]);
Router::add("POST", "/paymentpaid", HotelController::class, 'paymentSuccess', [Authmiddleware::class]);
Router::add("POST", "/deleteBooking", HotelController::class, 'deleteBooking', [Authmiddleware::class]);

Router::run();