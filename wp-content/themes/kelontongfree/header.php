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


	<header id="header">
		<div style="float:right;">
			<?php do_shortcode('[shopping_cart]'); ?>
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
		?>

				<a class="panel-button" href="#">Catégorie</a>
				<ul id="panel">
					<?php wp_list_categories('hierarchical=0&title_li='); ?>
				</ul>
	</nav>
