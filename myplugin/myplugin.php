<?php 
/* Plugin Name: My Plugin
Description: Extras for adding post types etc. 
Version: 1.0 
Author: Vicky Teinaki
Author URI: http://vickyteinaki.com 
License: GPLv2 
*/ 

function my_admin_init() {
	$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	  wp_enqueue_style( 'farbtastic' );
  wp_enqueue_script( 'farbtastic' );
	wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core') );
	wp_enqueue_style('jquery.ui.theme', $pluginfolder . '/smoothness/jquery-ui-1.8.16.custom.css');
	wp_enqueue_style('admin', $pluginfolder . '/admin.css');

}
add_action('admin_init', 'my_admin_init');

function my_admin_footer() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.mydatepicker').datepicker({
			dateFormat : 'yy-mm-dd'
		});
	});
	</script>
	<?php
}
 add_action('admin_footer', 'my_admin_footer');


 add_action('init', 'myplugin_register');
 
function myplugin_register() {

	$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
//TV
	$tv_labels = array(
		'name' => _x('TV', 'post type general name'),
		'singular_name' => _x('TV', 'post type singular name'),
		'add_new' => _x('Add TV Entry', 'research item'),
		'add_new_item' => __('Add TV Entry'),
		'edit_item' => __('Edit TV Entry'),
		'new_item' => __('New TV Entry'),
		'view_item' => __('View TV Entry'),
		'search_items' => __('Search TV'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
	
	$tv_args = array(
		'labels' => $tv_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'taxonomies' => array('category'),
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'menu_icon' => $pluginfolder . '/images/film.png',
		'supports' => array('title','editor','thumbnail', 'excerpt', 'comments', 'author'/*, 'post-formats'*/, 'page-attributes', 'trackbacks', 'custom-fields' ),
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'tv', 'with_front' => false )
	  ); 
	register_post_type( 'tv' , $tv_args );
	//Radio 
	/**/$radio_labels = array(
		'name' => _x('Radio', 'post type general name'),
		'singular_name' => _x('Podcast', 'post type singular name'),
		'add_new' => _x('Add Podcast', 'research item'),
		'add_new_item' => __('Add Podcast'),
		'edit_item' => __('Edit Podcast'),
		'new_item' => __('New Podcast'),
		'view_item' => __('View Podcast'),
		'search_items' => __('Search Radio'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
	
	$radio_args = array(
		'labels' => $radio_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'taxonomies' => array('category'),
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
	    'menu_icon' => $pluginfolder . '/images/microphone.png',

		'supports' => array('title','editor','thumbnail', 'excerpt', 'comments', 'author' , 'post-formats', 'page-attributes', 'trackbacks', 'custom-fields' ),
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'radio', 'with_front' => false )
	  ); 
	register_post_type( 'radio' , $radio_args ); /* */
	
	//Calendar

$calendar_labels = array(
		'name' => _x('Calendar', 'post type general name'),
		'singular_name' => _x('Calendar', 'post type singular name'),
		'add_new' => _x('Add Calendar Entry', 'research item'),
		'add_new_item' => __('Add Calendar Entry'),
		'edit_item' => __('Edit Calendar Entry'),
		'new_item' => __('New Calendar Entry'),
		'view_item' => __('View Calendar Entry'),
		'search_items' => __('Search Calendar'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
	
	$calendar_args = array(
		'labels' => $calendar_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'taxonomies' => array('category'),
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 5,
		'supports' => array('title','editor','thumbnail', 'page-attributes', 'custom-fields' ),
		'has_archive' => true,
		'menu_icon' => $pluginfolder . '/images/calendar-month.png',
		'rewrite' => array( 'slug' => 'calendar', 'with_front' => true )
	  ); 
	register_post_type( 'calendar' , $calendar_args );
	
	/* Taxonomy */
	register_taxonomy('series', array('post', 'tv', 'radio'),  array('hierarchical' => true, 'label' => 'Series', 'query_var' =>  true, 'rewrite' => true));

}


add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );
 
function myplugin_add_custom_box(){
  /* */ add_meta_box("radio_meta", "Radio Information", "radio_meta", "radio", "normal", "high");
   add_meta_box("calendar_meta", "Calendar Information", "calendar_meta", "calendar", "normal", "high");
 add_meta_box("tv_meta", "Video Embed", "tv_meta", "tv", "normal", "high");
 add_meta_box("bg_meta", "Custom Colour", "bg_meta", "post", "normal", "high");
 add_meta_box("header_meta", "Header Position", "header_meta", "post", "side", "low");

}

function radio_meta() {
 /* */ global $post;
  $custom = get_post_custom($post->ID);
   $radio_link = $custom["radio_link"][0];
  $radio_time = $custom["radio_time"][0];
   $radio_mp3 = $custom["radio_mp3"][0];
    $radio_m4a = $custom["radio_m4a"][0];

  echo '<p><label>Radio Link:</label><br /><input type="text" size="40" name="radio_link" value="' . $radio_link .'" /><br/><span class="description">Put in your radio link and it will be auto-magically embedded into the player.</span></p>
 <p><label>Show Time:</label><br /><input type="text" size="40" name="radio_time" value="' . $radio_time .'" /><br/><span class="description"> __ minutes __ seconds</span></p>
 <p><label>MP3 Download</label><br /><input type="text" size="40" name="radio_mp3" value="' . $radio_mp3 .'" /><br/><span class="description">Mp3 download link</span></p>
 <p><label>M4A Download</label><br /><input type="text" size="40" name="radio_m4a" value="' . $radio_m4a .'" /><br/><span class="description">M4a download link.</span></p>';
/**/
}

  function calendar_meta() {

 global $post;
  $custom = get_post_custom($post->ID);
   $event_url = $custom["event_url"][0];
 /* $event_image = $custom["event_image"][0]; */
   $event_location = $custom["event_location"][0];
    $start_date = $custom["start_date"][0];
     $end_date = $custom["end_date"][0];
     
  echo '<p><label>Event URL </label><br /><input type="text" size="40" name="event_url" value="' . $event_url . '" /><br/><span class="description">Event URL.</span></p>
 <p><label>Event Location</label><br /><input type="text" size="40" name="event_location" value="' . $event_location .'" /><br/><span class="description">Location</span></p>
 <p><label>Start Date</label><br /><input class="mydatepicker" type="text" size="40" name="start_date" value="' . $start_date .'" /><br/><span class="description">Start Date</span></p>
 <p><label>End Date</label><br /><input class="mydatepicker" type="text" size="40" name="end_date" value="' . $end_date .'" /><br/><span class="description">End Date</span></p>';


}


function header_meta() {
 	global $post;
  	$custom = get_post_custom($post->ID);
   	$header_top = $custom["header_top"][0];
	$header_right = $custom["header_right"][0];  
  echo '<p><label>Top Position</label><br /><input type="text" size="10" name="header_top" value="' . $header_top . '" />px<br/><span class="description">Position from top (default is 0 in line with text, -100 pushes up by 100px)</span></p>
 <p><label>Right Position</label><br /><input type="text" size="10" name="header_right" value="' . $header_right .'" />px<br/><span class="description">Position from right (20 will push it left 20px etc) </span></p>';
}


function tv_meta() {
 /* */ global $post;
  $custom = get_post_custom($post->ID);
   $tv_link = $custom["tv_link"][0];
  echo ' <p><label>Video Link:</label><br /><textarea  cols="100" rows="5" name="tv_link">' . $tv_link . '</textarea><br/><span class="description">Embed of video. Please make 780px wide</span></p>';
}

function bg_meta() {
 /* */ global $post;
  $custom = get_post_custom($post->ID);
   $bg_link = $custom["bg_link"][0];
    $text_link = $custom["text_link"][0];
  echo '<p><label for="bg_link">Pick background color</label><input type="text" id="bg_link" name="bg_link" value="' . $bg_link . '"/><div id="ilctabscolorpicker"></div></p>';
   echo '<p><label for="text_link">Pick header/link text color</label><input type="text" id="text_link" name="text_link" value="' . $text_link . '"/><div id="ilctabscolorpicker2"></div></p>'; ?>
  <script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#ilctabscolorpicker').hide();
    jQuery('#ilctabscolorpicker').farbtastic("#bg_link");
    jQuery("#bg_link").click(function(){jQuery('#ilctabscolorpicker').slideToggle()});
     jQuery('#ilctabscolorpicker2').hide();
    jQuery('#ilctabscolorpicker2').farbtastic("#text_link");
    jQuery("#text_link").click(function(){jQuery('#ilctabscolorpicker2').slideToggle()});

  });
 
</script>
  
  <?php
}


add_action('save_post', 'save_details');

function save_details($post_id){
  /* */global $post;
 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
return $post_id;					
  } else {
  update_post_meta($post->ID, "radio_link", $_POST["radio_link"]);
  update_post_meta($post->ID, "radio_time", $_POST["radio_time"]);
  update_post_meta($post->ID, "radio_mp3", $_POST["radio_mp3"]);  
  update_post_meta($post->ID, "radio_m4a", $_POST["radio_m4a"]);
  update_post_meta($post->ID, "event_url", $_POST["event_url"]);
  update_post_meta($post->ID, "event_image", $_POST["event_image"]);
  update_post_meta($post->ID, "event_location", $_POST["event_location"]);  
  update_post_meta($post->ID, "start_date", $_POST["start_date"]);  
  update_post_meta($post->ID, "end_date", $_POST["end_date"]); 
  update_post_meta($post->ID, "tv_link", $_POST["tv_link"]); 
  update_post_meta($post->ID, "bg_link", $_POST["bg_link"]);
  update_post_meta($post->ID, "text_link", $_POST["text_link"]);
  update_post_meta($post->ID, "header_top", $_POST["header_top"]);
  update_post_meta($post->ID, "header_right", $_POST["header_right"]);

}
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'homepage-thumb', 500, 400, true ); //(cropped)
}

function myplugin_postrss($content) {
global $wp_query;
$postid = $wp_query->post->ID;
$tv_link = get_post_meta($postid, 'tv_link', true);
$radio_link = get_post_meta($postid, 'radio_link', true);
if(is_feed()) {
if($tv_link !== '') {
$content =  tv_link . "<br/>" . $content;
}

else {
$content = $content;
}
}
return $content;
}
add_filter('the_excerpt_rss', 'myplugin_postrss');
add_filter('the_content', 'myplugin_postrss');

?>