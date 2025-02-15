jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};

jQuery(document).ready(function(){

    stickyHeader();

    /** Show/hide password */
    jQuery('[data-toggle="password"]').click(function() {
        jQuery(this).find('i').toggleClass('fa-eye fa-eye-slash');
        var el = $($(this).data('target'));
        if (el.attr('type') == 'password') {
            el.attr('type', 'text');
        } else {
            el.attr('type', 'password');
        }
    });

    /** Smooth Scroll **/
    jQuery('a[rel="smoothscroll"]').click(function(){
        var top = jQuery(this).data('top');
        jQuery('html, body').animate({
            scrollTop: jQuery( jQuery.attr(this, 'href') ).offset().top - top
        }, 1000);
        return false;
    });

    /** Button to reset a field */
    jQuery('[data-toggle="reset"]').click(function() {
        var el = $($(this).data('target'));
        el.val('');
    });

    /** Detect browser and device */
    if((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)){
        jQuery('body').addClass('touch-device');
    }
    if ( /^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
        jQuery('body').addClass('safari');
    }

    $('.has-submenu').hover(function(){
        var offsetRight = $(this).offset().left + $(this).outerWidth();
        var menuWidth = $(this).width();
        var winWidth = $( window ).width();

        /** console.log( 'spazio a destra: ' +  (winWidth - offsetRight) + ' / largh. menu: ' + menuWidth); */

        if( (winWidth - offsetRight) > menuWidth ) {
            $(this).children('.dropdown-menu.submenu').addClass('right').removeClass('left');
        } else {
            $(this).children('.dropdown-menu.submenu').addClass('left').removeClass('right');
        }
    }, function(){});

    /** Menu attivo */
    // var page = location.href;
    var page = location.pathname;

    $('#navbar-main a').each(function(){
        var href = $(this).attr('href');
        if(page == href){
            $(this).addClass('active');
        }
    });

    /** Count to */
    $('.timer').countTo();

    /** Jarallax */
    $('.jarallax').jarallax({
        speed: 0.5,
    });

    /** Menu dropdowns  */
    $('[data-toggle="show"]').on('click', function (e) {
        var el = $($(this).data('target'));
        $(el).toggleClass('opened');
    });

    $('.category-menu > li.has-submenu > a').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        $(this).toggleClass('expanded');
        $(this).next('.megamenu').toggleClass('show');
    });

    $('#navbar-main li.dropdown').each(function(){
        submenu = $(this).children('.dropdown-menu');

        var offsetRight = submenu.offset().left + submenu.outerWidth();
        var menuWidth = submenu.width();
        var winWidth = $( window ).width();

        if( (winWidth - offsetRight) > menuWidth ) {
            submenu.removeClass('dropdown-menu-end');
        } else {
            submenu.addClass('dropdown-menu-end');
        }
    }, function(){});

    /** Wow.js */
    new WOW().init();

    /** Isotope */
    var $grid = $('.referenze-grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });
    var $storegrid = $('.store-grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });
    var $gallerygrid = $('.gallery-grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });
    var $productlastgrid = $('.productlast-grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    /** layout Isotope after each image loads */
    $grid.imagesLoaded().progress( function() {
        $grid.isotope('layout');
    });
    $storegrid.imagesLoaded().progress( function() {
        $storegrid.isotope('layout');
    });
    $gallerygrid.imagesLoaded().progress( function() {
        $gallerygrid.isotope('layout');
    });
    $productlastgrid.imagesLoaded().progress( function() {
        $productlastgrid.isotope('layout');
    });

    $('.referenze-filters').on( 'click', 'button', function() {
        $('.referenze-filters button').removeClass('active');
        $(this).addClass('active');
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
    });
    $('.store-filters').on( 'click', 'button', function() {
        $('.store-filters button').removeClass('active');
        $(this).addClass('active');
        var filterValue = $(this).attr('data-filter');
        $storegrid.isotope({ filter: filterValue });
    });
    $('.productlast-filters').on( 'click', 'button', function() {
        $('.productlast-filters button').removeClass('active');
        $(this).addClass('active');
        var filterValue = $(this).attr('data-filter');
        $productlastgrid.isotope({ filter: filterValue });
    });

    /** gLightbox */
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
    const lightboxP = GLightbox({
        selector: '.glightbox-p',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
    const lightboxG = GLightbox({
        selector: '.glightbox-g',
        touchNavigation: true,
        loop: true,
    });

    /** Plyr */
    if ($('.js-player').length){
        const players = Plyr.setup('.js-player');
    }

    /** Owl Carousel Init */
    if (jQuery('[data-toggle="owlcarousel"]').length > 0) {
        jQuery('[data-toggle="owlcarousel"]').each(function(){
            var id = jQuery(this).attr('id');

            var breakpoint = jQuery('#'+id).data('responsive');
            var dots = jQuery('#'+id).data('dots');
            var nav = jQuery('#'+id).data('nav');
            var autoplay = jQuery('#'+id).data('autoplay');
            var margin = jQuery('#'+id).data('margin');
            var autowidth = jQuery('#'+id).data('autowidth');
            var animateIn = jQuery('#'+id).data('animatein') ? jQuery('#'+id).data('animatein') : 'fadeIn';
            var animateOut = jQuery('#'+id).data('animateout') ? jQuery('#'+id).data('animateout') : 'fadeOut';

            var autoheight = jQuery('#'+id).data('autoheight');
            if (typeof autoheight === 'undefined' || autoheight === null) {
                var autoheight = false;
            }
            var navcontainer = jQuery('#'+id).data('navcontainer');
            if (typeof navcontainer === 'undefined' || navcontainer === null) {
                var navcontainer = [false,false,false,false,false];
            }
            var dotscontainer = jQuery('#'+id).data('dotscontainer');
            if (typeof dotscontainer === 'undefined' || dotscontainer === null) {
                var dotscontainer = [false,false,false,false,false];
            }
            var loop = jQuery('#'+id).data('loop');
            if (typeof loop === 'undefined' || loop === null) {
                var loop = false;
            }

            var $owl = jQuery('#'+id).owlCarousel({
                navText: [
                    '<i class="fas fa-angle-left"></i>',
                    '<i class="fas fa-angle-right"></i>'
                ],
                nav: true,
                dots: false,
                slideBy: 1,
                margin: 0,
                stagePadding: 0,
                items: 1,
                autoHeight: autoheight,
                loop: loop,
                lazyLoad: true,
                autoWidth: false,
                responsiveClass: true,
                autoplay: autoplay[0],
                autoplayTimeout: autoplay[1],
                autoplayHoverPause: true,
                animateOut: animateOut,
                animateIn: animateIn,
                singleItem: true,
                smartSpeed:450,
                responsive:{
                    0:{
                        margin:margin[0],
                        loop:true,
                        items:breakpoint[0],
                        nav:nav[0],
                        dots:dots[0],
                        navContainer: navcontainer[0],
                        dotsContainer: dotscontainer[0],
                        autoWidth: autowidth[0]
                    },
                    576:{
                        margin:margin[1],
                        loop:true,
                        items:breakpoint[1],
                        nav:nav[1],
                        dots:dots[1],
                        navContainer: navcontainer[1],
                        dotsContainer: dotscontainer[1],
                        autoWidth: autowidth[1]
                    },
                    768:{
                        margin:margin[2],
                        items:breakpoint[2],
                        nav:nav[2],
                        dots:dots[2],
                        navContainer: navcontainer[2],
                        dotsContainer: dotscontainer[2],
                        autoWidth: autowidth[2]
                    },
                    992:{
                        margin:margin[3],
                        loop:true,
                        items:breakpoint[3],
                        nav:nav[3],
                        dots:dots[3],
                        navContainer: navcontainer[3],
                        dotsContainer: dotscontainer[3],
                        autoWidth: autowidth[3]
                    },
                    1200:{
                        margin:margin[4],
                        loop:true,
                        items:breakpoint[4],
                        nav:nav[4],
                        dots:dots[4],
                        navContainer: navcontainer[4],
                        dotsContainer: dotscontainer[4],
                        autoWidth: autowidth[4]
                    },
                    1400:{
                        margin:margin[5],
                        loop:true,
                        items:breakpoint[5],
                        nav:nav[5],
                        dots:dots[5],
                        navContainer: navcontainer[5],
                        dotsContainer: dotscontainer[5],
                        autoWidth: autowidth[5]
                    },
                    1600:{
                        margin:margin[6],
                        loop:true,
                        items:breakpoint[6],
                        nav:nav[6],
                        dots:dots[6],
                        navContainer: navcontainer[6],
                        dotsContainer: dotscontainer[6],
                        autoWidth: autowidth[6]
                    }
                },
                onInitialized: function (event) {
                    jQuery('#'+id).find('.owl-dot').each(function(index) {
                        jQuery(this).attr('aria-label', index + 1);
                    });
                    jQuery('#'+id + ' .owl-prev').attr('role','button').attr('title','Previous').attr('tabindex','0');
                    jQuery('#'+id + ' .owl-next').attr('role','button').attr('title','Next').attr('tabindex','0');
                }
            });
        });
    }

    /** Scrolltop */
    if (jQuery('#back-to-top').length) {
        var scrollTrigger = 200,
            backToTop = function () {
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    jQuery('#back-to-top').addClass('show');
                } else {
                    jQuery('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        jQuery(window).on('scroll', function () {
            backToTop();
        });
        jQuery('#back-to-top').on('click', function (e) {
            e.preventDefault();
            scrollTop();
        });
    }

    jQuery('.open-navbar').on('click', function (e) {
        e.preventDefault();
        jQuery('body').addClass('overflow-hidden');
    });
    jQuery('.close-navbar').on('click', function (e) {
        e.preventDefault();
        jQuery('body').removeClass('overflow-hidden');
    });

    $('.drop-toggle').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).parent().next('.submenu').toggleClass('show');
    });
});

function stickyHeader() {
    /** Header Fix on scroll */
    var siteHeader = jQuery('#header').outerHeight();
    var stickyHeaderTop = jQuery('#header').offset().top;
    var windowsWidth = jQuery(window).width();

    if ( windowsWidth >= 1400 || ( windowsWidth < 1400 && $('#header').hasClass('sticky-header-mobile') )  ) {
        jQuery(window).scroll(function(){
            if (jQuery(window).scrollTop() >= stickyHeaderTop ) {
                jQuery('#header').addClass('sticky-header');
                jQuery('#topbar').addClass('sticky-header');
            } else {
                jQuery('#header').removeClass('sticky-header');
                jQuery('#topbar').removeClass('sticky-header');
            }
            if (jQuery(window).scrollTop() > siteHeader*2) {
                jQuery('#header').addClass('in-view');
                // jQuery('#main').css('padding-top', siteHeader+'px' );
            } else {
                jQuery('#header').removeClass('in-view');
                // jQuery('#main').css('padding-top', '0px');
            }
        });
    }
}

function goBack() {
    window.history.back();
}

function scrollTop() {
    jQuery('html,body').animate({
        scrollTop: 0
    }, 700);
}

function smoothScroll(target) {
    jQuery('html, body').animate({
        scrollTop: jQuery( target ).offset().top
    }, 1000);
    return false;
}

/** Enable Bootstrap tooltip */
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
/** Enable Bootstrap popover */
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

jQuery(window).on('load', function() {
    $('#pre-loader').fadeOut('slow');
});

jQuery(window).resize(function() {
    stickyHeader();
});

function nascondi_password(id, iconid){
    const password = document.querySelector(id);
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    if(type == 'text'){
        $(iconid).removeClass('fa-eye-slash');
        $(iconid).addClass('fa-eye');
    }else{
        $(iconid).removeClass('fa-eye');
        $(iconid).addClass('fa-eye-slash');
    }
}

function toggle_class(id, toggle_class){
    jQuery( id ).toggleClass( toggle_class );
}

function increaseValue(el) {
    var currentVal = parseInt( jQuery(el).val() );

    if ( jQuery(el).attr("max") ) {
        var maxVal = parseInt( jQuery(el).attr("max") );
        if(currentVal < maxVal){
            if (!isNaN(currentVal)) {
                jQuery(el).val(currentVal + 1);
            } else {
                jQuery(el).val(0);
            }
        }
    } else {
        if (!isNaN(currentVal)) {
            jQuery(el).val(currentVal + 1);
        } else {
            jQuery(el).val(0);
        }
    }
    jQuery(el).change();
}

function decreaseValue(el) {
    var currentVal = parseInt( jQuery(el).val() );

    if ( jQuery(el).attr("min") ) {
        var minVal = parseInt( jQuery(el).attr('min') );
        if(currentVal > minVal){
            if (!isNaN(currentVal)) {
                jQuery(el).val(currentVal - 1);
            } else {
                jQuery(el).val(0);
            }
        }
    } else {
        if (!isNaN(currentVal) && currentVal > 0) {
            jQuery(el).val(currentVal - 1);
        } else {
            jQuery(el).val(0);
        }
    }
    jQuery(el).change();
}

function view_products(el, view, remove_classes, add_classes) {
    $(el).parent().children().removeClass('active');
    $(el).addClass('active');

    $('.listing').removeClass(remove_classes).addClass(add_classes);
}
