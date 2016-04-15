<?php get_header(); ?>

<!-- content -->
<div id="post-wrapper" class="normal">
    <div class="container">
        <div class="notfound">
            <div class="notfoundfirst"><?php _e( 'Error 404', 'jeg_textdomain' ) ?></div>
            <div class="notfoundsec">
                <p><?php _e( "It look like the page you're looking for doesn't exist, sorry", 'jeg_textdomain' ) ?></p>
                <div><?php get_search_form(); ?></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>