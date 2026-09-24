<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterModel extends Model
{
    protected $table = 'master_models';

    protected $fillable = [
        'data_scope',
        'number',
        'model',
        'is_active',
    ];

    protected $casts = [
        'number' => 'integer',
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'master_model_id');
    }

    public function getScopeLabelAttribute(): string
    {
        return strtoupper($this->data_scope);
    }
}
