<?php
/*
filename: functions.php
description: Contains functions that can be used anywhere in your theme.
It's a good place to factor out commonly used tasks.
*/

function add_my_js() {

	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_stylesheet_directory_uri() . '/assets/jquery/jquery-1.7.1.min.js');
		wp_enqueue_script( 'jquery' );
		
		wp_enqueue_script('blackfamily', get_stylesheet_directory_uri() . '/js/blackfamily.js', array('jquery'), false, true);
		wp_enqueue_script('flickity', get_stylesheet_directory_uri() . '/js/flickity.min.js', false, false, true);
	}
	
}
add_action('wp_enqueue_scripts', 'add_my_js');


/**
 * Register our sidebars and widgetized areas.
 *
 */
function jlb_widgets_init() {
	register_sidebar( array(
		'name'          => 'Footer Left Col',
		'id'            => 'footer-left',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="footer-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer Center Col',
		'id'            => 'footer-center',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="footer-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer Right Col',
		'id'            => 'footer-right',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="footer-title">',
		'after_title'   => '</h2>',
	) );

	register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'widgets_init', 'jlb_widgets_init' );


// custom menu example @ https://digwp.com/2011/11/html-formatting-custom-menus/
function clean_custom_menus() {
	$menu_name = 'header-menu'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<nav>';
		$menu_list .= '<ul class="navbar-nav">';
		foreach ((array) $menu_items as $key => $menu_item) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= '<li class="nav-item"><a href="'. $url .'" class="nav-link">'. $title .'</a></li>';
		}
		$menu_list .= '</ul>';
		$menu_list .= '</nav>';
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}

/*
Gets all images associated with the post
excludes images with an order >=99 which 
allows you to omit specific images.

Must be used within the Loop!
*/

function get_post_image_array( $post_id ){
	global $post;
	$postID = ($post_id) ? $post_id : $post->ID;
	
	//tell wordpress what information we need to get from the post
	$args = array(
		'post_parent' => $postID, 
		'post_status' => 'inherit', 
		'post_type' => 'attachment', 
		'post_mime_type' => 'image', 
		'order' => 'ASC', 
		'orderby' => 'menu_order ID'
		);
	$postImages = get_children( $args );
	//create an empty array to fill with our image info
	$filteredImages = array();
	//filter out all images with order >= 99

//print_r($postImages);

	foreach($postImages as $image){
		if($image->menu_order < 99) $filteredImages[] = $image;
	}
	return $filteredImages;
}


/*
Makes each image in the array compatible with
Timthumb which makes it easier to scale images
and not use too much bandwidth. This will make 
your website load faster. 

You should not use images larger than approx. 1MB in size, 
otherwise timthumb can choke. You shouldn't be using very
large images frequently anyway.

This function requires that you pass in an image array
like the one from the previous function get_post_image_array

A timthumb url will look something like this:
http://www.yoursite.com/wp-content/timthumb/timthumb.php?src=http://www.yoursite.com/images/image.jpg&h=250&w=150&zc=0&q=100

The url is long and unweildly, but if you can automate it,
as we're doing here, it'll save you and your users time and resources

If you need to generate multiple sizes of images, you can do that here as well.
You would need to define alternates for $maxwidth, $maxheight etc, and just
push an additional key/value pair back into the $image object where you can 
access it back in your theme. Some reasons you might do this is if you
need thumbnails, or a larger size for a lightbox.

see timthumb documentation at:
http://www.binarymoon.co.uk/projects/timthumb/
http://code.google.com/p/timthumb/
*/


function make_timthumb_image_array( $post_id ){
	global $post;
	$postID = ($post_id)? $post_id : $post->ID;
	
	//get the post image array from the function in this file
	$images = get_post_image_array( $postID );
	//define the location of timthumb in your file structure
	$timthumb_url = get_bloginfo('url') . "/wp-content/timthumb/timthumb.php";
	//create an empty array to place our new image objects into
	$imageArray = array();
	
	//loop through each image and generate a timthumb url
	foreach ($images as $image){
		$imgArray = wp_get_attachment_image_src($image->ID, 'large');
		$scaled_image = $imgArray[0];
		if($scaled_image == false) $scaled_image = $image->guid;
		$timthumb = $timthumb_url . "?src=" . $scaled_image;

		//place the timthumb url back into the image object with the key "timthumb"
		//we will have to retrieve this url later in our theme
		//note that $image is not an array, but an object and we must assign it accordingly
		$image->timthumb = $timthumb;
		//include the height and width of the base image
		$imgProperties = getImageSize($scaled_image);
		$image->width = $imgProperties[0];
		$image->height = $imgProperties[1];
		//include the orientation of the image
		$orientation = 'square';
		if($image->width > $image->height) $orientation = 'landscape';
		elseif($image->width < $image->height) $orientation = 'portrait';
		$image->orientation = $orientation;
		
		//roll the image object back into our new array
		$imageArray[] = $image;
	}
	return $imageArray;
}


// split content at the more tag and return an array
function split_content() {
	global $more;
	$more = true;
	$content = preg_split('/<span id="more-\d+"><\/span>/i', get_the_content('more'));
	for($c = 0, $csize = count($content); $c < $csize; $c++) {
		$content[$c] = apply_filters('the_content', $content[$c]);
	}
	return $content;
}


/* custom login style */
function custom_login() { 
echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/assets/css/custom-login.css" />'; 
}
add_action('login_head', 'custom_login');


//remove admin bar
add_action( 'admin_print_scripts-profile.php', 'hide_admin_bar_prefs' );
function hide_admin_bar_prefs() {
	echo '<style type="text/css">.show-admin-bar { display: none; }</style>';
}
add_filter( 'show_admin_bar', '__return_false' );


/*
	adds custom post type for updates
*/

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'bfg-update',
		array(
			'labels' => array(
				'name' => __( 'Updates' ),
				'singular_name' => __( 'Update' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}

/*
	add custom edit fields
*/

/*
	Add stylesheets and js to admin pages
*/

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace("\\",'/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content')));

add_action('admin_init','my_meta_init');
 
function my_meta_init() {
	// review the function reference for parameter details
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
	//wp_enqueue_script('my_jquery_js', MY_THEME_PATH . '/assets/jquery/jquery-1.6.1.min.js'); 
	wp_enqueue_script('my_meta_js', MY_THEME_PATH . '/assets/jquery/jquery-ui.js'); 
	wp_enqueue_script('my_map_js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDmBSTthgVOcDGME2lS3Bjm4Fk5ItecKuQ&sensor=false');
	wp_enqueue_script('my_admin_js', MY_THEME_PATH . '/js/admin.js');
	wp_enqueue_style('my_datepicker_css', MY_THEME_PATH . '/assets/css/ui-lightness/jquery-ui-1.8.16.custom.css');
}

$new_meta_boxes =
	array(
		
		"surname" => array(
			"name" => "surname",
			"std" => "",
			"title" => "Surname",
			"description" => "The surname of the individual in the record",
			'type' => 'text'
		),
		
		"givenName" => array(
			"name" => "given_name",
			"std" => "",
			"title" => "Given Name",
			"description" => "The given name of the individual in the record",
			'type' => 'text'
		),
		
		"dateBorn" => array(
			"name" => "date_born",
			"std" => "",
			"title" => "Date Born",
			"description" => "Enter in a date. (YYYY-MM-DD)",
			'type' => 'text'
		),
		"locationBorn" => array(
			"name" => "born",
			"std" => "",
			"title" => "Location Born",
			"description" => "Enter a location. Drag the marker around or type in a target destination and press tab, or click elsewhere to exit the field (not Enter!)",
			'type' => 'map'
		),
		"latBorn" => array(
			"name" => "lat_born",
			"std" => "",
			"title" => "lat",
			"description" => "Latitude",
			'type' => 'hidden',
			'readonly' => true
		),
		"lngBorn" => array(
			"name" => "lng_born",
			"std" => "",
			"title" => "lng",
			"description" => "Longitude",
			'type' => 'hidden',
			'readonly' => true
		),
		"zoomBorn" => array(
			"name" => "zoom_born",
			"std" => "",
			"title" => "zoom",
			"description" => "",
			'type' => 'hidden'
		),
		
		"dateDied" => array(
			"name" => "date_died",
			"std" => "",
			"title" => "Date Died",
			"description" => "Enter in a date. (YYYY-MM-DD)",
			'type' => 'text'
		),
		"locationDied" => array(
			"name" => "died",
			"std" => "",
			"title" => "Location Died",
			"description" => "Enter a location. Drag the marker around or type in a target destination and press tab, or click elsewhere to exit the field (not Enter!)",
			'type' => 'map'
		),
		"latDied" => array(
			"name" => "lat_died",
			"std" => "",
			"title" => "lat",
			"description" => "Latitude",
			'type' => 'hidden',
			'readonly' => true
		),
		"lngDied" => array(
			"name" => "lng_died",
			"std" => "",
			"title" => "lng",
			"description" => "Longitude",
			'type' => 'hidden',
			'readonly' => true
				
		),
		"zoomDied" => array(
			"name" => "zoom_died",
			"std" => "",
			"title" => "zoom",
			"description" => "",
			'type' => 'hidden'
		)
		
);

function new_meta_boxes() {
	global $post, $new_meta_boxes;
	global $user_identity;
	get_currentuserinfo();
 
	foreach($new_meta_boxes as $meta_box) {
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
 
		if($meta_box_value == "") $meta_box_value = $meta_box['std']; 
 
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
 
		if($meta_box['type'] != 'hidden') echo'<h4>'.$meta_box['title'].'</h4>';
 
		if($meta_box['type'] == "text"){
			if($meta_box['readonly']) $readonly = 'readonly';
			echo'<input type="text" id="'.$meta_box['name'].'" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" size="55" '.$readonly.'/><br />';
 		}elseif($meta_box['type'] == 'checkbox'){
			$checked = "";
			//$editable = "disabled";
			//if($meta_box['name'] == 'stage2' || $user_identity == "joseph" ||$user_identity == "Alixb"||$user_identity == "peter")
			//	$editable = "";
			if($meta_box_value == "true")
				$checked = 'checked="checked"';
			echo'<input type="checkbox" name="'.$meta_box['name'].'_value" value="true"'. $checked .' '. $editable .' /><br />';	
			
		} elseif($meta_box['type'] == 'map') {
			echo '<div id="'. $meta_box['name'] .'">';
			echo '<div class="map-canvas" style="height:500px;width:500px"></div>';
			echo '<input type="text" class="geocode-input"name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" size="55" /><br />';
			echo '<button class="clear-map"/>clear map</button><br />';
			echo '</div>';	
		} elseif($meta_box['type'] == 'hidden') {
		 	echo '<input type="hidden" id="'.$meta_box['name'].'" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'"  />';
		}
		
		if($meta_box['type'] != 'hidden') echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';
	}
}

function create_meta_box() {
	global $theme_name;
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-boxes', 'Post Meta', 'new_meta_boxes', 'post', 'normal', 'high' );
	}
}

function save_postdata( $post_id ) {
	global $post, $new_meta_boxes;

	foreach($new_meta_boxes as $meta_box) {
		// Verify
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))
		{
			return $post_id;
		}

		if ( 'page' == $_POST['post_type'] )
		{
			if ( !current_user_can( 'edit_page', $post_id )) return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id )) return $post_id;
		}
 
		$data = $_POST[$meta_box['name'].'_value'];
 
		if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
			add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
		elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
			update_post_meta($post_id, $meta_box['name'].'_value', $data);
		elseif($data == "")
			delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
	}
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');





