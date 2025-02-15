<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginParkingReservation extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_parking_reservations';
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

    public function getMenu()
    {
        $type = "plugin-parking-reservation";

        $url_edit = "/admin/$type/$this->id/edit";

        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";
        $editing = UserNavigation::where("user_id", "!=", backpack_user()->id)->where("url", $url_edit)->first();

        $html = '<div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    public function getSetting(){
        $html = "";

        if($this->is_blacklist == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_blacklist", 0]);
            $html .= "<strong>Blacklist</strong> <a href='$url' class='text text-success'><i class=\"las la-skull-crossbones\"></i></a><br>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_blacklist", 1]);
            $html .= "<strong>Blacklist</strong> <a href='$url' class='text text-danger'><i class=\"las la-skull-crossbones\"></i></a><br>";
        }

        if($this->is_checkin == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_checkin", 0]);
            $html .= "<strong>Entrata</strong> <a href='$url' class='text text-success'><i class=\"las la-car-side\"></i></a><br>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_checkin", 1]);
            $html .= "<strong>Entrata</strong> <a href='$url' class='text text-danger'><i class=\"las la-car-side\"></i></a><br>";
        }

        if($this->is_payed == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_payed", 0]);
            $html .= "<strong>Pagato</strong> <a href='$url' class='text text-success'><i class=\"las la-euro-sign\"></i></a><br>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_payed", 1]);
            $html .= "<strong>Pagato</strong> <a href='$url' class='text text-danger'><i class=\"las la-euro-sign\"></i></a><br>";
        }

        if($this->created_at){
            $data = Carbon::createFromFormat("Y-m-d H:i:s", $this->created_at)->format("d/m/Y H:i");
            $html .= "<small>Prenotato il $data</small>";
        }

        return $html;
    }


    public function getIsCheckin(){
        if($this->is_checkin == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_checkin", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_checkin", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getIsPayed(){
        if($this->is_payed == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_payed", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_payed", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }



    public function getIsBlackList(){
        if($this->is_blacklist == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_blacklist", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_blacklist", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getIsNewsletter(){
        if($this->is_newsletter == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations', $this->id, "is_newsletter", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_parking_reservations',$this->id, "is_newsletter", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getType(){
        if($this->type_park == 1)
            return "<span class='badge badge-info'>Scoperto</span>";

        if($this->type_park == 2)
            return "<span class='badge badge-warning'>Coperto</span>";
    }


    public function getFrom(){

        $html = "";
        if($this->from == "parkos") {
            $html .= "<span class='badge badge-dark'>PARKOS</span>";

            $modal = '<div class="modal fade" id="exampleModalInfo_' . $this->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_' . $this->id . '" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_' . $this->id . '">Info Parkos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                <table width="100%">
                                <tr>
                                    <td><strong>Codice</strong></td>
                                    <td>' . $this->parkos_code . '</td>
                                </tr>
                                 <tr>
                                    <td><strong>Parking Type</strong></td>
                                    <td>' . $this->parkos_parking_type . '</td>
                                </tr>
                                 <tr>
                                    <td><strong>Parkos Airport</strong></td>
                                    <td>' . $this->parkos_airport . '</td>
                                </tr>
                                  <tr>
                                    <td><strong>Merchant</strong></td>
                                    <td>' . $this->merchant . '</td>
                                </tr>
                                  <tr>
                                    <td><strong>Merchant ID</strong></td>
                                    <td>' . $this->merchant_id . '</td>
                                </tr>
                                </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                          </div>
                        </div>
                      </div>
                    </div>';

            $html .= $modal;

            $html .= '<br><a href="#" data-toggle="modal" data-target="#exampleModalInfo_' . $this->id . '" data-button-type="clone">Info Parkos</a>';
        }

        if($this->from == null)
            $html .="<span class='badge badge-secondary'>SITO</span>";

        return $html;
    }

    public function getTotal(){
        if($this->total)
            return "&euro; ".number_format($this->total, 2, ",", ".");
    }

    public function getStart(){
        if($this->date_start){
            $date = Carbon::createFromFormat("Y-m-d", $this->date_start)->format("d/m/Y");

            if($this->time_start){
                $time = Carbon::createFromFormat("H:i:s", $this->time_start)->format("H:i");
                return "$date <br>ore $time";
            }

            return "$date";
        }
    }

    public function getEnd(){
        if($this->date_end){
            $date = Carbon::createFromFormat("Y-m-d", $this->date_end)->format("d/m/Y");

            if($this->time_end){
                $time = Carbon::createFromFormat("H:i:s", $this->time_end)->format("H:i");
                return "$date <br> ore $time";
            }

            return "$date";
        }
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
}
