@extends('layouts.app')

@section('title', 'Data ' . $scopeLabel)
@section('header', 'Data ' . $scopeLabel)

@section('content')
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
            <h2>Master Model & Produk {{ $scopeLabel }}</h2>
            <div class="muted"></div>
        </div>

        <div class="export-actions">
            <a class="btn btn-success" href="{{ route('omd.master.export.excel', $scope) }}">
                Export Excel
            </a>

            <a class="btn btn-danger" href="{{ route('omd.master.export.pdf', $scope) }}">
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid2" style="grid-template-columns: 1fr 1fr; margin-bottom: 20px;">
        <div class="card">
            <h3 style="margin-top:0;">Tambah Model</h3>

            <form method="POST" action="{{ route('omd.master.model.store', $scope) }}">
                @csrf

                <div class="field">
                    <label for="model">Model</label>
                    <input id="model" name="model" value="{{ old('model') }}" placeholder="Masukkan model" required>
                </div>

                <button class="btn btn-primary" style="margin-top:14px;">
                    Simpan Model
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-top:0;">Tambah Produk</h3>
            <div class="muted" style="margin-bottom:16px;"></div>

            <form method="POST" action="{{ route('omd.master.product.store', $scope) }}">
                @csrf

                <div class="field">
                    <label for="master_model_id">Model</label>
                    <select id="master_model_id" name="master_model_id" required>
                        <option value="">Pilih model</option>

                        @foreach ($models as $model)
                            <option value="{{ $model->id }}" @selected(old('master_model_id', $selectedModelId) == $model->id)>
                                {{ $model->number }} - {{ $model->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field" style="margin-top:14px;">
                    <label for="product">Produk</label>
                    <input id="product" name="product" value="{{ old('product') }}" placeholder="Masukkan produk" required>
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
                <h3 style="margin:0;">Data Model & Produk {{ $scopeLabel }}</h3>
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
                    @forelse ($models as $model)
                        @forelse ($model->products as $index => $product)
                            <tr>
                                @if ($index === 0)
                                    <td class="col-no" rowspan="{{ $model->products->count() }}">
                                        <b>{{ $model->number }}</b>
                                    </td>

                                    <td class="col-model" rowspan="{{ $model->products->count() }}">
                                        <b>{{ $model->model }}</b>

                                        <div style="margin-top:8px;">
                                            <a class="btn btn-secondary btn-sm"
                                                href="{{ route('omd.master.model.edit', [$scope, $model]) }}">
                                                Edit Model
                                            </a>
                                        </div>
                                    </td>
                                @endif

                                <td class="col-product-no">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $product->name }}
                                </td>

                                <td class="col-action">
                                    <div class="action-inline">
                                        <a class="btn btn-secondary btn-sm"
                                            href="{{ route('omd.master.product.edit', [$scope, $product]) }}">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('omd.master.product.destroy', [$scope, $product]) }}"
                                            onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="col-no">
                                    <b>{{ $model->number }}</b>
                                </td>

                                <td class="col-model">
                                    <b>{{ $model->model }}</b>

                                    <div style="margin-top:8px;">
                                        <a class="btn btn-secondary btn-sm"
                                            href="{{ route('omd.master.model.edit', [$scope, $model]) }}">
                                            Edit Model
                                        </a>
                                    </div>
                                </td>

                                <td class="col-product-no">-</td>

                                <td class="muted">
                                    Belum ada produk.
                                </td>

                                <td class="col-action">
                                    <form method="POST" action="{{ route('omd.master.model.destroy', [$scope, $model]) }}"
                                        onsubmit="return confirm('Hapus model {{ addslashes($model->model) }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Hapus Model
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada data model {{ $scopeLabel }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
