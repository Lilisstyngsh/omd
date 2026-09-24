<?php $__env->startSection('title', 'Edit Produk'); ?>
<?php $__env->startSection('header', 'Edit Produk'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card form-card">
        <div class="page-head">
            <div>
                <h2>Edit Produk</h2>
                <div class="muted">Perbarui produk dan model induknya.</div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('omd.master.product.update', [$scope, $product])); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="field">
                <label for="master_model_id">Model</label>
                <select id="master_model_id" name="master_model_id" required>
                    <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($model->id); ?>"
                            <?php if(old('master_model_id', $product->master_model_id) == $model->id): echo 'selected'; endif; ?>
                        >
                            <?php echo e($model->number); ?> - <?php echo e($model->model); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="field" style="margin-top:14px;">
                <label for="product">Produk</label>
                <input
                    id="product"
                    name="product"
                    value="<?php echo e(old('product', $product->name)); ?>"
                    required
                >
            </div>

            <div class="actions" style="margin-top:16px;">
                <a
                    class="btn btn-secondary"
                    href="<?php echo e(route('omd.master.index', [$scope, 'model' => $product->master_model_id])); ?>"
                >
                    Batal
                </a>

                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/master/edit-product.blade.php ENDPATH**/ ?>