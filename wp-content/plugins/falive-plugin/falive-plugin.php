<?php
/*
	Plugin Name: Falive Plugin
	Plugin URI: http://jegtheme.com/
	Description: Mandatory Plugin for Falive Themes
	Version: 1.0.2
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'FALIVE_PLUGIN_VERSION' ) 	        or define( 'FALIVE_PLUGIN_VERSION', '1.0.2' );
defined( 'FALIVE_PLUGIN_URL' ) 		        or define( 'FALIVE_PLUGIN_URL', plugins_url('falive-plugin'));
defined( 'FALIVE_PLUGIN_FILE' ) 		    or define( 'FALIVE_PLUGIN_FILE',  __FILE__ );
defined( 'FALIVE_PLUGIN_DIR' ) 		        or define( 'FALIVE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

function jeg_falive_plugin_load() {
    if( defined('JEG_PLUGIN_VERSION') ) {
        require_once FALIVE_PLUGIN_DIR . '/lib/additional-widget.php';
    }
}
add_action('plugins_loaded', 'jeg_falive_plugin_load');

function falive_load_textdomain()
{
    $domain = 'falive-plugin';
    $jeg_lang_dir = dirname( plugin_basename( FALIVE_PLUGIN_FILE ) ) . '/lang/';

    // Traditional WordPress plugin locale filter
    $locale        = apply_filters( 'plugin_locale',  get_locale(), $domain );
    $mofile        = sprintf( '%1$s-%2$s.mo', $domain, $locale );

    // Setup paths to current locale file
    $mofile_local  = $jeg_lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/' . $domain . '/' . $mofile;


    if ( file_exists( $mofile_global ) ) {
        load_textdomain( $domain, $mofile_global );
    } elseif ( file_exists( $mofile_local ) ) {
        load_textdomain( $domain, $mofile_local );
    } else {
        load_plugin_textdomain( $domain, false, $jeg_lang_dir );
    }
}
add_action('init', 'falive_load_textdomain');

function jeg_get_popular_posts_falive($instance) {
    // default array defined
    $defaults = array(
        'title' => '',
        'limit' => 10,
        'range' => 'monthly',
        'freshness' => false,
        'order_by' => 'views',
        'post_type' => 'post,page',
        'pid' => '',
        'author' => '',
        'cat' => '',
        'shorten_title' => array(
            'active' => false,
            'length' => 25,
            'words' => false
        ),
        'post-excerpt' => array(
            'active' => false,
            'length' => 55,
            'keep_format' => false,
            'words' => false
        ),
        'thumbnail' => array(
            'active' => false,
            'build' => 'manual',
            'width' => 15,
            'height' => 15,
            'crop' => true
        ),
        'rating' => false,
        'stats_tag' => array(
            'comment_count' => false,
            'views' => true,
            'author' => false,
            'date' => array(
                'active' => false,
                'format' => 'F j, Y'
            ),
            'category' => false
        ),
    );

    global $wpdb;

    $instance = jeg_merge_array_r(
        $defaults,
        $instance
    );

    $prefix = $wpdb->prefix . "popularposts";
    $fields = "p.ID AS 'id', p.post_title AS 'title', p.post_date AS 'date', p.post_author AS 'uid'";
    $from = "";
    $where = "WHERE 1 = 1";
    $orderby = "";
    $groupby = "";
    $limit = "LIMIT {$instance['limit']}";

    $post_types = "";
    $pids = "";
    $cats = "";
    $authors = "";
    $content = "";

    $now = current_time('mysql');

    // post filters
    // * freshness - get posts published within the selected time range only
    if ( $instance['freshness'] ) {
        switch( $instance['range'] ){
            case "daily":
                $where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 DAY) ";
                break;

            case "weekly":
                $where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 WEEK) ";
                break;

            case "monthly":
                $where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 MONTH) ";
                break;

            default:
                $where .= "";
                break;
        }
    }

    // * post types - based on code seen at https://github.com/williamsba/WordPress-Popular-Posts-with-Custom-Post-Type-Support
    $types = explode(",", $instance['post_type']);
    $sql_post_types = "";
    $join_cats = true;

    // if we're getting just pages, why join the categories table?
    if ( 'page' == strtolower($instance['post_type']) ) {

        $join_cats = false;
        $where .= " AND p.post_type = '{$instance['post_type']}'";

    }
    // we're listing other custom type(s)
    else {

        if ( count($types) > 1 ) {

            foreach ( $types as $post_type ) {
                $sql_post_types .= "'{$post_type}',";
            }

            $sql_post_types = rtrim( $sql_post_types, ",");
            $where .= " AND p.post_type IN({$sql_post_types})";

        } else {
            $where .= " AND p.post_type = '{$instance['post_type']}'";
        }

    }

    // * posts exclusion
    if ( !empty($instance['pid']) ) {

        $ath = explode(",", $instance['pid']);

        $where .= ( count($ath) > 1 )
            ? " AND p.ID NOT IN({$instance['pid']})"
            : " AND p.ID <> '{$instance['pid']}'";

    }

    // * categories
    if ( !empty($instance['cat']) && $join_cats ) {

        $cat_ids = explode(",", $instance['cat']);
        $in = array();
        $out = array();
        $not_in = "";

        usort($cat_ids, 'jeg_sorter');

        for ($i=0; $i < count($cat_ids); $i++) {
            if ($cat_ids[$i] >= 0) $in[] = $cat_ids[$i];
            if ($cat_ids[$i] < 0) $out[] = $cat_ids[$i];
        }

        $in_cats = implode(",", $in);
        $out_cats = implode(",", $out);
        $out_cats = preg_replace( '|[^0-9,]|', '', $out_cats );

        if ($in_cats != "" && $out_cats == "") { // get posts from from given cats only
            $where .= " AND p.ID IN (
                        SELECT object_id
                        FROM {$wpdb->term_relationships} AS r
                             JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                             JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
                        WHERE x.taxonomy = 'category' AND t.term_id IN({$in_cats})
                        )";
        } else if ($in_cats == "" && $out_cats != "") { // exclude posts from given cats only
            $where .= " AND p.ID NOT IN (
                        SELECT object_id
                        FROM {$wpdb->term_relationships} AS r
                             JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                             JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
                        WHERE x.taxonomy = 'category' AND t.term_id IN({$out_cats})
                        )";
        } else { // mixed, and possibly a heavy load on the DB
            $where .= " AND p.ID IN (
                        SELECT object_id
                        FROM {$wpdb->term_relationships} AS r
                             JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                             JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
                        WHERE x.taxonomy = 'category' AND t.term_id IN({$in_cats})
                        ) AND p.ID NOT IN (
                        SELECT object_id
                        FROM {$wpdb->term_relationships} AS r
                             JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                             JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
                        WHERE x.taxonomy = 'category' AND t.term_id IN({$out_cats})
                        )";
        }

    }

    // * authors
    if ( !empty($instance['author']) ) {

        $ath = explode(",", $instance['author']);

        $where .= ( count($ath) > 1 )
            ? " AND p.post_author IN({$instance['author']})"
            : " AND p.post_author = '{$instance['author']}'";

    }

    // All-time range
    if ( "all" == $instance['range'] ) {

        $fields .= ", p.comment_count AS 'comment_count'";

        // order by comments
        if ( "comments" == $instance['order_by'] ) {

            $from = "{$wpdb->posts} p";
            $where .= " AND p.comment_count > 0 AND p.post_password = '' AND p.post_status = 'publish'";
            $orderby = " ORDER BY p.comment_count DESC";

            // get views, too
            if ( $instance['stats_tag']['views'] ) {

                $fields .= ", IFNULL(v.pageviews, 0) AS 'pageviews'";
                $from .= " LEFT JOIN {$prefix}data v ON p.ID = v.postid";

            }

        }
        // order by (avg) views
        else {

            $from = "{$prefix}data v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";
            $where .= " AND p.post_password = '' AND p.post_status = 'publish'";

            // order by views
            if ( "views" == $instance['order_by'] ) {

                $fields .= ", v.pageviews AS 'pageviews'";
                $orderby = "ORDER BY pageviews DESC";

            }
            // order by avg views
            elseif ( "avg" == $instance['order_by'] ) {

                $fields .= ", ( v.pageviews/(IF ( DATEDIFF('{$now}', MIN(v.day)) > 0, DATEDIFF('{$now}', MIN(v.day)), 1) ) ) AS 'avg_views'";
                $groupby = "GROUP BY v.postid";
                $orderby = "ORDER BY avg_views DESC";

            }

        }

        $query = "SELECT {$fields} FROM {$from} {$where} {$groupby} {$orderby} {$limit};";

    } else { // CUSTOM RANGE

        $interval = "";

        switch( $instance['range'] ){
            case "daily":
                $interval = "1 DAY";
                break;

            case "weekly":
                $interval = "1 WEEK";
                break;

            case "monthly":
                $interval = "1 MONTH";
                break;

            default:
                $interval = "1 DAY";
                break;
        }

        // order by comments
        if ( "comments" == $instance['order_by'] ) {
            $fields .= ", c.comment_count AS 'comment_count'";
            $from = "(SELECT comment_post_ID AS 'id', COUNT(comment_post_ID) AS 'comment_count' FROM {$wpdb->comments} WHERE comment_date_gmt > DATE_SUB('{$now}', INTERVAL {$interval}) AND comment_approved = 1 GROUP BY id ORDER BY comment_count DESC) c LEFT JOIN {$wpdb->posts} p ON c.id = p.ID";
            $where .= " AND p.post_password = '' AND p.post_status = 'publish'";

            if ( $instance['stats_tag']['views'] ) { // get views, too

                $fields .= ", IFNULL(v.pageviews, 0) AS 'pageviews'";
                $from .= " LEFT JOIN (SELECT postid, SUM(pageviews) AS pageviews FROM {$prefix}summary WHERE last_viewed > DATE_SUB('{$now}', INTERVAL {$interval}) GROUP BY postid) v ON p.ID = v.postid";

            }
        }
        // ordered by views / avg
        else {
            $from = "(SELECT postid, IFNULL(SUM(pageviews), 0) AS pageviews FROM {$prefix}summary WHERE last_viewed > DATE_SUB('{$now}', INTERVAL {$interval}) GROUP BY postid ORDER BY pageviews DESC) v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";
            $where .= " AND p.post_password = '' AND p.post_status = 'publish'";

            // ordered by views
            if ( "views" == $instance['order_by'] ) {
                $fields .= ", v.pageviews AS 'pageviews'";
            }
            // ordered by avg views
            elseif ( "avg" == $instance['order_by'] ) {

                $fields .= ", ( v.pageviews/(IF ( DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})) > 0, DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})), 1) ) ) AS 'avg_views' ";
                $groupby = "GROUP BY v.postid";
                $orderby = "ORDER BY avg_views DESC";

            }
            // get comments, too
            if ( $instance['stats_tag']['comment_count'] ) {

                $fields .= ", IFNULL(c.comment_count, 0) AS 'comment_count'";
                $from .= " LEFT JOIN (SELECT comment_post_ID AS 'id', COUNT(comment_post_ID) AS 'comment_count' FROM {$wpdb->comments} WHERE comment_date_gmt > DATE_SUB('{$now}', INTERVAL {$interval}) AND comment_approved = 1 GROUP BY id) c ON p.ID = c.id";

            }
        }

        $query = "SELECT {$fields} FROM {$from} {$where} {$groupby} {$orderby} {$limit};";

    }

    $result = $wpdb->get_results($query);
    return $result;
}
add_filter('jeg_get_popular_posts', 'jeg_get_popular_posts_falive', null, 1);