<?php 
/*
Template name: Page - Right Sidebar
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
*/
?>
<div class="entry-content single-page">
	<?php the_content(); ?>

<?php
// Lấy danh sách các Tac-gia của sản phẩm
$terms = get_the_terms( $post->ID, 'tac-gia' );

// Kiểm tra xem sản phẩm có Tac-gia hay không
if ( $terms && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        // Lấy nội dung của Tac-gia từ custom fields
        // $description = get_field('mo_ta_tac_gia', $term);
        // Lấy mô tả của Tac-gia
        $description = get_term_field('description', $term);
        // Hiển thị nội dung của Tac-gia nếu không trống
        if(!empty($description)) {
            // Bắt đầu thẻ div lớn
            echo '<div class="tac-gia-container">';
            
            // Bắt đầu thẻ div cho hình ảnh
            echo '<div class="tac-gia-image">';
            // Lấy hình ảnh của Tac-gia từ custom fields
            $image = get_field('hinh-anh-tac-gia', $term);
            // Hiển thị hình ảnh của Tac-gia
            if($image) {
                echo '<a href="' . get_term_link($term) . '"><img src="' . $image['url'] . '" alt="' . $term->name . '" /></a>';
            }
            // Kết thúc thẻ div cho hình ảnh
            echo '</div>';
            
            // Bắt đầu thẻ div cho tiêu đề và mô tả
            echo '<div class="tac-gia-info">';
            // Hiển thị tiêu đề của Tac-gia
            echo '<a href="' . get_term_link($term) . '"><h3>Về tác giả ' . $term->name . '</h3></a>';
            // Hiển thị nội dung của Tac-gia
            $short_description = substr($description, 0, 560); // Lấy 200 ký tự đầu tiên của nội dung
            echo '<p>' . $short_description;
            if (strlen($description) > 560) {
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




	<?php $san_pham_lien_quan = get_field('san_pham_lien_quan'); ?>

<?php if($san_pham_lien_quan){ ?>
			<div class="san-pham-lien-quan">
			    	<h2>Cuốn sách cùng thể loại hoặc tác giả mà bạn nên xem:</h2>
			    <ul>
    <?php foreach( $san_pham_lien_quan as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
            <li class="item-splq">
<a class="anh-dai-dien" href="<?php the_permalink(); ?>">
<?php echo get_the_post_thumbnail( get_the_id(), 'thumbnail', array( 'class' =>'thumnail') ); ?>
</a>
<div class="box-text">
 <a href="<?php the_permalink(); ?>"><h5 class="product-title">eBook <?php the_title(); ?></h5></a>
 <div>Tác giả: <strong><?php the_terms( $post->ID, 'tac-gia', '', ', ', '' ); ?></strong></div>
<div class="tom-tat"><?php the_excerpt() ?></div>
</div>
<div class="cot3">
    
   
<a class="nut-xem-chi-tiet" href="<?php the_permalink(); ?>"><i class="fa fa-eye" aria-hidden="true"></i><span>Xem Ngay</span></a>
</div>
<div class="clearboth"></div>
           
                 </li>
    <?php endforeach; ?>
    </ul>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			</div>
    <?php } ?>	
	<?php
	wp_link_pages( array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'flatsome' ),
		'after'  => '</div>',
	) );
	?>
	
<div class="xem-them">
    <span class="tieu-de-xem-them">Xem thêm:</span>
    <ul>
<?php 
    $postquery = new WP_Query(array('posts_per_page' => 5, 'orderby' => 'rand'));
    if ($postquery->have_posts()) {
    while ($postquery->have_posts()) : $postquery->the_post();
    $do_not_duplicate = $post->ID;
?>

<li>
    <a href="<?php the_permalink();?>"><?php the_title();?></a>
</li>

<?php endwhile; }  wp_reset_postdata(); ?>  </ul>

</div>

	<?php if ( get_theme_mod( 'blog_share', 1 ) ) {
		// SHARE ICONS
		echo '<div class="blog-share text-center">';
		echo '<div class="is-divider medium"></div>';
		echo do_shortcode( '[share]' );
		echo '</div>';
	} ?>
</div><!-- .entry-content2 -->

<?php if ( get_theme_mod( 'blog_single_footer_meta', 1 ) ) : ?>
	<footer class="entry-meta text-<?php echo get_theme_mod( 'blog_posts_title_align', 'center' ); ?>">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ' ', 'flatsome' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ' ', 'flatsome' ) );


		// But this blog has loads of categories so we should probably display them here.
		if ( '' != $tag_list ) {
			$meta_text = __( '<div class="danh-muc"><span class="title">Danh mục:</span> %1$s</div><div class="the-tim-kiem"><span class="title">Từ khóa:</span> %2$s</div>', 'flatsome' );
		} else {
			$meta_text = __( '<div class="danh-muc"><span class="title">Danh mục:</span>  %1$s</div>', 'flatsome' );
		}

		printf( $meta_text, $category_list, $tag_list, get_permalink(), the_title_attribute( 'echo=0' ) );
		?>
	</footer><!-- .entry-meta -->
<?php endif; ?>
<?php
/*
 * Code hiển thị bài viết liên quan trong cùng 1 category
 * Code by levantoan.com
 */
$categories = get_the_category(get_the_ID());
if ($categories){
    echo '<div class="bai-viet-lien-quan">';
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
    $args=array(
        'category__in' => $category_ids,
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 8, // So bai viet dc hien thi
    );
    $my_query = new wp_query($args);
    if( $my_query->have_posts() ):
        echo '<h3>Bài viết cùng chủ đề:</h3>
        <ul class="list-bai-viet">';
        while ($my_query->have_posts()):$my_query->the_post();
            ?>
            <li>
           
            <div class="box-image">
                 <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('large'); ?></a>
            </div>
             <a href="<?php the_permalink() ?>"><h4 class="tieu-de-bai-viet"><?php the_title(); ?></h4>
                        </a>
            </li>
            <?php
        endwhile;
        echo '</ul>';
    endif; wp_reset_query();
    echo '</div>';
}
?>
<?php if ( get_theme_mod( 'blog_author_box', 1 ) ) : ?>
	<div class="entry-author author-box">
		<div class="flex-row align-top">
			<div class="flex-col mr circle">
				<div class="blog-author-image">
					<?php
					$user = get_the_author_meta( 'ID' );
					echo get_avatar( $user, 90 );
					?>
				</div>
			</div><!-- .flex-col -->
			<div class="flex-col flex-grow">
				<h5 class="author-name uppercase pt-half">
					<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
				</h5>
				<p class="author-desc small"><?php echo esc_html( get_the_author_meta( 'user_description' ) ); ?></p>
			</div><!-- .flex-col -->
		</div>
	</div>
<?php endif; ?>

<?php if ( get_theme_mod( 'blog_single_next_prev_nav', 1 ) ) :
	flatsome_content_nav( 'nav-below' );
endif; ?>
