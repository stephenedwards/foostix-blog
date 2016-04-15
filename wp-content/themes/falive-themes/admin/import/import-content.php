<?php

function jeg_import_view() { ?>

    <h2>Import Dummy Data</h2>

    <?php echo jeg_import_notice(); ?>

    <p>Before importing content, please read several notice for importing content. </p>
    <div class="jeg-dummydata">
        <ul>
            <li>You can use dummy data to learn how this themes work.</li>
            <li>Menu will be recreated.</li>
            <li>Widget content will be replaced with demo widget.</li>
            <li>Demo content not included within demo content due to copyright of those image.</li>
            <li>Please make sure that your server able to do outbound request, we need to download some image that used on demo.</li>
            <li>Using this import, you won't have double content of import content.</li>
            <li>Please wait until Process is finished. and please leave your browser open during import process. Closing Browser will stop the import process</li>
        </ul>
    </div>


    <?php if ( is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) { ?>
    <div class="disable-wp-importer"><strong>[IMPORTANT]</strong> Our Import Dummy Data will not work correctly when WordPress Importer enabled. Please disable WordPress Importer Plugin first.</div>
    <?php } else { ?>
    <form class="jeg-import-form" method="post">
        <input type="hidden" name="jeg-nonce" value="<?php echo wp_create_nonce('jeg-dummy-import'); ?>" />
        <input name="reset" class="jeg-dummydata-button" type="submit" value="Import Dummy Data" />
        <input type="hidden" value="jeg-dummy-import" name="action" />
    </form>
    <?php } ?>


    <style>
        .jeg-dummydata ul {
            margin-left: 20px;
        }
        .jeg-dummydata ul li, .jeg-demonotice ul li {
            list-style: disc;
        }
        .jeg-dummydata-button, .jeg-dummydata-button:hover {
            background: none repeat scroll 0 0 #2ea2cc;
            box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15);
            color: #fff;
            text-decoration: none;
            height: 30px;
            line-height: 28px;
            margin: 0;
            padding: 0 12px;
            border-radius: 3px;
            border: 1px solid #0074a2;
            cursor: pointer;
            display: inline-block;
            font-size: 13px;
            white-space: nowrap;
        }
        .jeg-import-form {
            margin-bottom: 30px;
            margin-top: 30px;
        }
        .jeg-demonotice {
            background: none repeat scroll 0 0 #e5fafd;
            border: 1px solid #ccc;
            margin: 10px 10px 10px 0;
            padding: 5px 20px;
        }
        .jeg-demonotice > ul {
            padding-left: 20px;
        }
        .disable-wp-importer {
            background: none repeat scroll 0 0 #ddd;
            border: 2px solid;
            color: red;
            padding: 20px;
        }
        .import-notice {
            display: list-item;
            font-size: 14px;
            font-style: italic;
            font-weight: bold;
            margin-left: 20px;
        }
    </style>
    <?php

    if(  isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'jeg-dummy-import' && check_admin_referer('jeg-dummy-import' , 'jeg-nonce')){
        defined( 'WP_LOAD_IMPORTERS' ) or define('WP_LOAD_IMPORTERS', true);
        require_once ABSPATH . 'wp-admin/includes/import.php';
        $importer_error = false;

        if ( !class_exists( 'WP_Importer' ) ) {
            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            if ( file_exists( $class_wp_importer ) ){
                require_once($class_wp_importer);
            }
            else {
                $importer_error = true;
            }
        }

        if ( !class_exists( 'WP_Import' ) ) {
            $class_wp_import = JEG_PLUGIN_DIR . '/importer/wordpress-importer.php';
            if ( file_exists( $class_wp_import ) ) {
                require_once($class_wp_import);
            }
            else {
                $importer_error = true;
            }
        }

        if($importer_error){
            die("Error in import :(");
        } else {
            if(!is_file( get_template_directory() . '/admin/import/data/dummy.xml')){
                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";
            }
            else {
                jeg_prepare_import();

                ob_start();
                $wp_import = new WP_Import();
                $wp_import->fetch_attachments = true;
                $wp_import->import( get_template_directory() . '/admin/import/data/dummy.xml');
                ob_end_clean();
                jeg_create_notice("Finish Import Dummy Data");

                jeg_end_import();
            }
        }
    }
}

function jeg_create_notice($notice){
    echo "<div class='import-notice'>$notice</div><br/>";
}

function jeg_prepare_import() {

    // prevent double menu

    $termarray = array();
    $termarray[0] = get_term_by('name','Primary Menu', 'nav_menu');
    $termarray[1] = get_term_by('name','Mobile Menu', 'nav_menu');

    foreach($termarray as $term) {
        if(is_object($term)) {
            wp_delete_nav_menu($term->term_id);
        }
    }

}

function jeg_import_notice() {
    $shownotice = true;
    $noticelist = '<li>If you already have content on your website, please consider to use this dummy data on other WordPress installation that having no content.</li>';

    if($shownotice) {
        return '<div class="jeg-demonotice"><p>Dummy data notice : </p><ul>' . $noticelist . '</ul></div>';
    }
}

function jeg_panel_import()
{
    global $joptionglobal;

    ob_start();
    locate_template(array('admin/import/data/backend.json'), true, true);
    $content = ob_get_contents();
    ob_end_clean();

    $joptionglobal->import_option($content);
}

function jeg_set_menu_location()
{
    $mainmenu = get_term_by('name','Main Menu', 'nav_menu');

    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $mainmenu->term_id;
    $locations['mobile'] = $mainmenu->term_id;

    set_theme_mod( 'nav_menu_locations', $locations );
}


function jeg_add_widget_to_sidebar($sidebarSlug, $widgetSlug, $countMod, $widgetSettings = array())
{
    $sidebarSlug = sanitize_title($sidebarSlug);
    $sidebarOptions = get_option('sidebars_widgets');

    if(!isset($sidebarOptions[$sidebarSlug])){
        $sidebarOptions[$sidebarSlug] = array();
    }

    $newWidget = get_option('widget_'.$widgetSlug);
    if(!is_array($newWidget))$newWidget = array();
    $count = count($newWidget) + 1 + $countMod;
    $sidebarOptions[$sidebarSlug][] = $widgetSlug.'-'.$count;

    $newWidget[$count] = $widgetSettings;

    update_option('sidebars_widgets', $sidebarOptions);
    update_option('widget_'.$widgetSlug, $newWidget);
}

function reset_widget_content() {
    $sidebarOptions = get_option('sidebars_widgets');

    foreach($sidebarOptions as $sidebar_name => $sidebar_value) {
        if(is_array($sidebar_value)) {
            unset($sidebarOptions[$sidebar_name]);
            $sidebarOptions[$sidebar_name] = array();
        }
    }

    update_option('sidebars_widgets', $sidebarOptions);
}

function jeg_set_widget()
{
    reset_widget_content();

    // main sidebar
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'search', 0, array('title' => ''));
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'jeg_about_me', 1,
        array(
            'title' => 'WELCOME & BOUNJOUR',
            'aboutimg' => 'http://falive.jegtheme.com/wp-content/uploads/2015/05/person-beach-holiday-vacation-small.jpg',
            'aboutdesc' => 'Kreuzberg Apartment to talk with him about his career and his influences. In his award-winning thesis work, a photo series titled “Leuchtpunktordnungen"',
        )
    );
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'jr_insta_slider', 2,
        array(
            'title' => 'Instagram Feed',
            'username' => 'anna_dello_russo',
            'source' => 'media_library',
            'attachment' => 1,
            'template' => 'thumbs',
            'image_size' => 'thumbnail',
            'orderby' => 'rand',
            'images_link' => 'image_url',
            'images_number' => '9',
            'columns' => '3',
            'refresh_hour' => '5'
        )
    );
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'pw_board_widget', 3,
        array(
            'title' => 'Pinterest',
            'board_url' => 'https://id.pinterest.com/lauragiberson/my-style/',
            'board_size' => 'custom',
            'custom_width' => '85',
            'custom_height' => '300',
            'custom_board_width' => '290',
        )
    );
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'jeg_ads_widget', 4,
        array(
            'title' => 'Website Promo',
            'adsimage' => 'http://jmagz.jegtheme.com/wp-content/uploads/2015/02/300x250.png',
            'adsurl' => 'http://bit.ly/jkreativ/',
        )
    );
    jeg_add_widget_to_sidebar(JEG_SIDEBAR_WIDGET, 'jeg_last_post', 5,
        array(
            'title' => 'Latest Post',
            'lastnumber' => '4',
        )
    );


    // footer sidebar
    jeg_add_widget_to_sidebar(JEG_FOOTER_WIDGET_1, 'jeg_about_me', 0,
        array(
            'title' => 'About Blog',
            'aboutimg' => 'http://falive.jegtheme.com/wp-content/uploads/2015/05/camera-photography-vintage-technology-small.jpg',
            'aboutdesc' => 'Kreuzberg Apartment to talk with him about his career and his influences. In his award-winning thesis work, a photo series titled “Leuchtpunktordnungen"',
        )
    );
    jeg_add_widget_to_sidebar(JEG_FOOTER_WIDGET_2, 'jr_insta_slider', 2,
        array(
            'title' => 'Instagram Feed',
            'username' => 'anna_dello_russo',
            'source' => 'media_library',
            'attachment' => 1,
            'template' => 'thumbs',
            'image_size' => 'thumbnail',
            'orderby' => 'rand',
            'images_link' => 'image_url',
            'images_number' => '9',
            'columns' => '3',
            'refresh_hour' => '5'
        )
    );
    jeg_add_widget_to_sidebar(JEG_FOOTER_WIDGET_3, 'jeg_facebook_fans_widget', 0,
        array(
            'title' => 'Facebook Fans',
            'facebookurl' => 'http://www.facebook.com/jegtheme',
        )
    );

}

function jeg_set_homepage() {
    update_option('show_on_front', 'page');

    $homepage = get_page_by_title('Home Page');
    update_option('page_on_front', $homepage->ID);

    $helloworld = get_page_by_title('Hello world!', OBJECT, 'post');
    if($helloworld) {
        wp_delete_post($helloworld->ID, false);
    }
}

function jeg_end_import()
{
    // set widget
    jeg_set_widget();
    jeg_create_notice("Finish Import Widget");


    // import panel
    jeg_panel_import();
    jeg_create_notice("Finish Import Theme Panel Setting");


    // set home page
    jeg_set_homepage();

    // set menu location
    jeg_set_menu_location();
    jeg_create_notice("Finish Import Menu Location");

    echo "<h3>Congratulation, Import Finished!</h3>";
}