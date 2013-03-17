<?php get_header(); ?>

	<article id="content">
		<h2 class="featured-title">En avant</h2>
		
<?php 
		$iclUtility->getFeatureProduct(1,5); 

		// Display arrows only if there are more than 1 items
		global $wp_query;
		$total = $wp_query->post_count;
		if ( $total > 1 ) :
?>		
		<a class="prev" href="javascript:stepcarousel.stepBy('featured', -1)">Previous</a>
		<a class="next" href="javascript:stepcarousel.stepBy('featured', 1)">Next</a>
<?php
		endif;
?>
		<div id="featured">
			<div class="content-belt">
<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
?>			
				<section class="entry">
					<h3><a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php the_title() ?></a></h3>
					<p><?php echo $iclUtility->getProductImage( get_the_ID(), 500, 300 ); ?></p>
					<p><?php echo myExcerpts( false, 50 ); ?></p>					
					<p class="more-info"><a href="<?php echo get_permalink( get_the_ID() ); ?>" class="medium awesome">Voir la page produit</a></p>
				</section>
								
<?php 
			endwhile; endif;
?>											
			</div>
		</div>
	</article>

	<article id="content-2">
<?php
	$iclUtility->getRecentProduct(1,16);
	
		// Display arrows only if there are more than 1 items
		global $wp_query;
		$total = $wp_query->post_count;
		if ( $total > 4 ) :
?>		
		<a class="prev" href="javascript:stepcarousel.stepBy('products', -1)">Précédent</a>
		<a class="next" href="javascript:stepcarousel.stepBy('products', 1)">Suivant</a>
<?php
		endif;
?>
		<div id="products">
			<div class="products-belt">

<?php
		$count = 1;
		if ( have_posts() ) : while ( have_posts() ) : the_post(); 
?>		
		<section class="products-panel">
			<h3><a href="<?php echo get_permalink(get_the_ID())?>"><?php the_title()?></a></h3>
			<p class="imgwrap"><?php echo $iclUtility->getProductImage( get_the_ID(), 175, 150); ?> </p>
			<p><?php echo myExcerpts(false,20); ?></p>
			<p class="more-info"><a href="<?php echo get_permalink(get_the_ID())?>" class="medium awesome">Voir la page produit</a></p>
		</section>
<?php
			if ( $count % 4 == 0 ) : 
?>
			</div> <!-- .products-belt -->
			<div class="products-belt">
<?php
			endif;
			$count++;
		endwhile; endif;
?>

			</div>
		</div>
	</article>
</div>

<?php get_footer(); ?>