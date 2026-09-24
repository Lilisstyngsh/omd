<?php

namespace App\Http\Controllers;

use App\Models\MasterModel;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MasterDataExport;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    private function validateScope(string $scope): void
    {
        abort_unless(
            in_array($scope, ['ppic', 'produksi'], true),
            404
        );
    }

    private function scopeLabel(string $scope): string
    {
        return strtoupper($scope);
    }

    /**
     * Menampilkan Data Master Model & Produk.
     */
    public function index(string $scope, ?int $model = null)
    {
        $this->validateScope($scope);

        $models = MasterModel::query()
            ->where('data_scope', $scope)
            ->with([
                'products' => fn($query) => $query->orderBy('name')
            ])
            ->orderBy('number')
            ->get();

        return view('omd.master.index', [
            'scope' => $scope,
            'scopeLabel' => $this->scopeLabel($scope),
            'models' => $models,
            'selectedModelId' => $model,
        ]);
    }

    /**
     * Menambahkan Model.
     */
    public function storeModel(Request $request, string $scope)
    {
        $this->validateScope($scope);

        $validated = $request->validate([
            'model' => ['required', 'string', 'max:100'],
        ]);

        $modelName = trim($validated['model']);

        $exists = MasterModel::where('data_scope', $scope)
            ->whereRaw(
                'LOWER(model) = ?',
                [strtolower($modelName)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'model' => 'Model tersebut sudah terdaftar pada data '
                        . strtoupper($scope) . '.',
                ]);
        }

        $nextNumber = (
            (int) MasterModel::where('data_scope', $scope)
                ->max('number')
        ) + 1;

        MasterModel::create([
            'data_scope' => $scope,
            'number' => $nextNumber,
            'model' => $modelName,
        ]);

        return redirect()
            ->route('omd.master.index', ['scope' => $scope])
            ->with('success', 'Model berhasil ditambahkan.');
    }

    /**
     * Form Edit Model.
     */
    public function editModel(string $scope, MasterModel $masterModel)
    {
        $this->validateScope($scope);

        abort_unless(
            $masterModel->data_scope === $scope,
            404
        );

        return view('omd.master.edit-model', [
            'scope' => $scope,
            'scopeLabel' => $this->scopeLabel($scope),
            'masterModel' => $masterModel,
        ]);
    }

    /**
     * Update Model.
     */
    public function updateModel(
        Request $request,
        string $scope,
        MasterModel $masterModel
    ) {
        $this->validateScope($scope);

        abort_unless(
            $masterModel->data_scope === $scope,
            404
        );

        $validated = $request->validate([
            'model' => ['required', 'string', 'max:100'],
        ]);

        $modelName = trim($validated['model']);

        $exists = MasterModel::where('data_scope', $scope)
            ->where('id', '!=', $masterModel->id)
            ->whereRaw(
                'LOWER(model) = ?',
                [strtolower($modelName)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'model' => 'Model tersebut sudah digunakan.',
                ]);
        }

        $masterModel->update([
            'model' => $modelName,
        ]);

        return redirect()
            ->route('omd.master.index', ['scope' => $scope])
            ->with('success', 'Model berhasil diperbarui.');
    }

    /**
     * Hapus Model.
     */
    public function destroyModel(
        string $scope,
        MasterModel $masterModel
    ) {
        $this->validateScope($scope);

        abort_unless(
            $masterModel->data_scope === $scope,
            404
        );

        if ($masterModel->products()->exists()) {
            return back()->withErrors([
                'delete' =>
                'Model tidak dapat dihapus karena masih memiliki produk. '
                    . 'Hapus atau pindahkan produknya terlebih dahulu.',
            ]);
        }

        $masterModel->delete();

        return back()->with(
            'success',
            'Model berhasil dihapus.'
        );
    }

    /**
     * Menambahkan Produk.
     */
    public function storeProduct(
        Request $request,
        string $scope
    ) {
        $this->validateScope($scope);

        $validated = $request->validate([
            'master_model_id' => [
                'required',
                'integer',
                'exists:master_models,id',
            ],
            'product' => [
                'required',
                'string',
                'max:150',
            ],
        ]);

        $masterModel = MasterModel::where('data_scope', $scope)
            ->findOrFail($validated['master_model_id']);

        $productName = trim($validated['product']);

        $exists = $masterModel->products()
            ->whereRaw(
                'LOWER(name) = ?',
                [strtolower($productName)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'product' =>
                    'Produk tersebut sudah terdaftar pada model '
                        . $masterModel->model . '.',
                ]);
        }

        $masterModel->products()->create([
            'name' => $productName,
            'data_scope' => $scope,
        ]);

        return redirect()
            ->route('omd.master.index', [
                'scope' => $scope,
                'model' => $masterModel->id,
            ])
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form Edit Produk.
     */
    public function editProduct(
        string $scope,
        Product $product
    ) {
        $this->validateScope($scope);

        $product->load('masterModel');

        abort_unless(
            $product->masterModel &&
                $product->masterModel->data_scope === $scope,
            404
        );

        $models = MasterModel::where('data_scope', $scope)
            ->orderBy('number')
            ->get();

        return view('omd.master.edit-product', [
            'scope' => $scope,
            'product' => $product,
            'models' => $models,
        ]);
    }

    /**
     * Update Produk.
     */
    public function updateProduct(
        Request $request,
        string $scope,
        Product $product
    ) {
        $this->validateScope($scope);

        $product->load('masterModel');

        abort_unless(
            $product->masterModel &&
                $product->masterModel->data_scope === $scope,
            404
        );

        $validated = $request->validate([
            'master_model_id' => [
                'required',
                'integer',
                'exists:master_models,id',
            ],
            'product' => [
                'required',
                'string',
                'max:150',
            ],
        ]);

        $targetModel = MasterModel::where('data_scope', $scope)
            ->findOrFail($validated['master_model_id']);

        $productName = trim($validated['product']);

        $exists = $targetModel->products()
            ->where('id', '!=', $product->id)
            ->whereRaw(
                'LOWER(name) = ?',
                [strtolower($productName)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'product' =>
                    'Produk tersebut sudah terdaftar pada model tujuan.',
                ]);
        }

        $product->update([
            'master_model_id' => $targetModel->id,
            'data_scope' => $scope,
            'name' => $productName,
        ]);

        return redirect()
            ->route('omd.master.index', [
                'scope' => $scope,
                'model' => $targetModel->id,
            ])
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus Produk.
     */
    public function destroyProduct(
        string $scope,
        Product $product
    ) {
        $this->validateScope($scope);

        $product->load('masterModel');

        abort_unless(
            $product->masterModel &&
                $product->masterModel->data_scope === $scope,
            404
        );

        $modelId = $product->master_model_id;

        $product->delete();

        return redirect()
            ->route('omd.master.index', [
                'scope' => $scope,
                'model' => $modelId,
            ])
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Export Excel.
     */
    public function exportExcel(string $scope)
    {
        $this->validateScope($scope);

        return Excel::download(
            new MasterDataExport($scope),
            'data-master-'
                . $scope
                . '-'
                . now()->format('Ymd-His')
                . '.xlsx'
        );
    }

    /**
     * Export PDF.
     */
    public function exportPdf(string $scope)
    {
        $this->validateScope($scope);

        $models = MasterModel::query()
            ->where('data_scope', $scope)
            ->with([
                'products' => fn($query) => $query->orderBy('name')
            ])
            ->orderBy('number')
            ->get();

        $pdf = Pdf::loadView(
            'omd.master.exports.pdf',
            [
                'models' => $models,
                'scopeLabel' => $this->scopeLabel($scope),
            ]
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            'data-master-'
                . $scope
                . '-'
                . now()->format('Ymd-His')
                . '.pdf'
        );
    }
}
