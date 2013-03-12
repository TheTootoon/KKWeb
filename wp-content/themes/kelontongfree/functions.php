<?php
include_once( 'resources/classes/icl_utility.php' );
include_once( 'resources/classes/walkermenu.php' );
include_once( 'resources/breadcrumb-trail.php' );

$iclUtility = new IclUtility();

add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );

register_nav_menus( array(
	'header' => __( 'Header Menu', 'kelontong' )
	) 
);

register_sidebar(array(
  'name' => 'Left Sidebar',
  'description' => 'Widgets will be shown in the sidebar to the left side.',
  'before_widget' => '<div class="sidebar-widget">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="sidebar-widget-title">',
  'after_title' => '</h3>'
));

function date_posted_on($patternDate='d-M') {
	global $post;
	return get_the_date($patternDate);
}

function cutText($content = false,$excerpt_length=4) {
	$mycontent = strip_shortcodes($content);
	$mycontent = str_replace(']]>', ']]&gt;', $mycontent);
	$mycontent = strip_tags($mycontent);
	$words = explode(' ', $mycontent, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		$mycontent = implode(' ', $words);
	endif; 
	//print_r($words);
	return $mycontent;
}

function myExcerpts($content = false,$excerpt_length=200) {
	global $post;
	$mycontent = $post->post_excerpt;

	$mycontent = $post->post_content;
	$mycontent = strip_shortcodes($mycontent);
	$mycontent = str_replace(']]>', ']]&gt;', $mycontent);
	$mycontent = strip_tags($mycontent);
	$words = explode(' ', $mycontent, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '...');
		$mycontent = implode(' ', $words);
	endif;
	$mycontent = '<p>' . $mycontent . '</p>';
	// Make sure to return the content
	return $mycontent;
}

    /**
     * adding a dashboard widget into dashboard page.
     *
     * @global <type> $wp_dashboard_control_callbacks
     * @param <type> $widget_id
     * @param <type> $widget_name
     * @param <type> $callback
     *
     * @author Onnay Okheng
     */
    function addDashboardTokokoo() {
        wp_add_dashboard_widget( 'tokokoo-widget', 'Tokokoo News', 'dashboardTokokoo' );
    }

    function dashboardTokokoo() {
         $rss_url = 'http://feeds.feedburner.com/tokokoo';

        $rss = @fetch_feed($rss_url);

        if (is_wp_error($rss)) {
            if (is_admin() || current_user_can('manage_options')) {
                printf(__('<strong>RSS Error</strong>: %s'), $rss->get_error_message());
            }
        } elseif (!$rss->get_item_quantity()) {
            return FALSE;
        } else {
            wp_widget_rss_output($rss, array('items' => 5, 'show_summary' => TRUE, 'show_date' => TRUE));
        }

        $printout_html = <<< HTML
        <div class="stream">
                    <div class="logo-small">Tokokoo</div>
                    <ul>
                        <li><a id="icl-publishing-rss" href="$rss_url" target="_blank" >RSS</a></li>
                        <li><a id="icl-publishing-twit" href="http://twitter.com/tokokoo" target="_blank" >Twitter</a></li>
                        <li><a id="icl-publishing-email" href="http://tokokoo.com/support" target="_blank" >Support</a></li>
                    </ul>
        </div>
HTML;

        echo $printout_html;
    }


    // Adding style on admin page
    function tokokoo_themes_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/tokokoo_admin.css" media="screen" />';
    }

    add_action('wp_dashboard_setup' , 'addDashboardTokokoo');
    add_action('admin_head'         , 'tokokoo_themes_admin_head');

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

    add_action('admin_menu','themes_administration');
    
    function themes_administration(){
        $themename = get_option('current_theme');
        
        // Check all the Options, then if the no options are created for a ralitive sub-page... it's not created.
        if(function_exists(add_object_page)){
            add_object_page ('Page Title', $themename, 8,'dashboard', 'tokokoo_buy_theme', get_bloginfo('template_url'). '/img/icon.png');
        } else {
            add_menu_page ('Page Title', $themename, 8,'tokokoo_themes_home', 'tokokoo_buy_theme', get_bloginfo('template_url'). '/img/icon.png');
        }

        add_submenu_page('dashboard', $themename, 'Dashboard',        8, 'dashboard', 'tokokoo_buy_theme');       // Theme Buy Themes
        add_submenu_page('dashboard', $themename, 'Theme Options',    8, 'tokokoo',   'tokokoo_themes_page');     // Theme Options
        add_submenu_page('dashboard', $themename, 'Theme Changelog',  8, 'changelog', 'tokokoo_changelog');       // Theme Changelog

    }
    
    // Display the premium theme panel image
    function tokokoo_themes_page(){
    ?>

        <div class="wrap" id="tk_options">
            <img src="<?php echo get_bloginfo('template_url');?>/img/Theme Panel Tokokoo.jpg" alt="tokokoo appcloud free theme"/>
        </div>

    <?php
    }
    
    // Display the changelog of theme
    function tokokoo_changelog(){
    ?>

        <div class="wrap" id="tk_options">
            <h2><?php _e( 'Changelog', 'tokokoo'); ?> - <?php echo get_option('current_theme'); ?></h2>
            <pre>
            <?php
                $log_file   = file(get_bloginfo('template_url').'/changelog.txt');
                $log        = implode($log_file);
                echo $log;
            ?>
            </pre>
        </div>

    <?php
    }
    
    // Display other themes of tokokoo.
    function tokokoo_buy_theme(){
?>
<div class="wrap">
<div id="icon-index" class="icon32"><br></div><h2>Tokokoo - Dashboard</h2>
	
<div id="dashboard-widgets-wrap">
    <?php tk_message_deals(); ?>
    <div id="dashboard-widgets" class="metabox-holder">
        <div id="postbox-container-1" class="postbox-container" style="width:50%;">
            <div id="normal-sortables" class="meta-box-sortables">

                <div id="tokokoo_themes" class="postbox ">
                    <h3 class="hndle"><span>Tokokoo Latest Themes</span></h3>
                    <div class="inside">
                        <div class="rss-widget">
                            <?php tk_rss_output(); ?>                            
                        </div>
                        <a href="http://tokokoo.com/tokokoo-themes/" target="_blank" class="button" style="display: block;
border-radius: 4px;
padding: 10px;
text-align: center;">VIEW ALL</a>
                    </div>
                </div>
                
            </div>	
        </div>
        
        <div id="postbox-container-2" class="postbox-container" style="width:50%;">        
				
				<div id="tokokoo_support" class="postbox ">
					<h3 class="hndle"><span>Tokokoo Useful Links</span></h3>
                    <div class="inside">
                        <div class="rss-widget">
                            <ul>
                                <li style="display: block; border-bottom: 1px solid #ddd; padding-bottom: .5em;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://tokokoo.com/ticketing/" title="Tokokoo ticketing" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/support1.png">Ticketing</a>
									<span class="desc">Find a bug or need a support? Submit your ticket!</span>
								</li>
								
                                <li style="display: block; border-bottom: 1px solid #ddd; padding-bottom: .5em;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://tokokoo.com/support/" title="Tokokoo Documentation" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/docs1.png">Documentation</a>
									<span class="desc">Before you start everything, please read our documentations!</span>
								</li>
								
                                <li style="display: block; border-bottom: 1px solid #ddd; padding-bottom: .5em;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://tokokoo.com/contact/" title="Tokokoo Contact" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/contact1.png">Contact</a>
									<span class="desc">Need an intensive support, contact us!</span>
								</li>
								
								<li style="display: block; border-bottom: 1px solid #ddd; padding-bottom: .5em;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://tokokoo.com/faq/" title="FAQ" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/faq.png">FAQ</a>
									<span class="desc">Guaranteed answer for your frequently asked questions</span>
								</li>
								
								<li style="display: block; border-bottom: 1px solid #ddd; padding-bottom: .5em;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://tokokoo.com/knowledge-base/" title="knowledge base" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/kbase.png">Knowledge base</a>
									<span class="desc">Having a trouble ? Try to browse our knowledge base</span>
								</li>
								
                                <li style="display: block;">
									<a style="color: #333; font-weight: bold; display: inline-block; width: 200px;" href="http://twitter.com/tokokoo" title="Follow Us" target="_blank"><img style="vertical-align: middle; margin-right: 5px;" src="http://tokokoo.com/wp-content/uploads/2012/06/twitter1.png">Twitter account</a>
									<span class="desc">Get in touch with us by following us on twitter</span>
								</li>
                            </ul>

                        </div>                    
                    </div>
                </div>
				
                <div id="tokokoo_news" class="postbox ">
                    <h3 class="hndle"><span>Tokokoo News</span></h3>
                    <div class="inside">
                        <div class="rss-widget">
                            <?php 
                                // get RSS FEED
                                $rss_url = 'http://feeds.feedburner.com/tokokoo';
                                $rss = @fetch_feed($rss_url);
                                
                                wp_widget_rss_output($rss, array('items' => 2, 'show_summary' => 1, 'show_date' => 1));
                            ?>
                        </div>                    
                    </div>
                </div>
            
        </div>        
        </div>

        <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div>
<!--<div class="wrap" id="tk_options">
    <h2><?php _e('Buy Another Themes', 'tokokoo'); ?></h2>
    
    <iframe frameborder="0" style="width:100%; height: 4300px; overflow: hidden;" src="http://tokokoo.com/tokokoo-themes">
     [Your user agent does not support frames or is currently configured not to display frames. However, you may visit the related document.]
    </iframe>
    
</div>-->

<?php
    }
    
    
/**
 * Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss RSS url.
 * @param array $args Widget arguments.
 */
function tk_rss_output() {
    include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
    $feed = fetch_rss('http://tokokoo.com/feed/?post_type=portfolio'); // specify feed url
    $items = array_slice($feed->items, 0, 5); // specify first and last item
    
    if (!empty($items)) :
        echo "<ul>";
        foreach ($items as $item) :
            
            /**
             *  get title and link
             */
            $link   = $item['link'];
            while ( stristr($link, 'http') != $link )
                $link = substr($link, 1);
            
            $link   = esc_url(strip_tags($link));
            $title  = esc_attr(strip_tags($item['title']));
            if ( empty($title) )
                $title = __('Untitled');
                
            /**
             *  get description
             */
            $desc   = str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( @html_entity_decode( $item['description'], ENT_QUOTES, get_option('blog_charset') ) ) ) );
            $desc   = wp_trim_words( $desc, 20 );

            $desc       = esc_html( $desc );
            $summary    = "<div class='rsssummary'>$desc</div>";
            
            // Get the image link
            $image = $item['thumb'];
            
            // Get demo link
            $demolink = $item['demolink'];
            
            /**
             * Display the list
             */
            echo "<li style='margin-bottom:10px; padding-bottom:5px; border-bottom:1px solid #ddd;'>
                        <div class='rssthumb' style='float: left;'><img src='".$image."' width='250' style='border:1px solid #ddd;'/></div>
                        <div class='rssdescription' style='float: right; width: 48%;'>
                            <a class='rsswidget' href='$link' title='$desc'>$title</a>
                            {$summary}<br/>
                            <a href='$link' class='button' target='_blank'>See Detail</a> <a href='$demolink' class='button-primary' target='_blank'>Demo</a>
                        </div>
                        <div class='clear'></div>
                  </li>";
            
            
        endforeach;
        echo "</ul>";
    endif;
}

function tk_message_deals(){
    include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
    $feed = fetch_rss('http://tokokoo.com/deals/?wpd_feed_action=rss'); // specify feed url
    $items = array_slice($feed->items, 0, 1); // specify first and last item
    
    if (!empty($items)) :
        foreach ($items as $item) :
?>

    <div id="message" style="
  *zoom: 1;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #8F9C21), color-stop(100%, #768818));
  background-image: -webkit-linear-gradient(top, #8F9C21, #768818);
  background-image: -moz-linear-gradient(top, #8F9C21, #768818);
  background-image: -o-linear-gradient(top, #8F9C21, #768818);
  background-image: -ms-linear-gradient(top, #8F9C21, #768818);
  background-image: linear-gradient(top, #8F9C21, #768818);
  height: 40px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -ms-border-radius: 5px;
  -o-border-radius: 5px;
  border-radius: 5px;
  border:3px solid #5b6b0e;
  padding:10px;
  margin: 10px 0;
  ">
        <p>
            <span style="
                color: #fff;
                font-family: georgia;
                font-size: 20px;
                text-shadow: 2px 2px 0px #5b6b0e;
            "><?php echo $item['title']; ?></span> 
            <a href="<?php echo $item['link']; ?>" target="_blank" style="
*zoom: 1;
background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #f4f4f4), color-stop(100%, #cccccc));
background-image: -webkit-linear-gradient(top, #f4f4f4, #cccccc);
background-image: -moz-linear-gradient(top, #f4f4f4, #cccccc);
background-image: -o-linear-gradient(top, #f4f4f4, #cccccc);
background-image: -ms-linear-gradient(top, #f4f4f4, #cccccc);
background-image: linear-gradient(top, #f4f4f4, #cccccc);
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-ms-border-radius: 2px;
-o-border-radius: 2px;
border-radius: 5px;
border: 2px solid #5b6b0e;
padding: 10px 25px;
text-decoration: none;
color: #333;
float: right;
margin-top: -12px;
text-shadow: 1px 1px 0px #F4F4F4;
font-weight:bold;">VIEW DEALS</a></p>
    </div>
                
<?php 
        endforeach;
    endif;
    
} 


	
    // remove default jQuery from Plugin
    add_action('init', 'tk_load_js');
    function tk_load_js(){
        if(!is_admin()){
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js');
            wp_enqueue_script('jquery');
        }
    }


    /**
     * sometimes on multisite of WordPress setting, the plugin of WPEC is not installed automatically,
     * So this function is for install the plugin.
     * checking if the plugin has installed.
     *
     * @author Onnay Okheng (@onnayokheng)
     * @since July 14, 2012. When the sky is dark ;)
     */
    if ( function_exists('wpsc_core_setup_globals') && is_multisite() ) {

        // get option setup themes.
        $setup  = get_option('tk_setup_plugin');

        if(empty($setup)){ // checking if option is empty.
            add_option('tk_setup_plugin', 0);
            add_action('init', 'tk_setup_plugin' ); // call 'tk_setup_plugin' function.
        }

        function tk_setup_plugin(){
            global $wpdb;
            // get option setup themes.
            $setup  = get_option('tk_setup_plugin');
            $count  = $wpdb->get_var('SELECT COUNT(*) FROM `'.WPSC_TABLE_CURRENCY_LIST.'`'); // get count of 'WPSC_TABLE_CURRENCY_LIST' from table.

            if($setup != 1 && $count < 1){
                $wpec   = new WP_eCommerce(); // create new class.
                $wpec->install(); // install wpec plugin data.

                update_option('tk_setup_plugin', 1);
            }
        }
    }
    
?>