<div class="g5">
    <div class="g5div1">
        <img src="/img/hotel.png" alt="">
        <p>Ringkasan Pesanan</p>
    </div>
    <div class="g5divsub">
        <div class="g5div2">
            <div class="g5div2sub1">
                <img src="/<?= $data['hotel']->gambar_pertama ?>" alt="">
                <div class="g5div2sub3">
                    <p><?= $data['hotel']->nama ?></p>
                    <div class="g5div2sub4">
                        <img src="/img/location.png" alt="">
                        <p><?= $data['hotel']->alamat ?></p>
                    </div>
                </div>
            </div>
            <div class="g5div3sub2">
                <div class="g5div3sub3">
                    <p>Check-In</p>
                    <p class="g5div3sub4"><?= $data['hotel']->check_in ?></p>
                </div>
                <div class="g5div3sub3">
                    <p>Check-In</p>
                    <p class="g5div3sub4"><?= $data['hotel']->check_out ?></p>
                </div>
                <div class="g5div3sub3">
                    <p class="g5div3sub4"><?= $data['hotel']->nama_kamar ?></p>
                    <p><?= $data['hotel']->jumlah_kasur ?> Kamar</p>
                </div>
            </div>
        </div>
        <div class="g5div4">
            <p>Ringkasan Harga</p>
            <div class="g5div4sub1">
                <p><?= $data['hotel']->jumlah_kasur ?> Kamar x <?= $data['numberOfNight'] ?> Malam</p>
                <p>Rp<?= number_format($data['total'], 0, ",", ".") ?></p>
            </div>
            <div class="g5div4sub2">
                <p>Total Pembayaran</p>
                <p>Rp<?= number_format($data['total'], 0, ",", ".") ?></p>
            </div>
            <div class="g5div4sub3" onclick="payment()">
                <p>Bayar</p>
            </div>
        </div>
    </div>
</div>

<script>
    async function payment() {
        const total = <?= json_encode($data['total']) ?>;
        const data = {
            total: total,
        };
        try {
            const response = await fetch("http://localhost:8080/payment", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data),
            });
            const token = await response.json();
            window.snap.pay(token, {
                onSuccess: (result) => {
                    paid();
                    window.location.href = "/booking";
                }
            });
        } catch (error) {
            console.error(error.message);
        }
    }


    async function paid() {
        try {
            const response = await fetch("http://localhost:8080/paymentpaid", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
            });
        } catch (error) {
            console.error(error.message)
        }
    }
</script>