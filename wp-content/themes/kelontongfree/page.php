<?php get_header(); ?>

	<section id="product-content">
		<section class="sidebar">
<?php 
			if ( !dynamic_sidebar('Left Sidebar') ) :
			endif;
?>
		</section><!-- sidebar -->
		
		<section id="main-content">
			<section class="main">
<?php 
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); 
?>		
				<header class="post-title">
					<h2 class="entry-title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php the_title(); ?></a></h2>
				</header>
<?php 

				the_content();
				edit_post_link( __( 'Edit', 'kelontong' ), '<span class="edit-link">', '</span>' ); 
?>

<?php 
				if(is_single () || is_page()):
					comments_template( '', true );
				endif;
			endwhile;	
		endif;
?>
			</section> <!-- .main -->
		</section> <!-- #main-content -->
	</section>
	
</div>
<?php get_footer(); ?>