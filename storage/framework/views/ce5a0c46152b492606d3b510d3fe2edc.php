<?php $__env->startSection('title', 'Data Master ' . $scopeLabel); ?>
<?php $__env->startSection('header', 'Data Master ' . $scopeLabel); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .master-hero {
            background: linear-gradient(135deg, #5b21b6, #7c3aed 58%, #8b5cf6);
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
            color: rgba(255, 255, 255, .78);
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
        }

        .master-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .master-card {
            display: block;
            border: 1px solid #e8e5f0;
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 22px rgba(58, 35, 120, .06);
            transition: .2s ease;
            text-decoration: none;
            color: inherit;
        }

        .master-card:hover {
            transform: translateY(-3px);
            border-color: #c4b5fd;
            box-shadow: 0 12px 28px rgba(124, 58, 237, .12);
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

        .plant-form {
            display: flex;
            gap: 10px;
            align-items: end;
            flex-wrap: wrap;
        }

        .plant-form .field {
            margin: 0;
            min-width: 240px;
        }

        @media (max-width: 700px) {
            .master-hero {
                padding: 18px;
            }

            .plant-form {
                width: 100%;
            }

            .plant-form .field {
                width: 100%;
                min-width: 0;
            }
        }
    </style>


    
    <div class="breadcrumb">
        <span>Data Master</span>
        <span>›</span>
        <strong><?php echo e($scopeLabel); ?></strong>
    </div>

    
    <div class="card" style="margin-bottom:20px;">
        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:16px;
                flex-wrap:wrap;
            "
        >

            <div>
                <h3 style="margin:0;">
                    Tambah Plant
                </h3>
            </div>


            <form
                method="POST"
                action="<?php echo e(route('omd.master.plant.store', [
                    'scope' => $scope
                ])); ?>"
                class="plant-form"
            >
                <?php echo csrf_field(); ?>

                <div class="field">
                    <label for="plant_name">
                        Nama Plant
                    </label>

                    <input
                        id="plant_name"
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        placeholder="Contoh: Unit"
                        required
                        maxlength="100"
                    >
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Tambah
                </button>
            </form>

        </div>
    </div>


    
    <div class="page-head">

        <div>
            <h3 style="margin:0;">
                Plant <?php echo e($scopeLabel); ?>

            </h3>
        </div>


        
        <div
            class="export-actions"
            style="display:flex;gap:8px;flex-wrap:wrap;"
        >

            <a
                class="btn btn-success"
                href="<?php echo e(route('omd.master.export.excel', [
                    'scope' => $scope
                ])); ?>"
            >
                Export Excel
            </a>

            <a
                class="btn btn-danger"
                href="<?php echo e(route('omd.master.export.pdf', [
                    'scope' => $scope
                ])); ?>"
            >
                Export PDF
            </a>

        </div>

    </div>


    
    <?php if($plants->isEmpty()): ?>

        <div class="card">

            <strong>
                Belum ada Plant <?php echo e($scopeLabel); ?>.
            </strong>

            <div
                class="muted"
                style="margin-top:6px;"
            >
                Tambahkan Plant terlebih dahulu
                untuk membuat struktur Area / Line.
            </div>

        </div>

    <?php else: ?>

        <div class="master-grid">

            <?php $__currentLoopData = $plants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a
                    class="master-card"
                    href="<?php echo e(route('omd.master.plant.index', [
                        'scope' => $scope,
                        'plant' => $plant
                    ])); ?>"
                >

                    <div class="master-card-top">

                        <span class="badge-soft">
                            <?php echo e($plant->areas_count); ?> Line
                        </span>

                    </div>


                    <div style="margin-top:16px;">

                        <h3>
                            <?php echo e($plant->name); ?>

                        </h3>

                    </div>


                    <div class="master-card-footer">

                        <span class="btn-link">
                            Lihat Area →
                        </span>

                    </div>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/master/index.blade.php ENDPATH**/ ?>