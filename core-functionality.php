<?php
/*
Plugin name: Blockhaus Base Functionality
Description: Custom fields and Gutenberg blocks
Text Domain: blockhaus
*/

// Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', plugin_dir_path( __FILE__ ) . '/includes/acf/' );
// define( 'MY_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/' );

define( 'MY_ACF_URL', plugins_url( '/includes/acf/', __FILE__ ) );

// Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) {
    return true;
}

define( 'MY_PLUGIN_DIR_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) . '/includes/' ) );


add_filter('acf/settings/save_json', 'acf_json_save_point');
 
function acf_json_save_point( $path ) {
    
    // Update path
    $path = plugin_dir_path( __FILE__ ). 'includes/acf-json';
    
    // Return path
    return $path;
    
}

add_filter('acf/settings/load_json', 'acf_json_load_point');
 
function acf_json_load_point( $path ) {
    
    // Update path
    $path = plugin_dir_path( __FILE__ ). 'includes/acf-json';
    
    // Return path
    return $path;
    
}


function blockhaus_custom_images() {
	// add_image_size( 'landscape', 800, 450, array( 'center', 'center' ) ); // adds 800 pixels wide by 450 pixels tall image option, hard crop mode
	// add_image_size( 'hero', 1600, 1100, array( 'center', 'center' ) ); // adds 1600 pixels wide by 1100 pixels tall image option, hard crop mode
	// add_image_size( 'header', 1500, 500, array( 'center', 'center' ) ); // adds 1600 pixels wide by 1100 pixels tall image option, hard crop mode
	// add_image_size( 'blog', 500, 300, array( 'center', 'center' ) ); // adds 500 pixels wide by 300 pixels tall image option, hard crop mode
	add_image_size( 'social-media', 800, 418, array( 'center', 'center' ) ); // adds 800 pixels wide by 418 pixels tall image option, hard crop mode
}

add_action( 'after_setup_theme', 'blockhaus_custom_images' );

function blockhaus_image_names( $sizes ) {
	return array_merge( $sizes, array(
			// 'landscape' => __( 'Landscape' ),
			// 'hero' => __( 'Hero' ),
			// 'header' => __( 'Header' ),
			// 'blog' => __( 'Blog layout' ),
			'social-media' => __( 'Social media' ),
	) );
}

add_filter( 'image_size_names_choose', 'blockhaus_image_names' );

/**
 * Load Custom Blocks
 */
function blockhaus_load_blocks() {
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/funders/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/versions/block.json' );
}
add_action( 'init', 'blockhaus_load_blocks' );



function blockhaus_metatags() {
	
	global $post;
		
	/* default values for metatag properties */
	
	$author_name = '';
	$img = get_template_directory_uri() . '/assets/images/social/og.jpg';
	$type = 'website';
	$permalink = get_the_permalink();
	
		/* get social_image if it has been added. This will override the social image supplied with the theme */
	
		if(function_exists('get_field')):
			
			$img = get_field('social_image', 'option');
			
				if($img):
				
					$img = $img['sizes']['social-media'];
					
				endif;
				
		endif;
		
		/* set the $title, $type, $img, $locale and $excerpt values for single content items */
		
		if(is_page() || is_singular()):
			
			$title = get_the_title();
			$type = 'article';
			$author_id = $post->post_author;get_the_author_meta( 'nicename', $post->ID );
			$author_name = get_the_author_meta( 'nicename', $author_id );

			if(has_post_thumbnail($post->ID)) {
				
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full');
			$img = $img_src[0];
			
			}
			
			if ( is_singular('resources-de') || is_singular('blog-de')):
		
				$locale = 'de';
	
	
			elseif ( is_singular('resources-fr') || is_singular('blog-fr')):
				
				$locale = 'fr';
				
			else: 
				
				$lang = get_the_terms( get_the_ID(), 'language' );
				
				if ($lang):
				
					$locale = $lang[0]->slug;
					
				else:
					
					$locale = 'en';
					
				endif;
			
			endif;

			if(has_excerpt()) {
				/* check is content has an excerpt and strip out tags etc */
				$excerpt = strip_tags($post->post_excerpt);
				$excerpt = str_replace("", "'", $excerpt);
			
			} else {
				
				/* if content does not have an excerpt, generate one from the post_content itself. This will avoid non English items from having the default site description (in English) used */
				$excerpt = strip_tags($post->post_content);
				$excerpt = str_replace( array("\n", "\'", "\"", "\r", "\t"), ' ', $excerpt );
				$excerpt = mb_substr( $excerpt, 0, 170, 'utf8' );
				$excerpt = normalize_whitespace($excerpt);
			
			}
			
		/* set the $title, $excerpt, $locale and $permalink values for archive pages. $type and $img will use the global defaults */

		elseif(is_archive() && ! is_search()):

			$permalink = get_post_type_archive_link($post->post_type);
			
			if ( is_post_type_archive('blog-de') || is_post_type_archive('resources-de') ):
				
				$title = get_the_archive_title();
				
				if(function_exists('get_field')):
			
					$excerpt = get_field('german_site_description', 'option');
	
				endif;
				
				$locale = 'de';
	
			elseif ( is_post_type_archive('blog-fr') || is_post_type_archive('resources-fr') ):
				
				$title = get_the_archive_title();
				
				if(function_exists('get_field')):
			
					$excerpt = get_field('french_site_description', 'option');
	
				endif;
				
				$locale = 'fr';
			
			elseif ( is_post_type_archive('post' )):
				
				$title = single_post_title('',false);
				$excerpt = get_bloginfo('description');
				$locale = 'en';
				
			else: 
				
				$title = get_the_archive_title();
				$excerpt = get_bloginfo('description');
				$locale = 'en';
					
			endif;
			
		/* set the $title and $excerptvalues for the search page. $type and $img will use the global defaults */

		elseif(is_search()):

			//check this out on language pages
			
			$title = get_bloginfo('title') . ' search results for keyword ' . get_search_query();
			$excerpt = get_bloginfo('description');

		else:

			$title = get_bloginfo('title');
			$excerpt = get_bloginfo('description');

		endif;
	
	
		/* set the $locale depending on page type */
	
		// if ( is_singular('resources-de') || is_singular('blog-de') || is_post_type_archive('blog-de') || is_post_type_archive('resources-de') ):
		
		// 	$locale = 'de';


		// elseif ( is_singular('resources-fr') || is_singular('blog-fr')  || is_post_type_archive('blog-fr') || is_post_type_archive('resources-fr') ):
			
		// 	$locale = 'fr';
			
		// else: 
			
		// 	$lang = get_the_terms( get_the_ID(), 'language' );
			
		// 	if ($lang):
			
		// 		$locale = $lang[0]->slug;
				
		// 	else:
				
		// 		$locale = 'en';
				
		// 	endif;
		
		// endif;?>
	
	<!-- output metatags -->
		<?php if($author_name):?>
		<meta name="author" content="<?php echo $author_name;?>" />
		<?php endif;?>
		<meta name="description" content="<?php echo strip_tags($excerpt); ?>"/>
		<meta property="og:locale" content="<?php echo $locale;?>">
		<meta property="og:title" content="<?php echo strip_tags($title); ?>"/>
    <meta property="og:description" content="<?php echo strip_tags($excerpt); ?>"/>
    <meta property="og:type" content="<?php echo $type; ?>"/>
    <meta property="og:url" content="<?php echo esc_url($permalink); ?>"/>
    <meta property="og:site_name" content="<?php echo strip_tags(get_bloginfo()); ?>"/>
    <meta property="og:image" content="<?php echo $img; ?>"/>
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="<?php echo esc_url($permalink); ?>" />
    <meta name="twitter:title" content="<?php echo strip_tags($title); ?>" />
    <meta name="twitter:description" content="<?php echo strip_tags($excerpt); ?>" />
    <meta name="twitter:image" content="<?php echo $img; ?>" />
	
	
<?php }

add_action( 'wp_head', 'blockhaus_metatags',2);

/* This function sets the correct language attribute depending on post types and / or the manually set language taxonomy. We also set the attribute on default language pages as this is recognised as best practice on multilingual sites */

function setLangAttr() {
	
	if ( is_singular('resources-de') || is_singular('blog-de') || is_post_type_archive('blog-de') || is_post_type_archive('resources-de') ):
	
    return 'lang="de"';

	elseif ( is_singular('resources-fr') || is_singular('blog-fr')  || is_post_type_archive('blog-fr') || is_post_type_archive('resources-fr') ):
		
		/* open graph tags in FR */
    return 'lang="fr"';
	
	elseif ( is_page() || is_single() ):
		
		$lang = get_the_terms( get_the_ID(), 'language' );
		
		if ($lang):
		
		/* open graph tags in lang */
    return 'lang="' . $lang[0]->slug . '"';
		endif;
		
	elseif ( is_singular('post') || is_singular('resources') || is_post_type_archive('resources') || is_post_type_archive('post') ):
		
		return 'lang="en"';
		
	else: 
		
		return 'lang="en"';
		
	endif;
	
}   

add_filter( 'language_attributes', 'setLangAttr' );

/* This function adds the required hreflang tags to the head where other language versions exists */

if ( ! function_exists( 'hreflang_blockhaus' ) ) {
	function hreflang_blockhaus() {
		if ( is_singular()) {
			
			if(function_exists('get_field')):
				//get the contents of the relationship field for this content item
				$versions = get_field('language_versions', get_the_ID());
		
				if($versions):?>

				<?php foreach($versions as $version):
				// get the assigned language, if any, to check if content is not from a lingual resource post type
					$lang = get_the_terms( $version->ID, 'language' );  
				?>
 
						<?php if(($version->post_type === 'resources-fr') || ($lang && $lang[0]->slug === 'fr')):?>
		 
							<link rel="alternate" href="<?php echo get_the_permalink($version->ID);?>" hreflang="fr">
						
						<?php elseif(($version->post_type === 'resources-de') || ($lang && $lang[0]->slug === 'de')):?>
		
							<link rel="alternate" href="<?php echo get_the_permalink($version->ID);?>" hreflang="de">
								
						<?php else: ?>
						 
							<link rel="alternate" href="<?php echo get_the_permalink($version->ID);?>" hreflang="x-default">
							<link rel="alternate" href="<?php echo get_the_permalink($version->ID);?>" hreflang="en">
											
						<?php endif;?>
		
				<?php endforeach;?> 
	
				<?php endif;
		
		endif;
			
		}
		
		if(is_post_type_archive('resources') || is_post_type_archive('resources-de') || is_post_type_archive('resources-fr')):?>
			
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'resources' ); ?>" hreflang="x-default">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'resources' ); ?>" hreflang="en">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'resources-fr' ); ?>" hreflang="fr">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'resources-de' ); ?>" hreflang="de">
			
		<?php endif;
		
		if(is_home() || is_post_type_archive('blog-de') || is_post_type_archive('blog-fr')):?>
			
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'post' ); ?>" hreflang="x-default">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'post' ); ?>" hreflang="en">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'blog-fr' ); ?>" hreflang="fr">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'blog-de' ); ?>" hreflang="de">
			
		<?php endif;
	}
}
add_action( 'wp_head', 'hreflang_blockhaus' );


/**
 * Adapted from the following to duplicate resources to French and German resources custom post types
 * @snippet  Duplicate posts and pages without plugins
 * @author   Misha Rudrastyh
 * @url      https://rudrastyh.com/wordpress/duplicate-post.html
 */

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

function rd_duplicate_post_link( $actions, $post ) {
	
	if ( $post->post_type == "resources" ) {

	if( ! current_user_can( 'edit_posts' ) ) {
		return $actions;
	}

	$url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'rd_duplicate_post_as_draft',
				'post' => $post->ID,
			),
			'admin.php'
		),
		basename(__FILE__),
		'duplicate_nonce'
	);

	$actions[ 'duplicate' ] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Create language copies</a>';
	
}
	return $actions;

}

add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

function rd_duplicate_post_as_draft(){

	// check if post ID has been provided and action
	if ( empty( $_GET[ 'post' ] ) ) {
		wp_die( 'No resource to duplicate has been provided!' );
	}

	// Nonce verification
	if ( ! isset( $_GET[ 'duplicate_nonce' ] ) || ! wp_verify_nonce( $_GET[ 'duplicate_nonce' ], basename( __FILE__ ) ) ) {
		return;
	}

	// Get the original post id
	$post_id = absint( $_GET[ 'post' ] );

	// And all the original post data then
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	// if post data exists (I am sure it is, but just in a case), create the post duplicate
	if ( $post ) {

		// new post data array
		$args_fr = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => 'resources-fr',
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
		
		$args_de = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => 'resources-de',
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		// insert the post by wp_insert_post() function
		$new_fr_post_id = wp_insert_post( $args_fr );
		
		$new_de_post_id = wp_insert_post( $args_de );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies( get_post_type( $post ) ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		if( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_de_post_id, $post_terms, $taxonomy, false );
				wp_set_object_terms( $new_fr_post_id, $post_terms, $taxonomy, false );
			}
		}

		// duplicate all post meta
		$post_meta = get_post_meta( $post_id );
		if( $post_meta ) {

			foreach ( $post_meta as $meta_key => $meta_values ) {

				if( '_wp_old_slug' == $meta_key ) { // do nothing for this meta key
					continue;
				}

				foreach ( $meta_values as $meta_value ) {
					add_post_meta( $new_de_post_id, $meta_key, $meta_value );
					add_post_meta( $new_fr_post_id, $meta_key, $meta_value );
				}
			}
		}

		// finally, redirect to the edit post screen for the new draft
		// wp_safe_redirect(
		// 	add_query_arg(
		// 		array(
		// 			'action' => 'edit',
		// 			'post' => $new_post_id
		// 		),
		// 		admin_url( 'post.php' )
		// 	)
		// );
		// exit;
		// or we can redirect to all posts with a message
		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
					'saved' => 'post_duplication_created' // just a custom slug here
				),
				admin_url( 'edit.php' )
			)
		);
		exit;

	} else {
		wp_die( 'Post creation failed, could not find original post.' );
	}

}

/*
 * In case we decided to add admin notices
 */
add_action( 'admin_notices', 'rudr_duplication_admin_notice' );

function rudr_duplication_admin_notice() {

	// Get the current screen
	$screen = get_current_screen();

	if ( 'edit' !== $screen->base ) {
		return;
	}

    //Checks if settings updated
    if ( isset( $_GET[ 'saved' ] ) && 'post_duplication_created' == $_GET[ 'saved' ] ) {

		 echo '<div class="notice notice-success is-dismissible"><p style="font-size:16px; text-transform: uppercase;">Copies of this content have been created in the other language resources sections and are ready for translation.</p></div>';
		 
    }
}

function enqueue_admin_custom_css() {
	wp_enqueue_style( 'admin-custom', get_stylesheet_directory_uri() . '/assets/css/admin-custom.css' );
}


add_action( 'admin_enqueue_scripts', 'enqueue_admin_custom_css' );