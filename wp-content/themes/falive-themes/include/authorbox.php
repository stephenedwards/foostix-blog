<div class="author-box clearfix">
    <?php echo get_avatar( get_the_author_meta( 'ID' ), 150 ) ?>
    <div class="author-box-wrap">
        <h5><?php echo jeg_get_author_name(); ?></h5>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
            <p><?php the_author_meta( 'description' ); ?></p>
        <?php endif; ?>

        <?php if ( get_the_author_meta('user_url') ): ?>
            <p class="author-link"><i class="fa fa-link"></i>
                <a target="_blank" href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('user_url'); ?></a>
            </p>
        <?php endif ?>

        <div class="author-socials">
            <?php if ( get_the_author_meta( 'facebook' ) ): ?>
                <a href="<?php the_author_meta( 'facebook' ); ?>" rel="nofollow" class="facebook"><i class="fa fa-facebook-square"></i></a>
            <?php endif ?>
            <?php if ( get_the_author_meta( 'twitter' ) ): ?>
                <a href="<?php the_author_meta( 'twitter' ); ?>" rel="nofollow" class="twitter"><i class="fa fa-twitter"></i></a>
            <?php endif ?>
            <?php if ( get_the_author_meta( 'google' ) ): ?>
                <a href="<?php the_author_meta( 'google' ); ?>" rel="nofollow" class="google-plus"><i class="fa fa-google-plus"></i></a>
            <?php endif ?>
            <?php if ( get_the_author_meta( 'linkedin' ) ): ?>
                <a href="<?php the_author_meta( 'linkedin' ); ?>" rel="nofollow" class="linkedin"><i class="fa fa-linkedin"></i></a>
            <?php endif ?>
        </div>
    </div>
</div>