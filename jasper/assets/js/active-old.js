(function ($) {
	
	"use strict";
	
	jQuery(document).ready(function($){	

		$("ul#navigation").slicknav({
			prependTo: ".responsive-menu-wrap"
		});
	
		new WOW().init();
		//offset() measures how far down the sticky element is from the top of the window
			var stickyTop = $(".sticky").height();

			var stickNav = function() {
			  var windowTop = $(window).scrollTop();

			  //check to see if we have scrolled past the original location of the sticky element
			  if (windowTop > stickyTop) {

				//if so, change the sticky element to fised positioning
				$(".sticky").addClass("stuck");
			  } else {   
				$(".sticky").removeClass("stuck");
			  }
			};

			//whenever the user scrolls, measure how far we have scrolled
			$(window).on('scroll', stickNav);
			$(window).on('load', stickNav);
	});
		
	jQuery(window).load(function(){
		jQuery(".site-preloader").fadeOut();
		$("html, body").animate({ scrollTop: 0 }, "slow"); return false;	
	});
    
    /******************** 2.14 SCROLL TO UP ********************/
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 500) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});
		$('.scrollup').on("click", function() {
			$("html, body").animate({
				scrollTop: 0
			}, 800);
			return false;
		});
    
    
    
    $(".testimonial").owlCarousel({
            dots: true,
            nav: false,  
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i'],
            autoplay: false,
            autoplayTimeout: 5000,
            margin: 0,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 1,
                },
                768: {
                    items: 4,
                },
                990: {
                    items: 5,
                },
            },
        });	
	
    $(document).ready(function(){
			  $('.nav li a, .home-slider a, .single-service-item a').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
				&& location.hostname == this.hostname) {
				  var $target = $(this.hash);
				  $target = $target.length && $target
				  || $('[name=' + this.hash.slice(1) +']');
				  if ($target.length) {
					var targetOffset = $target.offset().top;
					$('html,body')
					.animate({scrollTop: targetOffset}, 1000);
				   return false;
				  }
				}
			  });
			});
        /******************** COUNTDOWN TIMER ********************/
		$('#launch-timer').countdown('2017/12/03', function(event) { // Changed date to your lunching date
		   $(this).html(event.strftime('<ul><li>day%!D<span>%-D</span> </li><li>hour%!H<span>%H</span> </li><li>minute%!M<span>%M</span> </li><li>second%!S<span>%S</span> </li></ul>'));
		});
    
}(jQuery));		