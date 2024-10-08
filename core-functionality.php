<?php
/*
Plugin name: Blockhaus Base Functionality
Description: Custom fields and Gutenberg blocks
Text Domain: core-functionality
Domain Path: /languages/
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
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/archive-description/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/author/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/comment-number/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/cookie-consent/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/copyright/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/date/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/down-arrow/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/files/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/funders/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/lost-password/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/no-results/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/places/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/places-grid/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/post-meta/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/privacy-links/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/read-more/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/scroll-top/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/type/block.json' );
	register_block_type( plugin_dir_path( __FILE__ ) . '/includes/blocks/versions/block.json' );
}
add_action( 'init', 'blockhaus_load_blocks' );


/* Update post labels */

add_action( 'init', 'blockhaus_change_post_object' );
// Change dashboard Posts to Articles
function blockhaus_change_post_object() {
    $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
        $labels->name = 'Articles';
        $labels->singular_name = 'Article';
        $labels->add_new = 'Add Article';
        $labels->add_new_item = 'Add Article';
        $labels->edit_item = 'Edit Article';
        $labels->new_item = 'Article';
        $labels->view_item = 'View Article';
        $labels->search_items = 'Search Articles';
        $labels->not_found = 'No Articles found';
        $labels->not_found_in_trash = 'No Articles found in Trash';
        $labels->all_items = 'All Articles';
        $labels->menu_name = 'Articles';
        $labels->name_admin_bar = 'Articles';
}

function blockhaus_seo() {
	
	global $post;
	
	// set default values
	$title = get_bloginfo('title');
	$author_name = '';
	$img = get_template_directory_uri() . '/assets/images/social/og.jpg';
	$img_alt = 'Two older women and an older man walking arm in arm';
	$type = 'website';
	$permalink = get_the_permalink();
	$excerpt = get_bloginfo( 'description' );
	$queried_object = get_queried_object();
	
	// get html language attr > returns lang="lang_code". Remove the " with str_replace so we can then use substr and strpos to get the code after the = . This will work with any lang code.
	$langAttr = get_language_attributes( );
	$locale = str_replace('"', '', $langAttr);
	$locale = substr($locale, strpos($locale, "=") + 1);
			
	if(is_singular()):
		// set title etc for single pages / cpts
		$title = get_the_title();
		$type = 'article';
		$author_id = $post->post_author;
		$author_name = get_the_author_meta( 'nicename', $author_id );
		
		if(has_post_thumbnail($post->ID)) {
			// set social img to post_thumbnail, if it exists
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full');
			$img_alt = get_post_meta(get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true);
			$img = $img_src[0];	
		}
		
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
		
	elseif(is_post_type_archive()):
		// set title, get postType and permalink for post type archives from queried_object - use this as get_post_type only works if there is archive content
		$title = post_type_archive_title( '', false );
		$postType = $queried_object->name;
		$permalink = get_post_type_archive_link($queried_object->name);
		
		if(function_exists('get_field')):
			$excerpt = get_field( $postType, 'option' );
		endif;
		
	elseif(is_home()):
		// set title and get permalink for blog page
		$title = single_post_title('',false);
		$permalink = get_post_type_archive_link('post');
		
		if(function_exists('get_field')):
			$excerpt = get_field( 'post', 'option' );
		endif;
		
	elseif(is_search()):
		// set title and get permalink for search page
		$title = 'Search results for keyword ' . get_search_query();
		$permalink = get_search_link();
		
	endif;

// only set the author meta tag if an author exists
if(!empty($author_name)):?>
<meta name="author" content="<?php echo $author_name;?>" />
<?php endif;?>

<meta name="description" content="<?php echo strip_tags(mb_substr( $excerpt, 0, 170, 'utf8' )); ?>"/>
<meta property="og:locale" content="<?php echo $locale;?>">
<meta property="og:title" content="<?php echo strip_tags($title); ?>"/>
<meta property="og:description" content="<?php echo strip_tags($excerpt); ?>"/>
<meta property="og:type" content="<?php echo $type; ?>"/>
<meta property="og:url" content="<?php echo esc_url($permalink); ?>"/>
<meta property="og:site_name" content="<?php echo strip_tags(get_bloginfo()); ?>"/>
<meta property="og:image" content="<?php echo $img; ?>"/>
<meta property="og:image:alt" content="<?php echo $img_alt; ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="<?php echo esc_url($permalink); ?>" />
<meta name="twitter:title" content="<?php echo strip_tags($title); ?>" />
<meta name="twitter:description" content="<?php echo strip_tags($excerpt); ?>" />
<meta name="twitter:image" content="<?php echo $img; ?>" />
<meta name="twitter:image:alt" content="<?php echo $img_alt; ?>" />
			
<?php }

add_action( 'wp_head', 'blockhaus_seo',2);

/* This function sets the correct language attribute depending on post types and / or the manually set language taxonomy. We also set the attribute on default language pages as this is recognised as best practice on multilingual sites */

function setLangAttr() {
	
	if(!is_admin()):
	
		if ( is_singular('resources-de') || is_singular('blog-de') || is_singular('place-de') || is_post_type_archive('blog-de') || is_post_type_archive('resources-de') || is_post_type_archive('place-de') ):
		
		switch_to_locale('de_DE');
		return 'lang="de"';

		elseif ( is_singular('resources-fr') || is_singular('blog-fr') || is_singular('place-fr') || is_post_type_archive('blog-fr') || is_post_type_archive('resources-fr') || is_post_type_archive('place-fr') ):
			
			switch_to_locale('fr_FR');
			return 'lang="fr"';
		
		elseif ( is_page()  ):
			
			$lang = get_the_terms( get_the_ID(), 'language' );
			
			if ($lang):
			
			$locale = $lang[0]->slug . '_' . strtoupper($lang[0]->slug); 
			/* open graph tags in lang */
			switch_to_locale($locale);
			return 'lang="' . $lang[0]->slug . '"';
			
			else:
				
			switch_to_locale('en_GB');
			return 'lang="en"';
		
			endif;
			
		elseif ( is_singular('post') || is_singular('resources') || is_post_type_archive('resources') || is_post_type_archive('post') ):
			
			switch_to_locale('en_GB');
			return 'lang="en"';
			
		else: 
			
			switch_to_locale('en_GB');
			return 'lang="en"';
			
		endif;
	
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
 
						<?php if(($version->post_type === 'resources-fr') || ($version->post_type === 'place-fr') || ($lang && $lang[0]->slug === 'fr')):?>
		 
							<link rel="alternate" href="<?php echo get_the_permalink($version->ID);?>" hreflang="fr">
						
						<?php elseif(($version->post_type === 'resources-de') || ($version->post_type === 'place-de') || ($lang && $lang[0]->slug === 'de')):?>
		
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
		
		if(is_post_type_archive('place') || is_post_type_archive('place-de') || is_post_type_archive('place-fr')):?>
			
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'place' ); ?>" hreflang="x-default">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'place' ); ?>" hreflang="en">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'place-fr' ); ?>" hreflang="fr">
			<link rel="alternate" href="<?php echo get_post_type_archive_link( 'place-de' ); ?>" hreflang="de">
			
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


function blockhaus_locale_date_formatter($post_id) {

	//use $post_id passed in from the registered block context to get the post type which we then use to switch the locale to allow us to use the built-in wp_date() function for outputting localized dates
	
	$type = get_post_type($post_id);
	
	if($type === 'resources-de' || $type === 'blog-de'):
	
	switch_to_locale( 'de_DE' );
  $locale_date = wp_date( get_option( 'date_format' ), get_post_timestamp($post_id) ); 
	switch_to_locale( 'en_GB' );
		
	elseif($type === 'resources-fr' || $type === 'blog-fr'):
	
	switch_to_locale( 'fr_FR' );
  $locale_date = wp_date( get_option( 'date_format' ), get_post_timestamp($post_id) ); 
	switch_to_locale( 'en_GB' );
	
	elseif($type === 'place-fr'):
	
	switch_to_locale( 'fr_FR' );
	$locale_date = null; 
	switch_to_locale( 'en_GB' );
	
	elseif($type === 'place-de'):
	
	switch_to_locale( 'de_DE' );
	$locale_date = null; 
	switch_to_locale( 'en_GB' );
	
	elseif($type === 'resources' || $type === 'post'):
	
	switch_to_locale( 'en_GB' );
	$locale_date = wp_date( get_option( 'date_format' ), get_post_timestamp($post_id) ); 
		
	else:
		
	$locale_date = null; 

	endif;

	if($locale_date && !(is_post_type_archive(['place', 'place-de', 'place-fr']) || is_singular(['place', 'place-de', 'place-fr', 'page']))):

	return '<time class="translated-date" datetime="' . get_the_time('c') . '"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>' . $locale_date . '</time>';
	
	elseif(is_admin()):
		
	return '<small>Localized Post Date</small>';
	
	else:
	
	endif;
	
}

function blockhaus_cookie_scripts() {
	if(function_exists('get_field')):

		$cookiesSet = get_field('cookies_settings', 'option');
		
		// $cookiesSet = $cookies['cookies_set'];
		
	
	
		$consentPanel = get_field('consent_panel_settings', 'option');
		if($consentPanel):
		$privacyPage = $consentPanel['privacy_page'];
		$contactPage = $consentPanel['contact_page'];
		$privacyPageDe = $consentPanel['privacy_page_de'];
		$contactPageDe = $consentPanel['contact_page_de'];
		$privacyPageFr = $consentPanel['privacy_page_fr'];
		$contactPageFr = $consentPanel['contact_page_fr'];
		endif;
		
	
		$analyticsSet = get_field('analytics_settings', 'option');
		// $analyticsSet = $analytics['analytics_cookies_set'];
		
		$embeddedContent = get_field('social_media_settings', 'option');
	  // $enhancedPrivacy = $social_media['enhanced_privacy'];
		
	
	endif;
	
		if($cookiesSet) {
				wp_enqueue_script( 'cookie-js', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.umd.js', array(), '', true );
				
				wp_enqueue_script( 'cookie-init-js', plugin_dir_url( __FILE__ ) . 'includes/js/cookieinit.js', array('cookie-js'), wp_get_theme()->get( 'Version' ), true );
	
				wp_enqueue_style( 'cookie-style', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.css', array(), '', 'all' ); 
				
				wp_localize_script("cookie-js", "WPVars", array(
					"contact_page" => $contactPage,
					"privacy_page" => $privacyPage,
					"contact_page_de" => $contactPageDe,
					"privacy_page_de" => $privacyPageDe,
					"contact_page_fr" => $contactPageFr,
					"privacy_page_fr" => $privacyPageFr,
					"analytics" => $analyticsSet,
					"media" => $embeddedContent,
				)
			);
	
		}
		
			// wp_enqueue_script( 'blockhaus-embedPrivacy', plugin_dir_url( __FILE__ ) . 'includes/js/embedPrivacy.js', array(), wp_get_theme()->get( 'Version' ), true );
		
}

add_action( 'wp_enqueue_scripts', 'blockhaus_cookie_scripts' );


add_filter('script_loader_tag', 'add_attributes_to_script', 10, 3); 
function add_attributes_to_script( $tag, $handle, $src ) {
    if ( 'cookie-init-js' === $handle ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '" id="cookie-init-js" ></script>';
    } 
	
    return $tag;
}


// add_filter('script_loader_tag', 'add_attribute_to_script', 10, 3); 
// function add_attribute_to_script( $tag, $handle, $src ) {
  
		
// 		if ( 'blockhaus-embedPrivacy' === $handle ) {
// 			$tag = '<script data-category="analytics" data-service="youtube" data-type="module" src="' . esc_url( $src ) . '" id="blockhaus-embedPrivacy" ></script>';
// 	} 
//     return $tag;
// }

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
			'post_title'     => $post->post_title  . ' [DUPLICATE TO TRANSLATE]',
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
			'post_title'     => $post->post_title . ' [DUPLICATE TO TRANSLATE]',
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
		
		update_field('language_versions', $post_id, $new_de_post_id);
		update_field('language_versions', $post_id, $new_fr_post_id);

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

/* Enqueue admin stylesheet to  */

function enqueue_admin_custom_css() {
	wp_enqueue_style( 'admin-custom', get_stylesheet_directory_uri() . '/assets/css/admin-custom.css' );
}


add_action( 'admin_enqueue_scripts', 'enqueue_admin_custom_css' );

// Register the columns.
add_filter( "manage_resources_posts_columns", function ( $defaults ) {
	
	$defaults['versions'] = 'Versions';

	return $defaults;
} );

// Handle the value for each of the new columns.
add_action( "manage_resources_posts_custom_column", function ( $column_name, $post_id ) {

	if ( $column_name == 'versions' ) {
		// Display an ACF field
		$versions = get_field( 'language_versions', $post_id );
		if($versions):?>

			<?php foreach($versions as $version):
			// get the assigned language, if any, to check if content is not from a lingual resource post type
				$lang = get_the_terms( $version->ID, 'language' );?>
			
					<?php if(($version->post_type === 'resources-fr') || ($lang && $lang[0]->slug === 'fr')):?>
						
					 <a style="padding-right: 1rem;" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
						<?php esc_html_e( 'Français [EDIT]', 'core-functionality' );?>
					</a><br>
					
					<?php elseif(($version->post_type === 'resources-de') || ($lang && $lang[0]->slug === 'de')):?>
						
						<a style="padding-right: 1rem;" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
						<?php esc_html_e( 'Deutsch [EDIT]', 'core-functionality' );?>
						</a><br>
						
					<?php else: ?>
					 	
					<?php endif;?>
					
					
			<?php endforeach;?> 

			<?php endif;
	
	}
	
}, 10, 2 );


add_filter( "manage_resources-de_posts_columns", function ( $defaults ) {
	
	$defaults['versions'] = 'Versions';

	return $defaults;
} );

// Handle the value for each of the new columns.
add_action( "manage_resources-de_posts_custom_column", function ( $column_name, $post_id ) {

	if ( $column_name == 'versions' ) {
		// Display an ACF field
		$versions = get_field( 'language_versions', $post_id );
		if($versions):?>

			<?php foreach($versions as $version):
			// get the assigned language, if any, to check if content is not from a lingual resource post type
				$lang = get_the_terms( $version->ID, 'language' );?>
			 
					<?php if(($version->post_type === 'resources-fr') || ($lang && $lang[0]->slug === 'fr')):?>
						<a style="" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
						<?php esc_html_e( 'Français [EDIT]', 'core-functionality' );?>
					</a><br>
					<?php elseif(($version->post_type === 'resources-de') || ($lang && $lang[0]->slug === 'de')):?>
							
						
							
					<?php else: ?>
						<a style="" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
					 	<?php esc_html_e( 'English [EDIT]', 'core-functionality' );?>
					</a><br>
					<?php endif;?>
			
			<?php endforeach;?> 

			<?php endif;
	
	}
	
}, 10, 2 );

add_filter( "manage_resources-fr_posts_columns", function ( $defaults ) {
	
	$defaults['versions'] = 'Versions';

	return $defaults;
} );

// Handle the value for each of the new columns.
add_action( "manage_resources-fr_posts_custom_column", function ( $column_name, $post_id ) {

	if ( $column_name == 'versions' ) {
		// Display an ACF field
		$versions = get_field( 'language_versions', $post_id );
		if($versions):?>

			<?php foreach($versions as $version):
			// get the assigned language, if any, to check if content is not from a lingual resource post type
				$lang = get_the_terms( $version->ID, 'language' );?>
			 
					<?php if(($version->post_type === 'resources-fr') || ($lang && $lang[0]->slug === 'fr')):?>
					
					<?php elseif(($version->post_type === 'resources-de') || ($lang && $lang[0]->slug === 'de')):?>
							
						<a style="" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
						<?php esc_html_e( 'Deutsch [EDIT]', 'core-functionality' );?>
					</a><br>	
							
					<?php else: ?>
						<a style="" class="admin-versions" href="<?php echo '/wp-admin/post.php?post=' . $version->ID . '&action=edit';?>">
					 	<?php esc_html_e( 'English [EDIT]', 'core-functionality' );?>
					</a><br>
					<?php endif;?>
			
			<?php endforeach;?> 

			<?php endif;
	
	}
	
}, 10, 2 );

function blockhaus_modify_archive_order( $query ) {

  // Check we're on the frontend and modifying the main query.
  if ( ! is_admin() && $query->is_main_query() ) {

      // Change to order to A-Z for place archives.
      if ( $query->is_post_type_archive('place') ) {
        $query->set( 'order', 'ASC' );
        $query->set( 'orderby', 'title' );
      } 
			
			if ( $query->is_post_type_archive('place-de') ) {
        $query->set( 'order', 'ASC' );
        $query->set( 'orderby', 'title' );
      } 
			
			if ( $query->is_post_type_archive('place-fr') ) {
        $query->set( 'order', 'ASC' );
        $query->set( 'orderby', 'title' );
      } 

  } 
}

add_action( 'pre_get_posts', 'blockhaus_modify_archive_order' );

function order_archive_by_post_type ( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		// Not a query for an admin page.
		// It's the main query for a front end page of your site.

		if ( is_tax('place') ) {
			// It's the main query for a category archive OR adapt for custom taxonomies

			// Let's change the query for category archives, orderby post type (available since WP 4.0) in ASC order ... a,b,c
			$query->set( 'orderby', 'type' );
   $query->set( 'order', 'ASC');
		}
	}
}
add_action( 'pre_get_posts', 'order_archive_by_post_type' );