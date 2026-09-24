<?php $__env->startSection('title', 'Data ' . $scopeLabel); ?>
<?php $__env->startSection('header', 'Data ' . $scopeLabel); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .master-table th,
        .master-table td {
            border: 1px solid #d9dee8;
            vertical-align: middle;
        }

        .master-table th {
            background: #f7f8fa;
        }

        .master-table .col-no {
            width: 70px;
            text-align: center;
        }

        .master-table .col-model {
            width: 180px;
        }

        .master-table .col-product-no {
            width: 80px;
            text-align: center;
        }

        .master-table .col-action {
            width: 190px;
            text-align: center;
        }

        .action-inline {
            display: inline-flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-sm {
            padding: 7px 10px;
            font-size: 12px;
        }

        .export-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
    </style>

    <div class="page-head">
        <div>
            <h2>Master Model & Produk <?php echo e($scopeLabel); ?></h2>
            <div class="muted"></div>
        </div>

        <div class="export-actions">
            <a class="btn btn-success" href="<?php echo e(route('omd.master.export.excel', $scope)); ?>">
                Export Excel
            </a>

            <a class="btn btn-danger" href="<?php echo e(route('omd.master.export.pdf', $scope)); ?>">
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid2" style="grid-template-columns: 1fr 1fr; margin-bottom: 20px;">
        <div class="card">
            <h3 style="margin-top:0;">Tambah Model</h3>

            <form method="POST" action="<?php echo e(route('omd.master.model.store', $scope)); ?>">
                <?php echo csrf_field(); ?>

                <div class="field">
                    <label for="model">Model</label>
                    <input id="model" name="model" value="<?php echo e(old('model')); ?>" placeholder="Masukkan model" required>
                </div>

                <button class="btn btn-primary" style="margin-top:14px;">
                    Simpan Model
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-top:0;">Tambah Produk</h3>
            <div class="muted" style="margin-bottom:16px;"></div>

            <form method="POST" action="<?php echo e(route('omd.master.product.store', $scope)); ?>">
                <?php echo csrf_field(); ?>

                <div class="field">
                    <label for="master_model_id">Model</label>
                    <select id="master_model_id" name="master_model_id" required>
                        <option value="">Pilih model</option>

                        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($model->id); ?>" <?php if(old('master_model_id', $selectedModelId) == $model->id): echo 'selected'; endif; ?>>
                                <?php echo e($model->number); ?> - <?php echo e($model->model); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="field" style="margin-top:14px;">
                    <label for="product">Produk</label>
                    <input id="product" name="product" value="<?php echo e(old('product')); ?>" placeholder="Masukkan produk" required>
                </div>

                <button class="btn btn-primary" style="margin-top:14px;">
                    Simpan Produk
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="page-head" style="margin-bottom:16px;">
            <div>
                <h3 style="margin:0;">Data Model & Produk <?php echo e($scopeLabel); ?></h3>
                <div class="muted">
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table master-table">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-model">Model</th>
                        <th class="col-product-no">No. Produk</th>
                        <th>Produk</th>
                        <th class="col-action">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $__empty_2 = true; $__currentLoopData = $model->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <tr>
                                <?php if($index === 0): ?>
                                    <td class="col-no" rowspan="<?php echo e($model->products->count()); ?>">
                                        <b><?php echo e($model->number); ?></b>
                                    </td>

                                    <td class="col-model" rowspan="<?php echo e($model->products->count()); ?>">
                                        <b><?php echo e($model->model); ?></b>

                                        <div style="margin-top:8px;">
                                            <a class="btn btn-secondary btn-sm"
                                                href="<?php echo e(route('omd.master.model.edit', [$scope, $model])); ?>">
                                                Edit Model
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <td class="col-product-no">
                                    <?php echo e($index + 1); ?>

                                </td>

                                <td>
                                    <?php echo e($product->name); ?>

                                </td>

                                <td class="col-action">
                                    <div class="action-inline">
                                        <a class="btn btn-secondary btn-sm"
                                            href="<?php echo e(route('omd.master.product.edit', [$scope, $product])); ?>">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="<?php echo e(route('omd.master.product.destroy', [$scope, $product])); ?>"
                                            onsubmit="return confirm('Hapus produk <?php echo e(addslashes($product->name)); ?>?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <tr>
                                <td class="col-no">
                                    <b><?php echo e($model->number); ?></b>
                                </td>

                                <td class="col-model">
                                    <b><?php echo e($model->model); ?></b>

                                    <div style="margin-top:8px;">
                                        <a class="btn btn-secondary btn-sm"
                                            href="<?php echo e(route('omd.master.model.edit', [$scope, $model])); ?>">
                                            Edit Model
                                        </a>
                                    </div>
                                </td>

                                <td class="col-product-no">-</td>

                                <td class="muted">
                                    Belum ada produk.
                                </td>

                                <td class="col-action">
                                    <form method="POST" action="<?php echo e(route('omd.master.model.destroy', [$scope, $model])); ?>"
                                        onsubmit="return confirm('Hapus model <?php echo e(addslashes($model->model)); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button class="btn btn-danger btn-sm">
                                            Hapus Model
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada data model <?php echo e($scopeLabel); ?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/master/index.blade.php ENDPATH**/ ?>