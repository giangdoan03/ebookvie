<?php
/**
 * Single Product tabs
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce/Templates
 * @version          3.8.0
 * @flatsome-version 3.16.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

// Đảm bảo $post được khởi tạo đúng cách
if ( ! isset( $post ) || empty( $post ) ) {
    $post = get_post(); // Gán giá trị nếu $post chưa được thiết lập
}

$tabs_style = get_theme_mod( 'product_display', 'tabs' );

// Get sections instead of tabs if set.
if ( $tabs_style == 'sections' ) {
	wc_get_template_part( 'single-product/tabs/sections' );

	return;
}

// Get accordion instead of tabs if set.
if ( $tabs_style == 'accordian' || $tabs_style == 'accordian-collapsed' ) {
	wc_get_template_part( 'single-product/tabs/accordian' );

	return;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$tab_count   = 0;
$panel_count = 0;

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper container tabbed-content">
		<ul class="tabs wc-tabs product-tabs small-nav-collapse <?php flatsome_product_tabs_classes(); ?>" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab <?php if ( $tab_count == 0 ) echo 'active'; ?>" id="tab-title-<?php echo esc_attr( $key ); ?>" role="presentation">
					<a href="#tab-<?php echo esc_attr( $key ); ?>" role="tab" aria-selected="<?php echo $tab_count == 0 ? 'true' : 'false'; ?>" aria-controls="tab-<?php echo esc_attr( $key ); ?>"<?php echo $tab_count != 0 ? ' tabindex="-1"' : ''; ?>>
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
				<?php $tab_count++; ?>
			<?php endforeach; ?>
		</ul>
		<div class="tab-panels">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content <?php if ( $panel_count == 0 ) echo 'active'; ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<?php if ( $key == 'description' && ux_builder_is_active() ) echo flatsome_dummy_text(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
				<?php $panel_count++; ?>
			<?php endforeach; ?>

			<?php do_action( 'woocommerce_product_after_tabs' ); ?>
		</div>
	</div>

<?php endif; ?>

<?php
// Lấy danh sách các Tac-gia của sản phẩm
$terms = get_the_terms( $post->ID, 'tac-gia' );

// Kiểm tra xem sản phẩm có Tac-gia hay không
if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        // Lấy nội dung của Tac-gia từ custom fields
        //$description = get_field('mo_ta_tac_gia', $term);
        // Lấy mô tả của Tac-gia
        $description = get_term_field('description', $term);

        // Hiển thị nội dung của Tac-gia nếu không trống
        if ( ! empty( $description ) ) {
            // Bắt đầu thẻ div lớn
            echo '<div class="tac-gia-container">';
            
            // Bắt đầu thẻ div cho hình ảnh
            echo '<div class="tac-gia-image">';
            // Lấy hình ảnh của Tac-gia từ custom fields
            $image = get_field('hinh-anh-tac-gia', $term);
            // Hiển thị hình ảnh của Tac-gia
            if ( $image ) {
                echo '<a href="' . get_term_link($term) . '"><img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $term->name ) . '" /></a>';
            }
            // Kết thúc thẻ div cho hình ảnh
            echo '</div>';
            
            // Bắt đầu thẻ div cho tiêu đề và mô tả
            echo '<div class="tac-gia-info">';
            // Hiển thị tiêu đề của Tac-gia
            echo '<a href="' . get_term_link($term) . '"><h3>Về tác giả ' . esc_html( $term->name ) . '</h3></a>';
            // Hiển thị nội dung của Tac-gia
            $short_description = substr($description, 0, 510); // Lấy 510 ký tự đầu tiên của nội dung
            echo '<p>' . esc_html( $short_description );
            if ( strlen($description) > 510 ) {
                echo '... <a href="' . get_term_link($term) . '">Xem thêm</a>'; // Thêm liên kết "Xem thêm" nếu có nội dung thừa
            }
            echo '</p>';
            // Kết thúc thẻ div cho tiêu đề và mô tả
            echo '</div>';
            
            // Kết thúc thẻ div lớn
            echo '</div>';
        }
    }
}
?>


<?php 
$link1 = get_field('link1');
$link2 = get_field('link2');
$link3 = get_field('link3');
$link4 = get_field('link4');
$link5 = get_field('link5');
$link6 = get_field('link6');
$link7 = get_field('link7');
?>
<div class="thong-tin-ky-thuat chang1" id="taixuong">
    <h3>Tải eBook <?php the_title(); ?> với định dạng </h3>
    <div class="row-info">
        <div class="left"><?php the_title(); ?> .PDF</div>
        <?php if ( $link1 ) { ?>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link1'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .PDF</a></div>
        <?php } else { ?>
            <div class="right">Updating...</div>
        <?php } ?>
    </div>
    <div class="row-info">
        <div class="left"><?php the_title(); ?> .EPUB</div>
        <?php if ( $link2 ) { ?>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link2'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .EPUB</a></div>
        <?php } else { ?>
            <div class="right">Updating...</div>
        <?php } ?>
    </div>
    <div class="row-info">
        <div class="left"><?php the_title(); ?> .AZW3</div>
        <?php if ( $link3 ) { ?>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link3'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .AZW3</a></div>
        <?php } else { ?>
            <div class="right">Updating...</div>
        <?php } ?>
    </div>
    <?php if ( $link4 ) { ?>
        <div class="row-info">
            <div class="left"><?php the_title(); ?> .MOBI</div>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link4'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .MOBI</a></div>
        </div>
    <?php } ?>
    <?php if ( $link5 ) { ?>
        <div class="row-info">
            <div class="left"><?php the_title(); ?> .PRC</div>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link5'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .PRC</a></div>
        </div>
    <?php } ?>
    <?php if ( $link6 ) { ?>
        <div class="row-info">
            <div class="left"><?php the_title(); ?> .CBR</div>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link6'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .CBR</a></div>
        </div>
    <?php } ?>
    <?php if ( $link7 ) { ?>
        <div class="row-info">
            <div class="left"><?php the_title(); ?> .CBZ</div>
            <div class="right"><a rel="nofollow noopener" href="<?php the_field('link7'); ?>" target="blank"><i class="fas fa-arrow-alt-circle-down" aria-hidden="true"></i> Tải .CBZ</a></div>
        </div>
    <?php } ?>
</div>
<div class="binhluanfb"> <?php echo do_shortcode('[block id="cau-hoi-lien-quan"]'); ?></div>
