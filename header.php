<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pl"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="pl"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="pl"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="pl"><!--<![endif]-->
<head>
<meta charset="utf-8">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<title>
<?php wp_title(); ?>
</title>
<meta name="viewport" content="width=device-width">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]--> 
<header>
    <h1 class="grid"><a href="<?php bloginfo('url');?>"><?php bloginfo('name');?></a></h1>
</header>
<nav>
    <ul id="menu">
      <?php wp_nav_menu( array('container_class' => false,'menu' => 'top-menu','container' => '', 'items_wrap' => '%3$s' )); ?>
    </ul>
</nav>
<?php if ( ( is_home() || is_front_page() ) ) { ?>
<div class="flexslider">
  <ul class="slides">
	<?php
    $query_images_args = array(
        'post_type' => 'attachment', 'post_excerpt' => 'slider', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,
    );
    
    $query_images = new WP_Query( $query_images_args );
    $images = array();
    foreach ( $query_images->posts as $image) {
		if ($image->post_excerpt == "slider") {
			echo "<li><img alt=\"".$image->post_content."\" src=\"".$image->guid."\"></li>\n";
		} else {};
    }
    ?>
</ul>
</div>
<?php } else {} ?>
<section id="container">
