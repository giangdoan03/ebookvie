<?php

/**
 * Template name: Page - Sách đã đọc
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
 */

get_header(); ?>

<?php do_action('flatsome_before_page'); ?>

<div id="content" role="main" class="content-area book-wrapper docsach123">
	<div class="container ">
    <?php
    global $wpdb;
    $current_user = wp_get_current_user();

    if (is_user_logged_in()) {
        $table_name = $wpdb->prefix . 'ebook_info';
        $user_id = get_current_user_id();

        $books_per_page = 15 ;  // Số sách mỗi trang
        $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $offset = ($current_page - 1) * $books_per_page;
        $record = $wpdb->get_row($wpdb->prepare("SELECT book_dadoc FROM $table_name WHERE id_user = %d", $user_id));
        $book_dadoc = json_decode($record->book_dadoc, true);

        $total_books = count($book_dadoc);

        echo '<h1>Sách đã đọc</h1>';
        if (!empty($book_dadoc)) {
            echo '<div id="list-book">';
            foreach (array_slice($book_dadoc, $offset, $books_per_page) as $book_id) {
                $product = wc_get_product($book_id);
                if ($product) { ?>

                    <div class="box box-book" id="book-<?php echo $product->get_id(); ?>">
                        <a href="<?php echo get_permalink($product->get_id()); ?>">
                            <div class="box-image">
                                <div class="image-cover">
                                    <?php echo $product->get_image(); ?>
                                </div>
                            </div>
                            <div class="box-text">
                                <h3 class="book-name"><?php echo $product->get_name(); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php
                }
            }
            echo '</div>';

            // Pagination
            $prev_arrow = is_rtl() ? get_flatsome_icon('icon-angle-right') : get_flatsome_icon('icon-angle-left');
			$next_arrow = is_rtl() ? get_flatsome_icon('icon-angle-left') : get_flatsome_icon('icon-angle-right');
            $total_pages = ceil($total_books / $books_per_page);
			$pages =  paginate_links(array(
					 'total'     => $total_pages,
					'current' => $current_page,
					'mid_size'      => 3,
					'type'          => 'array',
					'prev_text'     => $prev_arrow,
					'next_text'     => $next_arrow,
				));
            if (is_array($pages)) {
					
					echo '<ul class="page-numbers nav-pagination links text-center">';
					foreach ($pages as $page) {
						$page = str_replace("page-numbers", "page-number", $page);
						echo "<li>$page</li>";
					}
					echo '</ul>';
			}
        } else {
            echo '<p>Bạn chưa đọc sản phẩm nào.</p>';
        }
    } else {
        echo '<p>Bạn cần đăng nhập để xem thông tin này.</p>';
    }
    ?>
</div>


</div>

<?php do_action('flatsome_after_page'); ?>

<?php get_footer(); ?>