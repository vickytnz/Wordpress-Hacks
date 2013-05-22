<?php
/*
Misc functions for cleaning up Wordpress. 
Custom URLs and images are labeled EXAMPLE: do a search and replace to find them.

*/


/******** Setting up theme support for featured images -- customise as fit******* */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
add_action( 'after_setup_theme', 'theme_setup' );

function theme_setup() {
/*Add custom sizes here, with name, width, height, and whether to have true crop (yes), or not (no, or default)*/
	/* add_image_size('page-thumb', 220, 160, true);
    add_image_size('custom-category', 200 ); */
}
/******** end theme images *************/

/******** Change excerpt length *********/
function new_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');
/******** End change excerpt length *********/


/**
 * Register widgetized area and update sidebar with default widgets
 */
function toolbox_widgets_init() {
 register_sidebar( array (
     'name' => __( 'Sidebar Header', 'toolbox' ),
     'id' => 'sidebar-header',
     'before_widget' => '<aside id="%1$s" class="widget %2$s">',
     'after_widget' => "</aside>",
     'before_title' => '<h1 class="widget-title">',
     'after_title' => '</h1>',
 ) );
/** End **/

/* Fun with customising the login and dashboard */
//hook the administrative header output
add_action('admin_head', 'my_custom_logo');
 
 
function my_custom_logo() {
echo '<style type="text/css">#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/EXAMPLE.png) !important; }</style>';
/* Style with .login h1 a if needed*/
}

// Login URL
    function put_my_url(){
    return ('http://EXAMPLE.com/'); 
    }
    add_filter('login_headerurl', 'put_my_url');


function change_title(){
    return ('Hello. Do you have a password?'); 
    }
    add_filter('login_headertitle', 'change_title');



// login page logo
function custom_login_logo() {
    echo '<style type="text/css">h1 a { background: url('.get_bloginfo('template_directory').'/images/EXAMPLE.png) 50% 50% no-repeat !important; }</style>';
}
add_action('login_head', 'custom_login_logo');
/*End customising login and dashboard */

//Change default post type to say news
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
	$submenu['edit.php'][16][0] = 'News Tags';
	echo '';
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


/*
 Security fixes
*/
/*Remove generator tags */
remove_action( 'wp_head', 'wp_generator' ) ; 
remove_action( 'wp_head', 'wlwmanifest_link' ) ; 
remove_action( 'wp_head', 'rsd_link' ) ;

/* Remove HTML from comments */
add_filter( 'pre_comment_content', 'wp_specialchars' );

/*Hide errors on WP screen (useful if you're worried about hacking, but annoying if not */
function no_errors_please(){
  return 'Either your password or user name is incorrect';
}
add_filter( 'login_errors', 'no_errors_please' );

/* Stop WP from guessing URLS */
add_filter('redirect_canonical', 'stop_guessing');
function stop_guessing($url) {
 if (is_404()) {
   return false;
 }
 return $url;
}


?>