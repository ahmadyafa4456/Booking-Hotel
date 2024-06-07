<div class="home">
    <div class="div1">
        <p>Hotel</p>
        <div class="imageHome">
            <img src="/img/bgHotel.jpg" alt="">
        </div>
    </div>
    <div class="div2">
        <div class="inputInHome">
            <p>Booking Hotel</p>
            <?php if (isset($data['error'])) { ?>
                <div class="errorH">
                    <p><?= $data['error'] ?></p>
                </div>
            <?php } ?>
            <form class="inputHotel" method="GET" action="/hotel">
                <div class="inputLokasi">
                    <p>Pilih Lokasi</p>
                    <input type="text" name="lokasi" id="">
                </div>
                <div class="inputCheckIn">
                    <p>Check-In</p>
                    <input type="date" name="checkIn" class="valueCheckIn" onchange="updateCheckOut()" placeholder="">
                </div>
                <div class="inputCheckOut">
                    <p>Check-Out</p>
                    <input type="date" name="checkOut" class="valueCheckOut">
                </div>
                <div class="cari">
                    <button type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const updateCheckOut = () => {
        const checkInInput = document.querySelector(".valueCheckIn");
        const valueCheckIn = new Date(checkInInput.value);
        const valueCheckOut = new Date(valueCheckIn);
        valueCheckOut.setDate(valueCheckIn.getDate() + 1);
        const ValueString = valueCheckOut.toISOString().split('T')[0];
        const checkOutInput = document.querySelector(".valueCheckOut");
        checkOutInput.value = ValueString;
    }
</script>