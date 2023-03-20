import lightGallery from "lightgallery";
import lgThumbnail from "lightgallery/plugins/thumbnail"
import lgZoom from "lightgallery/plugins/zoom"

window.lightGallery = lightGallery;
window.lgThumbnail = lgThumbnail;
window.lgZoom = lgThumbnail;

window.$ = window.jQuery = require("jquery");

var sliderSwiper = new Swiper(".slider-swiper", {
    pagination: {
        el: ".swiper-pagination",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 7000,
    },
});

var reviewsSwiper = new Swiper(".reviews-swiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        // 1400: {
        //     slidesPerView: 2,
        // },
        // 2000: {
        //     slidesPerView: 2,
        // },
    },
    pagination: {
        el: ".swiper-pagination",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

// lightGallery(document.getElementById("klienti"), {
//     selector: ".image",
//     plugins: [lgZoom, lgThumbnail],
//     speed: 500,
// });

$(document).ready(function () {
    // $("#offcanvas .nav li a").click(function (event) {
    //     $("#offcanvas").removeClass("show");
    //     $(".offcanvas-backdrop").remove();
    //     $("body").removeAttr("style");
    // });
});
