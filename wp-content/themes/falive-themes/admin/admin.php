<?php

/** Init Admin */

// Add additional add button on widget
defined('JEG_WIDGET_NAME')      or define('JEG_WIDGET_NAME', 'jeg-widget-list');
defined('JEG_SIDEBAR_WIDGET')   or define('JEG_SIDEBAR_WIDGET', 'Sidebar Widget');
defined('JEG_FOOTER_WIDGET_1')  or define('JEG_FOOTER_WIDGET_1', 'Footer Widget 1');
defined('JEG_FOOTER_WIDGET_2')  or define('JEG_FOOTER_WIDGET_2', 'Footer Widget 2');
defined('JEG_FOOTER_WIDGET_3')  or define('JEG_FOOTER_WIDGET_3', 'Footer Widget 3');

if( defined('JEG_PLUGIN_VERSION') ) {
    locate_template(array('admin/import/import-content.php'), true, true);
    locate_template(array('admin/admin-functions.php'), true, true); // Theme Option
    locate_template(array('admin/init-dashboard.php'), true, true);  // Theme Option
    locate_template(array('admin/init-widget.php'), true, true);     // Theme Option
    locate_template(array('admin/init-metabox.php'), true, true);    // Metabox
}