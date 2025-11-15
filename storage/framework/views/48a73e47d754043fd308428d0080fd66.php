<!-- resources/views/shipping-partners.blade.php -->


<?php $__env->startSection('title', 'Partner Pengiriman'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mt-5 pt-4">
    <div class="row mb-5">
        <div class="col text-center">
            <h1 class="fw-bold">Partner Pengiriman</h1>
            <p class="lead text-muted">Didukung oleh jasa pengiriman terpercaya untuk melayani seluruh Indonesia</p>
        </div>
    </div>

    <div class="row">
        <?php $__currentLoopData = $shippingPartners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <img src="<?php echo e($partner->logo_url); ?>" alt="<?php echo e($partner->name); ?>" class="img-fluid mb-4" style="max-height: 80px;">
                    <h4 class="card-title"><?php echo e($partner->name); ?></h4>
                    <p class="darkred fw-semibold"><?php echo e($partner->service_type); ?></p>

                    <div class="coverage-areas mb-3">
                        <h6 class="text-muted">Cakupan Pengiriman:</h6>
                        <?php $__currentLoopData = $partner->coverage_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-light text-dark me-1 mb-1"><?php echo e(trim($area)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card darkredBg text-white">
                <div class="card-body text-center p-4">
                    <h3 class="card-title">Layanan Pengiriman Terintegrasi</h3>
                    <p class="card-text">Kami memastikan produk batik Anda sampai dengan aman dan tepat waktu ke seluruh penjuru Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Herd\allstock-warehouse\resources\views/shipping-partners.blade.php ENDPATH**/ ?>