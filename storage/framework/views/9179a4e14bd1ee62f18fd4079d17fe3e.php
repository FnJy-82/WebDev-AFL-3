<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allstock Warehouse - <?php echo $__env->yieldContent('title', 'Home'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: white;
        }

        .hero-section {
            background: linear-gradient(135deg, #5b1717 15%, #1e0a8c 100%);
            padding: 100px 0 50px;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .mission-item {
            border-left: 4px solid #900909;
            padding-left: 15px;
        }

        .darkred {
            color: #5b1717;
        }

        .darkredBg {
            background: #5b1717;
            color: white;
        }

        .btn-outline-darkred {
            color: darkred;
            border: 1px solid darkred;
            background-color: transparent;
        }

        .btn-outline-darkred:hover {
            background-color: darkred;
            color: white;
        }

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand darkred" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-warehouse me-2"></i>
                Allstock Warehouse
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link darkred" href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link darkred" href="<?php echo e(route('warehouse')); ?>">Gudang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link darkred" href="<?php echo e(route('suppliers')); ?>">Supplier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link darkred" href="<?php echo e(route('shipping-partners')); ?>">Partner Pengiriman</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-warehouse me-2"></i>Allstock Warehouse</h5>
                    <p class="mb-0">Pusat distribusi batik dan sarung terpercaya di Indonesia</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Allstock Warehouse. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\Users\Lenovo\Herd\allstock-warehouse\resources\views/layouts/app.blade.php ENDPATH**/ ?>