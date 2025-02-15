<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class BlockPage extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'blocks_pages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getPages()
    {
        if($this->page){
            return "<a href='/admin/pages_blocks/{$this->page->id}' target='_blank'>{$this->page->name}</a>";
        }
    }

    public function getEreditato()
    {
        $html = "";
        if($this->is_ereditable_from_id){
            $block_page = BlockPage::find($this->is_ereditable_from_id);
            if($block_page){
                $page = Page::find($block_page->page_id);

                $html = "<strong>ID:</strong> $block_page->obj_id <br><strong>TIPO:</strong> $block_page->type
                        <br> <strong>PAGINA:</strong> $page->name";
            }else{
                $html = "<span class='text text-danger'>$this->is_ereditable_from_id non esiste</span>";
            }
        }
        return $html;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
