 /**
 * Theme functions
 * Initialize all scripts and adds custom js
 *
 * @since 1.0.0
 *
 */

( function( $ ) {

    'use strict';

    var wpexFunctions = {

        /**
         * Define cache var
         *
         * @since 1.0.0
         */
        cache: {},

        /**
         * Main Function
         *
         * @since 1.0.0
         */
        init: function() {
            this.cacheElements();
            this.bindEvents();
        },

        /**
         * Cache Elements
         *
         * @since 1.0.0
         */
        cacheElements: function() {
            this.cache = {
                $window   : $( window ),
                $document : $( document ),
                $isTouch  : false
            };
        },

        /**
         * Bind Events
         *
         * @since 1.0.0
         */
        bindEvents: function() {

            // Get sef
            var self = this;

            // Check if touch is supported
            self.cache.$isTouch = ( ( 'ontouchstart' in window ) || ( navigator.msMaxTouchPoints > 0 ) );

            // Run on document ready
            self.cache.$document.on( 'ready', function() {
                self.cookies();
                self.coreFunctions();
                self.scrollTop();
                self.headerSearch();
                self.lightbox();
                self.mobileMenu();
                self.wooTweaks();
            } );

            // Run on Window Load
            self.cache.$window.on( 'load', function() {
                self.lightSliders();
                self.stickyElements();
                //self.nextPostPopup();
            } );

        },

        /**
         * Cookies
         *
         * @since 1.0.0
         */
        cookies: function() {

            // Clear cookie
            var $hash = window.location.hash;
            if ( '#wpex-notice-bar-cookie-delete' == $hash ) {
                $.removeCookie( 'wpex-notice-bar', { path: '/' } );
            }

            // Show/hide notice bar based on cookie
            if ( $.cookie( 'wpex-notice-bar' ) !== 'hide' ) {
                $( '.wpex-notice-bar' ).addClass( 'show' );
            };

            // Hide notice bar on click
            $( '.wpex-notice-bar-toggle.hide-bar' ).on( 'click', function( event ) {
                $( '.wpex-notice-bar' ).removeClass( 'show' );
                $.cookie( 'wpex-notice-bar', 'hide', {
                    expires : 10,
                    path    : '/'
                } );
                return false;
            } );

        },

        /**
         * Main theme functions
         *
         * @since 1.0.0
         */
        coreFunctions: function() {

        	var self = this;
           
            // Add class to last pingback for styling purposes
            $( ".commentlist li.pingback" ).last().addClass( 'last' );

            // Equal heights
            if ( $.fn.matchHeight != undefined ) {

            	// Homepage cats match height
            	if ( $( '.wpex-home-cat-entry' ).length !== 0 ) {
                	$( '.wpex-row .wpex-home-cat-entry .wpex-match-height' ).matchHeight();
            	}

            	// Standard entries
                
            }

            // Touch event for dropdowns
            $( '.wpex-dropdown-menu li.menu-item-has-children' ).on( 'touchstart', function( event ) {
            	$( this ).toggleClass( 'wpex-touched' );
            });

        },

        /**
         * Mobile menu
         *
         * @since 1.0.0
         */
        mobileMenu: function() {

                if ( ! $.fn.sidr ) {
                    return;
                }

                var self = this;

                // Add sidr
                $( 'a.wpex-toggle-mobile-menu' ).sidr( {
                    name     : 'wpex-main-sidr',
                    speed    : parseInt( wpexLocalize.sidrSpeed ),
                    source   : wpexLocalize.sidrSource,
                    side     : wpexLocalize.sidrSide,
                    displace : wpexLocalize.sidrDisplace,
                    renaming : true,
                    onOpen   : function( name ) {

                        // Hide if wrap clicked
                        $( '.wpex-site-wrap' ).click( function() {
                            $( '.sidr-class-menu-item-has-children.active' ).removeClass( 'active' ).children( 'ul' ).hide();
                            $.sidr( 'close', 'wpex-main-sidr' );
                        } );

                        // Rename font icons
                        $( "#wpex-main-sidr [class*='sidr-class-fa']" ).attr( 'class',
                            function( i, c ) {
                            c = c.replace( 'sidr-class-fa', 'fa');
                            c = c.replace( 'sidr-class-fa-', 'fa-');
                            return c;
                        } );

                        // Close on orientation change
                        self.cache.$window.on( 'orientationchange',function() {
                            $.sidr( 'close', 'wpex-sidr-menu' );
                        } );

                        // Bind scroll
                        $( "#wpex-main-sidr" ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
                            var e0    = e.originalEvent,
                                delta = e0.wheelDelta || -e0.detail;
                            this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
                            e.preventDefault();
                        });

                    },
                    onClose : function( name ) {

                        // Nothing yet

                    }

                } );

                // Declare useful vars
                var $hasChildren = $( '.sidr-class-menu-item-has-children' );

                // Add dropdown toggle (arrow)
                $hasChildren.children( 'a' ).append( '<span class="sidr-class-dropdown-toggle"></span>' );

                // Toggle dropdowns
                $( '.sidr-class-dropdown-toggle' ).on( self.cache.$isTouch ? 'touchstart' : 'click', function( event ) {
                    event.preventDefault();
                    var $toggleParentLink = $( this ).parent( 'a' ),
                        $toggleParentLi   = $toggleParentLink.parent( 'li' ),
                        $allParentLis     = $toggleParentLi.parents( 'li' ),
                        $dropdown         = $toggleParentLi.children( 'ul' );
                    if ( ! $toggleParentLi.hasClass( 'active' ) ) {
                        $hasChildren.not( $allParentLis ).removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
                        $toggleParentLi.addClass( 'active' ).children( 'ul' ).show( 'fast' );
                    } else {
                        $toggleParentLi.removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
                    }
                } );
                
                // Close sidr when clicking toggle
                $( 'a.sidr-class-toggle-sidr-close' ).on( self.cache.$isTouch ? 'touchstart' : 'click', function( event ) {
                    event.preventDefault();
                    $( '.sidr-class-menu-item-has-children.active' ).removeClass( 'active' ).children( 'ul' ).hide();
                    $.sidr( 'close', 'sidr-main' );
                } );

                // Close sidr when cliking main content
                $( '#outer-wrap' ).click( function() {
                    $( '.sidr-class-menu-item-has-children.active' ).removeClass( 'active' ).children( 'ul' ).hide();
                    $.sidr( 'close', 'sidr-main' );
                } );

        },

        /**
         * Header Search
         *
         * @since 1.0.0
         */
        headerSearch: function() {
            var $toggleLink = $( 'a.wpex-toggle-menu-search' );
            $toggleLink.click( function() {
                $( this ).css( {
                    'opacity' : 0
                } );
                $( '.wpex-cart-dropdown' ).removeClass( 'wpex-visible' );
                $( '.wpex-cart-dropdown' ).addClass( 'wpex-invisible' );
                $( '.wpex-header-searchform' ).toggleClass( 'wpex-invisible wpex-visible' );
                $( '.wpex-header-searchform input' ).focus();
                return false;
            } );
            $( '.wpex-header-searchform' ).click( function( event ) {
                event.stopPropagation();
            } );
            this.cache.$document.click( function() {
                $( '.wpex-header-searchform' ).removeClass( 'wpex-visible' );
                $( '.wpex-header-searchform' ).addClass( 'wpex-invisible' );
                $toggleLink.css( {
                    'opacity' : 1
                } );
            });
        },

        /**
         * Scroll top function
         *
         * @since 1.0.0
         */
        scrollTop: function() {

            var $scrollTopLink = $( 'a.wpex-site-scroll-top' );

            this.cache.$window.scroll(function () {
                if ( $( this ).scrollTop() > 100 ) {
                    $scrollTopLink.addClass( 'show' );
                } else {
                    $scrollTopLink.removeClass( 'show' );
                }
            } );

            $scrollTopLink.on( 'click', function() {
                $( 'html, body' ).animate( {
                    scrollTop : 0
                }, 400 );
                return false;
            } );

        },

        /**
         * Post Slider
         *
         * @since 1.0.0
         */
        lightSliders: function() {
            
            if ( $.fn.lightSlider === undefined ) {
                return;
            }

            // Full Slider
            var $fullSliderWrap = $( '.wpex-full-slider-wrap' );

            if ( $fullSliderWrap.length !== 0 ) {

                $fullSliderWrap.show();

                var $fullSlider = $( '.wpex-full-slider' );

                $fullSlider.lightSlider( {
                    mode           : 'fade',
                    speed          : 500,
                    pause          : parseInt( wpexHomeSliderVars.pause ),
                    auto           : wpexHomeSliderVars.slideShow,
                    adaptiveHeight : true,
                    item           : 1,
                    slideMargin    : 0,
                    pager          : true,
                    controls       : true,
                    loop           : true,
                    rtl            : wpexLocalize.isRTL,
                    prevHtml       : '<span class="fa fa-angle-left"></span>',
                    nextHtml       : '<span class="fa fa-angle-right"></span>',
                    onSliderLoad   : function( el ) {
                        if ( wpexHomeSliderVars.slideShow && parseInt( wpexHomeSliderVars.pause ) ) {
                            setTimeout( function() {
                                $fullSlider.play();
                            }, parseInt( wpexHomeSliderVars.pause ) );
                        }
                    }
                } );

            }
 
            // Post Slider
            var $slider = $( '.wpex-post-slider' );

            if ( $slider.length !== 0 ) {

                $slider.each( function() {

                    var $this = $( this );

                    $this.show();

                    $this.lightSlider( {
                        mode           : 'fade',
                        auto           : false,
                        speed          : 500,
                        adaptiveHeight : true,
                        item           : 1,
                        slideMargin    : 0,
                        pager          : false,
                        loop           : true,
                        rtl            : wpexLocalize.isRTL,
                        prevHtml       : '<span class="fa fa-angle-left"></span>',
                        nextHtml       : '<span class="fa fa-angle-right"></span>',
                        onBeforeStart  : function( el ) {
                            $( '.slider-first-image-holder, .slider-preloader' ).hide();
                        }
                    });

                });

            }

            // Slider widget
            var $instagramSlider = $( '.wpex-instagram-slider-widget-slider' );

            if ( $instagramSlider.length !== 0 ) {

                $instagramSlider.show();

                $instagramSlider.lightSlider( {
                    mode           : 'fade',
                    auto           : true,
                    pause          : 3000,
                    speed          : 500,
                    adaptiveHeight : true,
                    item           : 1,
                    slideMargin    : 0,
                    pager          : false,
                    controls       : true,
                    loop           : true,
                    rtl            : wpexLocalize.isRTL,
                    prevHtml       : '<span class="fa fa-angle-left"></span>',
                    nextHtml       : '<span class="fa fa-angle-right"></span>',
                    onSliderLoad  : function( el ) {
                        setTimeout( function() {
                        	$instagramSlider.play();
                        }, 3000 );
                    }

                });

            }

            // Shop carousel
            var $shopCarouselOuter = $( '.wpex-shop-carousel-outer' );

            if ( $shopCarouselOuter.length !== 0 ) {

                $shopCarouselOuter.show();

                $( '.wpex-shop-carousel' ).lightSlider( {
                	auto        : false,
                    item        : parseInt( wpexShopCarousel.columns ),
                    slideMove   : parseInt( wpexShopCarousel.columns ),
                    prevHtml    : '<span class="fa fa-angle-left"></span>',
                    nextHtml    : '<span class="fa fa-angle-right"></span>',
                    pager       : true,
                    controls    : false,
                    rtl         : wpexLocalize.isRTL,
                    slideMargin : parseInt( wpexShopCarousel.margin ),
                    responsive  : [
                        {
                            breakpoint : 956,
                            settings   : {
                                item        : 4,
                                slideMove   : 4,
                                slideMargin : 20
                              }
                        },
                        {
                            breakpoint : 800,
                            settings   : {
                                item        : 3,
                                slideMove   : 3,
                                slideMargin : 20
                              }
                        },
                        {
                            breakpoint : 480,
                            settings   : {
                                item        : 2,
                                slideMove   : 2,
                                slideMargin : 10
                              }
                        }
                    ]
                } );

            }

        },

        /**
         * Lightbox
         *
         * @since 1.0.0
         */
        lightbox: function() {

            if ( $.fn.magnificPopup != undefined ) {

                // Gallery lightbox
                $( '.wpex-lightbox-gallery, .woocommerce .images' ).each( function() {
                    $(this).magnificPopup( {
                        delegate    : 'a.wpex-lightbox-item',
                        type        : 'image',
                        gallery     : {
                            enabled : true
                        }
                    } );
                } );

                // WooCommerce lightbox
                $( '.woocommerce .images .thumbnails' ).magnificPopup( {
                    delegate    : 'a',
                    type        : 'image',
                    gallery     : {
                        enabled : true
                    }
                } );
                $( '.woocommerce .images .woocommerce-main-image' ).magnificPopup( {
                    type : 'image'
                } );

                if ( wpexLocalize.wpGalleryLightbox == true ) {

                    $( '.wpex-entry .gallery' ).each( function() {

                        // Check first item and see if it's linking to an image if so add lightbox
                        var firstItemHref = $(this).find( '.gallery-item a' ).first().attr( 'href' );
                        if ( /\.(jpg|png|gif)$/.test( firstItemHref ) ) {
                            $(this).magnificPopup( {
                                delegate    : '.gallery-item a',
                                type        : 'image',
                                gallery     : {
                                    enabled : true
                                }
                            } );
                        }

                    } );

                }

                // Auto add lightbox to entry images
                $( '.single-post .wpex-entry a:has(img)' ).each( function() {

                    // Define this
                    var $this = $( this );

                    // Not for gallery
                    if ( $this.parent().hasClass( 'gallery-icon' ) ) {
                        return;
                    }

                    // Get data
                    var $img  = $this.find( 'img' ),
                        $src  = $img.attr( 'src' ),
                        $ref  = $this.attr( 'href' ),
                        $ext  = $ref.substr( ( $ref.lastIndexOf( '.' ) +1 ) );

                    // Ad lightbox
                    if ( 'png' == $ext || 'jpg' == $ext || 'jpeg' == $ext || 'gif' == $ext ) {
                        $this.magnificPopup( {
                            type    : 'image'
                        } );
                    }

                } );

            }

        },

        /**
         * Sticky Elements
         *
         * @since 1.0.0
         */
        stickyElements: function() {

            // Sticky Nav
            if ( $( 'body' ).hasClass( 'wpex-has-sticky-nav' ) ) {

                $( '.wpex-site-nav' ).sticky( {
                    wrapperClassName : 'wpex-sticky-nav',
                    responsiveWidth  : true
                } );

            }

            // Sticky header
            else if ( $( 'body' ).hasClass( 'wpex-has-sticky-header' ) ) {

                $( '.wpex-site-header-wrap' ).sticky( {
                    wrapperClassName : 'wpex-sticky-header',
                    responsiveWidth  : true
                } );

            }

        },

        /**
         * Next post popup
         *
         * @since 1.0.0
         */
        nextPostPopup: function() {

            var $postArticle = $( '.wpex-post-article-box' );

            if ( $postArticle.length == 0 ) {
                return;
            }

            var $articleEndPosition = $postArticle.position().top+$postArticle.outerHeight()-$('.wpex-site-header-wrap').outerHeight()-500;

            this.cache.$window.scroll( function() {

                if ( $( this ).scrollTop() >= $articleEndPosition ) {
                    $( '.wpex-next-post-popup' ).removeClass( 'wpex-invisible');
                    $( '.wpex-next-post-popup' ).addClass( 'wpex-visible');
                } else {
                    $( '.wpex-next-post-popup' ).removeClass( 'wpex-visible');
                    $( '.wpex-next-post-popup' ).addClass( 'wpex-invisible');
                }



            } );

        },

        /**
         * WooCommerce Tweaks
         *
         * @since 1.0.0
         */
        wooTweaks: function() {

        	var self = this;

            if ( $.fn.matchHeight != undefined ) {
                $( '.products .wpex-product-entry-details, .wpex-login-template-form > .wpex-boxed-container' ).matchHeight();
            }

            var $cartToggle = $( '.wpex-menu-cart-toggle' );
            if ( ! $cartToggle.hasClass( 'toggle-disabled' ) ) {
                var $dropDown = $( '.wpex-cart-dropdown' );
                $cartToggle.click( function( event ) {
                    $dropDown.toggleClass( 'wpex-invisible wpex-visible' );
                    return false;
                } );
                $dropDown.click( function( event ) {
                    event.stopPropagation();
                } );
                this.cache.$document.click( function() {
                    $dropDown.removeClass( 'wpex-visible' );
                    $dropDown.addClass( 'wpex-invisible' );
                });
                $dropDown.bind( 'mousewheel DOMMouseScroll', function ( e ) {
                    var e0    = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
                    e.preventDefault();
                });
            }

            $( '.wpex-shop-orderby .wpex-border-button' ).on( self.cache.$isTouch ? 'touchstart' : 'click', function( event ) {
                event.stopPropagation();
            	$( this ).toggleClass( 'wpex-show-ul' );
            } );
            $( '.woocommerce .wpex-shop-orderby ul' ).on( self.cache.$isTouch ? 'touchstart' : 'click', function( event ) {
                event.stopPropagation();
            } );
            this.cache.$document.click( function() {
                $( '.wpex-shop-orderby .wpex-border-button' ).removeClass( 'wpex-show-ul' );
            });

        },

    }; // END wpexFunctions

    // Get things going
    wpexFunctions.init();

} ) ( jQuery );