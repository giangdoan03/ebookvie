<?php

/**
 * Template Name: Doc Sach xx
 */

get_header();

// Lấy slug từ URL
$slug = get_query_var('ten_sach');

// Lấy post object của sản phẩm dựa trên slug xxxxx
$args = array(
    'name'        => $slug,
    'post_type'   => 'product',
    'post_status' => 'publish',
    'numberposts' => 1
);
$product_posts = get_posts($args);

if ($product_posts) {
    $product_post = $product_posts[0];
    $file_epub_id = get_field('file_epub', $product_post->ID);
    $domain = $_SERVER['HTTP_HOST'];
    // print_r($product_post);
    if ($file_epub_id) {
        // Lấy URL của file từ ID
        $file_epub_url = wp_get_attachment_url($file_epub_id);
        if ($file_epub_url) {
?>
            <div>xxxxxxxxxx</div>
            <div id="epub-wrapper">
                <div id="titlebar">
                <div class="opener">
                    <?php 
                    $domain = $_SERVER['HTTP_HOST'];
                    $slug = $post->post_name;
                    // Kiểm tra nếu là localhost thì thêm "ebookvie" vào đường dẫn
                    if($domain == 'localhost'){
                        $url = "http://{$domain}/ebookvie/ebook/{$product_post->post_name}/";
                    } else {
                        $url = "https://{$domain}/ebook/{$product_post->post_name}/";
                    }
                    ?>
                    <a href="<?php echo $url; ?>" class="back-product"><i class="fas fa-arrow-left"></i></a>
                    <button class="toggle-toc"><i class="fas fa-bars"></i></button>
                </div>

                    <div class="metainfo">
                        <h1 class="book-name"><a href="https://<?php echo $domain; ?>/ebook/<?php echo $slug; ?>/"><?php echo $product_post->post_title; ?></a></h1>
                    </div>
                    <div class="title-controls">
                        <div class="save-book">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="full-web">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </div>
                    </div>
                </div>
                <div id="epub-reader"></div>
                <div class="toc-reader" style="display: none;">
                    <div class="toc-header">
                        <div class="title">Mục lục</div>
                        <div class="close-toc" style="cursor: pointer;"><i class="fas fa-times"></i></div>
                    </div>
                    <div class="toc-content">
                    </div>
                </div>
                <div class="toolbar">
                    <div class="arrow toolbar-prev">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </div>
                    <div class="arrow toolbar-next">
                        <i class="fas fa-long-arrow-alt-right"></i>
                    </div>
                </div>
            </div>
            <script src="https://cdn.supo.vn/timsach/statics/vendor/readbook/jszip.min.js"></script>
            <script src="https://cdn.supo.vn/timsach/statics/vendor/readbook/epub.min.js"></script>
            <script>
                (function($) {
                    $(document).ready(function() {
						document.title = "<?php echo $product_post->post_title; ?>";
                        var book = ePub("<?php echo esc_url($file_epub_url); ?>");
                        var heightRender = $("#epub-reader").height();
                        var rendition = book.renderTo("epub-reader", {
                            width: "100%",
                            height: heightRender
                        });

                        rendition.display();
                        $(".toolbar-prev").click(function(e) {
                            rendition.prev();
                        });
                        $(".toolbar-next").click(function(e) {
                            rendition.next();

                        });
                        $('.toggle-toc').click(function() {
                            var tocContent = $('.toc-content');
                            tocContent.empty(); // Xóa mục lục cũ
                            book.loaded.navigation.then(function(toc) {
                                toc.forEach(function(chapter) {
                                    var tocItem = $('<div></div>').text(chapter.label);
                                    tocItem.click(function() {
                                        rendition.display(chapter.href);
                                        $('.toc-reader').hide();
                                    });
                                    tocContent.append(tocItem);
                                });
                            });
                            $('.toc-reader').show();
                        });

                        $('.close-toc').click(function() {
                            $('.toc-reader').hide();
                        });
                        $('.full-web').on('click', function() {
                            if (!document.fullscreenElement &&
                                !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                                if (document.documentElement.requestFullscreen) {
                                    document.documentElement.requestFullscreen();
                                } else if (document.documentElement.mozRequestFullScreen) {
                                    document.documentElement.mozRequestFullScreen();
                                } else if (document.documentElement.webkitRequestFullscreen) {
                                    document.documentElement.webkitRequestFullscreen();
                                } else if (document.documentElement.msRequestFullscreen) {
                                    document.documentElement.msRequestFullscreen();
                                }
                            } else {
                                if (document.exitFullscreen) {
                                    document.exitFullscreen();
                                } else if (document.mozCancelFullScreen) {
                                    document.mozCancelFullScreen();
                                } else if (document.webkitExitFullscreen) {
                                    document.webkitExitFullscreen();
                                } else if (document.msExitFullscreen) {
                                    document.msExitFullscreen();
                                }
                            }
                        });
						// Bắt sự kiện nhấn phím
						$(document).keydown(function(e) {
							switch(e.which) {
								case 37: // Mũi tên trái
									e.preventDefault();
									rendition.prev();
									break;
								case 39: // Mũi tên phải
									e.preventDefault();
									rendition.next();
									break;
							}
						});
						// Enable swipe support
						// I have no idea why swiperRight/swiperLeft from plugins is not working, events just don't get fired
						var touchStart = 0;
var touchEnd = 0;
var lastTouchEnd = 0;

function handleTouchStart(event) {
    touchStart = event.changedTouches[0].screenX;
}

function handleTouchEnd(event) {
    touchEnd = event.changedTouches[0].screenX;
    
    // Double-tap zoom prevention
    var now = (new Date()).getTime();
    if (now - lastTouchEnd <= 300) {
        event.preventDefault();
    }
    lastTouchEnd = now;

    // Swipe detection
    if (touchStart < touchEnd) {
        if(rendition.book.package.metadata.direction === "rtl") {
            rendition.next();
        } else {
            rendition.prev();
        }
        // Swiped Right
    }
    if (touchStart > touchEnd) {
        if(rendition.book.package.metadata.direction === "rtl") {
            rendition.prev();
        } else {
            rendition.next();
        }
        // Swiped Left
    }
}

document.addEventListener('DOMContentLoaded', function() {
    rendition.on('touchstart', handleTouchStart);
    rendition.on('touchend', handleTouchEnd);
});

                        <?php
                        if (is_user_logged_in()) { ?>
                            $.ajax({
                                type: "post",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                // dataType: "html",
                                data: {
                                    action: 'ebook_info',
                                    book_id: <?php echo $product_post->ID; ?>
                                },
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        console.log('Book information saved successfully.');
                                    } else {
                                        console.log('An error occurred.');
                                    }
                                }
                            });

                            $('#epub-wrapper .title-controls .save-book').on('click', function() {
                                $.ajax({
                                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                    type: 'POST',
                                    data: {
                                        action: 'ebook_favorite',
                                        book_id: <?php echo $product_post->ID; ?>
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Bạn đã lưu vào tủ sách')
                                        } else {
                                            console.log('An error occurred.');
                                        }
                                    }
                                });
                            });
                        <?php } else { ?>
                            $('#epub-wrapper .title-controls .save-book').click(function(e) {
                                alert('Vui lòng đăng nhập để lưu vào tủ sách')
                            });
                        <?php } ?>
                    });

                })(jQuery);
            </script>
<?php
        } else {
            echo '<p>Không thể tìm thấy URL của file EPUB.</p>';
        }
    } else {
        echo '<p>File EPUB không tồn tại.</p>';
    }
} else {
    echo '<p>Sản phẩm không tồn tại.</p>';
}

get_footer();
?>