<?php

// dodanie sidebar-a
function grzenio_register_sidebars() {
  $sidebars = array('Sidebar', 'Footer');

  foreach($sidebars as $sidebar) {
    register_sidebar(
      array(
        'id'            => 'grzenio-' . sanitize_title($sidebar),
        'name'          => __($sidebar, 'grzenio'),
        'description'   => __($sidebar, 'grzenio'),
        'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
      )
    );
  }
}

add_action('widgets_init', 'grzenio_register_sidebars'); 

// dodanie obslugi menu
add_action( 'init', 'register_my_menu' );

// Register area for custom menu
function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}

// ladowanie css i javascript
function js_css() {
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr.custom.min.js', array(), '2.5.1', false );  
	wp_enqueue_script( 'modernizr' );  

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1', true);
	wp_enqueue_script('jquery');
	
	wp_register_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', false, '1.7.1', true);
	wp_enqueue_script('plugins');
	
	wp_register_script( 'scripts', get_template_directory_uri() . '/js/script.js', false, '1.7.1', true);
	wp_enqueue_script('scripts');
	
	wp_register_style( 'css', get_template_directory_uri() . '/style.css', array(), 'v1', 'all' );
	wp_enqueue_style( 'css' );
}    

add_action('wp_enqueue_scripts', 'js_css');

// czystki w wordpressie
function grzenio_head_cleanup() {
	// remove header links
	// remove_action( 'wp_head', 'feed_links_extra', 3 );                 // Category Feeds
	// remove_action( 'wp_head', 'feed_links', 2 );                       // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                         // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                           // WP version
}
add_action('init', 'grzenio_head_cleanup');

// usowanie wersji RSS
function grzenio_rss_version() { return ''; }
add_filter('the_generator', 'grzenio_rss_version');


// czytaj dalej inaczej :)
function grzenio_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">czytaj dalej &raquo;</a>';
}
add_filter('excerpt_more', 'grzenio_excerpt_more');
	
// dodanie f-cji wordpressa do tematu
function grzenio_theme_support() {
	add_theme_support('post-thumbnails');      // dodanie miniaturki
	set_post_thumbnail_size(125, 125, true);   // domyslny rozmiar miniaturki
	add_custom_background();                   // custom background
	add_theme_support('automatic-feed-links'); // rss thingy
	// dodatki do postow
	add_theme_support( 'post-formats',      // post formats
		array( 
			'aside',   // title less blurb
			'gallery', // gallery of images
			'link',    // quick link to other site
			'image',   // an image
			'quote',   // a quick quote
			'status',  // a Facebook like status update
			'video',   // video 
			'audio',   // audio
			'chat'     // chat transcript 
		)
	);	
	add_theme_support( 'menus' );            // wp menus
	register_nav_menus(                      // wp3+ menus
		array( 
			'main_nav' => 'The Main Menu',   // main nav in header
			'footer_links' => 'Footer Links' // secondary nav in footer
		)
	);	
}

add_action('after_setup_theme','grzenio_theme_support');	

// dodatkowy rozmiary miniaturek
add_image_size( 'grzenio-thumb-600', 600, 150, true ); // dodatkowy thumb 600x150
add_image_size( 'grzenio-thumb-300', 300, 100, true ); // dodatkowy thumb 300x100


// wyszukiwarka

function grzenio_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'grzenio') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search the Site..." />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
}

add_filter( 'get_search_form', 'grzenio_wpsearch' );
	

class grzenio_walker extends Walker_Nav_Menu {

	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}	


// cyfrowa nawigacja
function page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="bones_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = "First";
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "Last";
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
}

// usowanie P z obrazkow
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');

?>