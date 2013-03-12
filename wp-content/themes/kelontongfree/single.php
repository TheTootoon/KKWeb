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

				
				<div id="entry-author-info">
					<div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
					</div><!-- #author-avatar -->
					<div id="author-description">
						<h2><?php printf( esc_attr__( 'About %s', 'kelontong' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
						<div id="author-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'kelontong' ), get_the_author() ); ?>
							</a>
						</div><!-- #author-link	-->
					</div><!-- #author-description -->
				</div><!-- #entry-author-info -->
				

				<div id="nav-below" class="navi">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'kelontong' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'kelontong' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->				
				
<?php					
				comments_template( '', true );
			endwhile;	
		endif;
?>
			</section> <!-- .main -->
		</section> <!-- #main-content -->
	</section>
	
</div>
<?php get_footer(); ?>