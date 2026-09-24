<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('title', 'OMD Order'); ?></title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bg: #f5f7fb;
            --card: #fff;
            --text: #172033;
            --muted: #667085;
            --line: #e6e9ef;
            --primary: #2563eb;
            --dark: #111827;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            background: var(--dark);
            color: #fff;
            padding: 22px 16px;
            position: fixed;
            inset: 0 auto 0 0;
        }

        .brand {
            font-size: 20px;
            font-weight: 800;
            padding: 8px 10px 26px;
        }

        .brand small {
            display: block;
            color: #9ca3af;
            font-size: 11px;
            font-weight: 500;
            margin-top: 4px;
        }

        .nav-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #9ca3af;
            margin: 16px 10px 8px;
        }

        .nav a {
            display: block;
            padding: 11px 12px;
            border-radius: 8px;
            color: #d1d5db;
            margin: 3px 0;
            font-size: 14px;
        }

        .nav a:hover,
        .nav a.active {
            background: #1f2937;
            color: #fff;
        }

        .main {
            margin-left: 245px;
            width: calc(100% - 245px);
        }

        .topbar {
            height: 68px;
            background: #fff;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .topbar h1 {
            font-size: 18px;
            margin: 0;
        }

        .userbox {
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 13px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .content {
            padding: 28px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .page-head h2 {
            margin: 0;
            font-size: 24px;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 2px #00000005;
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            margin-top: 8px;
        }

        .grid2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 18px;
        }

        .chartbox {
            height: 330px;
        }

        .table-wrap {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 13px 15px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
        }

        .table th {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--muted);
            background: #fafbfc;
        }

        .btn {
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            background: #eef2f7;
            color: #344054;
        }

        .btn-success {
            background: #dcfce7;
            color: #166534;
        }

        .btn-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 5px 9px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-submitted {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-verified {
            background: #e0e7ff;
            color: #4338ca;
        }

        .badge-in_repair {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-completed,
        .badge-confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-draft {
            background: #f2f4f7;
            color: #475467;
        }

        .form-card {
            max-width: 850px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            font: inherit;
            background: #fff;
        }

        .field textarea {
            min-height: 100px;
            resize: vertical;
        }

        .full {
            grid-column: 1 / -1;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 9px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-success {
            background: #ecfdf3;
            color: #166534;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #eef3fb;
        }

        .login-card {
            width: min(430px, 92vw);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 12px 35px #11182710;
        }

        .login-card h1 {
            margin: 0 0 5px;
        }

        .login-card form {
            margin-top: 24px;
        }

        .login-card .field {
            margin-bottom: 16px;
        }

        .login-card .btn {
            width: 100%;
        }

        .filter {
            display: flex;
            gap: 10px;
            align-items: end;
            margin-bottom: 18px;
        }

        .filter .field {
            min-width: 140px;
        }

        .empty {
            text-align: center;
            padding: 45px;
            color: var(--muted);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .detail-item {
            background: #f8fafc;
            border-radius: 9px;
            padding: 14px;
        }

        .detail-item span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 5px;
        }

        .detail-item strong {
            font-size: 14px;
        }

        .timeline {
            border-left: 2px solid #dbeafe;
            padding-left: 18px;
        }

        .timeline-item {
            margin: 0 0 18px;
        }

        .timeline-item b {
            font-size: 13px;
        }

        .timeline-item p {
            margin: 4px 0;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 1000px) {
            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
                width: calc(100% - 210px);
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .app {
                display: block;
            }

            .main {
                margin: 0;
                width: 100%;
            }

            .cards,
            .form-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 15px;
            }

            .content {
                padding: 16px;
            }

            .filter {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    <?php if(auth()->guard()->check()): ?>
        <div class="app">

            
            <aside class="sidebar">
                <div class="brand">
                    OMD ORDER
                    <small>Workshop Digital System</small>
                </div>

                <div class="nav-title">Menu</div>

                <nav class="nav">
                    <a href="<?php echo e(route('dashboard')); ?>">
                        Dashboard
                    </a>

                    <?php if(auth()->user()->role === 'user'): ?>
                        <a href="<?php echo e(route('user.orders.index')); ?>">
                            Order Repair Box
                        </a>

                        <a href="<?php echo e(route('user.orders.create')); ?>">
                            XBuat Order RepairX
                        </a>

                        <a href="<?php echo e(route('user.tps.index')); ?>">
                            Order Repair TPS Tools
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('omd.orders.index')); ?>">
                            Order Repair
                        </a>

                        <a href="<?php echo e(route('omd.recap')); ?>">
                            Rekap Repair
                        </a>

                        <a href="<?php echo e(route('omd.tps.index')); ?>">
                            TPS Tool
                        </a>
                    <?php endif; ?>
                </nav>

                <div class="nav-title">Akun</div>

                <nav class="nav">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>

                        <button
                            type="submit"
                            class="btn btn-secondary"
                            style="width: 100%;"
                        >
                            Logout
                        </button>
                    </form>
                </nav>
            </aside>

            
            <main class="main">

                
                <header class="topbar">
                    <h1>
                        <?php echo $__env->yieldContent('header', 'Dashboard'); ?>
                    </h1>

                    <div class="userbox">
                        <div>
                            <b><?php echo e(auth()->user()->name); ?></b>

                            <div class="muted">
                                <?php echo e(str_replace('_', ' ', ucwords(auth()->user()->role))); ?>

                            </div>
                        </div>

                        <div class="avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                    </div>
                </header>

                
                <section class="content">

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-error">
                            <ul style="margin: 0; padding-left: 18px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>

                </section>

            </main>
        </div>
    <?php else: ?>
        <?php echo $__env->yieldContent('guest'); ?>
    <?php endif; ?>

</body>

</html><?php /**PATH C:\laragon\www\omd-order\resources\views/layouts/app.blade.php ENDPATH**/ ?>