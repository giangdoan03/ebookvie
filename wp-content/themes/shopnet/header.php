<?php
/**
 * Header template.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
	<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EntertainmentBusiness",
  "name": "EbookVie",
  "alternateName": "Tải sách Ebook EPUB, AZW3, PDF, MOBI miễn phí",
  "@id": "https://ebookvie.com/",
  "logo": "https://ebookvie.com/wp-content/uploads/2023/11/Logo-Ebook-Vie.png",
  "image": "https://ebookvie.com/wp-content/uploads/2023/11/Logo-Ebook-Vie.png",
  "description": "Ebookvie - Tải sách truyện ebook miễn phí định dạng Epub, Azw3, Pdf, Mobi... phù hợp cho máy đọc sách Kindle, Kobo, Boox, Bibox, Meebook, Pockerbook...",
  "url": "https://ebookvie.com/",
  "telephone": "0844456555",
  "priceRange": "10000VND-1000000000000VND",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "12 Ngõ 324/80 Phương Canh",
    "addressLocality": "Nam Từ Liêm",
	"addressRegion": "Hà Nội",
    "postalCode": "100000",
    "addressCountry": "VN"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  },
  "sameAs": [
    "",
	"https://www.facebook.com/ebookviecom",
	"https://twitter.com/ebookviecom",
	"https://www.pinterest.com/ebookvie/",
	"https://ebookviecom.tumblr.com/",
	"https://www.youtube.com/channel/UCwSbCeSPgLszteTltDGduIA",
	"https://www.linkedin.com/in/ebookvie",
	"https://ebookvie.weebly.com/",
	"https://sites.google.com/view/ebookviecom/",
	"https://ebookviecom.blogspot.com/",
	"https://www.deviantart.com/ebookvie",
	"https://www.behance.net/ebookvie",
	"https://ebookvie.quora.com/",
	"https://flipboard.com/@ebookvie"
  ]
}
</script>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

<div id="wrapper">

	<?php do_action( 'flatsome_before_header' ); ?>

	<header id="header" class="header <?php flatsome_header_classes(); ?>">
		<div class="header-wrapper">
			<?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
		</div>
	</header>

	<?php do_action( 'flatsome_after_header' ); ?>

	<main id="main" class="<?php flatsome_main_classes(); ?>">
