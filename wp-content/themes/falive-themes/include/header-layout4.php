<?php
    $logo   = apply_filters('jeg_logo_4', vp_option('joption.logo', get_template_directory_uri() .'/images/logo.png'));
    $logo2x = apply_filters('jeg_logo_4_retina', vp_option('joption.logo_retina', get_template_directory_uri() .'/images/logo@2x.png'));

    $logo_mobile   = apply_filters('jeg_logo_mobile', vp_option('joption.logo_mobile', get_template_directory_uri() .'/images/logo.png'));
    $logo_mobile2x = apply_filters('jeg_logo_mobile_retina', vp_option('joption.logo_mobile_retina', get_template_directory_uri() .'/images/logo@2x.png'));
?>
    <!-- heading v4 -->
    <div id="heading" class="four-nav">
        <div class="nav-wrapper">
            <div class="container">
                <div class="logo-wrapper">
                    <a title="<?php bloginfo('name'); ?>" href="<?php echo home_url(); ?>">
                        <img class="logo-desktop" src="<?php echo esc_url( $logo ); ?>" data-at2x="<?php echo esc_url( $logo2x ); ?>" alt="<?php bloginfo('name'); ?>">
                        <img class="logo-mobile"  src="<?php echo esc_url( $logo_mobile ); ?>" data-at2x="<?php echo esc_url( $logo_mobile2x ); ?>" alt="<?php bloginfo('name'); ?>">
                    </a>
                </div>
                <div class="iklan-wrapper">
                    <?php if ( vp_option('joption.header_ads_type', 'image') == 'image' ) : ?>
                        <a href="<?php echo vp_option('joption.header_ads_url', '#') ?>"><img src="<?php echo vp_option('joption.header_ads_image', get_template_directory_uri() .'/images/ads_header.png') ?>"/></a>
                    <?php else: ?>
                        <?php jeg_generate_google_ads(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="nav-helper"></div>
            <div class="nav-container">
                <div class="nav-wrapper">
                    <div class="container group">

                        <div class="mobile-navigation">
                            <i class="fa fa-bars"></i>
                        </div>

                        <div class="mobile-menu">
                            <?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'mobile' , 'fallback_cb' => false ) ); ?>
                        </div>

                        <div class="nav-search">
                            <i class="fa fa-search"></i>
                            <div class="searchbox">
                                <?php get_search_form(); ?>
                            </div>
                        </div>

                        <div class="navigation">
                            <?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'primary', 'fallback_cb' => false ) ); ?>
                        </div>

                        <div class="nav-social">
                            <?php echo jeg_social_icon(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- heading v4 ended -->