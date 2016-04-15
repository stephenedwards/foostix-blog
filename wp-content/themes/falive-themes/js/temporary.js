$(document).ready(function () {

    //$(window).load(function() {

    $('.flexslider').removeClass('main_slider');

    // todo: create function for counting slide and finding the middle

    var sliderCount = $('.flexslider .slides li').length
    var sliderStart = Math.round((sliderCount - 1) / 2);

    // get width of all sliders


    $('.flexslider').flexslider({

        animation: 'slide',
        slideshow: false,
        startAt: 0,  // later variable sliderCount for starting in the middle
        controlNav: false,
        mousewheel: false,

        start: function (slider) {
            //$('.flex-active-slide .flex-caption-inner').slideUp('slow');

            $('.flex-active-slide .flex-caption-inner').addClass('flex-caption-up');

            var slides = slider.slides;
            startSlide = slider.currentSlide;
            positiveIndex = startSlide + 2;
            negativeIndex = slider.count - 2;

            $slide = $(slides[positiveIndex]);
            $img = $slide.find('img[data-src]');
            if ($img) {
                $img.attr("src", $img.attr('data-src')).removeAttr("data-src");
            }

            $slide = $(slides[negativeIndex]);
            $img = $slide.find('img[data-src]');
            if ($img) {
                $img.attr("src", $img.attr('data-src')).removeAttr("data-src");
            }


            //console.log(positiveIndex);
            //console.log(negativeIndex);
        },

        before: function (slider) {
            $('.flex-active-slide .flex-caption-inner').removeClass('flex-caption-up');

            var slides = slider.slides;

            currentSlide = slider.currentSlide;

            if (currentSlide < slider.animatingTo) {
                index = currentSlide + 2;
            } else {
                index = currentSlide - 2;
            }

            $slide = $(slides[index]);
            $img = $slide.find('img[data-src]');
            if ($img) {
                $img.attr("src", $img.attr('data-src')).removeAttr("data-src");
            }
        },

        after: function (slider) {
            $('.flex-active-slide .flex-caption-inner').addClass('flex-caption-up');


        },

    });

    $('.flex-active-slide .flex-caption').css({
        "display": "block"
    });



    if ($('body').hasClass('logged-in')) {
        // stick the article control

        $('#content').stickem({
            offset: 180,
            start: -44,
        });

        // stick the pictures to sections (in article)

        $('.entry-content').stickem({
            item: '.sticky-caption',
            stickClass: 'stickcap',
            endStickClass: 'stickcap-end',
            offset: 180,
            start: 0,
        });

    }

    //});

    // pagination on archives

    function rightAction() {

        var currentPage = $(".pagination input").attr('data-page');
        currentPage = parseInt(currentPage);

        var currentValue = $(".pagination input").val();
        currentValue = parseInt(currentValue);

        // page 1

        if (currentPage == 1 && currentValue > 1) {

            var action = $(".pagination form").attr('action');
            action += 'page/' + $('.pagination input').val() + '/';
            $(".pagination form").attr('action', action);

        }

        if (currentPage == 1 && currentValue == 1) {

            var action = $(".pagination form").attr('action');
            var actionLength = action.length;
            var pagePosition = action.indexOf('page');
            if (pagePosition != -1) {

                var forSubstraction = actionLength - pagePosition;

                action = action.slice(0, -forSubstraction);

                $(".pagination form").attr('action', action);

            }

        }

        // page > 1

        if (currentPage > 1 && currentValue == 1) {

            var action = $(".pagination form").attr('action');
            var actionLength = action.length;
            var pagePosition = action.indexOf('page');
            if (pagePosition != -1) {

                var forSubstraction = actionLength - pagePosition;

                action = action.slice(0, -forSubstraction);

                $(".pagination form").attr('action', action);

            }
        }


        if (currentPage > 1 && currentValue > 1) {

            var action = $(".pagination form").attr('action');
            var actionLength = action.length;
            var pagePosition = action.indexOf('page');
            if (pagePosition == -1) {

                $(".pagination form").attr('action', action + 'page/' + currentValue + '/');

            }

            if (pagePosition != -1) {

                var forSubstraction = actionLength - pagePosition;

                action = action.slice(0, -forSubstraction);

                $(".pagination form").attr('action', action + 'page/' + currentValue + '/');

            }

        }

    }


    function maxi_checka() {
        var maxi = $('.pagination input').attr('data-max');

        if ($('.pagination input').val() > maxi) {
            $('.pagination input').val(maxi);
        }
    }

    $('.pagination input').change(function (event) {
        rightAction();
        maxi_checka();
    });

    $('.pagination input').keyup(function (event) {
        rightAction();
        maxi_checka();
    });

    $(".pagination input").keypress(function (event) {

        if (event.which == 13) {
            //event.preventDefault();
            if ($('.pagination input').val() == int) {
                $("form").submit();
            }

        }
    });


    // lazy load

    $("img.lazy").lazyload({
        threshold: 200,
        effect: "fadeIn"
    });

    $("img.lazy").lazyload({
        container: $("#articles .post_list"),
        threshold: 200,
        effect: "fadeIn"
    });

    $("img.lazy").lazyload({
        container: $("#tutorials .post_list"),
        threshold: 200,
        effect: "fadeIn"
    });

    $("img.lazy").lazyload({
        container: $("#reviews .post_list"),
        threshold: 200,
        effect: "fadeIn"
    });

    $("img.lazy").lazyload({
        container: $("#insights .post_list"),
        threshold: 200,
        effect: "fadeIn",
        failure_limit: 11
        /* 			     event: "sporty" */
    });

    $("img.lazy").lazyload({
        container: $("#news_events .post_list"),
        threshold: 200,
        effect: "fadeIn",
        failure_limit: 11
        /* 			     event: "sporty" */
    });


    // Social numbers with sharrre jquery plugin and custom render function

    $('.all-count').sharrre({
        share: {
            twitter: true,
            facebook: true,
        },
        template: '{total}',
        shorterTotal: true,
        enableHover: false,
        render: function (api, options) {

            // get twitter and facebook numbers

            var twitter = parseInt(options.count.twitter, 10);
            var facebook = parseInt(options.count.facebook, 10);


            // finding the parent element for filling twitter and facebook links
            // and finding the views and comment numbers for calculation

            parent = $(api.element).parents('.social_interactions_inner').attr('id');

            // fill twitter and facebook links with numbers

            $('#' + parent + ' .twitter-count').text(twitter);
            $('#' + parent + ' .facebook-count').text(facebook);

            // get views and comments numbers

            views = parseInt($('#' + parent + ' .views').text(), 10);
            comments = parseInt($('#' + parent + ' .comments').text(), 10);


            // add all the numbers

            var all_numbers = twitter + facebook + views + comments;


            // if more then 999 shorten with K suffix like '1K' or '1.1K'

            if (all_numbers > 999) {

                result = Math.round((all_numbers / 1000) * 10) / 10 + 'K';

            } else {

                result = all_numbers;

            }


            // output result

            $(api.element).text(result);

        }

    });


    if ($('.entry-content a img').parent('a').length > 1) {

        $('.entry-content a img').parent('a').attr('data-lightbox-gallery', 'gallery');


    }

    $('.entry-content a img').parent('a').nivoLightbox().append('<span class="view">&nbsp;</span>');


    $('.next_prev_navigation').mouseover(function () {
        $(this).addClass('show_nav');
    }).mouseout(function () {
        $(this).removeClass('show_nav');
    });


    $('.social_interactions').mouseover(function () {

        if (!$(this).hasClass('closed')) {
            $(this).addClass('open');
        }

    }).mouseout(function () {

        if (!$(this).hasClass('closed')) {
            $(this).removeClass('open');
        }

    });


    // !--- Hotkeys -------

    if ($('body').hasClass('home')) {


        $(document).keydown(function (e) {

            // avoiding conflict with inputs

            if (!$("input").is(":focus")) {

                // popular articles

                if (e.keyCode === 80) {

                    myOffsetArticles = $("#articles").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetArticles
                    }, 1000);
                }

                if (e.keyCode === 84) {

                    myOffsetTutorials = $("#tutorials").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetTutorials
                    }, 1000);
                }

                if (e.keyCode === 73) {

                    myOffsetInsights = $("#insights").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetInsights
                    }, 1000);
                }

                if (e.keyCode === 86) {

                    myOffsetInterviews = $("#interviews").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetInterviews
                    }, 1000);
                }

                if (e.keyCode === 78) {

                    myOffsetNews = $("#news_events").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetNews
                    }, 1000);
                }

                if (e.keyCode === 82) {

                    myOffsetReviews = $("#reviews").offset().top - 140;
                    $('html, body').animate({
                        scrollTop: myOffsetReviews
                    }, 1000);
                }

            }


        });


    }


    if ($.isFunction($.fn.clndr)) {

        // show calendar area

        $('#calendar_wrapper').removeClass('hidden');

        // pulling the workshop list to the left

        $('#scheduled').removeClass('lonely');


        // initiating the calendar

        var myEvents;

        var load_posts = function () {
            $.ajax({
                type: "GET",
                data: {},
                dataType: "json",
                url: "http://jointhebreed.com/wp/wp-content/themes/breed/ajax/clndr_events.php",
                success: function (data) {

                    //alert(data);
                    myEvents = data;
                    //alert(mEvents);
                    //console.log(myEvents);

                    theCal(myEvents);

                }
            });
        }

        load_posts();


        // var myEvents = [{"date":"2013-11-07"},{"date":"2013-11-20"}];

        function theCal(myEvents) {

            $('#calendar').clndr({

                events: myEvents,

                multiDayEvents: {

                    startDate: 'startDate',
                    endDate: 'endDate'

                },

                template: $('#clndr-template').html(),

                startWithMonth: moment(),


            });

        }


    }


    // Transforms headline in anchor and span

    function add_headline_anquor(my_headlines) {

        if (!$('#content').hasClass('page_content')) {

            $.each(my_headlines, function (i, e) {

                num = i + 1;

                headline_text = $(e).text();

                //console.log(headline_text);

                $(e).html('<span class="anchor"><a id="section_' + num + '">' + num + '</a></span><span class="headline_text">' + headline_text + '</span>');

            });

        }

    }

    add_headline_anquor($('.entry-content h2'));


    // Building the controls


    function article_controls() {

        // check if headlines exists

        var headlines_num = $('.entry-content h2').length;

        // if yes go further

        if (headlines_num !== 0) {


            // getting the headline in array

            var headlines = $('.entry-content h2');


            // perform for every headline

            $.each(headlines, function (index, element) {

                // Chapter number

                var chapterNum = index + 1;

                // Next chapter (for finding the first image later)

                var nextChapterNum = chapterNum + 1;

                // getting the headline text

                headlineText = $(element).find('.headline_text').text();

                //getting the parent - the h2 for finding easier the first image which is a sibling

                sectionHeadline = $('#section_' + chapterNum).parents('h2');

                // finding the first image after h2 and getting the src

                imageSrc = sectionHeadline.nextUntil($('h2')).find("img").first().attr('src');

                // checking the format (portrait or landscape) and set a class

                imageDim = sectionHeadline.nextUntil($('h2')).find("img").first();

                var imageDimWidth = $(imageDim).width();

                var imageDimHeight = $(imageDim).height();

                if (imageDimWidth > imageDimHeight) {
                    var imgClass = 'class="landscape" ';
                } else {
                    var imgClass = 'class="portrait" ';
                }

                // creating the html for the image

                var theImg = "";

                if (imageSrc) {
                    theImg = '<span class="img_wrapper"><img ' + imgClass + 'src="' + imageSrc + '" /></span>';
                }

                // Adding list element with number and headline

                $('.chapter-list').append('<li><a href="#section-' + chapterNum + '"><span class="section_num">' + chapterNum + '</span><span class="headline_content"><span>' + headlineText + '</span></span>' + theImg + '</a></li>');

            });

        }

    }

    article_controls();


    // Building section for sticky scrolling

    if (!$('#content').hasClass('page_content')) {

        function sticky_sections(headlines) {

            $.each(headlines, function (index, element) {

                var sectionNum = index + 1;
                var sectionID = 'id="section-' + sectionNum + '"';

                $(element).nextUntil($('h2')).wrapAll('<section class="section stickem-container"' + sectionID + '></section');

            });

            //$('.wp-caption').addClass("sticky-caption");
            $('.to_sidebar').addClass("sticky-caption");

        }

        sticky_sections($('.entry-content h2'));

    }


    // !--- Smooth scrolling for the anchors

    $('.chapter-list a').smoothScroll({offset: -200});


    // !--- Waypoints for posts

    function section_waypoints(sections) {

        $.each(sections, function (index, element) {

            var sectionNum = index + 1;

            sectionID = $(element).attr('id');
            //console.log(sectionID);


            $('#' + sectionID).waypoint(function (direction) {

                $active = $(this);

                //console.log($active);


                if (direction === "up") {
                    $active = $active.prevAll('.section').first();
                }

                // indicating the active section
                $('.chapter-list a.active').removeClass("active");
                $('.chapter-list a[href="#' + $active.attr('id') + '"]').addClass("active");

            }, {

                offset: 230,

            });

        });

    }

    section_waypoints($('.entry-content section'));


    // Navigation

    // stops click event when click on nav

    $('nav').click(function (event) {

        //console.log('click - nav');
        event.stopPropagation();

    });

    // closes form when click on body but not on nav

    $('html').click(function (event) {

        // console.log('click - body');

        if ($('html').hasClass("open_nav")) {
            $('html').removeClass('open_nav');
        }

    });

    // opens and closes nav

    $('.nav_toggle').click(function (event) {

        $('html').toggleClass('open_nav');

        // stops event here
        event.stopPropagation();

        return false;

    });


    // Search

    // stops click event when click on form

    $('#live_search').click(function (event) {

        //console.log('click - form');
        event.stopPropagation();

    });

    // closes form when click on body but not on form

    $('html').click(function (event) {

        //console.log('click - body');

        if ($('html').hasClass("open_search")) {
            $('html').removeClass('open_search');
        }

    });

    // opens and closes search

    $('.search_toggle').click(function (event) {

        $('html').toggleClass('open_search');

        // stops event here
        event.stopPropagation();

        return false;

    });


});

