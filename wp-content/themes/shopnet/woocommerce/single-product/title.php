<h1 class="product-title product_title entry-title">
	<?php the_title(); ?>
</h1>
<?php setPostViews(get_the_ID()); ?>
<div class="tdk-product-loop-custom-product-meta">
    <span class="last-updated-date">
        <i class="fas fa-eye"></i>
        <span>
            <?php 
                // Lấy số lượt xem bài viết
                $a = getPostViews(get_the_ID());
                
                // Đảm bảo $a là số và xử lý các trường hợp ngoại lệ
                if (!is_numeric($a)) {
                    $a = 0; // Gán giá trị mặc định là 0 nếu không phải số
                }

                // Tính toán và định dạng số lượt xem
                if ($a >= 1000) {
                    $formatted_views_xem = round(($a / 1000) * 1.3, 1) . 'K';
                } else {
                    $formatted_views_xem = round($a * 1.3);
                }
                
                echo $formatted_views_xem;
            ?>
        </span>
    </span>

    <span class="version">
        <i class="fas fa-arrow-alt-circle-down"></i>
        <?php 
            // Tính toán và định dạng số lượt tải
            if ($a >= 1000) {
                $formatted_views_tai = number_format($a / 1000, 1) . 'K';
            } else {
                $formatted_views_tai = $a;
            }
            
            echo $formatted_views_tai;
        ?>
    </span>

    <span class="review1">
        <?php echo do_shortcode('[rank_math_rich_snippet id="s-a13724e2-b464-4dee-9c65-9e83cea7c66e"]'); ?>
    </span>
</div>

<?php if(get_theme_mod('product_title_divider', 1)) { ?>
    <div class="is-divider small"></div>
<?php } ?>
