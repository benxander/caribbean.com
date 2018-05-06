/*
 *
 *		CUSTOM.JS
 *
 */

(function($){
	// DETECT TOUCH DEVICE //
	function is_touch_device() {
		return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
	}
	// MENU SLIDE //
	function menu_slide() {
		$(".menu-slide-container").prepend('<a class="close-menu" href="#">&times</a>');
		$(".menu-button").on("click", function(e) {
			e.preventDefault();
			$(".menu-slide-container").toggleClass("menu-open");
			$("#header, #header-sticky").toggleClass("header-hidden");
		});
		$(".close-menu").on("click", function(e) {
			e.preventDefault();
			$(".menu-slide-container").removeClass("menu-open");
			$("#header, #header-sticky").removeClass("header-hidden");
		});
		$(".menu-slide li").each(function() {
			if ($(this).hasClass('dropdown') || $(this).hasClass('megamenu')) {
				$(this).append('<span class="arrow"></span>');
			}
		});
		$(".menu-slide li.dropdown > span").on("click", function(e) {
			e.preventDefault();
			$(this).toggleClass("open").prev("ul").slideToggle(300);
		});
		$(".menu-slide li.megamenu > span").on("click", function(e) {
			e.preventDefault();
			$(this).toggleClass("open").prev("div").slideToggle(300);
		});
	}
	// SHOW/HIDE MOBILE MENU //
	function show_hide_mobile_menu() {
		$("#mobile-menu-button").on("click", function(e) {
			e.preventDefault();
			$("#mobile-menu").slideToggle(300);
        });
	}
	// MOBILE MENU //
	function mobile_menu() {
        if ($(window).width() < 992) {
			if ($("#menu").length < 1) {
				$("#header").append('<ul id="menu" class="menu-2">');
				$("#menu-left").clone().children().appendTo($("#menu"));
				$("#menu-right").clone().children().appendTo($("#menu"));
			}
            if ($("#menu").length > 0) {
                if ($("#mobile-menu").length < 1) {
                    $("#menu").clone().attr({
                        id: "mobile-menu",
                        class: ""
                    }).insertAfter("#header");
					$("#mobile-menu > li > a").addClass("waves");
                    $("#mobile-menu li").each(function() {
                        if ($(this).hasClass('dropdown') || $(this).hasClass('megamenu')) {
                            $(this).append('<span class="arrow"></span>');
                        }
                    });
                    $("#mobile-menu .megamenu .arrow").on("click", function(e) {
                        e.preventDefault();
                        $(this).toggleClass("open").prev("div").slideToggle(300);
                    });
                    $("#mobile-menu .dropdown .arrow").on("click", function(e) {
                        e.preventDefault();
                        $(this).toggleClass("open").prev("ul").slideToggle(300);
                    });
                }
            }

        } else {
            $("#mobile-menu").hide();
			$(".menu-2").hide();
        }
    }
	// STICKY //
	function sticky() {
		var sticky_point = 155;
		$("#header").clone(true,true).attr({
			id: "header-sticky",
			class: ""
		}).insertAfter("header");
		$(window).on("scroll", function(){
			if ($(window).scrollTop() > sticky_point) {
				$("#header-sticky").slideDown(300).addClass("header-sticky");
				$("#header .menu ul, #header .menu .megamenu-container").css({"visibility": "hidden"});
                if ($(window).width() >= 992) {
                    $('.social-media').css({"position":"fixed"});
                }
            } else {
                $("#header-sticky").slideUp(100).removeClass("header-sticky");
                $("#header .menu ul, #header .menu .megamenu-container").css({"visibility": "visible"});
                if ($(window).width() >= 992) {
                    $('.social-media').css({"position":"absolute"});
                }
			}
		});
	}
	// PROGRESS BARS //
	function progress_bars() {
		$(".progress .progress-bar:in-viewport").each(function() {
			if (!$(this).hasClass("animated")) {
				$(this).addClass("animated");
				$(this).animate({
					width: $(this).attr("data-width") + "%"
				}, 2000);
			}
		});
	}
	// COMPARISON BARS //
	function comparison_bars() {
		$(".comparison-bars .progress .progress-bar:in-viewport").each(function() {
			if (!$(this).hasClass("animated")) {
				$(this).addClass("animated").animate({
					width: $(this).attr("data-width")/2 + "%"
				}, 2000);
			}
			if ($(this).attr("data-direction") == "left") {
				$(this).css({
					"right": 50 + "%",
					"text-align": "right"
				});
			} else {
				$(this).css({
					"left": 50 + "%",
					"text-align": "left"
				});
			}
		});
	}

	// SHOW/HIDE SCROLL UP //
	function show_hide_scroll_top() {
		if ($(window).scrollTop() > $(window).height()/2) {
			$("#scroll-up").fadeIn(300);
		} else {
			$("#scroll-up").fadeOut(300);
		}
	}
	// SCROLL UP //
	function scroll_up() {
		$("#scroll-up").on("click", function() {
			$("html, body").animate({
				scrollTop: 0
			}, 800, 'linear');
			return false;
		});
	}
	// DOCUMENT READY //
	$(document).ready(function(){
		// STICKY //
		if ($("body").hasClass("sticky-header")) {
			sticky();
		}
		// MENU //
		if (typeof $.fn.superfish !== 'undefined') {
			$(".menu").superfish({
				delay: 500,
				animation: {
					opacity: 'show',
					height: 'show'
				},
				speed: 'fast',
				autoArrows: true
			});
		}
		// MENU SLIDE //
		menu_slide();
		// SHOW/HIDE MOBILE MENU //
		show_hide_mobile_menu();
		// MOBILE MENU //
		mobile_menu();
		// FANCYBOX //
		if (typeof $.fn.fancybox !== 'undefined') {
			$(".fancybox").fancybox({
				prevEffect: 'none',
				nextEffect: 'none',
				padding: 0
			});

		}

		// PLACEHOLDER //
		if (typeof $.fn.placeholder !== 'undefined') {
			$("input, textarea").placeholder();
		}

		// SHOW/HIDE SCROLL UP
		show_hide_scroll_top();
		// SCROLL UP //
		scroll_up();
		// PROGRESS BARS //
		progress_bars();


	});
	// WINDOW SCROLL //
	$(window).on("scroll", function() {
		// comparison_bars();
		// progress_bars();
		// pie_chart();
		// counter();
		// odometer();
		show_hide_scroll_top();
		// statistics();
	});
	// WINDOW RESIZE //
	$(window).resize(function() {
		mobile_menu();
		// image_box();
		// equal_height();
		full_screen();
	});
})(window.jQuery);
