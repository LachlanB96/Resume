$(document).ready(function() {
    $(window).scroll(function () { 

        console.log($(window).scrollTop());
        console.log(window.innerHeight);

        if ($(window).scrollTop() < window.innerHeight) {
            $('nav').addClass("sticky-top");
        }

        if ($(window).scrollTop() > window.innerHeight) {
            $('nav').removeClass("sticky-top");
        }
    });
});