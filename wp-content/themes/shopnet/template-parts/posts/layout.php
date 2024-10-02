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

<?php
	do_action('flatsome_before_blog');
?>

<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'top'){ get_template_part('template-parts/posts/featured-posts'); } ?>
<div class="row align-center">
	<div class="large-12 col">
	<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'content'){ get_template_part('template-parts/posts/featured-posts'); } ?>

	<?php
		if(is_single()){
			get_template_part( 'template-parts/posts/single');
			comments_template();
		} elseif(get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())){
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style_archive', '') );
		} else{
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		}
	?>
	</div> <!-- .large-12 -->

</div><!-- .row -->

<?php do_action('flatsome_after_blog');
