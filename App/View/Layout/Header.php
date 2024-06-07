<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<?php
use App\Cores\Database;
use App\Repository\AuthRepository;
use App\Service\AuthService;

$connection = Database::getConnection();
$authRepository = new AuthRepository($connection);
$authService = new AuthService($authRepository);

$user = $authService->current();
if (is_null($user)) {
    $user = [
        'nama'
        => null,
        'url' => null,
    ];
} else {
    $user = [
        'nama' => $user->name,
        'url' => $user->img,
    ];
}
?>

<body>
    <div class="header">
        <img class="imageHeader" src="/img/TravelPedia.png" alt="" onclick="home()">
        <?php if (is_null($user['nama']) || is_null($user['url'])) { ?>
            <div class="guest">
                <div class="daftar" onclick="daftar()">Daftar</div>
                <div class="login" onclick="masuk()">Masuk</div>
            </div>
        <?php } else { ?>
            <div class="profile" id="profile" onclick="toggleSetting()">
                <img src="/<?= $user['url'] ?>" alt="">
                <p><?= $user['nama'] ?></p>
            </div>
            <div class="settingProfile" id="settingProfile">
                <p onclick="pengaturan()">Pengaturan</p>
                <p onclick="booking()">Booking</p>
                <p class="last" onclick="keluar()">Keluar</p>
            </div>
        <?php } ?>
    </div>
    <div class="main">