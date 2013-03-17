<?php
/*Icl utility it's collection function for wordpress and wp-ecommerce themes
 * Created by : icreativelabs
 * 
 */

class IclUtility{
    /* this function will get standart feature */
    function getStickyPost($page=1,$limit=5,$rand=false){
        global $wpdb,$post, $wpsc_query,$wp_query;
        /* Get all sticky posts */
        $sticky = get_option( 'sticky_posts' );

        /* Sort the stickies with the newest ones at the top */
        //if (!$rand){
        //    rsort( $sticky );
        //}
        //$page = $page < 1 ? 1 : $page;
        //$page_ = ($page-1)*$limit;
        /* Get the 5 newest stickies (change 5 for a different number) */
        //$sticky = array_slice( $sticky, $page_, $limit );

        /* Query sticky posts */
        query_posts( array( 'post__in' => $sticky,
                                'posts_per_page' => $limit,
                                'paged' => $page) );
    }

    function getStickyPostType($postType='wpsc-product',$sticktOption='sticky_products',$page=1,$limit=5,$rand=false){
        global $wpdb,$post, $wpsc_query,$wp_query;
	$sticky_array = get_option($sticktOption);
        if (!is_array($sticky_array)){
            $dataArray['posts_per_page'] = $limit;
            query_posts($dataArray);
            return false;
        }
        /*if (!$rand){
            rsort( $sticky_array );
        }*/
        //$page = $page < 1 ? 1 : $page;
        //$page_ = ($page-1)*$limit;
        /* Get the 5 newest stickies (change 5 for a different number) */
        //$sticky = array_slice( $sticky_array, $page_, $limit );


        $dataArray = array(
                                'tag' => 'featured',
                                'posts_per_page' => $limit,
                                'paged' => $page
                         );
        if ($rand){
           $dataArray['orderby'] = 'rand';
        }
        
        query_posts($dataArray);

    }

    /* this function will get product feature */
    function getFeatureProduct($page=1,$limit=5,$rand=false){
        global $wpdb,$post, $wpsc_query,$wp_query;
        
        $this->getStickyPostType('wpsc-product','sticky_products',$page,$limit,$rand);
    }

    /* this function will get the post thumbnail */
    function getSingleStickyAttachment( $postId,$metaImageName='featured-product-thumbnails',$width=540,$height=260,$thimbtumb=false ) {
	global $wpdb;
	$attached_images = (array)get_posts( array(
				'post_type' => 'attachment',
				'numberposts' => 1,
				'post_status' => null,
				'post_parent' => $postId,
				'orderby' => 'menu_order',
				'order' => 'ASC'
			) );
        /*if ($thimbtumb){
             return '<img src="' . get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/timthumb.php?w='.$width.'&h='.$height.'&zc=1&src='.get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/images/featured-1.jpg' . '" alt="" />';
        }*/
	if ( has_post_thumbnail( $postId ) ) {
		add_image_size( $metaImageName, $width, $height, TRUE );
		$image = get_the_post_thumbnail( $product_id, $metaImageName );
		return $image;
	} elseif ( !empty( $attached_images ) ) {
		$attached_image = $attached_images[0];
                if (function_exists('wpsc_product_image')){
                    $image_link = wpsc_product_image( $attached_image->ID, $width, $height );
                    return '<img src="' . $image_link . '" alt="" />';
                }else{
                    return '<img src="' . get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/timthumb.php?w='.$width.'&h='.$height.'&zc=1&src='.get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/images/featured-1.jpg' . '" alt="" />';
                }
	} else {	
                return '<img src="' . get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/timthumb.php?w='.$width.'&h='.$height.'&zc=1&src='.get_bloginfo( 'stylesheet_directory', 'display' ).'/resources/images/featured-1.jpg' . '" alt="" />';
	}
    }

    function getProductImage($productId,$witdh,$height,$thimbtumb=false){
        global $wpdb;
        return $this->getSingleStickyAttachment($productId,'featured-product-thumbnails',$witdh,$height,$thimbtumb);
    }
    

    function getRecentPostType($postType='wpsc-product',$page=1,$limit=5){
        global $wpdb,$post, $wpsc_query,$wp_query;
        $dataArray = array(     'post_type' => $postType, 
                                'posts_per_page' => $limit,
                                'paged' => $page,
                                'orderby' => 'DESC'
                         );
        query_posts($dataArray);
        if (!have_posts ()){
            $dataArray = array( 'post_type' => 'post',
                                'posts_per_page' => $limit,
                                'paged' => $page,
                                'orderby' => 'DESC'
                         );
            query_posts($dataArray);

        }
    }
    
    function getRecentProduct($page=1,$limit=5){
        global $wpdb,$post, $wpsc_query,$wp_query;
        $this->getRecentPostType('wpsc-product',$page,$limit);
    }

    function getRecentPost($page=1,$limit=5){
        global $wpdb,$post, $wpsc_query,$wp_query;
        $this->getRecentPostType('post',$page,$limit);
    }
    /* listing all the categories under categories id and post type */
    function listCatByPostType($category_id='',$post_type='post'){
        $category_list = get_terms($post_type,'hide_empty=0&parent='.$category_id);
        return $category_list;
    }
    /* listing all the categories under categories id and post type wpsc_product_category*/
    function listCatForProduct($category_id=''){
        return $this->listCatByPostType($category_id,'wpsc_product_category');
    }

    function getLinkForCatByPostType($category_id,$post_type='post'){
        return get_term_link((int)$category_id, $post_type);
    }

    function getLinkForCatByProduct($category_id){
        return $this->getLinkForCatByPostType($category_id,'wpsc_product_category');
    }

    function isOnContent($text=''){
        global $post;
        if ( preg_match( "/\[".$text."\]/", $post->post_content) ) {
             
            return true;
        }
        return false;
    }

    function isOnAccountPage(){
        global $post;
        return $this->isOnContent('userlog');
    }

    function isOnProductPage(){
        global $post;
        return $this->isOnContent('productspage');
    }

    function isOnShoppingCartPage(){
        global $post;
        return $this->isOnContent('shoppingcart');
    }

    function isOnTransactionPage(){
        global $post;
        return $this->isOnContent('transactionresults');
    }

    function isOnUserLogPage(){
        global $post;
        return $this->isOnContent('userlog');
    }

    function isOnWPSCList(){
        global $post,$wpsc_query;
        //print_r($wpsc_query->query_vars);
        if (isset($wpsc_query->query_vars['wpsc_product_category'])){ 
            return true;
        }
        return false;
    }

    function isOnWPSCpage(){
        global $post;
        return  ($this->isOnWPSCList() || $this->isOnUserLogPage() || $this->isOnAccountPage() ||
                $this->isOnProductPage() || $this->isOnShoppingCartPage() || $this->isOnTransactionPage());
            
        //return false;
    }

}
?>