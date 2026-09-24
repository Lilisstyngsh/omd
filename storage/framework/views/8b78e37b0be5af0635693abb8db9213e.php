<?php $__env->startSection('title', 'Buat Order Repair'); ?>
<?php $__env->startSection('header', 'Buat Order Repair'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-head">
        <div>
            <h2>Form Order Repair Box NG</h2>

            <div class="muted">
                Data model dan produk otomatis mengikuti akun <?php echo e($userGroupLabel); ?>.
            </div>
        </div>
    </div>


    <div class="card form-card">

        
        <?php if($models->isEmpty()): ?>

            <div class="alert alert-error">
                Belum ada master Model dan Produk untuk <?php echo e($userGroupLabel); ?>.
                Silakan hubungi OMD.
            </div>

        <?php endif; ?>


        
        <?php if($errors->any()): ?>

            <div
                style="
                    background:#fef2f2;
                    border:1px solid #fecaca;
                    color:#b91c1c;
                    padding:12px 15px;
                    border-radius:10px;
                    margin-bottom:18px;
                "
            >

                <strong>Periksa kembali data:</strong>

                <ul style="margin:8px 0 0 18px;">

                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li>
                            <?php echo e($error); ?>

                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="<?php echo e(route('user.orders.store')); ?>"
        >

            <?php echo csrf_field(); ?>


            <div class="form-grid">


                
                <div class="field">

                    <label for="area_id">
                        Area / Line
                    </label>

                    <select
                        name="area_id"
                        id="area_id"
                        required
                    >

                        <option value="">
                            Pilih area / line
                        </option>

                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($area->id); ?>"
                                <?php if(
                                    old(
                                        'area_id',
                                        auth()->user()->area_id
                                    ) == $area->id
                                ): echo 'selected'; endif; ?>
                            >

                                <?php echo e($area->category); ?> - <?php echo e($area->name); ?>


                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>


                
                <div class="field">

                    <label for="master_model_id">
                        Model
                    </label>

                    <select
                        name="master_model_id"
                        id="master_model_id"
                        required
                    >

                        <option value="">
                            Pilih model
                        </option>

                        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($model->id); ?>"
                                <?php if(
                                    old('master_model_id') == $model->id
                                ): echo 'selected'; endif; ?>
                            >

                                <?php echo e($model->number); ?> - <?php echo e($model->model); ?>


                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>


                
                <div class="field">

                    <label for="product_id">
                        Produk
                    </label>

                    <select
                        name="product_id"
                        id="product_id"
                        required
                        disabled
                    >

                        <option value="">
                            Pilih model terlebih dahulu
                        </option>

                    </select>

                </div>


                
                <div class="field">

                    <label for="ng_type_id">
                        Jenis NG
                    </label>

                    <select
                        name="ng_type_id"
                        id="ng_type_id"
                        required
                    >

                        <option value="">
                            Pilih jenis NG
                        </option>

                        <?php $__currentLoopData = $ngTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($type->id); ?>"
                                <?php if(
                                    old('ng_type_id') == $type->id
                                ): echo 'selected'; endif; ?>
                            >

                                <?php echo e($type->code); ?> - <?php echo e($type->name); ?>


                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>


                
                <div class="field">

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        min="1"
                        value="<?php echo e(old('quantity', 1)); ?>"
                        required
                    >

                </div>


                
                <div class="field full">

                    <label for="description">
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        placeholder="Jelaskan kondisi/problem jika diperlukan."
                    ><?php echo e(old('description')); ?></textarea>

                </div>


            </div>


            
            <div
                style="
                    margin-top:18px;
                    display:flex;
                    gap:8px;
                "
            >

                <a
                    class="btn btn-secondary"
                    href="<?php echo e(route('user.orders.index')); ?>"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                    <?php echo e($models->isEmpty() ? 'disabled' : ''); ?>

                >
                    Kirim Order ke OMD
                </button>

            </div>


        </form>

    </div>


    

    <script>

        const models = {};

        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            models["<?php echo e($model->id); ?>"] = {

                id: "<?php echo e($model->id); ?>",

                products: [

                    <?php $__currentLoopData = $model->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        {
                            id: "<?php echo e($product->id); ?>",
                            name: <?php echo json_encode($product->name, 15, 512) ?>
                        },

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                ]

            };

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        const modelSelect =
            document.getElementById('master_model_id');

        const productSelect =
            document.getElementById('product_id');


        const oldProductId =
            "<?php echo e(old('product_id')); ?>";


        function loadProducts() {

            const modelId =
                modelSelect.value;


            productSelect.innerHTML = '';


            if (!modelId || !models[modelId]) {

                const option =
                    document.createElement('option');

                option.value = '';

                option.textContent =
                    'Pilih model terlebih dahulu';

                productSelect.appendChild(option);

                productSelect.disabled = true;

                return;
            }


            const defaultOption =
                document.createElement('option');

            defaultOption.value = '';

            defaultOption.textContent =
                'Pilih produk';

            productSelect.appendChild(
                defaultOption
            );


            const products =
                models[modelId].products;


            products.forEach(function (product) {

                const option =
                    document.createElement('option');


                option.value =
                    product.id;


                option.textContent =
                    product.name;


                if (
                    String(product.id) ===
                    String(oldProductId)
                ) {

                    option.selected = true;

                }


                productSelect.appendChild(
                    option
                );

            });


            productSelect.disabled = false;

        }


        modelSelect.addEventListener(
            'change',
            function () {

                loadProducts();

            }
        );


        loadProducts();

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\omd\resources\views/user/orders/create.blade.php ENDPATH**/ ?>