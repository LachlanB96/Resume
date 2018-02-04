$(document).ready(function() {
    $(window).scroll(function () { 

        console.log($(window).scrollTop());
        console.log(window.innerHeight);

        if ($(window).scrollTop() > window.innerHeight) {
            $('nav').addClass("navbar-fixed-top");
        }

        if ($(window).scrollTop() < window.innerHeight) {
            $('nav').removeClass("navbar-fixed-top");
        }
        beforeContent = 100;
        if ($(window).scrollTop() > beforeContent) {
            $('.section-title').addClass("onscreen");
        }
    });
});

$(function () {
    $('.min-chart#chart-sales').easyPieChart({
        barColor: "#4caf50",
        onStep: function (from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        }
    });
});