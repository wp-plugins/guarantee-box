<?php


class GuaranteeBoxCustomPostType{

private $post_type = 'guaranteebox';
private $post_label = 'Guarantee Box';
private $prefix = '_guarantee_box_';
function __construct() {
	
	
	add_action("init", array(&$this,"create_post_type"));
	add_action( 'init', array(&$this, 'guarantee_box_register_shortcodes'));
	add_action( 'wp_footer', array(&$this, 'enqueue_styles'));
	//add_action( 'wp_footer', array(&$this, 'enqueue_scripts'));
	
	add_action( 'cmb2_init', array(&$this,'guaranteebox_register_metabox' ));
	
	register_activation_hook( __FILE__, array(&$this,'activate' ));
}

function create_post_type(){
	register_post_type($this->post_type, array(
	         'label' => _x($this->post_label, $this->post_type.' label'), 
	         'singular_label' => _x('All '.$this->post_label, $this->post_type.' singular label'), 
	         'public' => true, // These will be public
	         'show_ui' => true, // Show the UI in admin panel
	         '_builtin' => false, // This is a custom post type, not a built in post type
	         '_edit_link' => 'post.php?post=%d',
	         'capability_type' => 'page',
	         'hierarchical' => false,
	         'rewrite' => array("slug" => $this->post_type), // This is for the permalinks
	         'query_var' => $this->post_type, // This goes to the WP_Query schema
	         //'supports' =>array('title', 'editor', 'custom-fields', 'revisions', 'excerpt'),
	         'supports' =>array('title', ),
	         'add_new' => _x('Add New', 'Event')
	         ));
}



/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */

function guaranteebox_register_metabox() {

	// Start with an underscore to hide fields from custom fields list
	//$prefix = '_guaranteebox_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $this->prefix . 'metabox',
		'title'         => __( 'Guarantee Box', 'cmb2' ),
		'object_types'  => array( $this->post_type, ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'headline', 'cmb2' ),
		//'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $this->prefix . 'headline',
		'type'       => 'text',
		'default'    => '100% Money Back Guarantee',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Guarantee Image', 'cmb2' ),
		//'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $this->prefix . 'image',
		'type' => 'file',
		'default' => plugin_dir_url(__FILE__).'images/guaranteeYellow1.png',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Guarantee Message', 'cmb2' ),
		//'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $this->prefix . 'message',
		'type' => 'textarea',
		'default' => 'We guarantee you will love this product or we will refund 100% of your money.  No questions asked.'
	) );
	$cmb_demo->add_field( array(
		'name'    => __( 'Background Color', 'cmb2' ),
		//'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => $this->prefix . 'background_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );
}



function guarantee_box_shortcode($atts){
		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );
		$dir = plugin_dir_path( __FILE__ );

		
		$headline = get_post_meta($id, $this->prefix . 'headline', true);
		$image = get_post_meta($id, $this->prefix . 'image', true);
		$message = get_post_meta($id, $this->prefix . 'message', true);
		$backgroundColor = get_post_meta($id, $this->prefix . 'background_color', true);
		
		ob_start();
		include $dir.'template/guaranteeBoxTemplate.php';
		return ob_get_clean();
}



function guarantee_box_register_shortcodes(){
		add_shortcode( 'guarantee_box', array(&$this,'guarantee_box_shortcode' ));
	}


function activate() {
	// register taxonomies/post types here
	$this->create_post_type();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function enqueue_styles(){
	wp_register_style( 'guarantee-box-css', plugin_dir_url(__FILE__).'css/guaranteeBox.css' );
	wp_enqueue_style('guarantee-box-css');
}

function enqueue_scripts(){
	//wp_enqueue_script('guarantee-box-js', plugin_dir_url(__FILE__).'js/guaranteeBox.js');
}



}// end GuaranteeBoxCustomPostType class

new GuaranteeBoxCustomPostType();


?>