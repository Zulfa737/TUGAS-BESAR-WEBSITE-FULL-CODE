/* script.js - Logic Animasi Scroll */

document.addEventListener("DOMContentLoaded", function() {
    
    function reveal() {
        // Ambil semua elemen dengan class animasi
        var reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right");

        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100; // Jarak (px) dari bawah layar

            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }

    // Jalankan saat scroll
    window.addEventListener("scroll", reveal);

    // Jalankan sekali saat load agar elemen teratas langsung muncul
    reveal();
});