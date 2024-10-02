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
           <a href="/ho-tro"><i class="fa fa-user-edit"></i><span>Cần hỗ trợ</span></a>
        </div>
        <div class="right">
            <a href="#" target="blank"><i class="fa fa-heart"></i><span>Yêu thích</span></a>
        </div>
    </div>

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
<div class="row2">
    <div class="container">
        <div class="row-info chang3">
            <div class="cot1">
                <div class="khoi-box">
                    <div class="box-title"><label>TRỞ THÀNH VIP TRONG HỆ THỐNG</label> Truy cập hơn 3000 sản phẩm </div> 
                    <div class="box-info"> 
                    <ul class="list-star pink">
                        <li>Tải xuống toàn bộ THEME và PLUGIN.</li>
                        <li>Không giới hạn số lượng website sử dụng.</li>
                        <li>Cập nhật thường xuyên.</li>
                        <li>Tiết kiệm tới 93%.</li>
                    </ul>
                    </div>
                    <a class="nut-dang-ky" href="/tai-khoan-vip/" target="_blank" rel="nofollow noopener">Mua gói VIP (ưu đãi không giới hạn)</a>
                </div>
            </div>
            <div class="cot2">
                <div class="khoi-box">
                     <div class="box-title"><label>MUA NHIỀU GIẢM NHIỀU TỚI 30%</label> Thanh toán online - Tải sản phẩm trực tiếp từ website </div> 
                <div class="box-info"> 
                    <ul class="list-star pink">
                        <li>Mua 2 sản phẩm khác nhau giảm 10%.</li>
                        <li>Mua 3 sản phẩm khác nhau giảm 15%.</li>
                        <li>Cập nhật thường xuyên.</li>
                        <li>Mua 5 sản phẩm khác nhau trở lên giảm 30%</li>
                    </ul>
                </div>
                <a class="nut-dang-ky" href="/shop/" target="_blank" rel="nofollow noopener">Xem thêm các sản phẩm khác</a>
                </div>
            </div>
            <div class="cot3">
                <div class="khoi-box">
                    <div class="box-title"><label>CHẾ ĐỘ SUPPORT TỐT NHẤT</label> Hỗ trợ mọi lúc mọi nơi. 24/7</div> 
                    <div class="box-info"> 
                     Để được hỗ trợ tốt nhất, vui lòng gửi email tới địa chỉ sau:
                     <h4>info.giuseart.com@gmail.com</h4>
                     hoặc
                    </div>
                     <a class="nut-dang-ky" href="https://messenger.com/t/demo" target="_blank" rel="nofollow noopener">Chat hỗ trợ trực tuyến</a>
             </div>
            </div>
    </div>
</div>
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

<div id="nut-buy">
    <div>
        <?php the_post_thumbnail("thumbnail",array( "title" => get_the_title(),"alt" => get_the_title() ));?>
    </div>
    <div>
        <h3><?php the_title() ;?></h3>
        <div class="price">
        <?php $gia_ban= get_post_meta( get_the_ID(), '_regular_price', true );?>
        <?php $gia_km= get_post_meta( get_the_ID(), '_sale_price', true ); ?>
        <?php if($gia_km){?>
        <div class="price">
             <span class="del"><?php echo number_format($gia_ban);?>đ</span>  <span class="ins"> <?php echo number_format($gia_km);?>đ</span>
        </div>
        <?php } else {?>
        <div class="price2">
            <span class="ins"> <?php echo number_format($gia_ban);?>đ</span>
        </div>
        <?php }?>
        
    </div>
			<?php the_excerpt() ;?>
    </div>
    
    <div>
        <p class="des">(Đặt hàng nhanh và chờ nhân viên gọi điện xác nhận sau 5 phút!)</p>
        <?php echo do_shortcode( '[devvn_quickbuy]' ); ?>
    </div>
</div>

	    </div>
	    </div>
	</div><!-- container -->
</div><!-- product-footer -->
</div><!-- .product-container -->
