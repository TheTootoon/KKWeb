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
				<div class="post-item">
					<header class="post-title">
						<h2 class="entry-title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php the_title(); ?></a></h2>
					</header>
					
					<div class="entry-meta">
						<?php twentyten_posted_on(); ?>
					</div><!-- .entry-meta -->						
<?php 
				the_content();
?>				
				</div>
<?php 
			endwhile;	
			
			if ( $wp_query->max_num_pages > 1 ) : 
?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'kelontong' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'kelontong' ) ); ?></div>
				</div><!-- #nav-above -->
<?php 
			endif;
		endif;
?>

				</div><!-- #nav-below -->		
			</section> <!-- .main -->
		</section> <!-- #main-content -->
	</section>
	
</div>
<?php get_footer(); ?>