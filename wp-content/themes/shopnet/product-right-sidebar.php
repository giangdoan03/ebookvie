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
 global $product;
?>

<div class="product-container">
<div class="product-main">
<div class="row mb-0 content-row">


	<div class="product-gallery large-<?php echo flatsome_option('product_image_width'); ?> col">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

    <div class="box-live-demo">
        <div class="left">
           <a href="/lien-he"><i class="fa fa-user-edit"></i><span>Cần hỗ trợ</span></a>
        </div>
        <div class="right">
            <a class="save-book"><i class="fa fa-heart"></i><span>Yêu thích</span></a>
        </div>
    </div>
	 <script>
                (function($) {
                    $(document).ready(function() {
                        <?php
                        if (is_user_logged_in()) { ?>
                            $('.box-live-demo .save-book').on('click', function() {
                                $.ajax({
                                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                    type: 'POST',
                                    data: {
                                        action: 'ebook_favorite',
                                        book_id: <?php echo $product->get_id(); ?>
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Bạn đã lưu vào tủ sách')
                                        } else {
                                            console.log('An error occurred.');
                                        }
                                    }
                                });
                            });
                        <?php } else { ?>
                            $('.box-live-demo .save-book').click(function(e) {
                                alert('Vui lòng đăng nhập để lưu vào tủ sách')
                            });
                        <?php } ?>
                    });

                })(jQuery);
            </script>
	</div>

	<div class="product-info summary col-fit col-divided col entry-summary <?php flatsome_product_summary_classes();?>">

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

	<div id="product-sidebar" class="col large-3 hide-for-medium <?php flatsome_sidebar_classes(); ?>">
		<?php
			do_action('flatsome_before_product_sidebar');
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			if (is_active_sidebar( 'product-sidebar' ) ) {
					dynamic_sidebar('product-sidebar');
			} else if(is_active_sidebar( 'shop-sidebar' )) {
					dynamic_sidebar('shop-sidebar');
			}
		?>
	</div>

</div><!-- .row -->
</div><!-- .product-main -->

<div class="product-footer">
	<div class="container">
	    <div class="row-info">
	    <div class="left">
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
	    </div>
	    <div class="right">
	        <?php if ( is_active_sidebar( 'block-product-2' ) ) : ?>
                <?php dynamic_sidebar( 'block-product-2' ); ?>
<?php endif; ?>



	    </div>
	    </div>
	</div><!-- container -->
</div><!-- product-footer -->
</div><!-- .product-container -->
