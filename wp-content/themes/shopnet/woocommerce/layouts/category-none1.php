<?php
/**
 * Category layout with no sidebar.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.16.0
 */
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;  

$GLOBALS['wp_embed']->post_ID = $taxonomy . '_' . $term_id;

// get the current taxonomy term
$term = get_queried_object();


// vars
$image = get_field('hinh-anh-tac-gia', $term);
$color = get_field('mo_ta_tac_gia', $term);
?>
<div class="row category-page-row">

		<div class="col large-12">
		<?php
		do_action('flatsome_products_before');

		/**
		* Hook: woocommerce_before_main_content.
		*
		* @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		* @hooked woocommerce_breadcrumb - 20 (FL removed)
		* @hooked WC_Structured_Data::generate_website_data() - 30
		*/
		do_action( 'woocommerce_before_main_content' ); ?>
<?php if( !empty( $color ) ): ?>
	<div class="tacgia10">
		<div class="tacgia11">
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />  
		</div>
		<div class="tacgia12"> 
			<h2><?php echo $term->name; ?></h2>
			<div class="term-description"><?php echo $color; ?> </div>
		</div>
	</div>
	<h3> Một số cuốn sách của tác giả <?php echo $term->name; ?> </h3>
<?php endif; ?>
		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>

		<?php

		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20 (FL removed)
			 * @hooked woocommerce_catalog_ordering - 30 (FL removed)
			 */
			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}
		?>

		<?php
		/**
		 * Hook: flatsome_products_after.
		 *
		 * @hooked flatsome_products_footer_content - 10
		 */
		do_action( 'flatsome_products_after' );
		/**
		 * Hook: woocommerce_after_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
		?>

		</div>
</div>
