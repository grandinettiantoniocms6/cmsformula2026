<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use CrudTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    use HasTranslations;

    public $translatable = ["title_page", "subtitle_page", "color_title_page", "color_subtitle_page", "slug", "title", "meta_title", "meta_description", "meta_keywords", "url", "url_interno"];

    protected $table = 'pages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            static $hasUpdatedByColumn = null;
            if ($hasUpdatedByColumn === null) {
                $hasUpdatedByColumn = Schema::hasColumn($model->getTable(), 'updated_by');
            }

            if (!$hasUpdatedByColumn) {
                return;
            }

            if (function_exists('backpack_auth') && backpack_auth()->check()) {
                $model->updated_by = backpack_user()->id;

                if (Schema::hasColumn($model->getTable(), 'updated_context')) {
                    $model->updated_context = 'page';
                }

                if (Schema::hasColumn($model->getTable(), 'updated_block_type')) {
                    $model->updated_block_type = null;
                }
            }
        });
    }

    /*public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('public')->delete($obj->image);
        });
    }*/
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "photo_background";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        // destination path relative to the disk above
        $destination_path = "public/uploads/pages";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image

            // $value può essere assoluto o relativo
            $absolute = $this->resolveImagePath($value);

            // Se è un URL remoto, meglio usare i byte/stream
            if (\Str::startsWith($absolute, ['http://', 'https://'])) {
                $bytes  = file_get_contents($absolute); // o Http::get(...)->body()
                $image  = \Image::make($bytes)->encode('jpg', 90);
            } else {
                $image  = \Image::make($absolute)->encode('jpg', 90);
            }

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = \Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }
    /*
    |------------------------------set_field_page--------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function getMenu(){
        if($this->slug == "/"){
            $linkAnteprima = "/";
        }else{
            $linkAnteprima = "/$this->slug";
        }

        $slug_shop_formula = config('config.slug_shop_formula');
        $slug_plugin_booking = config('config.slug_plugin_booking');

        if(in_array($this->name, $slug_shop_formula)){
            return "";
        }

        if(in_array($this->name, $slug_plugin_booking)){
            return "";
        }


        $url_edit = "/admin/page/$this->id/edit";

        $pages_count = Page::count();
        $website = WebsiteSetting::first();
        $hasPageLimit = $website && (int) $website->number_max_page > 0;
        $number = $hasPageLimit ? (int) $website->number_max_page - $pages_count : null;

        $link_duplica = "";
        if(!$hasPageLimit || $number > 0){
            $link_duplica = '<a href="javascript:void(0)" onclick="cloneEntry(this)" data-route="/admin/page/'.$this->id.'/clone" class="dropdown-item" data-button-type="clone">Duplica</a>';
        }


        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();
        if($editing){
            $icon_editing = "<i class='la la-exclamation text text-danger'></i>";

            $user = User::find($editing->user_id);
            if($user){
                $link_editing = "<a class=\"dropdown-item text text-danger\" href='#'>$user->name modifica!</a>";
            }
        }

        $linkBlocchi = route('pages.blocks', $this->id);

        if(backpack_user()->roles[0]->id == 4){
            $html = '<a class="dropdown-item" href="'.$linkAnteprima.'" target="_blank">Anteprima</a>';
            return $html;
        }

        $countBlocchi = PageBlock::where("page_id", $this->id)->count();

        $htmlLinkBlocchi = '<a class="dropdown-item" href="'.$linkBlocchi.'">Blocchi ('.$countBlocchi.')</a>';

        if(in_array($this->slug, config('config.slugs_protected'))){
            $keyUrl = array_search($this->slug, config('config.slugs_protected'));
            $htmlLinkBlocchi = '<a class="dropdown-item" href="'.$keyUrl.'">Impostazioni</a>';
        }

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$icon_editing.' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.$htmlLinkBlocchi.'
                    <a class="dropdown-item" href="'.$linkAnteprima.'" target="_blank">Anteprima</a>
                    '.$link_editing.'
                    '.$link_duplica.'
                    <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/page/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>
                  </div>
                </div><script>

	if (typeof deleteEntry != \'function\') {
	  $("[data-button-type=delete]").unbind(\'click\');

	  function deleteEntry(button) {
		// ask for confirmation before deleting an item
		// e.preventDefault();
		var button = $(button);
		var route = button.attr(\'data-route\');
		var row = $("#crudTable a[data-route=\'"+route+"\']").closest(\'tr\');

		swal({
		  title: "Avvertimento",
		  text: "Sei sicuro di eliminare questo elemento?",
		  icon: "warning",
		  buttons: {
		  	cancel: {
			  text: "Annulla",
			  value: null,
			  visible: true,
			  className: "bg-secondary",
			  closeModal: true,
			},
		  	delete: {
			  text: "Elimina",
			  value: true,
			  visible: true,
			  className: "bg-danger",
			}
		  },
		}).then((value) => {
			if (value) {
				$.ajax({
			      url: route,
			      type: \'DELETE\',
			      success: function(result) {
			          if (result == 1) {
			          	  // Show a success notification bubble
			              new Noty({
		                    type: "success",
		                    text: "<strong>Elemento eliminato</strong><br>L\'elemento è stato eliminato con successo."
		                  }).show();

			              // Hide the modal, if any
			              $(\'.modal\').modal(\'hide\');

			              // Remove the details row, if it is open
			              if (row.hasClass("shown")) {
			                  row.next().remove();
			              }

			              // Remove the row from the datatable
			              row.remove();
			          } else {
			              // if the result is an array, it means
			              // we have notification bubbles to show
			          	  if (result instanceof Object) {
			          	  	// trigger one or more bubble notifications
			          	  	Object.entries(result).forEach(function(entry, index) {
			          	  	  var type = entry[0];
			          	  	  entry[1].forEach(function(message, i) {
					          	  new Noty({
				                    type: type,
				                    text: message
				                  }).show();
			          	  	  });
			          	  	});
			          	  } else {// Show an error alert
				              swal({
				              	title: "NON eliminato",
	                            text: "C\'è stato un errore. L\'elemento potrebbe non essere stato eliminato.",
				              	icon: "error",
				              	timer: 4000,
				              	buttons: false,
				              });
			          	  }
			          }
			      },
			      error: function(result) {
			          // Show an alert with the result
			          swal({
		              	title: "NON eliminato",
                        text: "C\'è stato un errore. L\'elemento potrebbe non essere stato eliminato.",
		              	icon: "error",
		              	timer: 4000,
		              	buttons: false,
		              });
			      }
			  });
			}
		});

      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue(\'deleteEntry\');
</script>';

        $html .= '<script>
                        if (typeof cloneEntry != \'function\') {
                          $("[data-button-type=clone]").unbind(\'click\');

                          function cloneEntry(button) {
                              // ask for confirmation before deleting an item
                              // e.preventDefault();
                              var button = $(button);
                              var route = button.attr(\'data-route\');

                              $.ajax({
                                  url: route,
                                  type: "POST",
                                  success: function(result) {
                                      // Show an alert with the result
                                      new Noty({
                                        type: "success",
                                        text: "<strong>Elemento duplicato</strong><br>Un nuovo elemento è stato creato con le stesse informazioni di questo."
                                      }).show();

                                      // Hide the modal, if any
                                      $(\'.modal\').modal(\'hide\');

                                      if (typeof crud !== \'undefined\') {
                                        crud.table.ajax.reload();
                                      }
                                  },
                                  error: function(result) {
                                      // Show an alert with the result
                                      new Noty({
                                        type: "warning",
                                        text: "<strong>Duplicazione fallita</strong><br>Il nuovo elemento non può essere creato. Per favore, riprova."
                                      }).show();
                                  }
                              });
                          }
                        }
                        // make it so that the function above is run after each DataTable draw event
                        // crud.addFunctionToDataTablesDrawEventQueue(\'cloneEntry\');
                    </script>';

        return $html;
    }

    public function get_name()
    {
        $name = e($this->name);
        $indent = '';

        if($this->parent_id !== null){
            $indent = '&nbsp;&nbsp;&nbsp;';
        }

        $slug_shop_formula = config('config.slug_shop_formula');
        $slug_plugin_booking = config('config.slug_plugin_booking');

        if(in_array($this->name, $slug_shop_formula) || in_array($this->name, $slug_plugin_booking)){
            return $indent.$name;
        }

        if(backpack_user()->roles[0]->id > 3){
            return $indent.$name;
        }

        $linkBlocchi = route('pages.blocks', $this->id);
        $urlEdit = "/admin/page/$this->id/edit";

        $actions = '<span class="page-inline-actions">
            <a class="page-inline-action" href="'.$linkBlocchi.'" title="Modifica blocchi" aria-label="Modifica blocchi">
                <i class="la la-pencil"></i>
            </a>
            <a class="page-inline-action" href="'.$urlEdit.'" title="Impostazioni pagina" aria-label="Impostazioni pagina">
                <i class="la la-cog"></i>
            </a>
        </span>';

        return $indent.$name.$actions;

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

    function resolveImagePath(string $value): string
    {
        // 1) URL remoti → li lasci così (poi passerai i byte/stream)
        if (\Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        // 2) Già assoluto (/home/..., /var/..., /... )
        if (\Str::startsWith($value, '/')) {
            return $value;
        }

        // 3) Relativo che esiste dalla CWD
        if (is_file($value)) {
            return realpath($value);
        }

        // 4) Relativo sotto public/ (es. "uploads/hero/foo.png" o "storage/foo.png")
        $pub = public_path(ltrim($value, '/'));
        if (is_file($pub)) {
            return $pub;
        }

        // 5) Relativo sul disco 'public' (storage/app/public/...)
        if (\Storage::disk('public')->exists($value)) {
            return \Storage::disk('public')->path($value);
        }

        throw new \RuntimeException("File non trovato: {$value}");
    }
}
