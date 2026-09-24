

<?php $__env->startSection('title', 'Manajemen Akun'); ?>
<?php $__env->startSection('header', 'Manajemen Akun'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-head">
        <div>
            <h2>Manajemen Akun User</h2>
            <div class="muted">
                Kelola akun Leader PPIC dan Leader Produksi.
            </div>
        </div>

        <a href="<?php echo e(route('omd.users.create')); ?>" class="btn btn-primary">
            + Tambah Akun
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="margin-bottom:20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger" style="margin-bottom:20px;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="card">

        <div class="table-wrap">

            <table class="table">

                <thead>
                    <tr>
                        <th style="width:70px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:150px;">Bagian</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>

                            <td>
                                <?php echo e($index + 1); ?>

                            </td>

                            <td>
                                <b><?php echo e($user->name); ?></b>
                            </td>

                            <td>
                                <?php echo e($user->email); ?>

                            </td>

                            <td>
                                <span class="badge badge-<?php echo e($user->user_group); ?>">
                                    <?php echo e(strtoupper($user->user_group)); ?>

                                </span>
                            </td>

                            <td>

                                <div style="display:flex; gap:8px;">

                                    <a href="<?php echo e(route('omd.users.edit', $user)); ?>" class="btn btn-secondary">
                                        Edit
                                    </a>

                                    <form method="POST" action="<?php echo e(route('omd.users.destroy', $user)); ?>"
                                        onsubmit="return confirm('Hapus akun ini?')">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada akun user.
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/omd/users/index.blade.php ENDPATH**/ ?>