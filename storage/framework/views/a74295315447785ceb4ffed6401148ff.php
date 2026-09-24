<?php $__env->startSection('title', 'Edit Model ' . $scopeLabel); ?>
<?php $__env->startSection('header', 'Edit Model ' . $scopeLabel); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-head">
        <div>
            <h2>Edit Model <?php echo e($scopeLabel); ?></h2>
            <div class="muted">
                Perbarui nama model yang tersimpan pada data master.
            </div>
        </div>

        <a href="<?php echo e(route('omd.master.index', ['scope' => $scope])); ?>" class="btn">
            ← Kembali
        </a>
    </div>


    <div class="card" style="max-width: 650px;">

        <div style="margin-bottom: 22px;">
            <h3 style="margin: 0 0 6px;">
                Informasi Model
            </h3>

            <div class="muted">
                Nomor model dibuat otomatis oleh sistem dan tidak dapat diubah.
            </div>
        </div>


        
        <?php if($errors->any()): ?>
            <div
                style="
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#b91c1c;
            padding:12px 14px;
            border-radius:10px;
            margin-bottom:18px;
        ">
                <strong>Periksa kembali data:</strong>

                <ul style="margin:8px 0 0 18px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>


        <form method="POST"
            action="<?php echo e(route('omd.master.model.update', [
                'scope' => $scope,
                'masterModel' => $masterModel->id,
            ])); ?>">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>


            
            <div class="field">
                <label for="number">
                    Nomor
                </label>

                <input id="number" type="text" value="<?php echo e($masterModel->number); ?>" disabled
                    style="background:#f5f5f5; cursor:not-allowed;">
            </div>


            
            <div class="field" style="margin-top:16px;">
                <label for="model">
                    Model
                </label>

                <input id="model" type="text" name="model" value="<?php echo e(old('model', $masterModel->model)); ?>"
                    placeholder="Contoh: 660" maxlength="100" required autofocus>
            </div>


            
            <div class="field" style="margin-top:16px;">
                <label>
                    Data
                </label>

                <input type="text" value="<?php echo e(strtoupper($scope)); ?>" disabled
                    style="background:#f5f5f5; cursor:not-allowed;">
            </div>


            
            <div
                style="
            display:flex;
            justify-content:flex-end;
            gap:10px;
            margin-top:24px;
        ">

                <a href="<?php echo e(route('omd.master.index', ['scope' => $scope])); ?>" class="btn">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/master/edit-model.blade.php ENDPATH**/ ?>