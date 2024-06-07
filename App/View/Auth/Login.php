<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="g8">
        <div class="g8div1sub1">
            <div class="g8div2">
                <img src="/img/TravelPedia.png" alt="" onclick="home()">
            </div>
            <?php if (isset($data['error'])) { ?>
                <div class="error">
                    <p><?= $data['error'] ?></p>
                </div>
            <?php } ?>
            <form class="g8div3" method="post" action="/login">
                <div class="g8div4">
                    <p>Email</p>
                    <input type="text" name="email" id="">
                </div>
                <div class="g8div4">
                    <p>Password</p>
                    <input type="password" name="password" id="">
                </div>
                <button type="submit">Login</button>
                <div class="g8div5">
                    <a href="/daftar">Belum Punya Akun?</a>
                </div>
            </form>
        </div>
    </div>
    <script src="js/main.js"></script>

</body>

</html>