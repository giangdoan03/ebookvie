<div class="details woocommerce" id="woocommerce-details">
    <h2>
        <span><?php echo e(_wpcc('WooCommerce')); ?></span>
        <button class="button wpcc-button go-to-top"><?php echo e(_wpcc('Go to top')); ?></button>
    </h2>
    <div class="inside">
        <?php echo $__env->make('post-detail.woocommerce.tester.woocommerce-tester', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div><?php /**PATH /home/hemisico/ebookvie.com/wp-content/plugins/wp-content-crawler/app/views/post-detail/woocommerce/tester/main.blade.php ENDPATH**/ ?>