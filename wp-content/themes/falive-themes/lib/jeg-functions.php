<?php

function jlog($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}


function jeg_check_tag_post($post_tags) {

    foreach($post_tags as $tag) {
        $query = new WP_Query( 'tag_id=' . $tag );
        if(!empty($query->posts)) return true;
    }
    return false;
}

function jeg_relatedpost($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
            'size' => 6
        ),
        $atts
    );

    $isempty = false;

    $html = '';
    $html .=
        '<aside class="aside-post">
                <h6 class="aside-heading">' . __('People Also Read', 'jmagz-plugin') . '</h6>
                    <div class="aside-post-list">';

    $category_ids = array();
    if ( has_category() ) {
        $categories = get_the_category();
        foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;
    }

    $args = array(
        'category__in'        => $category_ids,
        'showposts'           => $atts['size'],
        'ignore_sticky_posts' => 1,
        'post__not_in'        => array(get_the_ID())
    );

    add_filter('posts_where', 'filter_where_prev');
    $the_query = new WP_Query( $args );
    remove_filter( 'posts_where', 'filter_where_prev');
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) :
            $the_query->the_post();
            $html .= '<a href="' . get_permalink(get_the_ID()) . '" class="post-title">' . get_the_title() . '</a>';
        endwhile;
    } else {
        $isempty = true;
    }
    wp_reset_postdata();

    $html .= "</div>
        </aside>";

    if($isempty) {
        return null;
    } else {
        return $html;
    }
}

function filter_where_prev($where) {
    global $post;
    $where .= " AND ID < " . $post->ID;
    return $where;
}

function filter_where_next($where) {
    global $post;
    $where .= " AND ID > " . $post->ID;
    return $where;
}

function jeg_merge_array_r( array &$array1, array &$array2 ) {
    $merged = $array1;
    foreach ( $array2 as $key => &$value ) {
        if ( is_array( $value ) && isset ( $merged[$key] ) && is_array( $merged[$key] ) ) {
            $merged[$key] = $this->__merge_array_r( $merged[$key], $value );
        } else {
            $merged[$key] = $value;
        }
    }
    return $merged;
}

function jeg_is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function jeg_get_image_src($id, $size = 'full') {
    if (!empty($id) && (ctype_digit($id) || is_int($id)) ) {
        $image = wp_get_attachment_image_src($id, $size);
        return $image[0];
    }
    return false;
}

function jeg_populate_social() {
    $socialarray = array();

    // Facebook
    if(vp_option('joption.social_facebook', 'http://fb.me/jegtheme')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-facebook',
            'class' => 'social-facebook',
            'url'   => vp_option('joption.social_facebook', 'http://fb.me/jegtheme'),
            'text'  => 'Facebook'
        );
    }

    // Twitter
    if(vp_option('joption.social_twitter', 'http://twitter.com/jegtheme')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-twitter',
            'class' => 'social-twitter',
            'url'   => vp_option('joption.social_twitter', 'http://twitter.com/jegtheme'),
            'text'  => 'Twitter'
        );
    }

    // Linkedin
    if(vp_option('joption.social_linkedin')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-linkedin',
            'class' => 'social-linkedin',
            'url'   => vp_option('joption.social_linkedin'),
            'text'  => 'Linked In'
        );
    }

    // Google Plus
    if(vp_option('joption.social_googleplus', 'https://www.google.com/+Jegtheme')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-google-plus',
            'class' => 'social-googleplus',
            'url'   => vp_option('joption.social_googleplus', 'https://www.google.com/+Jegtheme'),
            'text'  => 'Google Plus'
        );
    }

    // Pinterest
    if(vp_option('joption.social_pinterest', 'https://www.pinterest.com/jegtheme/')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-pinterest',
            'class' => 'social-pinterest',
            'url'   => vp_option('joption.social_pinterest', 'https://www.pinterest.com/jegtheme/'),
            'text'  => 'Pinterest'
        );
    }

    // Behance
    if(vp_option('joption.social_behance', 'https://www.behance.net/jegtheme')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-behance',
            'class' => 'social-behance',
            'url'   => vp_option('joption.social_behance', 'https://www.behance.net/jegtheme'),
            'text'  => 'Behance'
        );
    }

    // Github
    if(vp_option('joption.social_github')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-github',
            'class' => 'social-github',
            'url'   => vp_option('joption.social_github'),
            'text'  => 'Github'
        );
    }

    // Flickr
    if(vp_option('joption.social_flickr')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-flickr',
            'class' => 'social-flickr',
            'url'   => vp_option('joption.social_flickr'),
            'text'  => 'Flickr'
        );
    }

    // Tumblr
    if(vp_option('joption.social_tumblr')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-tumblr',
            'class' => 'social-tumblr',
            'url'   => vp_option('joption.social_tumblr'),
            'text'  => 'Tumblr'
        );
    }

    // Dribbble
    if(vp_option('joption.social_dribbble')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-dribbble',
            'class' => 'social-dribbble',
            'url'   => vp_option('joption.social_dribbble'),
            'text'  => 'Dribbble'
        );
    }

    // Soundcloud
    if(vp_option('joption.social_soundcloud')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-soundcloud',
            'class' => 'social-soundcloud',
            'url'   => vp_option('joption.social_soundcloud'),
            'text'  => 'Soundcloud'
        );
    }

    // instagram
    if(vp_option('joption.social_instagram')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-instagram',
            'class' => 'social-instagram',
            'url'   => vp_option('joption.social_instagram'),
            'text'  => 'Instagram'
        );
    }

    // Vimeo
    if(vp_option('joption.social_vimeo')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-vimeo-square',
            'class' => 'social-vimeo',
            'url'   => vp_option('joption.social_vimeo'),
            'text'  => 'Vimeo'
        );
    }

    // Youtube
    if(vp_option('joption.social_youtube')) {
        $socialarray[] = array(
            'icon'  => 'fa fa-youtube',
            'class' => 'social-youtube',
            'url'   => vp_option('joption.social_youtube'),
            'text'  => 'youtube'
        );
    }

    return $socialarray;
}

function jeg_social_icon($withtext = false, $class = '') {

    $socials = jeg_populate_social();
    if (empty($socials)) return false;

    $html = '<ul class="socials '. $class .'">';
    foreach($socials as $social) {
        if($withtext) {
            $html .= "<li><a target='_blank' rel='nofollow' href='" . $social['url'] . "' class='" . $social['class'] . "'><i class='" . $social['icon'] . "'></i>" . $social['text'] . "</a></li>";
        } else {
            $html .= "<li><a target='_blank' rel='nofollow' href='" . $social['url'] . "' class='" . $social['class'] . "'><i class='" . $social['icon'] . "'></i></a></li>";
        }

    }
    $html .= "</ul>";

    return $html;
}

function jeg_post_class( $id = '' ) {
    $class = 'short-content';

    if ( is_singular() && !is_page_template( 'template-home.php' ) )
        $class = 'full-content enable-pin-share';
    elseif ( (is_archive() || is_home()) && vp_option('joption.archives_content_type', 'excerpt') == 'full' )
        $class = 'full-content';
    elseif ( is_page_template( 'template-home.php' ) && vp_metabox('jeg_blogcontent.content_type', 'excerpt', $id) == 'full' )
        $class = 'full-content';


    return $class;
}

// Font Customizer
function jeg_get_googlefont() {

    $fonts_list            = array();
    $fonts_weight_list     = array();
    $fonts_json            = wp_remote_get( get_template_directory_uri() . '/lib/customizer/data/gwf.json');
    $fonts                 = json_decode( $fonts_json['body'], true );
    $fonts_list['default'] = 'Theme Default';

    foreach ( $fonts['items'] as $key => $value ) {
        $item_family                     = $fonts['items'][$key]['family'];
        $fonts_list[$item_family]        = $item_family;
        $fonts_weight_list[$item_family] = $fonts['items'][$key]['variants'];
    }

    return array(
        'fonts_list' => $fonts_list,
        'fonts_weight_list' => $fonts_weight_list
    );
}

function jeg_get_googlefont_weight( $fontname, $fontlist ) {
    if ( empty( $fontname ) )
        return array();

    $fontweights = array(
        '100'       => __( 'Ultra Light', 'jeg_textdomain' ),
        '100italic' => __( 'Ultra Light Italic', 'jeg_textdomain' ),
        '200'       => __( 'Light', 'jeg_textdomain' ),
        '200italic' => __( 'Light Italic', 'jeg_textdomain' ),
        '300'       => __( 'Book', 'jeg_textdomain' ),
        '300italic' => __( 'Book Italic', 'jeg_textdomain' ),
        'regular'   => __( 'Regular', 'jeg_textdomain' ),
        'italic'    => __( 'Italic', 'jeg_textdomain' ),
        '500'       => __( 'Medium', 'jeg_textdomain' ),
        '500italic' => __( 'Medium Italic', 'jeg_textdomain' ),
        '600'       => __( 'Semi-Bold', 'jeg_textdomain' ),
        '600italic' => __( 'Semi-Bold Italic', 'jeg_textdomain' ),
        '700'       => __( 'Bold', 'jeg_textdomain' ),
        '700italic' => __( 'Bold Italic', 'jeg_textdomain' ),
        '800'       => __( 'Extra Bold', 'jeg_textdomain' ),
        '800italic' => __( 'Extra Bold Italic', 'jeg_textdomain' ),
        '900'       => __( 'Ultra Bold', 'jeg_textdomain' ),
        '900italic' => __( 'Ultra Bold Italic', 'jeg_textdomain' )
    );

    if ( $fontname == 'default' )
        return $fontweights;

    $result = array();
    foreach ($fontlist['fonts_weight_list'][$fontname] as $key) {
        $result[ $key ] = $fontweights[ $key ];
    }

    return $result;
}

function jeg_custom_excerpt_length( $limit ) {
    $content = wp_strip_all_tags( get_the_excerpt(), true );
    echo wp_trim_words( $content, $limit );
}

if( ! function_exists('jeg_get_query_paged')) {
    function jeg_get_query_paged() {
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $page = ( get_query_var('page') ) ? get_query_var('page') : 1;
        return ( $paged > $page ) ? $paged : $page;
    }
}

function jeg_get_author_name( $author_id='' ) {
    $author_name = trim( get_the_author_meta( 'user_firstname', $author_id ) .' '. get_the_author_meta( 'user_lastname', $author_id ) );
    return empty( $author_name ) ? get_the_author_meta('user_nicename', $author_id) : $author_name;
}

function jeg_pagination_nomal($query) {
    global $wp_query;

    if ( !$query ) {
        $query = $wp_query;
    }

    $paged      = jeg_get_query_paged();
    $total_page = $query->max_num_pages;
    $big        = 999999999; // need an unlikely integer

    if($total_page > 1) :
        echo "<div class='paging'>";
        if($paged !== 1) echo "<a class='nav-normal nav-newer' href='" . get_pagenum_link($paged - 1) . "'><span>" . __("Newer", "jeg_textdomain") . "</span></a>";
        if($paged < $total_page) echo "<a class='nav-normal nav-older' href='" . get_pagenum_link($paged + 1) . "'><span>" . __("Older", "jeg_textdomain") . "</span></a>";
        echo "<div class='clear'></div>";
        echo "</div>";
    endif;
}

function jeg_pagination( $query = null ) {
    global $wp_query;

    if ( !$query ) {
        $query = $wp_query;
    }

    $paged      = jeg_get_query_paged();
    $total_page = $query->max_num_pages;
    $big        = 999999999; // need an unlikely integer

    $args = array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total'   => $total_page,
        'prev_text' => __('Prev', 'jeg_textdomain'),
        'next_text' => __('Next', 'jeg_textdomain'),
    );

    if ( $total_page > 1 ) : ?>
        <div class="paging">
            <?php echo paginate_links( $args ); ?>
            <span class="page-detail"><?php printf( __('Page %d of %d ', 'jeg_textdomain'), $paged, $total_page) ?></span>
        </div>
        <?php
    endif;
}

function jeg_build_statement() {
    $post_layout = vp_metabox('jeg_blogcontent.layout', 'normal');
    $post_count = apply_filters('jeg_blogcontent_masonry', vp_metabox('jeg_blogcontent.post_limit', 5));

    if($post_layout === 'masonry') {
        $post_count = apply_filters('jeg_blogcontent_masonry', vp_metabox('jeg_blogcontent.post_limit', 5));
    }

    $paged = jeg_get_query_paged();
    $statement = array(
        'post_type'             => 'post',
        'orderby'               => "date",
        'order'                 => "DESC",
        'paged'                 => $paged,
        'posts_per_page'        => $post_count,
    );

    if(vp_metabox('jeg_blogcontent.filter_post') === '1')
    {
        $filter = vp_metabox('jeg_blogcontent.jeg_filter_post.0');
        $filter_rule = $filter['filter_rule'] == 'include' ? 'in' : 'not_in';

        if($filter['filter_type'] === 'category')
        {
            $statement['category__'. $filter_rule] = $filter['filter_category'];
        } else if($filter['filter_type'] === 'tags')
        {
            $statement['tag__'. $filter_rule] = $filter['filter_tags'];
        }
    }

    return $statement;
}

function jeg_video_type($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}

function jeg_generate_random_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function jeg_generate_google_ads()
{
    $adshtml = '<div class="promocentered">';

    $publisherid    = vp_option('joption.top_menu_ads_google_publisher');
    $slotid         = vp_option('joption.top_menu_ads_google_id');

    $desktopsize_ad     = array('728','90');
    $tabsize_ad         = array('468','60');
    $phonesize_ad       = array('320', '50');

    $desktopsize    = vp_option('joption.top_menu_ads_google_desktop');
    $tabsize        = vp_option('joption.top_menu_ads_google_tab');
    $phonesize      = vp_option('joption.top_menu_ads_google_phone');

    if($desktopsize !== 'auto') $desktopsize_ad = explode('x', $desktopsize);
    if($tabsize !== 'auto') $tabsize_ad = explode('x', $tabsize);
    if($phonesize !== 'auto') $phonesize_ad = explode('x', $phonesize);

    $adshtml .= "<div class=\"\">\n";
    $randomstring = jeg_generate_random_string();

    $adshtml .= "<style type='text/css' scoped>\n";

    if($desktopsize !== 'hide') {
        $adshtml .= ".adsslot_{$randomstring}{ width:{$desktopsize_ad[0]}px !important; height:{$desktopsize_ad[1]}px !important; background: black; }\n";
    } else {
        $adshtml .= ".adsslot_{$randomstring}{ display: none !important; }\n";
    }
    if($tabsize !== 'hide') {
        $adshtml .= "@media (max-width:1199px) { .adsslot_{$randomstring}{ width:{$tabsize_ad[0]}px !important; height:{$tabsize_ad[1]}px !important; } }\n";
    } else {
        $adshtml .= "@media (max-width:1199px) { .adsslot_{$randomstring}{ display: none !important; } }\n";
    }
    if($phonesize !== 'hide') {
        $adshtml .= "@media (max-width:767px) { .adsslot_{$randomstring}{ width:{$phonesize_ad[0]}px !important; height:{$phonesize_ad[1]}px !important; } }\n";
    } else {
        $adshtml .= "@media (max-width:767px) { .adsslot_{$randomstring}{ display: none !important; } }\n";
    }

    $adshtml .= "</style>\n\n";
    $adshtml .= "<ins class=\"adsbygoogle adsslot_{$randomstring}\" style=\"display:inline-block;\" data-ad-client=\"{$publisherid}\" data-ad-slot=\"{$slotid}\"></ins>\n";
    $adshtml .= "<script async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>\n";
    $adshtml .= "<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>\n";
    $adshtml .= '</div>';
    $adshtml .= '</div>';

    echo $adshtml;
}


function jeg_get_ads_size() {
    return array(
        array( 'value' => 'auto',           'label' => 'Auto' ),
        array( 'value' => 'hide',           'label' => 'Hide' ),
        array( 'value' => '120x90' ,        'label' => '120 x 90'),
        array( 'value' => '120x240' ,       'label' => '120 x 240'),
        array( 'value' => '120x600' ,       'label' => '120 x 600'),
        array( 'value' => '125x125' ,       'label' => '125 x 125'),
        array( 'value' => '160x90' ,        'label' => '160 x 90'),
        array( 'value' => '160x600' ,       'label' => '160 x 600'),
        array( 'value' => '180x90' ,        'label' => '180 x 90'),
        array( 'value' => '180x150' ,       'label' => '180 x 150'),
        array( 'value' => '200x90' ,        'label' => '200 x 90'),
        array( 'value' => '200x200' ,       'label' => '200 x 200'),
        array( 'value' => '234x60' ,        'label' => '234 x 60'),
        array( 'value' => '250x250' ,       'label' => '250 x 250'),
        array( 'value' => '320x100' ,       'label' => '320 x 100'),
        array( 'value' => '300x250' ,       'label' => '300 x 250'),
        array( 'value' => '300x600' ,       'label' => '300 x 600'),
        array( 'value' => '320x50' ,        'label' => '320 x 50'),
        array( 'value' => '336x280' ,       'label' => '336 x 280'),
        array( 'value' => '468x15' ,        'label' => '468 x 15'),
        array( 'value' => '468x60' ,        'label' => '468 x 60'),
        array( 'value' => '728x15' ,        'label' => '728 x 15'),
        array( 'value' => '728x90' ,        'label' => '728 x 90'),
        array( 'value' => '970x90' ,        'label' => '970 x 90'),
        array( 'value' => '240x400' ,       'label' => '240 x 400'),
        array( 'value' => '250x360' ,       'label' => '250 x 360'),
        array( 'value' => '580x400' ,       'label' => '580 x 400'),
        array( 'value' => '750x100' ,       'label' => '750 x 100'),
        array( 'value' => '750x200' ,       'label' => '750 x 200'),
        array( 'value' => '750x300' ,       'label' => '750 x 300'),
        array( 'value' => '980x120' ,       'label' => '980 x 120'),
        array( 'value' => '930x180' ,       'label' => '930 x 180')
    );
}

function jeg_home_masonry_excerpt_length () { return 30; }
function jeg_home_excerpt_length () { return 90; }
function jeg_home_excerpt_more () { return ""; }
function jeg_slider_excerpt () { return 25; }
function jeg_slider_latest_more () { return "..."; }
function jeg_slider_excerpt_longer () { return 30; }