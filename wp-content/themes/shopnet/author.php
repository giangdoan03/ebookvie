<?php get_header(); ?>

<div class="container tacgia">
    <div class="row">
        <div class="col medium-3 small-12 large-3 tacgia1">
            <img src="https://ebookvie.com/wp-content/uploads/2024/06/Jessie-Evans.png">
        </div>
        <div class="col medium-9 small-12 large-9 tacgia2">
            <h1 class="tacgia3"><?php echo get_the_author(); // Hiển thị tên tác giả ?></h1>
            <div class="tacgia4"><?php the_author_meta('description'); // Hiển thị đoạn giới thiệu về tác giả với HTML ?></div>
        </div>
    </div>


<?php
/**
 * Posts archive list.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
 */

if ( have_posts() ) : ?>
    <div id="post-list">
        <h2>Bài viết của <?php echo get_the_author(); ?>:</h2>
        <?php
        $ids = array();
        while ( have_posts() ) : the_post();
            array_push( $ids, get_the_ID() );
        endwhile; // end of the loop.
        $ids = implode( ',', $ids );
        ?>

        <?php
        echo flatsome_apply_shortcode( 'blog_posts', array(
            'type'        => 'row',
            'image_width' => '40',
            'depth'       => get_theme_mod( 'blog_posts_depth', 0 ),
            'depth_hover' => get_theme_mod( 'blog_posts_depth_hover', 0 ),
            'text_align'  => get_theme_mod( 'blog_posts_title_align', 'center' ),
            'style'       => 'vertical',
            'columns'     => '1',
            'show_date'   => get_theme_mod( 'blog_badge', 1 ) ? 'true' : 'false',
            'ids'         => $ids,
            'excerpt_length' => '50',
        ) );
        ?>

        <?php flatsome_posts_pagination(); ?>
    </div>
<?php else : ?>

    <?php get_template_part( 'template-parts/posts/content', 'none' ); ?>

<?php endif; ?>
</div>
<?php get_footer(); ?>
