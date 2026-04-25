<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class DashboardTodo extends Model
{
    use CrudTrait;

    protected $table = 'dashboard_todos';
    protected $guarded = ['id'];
    protected $casts = [
        'is_done' => 'boolean',
        'sort_order' => 'integer',
        'priority' => 'string',
    ];
}
