<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginProductImportRunStep extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function run()
    {
        return $this->belongsTo(PluginProductImportRun::class, 'plugin_product_import_run_id');
    }
}
