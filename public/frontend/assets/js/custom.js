(function($) {
    'use strict';

    jQuery('.mean-menu').meanmenu({
        meanScreenWidth: "991"
    });

    $(window).on('scroll', function() {
        if ($(this).scrollTop() >150){
            $('.navbar-area').addClass("sticky-nav");
        }
        else{
            $('.navbar-area').removeClass("sticky-nav");
        }
    });

	$(".burger-menu").on('click',  function() {
		$('.sidebar-modal').toggleClass('active');
	});
	$(".sidebar-modal-close-btn").on('click',  function() {
		$('.sidebar-modal').removeClass('active');
    });

	$(".side-nav-responsive .dot-menu").on("click", function(){
		$(".side-nav-responsive .container .container").toggleClass("active");
    });

    $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
    $('.tab ul.tabs li a').on('click', function (g) {
         var tab = $(this).closest('.tab'),
         index = $(this).closest('li').index();
         tab.find('ul.tabs > li').removeClass('current');
         $(this).closest('li').addClass('current');
         tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
         tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
         g.preventDefault();
    });

	$('.accordion').find('.accordion-title').on('click', function(){
		$(this).toggleClass('active');
		$(this).next().slideToggle('fast');
		$('.accordion-content').not($(this).next()).slideUp('fast');
		$('.accordion-title').not($(this)).removeClass('active');
    });

    $('.datetimepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    new WOW().init();

    $('select').niceSelect();

    $('body').append('<div id="toTop" class="top-btn"><i class="bx bx-chevrons-up"></i></div>');
    $(window).on('scroll',function () {
         if ($(this).scrollTop() != 0) {
             $('#toTop').fadeIn();
         } else {
             $('#toTop').fadeOut();
         }
    });
    $('#toTop').on('click',function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });

    function callbackFunction (resp) {
        if (resp.result === "success") {
            formSuccessSub();
        }
        else {
            formErrorSub();
        }
    }
    function formSuccessSub(){
        $(".newsletter-form")[0].reset();
        submitMSGSub(true, "Thank you for subscribing!");
        setTimeout(function() {
            $("#validator-newsletter").addClass('hide');
        }, 4000)
    }
    function formErrorSub(){
        $(".newsletter-form").addClass("animated shake");
        setTimeout(function() {
            $(".newsletter-form").removeClass("animated shake");
        }, 1000)
    }

    jQuery(window).on('load',function(){
        jQuery(".preloader").fadeOut(500);
    });

})(jQuery);

function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    document.documentElement.className = themeName;
}

function toggleTheme() {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-light');
        $("#dark-mode").removeClass();
        $("#dark-mode").addClass("bx bx-moon");
    } else {
        setTheme('theme-dark');
        $("#dark-mode").removeClass();
        $("#dark-mode").addClass("bx bx-sun");
    }
}

(function () {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-dark');
        $("#dark-mode").removeClass();
        $("#dark-mode").addClass("bx bx-sun");
    } else {
        setTheme('theme-light');
        $("#dark-mode").removeClass();
        $("#dark-mode").addClass("bx bx-moon");
    }
})();
