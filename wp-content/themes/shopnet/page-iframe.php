<?php
/**
 * Template Name: Iframe Page
 */

// get_header();

// Kiểm tra nếu người dùng đã đăng nhập xxxxxxxxxxxxxx
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_data = [
        'user_id' => $current_user->ID,
        'user_name' => $current_user->user_login,
        'user_email' => $current_user->user_email
    ];
} else {
    $user_data = null;
}

// Giả sử biến $bookFile chứa tên file cuốn sách
$bookFile = 'Ma Than Tuong Quan Q19C6 - Kieu Phong.epub'; // Ví dụ, bạn có thể lấy giá trị này từ một nguồn dữ liệu khác

// Tạo URL cho iframe
$iframeUrl = "https://file.ebookvie.com/?bookPath=tuoi_tre.epub";
?>
<style>
body {
        overflow: hidden;
}
</style>
<div class="content">
    <h1>Iframe Page xxxxx</h1>

    <!-- Iframe để nhúng trang subdomain -->
    <iframe id="iframeId" src="<?php echo esc_url($iframeUrl); ?>" width="100%" height="1000px" style="border:none;"></iframe>
</div>

<script>

    const userInfo = <?php echo json_encode($user_data); ?>;


    // Gửi thông tin người dùng đến iframe
    function sendUserInfo() {
        if (iframe) {
            console.log('Sending user info:', userInfo);
            iframe.contentWindow.postMessage(userInfo, 'http://localhost/epub/bibi');
        }
    }

    // Biến để theo dõi xem đã lắng nghe thông điệp hay chưa
    let isMessageListenerSet = false;

    // Chỉ gửi thông tin người dùng một lần khi iframe được tải
    const iframe = document.getElementById('iframeId');


    // Hàm chọn văn bản trong iframe
    function selectTextInIframe() {
        // Giả sử bạn muốn chọn toàn bộ văn bản trong một phần tử cụ thể
        const textElement = document.getElementById('textElementId'); // Thay thế bằng ID của phần tử bạn muốn chọn
        const range = document.createRange();
        range.selectNodeContents(textElement);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);

        console.log('Text selected in iframe!');
    }



    iframe.onload = function() {
        if (!isMessageListenerSet) {
            console.log('Iframe script loaded'); // Log khi mã iframe được tải
            sendUserInfo();
            isMessageListenerSet = true; // Đánh dấu rằng listener đã được thiết lập
        }
    };


    // Lắng nghe sự kiện mouseup trên toàn bộ trang
    document.addEventListener('mouseup', function() {
        // Lấy nội dung đã chọn
        const selectedText = window.getSelection().toString();

        // Kiểm tra nếu có nội dung được chọn
        if (selectedText) {
            window.selectedText = selectedText; // Lưu nội dung đã chọn vào biến
            showSaveButton(selectedText); // Hiển thị nút lưu
        } else {
            // hideSaveButton(); // Ẩn nút lưu nếu không có nội dung được chọn
        }
    });



    // Hàm để hiển thị nút lưu
    function showSaveButton(selectedText) {
        // Tạo một ID duy nhất cho nút
        const buttonId = 'save-button-dd';

        // Tạo nút lưu
        const saveButton = document.createElement('button');
        saveButton.innerText = 'Lưu lại--';
        saveButton.id = buttonId; // Gán ID cho nút

        // Thêm nút vào body của trang
        document.body.appendChild(saveButton);

        // Bắt sự kiện click dựa vào id
        document.getElementById(buttonId).addEventListener('click', function() {
            console.log('Button ID:', buttonId); // Log ra ID của nút khi click
            console.log('Selected Text:', selectedText); // Log nội dung đã chọn
            saveSelectedText(selectedText); // Gọi hàm để lưu nội dung đã chọn

            // Xóa nút sau khi đã lưu
            document.getElementById(buttonId).remove();
        });
    }


    function saveSelectedText(selectedText) {
        const formData = new FormData();
        formData.append('action', 'save_selected_text');
        formData.append('text', selectedText);
        formData.append('user_id', userInfo.user_id);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Lưu thành công!');
                } else {
                    alert('Lưu thất bại: ' + data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }


    // Truy cập iframe ngoài có id="iframeId"
    const outerIframe = document.getElementById('iframeId');

    // Khi iframe ngoài đã tải xong
    outerIframe.addEventListener('load', function () {
        console.log('Outer iframe loaded.');

        // Truy cập tài liệu bên trong iframe ngoài
        const innerDocument = outerIframe.contentWindow.document;
        let selectionTimeout;
        let lastSelectedText = ''; // Biến để lưu đoạn văn bản cuối cùng đã chọn

        // Sử dụng MutationObserver để theo dõi khi iframe con được thêm vào
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.tagName === 'IFRAME' && node.classList.contains('item')) {
                        console.log('Dynamically added iframe with class "item" found:', node);

                        // Gắn sự kiện load cho iframe con để đảm bảo nó được tải đầy đủ
                        node.addEventListener('load', function () {
                            console.log('Inner iframe with class "item" loaded.');

                            // Truy cập tài liệu bên trong iframe con
                            const innerIframeDocument = node.contentWindow.document;

                            // Tự động highlight văn bản đã lưu trước đó khi tải lại trang
                            const savedRange = JSON.parse(localStorage.getItem('highlightedTextRange'));
                            if (savedRange) {
                                const textNode = innerIframeDocument.body.firstChild;  // Giả định đoạn văn bản nằm ở phần đầu

                                // Kiểm tra nếu offset không vượt quá độ dài của textNode
                                if (textNode.length >= savedRange.end) {
                                    const range = innerIframeDocument.createRange();
                                    range.setStart(textNode, savedRange.start);
                                    range.setEnd(textNode, savedRange.end);

                                    // Highlight đoạn văn bản bằng cách bọc nó trong span có màu vàng
                                    const span = innerIframeDocument.createElement('span');
                                    span.style.backgroundColor = 'yellow';
                                    range.surroundContents(span);
                                }
                            }

                            // Theo dõi việc chọn văn bản (bôi đen)
                            innerIframeDocument.addEventListener('selectionchange', function () {
                                // Xóa timeout cũ nếu có
                                clearTimeout(selectionTimeout);

                                // Đặt timeout để chờ một khoảng thời gian trước khi lưu và highlight đoạn văn bản
                                selectionTimeout = setTimeout(function () {
                                    const selection = innerIframeDocument.getSelection();
                                    const selectedText = selection.toString().trim();

                                    // Kiểm tra xem đoạn văn bản đã chọn có thay đổi không
                                    if (selectedText && selectedText !== lastSelectedText) {
                                        lastSelectedText = selectedText; // Cập nhật đoạn văn bản đã chọn
                                        const range = selection.getRangeAt(0);

                                        // Xử lý các phần tử TextNode để tránh lỗi surroundContents
                                        const fragment = range.cloneContents();
                                        const span = innerIframeDocument.createElement('span');
                                        span.style.backgroundColor = 'yellow';

                                        // Bọc văn bản được chọn trong thẻ <span>
                                        range.surroundContents(span);

                                        // Lưu vị trí start và end của văn bản đã bôi đen vào localStorage
                                        const startOffset = range.startOffset;
                                        const endOffset = range.endOffset;

                                        localStorage.setItem('highlightedTextRange', JSON.stringify({
                                            start: startOffset,
                                            end: endOffset
                                        }));

                                        // Gửi message về iframe cha sau khi bôi đen xong
                                        window.parent.postMessage(selectedText, '*');
                                    }
                                }, 500); // Chờ 500ms sau khi người dùng ngừng thay đổi vùng chọn
                            });
                        });
                    }
                });
            });
        });

        // Bắt đầu theo dõi các thay đổi trong tài liệu của iframe ngoài
        observer.observe(innerDocument.body, { childList: true, subtree: true });
    });





    // Trong iframe cha (có miền khác với iframe con), lắng nghe thông điệp từ iframe con
    window.addEventListener('message', function(event) {
        // Kiểm tra nguồn của thông điệp để đảm bảo an toàn
        if (event.origin === 'http://localhost') {
            const selectedText = event.data;
            if (selectedText) {
                console.log('Selected text from iframe:', selectedText);
                window.selectedText = selectedText; // Lưu nội dung đã chọn vào biến
                showSaveButton(selectedText); // Hiển thị nút lưu
            }
        } else {
            console.log('Untrusted message source:', event.origin);
        }
    });

</script>

<?php
// get_footer(); 
?>
