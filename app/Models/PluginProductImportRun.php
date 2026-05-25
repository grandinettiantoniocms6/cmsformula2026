<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginProductImportRun extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'queued_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function config()
    {
        return $this->belongsTo(PluginProductImport::class, 'plugin_product_import_id');
    }

    public function steps()
    {
        return $this->hasMany(PluginProductImportRunStep::class, 'plugin_product_import_run_id')->orderBy('id');
    }
}
