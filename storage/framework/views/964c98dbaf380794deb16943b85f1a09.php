

<?php $__env->startSection('title', 'Edit Akun'); ?>
<?php $__env->startSection('header', 'Edit Akun'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-head">

        <div>
            <h2>Edit Akun User</h2>
            <div class="muted">
                Perbarui informasi akun user.
            </div>
        </div>

        <a href="<?php echo e(route('omd.users.index')); ?>" class="btn btn-secondary">
            Kembali
        </a>

    </div>


    <div class="card">

        <form method="POST" action="<?php echo e(route('omd.users.update', $user)); ?>">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>


            <div class="field">

                <label for="name">
                    Nama
                </label>

                <input id="name" type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger">
                        <?php echo e($message); ?>

                    </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            <div class="field" style="margin-top:16px;">

                <label for="email">
                    Email
                </label>

                <input id="email" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger">
                        <?php echo e($message); ?>

                    </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            <div class="field" style="margin-top:16px;">

                <label for="user_group">
                    Bagian
                </label>

                <select id="user_group" name="user_group" required>

                    <option value="ppic" <?php if(old('user_group', $user->user_group) === 'ppic'): echo 'selected'; endif; ?>>
                        PPIC
                    </option>

                    <option value="produksi" <?php if(old('user_group', $user->user_group) === 'produksi'): echo 'selected'; endif; ?>>
                        Produksi
                    </option>

                </select>

                <?php $__errorArgs = ['user_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger">
                        <?php echo e($message); ?>

                    </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            <div class="field" style="margin-top:16px;">

                <label for="password">
                    Password Baru
                </label>

                <input id="password" type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger">
                        <?php echo e($message); ?>

                    </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            <div class="field" style="margin-top:16px;">

                <label for="password_confirmation">
                    Konfirmasi Password Baru
                </label>

                <input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Ulangi password baru">

            </div>


            <div style="margin-top:24px;">

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/users/edit.blade.php ENDPATH**/ ?>