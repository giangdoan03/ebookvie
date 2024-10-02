<?php

// [SHORTINIT MODE] Run this snippet in the SHORTINIT mode (fibosearch.php file). Take a look at the Implementation section above.

add_filter( 'dgwt/wcas/tnt/search_results/suggestion/product', function ( $data, $suggestion ) {

    if ( ! empty( $suggestion->meta['tac-gia'] ) ) {

        $html = '<div class="suggestion-book-author"> Tác giả: ';
        $html .= $suggestion->meta['tac-gia'];
        $html .= '</div>';

        $data['content_after'] = $html;
    }

    return $data;
}, 10, 2 );