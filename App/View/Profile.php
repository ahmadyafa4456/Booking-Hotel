<form class="g6" method="post" action="/updateProfile" enctype="multipart/form-data">
    <div class="g6div1">
        <?php if (is_null($data['user']->img)) { ?>
            <img src="/img/unknown.png" id="preview" alt="">
        <?php } else { ?>
            <img src="/<?= $data['user']->img ?>" id="preview" alt="">
        <?php } ?>
        <input type="file" src="" id="fileInput" alt="" name="image" accept="image/*" onchange="fileSelect(this)"
            hidden>
        <p onclick="openFile()">Pilih Foto</p>
    </div>
    <div class="g6div2">
        <div class="g6div2sub1">Ubah Profil</div>
        <?php if (isset($data['error'])) { ?>
            <div class="errorP">
                <p><?= $data['error'] ?></p>
            </div>
        <?php } ?>
        <div class="g6div2sub2">
            <div class="g6div2sub3">
                <p>Nama</p>
                <input type="text" name="name" id="" value="<?= $data['user']->name ?>">
            </div>
            <div class="g6div2sub3email">
                <p class="">Email</p>
                <input type="text" name="email" id="" value="<?= $data['user']->email ?>">
            </div>
        </div>
        <div class="g6div2sub4">
            <button type="submit">Simpan</button>
        </div>
    </div>
</form>

<script>
    function openFile() {
        document.getElementById("fileInput").click();
    }
    function fileSelect(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById("preview").src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>