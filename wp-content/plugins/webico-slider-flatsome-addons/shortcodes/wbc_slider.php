<?php


function wbc_image( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'_id'             => 'image_' . rand(),
		'id'              => '',
		'org_img'         => '',
		'caption'         => '',
		'animate'         => '',
		'animate_delay'   => '',
		'lightbox'        => '',
		'height'          => '',
		'text'          => '',
		'image_overlay'   => '',
		'image_hover'     => '',
		'image_hover_alt' => '',
		'image_size'      => 'large',
		'icon'            => '',
		'width'           => '',
		'margin'          => '',
		'position_x'      => '',
		'position_x__sm'  => '',
		'position_x__md'  => '',
		'position_y'      => '',
		'position_y__sm'  => '',
		'position_y__md'  => '',
		'depth'           => '',
		'parallax'        => '',
		'depth_hover'     => '',
		'link'            => '',
		'target'          => '_self',
	), $atts ) );

	if ( empty( $id ) ) {
		return '<div class="uxb-no-content uxb-image">Upload Image...</div>';
	}

	// Ensure key existence when builder setting is
	// not touched, to extract responsive widths.
	if ( ! array_key_exists( 'width', $atts ) ) {
		$atts['width'] = '100';
	}

	$classes       = array();
	$classes_inner = array( 'img-inner' );
	$classes_img   = array();
	$image_meta    = wp_prepare_attachment_for_js( $id );
	$link_atts     = array( 'target' => $target );

	if ( is_numeric( $id ) ) {
		if ( ! $org_img ) {
			$org_img = wp_get_attachment_image_src( $id, 'large' );
			$org_img = $org_img[0];
		}
		if ( $caption && $caption == 'true' ) {
			$caption = $image_meta['caption'];
		}
	} else {
		if ( ! $org_img ) {
			$org_img = $id;
		}
	}

	// If caption is enabled.
	$link_start = '';
	$link_end   = '';
	$link_class = '';

	if ( $link ) {
		if ( strpos( $link, 'watch?v=' ) !== false ) {
			$icon       = 'icon-play';
			$link_class = 'open-video';
			if ( ! $image_overlay ) {
				$image_overlay = 'rgba(0,0,0,.2)';
			}
		}
		$link_start = '<a class="' . $link_class . '" href="' . $link . '"' . flatsome_parse_target_rel( $link_atts ) . '>';
		$link_end   = '</a>';
	} elseif ( $lightbox ) {
		$link_start = '<a class="image-lightbox lightbox-gallery" href="' . $org_img . '" title="' . $caption . '">';
		$link_end   = '</a>';
	}

	// Set positions
	if ( function_exists( 'ux_builder_is_active' ) && ux_builder_is_active() ) {
		// Do not add positions if builder is active.
		// They will be set by the onChange handler.
	} else {
		$classes[] = flatsome_position_classes( 'x', $position_x, $position_x__sm, $position_x__md );
		$classes[] = flatsome_position_classes( 'y', $position_y, $position_y__sm, $position_y__md );
	}

	if ( $image_hover ) {
		$classes_inner[] = 'image-' . $image_hover;
	}
	if ( $image_hover_alt ) {
		$classes_inner[] = 'image-' . $image_hover_alt;
	}
	if ( $height ) {
		$classes_inner[] = 'image-cover';
	}
	if ( $depth ) {
		$classes_inner[] = 'box-shadow-' . $depth;
	}
	if ( $depth_hover ) {
		$classes_inner[] = 'box-shadow-' . $depth_hover . '-hover';
	}

	// Add Parallax Attribute.
	if ( $parallax ) {
		$parallax = 'data-parallax-fade="true" data-parallax="' . $parallax . '"';
	}

	// Set image height.
	$css_image_height = array(
		array( 'attribute' => 'padding-top', 'value' => $height ),
		array( 'attribute' => 'margin', 'value' => $margin ),
	);

	$classes       = implode( " ", $classes );
	$classes_inner = implode( " ", $classes_inner );
	$classes_img   = implode( " ", $classes_img );

	ob_start();
	?>
	<div class="img has-hover <?php echo $classes; ?>" id="<?php echo $_id; ?>">
		<?php echo $link_start; ?>
		<?php if ( $parallax ) echo '<div ' . $parallax . '>'; ?>
		<?php if ( $animate ) echo '<div data-animate="' . $animate . '">'; ?>
		<div class="<?php echo $classes_inner; ?> dark" <?php echo get_shortcode_inline_css( $css_image_height ); ?>>
			<?php echo flatsome_get_image( $id, $image_size, $caption ); ?>
			<?php if ( $image_overlay ) { ?>
				<div class="overlay" style="background-color: <?php echo $image_overlay; ?>"></div>
			<?php } ?>
			<?php if ( $icon ) { ?>
				<div class="absolute no-click x50 y50 md-x50 md-y50 lg-x50 lg-y50 text-shadow-2">
					<div class="overlay-icon">
						<i class="icon-play"></i>
					</div>
				</div>
			<?php } ?>

		</div>
    <div class="hidden TextCaption"><?php echo $text; ?></div>
		<?php if ( $animate ) echo '</div>'; ?>
		<?php if ( $parallax ) echo '</div>'; ?>
		<?php echo $link_end; ?>
		<?php
		$args = array(
			'width' => array(
				'selector' => '',
				'property' => 'width',
				'unit'     => '%',
			),
		);
		echo ux_builder_element_style_tag( $_id, $args, $atts );
		?>
	</div>

	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'wbc_image', 'wbc_image' );



function wbc_shortcode_ux_slider_tgdd($atts, $content=null) {

    extract( shortcode_atts( array(
        '_id' => 'wbcslider-'.rand(),
        'timer' => '6000',
        'bullets' => 'true',
        'visibility' => '',
        'type' => 'slide',
        'thumbnail' => false,
        'bullet_style' => '',
        'auto_slide' => 'true',
        'auto_height' => 'true',
        'bg_color' => '#fff',
        'text_color' => '#333',
        'caption_height' => '45px',
        'slide_align' => 'center',
        'style' => 'normal',
        'slide_width' => '',
        'arrows' => 'true',
        'pause_hover' => 'true',
        'hide_nav' => '',
        'nav_style' => 'circle',
        'nav_color' => 'light',
        'nav_size' => 'large',
        'nav_pos' => '',
        'infinitive' => 'true',
        'freescroll' => 'false',
        'parallax' => '0',
        'margin' => '',
        'columns' => '1',
        'height' => '',
        'rtl' => 'false',
        'draggable' => 'true',
        'friction' => '0.6',
        'selectedattraction' => '0.1',
        'threshold' => '5',

        // Derpicated
        'mobile' => 'true',

    ), $atts ) );

    // Stop if visibility is hidden
    if($visibility == 'hidden') return;

    ob_start();

    $classes = array('slider');

    if ($type == 'fade') $classes[] = 'slider-type-'.$type;

    // Hide if mobile is set to false
    if($mobile !==  'true' && !$visibility) {$visibility = 'hide-for-small';}

    // Bullet style
	if($bullet_style) $classes[] = 'slider-nav-dots-'.$bullet_style;

    // Nav style
    if($nav_style) $classes[] = 'slider-nav-'.$nav_style;

    // Nav size
    if($nav_size) $classes[] = 'slider-nav-'.$nav_size;

    // Nav Color
    if($nav_color) $classes[] = 'slider-nav-'.$nav_color;

    // Nav Position
    if($nav_pos) $classes[] = 'slider-nav-'.$nav_pos;

    // Add timer
    if($auto_slide == 'true') $auto_slide = $timer;

    // Add Slider style
    if($style) $classes[] = 'slider-style-'.$style;

    // Always show Nav if set
    if($hide_nav ==  'true') {$classes[] = 'slider-show-nav';}

    // Slider Nav visebility
    $is_arrows = 'true';
    $is_bullets = 'true';

    if($arrows == 'false') $is_arrows = 'false';
    if($bullets == 'false') $is_bullets = 'false';

    if(is_rtl()) $rtl = 'true';

    $classes = implode(" ", $classes);

    // Inline CSS
    $css_args = array(
        'bg_color' => array(
          'attribute' => 'background-color',
          'value' => $bg_color,
        ),
        'margin' => array(
          'attribute' => 'margin-bottom',
          'value' => $margin,
        )
    );
    $args = array(
		'margin' => array(
			'selector' => '',
			'property' => 'margin-bottom',
		),
	);
?>

<div class="wbcslider_tgdd slider-wrapper relative <?php echo $visibility; ?>" id="<?php echo $_id; ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
    <div class="wbcslider-main <?php echo $classes; ?>"
        data-flickity-options='{
            "cellAlign": "<?php echo $slide_align; ?>",
            "imagesLoaded": true,
            "lazyLoad": 1,
            "freeScroll": <?php echo $freescroll; ?>,
            "wrapAround": <?php echo $infinitive; ?>,
            "autoPlay": <?php echo $auto_slide;?>,
            "pauseAutoPlayOnHover" : <?php echo $pause_hover; ?>,
            "prevNextButtons": <?php echo $is_arrows; ?>,
            "contain" : true,
            "adaptiveHeight" : <?php echo $auto_height;?>,
            "dragThreshold" : <?php echo $threshold ;?>,
            "percentPosition": true,
            "pageDots": <?php echo $is_bullets; ?>,
            "rightToLeft": <?php echo $rtl; ?>,
            "draggable": <?php echo $draggable; ?>,
            "selectedAttraction": <?php echo $selectedattraction; ?>,
            "parallax" : <?php echo $parallax; ?>,
            "friction": <?php echo $friction; ?>
        }'
        >
        <?php echo do_shortcode($content); ?>
     </div>
     <div class="loading-spin dark large centered"></div>
		<div class=" carousel carousel-nav TextCaptions" data-flickity-options='{ "asNavFor": ".wbcslider-main", "contain": true, "pageDots": false }'></div>
		<?php echo ux_builder_element_style_tag( $_id, $args, $atts ); ?>
</div>

<style media="screen">
  .TextCaptions .flickity-slider{
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .TextCaptions{
    background: #F5F5F5;
    position: absolute;
    left: 0;
    right: 0;
  }
  .TextCaptions .item{
    margin: 0 !important;
    padding: 0 !important;
    height: <?php echo $caption_height; ?>;
    justify-content: center;
    align-items: center;
    display: flex;
    text-align: center;
    color: #666;
    font-size: 15px;
    line-height: 17px;
  }
   .TextCaptions .item::before {
	    background-color: #e5e5e5;
	    content: '';
	    height: 30px;
	    position: absolute;
	    top: calc(50% - 15px);
	    right: 0;
	    width: 1px;
	}
	.TextCaptions .item:last-child:before {
		content: "";
		background: none;
		width: 0
	}
	.TextCaptions .item.is-nav-selected {
		color: #000;
		font-weight: 500;
	}
	.TextCaptions .item.is-nav-selected::after {
	    background-color: #FF2D38;
	    content: '';
	    left: 0;
	    height: 3px;
	    position: absolute;
	    top: 0;
	    width: 100%;
	}
</style>
<!-- .ux-slider-wrapper -->

<?php

    $content = ob_get_contents();
    ob_end_clean();
    return $content;

}
add_shortcode("wbc_slider_tgdd", "wbc_shortcode_ux_slider_tgdd");

add_action( 'wp_footer', 'wbc_slider_tgdd_scripts' );
function wbc_slider_tgdd_scripts(){
?>

<script type="text/javascript">

  jQuery( document ).ready(function() {
  var html ='';
  jQuery('.wbcslider_tgdd .TextCaption').each(function(){
    var currentElement = jQuery(this);
    html += '<div class="col large-3 medium-3 small-6 item">' + currentElement.html() + '</div>';
  });
  jQuery('.wbcslider_tgdd .TextCaptions').html(html);
  });
</script>

<?php
}
