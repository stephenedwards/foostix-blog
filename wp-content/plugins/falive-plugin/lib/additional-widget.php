<?php
/*
 * @author jegbagus
 */

define('JEG_WIDGET_TEMPLATE_PATH'	, FALIVE_PLUGIN_DIR . '/lib/widget-template/');

/** base class of widget **/
abstract class Jeg_Widget extends WP_Widget
{
    protected $jtemplate;
    protected $fields;

    public function __construct($id_base = false, $name, $widget_options = array(), $control_options = array())
    {
        parent::__construct( $id_base,$name , $widget_options , $control_options );
        $this->jtemplate = new JTemplate(JEG_WIDGET_TEMPLATE_PATH, '.php');
    }

    public function render_form($fields, $instance) {

        foreach ($fields as $key => $field) :

            //** type text widget input **/
            if($field['type'] == 'type-text') {
                $this->jtemplate->render('type-text', array(
                    'title'		=> $field['title'] ,
                    'desc'		=> $field['desc'] ,
                    'fieldid'	=> $this->get_field_id( $key ) ,
                    'fieldname'	=> $this->get_field_name( $key ) ,
                    'value'		=> isset($instance[$key]) ? $instance[$key] : ''
                ), true);
            }

            if($field['type'] == 'type-textarea') {
                $this->jtemplate->render('type-textarea', array(
                    'title'		=> $field['title'] ,
                    'desc'		=> $field['desc'] ,
                    'fieldid'	=> $this->get_field_id( $key ) ,
                    'fieldname'	=> $this->get_field_name( $key ) ,
                    'value'		=> isset($instance[$key]) ? $instance[$key] : ''
                ), true);
            }

        endforeach;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        foreach ($this->fields as $key => $field) :
            $instance[$key] = wp_kses_post( $new_instance[$key] );
        endforeach;

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $this->render_form($this->fields, $instance);
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;
        if ( ! empty( $title ) )
            echo $before_title . esc_html( $title ) . $after_title;
        $this->jtemplate->render( $this->get_widget_template() , $instance, true);

        echo $after_widget;
    }

    abstract protected function get_widget_template();
}

/** Register widget **/
function jeg_register_widget () {
    register_widget("jeg_facebook_fans_widget");
    register_widget("jeg_ads_widget");
    register_widget("jeg_twitter_widget");
    register_widget("jeg_twitter_box_widget");
    register_widget("jeg_about_me");
    register_widget("jeg_last_post");
}

add_action( 'widgets_init', 'jeg_register_widget' );
/** Register widget **/




/**
 * Adds Facebook Fans Widget.
 */
class Jeg_Facebook_Fans_Widget extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     => 'Title',
                'desc'      => 'Title on Widget header',
                'type'      => 'type-text'
            ),
            'facebookurl'   => array(
                'title'     =>  'Facebook Page URL',
                'desc'      => 'Your widget page url like : http://www.facebook.com/jegbagusbarbershop',
                'type'      => 'type-text'
            )
        );

        parent::__construct(
            'jeg_facebook_fans_widget', // Base ID
            JEG_THEMENAME .': Facebook Fans Widget', // Name
            array( 'description' =>  'Sidebar Facebook fans widget for ' . JEG_THEMENAME , ) // Args
        );
    }

    public function get_widget_template () {
        return 'facebook-widget';
    }

}



/**
 * Adds Twitter Box Widget.
 */
class Jeg_Twitter_Box_Widget extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     =>  'Title',
                'desc'      => 'Title on Widget header',
                'type'      => 'type-text'
            ),
            'twitterid'   => array(
                'title'     =>  'Tweet widget ID',
                'desc'      => 'please create your twitter widget ID first right here : <a href="https://twitter.com/settings/widgets">https://twitter.com/settings/widgets</a>',
                'type'      => 'type-text'
            ),
            'twitterto'   => array(
                'title'     =>  'Tweet to',
                'desc'      => 'tweet to what account',
                'type'      => 'type-text'
            )
        );

        parent::__construct(
            'jeg_twitter_box_widget', // Base ID
            JEG_THEMENAME .': Twitter Box Widget', // Name
            array( 'description' =>  'Twitter Box Widget for ' . JEG_THEMENAME , ) // Args
        );
    }

    public function get_widget_template () {
        return 'twitter-box-widget';
    }

}




/**
 * Adds About Me Widget.
 */
class Jeg_About_Me extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     => 'Title',
                'desc'      => 'Title on Widget header',
                'type'      => 'type-text'
            ),
            'aboutimg'   => array(
                'title'     => 'About Image URL',
                'desc'      => 'put your image URL right here',
                'type'      => 'type-text'
            ),
            'aboutdesc'   => array(
                'title'     => 'About Description',
                'desc'      => 'about us text',
                'type'      => 'type-textarea'
            )
        );

        parent::__construct(
            'jeg_about_me', // Base ID
            JEG_THEMENAME .': About Me', // Name
            array( 'description' =>  'About me box for ' . JEG_THEMENAME , ) // Args
        );
    }

    public function get_widget_template () {
        return 'about-us-widget';
    }

}


/**
 * Adds About Me Widget.
 */
class Jeg_Last_Post extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     => 'Title',
                'desc'      => 'Title on Widget header',
                'type'      => 'type-text'
            ),
            'lastnumber'   => array(
                'title'     => 'Number of latest post',
                'desc'      => 'default latest post : 4',
                'type'      => 'type-text'
            )
        );

        parent::__construct(
            'jeg_last_post', // Base ID
            JEG_THEMENAME .': Latest post', // Name
            array( 'description' =>  'latest post ' . JEG_THEMENAME , ) // Args
        );
    }

    public function get_widget_template () {
        return 'last-post';
    }

}



/**
 * Adds Facebook Fans Widget.
 */
class Jeg_Ads_Widget extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     =>  'Title',
                'desc'      => 'Title on Widget header',
                'type'      => 'type-text'
            ),
            'adsimage'  => array(
                'title'     =>  'Your ads image' ,
                'desc'      => 'Your ads image url',
                'type'      => 'type-text'
            ),
            'adsurl'    => array(
                'title'     =>  'URL of your ads',
                'desc'      => 'where user will be redirected when they click your ads',
                'type'      => 'type-text'
            )
        );

        parent::__construct (
            'jeg_ads_widget', // Base ID
            JEG_THEMENAME .': Jeg Ads Widget', // Name
            array( 'description' =>  'Ads widget for ' . JEG_THEMENAME ) // Args
        );
    }

    public function get_widget_template () {
        return 'ads-widget';
    }
}

/**
 * Adds Jeg_Twitter_Widget widget.
 */
class Jeg_Twitter_Widget extends Jeg_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        $this->fields = array (
            'title'     => array(
                'title'     => 'Title',
                'desc'      => '',
                'type'      => 'type-text'
            ),
            'twitter_username'  => array(
                'title'     => 'Twitter Username',
                'desc'      => 'http://twitter.com/<strong>username</strong>',
                'type'      => 'type-text'
            ),
            'twitter_count' => array(
                'title'     => 'Tweet Count',
                'desc'      => 'Default: 5',
                'type'      => 'type-text'
            ),
            'twitter_consumer_key'  => array(
                'title'     => 'Twitter Consumer Key',
                'desc'      => 'Copy & paste your twitter consumer key, for more information where to find this value, please read documentation',
                'type'      => 'type-text'
            ),
            'twitter_consumer_secret'   => array(
                'title'     => 'Twitter Consumer Secret',
                'desc'      => 'Copy & paste your twitter Consumer Secret, for more information where to find this value, please read documentation',
                'type'      => 'type-text'
            ),
            'twitter_access_token'  =>  array(
                'title'     => 'Twitter Access Token',
                'desc'      => 'Copy & paste your twitter Access Token, for more information where to find this value, please read documentation',
                'type'      => 'type-text'
            ),
            'twitter_access_token_secret'   =>  array(
                'title'     => 'Twitter Access Token Secret',
                'desc'      => 'Copy & paste your twitter Access Token, for more information where to find this value, please read documentation',
                'type'      => 'type-text'
            )
        );

        parent::__construct(
            'jeg_twitter_widget', // Base ID
            JEG_THEMENAME .': Twitter Widget', // Name
            array( 'description' =>  'Twitter sidebar widget for ' . JEG_THEMENAME , ) // Args
        );
    }

    public function get_widget_template () {
        return 'twitter-widget';
    }

}