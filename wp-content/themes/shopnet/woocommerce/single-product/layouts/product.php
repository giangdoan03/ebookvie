<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 * @flatsome-version 3.18.0
 */
?>
<div class="product-container">

<div class="product-main">
	<div class="row content-row mb-0">

		<div class="product-gallery col large-<?php echo flatsome_option('product_image_width'); ?>">
		<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
		</div>

		<div class="product-info summary col-fit col entry-summary <?php flatsome_product_summary_classes();?>">
			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

		</div><!-- .summary -->


		<div id="product-sidebar" class="col large-2 hide-for-medium product-sidebar-small">
			<?php
				do_action('flatsome_before_product_sidebar');
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				if (is_active_sidebar( 'product-sidebar' ) ) {
					dynamic_sidebar('product-sidebar');
				}
			?>
		</div>

	</div><!-- .row -->
</div><!-- .product-main -->

<div class="product-footer">
	<div class="container">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div><!-- .container -->
</div><!-- .product-footer -->
</div><!-- .product-container -->
