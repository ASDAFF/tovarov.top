// page init
jQuery(function() {
    clearFormFields({clearInputs: true, passwordFieldText: true, addClassFocus: "focus", filterClass: "default"});
    initBrowserDetect();
    initInterface();
    if ( jQuery('body').hasClass('screen-mobile')) {
        initResponsiveNav()
    }
    initResolution();
    if ( jQuery('.advent-toolbar').length ) {
        detectResize();
    }
});

function detectResize() {

    // solving resize problem on android
    var page_width = $(window).width(), page_height = $(window).height();

    var window_original = jQuery(window).width();
    $(window).resize(function () {
        if( $(window).width() != page_width || $(window).height() != page_height ) {
            waitForFinalEvent(function() {
              var window_resized = jQuery(window).width();
              if (window_original < 1250 && window_resized > 1250) {
                  location.reload();
              }
              if (window_resized < 1250) {
                  location.reload();
              }
            }, 500, "some unique string");
        }
    });
}

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

function initResolution() {
	jQuery('.resolution-buttons a').click( function(e) {
		e.preventDefault();
		if ( !jQuery(this).hasClass('active') ) {
			jQuery('.resolution-buttons a').removeClass('active');
			jQuery(this).addClass('active');
		}
		/* wide resolution */
		if ( jQuery('.resolution-buttons a.active').hasClass('btn-wide') ){
			jQuery('.resolution-buttons .btn-wide').addClass('active');
			$('.resolution-frame').animate({
				width: '100%'
			}, 700, function(){
			   $('.loader ').fadeIn(400, function(){
                   page_reload();
                   $('.loader ').fadeOut();
               });
			});
		}
		/* tablet resolution */
		if ( jQuery('.resolution-buttons a.active').hasClass('btn-tablet') ){
			jQuery('.resolution-buttons .btn-tablet').addClass('active');
			$('.resolution-frame').animate({
				width: '768px'
			}, 700, function(){
               $('.loader ').fadeIn(400, function(){
                   page_reload();
                   $('.loader ').fadeOut();
               });
            });
		}
		/* phone resolution */
		if ( jQuery('.resolution-buttons a.active').hasClass('btn-phone') ){
			jQuery('.resolution-buttons .btn-phone').addClass('active');
			$('.resolution-frame').animate({
				width: '340px'
			}, 700, function(){
               $('.loader ').fadeIn(400, function(){
                   page_reload();
                   $('.loader ').fadeOut();
               });
            });
		}
	});

	// custom color buttons
	jQuery('.colors .color-1').click( function(e) {
	    e.preventDefault();
	    less.modifyVars({
	    	'@btn-color'		: '@btn-color-1',
	    	'@btn-border'		: '@btn-border-1',
	    	'@btn-hover'		: '@btn-hover-1',
	    	'@btn-border-hover'	: '@btn-border-hover-1',
	    	'@transparent'		: '@transparent-1'
		});
	    less.refreshStyles();
	});
	jQuery('.colors .color-2').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-2',
	    	'@btn-border'		: '@btn-border-2',
	    	'@btn-hover'		: '@btn-hover-2',
	    	'@btn-border-hover'	: '@btn-border-hover-2',
	    	'@transparent'		: '@transparent-2'
		});
        less.refreshStyles();
    });
    jQuery('.colors .color-3').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-3',
	    	'@btn-border'		: '@btn-border-3',
	    	'@btn-hover'		: '@btn-hover-3',
	    	'@btn-border-hover'	: '@btn-border-hover-3',
	    	'@transparent'		: '@transparent-3'
		});
        less.refreshStyles();
    });
    jQuery('.colors .color-4').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-4',
	    	'@btn-border'		: '@btn-border-4',
	    	'@btn-hover'		: '@btn-hover-4',
	    	'@btn-border-hover'	: '@btn-border-hover-4',
	    	'@transparent'		: '@transparent-4'
		});
        less.refreshStyles();
    });
    jQuery('.colors .color-5').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-5',
	    	'@btn-border'		: '@btn-border-5',
	    	'@btn-hover'		: '@btn-hover-5',
	    	'@btn-border-hover'	: '@btn-border-hover-5',
	    	'@transparent'		: '@transparent-5'
		});
        less.refreshStyles();
    });
    jQuery('.colors .color-6').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-6',
	    	'@btn-border'		: '@btn-border-6',
	    	'@btn-hover'		: '@btn-hover-6',
	    	'@btn-border-hover'	: '@btn-border-hover-6',
	    	'@transparent'		: '@transparent-6'
		});
        less.refreshStyles();
    });
    jQuery('.colors .color-7').click( function(e) {
        e.preventDefault();
        less.modifyVars({
	    	'@btn-color'		: '@btn-color-7',
	    	'@btn-border'		: '@btn-border-7',
	    	'@btn-hover'		: '@btn-hover-7',
	    	'@btn-border-hover'	: '@btn-border-hover-7',
	    	'@transparent'		: '@transparent-7'
		});
        less.refreshStyles();
    });

	function page_reload () {
		jQuery('.resolution-frame').attr('src', $('.resolution-frame').attr('src'));
	}

	// close advent toolbar
	jQuery ('.advent-toolbar .btn-close').click (function (e) {
        e.preventDefault();
        jQuery('.advent-toolbar').slideUp();
        jQuery('.resolution-frame').css('padding-top', '0');
    });

    // - layout type select

    // wide
    jQuery ('.layout-type .btn-collapsed').click (function (e) {
        e.preventDefault();
        jQuery('.layout-type li a').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.resolution-frame ').contents().find('body').addClass('wide-page');
    });

    // boxed
    jQuery ('.layout-type .btn-boxed').click (function (e) {
        e.preventDefault();
        jQuery('.layout-type li a').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.resolution-frame ').contents().find('body').removeClass('wide-page');
    });

    // mobile top nav
    if ( jQuery('body').hasClass('screen-mobile')) {
        jQuery('<a href="#" class="top-toggle">'+js_about_city+'</a>').prependTo('.top-nav');
        jQuery('.top-nav .items li').removeClass('active');
        jQuery('.top-toggle').click( function (e) {
            e.preventDefault();
            jQuery('.top-nav .items').slideToggle();
            jQuery(this).toggleClass('active');
        });
    }
}

function initResponsiveNav() {
	// Append the mobile icon nav
	$('.nav-frame').append($('<div class="nav-mobile">'+js_menu_name+'</div>'));

	// Add a <span> to every .nav-item that has a <ul> inside
	$('#nav > li').has('ul').prepend('<span class="nav-click"><i class="nav-arrow"></i></span>');

	// Click to reveal the nav
	$('.nav-mobile').click(function(){
		$('#nav').toggle();
	});

	// Dynamic binding to on 'click'
	$('#nav > li > a').click( function (e) {
        if ( $(this).hasClass('hasDrop') ) {
            e.preventDefault();
            $(this).next('.drop').slideToggle();
        }
	});

	$('#nav .col-title').click(function(e){
        if ( $(this).hasClass('hasDrop') ) {
            e.preventDefault();
            $(this).next('.sub-menu').toggle();
        }
	});
}

function initInterface(){
    // custom scroll on body
    //$("html").niceScroll();

    // detect if mobile
    if( window.innerWidth < 641 ) {
        jQuery('body').addClass('screen-mobile');
    }
    else {
        jQuery('body').removeClass('screen-mobile');
    }
    // the same on resize
    $( window ).resize(function() {
        if( window.innerWidth < 641 ) {
            jQuery('body').addClass('screen-mobile');
            //jQuery('.nav-list').hide();
        }
        else {
            jQuery('body').removeClass('screen-mobile');
            //jQuery('.nav-list').show();
        }
        window_width = jQuery(window).width();
		window_height = jQuery(window).height();
    });

    // detect if 404 page
    if ( jQuery('.box-404').length ) {
        jQuery('body').addClass('page-404');
    }

    // mobile footer features
    if ( jQuery('body').hasClass('screen-mobile')) {
        jQuery('#footer .copy').insertAfter('#footer .container');
    }

    // contacts page features
    if ( jQuery('body').hasClass('screen-mobile')) {
        jQuery('.page-map').addClass('page-image').removeClass('page-map');
        //jQuery('.page-image img').attr('src', 'images/img-paints.jpg');
        jQuery('.page-image img').after('<div class="frame"></div>');
    }

    // catalog mobile filters
    if ( jQuery('body').hasClass('screen-mobile')) {
    	jQuery('.filter-expand h2').click( function(e) {
    		e.preventDefault();
    		jQuery(this).next('form').slideToggle();
    	});
    }

    // detect if hasDrop
    jQuery('li > .drop').prev('a').addClass('hasDrop');
    jQuery('.col > .sub-menu').prev('a').addClass('hasDrop');

    /*jQuery.each(wished, function(index,val) {
            $('.link-wishlist-delete.item'+val).show();
            $('.link-wishlist.item'+val).hide();
            $('.link-wish.det.item'+val).addClass('exists');
    });*/




    // footer boxes width detect
    $('.footer-blocks .block').each( function(e) {
        var this_width = $(this).width();
        $(this).find('.block-frame').width(this_width);
    });
    $( window ).resize(function() {
       $('.footer-blocks .block').each( function(e) {
          var this_width = $(this).width();
          $(this).find('.block-frame').width(this_width);
       });
    });



    // new menu aligner
    if ( !$('body').hasClass('screen-mobile') ) {
	    alignMenu();
	    $(window).resize(function() {
	            $("#nav").append($(".points-holder .nav").html());
	            $(".points-holder").remove();
	            alignMenu();
	    });
    }

    function alignMenu() {
        var li_sum = 0;
        $('#nav > li').each(function() {
                li_sum += $(this).outerWidth(true);
        });

        var w = 0;
        var mw = $('.nav-frame').width() - 250;
        var i = -1;
        var menuhtml = '';

        if ( $("#nav").width() < li_sum) {
            jQuery.each($("#nav").children(), function() {
                    i++;
                    w += $(this).outerWidth(true);
                    if (mw < w) {
                        menuhtml += $('<div>').append($(this).clone()).html();
                        $(this).remove();
                    }
            });
            $(".discount-link").before (
                '<div class="points-holder"><span class="points">&nbsp;</span><div class="add-menu">'
                + '<div class="nav-frame">'
                + '<ul class="nav">'
                + menuhtml
                + '</ul></div></div></div>'
            );
            $("#nav").width(mw);

            if ( !$('body').hasClass('screen-mobile') ) {
	            jQuery('.nav li').hover( function() {
	                    var drop_width = 0;
	                    jQuery(this).find('.drop').show();
	                    jQuery(this).find('.col').each(function(index) {
	                            drop_width = drop_width + jQuery(this).outerWidth(true);
	                    });
	                    if ( jQuery(this).find('.drop .drop-img').length > 0 ){
	                        jQuery(this).find('.drop').width(drop_width + 160);
	                    }
	                    else{
	                        jQuery(this).find('.drop').width(drop_width);
	                    }
	                }, function () {
	                    jQuery(this).find('.drop').hide();
	            });
            }
        }


        // detect add_menu position
        if ( jQuery('.points').length ) {
            var add_menu_pos = jQuery('.nav-frame').width() - jQuery('.points').position().left - ( jQuery('.add-menu').width() / 2 );
            jQuery('.add-menu').css('right', add_menu_pos);
        }
    }

    // drop width calculate
    if ( !$('body').hasClass('screen-mobile') ) {
	    jQuery('#nav li').hover( function() {
	            var drop_width = 0;
	            jQuery(this).find('.drop').show();
	            jQuery(this).find('.col').each(function(index) {
                    if(index<5)
                        drop_width = drop_width + jQuery(this).outerWidth(true);
	            });
	            if ( jQuery(this).find('.drop .drop-img').length > 0 ) {
	                jQuery(this).find('.drop').width(drop_width + 160);
	            }
	            else{
	                jQuery(this).find('.drop').width(drop_width);
	            }
	        }, function () {
	            jQuery(this).find('.drop').hide();
	    });
    }

    // top nav aligner
    if ( !$('body').hasClass('screen-mobile') ) {
	    alignMenu_2();
	    $(window).resize(function() {
	            $(".top-nav .items").append($(".more-link .sub").html());
	            $(".more-link").remove();
	            alignMenu_2();
	    });
    }

    function alignMenu_2() {
        var li_sum = 0;
        $('.top-nav .items > li').each(function() {
                li_sum += $(this).outerWidth(true);
        });

        var w = 0;
        var mw = $(".top-nav").width() - 54;
        var i = -1;
        var menuhtml = '';

        if ( $(".top-nav").width() < li_sum) {
            jQuery.each($(".top-nav .items").children(), function() {
                    i++;
                    w += $(this).outerWidth(true);
                    if (mw < w) {
                        menuhtml += $('<div>').append($(this).clone()).html();
                        $(this).remove();
                    }
            });
            $(".top-nav .items").after (
                '<div class="more-link">'
                + '<a class="link" href="#">'+more+'</a>'
                + '<ul class="sub">'
                + menuhtml
                + '</ul></div>'
            );
            $(".top-nav .items").width(mw);
        }
    }

    // cart page items height calculate
    var basket_max = -1;
    jQuery(".item-form-holder").each(function() {
            var h = $(this).height();
            basket_max = h > basket_max ? h : basket_max;
    });
    jQuery(".item-form-holder").height(basket_max);

    // placeholder toggle
    jQuery(":not(.default)[placeholder]").togglePlaceholder();

    // visual products carousel
    jQuery('.visual-new #carousel').infiniteCarousel({
            autoHideCaptions: false,
            autoPilot: true,
    });

    // share box
    jQuery('.share-ico').click(function(e) {
            e.preventDefault();
            jQuery(this).next('.share-box').fadeToggle();
    });
    jQuery('.share-box .btn-close').click(function(e) {
            e.preventDefault();
            jQuery(this).closest('.share-box').fadeOut();
    });

    // sticky header
    jQuery('.nav-holder').scrollToFixed();

    // catalog view switch -
    // deleted, because it's physical change tempalte to show (SEO better, no dublicates of product at this page)
    /*if ( jQuery('.views .icons').hasClass('active') ) {
    jQuery('.items-cells').css('display', 'block');
    jQuery('.products-items-list, .products-items-listview').css('display', 'none');
    }
    if ( jQuery('.views .icons-pic-list').hasClass('active') ) {
    jQuery('.products-items-list').css('display', 'block');
    jQuery('.items-cells, .products-items-listview').css('display', 'none');

    }
    if ( jQuery('.views .icons-list').hasClass('active') ) {
    jQuery('.items-cells, .products-items-list').css('display', 'none');
    jQuery('.products-items-listview').css('display', 'block');
    }
    jQuery('.views a').click(function(e) {
    e.preventDefault();
    jQuery('.views a').removeClass('active');
    jQuery(this).addClass('active');
    if ( jQuery('.views .icons').hasClass('active') ) {
    jQuery('.items-cells').css('display', 'block');
    jQuery('.products-items-list, .products-items-listview').css('display', 'none');
    }

    if ( jQuery('.views .icons-pic-list').hasClass('active') ) {
    jQuery('.products-items-list').css('display', 'block');
    jQuery('.items-cells, .products-items-listview').css('display', 'none');
    }

    if ( jQuery('.views .icons-list').hasClass('active') ) {



    jQuery('.products-items-listview').css('display', 'block');
    jQuery('.items-cells, .products-items-list').css('display', 'none');
    }
    });*/
    /*jQuery('.views .icons').click(function(e) {
    e.preventDefault();
    jQuery('.views a').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.items-cells').css('display', 'block');
    jQuery('.products-items-list').css('display', 'none');
    });
    if ( jQuery('.views .icons-list').hasClass('active') ) {
    jQuery('.items-cells').css('display', 'none');
    jQuery('.products-items-list').css('display', 'block');
    }
    jQuery('.views .icons-list').click(function(e) {
    e.preventDefault();
    jQuery('.views a').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.items-cells').css('display', 'none');
    jQuery('.products-items-list').css('display', 'block');
    });*/

    if ( !$('body').hasClass('screen-mobile') ) {
        $('#visual').show();
        $("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 700,
            autoPlay : 5000,
            paginationSpeed : 400,
            singleItem : true,
            afterInit: function () {
                $("#owl-demo").addClass('finished');
                $("#visual .slides .container").animate({
                        opacity: 1
                    }, 1200);
            }
        });
    } else {
        jQuery('#visual').remove();
    }


    // brand names tabs carousel
    if ( !$('body').hasClass('screen-mobile') ) {
	    jQuery('.brands-carousel').scrollGallery({
	            btnPrev:'a.btn-prev',
	            btnNext:'a.btn-next',
	            sliderHolder: '.mask',
	            slider:'>ul',
	            slides: '>li',
	            step:6
	    });
        var brand_items = jQuery('.brands-carousel .items > li').length;
        if ( brand_items < 7) {jQuery('.brands-carousel').addClass('arrows-disabled');}
    } else {
    	jQuery('.brands-carousel').scrollGallery({
	            btnPrev:'a.btn-prev',
	            btnNext:'a.btn-next',
	            sliderHolder: '.mask',
	            slider:'>ul',
	            slides: '>li',
	            step:2
	    });

    }



    // brands products carousel
    if ( !$('body').hasClass('screen-mobile') ) {
    	jQuery('.items-include').scrollGallery({
            btnPrev:'a.btn-prev',
            btnNext:'a.btn-next',
            sliderHolder: '.mask',
            slider:'div.tab-items',
            slides: 'div.product-item',
            step:6
	    });
	    jQuery('.similars .items-include').scrollGallery({
            btnPrev:'a.btn-prev',
            btnNext:'a.btn-next',
            sliderHolder: '.mask',
            slider:'div.tab-items',
            slides: 'div.product-item',
            step:4
	    });
    }
    else  {
    	jQuery('.items-include').scrollGallery({
            btnPrev:'a.btn-prev',
            btnNext:'a.btn-next',
            sliderHolder: '.mask',
            slider:'div.tab-items',
            slides: 'div.product-item',
            step:1
	    });
	    jQuery('.similars .items-include').scrollGallery({
            btnPrev:'a.btn-prev',
            btnNext:'a.btn-next',
            sliderHolder: '.mask',
            slider:'div.tab-items',
            slides: 'div.product-item',
            step:1
	    });
    }

    // // brand names tabs carousel
    // jQuery('.product-popup .images-block').scrollGallery({
    //         btnPrev:'a.link-prev',
    //         btnNext:'a.link-next',
    //         sliderHolder: '.mask',
    //         pagerLinks:'.slides li a',
    //         slider:'>ul',
    //         slides: '>li',
    //         step:1
    // });

    // Testimonials gallery
    jQuery('.testemonials-block').fadeGallery({
            slideElements:'.item',
            pagerLinks:'.navigate ul li',
            pagerGener: true,
            switchTime: 5000,
            pauseOnHover:false
    });

    // news details gallery
    jQuery('.news-images').fadeGallery({
            slideElements:'.item',
            pagerLinks:'.navigate ul li',
            pagerGener: true,
            switchTime: 5000,
            duration:300,
            pauseOnHover:false
    });
    // side testimonials carousel
    jQuery('.quotes-list').scrollGallery({
            sliderHolder: '.mask',
            slider:'>ul',
            slides: '>li',
            step:1,
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
            pagerLinks:'div.pagess a'
    });

    // side advice carousel
    jQuery('.advice-box').scrollGallery({
            sliderHolder: '.mask',
            slider:'>ul',
            slides: '>li',
            step:1,
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
    });

    // Testimonials gallery
    jQuery('#footer .fade-items').fadeGallery({
            slideElements:'.item',
            switchTime: 8000,
            pauseOnHover:false,
            autoRotation:true,
            duration: 1200,
    });

    // videos carousel
    setTimeout(function(){
            //#issues 12 fix, heavy images bug, 31 Jan 2014
            // videos frame & expand box width

            var box_sum = 0;

            $(".videos-section .videos-list li").each(function() {
                box_sum += jQuery(this).width();
            });

            $(".videos-section .videos-list .expand").each(function() {
                    // getting parent link width/height
                    var box_width = jQuery(this).parent().parent().width();
                    var box_height = jQuery(this).parent().parent().height();

                    // fitting to expander proportions
                    var expand_width = box_width - 24;
                    var expand_height = box_height - 24;
                    jQuery(this).width(expand_width);
                    jQuery(this).height(expand_height);
                    jQuery(this).children().width(expand_width);
                    jQuery(this).children().height(expand_height);
            });
            $(".videos-section .videos-list .frame").each(function() {
                    // getting parent link width/height
                    var box_width = jQuery(this).parent().width();
                    var box_height = jQuery(this).parent().height();

                    // fitting to expander proportions
                    var frame_width = box_width - 24;
                    var frame_height = box_height - 24;
                    jQuery(this).width(frame_width);
                    jQuery(this).height(frame_height);
            });
            $( '.videos-section .mask' ).lemmonSlider();
            if ( jQuery('.videos-section .videos-list').width() < box_sum + 1 ) {
                jQuery('.videos-section .videos-list').width(box_sum + 1);
            }
        }, 1000);

    // index brand tabs
    var tabContainers = jQuery('.brands-catalog .items-carousel .container > div');
    tabContainers.hide().filter(':first').show();
    jQuery('.brands-carousel .items li a').click(function () {
            tabContainers.hide();
            tabContainers.filter(this.hash).show(); // РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…
            jQuery('.brands-carousel .items li').removeClass('active'); // РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… 'selected'
            jQuery(this).parent().addClass('active');
            return false;
    }).filter(':first').click();

    // index menu tabs
    var tabContainers2 = jQuery('.menu-tabs-section .index-tabs > div');
    tabContainers2.hide().filter(':first').show();
    jQuery('.menu-tabs .menu li a').click(function () {
            tabContainers2.hide();
            tabContainers2.filter(this.hash).show(); // РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…
            jQuery('.menu-tabs .menu li').removeClass('active'); // РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… 'selected'
            jQuery(this).parent().addClass('active');
            return false;
    }).filter(':first').click();

    // account tabs -
    /*var tabContainers3 = jQuery('.account-holder .account-frames > .tab');
    tabContainers3.hide().filter(':first').show();
    jQuery('.account-tabs li a').click(function () {
    tabContainers3.hide();
    tabContainers3.filter(this.hash).show(); // РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…
    jQuery('.account-tabs li a').removeClass('active'); // РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… 'selected'
    jQuery(this).addClass('active');
    return false;
    }).filter(':first').click();*/

    // product details tabs
    var tabContainers4 = jQuery('.list-holder > div');
    tabContainers4.hide().filter(':first').show();
    jQuery('.product-tabs-list li a').click(function () {
            tabContainers4.hide();
            tabContainers4.filter(this.hash).show(); // РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…
            jQuery('.product-tabs-list li a').removeClass('active'); // РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… 'selected'
            jQuery(this).addClass('active');
            return false;
    }).filter(':first').click();
    // index product filtering
    $('.products-block').mixItUp();
	$('.products-block').on('mixEnd', function(e, state){
		//alert(state);
		var $i_count = 0;
		$(".products-block .product-item").each(function () {
			if ($(this).is(":visible")){
				$i_count++;
				if($i_count > 8){
					$(this).attr('style', '');
				}
			}
		});
	});
    // custom forms
    $('.account-form input, .account-form select').styler();
    $('#sidebar input, #sidebar select').styler();
    $('.checks input, .item-form select').styler();
    $('.view-form input, .view-form select').styler();
    $('.product-popup .selects select, .add-popup .selects select').styler();
    $('.order-container input, .order-container select').styler();
    jQuery('.selectbox .select s').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().toggleClass('parent-focus');
    });


    // parent class for checkbox
    $('.jq-checkbox').click(function() {
            if ( $(this).hasClass('checked') ){
                $(this).parent().addClass('active');
            }
            else{
                $(this).parent().removeClass('active');
            }
    });

    // custom scroll
    jQuery(".brands-list").mCustomScrollbar({
            scrollInertia:300,
            autoDraggerLength:false,
            mouseWheel:false
    });

    // timer
    $(".timer-box .timer strong").countdown({
            date: "october 11, 2014", //Counting TO a date
            htmlTemplate: "%{h} : %{m} : %{s}",
            onChange: function( event, timer ){
            },
            onComplete: function( event ){

                $(this).html("<strong class='complete'>COMPLETED</strong>");
            },
            leadingZero: true,
            direction: "down"
    });

    // aside-timer
    $(".aside-timer .clock").countdown({
            date: "november 11, 2014", //Counting TO a date
            htmlTemplate: "<div class='digit'><strong>%{h}</strong><span>"+hours1+"</span></div><div class='digit'><strong>%{m}</strong><span>"+minutes+"</span></div><div class='digit'><strong>%{s}</strong><span>"+seconds+"</span></div>",
            onChange: function( event, timer ){
            },
            onComplete: function( event ){

                $(this).html("<strong class='complete'>COMPLETED</strong>");
            },
            leadingZero: true,
            direction: "down"
    });

    $('.popup-open').click(function(e){
            e.preventDefault();

            $id = $(this).attr('href');
            $('.btn-close').click();
            jQuery($id).bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });



    // product slider  link saver
    var activeLink;;
    var clickLink;
    var memory = $('.images-block .slides:first-child img');

    $('.images-block .slides:first-child img').addClass('item_active');

    $('.images-block .slides img').click(function(e) {
        e.preventDefault();
        $(memory).parent().removeClass('item_active');
        memory = this;
        $(memory).parent().addClass('item_active');
        clickLink = $(this).attr('src');
        $('#fullscreen img').attr('src', clickLink);
        $('.images-block .mask img').attr('src', clickLink);
    });

    // $('.images-block .slides img').mouseenter(function() {
    //         mouseEnterLink = $(this).attr('src');
    //         $('.images-block .mask img').fadeOut(200, function() {
    //         $(this).attr('src', mouseEnterLink);
    //         $(this).fadeIn(200);
    //     });
    // });


    // $('.images-block .slides img').mouseenter(function() {
    //         mouseEnterLink = $(this).attr('src');
    //         $('.images-block .mask img').attr('src', mouseEnterLink);
    //         $('#fullscreen img').attr('src', mouseEnterLink);
    // });

    // $('.images-block .slides img').mouseleave(function() {
    //         $('.images-block .mask img').fadeOut(50, function() {
    //         $(this).attr('src', mouseEnterLink);
    //         $(this).fadeIn(50);
    //     });
    // });



    if($('.slides ul li').length > 4){
        //alert($('.slides ul li').length );
        jQuery('.product-popup .link-prev').fadeIn('slow');
        jQuery('.product-popup .link-next').fadeIn('slow');
        jQuery('.product-popup .images-block').scrollGallery({
        btnPrev:'a.link-prev',
        btnNext:'a.link-next',
        sliderHolder: '.slides',
        pagerLinks:'.slides li a',
        slider:'>ul',
        slides: '>li',
        step:1
    });
    }

    // $('a.link-next, a.link-prev').click( function() {
    //     activeLink = $('a.active img').attr('src');
    //     $('.images-block .mask img').attr('src', activeLink);
    // });


    // callback popup
  /* jQuery(document).on('click', '.top-info .callback, .contact-boxes .callback, .order.callback, .btn-click.callback-popup-link', function(e) {
             e.preventDefault();
            $('.callback-tovar').val($(this).attr('data-prod'));
            jQuery('.popup.call-popup').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });*/


    var videoSrc;
    jQuery('.video-link').click(function(e){
            var id = jQuery(this).attr('data-id');
            var src = jQuery('.video-cont'+id+' iframe').attr("src");
            if(src.length > 0) {
                videoSrc = src;
            }
            console.log(videoSrc);
            e.preventDefault();
            jQuery('.video-cont'+id).bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff',
                    onOpen: function() {
                        jQuery('.video-cont'+id+' iframe').attr("src", videoSrc);
                    },
                    onClose: function() {
                        jQuery('.video-cont'+id+' iframe').attr("src",'');
                    }
            });

    });



    jQuery('.video-link-fancybox').fancybox({
      helpers: {
        overlay: {
          locked: false
        }
      }
    });


   jQuery(".video-link-fancybox").fancybox({
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        width       : '70%',
        height      : '70%',
        autoSize    : false,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
    });

    // product popup
    jQuery('.link-details').click(function(e) {
            e.preventDefault();
            jQuery('.popup.product-popup').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });

    // job popup
    jQuery('.job-items .item .link a').click(function(e) {
            e.preventDefault();
            $('.ajax-tmp').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff',
                    follow: [true, false],
                    loadUrl: $(this).attr('href')
            });
    });
    //subscribe
    function submit_subscribe(form,email){
        var bOk = false;
        if(jQuery().val(email) != '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(pattern.test(jQuery(email).val())){
                bOk = true;
            } else {
                bOk = false;
                jQuery('.popup#subscribe-unsuccess').bPopup({
                        closeClass: 'btn-close',
                        modalColor: '#fff'
                });
            }
        } else {     bOk = false;
            jQuery('.popup#subscribe-unsuccess').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
        }
        if(bOk){
            jQuery.ajax({
                    url: jQuery(form).attr('action'),
                    data: jQuery(form).serialize(),
                    type:'POST',
                    success:function(data){
                        jQuery('.popup#subscribe-success').bPopup({
                                closeClass: 'btn-close',
                                modalColor: '#fff'
                        });
                        // console.log(data);
                        //alert('add');
                    },
            });
        }
    }

    jQuery('form[name=subscribe_f]').on('submit',function(){
            submit_subscribe(this,'.footer-search input[name=EMAIL]');
            return false;
    });

    jQuery('form[name=subsc_action]').on('submit',function(){
            submit_subscribe(this,'.widget input[name=EMAIL]');
            return false;
    })

    // product popup
    jQuery('.add-popup .buttons .btn-cart').click(function(e) {
            e.preventDefault();
            jQuery('.popup.add-popup').bPopup().close();
            jQuery('.fly-message.wishlist').fadeOut(700);
            jQuery('.fly-message.cart').fadeIn(700).delay(3000).fadeOut(700);
    });

    //clear visited
    $(document).on('click', '.clear_visited', function(e){
            e.preventDefault();
            $.ajax({
                    type: 'POST',
                    url: $(this).attr('href'),

                    dataType: "html",
                    success: function(html)
                    {
                        $('div.tab.wishlist').replaceWith('<div class="tab wishlist"><p>'+nowish+'</p></div>')
                        $.post(sd+'ajax/wishlist.php', "", function(html){
                                $('div.links').replaceWith(html);
                        });
                        console.log('clear');
                    }
            })

    })

    // product wishlist add

    $(document).on('click', '.link-wishlist,.link-wishlist-delete,.wishlist_delete.item-delete,.link-wish.det', function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            var id = $(this).attr('data-id');
            var action = $(this).attr('data-action');
            var elem = $(this);

            $.ajax({
                    type: 'POST',
                    url: href,
                    data: {
                        action:action,
                        id: id,
                    },
                    dataType: "html",
                    success: function(html)
                    {
                        if($(elem).hasClass('wishlist_delete')){
                            reloadWishlistHTML();
                        }

                        if($(elem).hasClass('link-wishlist')){
                            $(elem).hide();
                            $('.link-wishlist-delete.item'+id).show();
                        }else if($(elem).hasClass('link-wishlist-delete')){
                            $(elem).hide();
                            $('.link-wishlist.item'+id).show();
                        } else if($(elem).hasClass('link-wish')) {
                            if($(elem).hasClass('exists')){$(elem).removeClass('exists');}
                            else{$(elem).addClass('exists');}
                        }
                        $('.links').html(html);

                    }
            })

            return false;
    });


    $(document).on('click', '.all-wish-delete', function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            $.ajax({
                    type: 'POST',
                    url: href,
                    dataType: "html",
                    success: function(html)
                    {
                        reloadWishlistHTML();
                        $('.links').html(html);
                    }
            })

            return false;
    });



    /*  jQuery('.link-wishlist').click(function(e) {
    e.preventDefault();
    jQuery('.fly-message.cart').fadeOut(700);
    jQuery('.fly-message.wishlist').fadeIn(700).delay(3000).fadeOut(700);
    });    */

    /*// product popup adding
    jQuery('.product-popup .btn-click').click(function(e) {
            e.preventDefault();
            jQuery('.popup.product-popup').bPopup().close();
            jQuery('.success-popup').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });
    // cart callback popup
    jQuery('.cart-container .buttons .btn-click').click(function(e) {
            e.preventDefault();
            jQuery('.callback-popup').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });

    // cart rest popup
    jQuery('.cart-container .buttons .btn-cart').click(function(e) {
            e.preventDefault();
            jQuery('.rest-popup').bPopup({
                    closeClass: 'btn-close',
                    modalColor: '#fff'
            });
    });*/
    // faq section
    jQuery('.faq-section .link-show').click(function(e) {
            e.preventDefault();
            if( jQuery(this).parent().hasClass('opened') ){
                jQuery(this).parent().removeClass('opened');
                jQuery(this).next().slideUp(250);
            }
            else{
                jQuery(this).parent().addClass('opened');
                jQuery(this).next().slideDown(350);
            }
    });

    // contact section
    jQuery('.contact-info .link-show').click(function(e) {
        e.preventDefault();
        if( jQuery(this).parent().hasClass('opened') ){
            jQuery(this).parent().removeClass('opened');
            jQuery(this).next().slideUp(250);
        }
        else{
            jQuery(this).parent().addClass('opened');
            jQuery(this).next().slideDown(350);
        }
    });

    // orders history section
    jQuery('.history-table .btn-expand').click(function(e) {
            e.preventDefault();
            if( jQuery(this).parent().parent().hasClass('opened') ){
                jQuery(this).parent().parent().removeClass('opened');
                jQuery(this).parent().parent().next().slideUp(250);
            }
            else{
                jQuery(this).parent().parent().addClass('opened');
                jQuery(this).parent().parent().next().slideDown(350);
            }
    });
    // reviews section
    jQuery('.rew-cols .links .item a').click(function() {
            jQuery('.rew-cols .links .item a').removeClass('active');
            jQuery(this).addClass('active');
    });
    jQuery('.content-gal').scrollGallery({
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
            sliderHolder: '.mask',
            slider:'>ul',
            slides: '>li',
            step:1
    });

    // details tab gallery
    jQuery('.desc-gallery').scrollGallery({
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
            sliderHolder: '.mask',
            slider:'>ul',
            slides: '>li',
            step:1
    });
    // index brand tabs
    var tabContainers22 = jQuery('.rew-cols .contents-holder > .content-box');
    tabContainers22.hide().filter(':first').show();
    jQuery('.rew-cols .links .item a').click(function () {
            tabContainers22.fadeOut('fast');
            tabContainers22.filter(this.hash).fadeIn(); // РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…
            jQuery('.rew-cols .links .item a').removeClass('active'); // РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… РїС—Р…РїС—Р…РїС—Р…РїС—Р…РїС—Р… 'selected'
            jQuery(this).addClass('active');
            return false;
    }).filter(':first').click();

    // paymethods click class
    jQuery('.pay-method .item').click(function(e) {
            e.preventDefault();
            jQuery('.pay-method .item').removeClass('active');
            jQuery(this).addClass('active');
    });

    // shipmethods click class
    jQuery('.delivery-method .item').click(function(e) {
            e.preventDefault();
            jQuery('.delivery-method .item').removeClass('active');
            jQuery(this).addClass('active');
    });

    // right sticky toolbox
    jQuery('.toolbox .btn-close').click(function(e) {
            e.preventDefault();
            jQuery('.toolbox .links').fadeOut();
            jQuery('.toolbox .btn-plus').fadeIn();
    });
    // right sticky toolbox
    jQuery('.toolbox .btn-plus').click(function(e) {
            e.preventDefault();
            jQuery('.toolbox .links').fadeIn();
            jQuery('.toolbox .btn-plus').fadeOut();
    });

    // scroll to top
    toTop();

    // job items hover
    jQuery('.job-items .item').hover(function() {
            jQuery(this).toggleClass('red');
    });
    // input file button (job offers)
    jQuery('body').on('click','.fileinputs .file',function() {
      jQuery('.fileinputs .file').change(function() {
        var filename = jQuery(this).val();
        if ( filename != "") {
            jQuery('.fileinputs .button').addClass('loaded').html( "<span>"+resadded+"</span>" );
        }
      });
  });
}



function toTop(){
    var pxShow = 700; //height on which the button will show
    var scrollSpeed = 400; //how slow/fast you want the button to scroll to top. can be a value, 'slow', 'normal' or 'fast'

    jQuery(window).scroll(function(){
            if(jQuery(window).scrollTop() >= pxShow){
                jQuery(".toolbox .link-up").fadeIn();
            } else{
                jQuery(".toolbox .link-up").fadeOut();
            }
    });

    jQuery('.toolbox .link-up').click(function(){
            jQuery('html, body').animate({scrollTop:0}, scrollSpeed);
            return false;
    });
}


// browser detect
function initBrowserDetect() {
    var u = navigator.userAgent.toLowerCase();
    var _html = document.getElementsByTagName("html")[0];

    if(is("win")) addClass("win");
    else if(is("mac")) addClass("mac");
    else if(is("linux") || is("x11")) addClass("linux");

    if(is("msie 10.0")) addClass("ie10");
    else if(is("msie 9.0")) addClass("ie9");
    else if(is("msie 8.0")) addClass("ie8");
    else if(is("msie 7.0")) addClass("ie7");
    else if(is("msie 6.0")) addClass("ie6");
    else if(is("firefox/2")) addClass("ff2");
    else if(is("firefox/3")) addClass("ff3");
    else if(is("opera") && is("version/10")) addClass("opera10");
    else if(is("opera/9")) addClass("opera9");
    else if(is("safari") && is("version/3")) addClass("safari3");
    else if(is("safari") && is("version/4")) addClass("safari4");
    else if(is("safari") && is("version/5")) addClass("safari5");
    else if(is("chrome")) addClass("chrome");
    else if(is("safari")) addClass("safari2");
    else if(is("unknown")) addClass("unknown");

    if(is("msie")) addClass("trident");
    else if(is("applewebkit")) addClass("webkit");
    else if(is("gecko")) addClass("gecko");
    else if(is("opera")) addClass("presto");

    function is(browser)
    {
        if(u.indexOf(browser) !=-1) return true;
    }
    function addClass(_class)
    {
        _html.className += (" " + _class);
    }
}

// scrolling gallery plugin
jQuery.fn.scrollGallery = function(_options){
    var _options = jQuery.extend({
            sliderHolder: '>div',
            slider:'>ul',
            slides: '>li',
            pagerLinks:'div.pager a',
            btnPrev:'a.link-prev',
            btnNext:'a.link-next',
            activeClass:'active',
            disabledClass:'disabled',
            generatePagination:'div.pg-holder',
            curNum:'em.scur-num',
            allNum:'em.sall-num',
            circleSlide:true,
            pauseClass:'gallery-paused',
            pauseButton:'none',
            pauseOnHover:true,
            autoRotation:false,
            stopAfterClick:false,
            switchTime:5000,
            duration:650,
            easing:'swing',
            event:'click',
            splitCount:false,
            afterInit:false,
            vertical:false,
            step:false
        },_options);
    return this.each(function(){
            // gallery options
            var _this = jQuery(this);
            var _sliderHolder = jQuery(_options.sliderHolder, _this);
            var _slider = jQuery(_options.slider, _sliderHolder);
            var _slides = jQuery(_options.slides, _slider);
            var _btnPrev = jQuery(_options.btnPrev, _this);
            var _btnNext = jQuery(_options.btnNext, _this);
            var _pagerLinks = jQuery(_options.pagerLinks, _this);
            var _generatePagination = jQuery(_options.generatePagination, _this);
            var _curNum = jQuery(_options.curNum, _this);
            var _allNum = jQuery(_options.allNum, _this);
            var _pauseButton = jQuery(_options.pauseButton, _this);
            var _pauseOnHover = _options.pauseOnHover;
            var _pauseClass = _options.pauseClass;
            var _autoRotation = _options.autoRotation;
            var _activeClass = _options.activeClass;
            var _disabledClass = _options.disabledClass;
            var _easing = _options.easing;
            var _duration = _options.duration;
            var _switchTime = _options.switchTime;
            var _controlEvent = _options.event;
            var _step = _options.step;
            var _vertical = _options.vertical;
            var _circleSlide = _options.circleSlide;
            var _stopAfterClick = _options.stopAfterClick;
            var _afterInit = _options.afterInit;
            var _splitCount = _options.splitCount;
            // gallery init
            if(!_slides.length) return;
            if(_splitCount) {
                var curStep = 0;
                var newSlide = jQuery('<slide>').addClass('split-slide');
                _slides.each(function(){
                        newSlide.append(this);
                        curStep++;
                        if(curStep > _splitCount-1) {
                            curStep = 0;
                            _slider.append(newSlide);
                            newSlide = jQuery('<slide>').addClass('split-slide');
                        }
                });
                if(curStep) _slider.append(newSlide);
                _slides = _slider.children();
            }
            var _currentStep = 0;
            var _sumWidth = 0;
            var _sumHeight = 0;
            var _hover = false;
            var _stepWidth;
            var _stepHeight;
            var _stepCount;
            var _offset;
            var _timer;
            _slides.each(function(){
                    _sumWidth+=jQuery(this).outerWidth(true);
                    _sumHeight+=jQuery(this).outerHeight(true);
            });
            // calculate gallery offset
            function recalcOffsets() {
                if(_vertical) {
                    if(_step) {
                        _stepHeight = _slides.eq(_currentStep).outerHeight(true);
                        _stepCount = Math.ceil((_sumHeight-_sliderHolder.height())/_stepHeight)+1;
                        _offset = -_stepHeight*_currentStep;
                    } else {
                        _stepHeight = _sliderHolder.height();
                        _stepCount = Math.ceil(_sumHeight/_stepHeight);
                        _offset = -_stepHeight*_currentStep;
                        if(_offset < _stepHeight-_sumHeight) _offset = _stepHeight-_sumHeight;
                    }
                } else {
                    if(_step) {
                        _stepWidth = _slides.eq(_currentStep).outerWidth(true)*_step;
                        _stepCount = Math.ceil((_sumWidth-_sliderHolder.width())/_stepWidth)+1;
                        _offset = -_stepWidth*_currentStep;
                        if(_offset < _sliderHolder.width()-_sumWidth) _offset = _sliderHolder.width()-_sumWidth;
                    } else {
                        _stepWidth = _sliderHolder.width();
                        _stepCount = Math.ceil(_sumWidth/_stepWidth);
                        _offset = -_stepWidth*_currentStep;
                        if(_offset < _stepWidth-_sumWidth) _offset = _stepWidth-_sumWidth;
                    }
                }
            }
            // gallery control
            if(_btnPrev.length) {
                _btnPrev.bind(_controlEvent,function(){
                        if(_stopAfterClick) stopAutoSlide();
                        prevSlide();
                        return false;
                });
            }
            if(_btnNext.length) {
                _btnNext.bind(_controlEvent,function(){
                        if(_stopAfterClick) stopAutoSlide();
                        nextSlide();
                        return false;
                });
            }
            if(_generatePagination.length) {
                _generatePagination.empty();
                recalcOffsets();
                var _list = jQuery('<ul />');
                for(var i=0; i<_stepCount; i++) jQuery('<li><a href="#">'+(i+1)+'</a></li>').appendTo(_list);
                _list.appendTo(_generatePagination);
                _pagerLinks = _list.children();
            }
            if(_pagerLinks.length) {
                _pagerLinks.each(function(_ind){
                        jQuery(this).bind(_controlEvent,function(){
                                if(_currentStep != _ind) {
                                    if(_stopAfterClick) stopAutoSlide();
                                    _currentStep = _ind;
                                    switchSlide();
                                }
                                return false;
                        });
                });
            }
            // gallery animation
            function prevSlide() {
                recalcOffsets();
                if(_currentStep > 0) _currentStep--;
                else if(_circleSlide) _currentStep = _stepCount-1;
                switchSlide();
            }
            function nextSlide() {
                recalcOffsets();
                if(_currentStep < _stepCount-1) _currentStep++;
                else if(_circleSlide) _currentStep = 0;
                switchSlide();
            }
            function refreshStatus() {
                if(_pagerLinks.length) _pagerLinks.removeClass(_activeClass).eq(_currentStep).addClass(_activeClass);
                if(!_circleSlide) {
                    _btnPrev.removeClass(_disabledClass);
                    _btnNext.removeClass(_disabledClass);
                    if(_currentStep == 0) _btnPrev.addClass(_disabledClass);
                    if(_currentStep == _stepCount-1) _btnNext.addClass(_disabledClass);
                }
                if(_curNum.length) _curNum.text(_currentStep+1);
                if(_allNum.length) _allNum.text(_stepCount);
            }
            function switchSlide() {
                recalcOffsets();
                if(_vertical) _slider.animate({marginTop:_offset},{duration:_duration,queue:false,easing:_easing});
                else _slider.animate({marginLeft:_offset},{duration:_duration,queue:false,easing:_easing});
                refreshStatus();
                autoSlide();
            }
            // autoslide function
            function stopAutoSlide() {
                if(_timer) clearTimeout(_timer);
                _autoRotation = false;
            }
            function autoSlide() {
                if(!_autoRotation || _hover) return;
                if(_timer) clearTimeout(_timer);
                _timer = setTimeout(nextSlide,_switchTime+_duration);
            }
            if(_pauseOnHover) {
                _this.hover(function(){
                        _hover = true;
                        if(_timer) clearTimeout(_timer);
                    },function(){
                        _hover = false;
                        autoSlide();
                });
            }
            recalcOffsets();
            refreshStatus();
            autoSlide();
            // pause buttton
            if(_pauseButton.length) {
                _pauseButton.click(function(){
                        if(_this.hasClass(_pauseClass)) {
                            _this.removeClass(_pauseClass);
                            _autoRotation = true;
                            autoSlide();
                        } else {
                            _this.addClass(_pauseClass);
                            stopAutoSlide();
                        }
                        return false;
                });
            }
            if(_afterInit && typeof _afterInit === 'function') _afterInit(_this, _slides);
    });
}

// slideshow plugin
jQuery.fn.fadeGallery = function(_options){
    var _options = jQuery.extend({
            slideElements:'div.slides > div.slide',
            pagerGener: true,
            pagerHold: false,
            pagerLinks:'ul.nav-list li',
            btnNext:'a.btn-next',
            btnPrev:'a.btn-prev',
            btnPlayPause:'a.play-pause',
            btnPlay:'a.play',
            btnPause:'a.pause',
            pausedClass:'paused',
            disabledClass: 'disabled',
            playClass:'playing',
            activeClass:'active',
            currentNum:false,
            allNum:false,
            startSlide:null,
            noCircle:false,
            caption:'ul.caption > li',
            pauseOnHover:true,
            autoRotation:false,
            autoHeight:true,
            onChange:false,
            switchTime:3000,
            duration:650,
            event:'click'
        },_options);

    return this.each(function(){
            // gallery options
            var _this = jQuery(this);
            var _slides = jQuery(_options.slideElements, _this);
            var _btnPrev = jQuery(_options.btnPrev, _this);
            var _btnNext = jQuery(_options.btnNext, _this);
            var _btnPlayPause = jQuery(_options.btnPlayPause, _this);
            var _btnPause = jQuery(_options.btnPause, _this);
            var _btnPlay = jQuery(_options.btnPlay, _this);
            var _pauseOnHover = _options.pauseOnHover;
            var _autoRotation = _options.autoRotation;
            var _activeClass = _options.activeClass;
            var _disabledClass = _options.disabledClass;
            var _pausedClass = _options.pausedClass;
            var _playClass = _options.playClass;
            var _autoHeight = _options.autoHeight;
            var _duration = _options.duration;
            var _switchTime = _options.switchTime;
            var _controlEvent = _options.event;
            var _currentNum = (_options.currentNum ? jQuery(_options.currentNum, _this) : false);
            var _allNum = (_options.allNum ? jQuery(_options.allNum, _this) : false);
            var _startSlide = _options.startSlide;
            var _noCycle = _options.noCircle;
            var _onChange = _options.onChange;
            var _pagerGener = _options.pagerGener;
            var _pagerHold = jQuery(_options.pagerHold,_this);
            var _caption = jQuery(_options.caption,_this);
            var _paging = '';
            if(_pagerGener){
                for(var i=0; i< _slides.length; i++){
                    _paging += '<li><a href="#">'+(i+1)+'</a></li>';
                }
                _pagerHold.html('<ul>'+_paging+'</ul>');
            }
            var _pagerLinks = jQuery(_options.pagerLinks, _this);
            // gallery init
            var _hover = false;
            var _prevIndex = 0;
            var _currentIndex = 0;
            var _slideCount = _slides.length;
            var _timer;
            if(_slideCount < 2) return;

            _prevIndex = _slides.index(_slides.filter('.'+_activeClass));
            if(_prevIndex < 0) _prevIndex = _currentIndex = 0;
            else _currentIndex = _prevIndex;
            if(_startSlide != null) {
                if(_startSlide == 'random') _prevIndex = _currentIndex = Math.floor(Math.random()*_slideCount);
                else _prevIndex = _currentIndex = parseInt(_startSlide);
            }
            _slides.hide().eq(_currentIndex).show();
            _caption.hide().eq(_currentIndex).show();
            if(_autoRotation) _this.removeClass(_pausedClass).addClass(_playClass);
            else _this.removeClass(_playClass).addClass(_pausedClass);

            // gallery control
            if(_btnPrev.length) {
                _btnPrev.bind(_controlEvent,function(){
                        prevSlide();
                        return false;
                });
            }
            if(_btnNext.length) {
                _btnNext.bind(_controlEvent,function(){
                        nextSlide();
                        return false;
                });
            }
            if(_pagerLinks.length) {
                _pagerLinks.each(function(_ind){
                        jQuery(this).bind(_controlEvent,function(){
                                if(_currentIndex != _ind) {
                                    _prevIndex = _currentIndex;
                                    _currentIndex = _ind;
                                    switchSlide();
                                }
                                return false;
                        });
                });
            }

            // play pause section
            if(_btnPlayPause.length) {
                _btnPlayPause.bind(_controlEvent,function(){
                        if(_this.hasClass(_pausedClass)) {
                            _this.removeClass(_pausedClass).addClass(_playClass);
                            _autoRotation = true;
                            autoSlide();
                        } else {
                            _autoRotation = false;
                            if(_timer) clearTimeout(_timer);
                            _this.removeClass(_playClass).addClass(_pausedClass);
                        }
                        return false;
                });
            }
            if(_btnPlay.length) {
                _btnPlay.bind(_controlEvent,function(){
                        _this.removeClass(_pausedClass).addClass(_playClass);
                        _autoRotation = true;
                        autoSlide();
                        return false;
                });
            }
            if(_btnPause.length) {
                _btnPause.bind(_controlEvent,function(){
                        _autoRotation = false;
                        if(_timer) clearTimeout(_timer);
                        _this.removeClass(_playClass).addClass(_pausedClass);
                        return false;
                });
            }
            // gallery animation
            function prevSlide() {
                _prevIndex = _currentIndex;
                if(_currentIndex > 0) _currentIndex--;
                else {
                    if(_noCycle) return;
                    else _currentIndex = _slideCount-1;
                }
                switchSlide();
            }
            function nextSlide() {
                _prevIndex = _currentIndex;
                if(_currentIndex < _slideCount-1) _currentIndex++;
                else {
                    if(_noCycle) return;
                    else _currentIndex = 0;
                }
                switchSlide();
            }
            function refreshStatus() {
                if(_pagerLinks.length) _pagerLinks.removeClass(_activeClass).eq(_currentIndex).addClass(_activeClass);
                if(_currentNum) _currentNum.text(_currentIndex+1);
                if(_allNum) _allNum.text(_slideCount);
                _slides.eq(_prevIndex).removeClass(_activeClass);
                _slides.eq(_currentIndex).addClass(_activeClass);
                if(_noCycle) {
                    if(_btnPrev.length) {
                        if(_currentIndex == 0) _btnPrev.addClass(_disabledClass);
                        else _btnPrev.removeClass(_disabledClass);
                    }
                    if(_btnNext.length) {
                        if(_currentIndex == _slideCount-1) _btnNext.addClass(_disabledClass);
                        else _btnNext.removeClass(_disabledClass);
                    }
                }
                if(typeof _onChange === 'function') {
                    _onChange(_this, _currentIndex);
                }
            }
            function switchSlide() {
                _slides.eq(_prevIndex).fadeOut(_duration, function(){
                        _slides.eq(_currentIndex).fadeIn(_duration);
                });
                _caption.eq(_prevIndex).fadeOut();
                _caption.eq(_currentIndex).fadeIn();
                if(_autoHeight) _slides.eq(_currentIndex).parent().animate({height:_slides.eq(_currentIndex).outerHeight(true)},{duration:_duration,queue:false});
                refreshStatus();
                autoSlide();
            }

            // autoslide function
            function autoSlide() {
                if(!_autoRotation || _hover) return;
                if(_timer) clearTimeout(_timer);
                _timer = setTimeout(nextSlide,_switchTime+_duration);
            }
            if(_pauseOnHover) {
                _this.hover(function(){
                        _hover = true;
                        if(_timer) clearTimeout(_timer);
                    },function(){
                        _hover = false;
                        autoSlide();
                });
            }
            refreshStatus();
            autoSlide();
    });
};

/*
* jQuery Cycle Carousel plugin
*/
;(function(jQuery){
        function ScrollAbsoluteGallery(options) {
            this.options = jQuery.extend({
                    activeClass: 'active',
                    mask: 'div.slides-mask',
                    slider: '>ul',
                    slides: '>li',
                    btnPrev: '.btn-prev',
                    btnNext: '.btn-next',
                    pagerLinks: 'ul.pager > li',
                    generatePagination: false,
                    pagerList: '<ul>',
                    pagerListItem: '<li><a href="#"></a></li>',
                    pagerListItemText: 'a',
                    galleryReadyClass: 'gallery-js-ready',
                    currentNumber: 'span.current-num',
                    totalNumber: 'span.total-num',
                    maskAutoSize: false,
                    autoRotation: false,
                    pauseOnHover: false,
                    stretchSlideToMask: false,
                    switchTime: 3000,
                    animSpeed: 500,
                    handleTouch: true,
                    swipeThreshold: 50
                }, options);
            this.init();
        }
        ScrollAbsoluteGallery.prototype = {
            init: function() {
                if(this.options.holder) {
                    this.findElements();
                    this.attachEvents();
                }
            },
            findElements: function() {
                // find structure elements
                this.holder = jQuery(this.options.holder).addClass(this.options.galleryReadyClass);
                this.mask = this.holder.find(this.options.mask);
                this.slider = this.mask.find(this.options.slider);
                this.slides = this.slider.find(this.options.slides);
                this.btnPrev = this.holder.find(this.options.btnPrev);
                this.btnNext = this.holder.find(this.options.btnNext);

                // slide count display
                this.currentNumber = this.holder.find(this.options.currentNumber);
                this.totalNumber = this.holder.find(this.options.totalNumber);

                // create gallery pagination
                if(typeof this.options.generatePagination === 'string') {
                    this.pagerLinks = this.buildPagination();
                } else {
                    this.pagerLinks = this.holder.find(this.options.pagerLinks);
                }

                // define index variables
                this.slideWidth = this.slides.width();
                this.currentIndex = 0;
                this.prevIndex = 0;

                // reposition elements
                this.slider.css({
                        position: 'relative',
                        height: this.slider.height()
                });
                this.slides.css({
                        position: 'absolute',
                        left: -9999,
                        top: 0
                }).eq(this.currentIndex).css({
                        left: 0
                });
                this.refreshState();
            },
            buildPagination: function() {
                var pagerLinks = jQuery();
                if(!this.pagerHolder) {
                    this.pagerHolder = this.holder.find(this.options.generatePagination);
                }
                if(this.pagerHolder.length) {
                    this.pagerHolder.empty();
                    this.pagerList = jQuery(this.options.pagerList).appendTo(this.pagerHolder);
                    for(var i = 0; i < this.slides.length; i++) {
                        jQuery(this.options.pagerListItem).appendTo(this.pagerList).find(this.options.pagerListItemText).text(i+1);
                    }
                    pagerLinks = this.pagerList.children();
                }
                return pagerLinks;
            },
            attachEvents: function() {
                // attach handlers
                var self = this;
                this.btnPrev.click(function(e){
                        if(self.slides.length > 1) {
                            self.prevSlide();
                        }
                        e.preventDefault();
                });
                this.btnNext.click(function(e){
                        if(self.slides.length > 1) {
                            self.nextSlide();
                        }
                        e.preventDefault();
                });
                this.pagerLinks.each(function(index){
                        jQuery(this).click(function(e){
                                if(self.slides.length > 1) {
                                    self.numSlide(index);
                                }
                                e.preventDefault();
                        });
                });

                // handle autorotation pause on hover
                if(this.options.pauseOnHover) {
                    this.holder.hover(function(){
                            clearTimeout(self.timer);
                        }, function(){
                            self.autoRotate();
                    });
                }

                // handle holder and slides dimensions
                jQuery(window).bind('load resize orientationchange', function(){
                        if(!self.animating) {
                            if(self.options.stretchSlideToMask) {
                                self.resizeSlides();
                            }
                            self.resizeHolder();
                            self.setSlidesPosition(self.currentIndex);
                        }
                });
                if(self.options.stretchSlideToMask) {
                    self.resizeSlides();
                }

                // handle swipe on mobile devices
                if(this.options.handleTouch && jQuery.fn.swipe && this.slides.length > 1) {
                    this.mask.swipe({
                            excludedElements: '',
                            fallbackToMouseEvents: false,
                            threshold: this.options.swipeThreshold,
                            allowPageScroll: 'vertical',
                            swipeStatus: function(e, phase, direction, offset) {
                                // avoid swipe while gallery animating
                                if(self.animating) {
                                    return false;
                                }

                                // move gallery
                                if(direction === 'left' || direction === 'right') {
                                    self.swipeOffset = -self.slideWidth + (direction === 'left' ? -1 : 1) * offset;
                                    self.slider.css({marginLeft: self.swipeOffset});
                                }
                                clearTimeout(self.timer);
                                switch(phase) {
                                    case 'cancel':
                                        self.slider.animate({marginLeft: -self.slideWidth}, {duration: self.options.animSpeed});
                                        break;
                                    case 'end':
                                    if(direction === 'left') {
                                        self.nextSlide();
                                    } else {
                                        self.prevSlide();
                                    }
                                    self.swipeOffset = 0;
                                    break;
                                }
                            }
                    });
                }

                // start autorotation
                this.autoRotate();
                this.resizeHolder();
                this.setSlidesPosition(this.currentIndex);
            },
            resizeSlides: function() {
                this.slideWidth = this.mask.width();
                this.slides.css({
                        width: this.slideWidth
                });
            },
            resizeHolder: function() {
                if(this.options.maskAutoSize) {
                    this.slider.css({
                            height: this.slides.eq(this.currentIndex).outerHeight(true)
                    });
                }
            },
            prevSlide: function() {
                if(!this.animating) {
                    this.direction = -1;
                    this.prevIndex = this.currentIndex;
                    if(this.currentIndex > 0) this.currentIndex--;
                    else this.currentIndex = this.slides.length - 1;
                    this.switchSlide();
                }
            },
            nextSlide: function(fromAutoRotation) {
                if(!this.animating) {
                    this.direction = 1;
                    this.prevIndex = this.currentIndex;
                    if(this.currentIndex < this.slides.length - 1) this.currentIndex++;
                    else this.currentIndex = 0;
                    this.switchSlide();
                }
            },
            numSlide: function(c) {
                if(!this.animating && this.currentIndex !== c) {
                    this.direction = c > this.currentIndex ? 1 : -1;
                    this.prevIndex = this.currentIndex;
                    this.currentIndex = c;
                    this.switchSlide();
                }
            },
            preparePosition: function() {
                // prepare slides position before animation
                this.setSlidesPosition(this.prevIndex, this.direction < 0 ? this.currentIndex : null, this.direction > 0 ? this.currentIndex : null, this.direction);
            },
            setSlidesPosition: function(index, slideLeft, slideRight, direction) {
                // reposition holder and nearest slides
                if(this.slides.length > 1) {
                    var prevIndex = (typeof slideLeft === 'number' ? slideLeft : index > 0 ? index - 1 : this.slides.length - 1);
                    var nextIndex = (typeof slideRight === 'number' ? slideRight : index < this.slides.length - 1 ? index + 1 : 0);

                    this.slider.css({marginLeft: this.swipeOffset ? this.swipeOffset : -this.slideWidth});
                    this.slides.css({left:-9999}).eq(index).css({left: this.slideWidth});

                    if(prevIndex === nextIndex && typeof direction === 'number') {
                        this.slides.eq(nextIndex).css({left: direction > 0 ? this.slideWidth*2 : 0 });
                    } else {
                        this.slides.eq(prevIndex).css({left: 0});
                        this.slides.eq(nextIndex).css({left: this.slideWidth * 2});
                    }
                }
            },
            switchSlide: function() {
                // prepare positions and calculate offset
                var self = this;
                var oldSlide = this.slides.eq(this.prevIndex);
                var newSlide = this.slides.eq(this.currentIndex);

                // start animation
                var animProps = {marginLeft: this.direction > 0 ? -this.slideWidth*2 : 0 };
                if(this.options.maskAutoSize) {
                    // resize holder if needed
                    animProps.height = newSlide.outerHeight(true);
                }
                this.animating = true;
                this.preparePosition();
                this.slider.animate(animProps,{duration:this.options.animSpeed, complete:function() {
                            self.setSlidesPosition(self.currentIndex);

                            // start autorotation
                            self.animating = false;
                            self.autoRotate();
                }});

                // refresh classes
                this.refreshState();
            },
            refreshState: function(initial) {
                // slide change function
                this.slides.removeClass(this.options.activeClass).eq(this.currentIndex).addClass(this.options.activeClass);
                this.pagerLinks.removeClass(this.options.activeClass).eq(this.currentIndex).addClass(this.options.activeClass);

                // display current slide number
                this.currentNumber.html(this.currentIndex + 1);
                this.totalNumber.html(this.slides.length);
            },
            autoRotate: function() {
                var self = this;
                clearTimeout(this.timer);
                if(this.options.autoRotation && self.slides.length > 1) {
                    this.timer = setTimeout(function() {
                            self.nextSlide();
                        }, this.options.switchTime);
                }
            }
        };

        // jquery plugin
        jQuery.fn.scrollAbsoluteGallery = function(opt){
            return this.each(function(){
                    jQuery(this).data('ScrollAbsoluteGallery', new ScrollAbsoluteGallery(jQuery.extend(opt,{holder:this})));
            });
        };
    }(jQuery));

// Clear Forms
function clearFormFields(o)
{
    if (o.clearInputs == null) o.clearInputs = true;
    if (o.clearTextareas == null) o.clearTextareas = true;
    if (o.passwordFieldText == null) o.passwordFieldText = false;
    if (o.addClassFocus == null) o.addClassFocus = false;
    if (!o.filterClass) o.filterClass = "default";
    if(o.clearInputs) {
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++ ) {
            if((inputs[i].type == "text" || inputs[i].type == "password") && inputs[i].className.indexOf(o.filterClass) == -1) {
                inputs[i].valueHtml = inputs[i].value;
                inputs[i].onfocus = function ()    {
                    if(this.valueHtml == this.value) this.value = "";
                    if(this.fake) {
                        inputsSwap(this, this.previousSibling);
                        this.previousSibling.focus();
                    }
                    if(o.addClassFocus && !this.fake) {
                        this.className += " " + o.addClassFocus;
                        this.parentNode.className += " parent-" + o.addClassFocus;
                    }
                }
                inputs[i].onblur = function () {
                    if(this.value == "") {
                        this.value = this.valueHtml;
                        if(o.passwordFieldText && this.type == "password") inputsSwap(this, this.nextSibling);
                    }
                    if(o.addClassFocus) {
                        this.className = this.className.replace(o.addClassFocus, "");
                        this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
                    }
                }
                if(o.passwordFieldText && inputs[i].type == "password") {
                    var fakeInput = document.createElement("input");
                    fakeInput.type = "text";
                    fakeInput.value = inputs[i].value;
                    fakeInput.className = inputs[i].className;
                    fakeInput.fake = true;
                    inputs[i].parentNode.insertBefore(fakeInput, inputs[i].nextSibling);
                    inputsSwap(inputs[i], null);
                }
            }
        }
    }
    if(o.clearTextareas) {
        var textareas = document.getElementsByTagName("textarea");
        for(var i=0; i<textareas.length; i++) {
            if(textareas[i].className.indexOf(o.filterClass) == -1) {
                textareas[i].valueHtml = textareas[i].value;
                textareas[i].onfocus = function() {
                    if(this.value == this.valueHtml) this.value = "";
                    if(o.addClassFocus) {
                        this.className += " " + o.addClassFocus;
                        this.parentNode.className += " parent-" + o.addClassFocus;
                    }
                }
                textareas[i].onblur = function() {
                    if(this.value == "") this.value = this.valueHtml;
                    if(o.addClassFocus) {
                        this.className = this.className.replace(o.addClassFocus, "");
                        this.parentNode.className = this.parentNode.className.replace("parent-"+o.addClassFocus, "");
                    }
                }
            }
        }
    }
    function inputsSwap(el, el2) {
        if(el) el.style.display = "none";
        if(el2) el2.style.display = "inline";
    }
}

function initAutoScalingNav(o) {
    if (!o.menuId) o.menuId = "nav";
    if (!o.tag) o.tag = "a";
    if (!o.spacing) o.spacing = 0;
    if (!o.constant) o.constant = 0;
    if (!o.minPaddings) o.minPaddings = 0;
    if (!o.liHovering) o.liHovering = false;
    if (!o.sideClasses) o.sideClasses = false;
    if (!o.equalLinks) o.equalLinks = false;
    if (!o.flexible) o.flexible = false;
    var nav = document.getElementById(o.menuId);
    if(nav) {
        nav.className += " scaling-active";
        var lis = nav.getElementsByTagName("li");
        var asFl = [];
        var lisFl = [];
        var width = 0;
        for (var i=0, j=0; i<lis.length; i++) {
            if(lis[i].parentNode == nav) {
                var t = lis[i].getElementsByTagName(o.tag).item(0);
                asFl.push(t);
                asFl[j++].width = t.offsetWidth;
                lisFl.push(lis[i]);
                if(width < t.offsetWidth) width = t.offsetWidth;
            }
            if(o.liHovering) {
                lis[i].onmouseover = function() {
                    this.className += " hover";
                }
                lis[i].onmouseout = function() {
                    this.className = this.className.replace("hover", "");
                }
            }
        }
        var menuWidth = nav.clientWidth - asFl.length*o.spacing - o.constant;
        if(o.equalLinks && width * asFl.length < menuWidth) {
            for (var i=0; i<asFl.length; i++) {
                asFl[i].width = width;
            }
        }
        width = getItemsWidth(asFl);
        if(width < menuWidth) {
            var version = navigator.userAgent.toLowerCase();
            for (var i=0; getItemsWidth(asFl) < menuWidth; i++) {
                asFl[i].width++;
                if(!o.flexible) {
                    asFl[i].style.width = asFl[i].width + "px";
                }
                if(i >= asFl.length-1) i=-1;
            }
            if(o.flexible) {
                for (var i=0; i<asFl.length; i++) {
                    width = (asFl[i].width - o.spacing - o.constant/asFl.length)/menuWidth*100;
                    if(i != asFl.length-1) {
                        lisFl[i].style.width = width + "%";
                    }
                    else {
                        if(navigator.appName.indexOf("Microsoft Internet Explorer") == -1 || version.indexOf("msie 8") != -1 || version.indexOf("msie 9") != -1)
                            lisFl[i].style.width = width + "%";
                    }
                }
            }
        }
        else if(o.minPaddings > 0) {
            for (var i=0; i<asFl.length; i++) {
                asFl[i].style.paddingLeft = o.minPaddings + "px";
                asFl[i].style.paddingRight = o.minPaddings + "px";
            }
        }
        if(o.sideClasses) {
            lisFl[0].className += " first-child";
            lisFl[0].getElementsByTagName(o.tag).item(0).className += " first-child-a";
            lisFl[lisFl.length-1].className += " last-child";
            lisFl[lisFl.length-1].getElementsByTagName(o.tag).item(0).className += " last-child-a";
        }
        nav.className += " scaling-ready";
    }
    function getItemsWidth(a) {
        var w = 0;
        for(var q=0; q<a.length; q++) {
            w += a[q].width;
        }
        return w;
    }
}

// placeholder focus
$.fn.togglePlaceholder = function() {
    return this.each(function() {
            $(this)
            .data("holder", $(this).attr("placeholder"))
            .focusin(function(){
                    $(this).attr('placeholder','');
            })
            .focusout(function(){
                    $(this).attr('placeholder',$(this).data('holder'));
            });
    });
};

// scroll to fixed
(function(a){a.isScrollToFixed=function(b){return !!a(b).data("ScrollToFixed")};a.ScrollToFixed=function(d,h){var k=this;k.$el=a(d);k.el=d;k.$el.data("ScrollToFixed",k);var c=false;var F=k.$el;var G;var D;var p;var C=0;var q=0;var i=-1;var e=-1;var t=null;var y;var f;function u(){F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");e=-1;C=F.offset().top;q=F.offset().left;if(k.options.offsets){q+=(F.offset().left-F.position().left)}if(i==-1){i=q}G=F.css("position");c=true;if(k.options.bottom!=-1){F.trigger("preFixed.ScrollToFixed");w();F.trigger("fixed.ScrollToFixed")}}function m(){var H=k.options.limit;if(!H){return 0}if(typeof(H)==="function"){return H.apply(F)}return H}function o(){return G==="fixed"}function x(){return G==="absolute"}function g(){return !(o()||x())}function w(){if(!o()){t.css({display:F.css("display"),width:F.outerWidth(true),height:F.outerHeight(true),"float":F.css("float")});cssOptions={position:"fixed",top:k.options.bottom==-1?s():"",bottom:k.options.bottom==-1?"":k.options.bottom,"margin-left":"0px"};if(!k.options.dontSetWidth){cssOptions.width=F.width()}F.css(cssOptions);F.addClass("scroll-to-fixed-fixed");if(k.options.className){F.addClass(k.options.className)}G="fixed"}}function b(){var I=m();var H=q;if(k.options.removeOffsets){H=0;I=I-C}cssOptions={position:"absolute",top:I,left:H,"margin-left":"0px",bottom:""};if(!k.options.dontSetWidth){cssOptions.width=F.width()}F.css(cssOptions);G="absolute"}function j(){if(!g()){e=-1;t.css("display","none");F.css({width:"",position:D,left:"",top:p.top,"margin-left":""});F.removeClass("scroll-to-fixed-fixed");if(k.options.className){F.removeClass(k.options.className)}G=null}}function v(H){if(H!=e){F.css("left",q-H);e=H}}function s(){var H=k.options.marginTop;if(!H){return 0}if(typeof(H)==="function"){return H.apply(F)}return H}function z(){if(!a.isScrollToFixed(F)){return}var J=c;if(!c){u()}var H=a(window).scrollLeft();var K=a(window).scrollTop();var I=m();if(k.options.minWidth&&a(window).width()<k.options.minWidth){if(!g()||!J){n();F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed")}}else{if(k.options.bottom==-1){if(I>0&&K>=I-s()){if(!x()||!J){n();F.trigger("preAbsolute.ScrollToFixed");b();F.trigger("unfixed.ScrollToFixed")}}else{if(K>=C-s()){if(!o()||!J){n();F.trigger("preFixed.ScrollToFixed");w();e=-1;F.trigger("fixed.ScrollToFixed")}v(H)}else{if(!g()||!J){n();F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed")}}}}else{if(I>0){if(K+a(window).height()-F.outerHeight(true)>=I-(s()||-l())){if(o()){n();F.trigger("preUnfixed.ScrollToFixed");if(D==="absolute"){b()}else{j()}F.trigger("unfixed.ScrollToFixed")}}else{if(!o()){n();F.trigger("preFixed.ScrollToFixed");w()}v(H);F.trigger("fixed.ScrollToFixed")}}else{v(H)}}}}function l(){if(!k.options.bottom){return 0}return k.options.bottom}function n(){var H=F.css("position");if(H=="absolute"){F.trigger("postAbsolute.ScrollToFixed")}else{if(H=="fixed"){F.trigger("postFixed.ScrollToFixed")}else{F.trigger("postUnfixed.ScrollToFixed")}}}var B=function(H){if(F.is(":visible")){c=false;z()}};var E=function(H){z()};var A=function(){var I=document.body;if(document.createElement&&I&&I.appendChild&&I.removeChild){var K=document.createElement("div");if(!K.getBoundingClientRect){return null}K.innerHTML="x";K.style.cssText="position:fixed;top:100px;";I.appendChild(K);var L=I.style.height,M=I.scrollTop;I.style.height="3000px";I.scrollTop=500;var H=K.getBoundingClientRect().top;I.style.height=L;var J=(H===100);I.removeChild(K);I.scrollTop=M;return J}return null};var r=function(H){H=H||window.event;if(H.preventDefault){H.preventDefault()}H.returnValue=false};k.init=function(){k.options=a.extend({},a.ScrollToFixed.defaultOptions,h);k.$el.css("z-index",k.options.zIndex);t=a("<div />");G=F.css("position");D=F.css("position");p=a.extend({},F.offset());if(g()){k.$el.after(t)}a(window).bind("resize.ScrollToFixed",B);a(window).bind("scroll.ScrollToFixed",E);if(k.options.preFixed){F.bind("preFixed.ScrollToFixed",k.options.preFixed)}if(k.options.postFixed){F.bind("postFixed.ScrollToFixed",k.options.postFixed)}if(k.options.preUnfixed){F.bind("preUnfixed.ScrollToFixed",k.options.preUnfixed)}if(k.options.postUnfixed){F.bind("postUnfixed.ScrollToFixed",k.options.postUnfixed)}if(k.options.preAbsolute){F.bind("preAbsolute.ScrollToFixed",k.options.preAbsolute)}if(k.options.postAbsolute){F.bind("postAbsolute.ScrollToFixed",k.options.postAbsolute)}if(k.options.fixed){F.bind("fixed.ScrollToFixed",k.options.fixed)}if(k.options.unfixed){F.bind("unfixed.ScrollToFixed",k.options.unfixed)}if(k.options.spacerClass){t.addClass(k.options.spacerClass)}F.bind("resize.ScrollToFixed",function(){t.height(F.height())});F.bind("scroll.ScrollToFixed",function(){F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");z()});F.bind("detach.ScrollToFixed",function(H){r(H);F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");a(window).unbind("resize.ScrollToFixed",B);a(window).unbind("scroll.ScrollToFixed",E);F.unbind(".ScrollToFixed");k.$el.removeData("ScrollToFixed")});B()};k.init()};a.ScrollToFixed.defaultOptions={marginTop:0,limit:0,bottom:-1,zIndex:1000};a.fn.scrollToFixed=function(b){return this.each(function(){(new a.ScrollToFixed(this,b))})}})(jQuery);

/*================================================================================
* @name: bPopup - if you can't get it up, use bPopup
* @author: (c)Bjoern Klinggaard (twitter@bklinggaard)
* @demo: http://dinbror.dk/bpopup
* @version: 0.9.4.min
================================================================================*/
 (function(b){b.fn.bPopup=function(z,F){function K(){a.contentContainer=b(a.contentContainer||c);switch(a.content){case "iframe":var h=b('<iframe class="b-iframe" '+a.iframeAttr+"></iframe>");h.appendTo(a.contentContainer);r=c.outerHeight(!0);s=c.outerWidth(!0);A();h.attr("src",a.loadUrl);k(a.loadCallback);break;case "image":A();b("<img />").load(function(){k(a.loadCallback);G(b(this))}).attr("src",a.loadUrl).hide().appendTo(a.contentContainer);break;default:A(),b('<div class="b-ajax-wrapper"></div>').load(a.loadUrl,a.loadData,function(){k(a.loadCallback);G(b(this))}).hide().appendTo(a.contentContainer)}}function A(){a.modal&&b('<div class="b-modal '+e+'"></div>').css({backgroundColor:a.modalColor,position:"fixed",top:0,right:0,bottom:0,left:0,opacity:0,zIndex:a.zIndex+t}).appendTo(a.appendTo).fadeTo(a.speed,a.opacity);D();c.data("bPopup",a).data("id",e).css({left:"slideIn"==a.transition||"slideBack"==a.transition?"slideBack"==a.transition?g.scrollLeft()+u:-1*(v+s):l(!(!a.follow[0]&&m||f)),position:a.positionStyle||"absolute",top:"slideDown"==a.transition||"slideUp"==a.transition?"slideUp"==a.transition?g.scrollTop()+w:x+-1*r:n(!(!a.follow[1]&&p||f)),"z-index":a.zIndex+t+1}).each(function(){a.appending&&b(this).appendTo(a.appendTo)});H(!0)}function q(){a.modal&&b(".b-modal."+c.data("id")).fadeTo(a.speed,0,function(){b(this).remove()});a.scrollBar||b("html").css("overflow","auto");b(".b-modal."+e).unbind("click");g.unbind("keydown."+e);d.unbind("."+e).data("bPopup",0<d.data("bPopup")-1?d.data("bPopup")-1:null);c.undelegate(".bClose, ."+a.closeClass,"click."+e,q).data("bPopup",null);H();return!1}function G(h){var b=h.width(),e=h.height(),d={};a.contentContainer.css({height:e,width:b});e>=c.height()&&(d.height=c.height());b>=c.width()&&(d.width=c.width());r=c.outerHeight(!0);s=c.outerWidth(!0);D();a.contentContainer.css({height:"auto",width:"auto"});d.left=l(!(!a.follow[0]&&m||f));d.top=n(!(!a.follow[1]&&p||f));c.animate(d,250,function(){h.show();B=E()})}function L(){d.data("bPopup",t);c.delegate(".bClose, ."+a.closeClass,"click."+e,q);a.modalClose&&b(".b-modal."+e).css("cursor","pointer").bind("click",q);M||!a.follow[0]&&!a.follow[1]||d.bind("scroll."+e,function(){B&&c.dequeue().animate({left:a.follow[0]?l(!f):"auto",top:a.follow[1]?n(!f):"auto"},a.followSpeed,a.followEasing)}).bind("resize."+e,function(){w=y.innerHeight||d.height();u=y.innerWidth||d.width();if(B=E())clearTimeout(I),I=setTimeout(function(){D();c.dequeue().each(function(){f?b(this).css({left:v,top:x}):b(this).animate({left:a.follow[0]?l(!0):"auto",top:a.follow[1]?n(!0):"auto"},a.followSpeed,a.followEasing)})},50)});a.escClose&&g.bind("keydown."+e,function(a){27==a.which&&q()})}function H(b){function d(e){c.css({display:"block",opacity:1}).animate(e,a.speed,a.easing,function(){J(b)})}switch(b?a.transition:a.transitionClose||a.transition){case "slideIn":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()-(s||c.outerWidth(!0))-C});break;case "slideBack":d({left:b?l(!(!a.follow[0]&&m||f)):g.scrollLeft()+u+C});break;case "slideDown":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()-(r||c.outerHeight(!0))-C});break;case "slideUp":d({top:b?n(!(!a.follow[1]&&p||f)):g.scrollTop()+w+C});break;default:c.stop().fadeTo(a.speed,b?1:0,function(){J(b)})}}function J(b){b?(L(),k(F),a.autoClose&&setTimeout(q,a.autoClose)):(c.hide(),k(a.onClose),a.loadUrl&&(a.contentContainer.empty(),c.css({height:"auto",width:"auto"})))}function l(a){return a?v+g.scrollLeft():v}function n(a){return a?x+g.scrollTop():x}function k(a){b.isFunction(a)&&a.call(c)}function D(){x=p?a.position[1]:Math.max(0,(w-c.outerHeight(!0))/2-a.amsl);v=m?a.position[0]:(u-c.outerWidth(!0))/2;B=E()}function E(){return w>c.outerHeight(!0)&&u>c.outerWidth(!0)}b.isFunction(z)&&(F=z,z=null);var a=b.extend({},b.fn.bPopup.defaults,z);a.scrollBar||b("html").css("overflow","hidden");var c=this,g=b(document),y=window,d=b(y),w=y.innerHeight||d.height(),u=y.innerWidth||d.width(),M=/OS 6(_\d)+/i.test(navigator.userAgent),C=200,t=0,e,B,p,m,f,x,v,r,s,I;c.close=function(){a=this.data("bPopup");e="__b-popup"+d.data("bPopup")+"__";q()};return c.each(function(){b(this).data("bPopup")||(k(a.onOpen),t=(d.data("bPopup")||0)+1,e="__b-popup"+t+"__",p="auto"!==a.position[1],m="auto"!==a.position[0],f="fixed"===a.positionStyle,r=c.outerHeight(!0),s=c.outerWidth(!0),a.loadUrl?K():A())})};b.fn.bPopup.defaults={amsl:50,appending:!0,appendTo:"body",autoClose:!1,closeClass:"b-close",content:"ajax",contentContainer:!1,easing:"swing",escClose:!0,follow:[!0,!0],followEasing:"swing",followSpeed:500,iframeAttr:'scrolling="no" frameborder="0"',loadCallback:!1,loadData:!1,loadUrl:!1,modal:!0,modalClose:!0,modalColor:"#000",onClose:!1,onOpen:!1,opacity:0.7,position:["auto","auto"],positionStyle:"absolute",scrollBar:!0,speed:250,transition:"fadeIn",transitionClose:!1,zIndex:9997}})(jQuery);

(function(a){a.isScrollToFixed=function(b){return !!a(b).data("ScrollToFixed")};a.ScrollToFixed=function(d,h){var k=this;k.$el=a(d);k.el=d;k.$el.data("ScrollToFixed",k);var c=false;var F=k.$el;var G;var D;var p;var C=0;var q=0;var i=-1;var e=-1;var t=null;var y;var f;function u(){F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");e=-1;C=F.offset().top;q=F.offset().left;if(k.options.offsets){q+=(F.offset().left-F.position().left)}if(i==-1){i=q}G=F.css("position");c=true;if(k.options.bottom!=-1){F.trigger("preFixed.ScrollToFixed");w();F.trigger("fixed.ScrollToFixed")}}function m(){var H=k.options.limit;if(!H){return 0}if(typeof(H)==="function"){return H.apply(F)}return H}function o(){return G==="fixed"}function x(){return G==="absolute"}function g(){return !(o()||x())}function w(){if(!o()){t.css({display:F.css("display"),width:F.outerWidth(true),height:F.outerHeight(true),"float":F.css("float")});cssOptions={position:"fixed",top:k.options.bottom==-1?s():"",bottom:k.options.bottom==-1?"":k.options.bottom,"margin-left":"0px"};if(!k.options.dontSetWidth){cssOptions.width=F.width()}F.css(cssOptions);F.addClass("scroll-to-fixed-fixed");if(k.options.className){F.addClass(k.options.className)}G="fixed"}}function b(){var I=m();var H=q;if(k.options.removeOffsets){H=0;I=I-C}cssOptions={position:"absolute",top:I,left:H,"margin-left":"0px",bottom:""};if(!k.options.dontSetWidth){cssOptions.width=F.width()}F.css(cssOptions);G="absolute"}function j(){if(!g()){e=-1;t.css("display","none");F.css({width:"",position:D,left:"",top:p.top,"margin-left":""});F.removeClass("scroll-to-fixed-fixed");if(k.options.className){F.removeClass(k.options.className)}G=null}}function v(H){if(H!=e){F.css("left",q-H);e=H}}function s(){var H=k.options.marginTop;if(!H){return 0}if(typeof(H)==="function"){return H.apply(F)}return H}function z(){if(!a.isScrollToFixed(F)){return}var J=c;if(!c){u()}var H=a(window).scrollLeft();var K=a(window).scrollTop();var I=m();if(k.options.minWidth&&a(window).width()<k.options.minWidth){if(!g()||!J){n();F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed")}}else{if(k.options.bottom==-1){if(I>0&&K>=I-s()){if(!x()||!J){n();F.trigger("preAbsolute.ScrollToFixed");b();F.trigger("unfixed.ScrollToFixed")}}else{if(K>=C-s()){if(!o()||!J){n();F.trigger("preFixed.ScrollToFixed");w();e=-1;F.trigger("fixed.ScrollToFixed")}v(H)}else{if(!g()||!J){n();F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed")}}}}else{if(I>0){if(K+a(window).height()-F.outerHeight(true)>=I-(s()||-l())){if(o()){n();F.trigger("preUnfixed.ScrollToFixed");if(D==="absolute"){b()}else{j()}F.trigger("unfixed.ScrollToFixed")}}else{if(!o()){n();F.trigger("preFixed.ScrollToFixed");w()}v(H);F.trigger("fixed.ScrollToFixed")}}else{v(H)}}}}function l(){if(!k.options.bottom){return 0}return k.options.bottom}function n(){var H=F.css("position");if(H=="absolute"){F.trigger("postAbsolute.ScrollToFixed")}else{if(H=="fixed"){F.trigger("postFixed.ScrollToFixed")}else{F.trigger("postUnfixed.ScrollToFixed")}}}var B=function(H){if(F.is(":visible")){c=false;z()}};var E=function(H){z()};var A=function(){var I=document.body;if(document.createElement&&I&&I.appendChild&&I.removeChild){var K=document.createElement("div");if(!K.getBoundingClientRect){return null}K.innerHTML="x";K.style.cssText="position:fixed;top:100px;";I.appendChild(K);var L=I.style.height,M=I.scrollTop;I.style.height="3000px";I.scrollTop=500;var H=K.getBoundingClientRect().top;I.style.height=L;var J=(H===100);I.removeChild(K);I.scrollTop=M;return J}return null};var r=function(H){H=H||window.event;if(H.preventDefault){H.preventDefault()}H.returnValue=false};k.init=function(){k.options=a.extend({},a.ScrollToFixed.defaultOptions,h);k.$el.css("z-index",k.options.zIndex);t=a("<div />");G=F.css("position");D=F.css("position");p=a.extend({},F.offset());if(g()){k.$el.after(t)}a(window).bind("resize.ScrollToFixed",B);a(window).bind("scroll.ScrollToFixed",E);if(k.options.preFixed){F.bind("preFixed.ScrollToFixed",k.options.preFixed)}if(k.options.postFixed){F.bind("postFixed.ScrollToFixed",k.options.postFixed)}if(k.options.preUnfixed){F.bind("preUnfixed.ScrollToFixed",k.options.preUnfixed)}if(k.options.postUnfixed){F.bind("postUnfixed.ScrollToFixed",k.options.postUnfixed)}if(k.options.preAbsolute){F.bind("preAbsolute.ScrollToFixed",k.options.preAbsolute)}if(k.options.postAbsolute){F.bind("postAbsolute.ScrollToFixed",k.options.postAbsolute)}if(k.options.fixed){F.bind("fixed.ScrollToFixed",k.options.fixed)}if(k.options.unfixed){F.bind("unfixed.ScrollToFixed",k.options.unfixed)}if(k.options.spacerClass){t.addClass(k.options.spacerClass)}F.bind("resize.ScrollToFixed",function(){t.height(F.height())});F.bind("scroll.ScrollToFixed",function(){F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");z()});F.bind("detach.ScrollToFixed",function(H){r(H);F.trigger("preUnfixed.ScrollToFixed");j();F.trigger("unfixed.ScrollToFixed");a(window).unbind("resize.ScrollToFixed",B);a(window).unbind("scroll.ScrollToFixed",E);F.unbind(".ScrollToFixed");k.$el.removeData("ScrollToFixed")});B()};k.init()};a.ScrollToFixed.defaultOptions={marginTop:0,limit:0,bottom:-1,zIndex:1000};a.fn.scrollToFixed=function(b){return this.each(function(){(new a.ScrollToFixed(this,b))})}})(jQuery);