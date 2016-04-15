<div class="footer-margin"></div>

<?php
    $footer_text = vp_option('joption.footer_text', '&copy; Jegtheme 2014. All rights reserved' );

    if(vp_option('joption.show_subscribe_footer')) {
?>
    <div class="subscribe-footer">
        <h1><?php _e('SUBSCRIBE', 'jeg_textdomain'); ?></h1>
        <p><?php _e('Subscribe now to get notified about exclusive offers from Jegthemes every Weeks!', 'jeg_textdomain'); ?></p>
        <form class="sml_subscribe" method="post">
            <input class="sml_hiddenfield" name="sml_subscribe" value="1" type="hidden">
            <input class="sml_emailinput" name="sml_email" placeholder="<?php _e('Your email address','jeg_textdomain'); ?>" value="Your e-mail" type="text">
            <input class="sml_submit" name="sml_submit" type="submit" value="<?php _e('Submit','jeg_textdomain'); ?>">
        </form>
    </div>
<?php
    }
?>
        <div id="footer" class="second-footer">
            <div class="footer-widget">
                <div class="container clearfix">
                    <div class="grid one-third">
                        <?php /* Footer Widget 1 */ if ( is_active_sidebar( JEG_FOOTER_WIDGET_1 ) ) dynamic_sidebar( JEG_FOOTER_WIDGET_1 ) ?>
                    </div>
                    <div class="grid one-third">
                        <?php /* Footer Widget 2 */ if ( is_active_sidebar( JEG_FOOTER_WIDGET_2 ) ) dynamic_sidebar( JEG_FOOTER_WIDGET_2 ) ?>
                    </div>
                    <div class="grid one-third last">
                        <?php /* Footer Widget 3 */ if ( is_active_sidebar( JEG_FOOTER_WIDGET_3 ) ) dynamic_sidebar( JEG_FOOTER_WIDGET_3 ) ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="social-copy">
                        <span><?php echo wp_kses_post( $footer_text );?></span>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

    </div><!-- /#wrapper -->
    <?php wp_footer() ?>
</body>
</html>