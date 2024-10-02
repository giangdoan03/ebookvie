<?php
/** @var \WPCCrawler\PostDetail\WooCommerce\WooCommerceData $detailData */
/** @var \WPCCrawler\Objects\Crawling\Data\PostData $postData */
?>


<div class="container-fluid">
    <div class="row">
        
        <div class="col col-sm-6 thumbnail-image">
            <div class="section-title"><?php echo e(_wpcc('Featured Image')); ?></div>
            <?php $thumbData = $postData ? $postData->getThumbnailData() : null; ?>
            <?php if($thumbData): ?>
                <a href="<?php echo e($thumbData->getLocalUrl()); ?>" target="_blank">
                    <img class="img-responsive" src="<?php echo e($thumbData->getLocalUrl()); ?>">
                </a>
            <?php else: ?>
                <div class="not-found-message">
                    <?php echo e(_wpcc("No featured image")); ?>

                </div>
            <?php endif; ?>
        </div>

        
        <div class="col col-sm-6 gallery-images">
            <div class="section-title"><?php echo e(_wpcc('Gallery Images')); ?></div>
            <?php if($detailData->getGalleryImageUrls()): ?>

                <?php $__currentLoopData = $detailData->getGalleryImageUrls(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-image">
                        <a href="<?php echo e($imageUrl); ?>" target="_blank">
                            <img class="img-responsive" src="<?php echo e($imageUrl); ?>">
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php else: ?>
                <div class="not-found-message">
                    <?php echo e(_wpcc("No gallery images")); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php echo $__env->make('site-tester.partial.detail-table', [
    'tableData' => $tableData
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="data-container">
    <?php $str = (print_r($detailData, true)); ?>
    <?php echo $__env->make('site-tester.partial.toggleable-textarea', [
        'title'      => _wpcc('Data'),
        'toggleText' => _wpcc('Toggle data'),
        'id'         => 'woocommerce-data',
        'hidden'     => true,
        'content'    => $str
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH /home/hemisico/ebookvie.com/wp-content/plugins/wp-content-crawler/app/views/post-detail/woocommerce/tester/woocommerce-tester.blade.php ENDPATH**/ ?>