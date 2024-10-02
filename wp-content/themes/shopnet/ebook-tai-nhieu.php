<?php
/*
Template Name: Popular Products
*/
get_header();
?>

<div class="container row category-page-row">
    <h1 class="entry-title" style="text-align: center;">Top 100+ Sách/ eBook tải nhiều trong tháng</h1>
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Calculate the offset based on the current page
    $offset = ($paged - 1) * 25;

    // Ensure the total number of products does not exceed 100
    $total_products = 100;
    $remaining_products = $total_products - $offset;
    $posts_per_page = ($remaining_products < 25) ? $remaining_products : 25;

    // Query arguments
    $args = array(
        'post_type' => 'product',
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset
    );

    $popular_products = new WP_Query($args);

    if($popular_products->have_posts()) :
    ?>
        <div class="products row row-small large-columns-5 medium-columns-3 small-columns-2 has-equal-box-heights equalize-box">
        <?php while($popular_products->have_posts()) : $popular_products->the_post(); ?>
            <div class="product-small col has-hover product type-product first instock has-post-thumbnail product-type-simple">
                <div class="col-inner"><div class="product-small box ">
                    <div class="box-image">
                        <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?></a>
                    </div>
                    <div class="box-text box-text-products text-center grid-style-2" style="height: 126.425px;">
                        <p class="category uppercase is-smaller no-text-overflow product-cat op-7"><?php echo wc_get_product_category_list(get_the_ID()); ?></p>
                        <p class="name product-title woocommerce-loop-product__title"><a 
                        class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <div class="price-wrapper">
                            <span class="price"><span class="amount">Xem Ngay</span></span>
                        </div>
                    </div>  
                </div></div>
            </div>
        <?php endwhile; ?>
        </div>

        <div class="nav-pagination links text-center phantrang">
            <?php
            // Custom pagination
            $total_pages = ceil($total_products / 25);
            echo paginate_links(array(
                'total' => $total_pages,
                'current' => $paged
            ));
            ?>
        </div>
    <?php else : ?>
        <p>Không có sản phẩm nào được tìm thấy.</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
