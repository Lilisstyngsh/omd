@extends('layouts.app')

@section('title', $area->name . ' - Model & Produk')
@section('header', $area->name . ' - Model & Produk')

@section('content')
<style>
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

    .context-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .context-title h2 {
        margin: 0;
    }

    .context-title p {
        margin: 6px 0 0;
        color: #667085;
    }

    .master-grid-forms {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .context-chip {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f5f3ff;
        color: #6d28d9;
        font-size: 11px;
        font-weight: 750;
        margin-top: 10px;
    }

    .master-table th,
    .master-table td {
        border: 1px solid #e9e7ef;
        vertical-align: middle;
    }

    .master-table th {
        background: #faf9fc;
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

    .col-no {
        width: 70px;
        text-align: center;
    }

    .col-model {
        width: 180px;
    }

    .col-product-no {
        width: 80px;
        text-align: center;
    }

    .col-action {
        width: 190px;
        text-align: center;
    }

    @media (max-width:800px) {
        .master-grid-forms {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="breadcrumb">
    <a href="{{ route('omd.master.index', ['scope' => $scope]) }}">Data Master {{ $scopeLabel }}</a>
    <span>›</span>
    <a href="{{ route('omd.master.plant.index', ['scope' => $scope, 'plant' => $plant]) }}">{{ $plant->name }}</a>
    <span>›</span>
    <strong>{{ $area->name }}</strong>
</div>

<div class="context-head">
    <div class="context-title">
        <h2>{{ $area->name }}</h2>
        <p>Kelola Model dan Produk pada Area / Line ini.</p>
        <span class="context-chip">{{ $scopeLabel }} · {{ $plant->name }} · {{ $area->name }}</span>
    </div>

    <a class="btn btn-secondary" href="{{ route('omd.master.plant.index', ['scope' => $scope, 'plant' => $plant]) }}">← Kembali ke Area</a>
</div>

<div class="master-grid-forms">
    <div class="card">
        <h3 style="margin-top:0;">Tambah Model</h3>
        <div class="muted" style="margin-bottom:16px;">Scope, Plant, dan Area mengikuti halaman ini otomatis.</div>

        <form method="POST" action="{{ route('omd.master.model.store', ['scope' => $scope, 'plant' => $plant, 'area' => $area]) }}">
            @csrf
            <div class="field">
                <label for="model">Model</label>
                <input id="model" name="model" value="{{ old('model') }}" placeholder="Contoh: 660" maxlength="100" required>
            </div>
            <button class="btn btn-primary" style="margin-top:14px;">Simpan Model</button>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">Tambah Produk</h3>
        <div class="muted" style="margin-bottom:16px;">Pilih Model, lalu masukkan Produk.</div>

        <form method="POST" action="{{ route('omd.master.product.store', ['scope' => $scope, 'plant' => $plant, 'area' => $area]) }}">
            @csrf
            <div class="field">
                <label for="master_model_id">Model</label>
                <select id="master_model_id" name="master_model_id" required>
                    <option value="">Pilih model</option>
                    @foreach ($models as $model)
                    <option value="{{ $model->id }}" @selected(old('master_model_id')==$model->id)>
                        {{ $model->number }} - {{ $model->model }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="field" style="margin-top:14px;">
                <label for="product">Produk</label>
                <input id="product" name="product" value="{{ old('product') }}" placeholder="Contoh: Produk A" maxlength="150" required>
            </div>
            <button class="btn btn-primary" style="margin-top:14px;" {{ $models->isEmpty() ? 'disabled' : '' }}>Simpan Produk</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="page-head" style="margin-bottom:16px;">
        <div>
            <h3 style="margin:0;">Model & Produk</h3>
            <div class="muted">{{ $scopeLabel }} / {{ $plant->name }} / {{ $area->name }}</div>
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
                @forelse ($models as $model)
                @forelse ($model->products as $index => $product)
                <tr>
                    @if ($index === 0)
                    <td class="col-no" rowspan="{{ $model->products->count() }}"><b>{{ $model->number }}</b></td>
                    <td class="col-model" rowspan="{{ $model->products->count() }}">
                        <b>{{ $model->model }}</b>
                        <div style="margin-top:8px;">
                            <a class="btn btn-secondary btn-sm" href="{{ route('omd.master.model.edit', ['scope' => $scope, 'plant' => $plant, 'area' => $area, 'masterModel' => $model]) }}">Edit Model</a>
                        </div>
                    </td>
                    @endif
                    <td class="col-product-no">{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="col-action">
                        <div class="action-inline">
                            <a class="btn btn-secondary btn-sm" href="{{ route('omd.master.product.edit', ['scope' => $scope, 'plant' => $plant, 'area' => $area, 'product' => $product]) }}">Edit</a>
                            <form method="POST" action="{{ route('omd.master.product.destroy', ['scope' => $scope, 'plant' => $plant, 'area' => $area, 'product' => $product]) }}" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="col-no"><b>{{ $model->number }}</b></td>
                    <td class="col-model">
                        <b>{{ $model->model }}</b>
                        <div style="margin-top:8px;">
                            <a class="btn btn-secondary btn-sm" href="{{ route('omd.master.model.edit', ['scope' => $scope, 'plant' => $plant, 'area' => $area, 'masterModel' => $model]) }}">Edit Model</a>
                        </div>
                    </td>
                    <td class="col-product-no">-</td>
                    <td class="muted">Belum ada produk.</td>
                    <td class="col-action">
                        <form method="POST" action="{{ route('omd.master.model.destroy', ['scope' => $scope, 'plant' => $plant, 'area' => $area, 'masterModel' => $model]) }}" onsubmit="return confirm('Hapus model {{ addslashes($model->model) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus Model</button>
                        </form>
                    </td>
                </tr>
                @endforelse
                @empty
                <tr>
                    <td colspan="5" class="empty">Belum ada Model pada area ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection