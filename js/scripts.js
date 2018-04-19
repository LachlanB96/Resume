$(document).ready(function() {
    $(".striked-out").hover(function(event){
        $(".formHover").show();
    });





    var sectionPos = Array();
    $.each(
        $(".section > div"),
        function(index, value){
            sectionPos.push({section: value.className, position: (
                value.getBoundingClientRect().y
                )});
        }
        );
    
    console.log(sectionPos);
    console.log(window.innerHeight);
    navSticky = false;
    $(window).scroll(function () {
        //$(".navbar").css("opacity", Math.min(1, ($(window).scrollTop() / window.innerHeight - 0.5) * 2)); //Minus 0.5 so that we get a value range from -1 to 1, making the fade start at halfway (0)
        distFromTop = $(window).scrollTop();
        console.log(distFromTop);
        console.log(window.innerHeight);

        if (distFromTop >= window.innerHeight - 20 && !navSticky) {
            console.log(navSticky);
            $('nav').addClass("navbar-fixed-top");
            navSticky = true;
        }

        else if (distFromTop < window.innerHeight - 20) {
            navSticky = false;
            $('nav').removeClass("navbar-fixed-top");
        }
        beforeContent = 100;
        if (distFromTop > beforeContent) {
            $('.section .title').addClass("onscreen");
        }
        $(".nav > li").removeClass("active");
        for (var i = 1; i < sectionPos.length; i++) {
            if(distFromTop < sectionPos[i].position){
                $(".nav > #" + sectionPos[i-1].section).removeClass("not-active").addClass("active");
                return;
            }
        }
    });

    $("#emailButton").click(function(){
        str = "I like computer lan";
        futureGoal = "b.com";
        email = "c";
        email += String.fromCharCode(118);
        email += String.fromCharCode(Math.pow(2, 6));
        email += "la" + "c" + ('h');
        email += str[16] + str[17] + str[18] ;
        email += futureGoal;
        mailTo = "mailto:" + email + "?subject=%5BImportant%5D%5BWebsite%5D%20%3CYour%20Title%20Here%3E&body=";
        $("#emailPlain").text(email);
        $("#mailTo").attr("style", "");
        $("#mailTo > a").attr("href", mailTo);
    });
});

function doThis(id){
    $('#' + jq(id)).toggle();
    $('.sub' + jq(id)).toggle();
}

function jq( myid ) {
    return myid.replace( /(:|\/|\+)/g, "\\$1" );
}