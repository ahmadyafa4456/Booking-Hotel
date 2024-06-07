<div class="g1">
    <img src="/img/hotel.png" alt="">
    <p class="g1lokasi"><?= $data['lokasi'] ?></p>
    <div class="g1carilokasi">
        Ubah Lokasi
    </div>
</div>
<div>
    <?php foreach ($data['hotel'] as $hotel): ?>
        <div class="g2" onclick="redirectToHotel(<?= $hotel['id'] ?>)">
            <img src="<?= $hotel['url'] ?>" alt="">
            <div class="g2div1">
                <p><?= $hotel['nama'] ?></p>
                <div class="g2div2">
                    <img src="/img/location.png" alt="">
                    <p><?= $hotel['kota'] ?></p>
                </div>
            </div>
            <div class="g3">
                <p class="g3harga">Rp<?= number_format($hotel['harga_termurah'], 0, ",", ".") ?></p>
                <p class="g3lanjutan">Termasuk pajak kamar/makan/malam</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function redirectToHotel(hotelId) {
        window.location.href = `/hotel/${hotelId}?checkIn=<?= $data['checkIn'] ?>&checkOut=<?= $data['checkOut'] ?>`;
    }
</script>