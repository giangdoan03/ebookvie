<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 * @flatsome-version 3.18.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

$classes = array();
if ( $product->is_on_sale() ) {
    $classes[] = 'price-on-sale';
}
if ( ! $product->is_in_stock() ) {
    $classes[] = 'price-not-in-stock';
}
?>

<div class="price-wrapper">
    <p class="price product-page-price <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php echo wp_kses_post( $product->get_price_html() ); ?>
    </p> 
</div>

<p class="motangan">
    Đọc online sách ebook <?php the_title(); ?>
    <?php
    $product_id = $product->get_id(); // Sử dụng get_id() thay vì $product->id
    $product_tags = get_the_term_list( $product_id, 'product_tag', '', ', ' );
    if ( $product_tags ) {
        echo '<span class="single-product-tags">' . wp_kses_post( $product_tags ) . '</span>';
    }
    ?>
    bản đẹp của tác giả 
    <?php
    $tac_gia_terms = get_the_terms( $post->ID, 'tac-gia' );
    if ( ! is_wp_error( $tac_gia_terms ) && ! empty( $tac_gia_terms ) ) {
        echo esc_html( join( ', ', wp_list_pluck( $tac_gia_terms, 'name' ) ) );
    }
    ?>,
    thuộc thể loại
    <?php
    $categ = wc_get_product_category_list( $product_id );
    echo wp_kses_post( $categ );
    ?>.
    Mời các bạn tải về miễn phí thông qua liên kết bên dưới.
</p>

<?php $changelog = get_field('changelog'); ?>
<div class="thong-tin-ky-thuat">
    <div class="row-info">
        <div class="left">Thể loại</div>
        <div class="right"><?php echo wp_kses_post( $categ ); ?></div>
    </div>

    <div class="row-info">
        <div class="left">Định dạng</div>
        <div class="right">
            <?php
            if ( $product_tags ) {
                echo '<span class="single-product-tags">' . wp_kses_post( $product_tags ) . '</span>';
            }
            ?>
        </div>
    </div>

    <div class="row-info">
        <div class="left">Tác giả</div>
        <div class="right">
            <?php
            if ( ! is_wp_error( $tac_gia_terms ) && ! empty( $tac_gia_terms ) ) {
                echo esc_html( join( ', ', wp_list_pluck( $tac_gia_terms, 'name' ) ) );
            }
            ?>
        </div>
    </div>

    <div class="row-info">
        <div class="left">Nguồn</div>
        <div class="right">
            <?php echo $changelog ? esc_html( $changelog ) : 'Đang cập nhật...'; ?>
        </div>
    </div>
</div>

<?php
$slug = $post->post_name;
$domain = esc_url( $_SERVER['HTTP_HOST'] );
$field = get_field( 'file_epub' );
if ( $field ) {
    ?>
    <a href="https://<?php echo esc_url( $domain ); ?>/doc-sach/<?php echo esc_attr( $slug ); ?>/" class="view-book">
        <i class="fas fa-book"></i> Đọc sách
    </a>
<?php } ?>
