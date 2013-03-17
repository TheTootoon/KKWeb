<?php get_header(); ?>

	<section id="product-content">
		
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
?>				
			
				
<?php					
			endwhile;	
		endif;
?>
			</section> <!-- .main -->
		</section> <!-- #main-content -->
	</section>
	
</div>
<?php get_footer(); ?>