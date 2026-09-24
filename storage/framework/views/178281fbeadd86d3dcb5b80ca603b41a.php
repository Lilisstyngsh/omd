<?php $__env->startSection('title', 'Tambah Akun'); ?>
<?php $__env->startSection('header', 'Tambah Akun'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-head">
        <div>
            <h2>Tambah Akun User</h2>
            <div class="muted">
                Tambahkan akun Leader PPIC atau Leader Produksi.
            </div>
        </div>

        <a href="<?php echo e(route('omd.users.index')); ?>" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger" style="margin-bottom:20px;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="card">

        <form method="POST" action="<?php echo e(route('omd.users.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="field">
                <label for="name">Nama</label>

                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Nama leader"
                    required>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field" style="margin-top:16px;">
                <label for="email">Email</label>

                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="contoh@omd.com"
                    required>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field" style="margin-top:16px;">
                <label for="user_group">Plant</label>

                <select id="user_group" name="user_group" required>
                    <option value="">Pilih Bagian</option>

                    <option value="ppic" <?php if(old('user_group') === 'ppic'): echo 'selected'; endif; ?>>
                        PPIC
                    </option>

                    <option value="produksi" <?php if(old('user_group') === 'produksi'): echo 'selected'; endif; ?>>
                        Produksi
                    </option>
                </select>

                <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field" style="margin-top:16px;">
                <label for="password">Password</label>

                <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="field" style="margin-top:16px;">
                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password"
                    required>
            </div>

            <div style="margin-top:24px; display:flex; gap:10px;">

                <a href="<?php echo e(route('omd.users.index')); ?>" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Akun
                </button>

            </div>

        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/users/create.blade.php ENDPATH**/ ?>