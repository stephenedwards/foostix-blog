<?php
/***
 * Jkreativ Customizer Controller
 * @author : Jegtheme
 */

/* ------------------------------------------------------------------------- *
 *  Register Customizer Options
 * ------------------------------------------------------------------------- */
function jeg_register_theme_customizer($wp_customize) {
    locate_template(array('/lib/customizer/options/general.php'),    true, true); #1
    locate_template(array('/lib/customizer/options/font.php'),       true, true); #2
    locate_template(array('/lib/customizer/options/header1.php'),    true, true); #3
    locate_template(array('/lib/customizer/options/header2.php'),    true, true); #4
    locate_template(array('/lib/customizer/options/header3.php'),    true, true); #5
    locate_template(array('/lib/customizer/options/header4.php'),    true, true); #6
    locate_template(array('/lib/customizer/options/header5.php'),    true, true); #7
    locate_template(array('/lib/customizer/options/mobile.php'),     true, true); #8
    locate_template(array('/lib/customizer/options/sidebar.php'),    true, true); #9
    locate_template(array('/lib/customizer/options/footer.php'),     true, true); #10
    locate_template(array('/lib/customizer/options/background.php'), true, true); #11
}
add_action( 'customize_register', 'jeg_register_theme_customizer' );


/*  Customizer Controls
 * ------------------------------------------------------------------------- */
if (class_exists('WP_Customize_Control')) {

    /**
     * New Upload Control
     */
    class Jeg_Customize_Newupload_Control extends WP_Customize_Control {
        public $type = 'newupload';

        public function enqueue(){
            wp_enqueue_media();
            wp_enqueue_style ('jeg-theme-customizer-style', get_template_directory_uri() . '/lib/customizer/css/customizer.css', null, JEG_VERSION);
            wp_enqueue_script('jeg-jkreativ-newupload', get_template_directory_uri() . '/lib/customizer/js/newupload.js' , null, null, true);
        }

        public function render_content(){
            $image = '';
            $value = $this->value();

            if(!empty($value)) {
                if(ctype_digit($value) || is_int($value)) {
                    $image = wp_get_attachment_image_src($value, "full");
                    $image = $image[0];
                } else {
                    $image = $this->value();
                }
            }

            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <div class="uploadfile">
                    <div class="portfolioinputtitle"></div>
                    <div class="jimg">
                        <img src="<?php echo esc_url( $image ) ?>">
                    </div>
                    <input type="hidden" class="videocover uploadtext newupload-input">
                    <div class="buttons">
                        <input type='button' value='Select Image' class='selectfileimage btn'/>
                        <input type='button' value='x' class='removefile btn'/>
                    </div>
                </div>
            </label>
            <?php
        }
    }

    /**
     * Flag control
     */
    class Jeg_Customize_Flag_Control extends WP_Customize_Control {
        public $type = 'flag';

        public function enqueue(){
            wp_enqueue_style ('jeg-theme-customizer-style', get_template_directory_uri() . '/lib/customizer/css/customizer.css', null, JEG_VERSION);
            wp_enqueue_script('jeg-jkreativ-additional-script', get_template_directory_uri() . '/lib/customizer/js/customizer-additional.js' , null, null, true);
        }

        public function render_content(){
            ?>
            <label class="title-label">
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            </label>
            <?php
        }
    }

    /**
     * Slider control
     ***/
    class Jeg_Customize_Slider_Control extends WP_Customize_Control {
        public $type = 'slider';
        public $min, $max, $step;

        public function enqueue(){
            wp_enqueue_script('customizer-slider', get_template_directory_uri() . '/lib/customizer/js/slider-ui.js' , array('jquery-ui-slider'), '1.0', true);
            wp_enqueue_style('jquery-css-cdn', get_template_directory_uri() . '/lib/customizer/css/jquery-ui.css');
        }

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <input class="slider-input" type="text" disabled="disabled" value="<?php echo esc_attr( $this->value() ) ?>" />
                <div class="slider-wrapper">
                    <div class="slider" data-min="<?php echo esc_attr( $this->min ) ?>" data-max="<?php echo esc_attr( $this->max ) ?>" data-step="<?php echo esc_attr( $this->step ) ?>" data-value="<?php echo esc_attr( $this->value() ) ?>"></div>
                </div>
            </label>
            <?php
        }
    }

    /**
     * Textarea control
     */
    class Jeg_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function enqueue(){
            wp_enqueue_style ('jeg-theme-customizer-style', get_template_directory_uri() . '/lib/customizer/css/customizer.css', null, JEG_VERSION);
        }

        public function render_content(){
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
        <?php
        }
    }

    /**
     * Sub Title
     */
    class Jeg_Customize_Subtitle_Control extends WP_Customize_Control {
        public $type = 'subtitle';

        public function enqueue(){
            wp_enqueue_style ('jeg-theme-customizer-style', get_template_directory_uri() . '/lib/customizer/css/customizer.css', null, JEG_VERSION);
        }

        public function render_content() {
        ?>
            <h4 class="customize-subtitle"><?php echo esc_html( $this->label ); ?></h4>
            <small><?php echo esc_html( $this->description ); ?></small>
        <?php
        }
    }

}

/* ------------------------------------------------------------------------- *
 *  Customizer Framework
 * ------------------------------------------------------------------------- */
class Jeg_Customizer_Framework {
    private $section;
    private $setting;
    private $wp_customize;

    public function __construct($section, $setting, $wp_customize) {
        $this->section = $section;
        $this->setting = $setting;
        $this->wp_customize = $wp_customize;
        $this->build_customizer();
    }

    public function build_customizer() {
        $sectionname = 'jeg_top_nav_section';
        $this->wp_customize->add_section(
            $this->section['name'],
            array(
                'title'         => $this->section['title'],
                'priority'      => $this->section['priority'],
                'description'   => $this->section['description']
            )
        );

        foreach($this->setting as $id => $setting) {
            if($setting['type'] === 'upload') {
                $this->customizer_upload($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'color') {
                $this->customizer_color($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'slider') {
                $this->customizer_slider($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'text') {
                $this->customizer_text($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'checkbox') {
                $this->customizer_checkbox($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'select') {
                $this->customizer_select($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'radio') {
                $this->customizer_radio($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'flag') {
                $this->customizer_flag($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'newupload') {
                $this->customizer_newupload($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'textarea') {
                $this->customizer_textarea($this->section['name'], $setting, $this->wp_customize, $id);
            }
            if($setting['type'] === 'subtitle') {
                $this->customizer_subtitle($this->section['name'], $setting, $this->wp_customize, $id);
            }
        }
    }

    /** customize new upload **/
    public function customizer_newupload($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new Jeg_Customize_Newupload_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id,
        )));
    }

    /** textarea select **/
    public function customizer_textarea($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new Jeg_Customize_Textarea_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id,
        )));
    }

    /** sub title **/
    public function customizer_subtitle($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new Jeg_Customize_Subtitle_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'description'  => $setting['description'],
            'priority'  => $id,
        )));
    }

    /** customize select **/
    public function customizer_select($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( $setting['name'], array(
            'settings'  => $setting['name'],
            'label'     => $setting['title'],
            'choices'   => $setting['choices'],
            'section'   => $sectionname,
            'type'      => 'select',
            'priority'  => $id,
        ));
    }

    /*** radio ***/
    public function customizer_radio($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( $setting['name'], array(
            'settings'  => $setting['name'],
            'label'     => $setting['title'],
            'choices'   => $setting['choices'],
            'section'   => $sectionname,
            'type'      => 'radio',
            'priority'  => $id,
        ));
    }

    /*** text ***/
    public function customizer_text ($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( $setting['name'], array(
            'settings'  => $setting['name'],
            'label'     => $setting['title'],
            'section'   => $sectionname,
            'priority'  => $id
        ));
    }

    /*** check box ***/
    public function customizer_checkbox ($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( $setting['name'], array(
            'settings'  => $setting['name'],
            'label'     => $setting['title'],
            'section'   => $sectionname,
            'type'      => 'checkbox',
            'priority'  => $id
        ));
    }

    /** flag **/
    public function customizer_flag ($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new Jeg_Customize_Flag_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id
        )));
    }

    /** slider **/
    public function customizer_slider($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new Jeg_Customize_Slider_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id,
            'min'       => $setting['min'],
            'max'       => $setting['max'],
            'step'      => $setting['step'],
        )));
    }

    /** upload **/
    public function customizer_upload ($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id,
        )));
    }

    /** color **/
    public function customizer_color ($sectionname, $setting, $wp_customize, $id) {
        $wp_customize->add_setting( $setting['name'], array(
            'transport' => $setting['transport'],
            'default'   => $setting['default'],
            'sanitize_callback' => 'jeg_sanitize_callback_dummy'
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, $setting['name'], array(
            'section'   => $sectionname,
            'label'     => $setting['title'],
            'settings'  => $setting['name'],
            'priority'  => $id,
        )));
    }
}

function jeg_sanitize_callback_dummy( $value ) {
    return $value;
}