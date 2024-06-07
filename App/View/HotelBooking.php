<div class="g7div1">
    <p>Detail Pesanan</p>
</div>
<?php foreach ($data['hotel'] as $hotel): ?>
    <div class="g7div2" style="margin-bottom: 20px;">
        <div class="g7div2sub1">
            <div class="g7div2sub3">
                <p>Nama Hotel</p>
                <p class="g7div2sub4"><?= $hotel['nama'] ?></p>
                <p><?= $hotel['alamat'] ?></p>
            </div>
            <div class="g7div2sub5">
                <img src="/<?= $hotel['gambar_pertama'] ?>" alt="">
            </div>
        </div>
        <div class="g7border"></div>
        <div class="g7div3sub1">
            <div class="g7div2sub3">
                <p>Check-In</p>
                <p class="g7div2sub4"><?= $hotel['check_in'] ?></p>
            </div>
            <div class="g7div2sub3">
                <p>Check-Out</p>
                <p class="g7div2sub4"><?= $hotel['check_out'] ?></p>
            </div>
        </div>
        <div class="g7border"></div>
        <div class="g7div4sub1">
            <div class="g7div4sub0">
                <p>Nama Tamu</p>
                <p class="g7div4sub3"><?= $data['nama'] ?></p>
            </div>
            <div class="g7div4sub4">
                <div class="g7div4sub0">
                    <p>Detail Kamar</p>
                    <p class="g7div4sub3"><?= $hotel['nama_kamar'] ?></p>
                    <p><?= $hotel['jumlah_kasur'] ?> Kamar</p>
                </div>
                <div class="g7div4sub5" onclick="deleteBooking(<?= $hotel['id'] ?>)">
                    Batalkan
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    async function deleteBooking(id) {
        try {
            const response = await fetch("http://localhost:8080/deleteBooking", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: id }),
            });
            window.location.href = "/booking";
        } catch (error) {
            console.error(error);
        }
    }
</script>