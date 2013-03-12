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
				
				<div class="entry-meta">
					<?php twentyten_posted_on(); ?>
				</div><!-- .entry-meta -->						
<?php 
				the_content();
?>				

				<div class="entry-utility">
					<?php twentyten_posted_in(); ?>
					<?php edit_post_link( __( 'Edit', 'kelontong' ), '<span class="edit-link">', '</span>' );  ?>
				</div><!-- .entry-utility -->		

<?php 
			endwhile;	
		endif;
?>
			</section> <!-- .main -->
		</section> <!-- #main-content -->
	</section>
	
</div>
<?php get_footer(); ?>