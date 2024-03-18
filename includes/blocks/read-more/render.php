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

if(is_singular('blog-de') || is_singular('place-de') || is_singular('resources-de') || get_post_type($post_id) === 'blog-de' || get_post_type($post_id) === 'place-de' || get_post_type($post_id) === 'resources-de'):
  $readMore = 'Mehr lesen';
elseif(is_singular('blog-fr') || is_singular('place-fr') || is_singular('resources-fr') || get_post_type($post_id) === 'blog-fr' || get_post_type($post_id) === 'place-fr' || get_post_type($post_id) === 'resources-fr'):
  $readMore = 'En savoir plus';
else:
  $readMore = 'Read more';
endif;

if(is_admin()):?>

<a class="wp-block-blockhaus-read-more is-style-button" >
  <?php echo $readMore;?> 
  <span class="screen-reader-text">: <?php echo get_the_title($post_id);?></span>
</a>

<?php else: ?>

<a href="<?php echo get_permalink($post_id);?>" class="wp-block-blockhaus-read-more is-style-button" >
  <?php echo $readMore;?> 
  <span class="screen-reader-text">: <?php echo get_the_title($post_id);?></span>
</a>

<?php endif;?>


