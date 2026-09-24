<?php $__env->startSection('title', 'Area / Line - ' . $plant->name); ?>
<?php $__env->startSection('header', 'Area / Line - ' . $plant->name); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .master-hero {
            background: linear-gradient(
                135deg,
                #5b21b6,
                #7c3aed 58%,
                #8b5cf6
            );
            color: #fff;
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 12px 30px rgba(124, 58, 237, .18);
        }

        .master-hero h2 {
            margin: 0 0 6px;
        }

        .master-hero p {
            margin: 0;
            color: rgba(255,255,255,.78);
        }

        .breadcrumb {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 14px;
            font-size: 12px;
            color: #667085;
        }

        .breadcrumb a {
            color: #6d28d9;
            font-weight: 650;
            text-decoration: none;
        }

        .master-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(240px, 1fr)
            );
            gap: 16px;
        }

        .master-card {
            display: block;
            border: 1px solid #e8e5f0;
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 22px rgba(58,35,120,.06);
            transition: .2s ease;
            text-decoration: none;
            color: inherit;
        }

        .master-card:hover {
            transform: translateY(-3px);
            border-color: #c4b5fd;
            box-shadow: 0 12px 28px rgba(124,58,237,.12);
        }

        .master-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .master-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ede9fe;
            color: #6d28d9;
            font-weight: 800;
            font-size: 20px;
        }

        .master-card h3 {
            margin: 0;
            font-size: 16px;
        }

        .master-card p {
            margin: 8px 0 0;
            color: #667085;
            font-size: 13px;
        }

        .master-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .badge-soft {
            padding: 5px 9px;
            border-radius: 999px;
            background: #f5f3ff;
            color: #6d28d9;
            font-size: 11px;
            font-weight: 700;
        }

        .btn-link {
            color: #6d28d9;
            font-weight: 700;
            font-size: 12px;
        }

        .empty-card {
            text-align: center;
            padding: 35px 20px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        @media (max-width: 700px) {
            .master-hero {
                padding: 18px;
            }
        }
    </style>


    
    <div class="breadcrumb">

        <a href="<?php echo e(route('omd.master.index', [
            'scope' => $scope
        ])); ?>">
            Data Master
        </a>

        <span>›</span>

        <a href="<?php echo e(route('omd.master.index', [
            'scope' => $scope
        ])); ?>">
            <?php echo e($scopeLabel); ?>

        </a>

        <span>›</span>

        <strong>
            <?php echo e($plant->name); ?>

        </strong>

    </div>


    
    <div class="back-button">

        <a
            href="<?php echo e(route('omd.master.index', [
                'scope' => $scope
            ])); ?>"
            class="btn btn-secondary"
        >
            ← Kembali ke Plant
        </a>

    </div>


    
    <div class="master-hero">

        <h2>
            Area / Line - <?php echo e($plant->name); ?>

        </h2>

        <p>
            Pilih Area / Line untuk mengelola Model dan Produk.
        </p>

    </div>


    
    <div class="page-head">

        <div>

            <h3 style="margin:0;">
                Area / Line
            </h3>

            <div class="muted">
                Plant <?php echo e($plant->name); ?>

                · Scope <?php echo e(strtoupper($scopeLabel)); ?>

            </div>

        </div>

    </div>


    
    <?php if($areas->isEmpty()): ?>

        <div class="card empty-card">

            <div
                class="muted"
                style="margin-top:6px;"
            >
                Belum ada data.
            </div>

        </div>

    <?php else: ?>

        <div class="master-grid">

            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a
                    class="master-card"
                    href="<?php echo e(route('omd.master.area.index', [
                        'scope' => $scope,
                        'plant' => $plant,
                        'area' => $area
                    ])); ?>"
                >

                    <div class="master-card-top">

                        <div class="master-icon">
                            ▣
                        </div>

                        <span class="badge-soft">

                            <?php echo e($area->master_models_count ?? 0); ?>

                            Model

                        </span>

                    </div>


                    <div style="margin-top:16px;">

                        <h3>
                            <?php echo e($area->name); ?>

                        </h3>

                        <p>
                            Kelola Model dan Produk
                            pada Area / Line
                            <?php echo e($area->name); ?>.
                        </p>

                    </div>


                    <div class="master-card-footer">

                        <span class="muted">
                            Plant <?php echo e($plant->name); ?>

                        </span>

                        <span class="btn-link">
                            Lihat Model →
                        </span>

                    </div>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/master/plants.blade.php ENDPATH**/ ?>