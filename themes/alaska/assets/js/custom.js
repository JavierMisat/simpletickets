jQuery(document).ready(function ($) {
    "use strict";
    //SELECT
    //BACK TO TOP
    $('.backtotop').click(function () {
        $('html,body').animate({scrollTop: 0}, 800);
        return false;
    });
    if ($('.flex-control-thumbs').length == 1) {
        $('.flex-control-thumbs').not('.slick-initialized').each(function () {
            var _this = $(this),
                _config = [];
            _config.focusOnSelect = false;
            _config.infinite = false;
            _config.slidesToShow = 4;
            _config.cssEase = 'linear';
            _config.arrows = false;
            _config.slidesToScroll = 1;
            _config.autoplay = true;
            _config.autoplaySpeed = 2000;
            _this.slick(_config);
        })
    }
    ;
    $(window).scroll(function () {
        ts_update_back_to_top();
    });
    ts_update_back_to_top();

    function ts_update_back_to_top() {
        if ($(window).scrollTop() > 180) {
            $('.backtotop').addClass('ts-block')
        } else {
            $('.backtotop').removeClass('ts-block')
        }
    }

    $('.ts-option-search').each(function () {
        $(this).wrap('<div class="ts-select-style"></div>');
        $(this).after("<span class='ts_selected'></span>");
    });
    $(".ts-option-search").change(function () {

        var selectedOption = $(this).find(":selected").text();

        $(this).next(".ts_selected").text(selectedOption);

    }).trigger('change');

    //FUNFACT

    $('.ts-funfact').appear(function () {
        var count_element = $('.funfact-number', this).html();
        $(".funfact-number", this).countTo({
            from: 0,
            to: count_element,
            speed: 2500,
            refreshInterval: 50,
        });
    });

    var widthDev = $(window).width();
    if ((widthDev < 1200) && (widthDev >= 768)) {
        $('.menu-nav li').click(function () {
            //$('.menu-nav li').removeClass('ts_hover')
            //$(this).addClass('ts_hover');
            $(this).toggleClass('ts_hover');
        });

    } else if (widthDev <= 767) {
        $('.menu-nav li').click(function () {
            $(this).toggleClass('ts_hover');
        });
    } else {
        $('#menu-main-menu').addClass('ts-menu-destop');
    }
    //PARALLAX
    //$(".parallax-section").parallax();


    //TAB

    $('.ts-horizontalTab').easyResponsiveTabs({
        type: 'default',
        width: 'auto',
        fit: true,
        animation: 'slide'
    });
    if ($(window).width() > 767) {
        $('.ts-horizontalTab').each(function () {
            var _this = $(this);
            var numberTab = _this.find(".resp-tabs-list li").size();
            var wTab = 100 / numberTab;
            _this.find(".resp-tabs-list li").css("width", wTab + "%")
        })
    }
    $('.ts-verticalTab').easyResponsiveTabs({
        type: 'vertical',
        fit: true
    });
    if ($(window).width() >= 768) {
        $('.ts-verticalTab').each(function () {
            var _thisV = $(this);
            var heightTab = _thisV.find('.resp-tabs-list li[aria-controls="tab_item-0"]').outerHeight();
            var numberTabV = _thisV.find(".resp-tabs-list li").size();
            var hTab = heightTab * numberTabV - 1;
            _thisV.find(".resp-tabs-container").css("min-height", hTab + "px")
        })
    }
    //TWITTER SLIDER
    if ($("#owl-twitter").length > 0) {

        $(".twitter-slide").owlCarousel({
            autoPlay: 4000,
            slideSpeed: 1000,
            navigation: false,
            pagination: true,
            singleItem: true
        });
    }

    //MENU MOBILE
    $('.mobile-navigation').click(function () {
        $('.ts-mainmenu').slideToggle(500);
    })

    //CLIENT SLIDER
    if ($(".ts-client-list ul").length > 0) {

        $(".ts-client-list ul").owlCarousel({
            items: 3,
            autoPlay: 4000,
            slideSpeed: 1000,
            navigation: false,
            pagination: false,
            singleItem: false,
            navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            itemsCustom: [[0, 1], [320, 2], [480, 2], [768, 4], [992, 4], [1200, 5]]
        });
    }
    // Skill bar
    $('.skillbar').each(function () {
        $(this).find('.skillbar-bar').animate({
            width: $(this).attr('data-percent')
        }, 6000);
    });

    $(window).load(function () {
        if ($('#wpadminbar').length) {
            var heightB = $('#wpadminbar').outerHeight();
            $(".main-header").sticky({topSpacing: heightB});
        } else {
            $(".main-header").sticky({topSpacing: 0});
        }
    });

    // Portfolio slider
    if ($(".ts-portfolio-slider").length > 0) {
        $(".ts-portfolio-slider").owlCarousel({
            autoPlay: 4000,
            slideSpeed: 1000,
            navigation: true,
            pagination: false,
            singleItem: true,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        });
    }

    //Gallery blog
    if ($(".blog-grallery").length > 0) {

        $(".blog-grallery").owlCarousel({
            autoPlay: 4000,
            slideSpeed: 3000,
            navigation: true,
            pagination: false,
            singleItem: true,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        });
    }
    //SELECT SHOP
    if (jQuery().chosen) {
        $(".woocommerce-ordering .orderby").chosen();
    }
    //SIDER BAR
    if ($(window).width() > 991) {
        $('.ts-menu-sidebar li a').hover(function () {
            var _parent = $(this).parent();
            if ((!_parent.hasClass('current_page_item')) && (!_parent.hasClass('current-menu-parent'))) {
                _parent.addClass('ts-active-menusiderbar');
                _parent.find('.dropdown-menu').slideDown();
                _parent.mouseleave(function () {
                    $(this).removeClass('ts-active-menusiderbar');
                    $(this).find('.dropdown-menu').slideUp();
                })
            }
        })
    }


    //Menu header 2
    var height1 = $('.ts-header-1').outerHeight();
    var height2 = $('.top-header').outerHeight();
    var resultH = height1 + height2;
    $(window).scroll(function () {
        var scrollTop = $(document).scrollTop();
        if (scrollTop > resultH) {
            $('.main-menu-2').addClass('fixed');
        } else {
            $('.main-menu-2').removeClass('fixed');
        }
    })
});

(function (e) {
    "use strict";
    e(document).ready(function () {
        e("#toggle-bar-wrap").click(function (e) {
            e.stopPropagation()
        });
        e(document).click(function () {
            e("#toggle-bar-wrap").removeClass("active-bar");
            e("a.toggle-bar-btn.fade-toggle").children(".ts-infobar").removeClass("infobar-up").addClass("infobar-down")

        });
        e("a.toggle-bar-btn.fade-toggle").on(false ? "touchstart" : "click", function (t) {
            e(this).find(".ts-infobar").toggleClass("infobar-up infobar-down");
            e("#toggle-bar-wrap").toggleClass("active-bar");
            return false
        });
    })
})(jQuery);
jQuery(function ($) {

    // Quantity buttons
    $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

    // Target quantity inputs on product pages
    $('input.qty:not(.product-quantity input.qty)').each(function () {
        var min = parseFloat($(this).attr('min'));

        if (min && min > 0 && parseFloat($(this).val()) < min) {
            $(this).val(min);
        }
    });

    $(document).on('click', '.plus, .minus', function () {

        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
            currentVal = parseFloat($qty.val()),
            max = parseFloat($qty.attr('max')),
            min = parseFloat($qty.attr('min')),
            step = $qty.attr('step');

        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
        if (max === '' || max === 'NaN') max = '';
        if (min === '' || min === 'NaN') min = 0;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

        // Change the value
        if ($(this).is('.plus')) {

            if (max && (max == currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {

            if (min && (min == currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }

        }

        // Trigger change event
        $qty.trigger('change');
    });

    $('.navbar-collapse .nav .dropdown').hover(function (e) {
        $(this).find('.dropdown-menu').stop(true, false).slideDown(300);
    }, function (e) {
        $(this).find('.dropdown-menu').stop(true, false).slideUp(300);
    });

    // Color Changer
    $('.color-changer').each(function () {
        var $this = $(this);
        var this_color = $this.attr('data-color');
        var this_hover_color = $this.attr('data-hover-color');
        var selector = $this;

        if (typeof this_color != 'undefined' && typeof this_color != false) {
            var target = $this.attr('data-c-target');
            if ($.trim(target) != '') {
                if ($this.find($.trim(target).length)) {
                    selector = $this.find($.trim(target));
                    selector.css({
                        color: this_color
                    });
                }
            }
            else {
                selector.css({
                    color: this_color
                });
            }
        }

        // Hover color
        if (typeof this_hover_color != 'undefined' && typeof this_hover_color != false) {
            var target_hover = $this.attr('data-hover-c-target');
            if ($.trim(target_hover) != '') {
                $this.find($.trim(target_hover)).each(function () {

                    // For nav menu (active)
                    if ($(this).closest('.menu-item.active').length) {
                        $(this).closest('.menu-item.active').find('> a').css({
                            'color': this_hover_color
                        });
                    }

                    var color_before_hover = $(this).css('color');
                    if (typeof this_color != 'undefined' && typeof this_color != false) {
                        color_before_hover = this_color;
                    }
                    if ($(this).closest('.menu-item.active').length) { // Active menu item
                        color_before_hover = this_hover_color;
                    }
                    $(this).hover(function () {
                        $(this).css({
                            'color': this_hover_color
                        });

                        // For nav menu
                        if ($(this).closest('.menu-item').length && $(this).is('a')) {
                            $(this).closest('.menu-item').find('> a').css({
                                'color': this_hover_color
                            });
                        }

                    }, function () {
                        $(this).css({
                            'color': color_before_hover
                        });

                        // For nav menu
                        if ($(this).closest('.menu-item').length && $(this).is('a')) {
                            $(this).closest('.menu-item').find('> a').css({
                                'color': color_before_hover
                            });
                        }
                    });
                });
            }
        }

    });

    $('.bg-color-changer').each(function () {
        var $this = $(this);
        var this_color = $this.attr('data-bg-color');
        var selector = $this;

        if (typeof this_color != 'undefined' && typeof this_color != false) {
            var target = $this.attr('data-bgc-target');
            if ($.trim(target) != '') {
                if ($this.find($.trim(target).length)) {
                    selector = $this.find($.trim(target));
                    selector.css({
                        'background-color': this_color
                    });
                }
            }
            else {
                selector.css({
                    'background-color': this_color
                });
            }
        }
    });
});

function TS_Check_Domain() {
    jQuery.ajax({
        type: 'POST',
        url: jQuery('#whois').attr('action'),
        data: jQuery('#whois').serialize()
    }).done(function (data) {
        jQuery('#log_res').html(data);
    });

    return false;
}