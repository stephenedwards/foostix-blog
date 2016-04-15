<?php

add_action('wp_enqueue_scripts', 'jeg_init_style');
add_action('wp_enqueue_scripts', 'jeg_favicon');
add_action('wp_enqueue_scripts', 'jeg_init_fonts');
add_action('wp_enqueue_scripts', 'jeg_init_script');
add_action('wp_head', 'jeg_html5shim');
add_action('wp_head', 'jeg_customizer_style');
add_action('wp_footer', 'jeg_additional_script');

/* ------------------------------------------------------------------------- *
 *  Load CSS
/* ------------------------------------------------------------------------- */
function jeg_init_style() {
    if(!jeg_is_login_page()) {

        $templateurl = get_template_directory_uri();

        wp_enqueue_style('wp-mediaelement',       null, JEG_VERSION);
        wp_enqueue_style('jeg-fontawesome',    $templateurl .'/css/fontawesome/css/font-awesome.min.css', null, JEG_VERSION);
        wp_enqueue_style('jeg-flexslider',     $templateurl .'/css/flexslider/flexslider.css', null, JEG_VERSION);
        wp_enqueue_style('jeg-owlcarousel',    $templateurl .'/css/owl-carousel/owl.carousel.css', null, JEG_VERSION);
        wp_enqueue_style('jeg-owltheme',       $templateurl .'/css/owl-carousel/owl.theme.css', null, JEG_VERSION);
        wp_enqueue_style('jeg-owltransitions', $templateurl .'/css/owl-carousel/owl.transitions.css', null, JEG_VERSION);
        wp_enqueue_style('jeg-main',           get_stylesheet_uri() , null, JEG_VERSION);
        wp_enqueue_style('jeg-responsive',     $templateurl .'/css/responsive.css', null, JEG_VERSION);

    }
}


/* ------------------------------------------------------------------------- *
 *  Load Javascripts
/* ------------------------------------------------------------------------- */
function jeg_init_script () {

    jeg_register_script();

    if(!jeg_is_login_page()) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wp-mediaelement' );
        wp_enqueue_script( 'jeg-main' );
        wp_enqueue_script( 'jeg-hoverintent' );
        wp_enqueue_script( 'jeg-flexslider' );
        wp_enqueue_script( 'jeg-owlcarousel' );
        wp_enqueue_script( 'jeg-events' );
        wp_enqueue_script( 'jeg-mutate' );
        wp_enqueue_script( 'jeg-jfollowsidebar' );
        wp_enqueue_script( 'jeg-waypoints' );

        // Homepage
        if (is_page_template( 'template-home.php' ) || vp_option('joption.archives_content_layout') == 'masonry' ) {
            wp_enqueue_script( 'jeg-isotope' );
            wp_enqueue_script( 'jeg-imagesloaded' );
        }

        wp_localize_script('jeg-main', 'joption', jeg_get_admin_js_option());
    }
}


function jeg_get_admin_js_option() {
    $option = array();
    $option['shareto'] = __('Share Article to ','jeg_textdomain');
    $option['sticky'] = apply_filters('jeg_sticky_header', vp_option('joption.sticky_menu'));
    return $option;
}

function jeg_register_script() {

    $templateurl = get_template_directory_uri();

    wp_register_script( 'jeg-main',           $templateurl .'/js/main.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-hoverintent',    $templateurl .'/js/jquery.hoverIntent.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-flexslider',     $templateurl .'/js/jquery.flexslider-min.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-owlcarousel',    $templateurl .'/js/owl.carousel.min.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-events',         $templateurl .'/js/mutate/events.min.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-mutate',         $templateurl .'/js/mutate/mutate.min.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-jfollowsidebar', $templateurl .'/js/jquery.jfollowsidebar.js', null, JEG_VERSION, true);
    // wp_register_script( 'jeg-mediaelement',   $templateurl .'/js/mediaelement-and-player.min.js', null, JEG_VERSION, true);
    wp_register_script( 'jeg-html5shiv',      $templateurl . '/js/html5shiv.js', null, JEG_VERSION, true );
    wp_register_script( 'jeg-isotope',        $templateurl . '/js/jquery.isotope.min.js', null, JEG_VERSION, true );
    wp_register_script( 'jeg-imagesloaded',   $templateurl . '/js/imagesloaded.pkgd.min.js', null, JEG_VERSION, true );
    wp_register_script( 'jeg-waypoints',      $templateurl . '/js/waypoints.js', null, JEG_VERSION, true );

    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}

function jeg_html5shim () {
    global $is_IE;

    if ($is_IE) :
        echo "<!--[if lt IE 9]>\n";
        echo '<script src="'. get_template_directory_uri() . "/js/html5shiv.min.js\"></script>\n";
        echo "<![endif]-->";
    endif;
}

/* ------------------------------------------------------------------------- *
 *  Load Favicon
/* ------------------------------------------------------------------------- */
function jeg_favicon() {
    $favicon   = vp_option('joption.favicon', get_template_directory_uri() .'/images/favicon.ico');

    echo '<link rel="shortcut icon" href="'. esc_url( $favicon ) .'" type="image/x-icon">'.
         '<link rel="icon" href="'. esc_url( $favicon ) .'" type="image/x-icon">';
}

/* ------------------------------------------------------------------------- *
 *  Fonts Customizer
/* ------------------------------------------------------------------------- */

// url example : https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Playfair+Display:400normal,italic
function jeg_init_fonts() {
    $fonts = jeg_get_mods_fonts();

    foreach ( $fonts as $key => $font ) {
        if ( $fonts[$key] === 'default' || empty($fonts[ $key ]) ) {
            unset( $fonts[ $key ] );
            continue;
        }
        $fonts[ $key ] = $fonts[ $key ] . ":400,400italic,700";
    }

    if ( ! empty($fonts) )
        echo '<link id="jeg-font-cuztomizer" href="http://fonts.googleapis.com/css?family='. urlencode( implode( "|", array_unique($fonts) ) ) .'&subset=latin,latin-ext" rel="stylesheet" type="text/css">';
}

function jeg_cuztomize_fonts() {
    $fonts = jeg_get_mods_fonts(); ?>

    <?php if( $fonts['body'] != 'default' && !empty($fonts['body']) ) : ?>
    /*** Global Font ***/
        body, input, textarea, button, select, label {
            font-family: <?php echo esc_attr( $fonts['body'] ) ?>;
        }
    <?php endif; ?>

    <?php if( $fonts['heading'] != 'default' && !empty($fonts['heading']) ) : ?>
    /*** Heading ***/
        article .content-title, .meta-article-header, .widget h1.widget-title, .footerwidget-title h3, .entry h1, .entry h2, .entry h3, .entry h4, .entry h5, .entry h6, article .content-meta, .line-heading, h1, h2, h3, h4, h5,h6, .category-header span
        {
            font-family: <?php echo esc_attr( $fonts['heading'] ) ?>;
        }
    <?php endif; ?>

    <?php if( $fonts['menu'] != 'default' && !empty($fonts['menu']) ) : ?>
    /*** Menu ***/
        #heading .navigation, #heading .mobile-menu, .second-footer .footer-nav {
            font-family: <?php echo esc_attr( $fonts['menu'] ) ?>;
        }
    <?php endif;
}

function jeg_get_fontweight( $fontweightstyle ) {
    $fontweight = '400';
    $fontstyle  = 'normal';

    if ( $fontweightstyle == 'regular' ) {
        $fontweight = '400';
    } elseif ( $fontweightstyle == 'italic' ) {
        $fontweight = '400';
        $fontstyle  = 'italic';
    } elseif ( strpos( $fontweightstyle, 'italic' ) ) {
        $fontweight = str_replace( 'italic', '', $fontweightstyle );
        $fontstyle  = 'italic';
    } ?>

    font-weight: <?php echo esc_attr( $fontweight ) ?>;
    font-style: <?php echo esc_attr( $fontstyle ) ?>;

    <?php
}

function jeg_get_mods_fonts() {

    $fonts = array(
        'body' => get_theme_mod( 'font_family_body' ),
        'heading' => get_theme_mod( 'font_family_heading' ),
        'menu' => get_theme_mod( 'font_family_menu' ),
    );


    if( $fonts['body'] === 'default' || empty($fonts['body']) ) $fonts['body'] = 'Droid Serif';
    if( $fonts['heading'] === 'default' || empty($fonts['heading'])) $fonts['heading'] = 'Playfair Display';
    if( $fonts['menu'] === 'default' || empty($fonts['menu']))  $fonts['menu'] = 'Lato';


    return $fonts;
}

/* ------------------------------------------------------------------------- *
 *  Customizer Style
/* ------------------------------------------------------------------------- */
function jeg_customizer_style() { ?>
    <style type="text/css">

    <?php if ( get_theme_mod( 'text_color' ) ) { ?>body {color: <?php echo get_theme_mod( 'text_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'link_color' ) ) { ?>a {color: <?php echo get_theme_mod( 'link_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'link_hover_color' ) ) { ?>a:hover {color: <?php echo get_theme_mod( 'link_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'button_color' ) ) { ?>
    #popular-post .popular-excerpt .popular-category  a, .tag-wrapper > a, .entry a { color: <?php echo get_theme_mod( 'button_color' ) ?>; }
    .subscribe-footer .sml_submit, .subscribe-footer .sml_submit:hover,
    input[type="submit"], button[type="submit"], input[type="submit"]:hover, button[type="submit"]:hover { background: <?php echo get_theme_mod( 'button_color' ) ?>; border: 1px solid <?php echo get_theme_mod( 'button_color' ) ?>; }
    article .content-meta a:hover { color: <?php echo get_theme_mod( 'button_color' ) ?>; }
    article.short-content .readmore, article.short-content .more-link, .article-masonry-box .readmore  { background: <?php echo get_theme_mod( 'button_color' ) ?>; }
    <?php } ?>

    /***  HEADER LAYOUT 1  ***/
    #heading.first-nav .logo-wrapper a {padding: <?php echo get_theme_mod( 'header1_logo_padding_top', 80 ) ?>px 0 <?php echo get_theme_mod( 'header1_logo_padding_bottom', 60 ) ?>px}
    <?php if ( get_theme_mod( 'header1_bg' ) ) { ?>#heading.first-nav .logo-wrapper {background: <?php echo get_theme_mod( 'header1_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header1_menubar_bg' ) ) { ?>#heading.first-nav .nav-wrapper {background: <?php echo get_theme_mod( 'header1_menubar_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_menu_color' ) ) { ?>#heading.first-nav .navigation > ul > li > a {color: <?php echo get_theme_mod( 'header1_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_menu_hover_color' ) ) { ?>#heading.first-nav .navigation > ul > li:hover > a {color: <?php echo get_theme_mod( 'header1_menu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_menu_hover_bg' ) ) { ?>#heading.first-nav .navigation > ul > li:hover {background: <?php echo get_theme_mod( 'header1_menu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header1_submenu_bg' ) ) { ?>#heading.first-nav .navigation .sub-menu {background: <?php echo get_theme_mod( 'header1_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_submenu_line' ) ) { ?>#heading.first-nav .navigation .sub-menu li{border-bottom: 1px solid <?php echo get_theme_mod( 'header1_submenu_line' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_submenu_color' ) ) { ?>#heading.first-nav .navigation .sub-menu li a {color: <?php echo get_theme_mod( 'header1_submenu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_submenu_hover_color' ) ) { ?>#heading.first-nav .navigation .sub-menu li:hover > a {color: <?php echo get_theme_mod( 'header1_submenu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_submenu_hover_bg' ) ) { ?>#heading.first-nav .navigation .sub-menu li:hover {background: <?php echo get_theme_mod( 'header1_submenu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header1_search_color' ) ) { ?>#heading.first-nav .nav-search i {color: <?php echo get_theme_mod( 'header1_search_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_search_bg' ) ) { ?>#heading.first-nav .nav-search {background: <?php echo get_theme_mod( 'header1_search_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header1_social_color' ) ) { ?>#heading.first-nav .nav-social li a {color: <?php echo get_theme_mod( 'header1_social_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_social_hover_color' ) ) { ?>#heading.first-nav .nav-social li a:hover {color: <?php echo get_theme_mod( 'header1_social_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header1_social_hover_bg' ) ) { ?>#heading.first-nav .nav-social li a:hover {background: <?php echo get_theme_mod( 'header1_social_hover_bg' ) ?>;}<?php } ?>

    /***  HEADER LAYOUT 2  ***/
    <?php if ( get_theme_mod( 'header2_height' ) ) { ?>#heading.second-nav .navigation > ul > li, #heading.second-nav .navigation > ul > li > a, #heading.second-nav .logo-wrapper, #heading.second-nav .nav-search i, #heading.second-nav .mobile-navigation i {line-height: <?php echo get_theme_mod( 'header2_height' ) ?>px;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_bg' ) ) { ?>#heading.second-nav .nav-wrapper {background: <?php echo get_theme_mod( 'header2_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header2_menu_color' ) ) { ?>#heading.second-nav .navigation > ul > li > a {color: <?php echo get_theme_mod( 'header2_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_menu_hover_color' ) ) { ?>#heading.second-nav .navigation > ul > li:hover > a {color: <?php echo get_theme_mod( 'header2_menu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_menu_hover_bg' ) ) { ?>#heading.second-nav .navigation > ul > li:hover {background: <?php echo get_theme_mod( 'header2_menu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header2_submenu_bg' ) ) { ?>#heading.second-nav .navigation .sub-menu {background: <?php echo get_theme_mod( 'header2_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_submenu_line' ) ) { ?>#heading.second-nav .navigation .sub-menu li{border-bottom: 1px solid <?php echo get_theme_mod( 'header2_submenu_line' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_submenu_color' ) ) { ?>#heading.second-nav .navigation .sub-menu li a {color: <?php echo get_theme_mod( 'header2_submenu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_submenu_hover_color' ) ) { ?>#heading.second-nav .navigation .sub-menu li:hover > a {color: <?php echo get_theme_mod( 'header2_submenu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_submenu_hover_bg' ) ) { ?>#heading.second-nav .navigation .sub-menu li:hover {background: <?php echo get_theme_mod( 'header2_submenu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header2_search_color' ) ) { ?>#heading.second-nav .nav-search i {color: <?php echo get_theme_mod( 'header2_search_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header2_search_bg' ) ) { ?>#heading.second-nav .nav-search {background: <?php echo get_theme_mod( 'header2_search_bg' ) ?>;}<?php } ?>

    /***  HEADER LAYOUT 3  ***/
    #heading.third-nav .logo-wrapper {padding: <?php echo get_theme_mod( 'header3_logo_padding_top', 80 ) ?>px 0 <?php echo get_theme_mod( 'header3_logo_padding_bottom', 80 ) ?>px}
    <?php if ( get_theme_mod( 'header3_bg' ) ) { ?>#heading.third-nav .logo-wrapper {background: <?php echo get_theme_mod( 'header3_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header3_menubar_bg' ) ) { ?>#heading.third-nav .nav-container {background: <?php echo get_theme_mod( 'header3_menubar_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_menu_color' ) ) { ?>#heading.third-nav .navigation > ul > li > a {color: <?php echo get_theme_mod( 'header3_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_menu_hover_color' ) ) { ?>#heading.third-nav .navigation > ul > li:hover > a {color: <?php echo get_theme_mod( 'header3_menu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_menu_hover_bg' ) ) { ?>#heading.third-nav .navigation > ul > li:hover {background: <?php echo get_theme_mod( 'header3_menu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header3_submenu_bg' ) ) { ?>#heading.third-nav .navigation .sub-menu {background: <?php echo get_theme_mod( 'header3_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_submenu_line' ) ) { ?>#heading.third-nav .navigation .sub-menu li{border-bottom: 1px solid <?php echo get_theme_mod( 'header3_submenu_line' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_submenu_color' ) ) { ?>#heading.third-nav .navigation .sub-menu li a {color: <?php echo get_theme_mod( 'header3_submenu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_submenu_hover_color' ) ) { ?>#heading.third-nav .navigation .sub-menu li:hover > a {color: <?php echo get_theme_mod( 'header3_submenu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_submenu_hover_bg' ) ) { ?>#heading.third-nav .navigation .sub-menu li:hover {background: <?php echo get_theme_mod( 'header3_submenu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header3_search_color' ) ) { ?>#heading.third-nav .nav-search i {color: <?php echo get_theme_mod( 'header3_search_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_search_bg' ) ) { ?>#heading.third-nav .nav-search {background: <?php echo get_theme_mod( 'header3_search_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header3_social_color' ) ) { ?>#heading.third-nav .nav-social li a {color: <?php echo get_theme_mod( 'header3_social_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_social_hover_color' ) ) { ?>#heading.third-nav .nav-social li a:hover {color: <?php echo get_theme_mod( 'header3_social_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header3_social_hover_bg' ) ) { ?>#heading.third-nav .nav-social li a:hover {background: <?php echo get_theme_mod( 'header3_social_hover_bg' ) ?>;}<?php } ?>

    /***  HEADER LAYOUT 4  ***/
    #heading.four-nav .logo-wrapper {padding: <?php echo get_theme_mod( 'header4_logo_padding_top', 80 ) ?>px 0 <?php echo get_theme_mod( 'header4_logo_padding_bottom', 80 ) ?>px}
    <?php if ( get_theme_mod( 'header4_bg' ) ) { ?>#heading.four-nav .nav-wrapper {background: <?php echo get_theme_mod( 'header4_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header4_menubar_bg' ) ) { ?>#heading.four-nav .nav-container {background: <?php echo get_theme_mod( 'header4_menubar_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_menu_color' ) ) { ?>#heading.four-nav .navigation > ul > li > a {color: <?php echo get_theme_mod( 'header4_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_menu_hover_color' ) ) { ?>#heading.four-nav .navigation > ul > li:hover > a {color: <?php echo get_theme_mod( 'header4_menu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_menu_hover_bg' ) ) { ?>#heading.four-nav .navigation > ul > li:hover {background: <?php echo get_theme_mod( 'header4_menu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header4_submenu_bg' ) ) { ?>#heading.four-nav .navigation .sub-menu {background: <?php echo get_theme_mod( 'header4_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_submenu_line' ) ) { ?>#heading.four-nav .navigation .sub-menu li{border-bottom: 1px solid <?php echo get_theme_mod( 'header4_submenu_line' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_submenu_color' ) ) { ?>#heading.four-nav .navigation .sub-menu li a {color: <?php echo get_theme_mod( 'header4_submenu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_submenu_hover_color' ) ) { ?>#heading.four-nav .navigation .sub-menu li:hover > a {color: <?php echo get_theme_mod( 'header4_submenu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_submenu_hover_bg' ) ) { ?>#heading.four-nav .navigation .sub-menu li:hover {background: <?php echo get_theme_mod( 'header4_submenu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header4_search_color' ) ) { ?>#heading.four-nav .nav-search i {color: <?php echo get_theme_mod( 'header4_search_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_search_bg' ) ) { ?>#heading.four-nav .nav-search {background: <?php echo get_theme_mod( 'header4_search_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header4_social_color' ) ) { ?>#heading.four-nav .nav-social li a {color: <?php echo get_theme_mod( 'header4_social_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_social_hover_color' ) ) { ?>#heading.four-nav .nav-social li a:hover {color: <?php echo get_theme_mod( 'header4_social_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header4_social_hover_bg' ) ) { ?>#heading.four-nav .nav-social li a:hover {background: <?php echo get_theme_mod( 'header4_social_hover_bg' ) ?>;}<?php } ?>

    /***  HEADER LAYOUT 5  ***/
    #heading.fifth-nav .logo-wrapper {padding: <?php echo get_theme_mod( 'header5_logo_padding_top', 80 ) ?>px 0 <?php echo get_theme_mod( 'header5_logo_padding_bottom', 80 ) ?>px}
    <?php if ( get_theme_mod( 'header5_bg' ) ) { ?>#heading.fifth-nav .top-wrapper {background: <?php echo get_theme_mod( 'header5_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header5_menubar_bg' ) ) { ?>#heading.fifth-nav .nav-wrapper {background: <?php echo get_theme_mod( 'header5_menubar_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_menu_color' ) ) { ?>#heading.fifth-nav .navigation > ul > li > a {color: <?php echo get_theme_mod( 'header5_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_menu_hover_color' ) ) { ?>#heading.fifth-nav .navigation > ul > li:hover > a {color: <?php echo get_theme_mod( 'header5_menu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_menu_hover_bg' ) ) { ?>#heading.fifth-nav .navigation > ul > li:hover {background: <?php echo get_theme_mod( 'header5_menu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header5_submenu_bg' ) ) { ?>#heading.fifth-nav .navigation .sub-menu {background: <?php echo get_theme_mod( 'header5_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_submenu_line' ) ) { ?>#heading.fifth-nav .navigation .sub-menu li{border-bottom: 1px solid <?php echo get_theme_mod( 'header5_submenu_line' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_submenu_color' ) ) { ?>#heading.fifth-nav .navigation .sub-menu li a {color: <?php echo get_theme_mod( 'header5_submenu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_submenu_hover_color' ) ) { ?>#heading.fifth-nav .navigation .sub-menu li:hover > a {color: <?php echo get_theme_mod( 'header5_submenu_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_submenu_hover_bg' ) ) { ?>#heading.fifth-nav .navigation .sub-menu li:hover {background: <?php echo get_theme_mod( 'header5_submenu_hover_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header5_search_color' ) ) { ?>#heading.fifth-nav .nav-search i {color: <?php echo get_theme_mod( 'header5_search_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_search_bg' ) ) { ?>#heading.fifth-nav .nav-search {background: <?php echo get_theme_mod( 'header5_search_bg' ) ?>;}<?php } ?>

    <?php if ( get_theme_mod( 'header5_social_color' ) ) { ?>#heading.fifth-nav .nav-social li a {color: <?php echo get_theme_mod( 'header5_social_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_social_hover_color' ) ) { ?>#heading.fifth-nav .nav-social li a:hover {color: <?php echo get_theme_mod( 'header5_social_hover_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'header5_social_hover_bg' ) ) { ?>#heading.fifth-nav .nav-social li a:hover {background: <?php echo get_theme_mod( 'header5_social_hover_bg' ) ?>;}<?php } ?>

    /***  MOBILE  ***/
    <?php if ( get_theme_mod( 'mobile_menu_bg' ) ) { ?>#heading .mobile-menu {background: <?php echo get_theme_mod( 'mobile_menu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'mobile_menu_color' ) ) { ?>#heading .mobile-menu a {color: <?php echo get_theme_mod( 'mobile_menu_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'mobile_submenu_bg' ) ) { ?>#heading .mobile-menu .sub-menu li {background: <?php echo get_theme_mod( 'mobile_submenu_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'mobile_menu_line' ) ) { ?>#heading .mobile-menu a {border-top: <?php echo get_theme_mod( 'mobile_menu_line' ) ?>;}<?php } ?>

    /***  SIDEBAR  ***/
    <?php if ( get_theme_mod( 'sidebar_heading_color' ) ) { ?>.widget .widget-title {color: <?php echo get_theme_mod( 'sidebar_heading_color' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'sidebar_heading_bg' ) ) { ?>.widget .widget-title span:after, .widget .widget-title span:before {border-top-color: <?php echo get_theme_mod( 'sidebar_heading_bg' ) ?>;}<?php } ?>

    /***  FOOTER  ***/
    <?php if ( get_theme_mod( 'footer_bg' ) ) { ?>.first-footer, .second-footer .footer-bottom {background: <?php echo get_theme_mod( 'footer_bg' ) ?>;}<?php } ?>
    <?php if ( get_theme_mod( 'footer_text_color' ) ) { ?>.footer-bottom .social-copy span {color: <?php echo get_theme_mod( 'footer_text_color' ) ?>;}<?php } ?>

    /***  WEBSITE BACKGROUND  ***/
    <?php if( get_theme_mod('website_color_background') ) { ?>body { background-color: <?php echo get_theme_mod('website_color_background'); ?>; }<?php } ?>
    <?php if( get_theme_mod('website_image_background') ) {
        $backgroundimage = get_theme_mod('website_image_background');
        if(ctype_digit($backgroundimage) || is_int($backgroundimage)) {
            $backgroundimage = jeg_get_image_src($backgroundimage, "full"); ?>

            body { background-image: url('<?php echo esc_html( $backgroundimage ); ?>'); }
            <?php if( get_theme_mod('website_background_repeat') ) { ?>body { background-repeat: <?php echo get_theme_mod('website_background_repeat'); ?>; }<?php } ?>
            <?php if( get_theme_mod('website_background_fullscreen') ) { ?>
                body { background-attachment: fixed; -webkit-background-size: cover; -o-background-size: cover; -moz-background-size: cover; background-size: cover; }
            <?php } ?>

            body { background-position: <?php echo get_theme_mod('website_background_vertical_position', 'center'); ?> <?php echo get_theme_mod('website_background_horizontal_position', 'center'); ?>; }
            <?php
        }
    }
    ?>

    /***  CUSTOM FONTS  ***/
    <?php echo esc_attr( jeg_cuztomize_fonts() ); ?>

    /***  CUSTOM CSS  ***/
    <?php if( vp_option('joption.custom_css') ) { echo vp_option('joption.custom_css'); }?>

    </style><?php
}

/* ------------------------------------------------------------------------- *
 *  Additional Script
/* ------------------------------------------------------------------------- */
function jeg_additional_script() {
    echo "<script>\n" . vp_option('joption.custom_js') . "\n</script>\n";
}