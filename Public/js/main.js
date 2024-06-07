function toggleSetting() {
   const setting = document.getElementById("settingProfile");
   if (setting.style.display === "none") {
      setting.style.display = "block";
   } else {
      setting.style.display = "none";
   }
}

document.addEventListener("DOMContentLoaded", function () {
   const checkInInput = document.querySelector(".valueCheckIn");
   const checkOutInput = document.querySelector(".valueCheckOut");
   const tomorrow = new Date();
   const today = tomorrow.toISOString().split("T")[0];
   tomorrow.setDate(tomorrow.getDate() + 1);
   const tomorrowFormatted = tomorrow.toISOString().split("T")[0];
   checkInInput.addEventListener("change", function () {
      const checkInDate = new Date(checkInInput.value);
      checkOutInput.value =
         checkInDate.getFullYear() +
         "-" +
         ("0" + (checkInDate.getMonth() + 1)).slice(-2) +
         "-" +
         ("0" + (checkInDate.getDate() + 1)).slice(-2);
   });
   checkInInput.value = today;
   checkOutInput.value = tomorrowFormatted;
});

function daftar() {
   window.location.href = "daftar";
}

function masuk() {
   window.location.href = "login";
}

function home() {
   window.location.href = "/";
}

function pengaturan() {
   window.location.href = "/profile";
}

function booking() {
   window.location.href = "/booking";
}

async function keluar() {
   try {
      const response = await fetch("/logout", {
         method: "POST",
      });
      window.location.href = "/";
   } catch (error) {
      console.error(error);
   }
}
