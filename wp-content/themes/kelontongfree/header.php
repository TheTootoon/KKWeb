<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */

		global $page, $paged;
		wp_title( '|', true, 'right' );
		// Add the blog name.
		bloginfo( 'name' );
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'kelontong' ), max( $paged, $page ) );
		?></title>

		

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/green.css" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
	
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/script/stepcarousel.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/script/lib.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/script/html5.js"></script>

</head>

<body>

<div id="wrapper">

	<nav id="navbar">

		<?php				
			if (has_nav_menu('header')):
				wp_nav_menu(array('theme_location' => 'header','menu_id'=>'','container'=>'','menu_class'=>'navigation'));
			endif;
		?>						

		<ul class="left-nav">
			<?php wp_register(); ?>
			<li class="login"><?php wp_loginout(); ?></li>
		</ul>		 
	</nav>

	<header id="header">
		<div style="float:right;">
			<?php echo do_shortcode('[shopping_cart empty_msg="Panier vide"]'); ?>
		</div>
		<hgroup>
			<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="tagline"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
	</header>
	
	<nav id="midbar">

		<?php 
				// display breadcrumb
				breadcrumb_trail( array('before' => '', 'separator' => '&gt;' ) ); 	

				// display list of wpec categories if wpec is installed.
				if ( function_exists( 'wpsc_display_categories' ) ) :
		?>

				<a class="panel-button" href="#">Browse Category</a>
				<ul id="panel">
					<?php wpsc_start_category_query( array( 'category_group'=> 1, 'show_thumbnails'=> 0 ) ); ?>
						<li>
							<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>"><?php wpsc_print_category_name();?></a>
						</li>
					<?php wpsc_end_category_query(); ?>
				</ul>		

		<?php else: // wpsc is not installed, so display list of categories instead. ?>

				<a class="panel-button" href="#">Browse Category</a>
				<ul id="panel">
					<?php wp_list_categories('hierarchical=0&title_li='); ?>
				</ul>

		<?php endif; ?>
                    
	</nav>
