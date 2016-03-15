
$(document).ready(function() {
    //Find out if screen is in mobile or desktop range.
    var isNotMobile = window.matchMedia("only screen and (min-width: 640px)");

    //If in desktop range, make the header sticky.
    if (isNotMobile.matches) {
        $("#header-block").sticky({ topSpacing: 0 });
    //}
    //If in the mobile range, hide the first two detail bullets.
    //else {
        //$.each($('.res-details'), function(index, value) {
            //Get the first two list items in the .res-details div.
            //var items = $(value).find('ul li').slice(0,2).detach();

            //Prepend those to list items in the div surrounding the other hidden list items to make them
            //invisible as well.
            //$(value).find('ul div').prepend(items);
        //});
    }
});

$(document).ready(function() {
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    // disable nav click activation on desktop / tablet
    var $navItems = $('.navbar-nav > li.dropdown > a.dropdown-toggle');
    var $navMenus = $('.navbar-nav > li.dropdown > ul.dropdown-menu');
    if(!isMobile) {
        $navItems.removeAttr('data-toggle');
        // toggle nav background on hover
        $('.navbar-nav > li.dropdown > ul.dropdown-menu').hover(function () {
            var $menu = $(this);
            var $menuLabel = $menu.parent().find('a.dropdown-toggle');
            $menuLabel.css('backgroundColor', '#124563');
            $menu.addClass('menu-hovered');
        }, function() {
            var $menu = $(this);
            $menu.removeClass('menu-hovered');
            $menu.hide();
            var $menuLabel = $menu.parent().find('a.dropdown-toggle');
            var menuItemHovered = $menuLabel.hasClass('menu-item-hovered');
            if (!menuItemHovered) {
                $(this).parent().find('a.dropdown-toggle').css('backgroundColor', '#0c4e77');
            }
        });
        // keep nav background on hover
        $('.navbar-nav > li.dropdown').hover(function (){
            var $menuLabel = $(this).find('a.dropdown-toggle');
            var $menu = $(this).find('ul.dropdown-menu');
            $menu.show();
            $menuLabel.css('backgroundColor', '#124563');
            $menuLabel.addClass('menu-item-hovered');
        }, function() {
            var $menuLabel = $(this).find('a.dropdown-toggle');
            var $menu = $(this).find('ul.dropdown-menu');
            $menuLabel.removeClass('menu-item-hovered');
            var menuHovered = $menu.hasClass('menu-hovered');
            if (!menuHovered) {
                $menu.hide();
                $menuLabel.css('backgroundColor', '#0c4e77');
            }
        });
        // toggle nav click menu activation with viewport size change
        $(window).resize(function() {
            var mobileView = $(window).width() < 768;
            if (mobileView) {
                $navItems.attr('data-toggle', 'dropdown');
            } else {
                if (!isMobile) {
                    $navItems.removeAttr('data-toggle');
                    $navMenus.hide();
                }
            }
        });
    }

    $('body').on('click', '[href^=collapse]', function (e) {
        e.preventDefault()
    });

    // smooth scrolling to page anchors with consideration
    // for sticky header on desktop and mobile
    $("a[href^='#']").each(function(index, element) {

        if ($(element).attr("href").length > 2) {

            var name = $(this).attr('href').replace(/\#/g, '');

            try {
                var anchor = $('a[name=' + name + ']');

                if (anchor.length > 0) {
                    $(element).click(function(event) {

                        event.preventDefault();

                        // desktop
                        if (window.innerWidth > 800) {
                            $('html,body').animate({scrollTop: anchor.offset().top  - 122},'slow');
                        }
                        else { // mobile
                            $('html,body').animate({scrollTop: anchor.offset().top},'slow');
                        }

                    });
                }
            }
            catch (err) {
            }
        }

    });

    // ensure all img tracking pixels do not have space on page
    $('body > img').each(function(index, element){

        if ($(element).width() === 1 || $(element).height() === 1) {
            $(element)
                .width(0)
                .height(0)
                .css('height', '0px')
                .css('width', '0px')
                .css('display', 'none')
                .css('border', 'solid transparent 0px');
        }

    });

    //Function for all bootstrap tooltips sitewide.
    $('[data-toggle="tooltip"]').tooltip();

});
