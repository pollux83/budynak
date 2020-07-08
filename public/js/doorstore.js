$(document).ready(function(){
    $('nav li').hover(function() {
        $(this).find('a:first').addClass("active2");
        $(this).find('ul').addClass("showDrop");
    }, function() {
        $(this).find('a:first').removeClass("active2");
        $(this).find('ul').removeClass("showDrop");
    });

    //if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        
    if (window.innerWidth <= 800 && window.innerHeight <= 600) {
        $('.cdropl a:first').click(function() {
            var isOpen = $("#cdrop").attr("class");
            if (isOpen == "showDrop") {
                $(this).removeClass("active2");
                $('#cdrop').removeClass("showDrop");
            } else {
                $(this).addClass("active2");
                $("#cdrop").addClass("showDrop");
            }
        });
        $('.cdropl a:first').click(function(e) { e.stopPropagation(); });
        $(':not(.cdropl a:first)').click(function() {
            $(".cdropl a:first").removeClass("active2");
            $("#cdrop").removeClass("showDrop");
        });
    } else {
        $('.cdropl').hover(function() {
            $(this).find('a:first').addClass("active2");
            $(this).find('ul').addClass("showDrop");
        }, function() {
            $(this).find('a:first').removeClass("active2");
            $(this).find('ul').removeClass("showDrop");
        });
    }

    jQuery('.mobsearch a').click(function() {
        jQuery(this).toggleClass("active3");
        jQuery('#rTop .search').toggleClass("show");
    });

    jQuery('.con h2').click(function() {
        var canSee = jQuery('.con .cat').is(":visible");
        if (canSee == true ) {
            jQuery('.con .cat').slideUp();
            jQuery('.icon .fa').attr('class','fa fa-caret-down');
        } else {
            jQuery('.con .cat').slideDown();
            jQuery('.icon .fa').attr('class','fa fa-caret-up');
        }
    });

});

jQuery(function() {
    jQuery('#navBox').dlmenu({
        animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
    });
});