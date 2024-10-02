<?php
/**
 * Related Products
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     8.3.0
 * @flatsome-version 3.18.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
    return;
}

$cats_array = array(0);

// get categories
$terms = wp_get_post_terms( $product->get_id(), 'tac-gia' ); // Sử dụng get_id()

// select only the category which doesn't have any children
foreach ( $terms as $term ) {
    $children = get_term_children( $term->term_id, 'tac-gia' );
    if ( ! sizeof( $children ) )
        $cats_array[] = $term->term_id;
}

// Check if there are at least 2 categories
if ( sizeof( $cats_array ) >= 2 ) {

    $args = apply_filters( 'woocommerce_related_products_args', array(
        'post_type' => 'product',
        'ignore_sticky_posts' => 1,
        'no_found_rows' => 1,
        'posts_per_page' => $posts_per_page,
        'orderby' => $orderby,
        'tax_query' => array(
            array(
                'taxonomy' => 'tac-gia',
                'field' => 'id',
                'terms' => $cats_array
            ),
        ),
        'post_status' => 'publish' // Only fetch published products
    ));

    // Get current product ID
    $current_product_id = $product->get_id(); // Sử dụng get_id()

    $products                    = new WP_Query( $args );
    $woocommerce_loop['name']    = 'related';
    $woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $columns );

    if ( $products->have_posts() ) : ?>

        <div class="related related-products-wrapper product-section has-equal-box-heights equalize-box">
            <?php if ( $products->post_count > 1 ) : ?>
                <h3 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase"><?php _e( 'Sách eBook cùng tác giả', 'woocommerce' ); ?></h3>
            <?php endif; ?>

            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php 
                    // Check if the current product is the same as the related product, if yes, skip it
                    if ( $current_product_id == get_the_ID() ) {
                        continue; 
                    } ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        </div>

    <?php endif;

    // get categories
    $terms = wp_get_post_terms( $product->get_id(), 'product_cat' ); // Sử dụng get_id()

    // select only the category which doesn't have any children
    foreach ( $terms as $term ) {
        $children = get_term_children( $term->term_id, 'product_cat' );
        if ( ! sizeof( $children ) )
            $cats_array[] = $term->term_id;
    }

    $args = apply_filters( 'woocommerce_related_products_args', array(
        'post_type' => 'product',
        'ignore_sticky_posts' => 1,
        'no_found_rows' => 1,
        'posts_per_page' => $posts_per_page,
        'orderby' => $orderby,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cats_array
            ),
        )
    ));

    $products                    = new WP_Query( $args );
    $woocommerce_loop['name']    = 'related';
    $woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $columns );

    if ( $products->have_posts() ) : ?>

        <div class="related related-products-wrapper product-section has-equal-box-heights equalize-box">

            <h3 class="product-section-title container-width product-section-title-related pt-half pb-half uppercase"><?php _e( 'Sách eBook cùng chủ đề', 'woocommerce' ); ?></h3>

            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        </div>

    <?php endif;

    wp_reset_postdata();
} ?>
