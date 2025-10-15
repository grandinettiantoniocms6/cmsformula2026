<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlockCollage extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    use HasTranslations;
    public $translatable = ['title_dx','description_dx','url_dx_interno','url_dx','button_dx','title_sx','description_sx','url_sx_interno','url_sx','button_sx'];

    protected $table = 'blocks_collages';
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
    // Sistema che genera la THUMB
    public function get_foto_mini(){
        if($this->foto_sx){
            $basename = basename($this->foto_sx);
            $temp = explode(".", $basename);

            $check = "thumb/blocks_collages/$temp[0]-mini.webp";
            if(file_exists($check)){
                $url = url($check);
                return "<img src='$url'>";
            }

            $url = url($this->foto_sx);
            return "<img src='$url' style='width: 120px; border-radius: 3px;'>";
        }
    }

    public function setFotoSxAttribute($value)
    {
        $attribute_name = "foto_sx";
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/blocks_collages";

        if ($value == null) {
            $this->attributes[$attribute_name] = null;
            return;
        }

        $basename = basename($value);
        $nameFile = explode(".", $basename);

        // nuovo sistema Thumb 2.0 creato il 25/10/2022 KT
        $adminBlock = AdminBlock::where("name", "blockCollage")->first();
        $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

        if(count($adminThumb)){
            foreach ($adminThumb as $thumb){
                // $value può essere assoluto o relativo
                $absolute = $this->resolveImagePath($value);

                // Se è un URL remoto, meglio usare i byte/stream
                if (\Str::startsWith($absolute, ['http://', 'https://'])) {
                    $bytes  = file_get_contents($absolute); // o Http::get(...)->body()
                    $image  = \Image::make($bytes)->encode('webp', 90);
                } else {
                    $image  = \Image::make($absolute)->encode('webp', 90);
                }

                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                $suffix = $thumb->suffix;

                $image->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });

                $filename = "$nameFile[0]-{$suffix}.webp";
                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            }
        }
        // end sistema Thumb 2.0

        $this->attributes[$attribute_name] = $value;
    }

    public function setFotoDxAttribute($value)
    {
        $attribute_name = "foto_dx";
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "public/thumb/blocks_collages";

        if ($value == null) {
            $this->attributes[$attribute_name] = null;
            return;
        }

        $basename = basename($value);
        $nameFile = explode(".", $basename);

        // nuovo sistema Thumb 2.0 creato il 25/10/2022 KT
        $adminBlock = AdminBlock::where("name", "blockCollage")->first();
        $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

        if(count($adminThumb)){
            foreach ($adminThumb as $thumb){
                // $value può essere assoluto o relativo
                $absolute = $this->resolveImagePath($value);

                // Se è un URL remoto, meglio usare i byte/stream
                if (\Str::startsWith($absolute, ['http://', 'https://'])) {
                    $bytes  = file_get_contents($absolute); // o Http::get(...)->body()
                    $image  = \Image::make($bytes)->encode('webp', 90);
                } else {
                    $image  = \Image::make($absolute)->encode('webp', 90);
                }

                $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                $suffix = $thumb->suffix;

                $image->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });

                $filename = "$nameFile[0]-{$suffix}.webp";
                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            }
        }
        // end sistema Thumb 2.0

        $this->attributes[$attribute_name] = $value;
    }

    public function getMenu()
    {
        $type = "blockCollage";

        $url_edit = "/admin/$type/$this->id/edit";

        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ' . $icon_editing . ' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    ' . $link_editing . '
                    <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/' . $type . '/' . $this->id . '" class="dropdown-item" data-button-type="delete">Elimina</a>
                  </div>
                </div>';
        if ($editing) {
            $icon_editing = "<i class='la la-exclamation text text-danger'></i>";

            $user = User::find($editing->user_id);
            if ($user) {
                $link_editing = "<span class=\"text text-danger\">$user->name in modifica...</span>";
            }

            $html = '' . $icon_editing . ' ' . $link_editing . '';
        }

        $html .= '<script>

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
        return $html;
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
