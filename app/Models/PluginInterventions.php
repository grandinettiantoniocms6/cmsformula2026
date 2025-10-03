<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginInterventions extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_interventions';
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
    public function getDate(){
        $html = "";

        $date_it = Carbon::createFromFormat("Y-m-d", $this->date_intervention)->format("d/m/Y");

        if($this->is_all_day){
            $html .= "$date_it <br> Tutto il giorno";
        }else{
            if($this->start && $this->end){
                $start = Carbon::createFromFormat("H:i:s", $this->start)->format("H:i");
                $end = Carbon::createFromFormat("H:i:s", $this->end)->format("H:i");

                $html .= "$date_it <br> Dalle $start alle $end";
            }else{
                $html .= "$date_it";
            }

        }

        return $html;
    }

    public function getClient(){
        $html = "";

        if($this->client){
            $nominativo = "{$this->client->first_name} {$this->client->last_name}";

            if(strlen($nominativo) > 40){
                $nominativo = substr($nominativo, 0, 40);
                $nominativo .= "...";
            }

            $html .= "{$nominativo}<br> {$this->client->mobile}";
        }

        return $html;
    }

    public function getAddress(){
        $html = "";

        $int = "";
        if($this->interno){
            $int = "Int.{$this->interno}";
        }

        $html .= "{$this->address} {$this->civico} $int<br> {$this->frazione} {$this->comune} {$this->provincia} <br> {$this->cap}";

        return $html;
    }

    public function getVehicle(){
        $html = "";

        if($this->vehicle){
            $html .= "{$this->vehicle->name} <br> {$this->vehicle->code}";
        }

        return $html;
    }

    public function getStatus(){
        $html = "";

        if($this->status){
            $html .= "<div id='res-status-$this->id'><span style='padding:3px; background-color:{$this->status->color}; color:black;'>{$this->status->name}</span></div>";
        }

        return $html;
    }

    public function getDriver(){
        $html = "";

        if($this->driver){
             $html .= "<strong>A:</strong> {$this->driver->first_name} {$this->driver->last_name}";
        }

        if($this->laborer){
            $html .= "<br><strong>M:</strong> {$this->laborer->first_name} {$this->laborer->last_name}";
        }

        return $html;
    }

    public function getLaborer(){
        $html = "";

        if($this->laborer){
            $html .= "{$this->laborer->first_name} {$this->laborer->last_name}";
        }

        return $html;
    }

    public function getCheck(){
        return "<input type='checkbox' class='checkbox' name='ids[]' value='{$this->id}'>";
    }


    public function getIsInvoice(){
        if($this->is_invoice == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_interventions', $this->id, "is_invoice", 0]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-file-invoice la-2x\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_interventions',$this->id, "is_invoice", 1]);
            return "<a href='$url' class='text text-dark'><i class=\"las la-file-invoice la-2x\"></i></a>";
        }
    }


    public function getIsPaid(){
        if($this->is_paid == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_interventions', $this->id, "is_paid", 0]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-euro-sign la-2x\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_interventions',$this->id, "is_paid", 1]);
            return "<a href='$url' class='text text-dark'><i class=\"las la-euro-sign la-2x\"></i></a>";
        }
    }

    public function getIsDelivery(){
        if($this->is_delivery == 1){
            //$url = route('dashboard.set.field.boolean', ['plugins_interventions', $this->id, "is_delivery", 0]);
            return "<div id='delivery_$this->id'><a href='javascript:change_delivery($this->id, 0)' class='text text-success'><i class=\"las la-list la-2x\"></i></a></div>";
        }else{
            // $url = route('dashboard.set.field.boolean', ['plugins_interventions',$this->id, "is_delivery", 1]);
            return "<div id='delivery_$this->id'><a href='javascript:change_delivery($this->id, 1)' class='text text-dark'><i class=\"las la-list la-2x\"></i></a></div>";
        }
    }




    public function getMenu()
    {
        $type = "plugin-interventions";

        $url_edit = "/admin/$type/$this->id/edit";
        $url_pdf = route('pluginInterventions.print_pdf', $this->id);
        $url_send = route('pluginInterventions.send_mail', $this->id);
        $url_annulla = route('pluginInterventions.annulla', $this->id);

        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();

        $link_export = "<a class=\"dropdown-item\" href=\"$url_pdf\">Scarica PDF</a>";
        $link_send = "<a class=\"dropdown-item\" href=\"$url_send\">Invia Email</a>";
        $link_annulla = "<a class=\"dropdown-item\" href=\"$url_annulla\">Annulla</a>";

        // <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/' . $type . '/' . $this->id . '" class="dropdown-item" data-button-type="delete">Elimina</a>

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ' . $icon_editing . ' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    ' . $link_editing . '
                    ' . $link_export . '
                    ' . $link_send . '
                    ' . $link_annulla . '
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
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function client(){
        return $this->belongsTo(PluginInterventionsClients::class, "client_id");
    }

    public function vehicle(){
        return $this->belongsTo(PluginInterventionsVehicles::class, "vehicle_id");
    }

    public function driver(){
        return $this->belongsTo(PluginInterventionsDrivers::class, "driver_id");
    }

    public function laborer(){
        return $this->belongsTo(PluginInterventionsLaborers::class, "laborer_id");
    }

    public function status(){
        return $this->belongsTo(PluginInterventionsStatus::class, "status_id");
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
