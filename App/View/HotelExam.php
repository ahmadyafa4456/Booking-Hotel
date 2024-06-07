<div class="g4">
    <div class="g4div1">
        <div class="g4div2">
            <p class="g4namahotel"><?= $data['hotel'][0][1] ?></p>
            <div class="g4divsub">
                <img src="/img/location.png" alt="">
                <p><?= $data['hotel'][0][2] ?></p>
            </div>
        </div>
        <div class="g4div3">
            <p>Lihat Kamar</p>
        </div>
    </div>
    <div class="g4div4">
        <div class="g4div4sub1">
            <img src="/<?= $data['image'][0][0] ?>" alt="">
        </div>
        <div class="g4div4sub2">
            <?php foreach ($data['filteredImage'] as $hotel): ?>
                <img src="/<?= $hotel['url'] ?>" alt="">
            <?php endforeach; ?>
        </div>
    </div>
    <div class="g4div5">
        <p>Fasilitas</p>
        <div class="g4div5sub0">
            <div class="g4div5sub1">
                <img src="/img/hy.png" alt="">
                <p>Hygiene Verified</p>
            </div>
            <div class="g4div5sub1">
                <img src="/img/hotel-ac.png" alt="">
                <p class="ac">AC</p>
            </div>
            <div class="g4div5sub1">
                <img src="/img/hotel-no_smoking.png" alt="">
                <p class="smoking">Ruang Bebas Rokok</p>
            </div>
            <div class="g4div5sub1">
                <img src="/img/hotel-internet.png" alt="">
                <p class="wifi">Wifi Gratis</p>
            </div>
            <div class="g4div5sub1">
                <img src="/img/hotel-lift.png" alt="">
                <p class="lift">Lift</p>
            </div>
        </div>
    </div>
    <?php foreach ($data['hotel'] as $hotel): ?>
        <div class="g4div6">
            <img src="/<?= $hotel['url'] ?>" alt="">
            <div class="g4div6sub1">
                <div class="giv4div6sub2">
                    <div class="g4div6sub3">
                        <p class="kamar"><?= $hotel['nama_kamar'] ?></p>
                        <p>Maksimal <?= $hotel['max'] ?> Dewasa</p>
                        <p><?= $hotel['jumlah_kasur'] ?> kasur</p>
                    </div>
                    <div class="g4div6sub3">
                        <p class="g4div6sub4">Rp<?= number_format($hotel['harga'], 0, ",", ".") ?></p>
                        <p class="">Termasuk pajak kamar/makan/malam</p>
                        <div class="pilihkamar" onclick="booking(<?= json_encode($hotel['id']) ?>)">
                            <p>
                                Pilih Kamar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    async function booking($id) {
        const hotelId = <?= json_encode($data['hotel'][0][0]) ?>;
        const kamarId = $id;
        const checkIn = <?= json_encode($data['checkIn']) ?>;
        const checkOut = <?= json_encode($data['checkOut']) ?>;
        const data = {
            hotel_id: hotelId,
            kamar_id: kamarId,
            check_in: checkIn,
            check_out: checkOut
        };
        try {
            const response = await fetch("http://localhost:8080/booking", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            window.location.href = "/payment";
        } catch (error) {
            console.error("Error:", error)
        }
    }
</script>