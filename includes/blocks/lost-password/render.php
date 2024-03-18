<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 $class_name = 'demo-author-block-acf';
 if ( ! empty( $block['className'] ) ) {
     $class_name .= ' ' . $block['className'];
 }

$readMore = 'Read more';

if(is_singular('blog-de') || is_singular('place-de') || get_post_type($post_id) === 'blog-de' || get_post_type($post_id) === 'place-de'):
  $readMore = 'Mehr lesen';
elseif(is_singular('blog-fr') || is_singular('place-fr') || get_post_type($post_id) === 'blog-fr' || get_post_type($post_id) === 'place-fr'):
  $readMore = 'En savoir plus';
else:
  $readMore = 'Read more';
endif;


if(!is_user_logged_in(  )):
  
if(is_admin()):?>

<a class="wp-block-blockhaus-lost-password is-style-button" alt="<?php esc_attr_e( 'Reset password', 'textdomain' ); ?>">
  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 3.5c2.414 1.377 4 4.022 4 7a8 8 0 1 1-8-8"/><path d="M14.5 7.5v-4h4"/></g></svg>
	<?php esc_html_e( 'Reset password', 'textdomain' ); ?>
</a>

<?php else: ?>

<a class="wp-block-blockhaus-lost-password is-style-button" href="<?php echo esc_url( wp_lostpassword_url() ); ?>" alt="<?php esc_attr_e( 'Reset password', 'textdomain' ); ?>">
  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 3.5c2.414 1.377 4 4.022 4 7a8 8 0 1 1-8-8"/><path d="M14.5 7.5v-4h4"/></g></svg>
	<?php esc_html_e( 'Reset password', 'textdomain' ); ?>
</a>

<?php endif;
endif;
?>


