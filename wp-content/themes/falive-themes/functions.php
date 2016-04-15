<?php


if(!defined('JEG_PLUGIN_VERSION')) {
    if(!function_exists('vp_option')) { function vp_option($key, $default = null){ return $default; } }
    if(!function_exists('vp_metabox')) { function vp_metabox($key, $default = null, $post_id = null){ return $default; } }
}

if(!defined('JEG_PLUGIN_VERSION') && !is_admin()) {
    if(!function_exists('vp_get_gwf_style')) { function vp_get_gwf_style() { return null; } }
    if(!function_exists('vp_get_gwf_weight')) { function vp_get_gwf_weight() { return null; } }
}


add_action('plugins_loaded', 'falive_plugin_check');

function jeg_init_variable()
{
    /* Theme Name */
    defined( 'JEG_THEMENAME' ) or define("JEG_THEMENAME", 'Falive');
    defined( 'JEG_SHORTNAME' ) or define("JEG_SHORTNAME", 'falive');
    defined( 'JEG_THEME' ) or define("JEG_THEME", 'jegtheme');

    /* themes version */
    $themeData          = wp_get_theme();
    $themeVersion       = trim($themeData['Version']);
    if (!$themeVersion)   $themeVersion = "1.1.1";
    define("JEG_VERSION"    , $themeVersion);

    // Localization Support
    load_theme_textdomain('jeg_textdomain', get_template_directory() . '/lang');

    // Support feed link
    add_theme_support( 'automatic-feed-links' );

    // Featured image
    add_theme_support( 'post-thumbnails' );

    // Support Post Types
    add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

    // Add Title Tag
    add_theme_support( 'title-tag' );

    // Thumbnail Size
    add_image_size( 'fullslider', 1280, 720, true );
    add_image_size( 'featured', 1080, 635, true );
    add_image_size( 'half-featured', 540, 317, true );
    add_image_size( 'popular-post', 348, 278, true );
    add_image_size( 'popup-post', 120, 120, true );

    // Unnecesary add
    if ( ! isset( $content_width ) ) $content_width = 620;
}

jeg_init_variable();


// Register Menu
function jeg_register_menu() {
    add_theme_support( 'menus' );
    if ( function_exists('register_nav_menu') ) {
        register_nav_menus( array(
            'primary' => 'Primary Menu',
            'mobile' => 'Mobile Menu'
        ) );
    }
}
add_action('after_setup_theme', 'jeg_register_menu');

function jeg_add_custom_mime_types($mimes){
    return array_merge($mimes,array (
        'ico'   => 'image/vnd.microsoft.icon',
    ));
}
add_filter('upload_mimes','jeg_add_custom_mime_types');

function jeg_add_author_socials( $socials ) {
    $socials = array(
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'google' => 'Google',
        'linkedin' => 'Linkedin',
    );
    return $socials;
}
add_filter('user_contactmethods','jeg_add_author_socials',10,1);


// alter size of post gallery
function jeg_gallery_shortcode($output, $attr){
    $attr['size'] = 'gallery-thumb';
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( ! $attr['orderby'] ) {
            unset( $attr['orderby'] );
        }
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery' );

    $id = intval( $atts['id'] );
    if ( 'RAND' == $atts['order'] ) {
        $atts['orderby'] = 'none';
    }

    if ( ! empty( $atts['include'] ) ) {
        $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( ! empty( $atts['exclude'] ) ) {
        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
        }
        return $output;
    }

    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
        $itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
        $captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
        $icontag = 'dt';
    }

    $columns = intval( $atts['columns'] );
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = '';

    /**
     * Filter whether to print default gallery styles.
     *
     * @since 3.1.0
     *
     * @param bool $print Whether to print default gallery styles.
     *                    Defaults to false if the theme supports HTML5 galleries.
     *                    Otherwise, defaults to true.
     */
    if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
        $gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
    }

    $size_class = sanitize_html_class( $atts['size'] );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    /**
     * Filter the default gallery shortcode CSS styles.
     *
     * @since 2.5.0
     *
     * @param string $gallery_style Default gallery shortcode CSS styles.
     * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
     */
    $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
            $image_output = wp_get_attachment_link( $id, $atts['size'], false, false );
        } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
            $image_output = wp_get_attachment_image( $id, $atts['size'], false );
        } else {
            $image_output = wp_get_attachment_link( $id, $atts['size'], true, false );
        }
        $image_meta  = wp_get_attachment_metadata( $id );

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
            $output .= '<br style="clear: both" />';
        }
    }

    if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
        $output .= "
			<br style='clear: both' />";
    }

    $output .= "
		</div>\n";

    return $output;

}
add_filter( 'post_gallery', 'jeg_gallery_shortcode', 10, 2 );


// Include Libraries
locate_template(array('admin/admin.php'), true, true);
locate_template(array('lib/scriptstyle.php'), true, true);
locate_template(array('lib/jeg-functions.php'), true, true);
locate_template(array('lib/jeg-customizer.php'), true, true);
locate_template(array('tgm/plugin-list.php'), true, true);
locate_template(array('lib/additional-widget.php'), true, true);
locate_template(array('lib/jtemplate.php'), true, true);
