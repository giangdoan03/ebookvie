<?php 
/*
Template name: Page - Right Sidebar
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
*/
?>
<section class="no-results not-found">
	<header class="page-title">
		<h1 class="page-title"><?php esc_html_e( 'Rất tiếc!', 'flatsome' ); ?></h1>
	</header><!-- .page-title -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Bạn đã sẵn sàng tạo bài viết đầu tiên? <a href="%1$s">Bắt đầu ngay</a>.', 'flatsome' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Xin lỗi, nội dung bạn tìm không có sẵn, vui lòng tìm kiếm với từ khóa khác!', 'flatsome' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Xin lỗi, nội dung bạn tìm không có sẵn, vui lòng tìm kiếm với từ khóa khác!', 'flatsome' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
