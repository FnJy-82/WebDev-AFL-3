<!-- resources/views/home.blade.php -->


<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="hero-section text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Pusat Distribusi Batik & Sarung Terpercaya</h1>
                <p class="lead mb-4">Menghubungkan pengrajin batik lokal dengan pasar yang lebih luas melalui sistem warehouse modern di Surabaya.</p>
                <a href="<?php echo e(route('warehouse')); ?>" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-info-circle me-2"></i>Pelajari Lebih
                </a>
                <a href="<?php echo e(route('suppliers')); ?>" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-handshake me-2"></i>Lihat Supplier
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Warehouse Info -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <img src="<?php echo e($warehouse->logo_url); ?>" alt="<?php echo e($warehouse->name); ?>" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3"><?php echo e($warehouse->name); ?></h1>
                <p class="text-muted mb-4"><?php echo e($warehouse->description); ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="fas fa-map-marker-alt darkred me-2"></i> <?php echo e($warehouse->full_address); ?></p>
                    </div>
                </div>
                <a href="<?php echo e(route('warehouse')); ?>" class="btn darkredBg">Detail Gudang</a>
            </div>
        </div>
    </div>
</section>

<!-- Suppliers Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fw-bold">Supplier Kami</h2>
                <p class="text-muted">Bekerja sama dengan pengrajin batik terbaik dari berbagai daerah</p>
            </div>
        </div>
        <div class="row">
            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($supplier->display_name); ?></h5>
                        <?php if($supplier->shopee_link): ?>
                        <a href="<?php echo e($supplier->shopee_link); ?>" target="_blank" class="btn btn-outline-darkred btn-outline-darkred:hover darkred btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Kunjungi Shopee
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Shipping Partners -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fw-bold">Partner Pengiriman</h2>
                <p class="text-muted">Didukung oleh jasa pengiriman terpercaya</p>
            </div>
        </div>
        <div class="row">
            <?php $__currentLoopData = $shippingPartners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <img src="<?php echo e($partner->logo_url); ?>" alt="<?php echo e($partner->name); ?>" class="img-fluid mb-3" style="max-height: 60px;">
                        <h5 class="card-title"><?php echo e($partner->name); ?></h5>
                        <p class="text-muted small"><?php echo e($partner->service_type); ?></p>
                        <div class="coverage-areas">
                            <?php $__currentLoopData = $partner->coverage_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-dark me-1 mb-1"><?php echo e(trim($area)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Herd\allstock-warehouse\resources\views/home.blade.php ENDPATH**/ ?>