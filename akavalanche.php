<?php
/*
Plugin Name: AKAvalanche
Plugin URI: http://www.couloirgraphics.com/
Description: Creates akavalanches custom post types.
Version: 1.0
Author: William Finley
Author URI: http://couloirgraphics.com/
Copyrighht:  William Finley
*/

// **************************  functions for AKAvalanche site - note - this plugin requires Advanced Custom Field.  ***************** */  
// **************************  				the ACF json / php files are located in /assets.  						***************** */  

// ************************** --------------------------------------------------  ***************** */  
// **************************  Step 1: create the menu item(s)                      ***************** */  
// ************************** --------------------------------------------------  ***************** */  
function akavalanches_admin_menu() {
    add_menu_page(
        'Forecasts',
        'Forecasts',
        'read',
        'akavalanches',
        '',
        'dashicons-admin-home',
        20
    );
    // **************** start CNFAIC CUSTOM RIDING PAGE CODE ************** \\
    add_submenu_page( 'akavalanches',
	'Riding Areas',
	'Riding Areas',
	'manage_options',
	'akavalanches_riding',
	'akavalanches_riding');
	 // **************** end CNFAIC CUSTOM RIDING PAGE CODE ************** \\
 }
add_action( 'admin_menu', 'akavalanches_admin_menu' );
 // this option calls the riding page update script
function akavalanches_riding(){
	echo '<div class="wrap"><div id="icon-users" class="icon32"><br></div> <h2>Riding Areas</h2>';
	include("riding-areas.php");
	echo '</div>';	
}




// ************************** --------------------------------------------------  ***************** */  
// **************************  Step 2: create & register  forecasts custom post    ***************** */  
// **************************  you need to loop through each zone and insert a    ***************** */  
// **************************  unique name for each in order for all to dispaly    ***************** */ 
// **************************  change create_posttype_forecast_xxx to name you want.    ***************** */ 
// **************************  Note that you must duplicate ACF fields and edit per region.     ***************** */ 
// ************************** --------------------------------------------------  ***************** */  

// set vars for forecast.  Used throughout but repeated below.
$zone1_name = "Turnagain Pass";
$zone1_slug = "turnagain";

// ZONE 1 FORECAST //
function akavalanches_create_posttype_forecast_zone1() {
    $zone1_name = "Turnagain Pass";
	$zone1_slug = "turnagain";
    register_post_type( 'forecast_zone1',
        array(
            'labels' => array(
                'name' => __( $zone1_name ),
                'singular_name' => __( $zone1_name )
            ),
            'public' => true,
            'has_archive' => 'forecast/'.$zone1_slug.'/archives',
            'rewrite' => array('slug' => 'forecast/'.$zone1_slug.''),
            'supports' => array('editor' ),
            'show_in_menu'  => 'akavalanches',
            'feeds' => true,
            'with_front' => false
        )
    );
}
add_action( 'init', 'akavalanches_create_posttype_forecast_zone1' );


// ************************** ---------------------------------------------------------------  ***************** */  
// **************************  2a: move content editor into the tab / note that  you need  	  ***************** */  
// ************************** to adjust the ACF field (acf-field-xxx to move the editor 	      ***************** */  
// ************************** ---------------------------------------------------------------  ***************** */  

add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
    ?>
    <script type="text/javascript">
    (function($) {
        
        $(document).ready(function(){
            $('.acf-field-5cd1cfa2e4a2f .acf-input').append( $('#postdivrich') );
        });
        
    })(jQuery);    
    </script>
    <style type="text/css">
        .acf-field #wp-content-editor-tools {
            background: transparent;
            padding-top: 0;
        }
    </style>
    <?php    
}

// ************************** --------------------------------------------------  ***************** */  
// **************************   2b. IF forecast post then after save change the title to the date       ***************** */  
// ************************** --------------------------------------------------  ***************** */  



add_action('acf/save_post', 'my_save_post', 20);
function my_save_post($post_id){
  
  if ( get_post_type( get_the_ID() ) == 'forecast_zone1' ) {
	  
	  // Get the data from a field
	  $new_title = get_field('akavalanche_date', $post_id);
	  
	  // Set the post data
	  $new_post = array(
	      'ID'           => $post_id,
	      'post_title'   => $new_title,
	      'post_name'   => $new_title,
	  );
	  
	  // Remove the hook to avoid infinite loop. Please make sure that it has
	  // the same priority (20)
	  remove_action('acf/save_post', 'my_save_post', 20);
	  
	  // Update the post
	  wp_update_post( $new_post );
	  
	  // Add the hook back
	  add_action('acf/save_post', 'my_save_post', 20);
  
  }

}

function akavalanche_disallow_posts_with_same_title($messages) {
    global $post;
    global $wpdb ;
    $title = $post->post_title;
    $post_id = $post->ID ;
    $wtitlequery = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'forecast_zone1' AND post_title = '{$title}' AND ID != {$post_id} " ;
 
    $wresults = $wpdb->get_results( $wtitlequery) ;
 
    if ( $wresults ) {
        $error_message = 'ERROR.  A forecast for this date has already been inserted. Please choose another';
        add_settings_error('post_has_links', '', $error_message, 'error');
        settings_errors( 'post_has_links' );
        $post->post_status = 'draft';
        wp_update_post($post);
        return;
    }
    return $messages;

}
add_action('post_updated_messages', 'akavalanche_disallow_posts_with_same_title');



// ************************** --------------------------------------------------  ***************** */  
// **************************  	Step 3:	Create the front end templates // need to hardcode types	     ***************** */  
// ************************** --------------------------------------------------  ***************** */  

// this loads the archive page
add_filter('template_include', 'akavalanche_archives');
function akavalanche_archives( $template ) {
  if ( is_post_type_archive('forecast_zone1') ) {
    return plugin_dir_path(__FILE__) . 'forecast-archive.php';
  }
  return $template;
}

// this loads the individual page
function akavalanche_load_template ($template) {
    global $post;
    if ( strpos($post->post_type, 'forecast_zone1') !== false && $template !== locate_template(array("forecast-single.php"))){
        return plugin_dir_path( __FILE__ ) . "forecast-single.php";
    }
    return $template;
}
add_filter('single_template', 'akavalanche_load_template');


function Get_most_recent_permalink(){
    global $post;
    $tmp_post = $post;
    $args = array(
        'numberposts'     => 1,
        'offset'          => 0,
        'orderby'         => 'post_date',
        'order'           => 'DESC',
        'post_type'       => 'forecast_zone1',
        'post_status'     => 'publish' );
    $myposts = get_posts( $args );
    $permalink = get_permalink($myposts[0]->ID);
    $post = $tmp_post;
    return $permalink;
}

// ************************** --------------------------------------------------  ***************** */  
// **************************  	Step 4:	Enqueue	 CSS			   ***************** */  
// ************************** --------------------------------------------------  ***************** */  
  
function wpse_load_plugin_css() {
	$ver_num ='092220';
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style1', $plugin_url . 'advisory.css', '', $ver_num );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css' );

// ************************** --------------------------------------------------  ***************** */  
// **************************  	Misc Customizations & functions			   ***************** */  
// ************************** --------------------------------------------------  ***************** */  

// clean up the excerpt on archives page
function akavalancheexcerpt_more($more) {
    return '';
}
add_filter('excerpt_more', 'akavalancheexcerpt_more', 21 );

/*****************************************************************************
Add & edit admin columns for custom post types
*****************************************************************************/
/* remove date from forecasts  */
function forecast_zone1_manage_columns( $columns ) {
  unset($columns['date']);
  return $columns;
}

function forecast_zone1_column_init() {
  add_filter( 'manage_forecast_zone1_posts_columns' , 'forecast_zone1_manage_columns' );
}
add_action( 'admin_init' , 'forecast_zone1_column_init' );

/* prepart add columns to forecasts statement */
function add_acf_columns ( $columns ) {
   return array_merge ( $columns, array ( 
        'akavalanche_author' => __ ( 'Author' ),
        'akavalanche_rating_high' => __ ( 'Alpine' ),
        'akavalanche_rating_middle' => __ ( 'Treeline' ),
        'akavalanche_rating_low' => __ ( 'Below Treeline' ),
 
   ) );
 }
 add_filter ( 'manage_forecast_zone1_posts_columns', 'add_acf_columns' );
 
 /*  Add columns to forecasts */
 function forecast_zone1_custom_column ( $column, $post_id ) {
   switch ( $column ) {
      case 'akavalanche_author':
       echo get_post_meta ( $post_id, 'akavalanche_author', true );
       break;
	  case 'akavalanche_rating_high':
       echo get_post_meta ( $post_id, 'akavalanche_rating_high', true );
       break;
      case 'akavalanche_rating_middle':
       echo get_post_meta ( $post_id, 'akavalanche_rating_middle', true );
       break;
      case 'akavalanche_rating_low':
       echo get_post_meta ( $post_id, 'akavalanche_rating_low', true );
       break;
   }
 }
 add_action ( 'manage_forecast_zone1_posts_custom_column', 'forecast_zone1_custom_column', 10, 3 );
 

/*****************************************************************************
Accidents custom post edits
*****************************************************************************/
// **************** start ACCIDENTS create PAGE CODE ************** \\
function akavalanches_create_posttype_forecast_accidents() {
	$slug = "accidents";
    register_post_type( 'forecast_acccidents',
    
        array(
            'labels' => array(
                'name' => __( 'Accidents' ),
                'singular_name' => __( 'Accident' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => $slug),
            'show_in_menu'       => 'akavalanches',
        )
    );
}
add_action( 'init', 'akavalanches_create_posttype_forecast_accidents' );
// **************** end ACCIDENTS create PAGE CODE ************** \\

/* remove date from acccidents admin column  */
function forecast_acccidents_manage_columns( $columns ) {
  unset($columns['date']);
  return $columns;
}

/* prepart add columns to acccidents statement */
function forecast_acccidents_column_init() {
  add_filter( 'manage_forecast_acccidents_posts_columns' , 'forecast_acccidents_manage_columns' );
}
add_action( 'admin_init' , 'forecast_acccidents_column_init' );

function add_acf_columns2 ( $columns ) {
   return array_merge ( $columns, array ( 
        'cnfaic_accidents_date' => __ ( 'Date' ),
        'cnfaic_accidents_region' => __ ( 'Region' ),
        'cnfaic_accidents_activity' => __ ( 'Activity' ),
        'cnfaic_accidents_killed' => __ ( 'Fatalities' ),
   ) );
 }
 add_filter ( 'manage_forecast_acccidents_posts_columns', 'add_acf_columns2' );
 
 /*  Add columns to acccidents */
 function forecast_acccidents_custom_column ( $column, $post_id ) {
   switch ( $column ) {
      case 'cnfaic_accidents_date':
        $event_date = get_post_meta ( $post_id, 'cnfaic_accidents_date', true );
        echo $fDate = date("M d Y", strtotime($event_date));
       break;
	  case 'cnfaic_accidents_region':
       echo get_post_meta ( $post_id, 'cnfaic_accidents_region', true );
       break;
       case 'cnfaic_accidents_killed':
       echo get_post_meta ( $post_id, 'cnfaic_accidents_killed', true );
       break;
       case 'cnfaic_accidents_activity':
       echo get_post_meta ( $post_id, 'cnfaic_accidents_activity', true );
       break;
   }
 }
 add_action ( 'manage_forecast_acccidents_posts_custom_column', 'forecast_acccidents_custom_column', 10, 3 );

// this loads the archive page
 /*  create an acccidents short code */
function forecast_acccidents_table_func( $atts ){
	ob_start();
	include 'accidents-archive.php';
	$content = ob_get_clean();
    return  $content;
}
add_shortcode( 'forecast_acccidents_table', 'forecast_acccidents_table_func' );

// this loads the individual page
function akavalanche_load_accidentarchives_template ($template) {
    global $post;
    if ( strpos($post->post_type, 'forecast_acccidents') !== false ){
        return plugin_dir_path( __FILE__ ) . "accidents-single.php";
    }
    return $template;
}
add_filter('single_template', 'akavalanche_load_accidentarchives_template');

// register googlemaps API
function my_acf_init() {
	acf_update_setting('google_api_key', 'xxx');
}
add_action('acf/init', 'my_acf_init');


?>