$(function() {
	"use strict";
    $(".mobile-toggle-menu").on("click", function() {
        $(".wrapper").addClass("toggled")
    }),

    $(".dark-mode").on("click", function() {

        if (localStorage.getItem('theme') === 'dark-theme') {
            setTheme('light-theme');
        } else {
            setTheme('dark-theme');
        }

        if($(".dark-mode-icon i").attr("class") == 'bx bx-sun') {
            $(".dark-mode-icon i").attr("class", "bx bx-moon");
            $("html").attr("class", "light-theme")
        } else {
            $(".dark-mode-icon i").attr("class", "bx bx-sun");
            $("html").attr("class", "dark-theme")
        }

    }),

    $(".toggle-icon").click(function() {
        $(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
            $(".wrapper").addClass("sidebar-hovered")
        }, function() {
            $(".wrapper").removeClass("sidebar-hovered")
        }))
    }),

    $(document).ready(function() {
        $(window).on("scroll", function() {
            $(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
        }), $(".back-to-top").on("click", function() {
            return $("html, body").animate({
                scrollTop: 0
            }, 600), !1
        })
    }),

    $(function() {
        for (var e = window.location, o = $(".metismenu li a").filter(function() {
                return this.href == e
            }).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
    }),


    $(function() {
        $("#menu").metisMenu()
    })
});

(function () {
    if (localStorage.getItem('theme') === 'dark-theme') {
        $(".dark-mode-icon i").attr("class", "bx bx-sun");
        setTheme('dark-theme');
    } else {
        $(".dark-mode-icon i").attr("class", "bx bx-moon");
        setTheme('light-theme');
    }
})();

function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    document.documentElement.className = themeName;
}
