<?php if ( has_post_thumbnail() ) : ?>
    <div class="feature-holder">
        <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('half-featured') ?>
        </a>
    </div>
<?php endif; ?>