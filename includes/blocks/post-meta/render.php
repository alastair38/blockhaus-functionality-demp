<?php
/**
 * Post meta block.
 *
 * @param array  $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id The post ID the block is rendering content against.
 *                     This is either the post ID currently being displayed inside a query loop,
 *                     or the post ID of the post hosting this block.
 * @param array $context The context provided to the block by the post or its parent block.
 */

// Support custom id values.
$block_id = '';
if ( ! empty( $block['anchor'] ) ) {
    $block_id = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className".
$class_name = 'demo-author-block-acf';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

/**
 * A template string of blocks.
 * Need help converting block HTML markup to an array?
 * 👉 https://happyprime.github.io/wphtml-converter/
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
 */
$inner_blocks_template = array(
   
    array(
              'blockhaus/date',
              array(
                  'name' => 'blockhaus/date'
              ),
          ),
          array(
            'blockhaus/author',
            array(
                'name' => 'blockhaus/author'
            ),
        ),
    array(
      'blockhaus/places',
      array(
          'name' => 'blockhaus/places'
      ),
  ),
);

if(!is_post_type_archive(['place'])):
?>

    <InnerBlocks
        <?php echo get_block_wrapper_attributes();?>
        template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
    />

    <?php endif;?>