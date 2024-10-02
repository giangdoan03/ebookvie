<?php if($site instanceof WP_Post): ?>
    <span class="site">
        <a href="<?php echo get_edit_post_link($site->ID); ?>" target="_blank"><?php echo e($site->post_title); ?></a>
    </span>
<?php endif; ?><?php /**PATH /home/hemisico/ebookvie.com/wp-content/plugins/wp-content-crawler/app/views/dashboard/partials/site-link.blade.php ENDPATH**/ ?>