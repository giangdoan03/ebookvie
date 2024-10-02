<?php
//*Xoá nút thêm giỏ hàng //
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//*Chuyen gia thanh mien phi //
function devvn_wc_custom_get_price_html( $price, $product ) {
    if ( $product->get_price() == 0 ) {
        if ( $product->is_on_sale() && $product->get_regular_price() ) {
            $regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) );
            $price = wc_format_price_range( $regular_price, __( 'Miễn phí', 'woocommerce' ) );
        } else {
            $price = '<span class="amount">' . __( 'Xem Ngay', 'woocommerce' ) . '</span>';
        }
    }
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'devvn_wc_custom_get_price_html', 10, 2 );
//*Không cache sitemap //
add_filter( 'rank_math/sitemap/enable_caching', '__return_false');
//*Search Tac gia voi Fiboseach //
add_filter( 'dgwt/wcas/indexer/taxonomies', function ( $taxonomies ) {
    $taxonomies[] = 'tac-gia';

    return $taxonomies;
} );

add_filter( 'dgwt/wcas/tnt/indexer/readable/product/data', function ( $data, $product_id, $product ) {

    $term = $product->getTerms( 'tac-gia', 'string' );

    if ( ! empty( $term ) ) {

        $html = '<span class="suggestion-book-author">';
        $html .= $term;
        $html .= '</span>';


        $data['meta']['tac-gia'] = $html;
    }

    return $data;
}, 10, 3 );
// chuyen schema ebook voi trang tacgia



// Nang dung luong tim kiem fibor search
add_filter( 'dgwt/wcas/troubleshooting/analytics/record_limit', function () {
    return 500000;
} );


add_filter( 'dgwt/wcas/indexer/searchable_set_items_count', function ( $count ) {
    return 10;
} );
add_filter( 'dgwt/wcas/indexer/readable_set_items_count', function ( $count ) {
    return 5;
} );
add_filter( 'dgwt/wcas/indexer/taxonomy_set_items_count', function ( $count ) {
    return 10;
} );
add_filter( 'dgwt/wcas/indexer/variations_set_items_count', function ( $count ) {
    return 5;
} );


// Nút đăng bài
function realdev_publish_btn() {
    if (is_admin() && current_user_can('edit_posts')) {
        $screen = get_current_screen();
        if ($screen->base === 'post') {
            echo '<button id="btn-submit" class="button button-primary button-large"></button>';
            echo '<style>#woocommerce-embedded-root{ display: none;} .wp-editor-tools{ background: #fff !important; padding-top: 5px !important;} #btn-submit{ min-height: 30px !important; max-height: 30px; line-height: 2;} </style>';
            echo '<script>document.addEventListener("DOMContentLoaded", function(){ var p=document.getElementById("publish"); var b=document.getElementById("btn-submit"); if (p && b){ b.textContent=p.value;}}); </script>';
        }
    }
}
add_action('media_buttons', 'realdev_publish_btn');
// Cho php HTML trong phần mô tả tac giả
remove_filter('pre_user_description', 'wp_filter_kses');

/**
 * chuyen huong link co .html ve trang chu.
 */
function auto_redirect_html_links() {
    if (is_404()) { // Chỉ chuyển hướng khi trang không tồn tại
        $requested_url = $_SERVER['REQUEST_URI'];
        $new_url = str_replace('.html', '', $requested_url);

        // Chuyển hướng về trang chủ nếu đường link mới không tồn tại
        wp_redirect(home_url('/'), 301);
        exit();
    }
}
add_action('template_redirect', 'auto_redirect_html_links');

// Thêm cột hình ảnh vào phần admin column của custom taxonomy 'Tac-gia'
function add_taxonomy_image_column($columns) {
    $new_columns = array();
    // Sao chép tất cả các cột hiện có
    foreach($columns as $key => $value) {
        $new_columns[$key] = $value;
        // Chèn cột hình ảnh sau cột tên
        if($key === 'name') {
            $new_columns['taxonomy-image'] = 'Hình ảnh';
        }
    }
    return $new_columns;
}
add_filter('manage_edit-tac-gia_columns', 'add_taxonomy_image_column');

// Hiển thị nội dung cho cột hình ảnh trong phần admin column của custom taxonomy 'Tac-gia'
function display_taxonomy_image_column($content, $column_name, $term_id) {
    if ($column_name === 'taxonomy-image') {
        // Lấy hình ảnh của custom field 'hinh-anh'
        $image = get_field('hinh-anh-tac-gia', 'tac-gia_' . $term_id);
        if ($image) {
            // Hiển thị hình ảnh nhỏ trong admin column
            $content = '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" style="max-width:50px;max-height:50px;" />';
        }
    }
    return $content;
}
add_filter('manage_tac-gia_custom_column', 'display_taxonomy_image_column', 10, 3);


//* Remove WordPress's default image sizes
function remove_default_image_sizes( $sizes) {
    unset( $sizes['large']);
    unset( $sizes['woocommerce_thumbnail']);
    unset( $sizes['woocommerce_single']);
    unset( $sizes['woocommerce_gallery_thumbnail']);
    unset( $sizes['dgwt-wcas-product-suggestion']);
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['medium_large']);
    unset( $sizes['1536x1536']);
    unset( $sizes['2048x2048']);
    unset( $sizes['scaled']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');



// Codfe.com cải tiến hàm search trên Flatsome
function __codfe_search_by_title_only( $search, &$wp_query )
{
  global $wpdb;
  if(empty($search)) {
    return $search; // skip processing - no search term in query
  }
  $q = $wp_query->query_vars;
  $n = !empty($q['exact']) ? '' : '%';
  $search =
  $searchand = '';
  foreach ((array)$q['search_terms'] as $term) {
    $term = esc_sql($wpdb->esc_like($term));
    $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
    $searchand = ' AND ';
  }
  if (!empty($search)) {
    $search = " AND ({$search}) ";
    if (!is_user_logged_in())
      $search .= " AND ($wpdb->posts.post_password = '') ";
  }
  return $search;
}
add_filter('posts_search', '__codfe_search_by_title_only', 500, 2);

//*hinh dai dien khi share FB cho custom taxonomy //
add_action('wp_head', 'rjrasmussen_brand', 5);
function rjrasmussen_brand( ) {
    // If it's not a taxonomy, die.
    if ( !is_tax('tac-gia') ) {
        return;
    }
    global $post;
    if (get_field('hinh-anh-tac-gia', $post->ID)) {
        $image = base_image_url(get_field('hinh-anh-tac-gia', $post->ID), null); 
    }
    echo '<meta property="og:image" content="'.$image.'" />';
}

//*An thong bao ban quyen faltsome //
add_action('init','hide_flatsome_notice');
function  hide_flatsome_notice() {
    remove_action('admin_notices','flatsome_maintenance_admin_notice');
}

//*tạo thêm sidebar //

register_sidebar(array(
    'name' => 'Sidebar Product 2',
    'id' => 'block-product-2',
    'description' => 'Sidebar hiển thị sidebar mới của trang sản phẩm',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<span class="widget-title">',
    'after_title' => '</span>'
));

/*Sắp xếp lại thứ tự các field*/
add_filter("woocommerce_checkout_fields", "order_fields");
function order_fields($fields) {
 
  //Shipping
  $order_shipping = array(
    "shipping_last_name",
    "shipping_phone",
    "shipping_address_1"
  );
  foreach($order_shipping as $field_shipping)
  {
    $ordered_fields2[$field_shipping] = $fields["shipping"][$field_shipping];
  }
  $fields["shipping"] = $ordered_fields2;
  return $fields;
}
 
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields',99 );
function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_first_name']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_address_2']);
  $fields['billing']['billing_last_name'] = array(
    'label' => __('Họ và tên', 'devvn'),
    'placeholder' => _x('Nhập đầy đủ họ và tên của bạn', 'placeholder', 'devvn'),
    'required' => true,
    'class' => array('form-row-wide'),
    'clear' => true
  );
  $fields['billing']['billing_address_1']['placeholder'] = 'Ví dụ: Số xx Ngõ xx Phú Kiều, Bắc Từ Liêm, Hà Nội';
 
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_country']);
  unset($fields['shipping']['shipping_city']);
  unset($fields['shipping']['shipping_state']);
  unset($fields['shipping']['shipping_address_2']);
 
  $fields['shipping']['shipping_phone'] = array(
    'label' => __('Điện thoại', 'devvn'),
    'placeholder' => _x('Số điện thoại người nhận hàng', 'placeholder', 'devvn'),
    'required' => true,
    'class' => array('form-row-wide'),
    'clear' => true
  );
  $fields['shipping']['shipping_last_name'] = array(
    'label' => __('Họ và tên', 'devvn'),
    'placeholder' => _x('Nhập đầy đủ họ và tên của người nhận', 'placeholder', 'devvn'),
    'required' => true,
    'class' => array('form-row-wide'),
    'clear' => true
  );
  $fields['shipping']['shipping_address_1']['placeholder'] = 'Ví dụ: Số xx Ngõ xx Phú Kiều, Bắc Từ Liêm, Hà Nội';
 
  return $fields;
}
 
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order){
  echo '<p><strong>'.__('Số ĐT người nhận').':</strong> <br>' . get_post_meta( $order->get_id(), '_shipping_phone', true ) . '</p>';
}
//Tùy chỉnh admin footer
function custom_admin_footer() { 
 echo 'Thiết kế bởi <a href="https://ebookvie.com" target="blank">eBookVie.com</a>';}
 add_filter('admin_footer_text', 'custom_admin_footer');
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
}

function wpc_url_login(){
return "https://ebookvie.com"; 
}
add_filter('login_headerurl', 'wpc_url_login');
add_action( 'wp_enqueue_scripts', 'flatsome_enqueue_scripts_styles' );
function flatsome_enqueue_scripts_styles() {
wp_enqueue_style( 'dashicons' );
wp_enqueue_style( 'flatsome-ionicons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css' );
}
add_action('admin_head', 'Hide_WooCommerce_Breadcrumb');

function Hide_WooCommerce_Breadcrumb() {
  echo '<style>
    .woocommerce-layout__header {
        display: none;
    }
    .woocommerce-layout__activity-panel-tabs {
        display: none;
    }
    .woocommerce-layout__header-breadcrumbs {
        display: none;
    }
    .woocommerce-embed-page .woocommerce-layout__primary{
        display: none;
    }
    .woocommerce-embed-page #screen-meta, .woocommerce-embed-page #screen-meta-links{top:0;}
    </style>';
}
add_filter( 'use_block_editor_for_post', '__return_false' );


//CODE LAY LUOT XEM
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "01 tải";
    }
    return $count.' tải';
}
 
// CODE DEM LUOT XEM
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
 
/**
 * Remove Ancient Custom Fields metabox from post editor
 * because it uses a very slow query meta_key sort query
 * so on sites with large postmeta tables it is super slow
 * and is rarely useful anymore on any site
 */
function s9_remove_post_custom_fields_metabox() {
     foreach ( get_post_types( '', 'names' ) as $post_type ) {
         remove_meta_box( 'postcustom' , $post_type , 'normal' );   
     }
}
add_action( 'admin_menu' , 's9_remove_post_custom_fields_metabox' );


 

// Tắt chức năng Marketing Hub (tiếp thị) của WooCoo
function woocommerce_feature_disabled() {
  add_filter('woocommerce_admin_get_feature_config', 'vf_admin_get_feature_config', 10, 1);
  function vf_admin_get_feature_config( $features ) {
    $features['activity-panels']                  = false;
    $features['analytics']                        = false;
    $features['analytics-dashboard']              = false;
    $features['analytics-dashboard/customizable'] = false;
    $features['homescreen']                       = false;

    $features['marketing'] = false;

    return $features;
  }
}
add_action('woocommerce_init', 'woocommerce_feature_disabled', 999);
// Chinh do dai mat khau dang nhap
 add_filter( 'woocommerce_get_script_data', 'pwd_strength_meter_settings', 20, 2 );
function pwd_strength_meter_settings( $params, $handle  ) {
if( $handle === 'wc-password-strength-meter' ) {
    $params = array_merge( $params, array(

        'min_password_strength' => 2,
        'i18n_password_error' => 'Mật khẩu bạn quá yếu. Hãy thử lại!',
        'i18n_password_hint' => ' Vui lòng nhập mật khẩu không đấu với <strong>ít nhất 8 ký tự, </strong>Trong đó bao gồm: <strong>CHỮ HOA, chữ thường, số hoặc ký tự đặc biệt</strong>. Ví dụ:<strong>eBookVie@123</strong>'
    ) );
}
return $params;}

//CODE GUI EMAIL
add_action( 'phpmailer_init', function( $phpmailer ) {
    if ( !is_object( $phpmailer ) )
    $phpmailer = (object) $phpmailer;
    $phpmailer->Mailer     = 'smtp';
    $phpmailer->Host       = 'smtp.gmail.com';
    $phpmailer->SMTPAuth   = 1;
    $phpmailer->Port       = 587;
    $phpmailer->Username   = 'ebookviecom@gmail.com'; //điền tài khoản gmail của bạn
    $phpmailer->Password   = 'kror hhip hreq cspw'; //điền mật khẩu ứng dụng mà bạn đã tạo ở trên
    $phpmailer->SMTPSecure = 'TLS';
    $phpmailer->From       = 'ebookviecom@gmail.com'; //điền tài khoản gmail của bạn
    $phpmailer->FromName   = 'eBookVie';
});

/*
* Author: Le Van Toan - https://levantoan.com
* Đoạn code thu gọn nội dung bao gồm cả nút xem thêm và thu gọn lại sau khi đã click vào xem thêm
*/
add_action('wp_footer','devvn_readmore_flatsome');
function devvn_readmore_flatsome(){
    ?>
    <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
            padding-bottom: 25px;
        }
        .fix_height{
            max-height: 800px;
            overflow: hidden;
            position: relative;
        }
        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }
        .devvn_readmore_flatsome {
            padding-bottom: 15px;
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            background: #ffffffcf;
        }
        .devvn_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: "";
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
            display: block;
        }
        .devvn_readmore_flatsome a {
            background-image: linear-gradient(to right, #e31587 , #8112b9);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            display: unset;
        }
        .devvn_readmore_flatsome a:after {

            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid white;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }
        .devvn_readmore_flatsome_less a:after {
            border-top: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid white;
        }
        .devvn_readmore_flatsome_less:before {
            display: none;
        }
    </style>
    <script>
        (function($){
            $(window).on('load', function(){
                if($('.single-product div#tab-description').length > 0){
                    let wrap = $('.single-product div#tab-description');
                    let current_height = wrap.height();
                    let your_height = 800;
                    if(current_height > your_height){
                        wrap.addClass('fix_height');
                        wrap.append(function(){
                            return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                        });
                        wrap.append(function(){
                            return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                        });
                        $('body').on('click','.devvn_readmore_flatsome_more', function(){
                            wrap.removeClass('fix_height');
                            $('body .devvn_readmore_flatsome_more').hide();
                            $('body .devvn_readmore_flatsome_less').show();
                        });
                        $('body').on('click','.devvn_readmore_flatsome_less', function(){
                            wrap.addClass('fix_height');
                            $('body .devvn_readmore_flatsome_less').hide();
                            $('body .devvn_readmore_flatsome_more').show();
                        });
                    }
                }
            });
        })(jQuery);
    </script>
    <?php
}


/*
 * Thêm nút Xem thêm vào phần mô tả của danh mục sản phẩm
 * Author: Le Van Toan - https://levantoan.com
*/
add_action('wp_footer','devvn_readmore_taxonomy_flatsome');
function devvn_readmore_taxonomy_flatsome(){
    if(is_woocommerce() && is_tax('tac-gia')):
        ?>
        <style>
            .term-description {
                overflow: hidden;
                position: relative;
                margin-bottom: 20px;
                padding-bottom: 25px;
            }
            .devvn_readmore_taxonomy_flatsome {
                    padding-bottom: 15px;
                text-align: center;
                cursor: pointer;
                position: absolute;
                z-index: 10;
                bottom: 0;
                width: 100%;
                background: #ffffffcf;
            }
            .devvn_readmore_taxonomy_flatsome:before {
                height: 55px;
                margin-top: -45px;
                content: "";
                background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
                display: block;
            }
            .devvn_readmore_taxonomy_flatsome a {
                background-image: linear-gradient(to right, #e31587 , #8112b9);
                display: unset;
                color: white;
                padding: 10px 20px;
                border-radius: 30px;

            }
            .devvn_readmore_taxonomy_flatsome a:after {
                content: '';
                width: 0;
                right: 0;
                border-top: 6px solid white;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                display: inline-block;
                vertical-align: middle;
                margin: -2px 0 0 5px;
            }
            .devvn_readmore_taxonomy_flatsome_less:before {
                display: none;
            }
            .devvn_readmore_taxonomy_flatsome_less a:after {
                border-top: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid white;
            }
        </style>
        <script>
            (function($){
                $(window).on('load', function(){
                    if($('.term-description').length > 0){
                        var wrap = $('.term-description');
                        var current_height = wrap.height();
                        var your_height = 450;
                        if(current_height > your_height){
                            wrap.css('height', your_height+'px');
                            wrap.append(function(){
                                return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_show"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                            });
                            wrap.append(function(){
                                return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_less" style="display: none"><a title="Thu gọn" href="javascript:void(0);">Thu gọn</a></div>';
                            });
                            $('body').on('click','.devvn_readmore_taxonomy_flatsome_show', function(){
                                wrap.removeAttr('style');
                                $('body .devvn_readmore_taxonomy_flatsome_show').hide();
                                $('body .devvn_readmore_taxonomy_flatsome_less').show();
                            });
                            $('body').on('click','.devvn_readmore_taxonomy_flatsome_less', function(){
                                wrap.css('height', your_height+'px');
                                $('body .devvn_readmore_taxonomy_flatsome_show').show();
                                $('body .devvn_readmore_taxonomy_flatsome_less').hide();
                            });
                        }
                    }
                });
            })(jQuery);
        </script>
    <?php
    endif;
}



//CODE HIEN THI SO LUOT XEM BAI VIET TRONG DASHBOARDH
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());}}


// Tuan function
function custom_mime_types($mimes)
{
    $mimes['epub'] = 'application/epub+zip';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

function my_custom_upload_directory($upload) {
	$upload['subdir'] = '/epub';
    $upload['path'] = $upload['basedir'] . $upload['subdir'];
    $upload['url'] = $upload['baseurl'] . $upload['subdir'];
    return $upload;
}

function my_acf_upload_prefilter($errors, $file, $field) {
    if ($field['name'] == 'file_epub') {
        add_filter('upload_dir', 'my_custom_upload_directory');
    }
    return $errors;
}

function my_acf_upload_prefilter_after($file, $field) {
    if ($field['name'] == 'file_epub') {
        remove_filter('upload_dir', 'my_custom_upload_directory');
    }
    return $file;
}

add_filter('acf/upload_prefilter', 'my_acf_upload_prefilter', 10, 3);
add_filter('acf/update_value/name=file_epub', 'my_acf_upload_prefilter_after', 10, 2);

function add_rewrite_rules() {
    add_rewrite_rule(
        '^doc-sach/([^/]*)/?',
        'index.php?pagename=doc-sach&ten_sach=$matches[1]',
        'top'
    );
}
add_action('init', 'add_rewrite_rules');

function add_query_vars($vars) {
    $vars[] = 'ten_sach';
    return $vars;
}
add_filter('query_vars', 'add_query_vars');

// tao db
 global $wpdb;
    $table_name = $wpdb->prefix . 'ebook_info';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        id_user INT NOT NULL,
        book_dadoc TEXT NOT NULL,
        book_yeuthich TEXT NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
function ebook_info_ajax_handler() {
   global $wpdb;

    $id_user = get_current_user_id();
    $book_id = intval($_POST['book_id']);
    $table_name = $wpdb->prefix . 'ebook_info';

    $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id_user = %d", $id_user));

    if ($record) {
        $book_dadoc = json_decode($record->book_dadoc, true);

        // Loại bỏ ID cũ nếu đã tồn tại
        $book_dadoc = array_diff($book_dadoc, array($book_id));
        
        // Thêm ID mới vào đầu mảng
        array_unshift($book_dadoc, $book_id);

        $wpdb->update($table_name, array(
            'book_dadoc' => json_encode(array_values($book_dadoc)) // array_values để đảm bảo chỉ số mảng bắt đầu từ 0
        ), array('id_user' => $id_user));
    } else {
        $book_dadoc = array($book_id);
        $wpdb->insert($table_name, array(
            'id_user' => $id_user,
            'book_dadoc' => json_encode($book_dadoc),
            'book_yeuthich' => json_encode(array())
        ));
    }

    wp_send_json_success();
}

add_action('wp_ajax_ebook_info', 'ebook_info_ajax_handler');
add_action('wp_ajax_nopriv_ebook_info', 'ebook_info_ajax_handler');


function ebook_favorite_ajax_handler() {
    global $wpdb;

    $id_user = get_current_user_id();
    $book_id = intval($_POST['book_id']);
    $table_name = $wpdb->prefix . 'ebook_info';

    $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id_user = %d", $id_user));

    if ($record) {
        $book_yeuthich = json_decode($record->book_yeuthich, true);
		
		$book_yeuthich = array_diff($book_yeuthich, array($book_id));
		
 	   array_unshift($book_yeuthich, $book_id);
        if (!in_array($book_id, $book_yeuthich)) {
            $book_yeuthich[] = $book_id;
        }

        $wpdb->update($table_name, array(
            'book_yeuthich' => json_encode($book_yeuthich)
        ), array('id_user' => $id_user));
    } else {
        $book_yeuthich = array($book_id);

        $wpdb->insert($table_name, array(
            'id_user' => $id_user,
            'book_dadoc' => json_encode(array()),
            'book_yeuthich' => json_encode($book_yeuthich)
        ));
    }

    wp_send_json_success();
}
add_action('wp_ajax_ebook_favorite', 'ebook_favorite_ajax_handler');
add_action('wp_ajax_nopriv_ebook_favorite', 'ebook_favorite_ajax_handler');

function add_custom_endpoints() {
    add_rewrite_endpoint('san-pham-da-doc', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('san-pham-yeu-thich', EP_ROOT | EP_PAGES);
}
add_action('init', 'add_custom_endpoints');

function custom_query_vars($vars) {
    $vars[] = 'sach-da-doc';
    $vars[] = 'tu-sach';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars', 0);
function add_custom_menu_items($items) {
    $items['sach-da-doc'] = 'Sách đã đọc';
    $items['tu-sach'] = 'Tủ sách';
    return $items;
}
add_filter('woocommerce_account_menu_items', 'add_custom_menu_items');

function custom_endpoint_content() {
    global $wpdb;
    $current_user = wp_get_current_user();

    if (is_user_logged_in()) {
        $table_name = $wpdb->prefix . 'ebook_info';
        $user_id = get_current_user_id();

        // Lấy danh sách sản phẩm đã đọc
        if (get_query_var('sach-da-doc') !== '') {
            $record = $wpdb->get_row($wpdb->prepare("SELECT book_dadoc FROM $table_name WHERE id_user = %d", $user_id));
            $book_dadoc = json_decode($record->book_dadoc, true);

            echo '<h2>Sản phẩm đã đọc</h2>';
            if (!empty($book_dadoc)) {
                foreach ($book_dadoc as $book_id) {
                    $product = wc_get_product($book_id);
                    echo '<p><a href="' . get_permalink($product->get_id()) . '">' . $product->get_name() . '</a></p>';
                }
            } else {
                echo '<p>Bạn chưa đọc sản phẩm nào.</p>';
            }
        }

        // Lấy danh sách sản phẩm yêu thích
        if (get_query_var('tu-sach') !== '') {
            $record = $wpdb->get_row($wpdb->prepare("SELECT book_yeuthich FROM $table_name WHERE id_user = %d", $user_id));
            $book_yeuthich = json_decode($record->book_yeuthich, true);

            echo '<h2>Sản phẩm yêu thích</h2>';
            if (!empty($book_yeuthich)) {
                foreach ($book_yeuthich as $book_id) {
                    $product = wc_get_product($book_id);
                    echo '<p><a href="' . get_permalink($product->get_id()) . '">' . $product->get_name() . '</a></p>';
                }
            } else {
                echo '<p>Bạn chưa yêu thích sản phẩm nào.</p>';
            }
        }
    } else {
        echo '<p>Bạn cần đăng nhập để xem thông tin này.</p>';
    }
}
add_action('woocommerce_account_san-pham-da-doc_endpoint', 'custom_endpoint_content');
add_action('woocommerce_account_san-pham-yeu-thich_endpoint', 'custom_endpoint_content');


// Xử lý AJAX request cho việc xóa book_yeuthich
function remove_favorite_ajax_handler() {
    global $wpdb;
    $id_user = get_current_user_id();
    $book_id = intval($_POST['book_id']);
    $table_name = $wpdb->prefix . 'ebook_info';

    $record = $wpdb->get_row($wpdb->prepare("SELECT book_yeuthich FROM $table_name WHERE id_user = %d", $id_user));

    if ($record) {
        $book_yeuthich = json_decode($record->book_yeuthich, true);

        if (in_array($book_id, $book_yeuthich)) {
            $book_yeuthich = array_diff($book_yeuthich, array($book_id));
        }

        $wpdb->update($table_name, array(
            'book_yeuthich' => json_encode($book_yeuthich)
        ), array('id_user' => $id_user));

        wp_send_json_success();
    } else {
        wp_send_json_error('Không tìm thấy sản phẩm.');
    }
}
add_action('wp_ajax_remove_favorite', 'remove_favorite_ajax_handler');
