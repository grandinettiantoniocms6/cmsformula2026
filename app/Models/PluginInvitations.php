<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PluginInvitations extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_invitations';
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getMenu(){
        if(backpack_user()->country_id == config('config.default_country_user_it')){
            $button_field = "Reinvita";
            $button_field2 = "Elimina";
            $label1 = "Data accettazione";
            $button_swal = "Annulla";
            $button_swal2 = "Elimina";
            $title_swal = "Avvertimento";
            $subtitle_swal = "Sei sicuro di eliminare questo elemento?";
            $message_swal = "Elemento eliminato";

            $subtitle_swal2 = "Sei sicuro di voler inviare nuovamento l'invito?";
            $message_swal2 = "Invito inviato";

        }else{
            $button_field = "Re-invite";
            $button_field2 = "Delete";
            $label1 = "Date of acceptance";
            $button_swal = "Cancel";
            $button_swal2 = "Delete";
            $title_swal = "Warning";
            $subtitle_swal = "Are you sure you delete this item?";
            $message_swal = "Item deleted";
            $subtitle_swal2 = "Are you sure you want to send the invitation again?";

            $message_swal2 = "Invitation sent";
        }


        if($this->is_login == 1){
            if($this->login_at){
                $login_at = Carbon::createFromFormat("Y-m-d H:i:s", $this->login_at)->format("d/m/Y H:i");
                return "$label1: $login_at";
            }

        }

        $html = "";
        $user = User::where("email", $this->email)->first();
        if($user){
            if($this->login_at){
                $html = "";
            }else{
                if($user->active == 0){
                    $html = '<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/pluginInvitations/'.$this->id.'" class="btn btn-sm btn-link" data-button-type="delete"><i class="la la-trash"></i> Elimina1</a>';
                }
                $html .='<script>

            if (typeof deleteEntry != \'function\') {
              $("[data-button-type=delete]").unbind(\'click\');

              function deleteEntry(button) {
                // ask for confirmation before deleting an item
                // e.preventDefault();
                var button = $(button);
                var route = button.attr(\'data-route\');
                var row = $("#crudTable a[data-route=\'"+route+"\']").closest(\'tr\');

                swal({
                  title: "'.$title_swal.'",
                  text: "'.$subtitle_swal.'",
                  icon: "warning",
                  buttons: {
                    cancel: {
                      text: "'.$button_swal.'",
                      value: null,
                      visible: true,
                      className: "bg-secondary",
                      closeModal: true,
                    },
                    delete: {
                      text: "'.$button_swal2.'",
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
                                    text: "<strong>'.$message_swal.'</strong>"
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
            }
        }



        if($this->is_login == 0){
            $html = '<a href="javascript:void(0)" onclick="resendEntry(this)" data-route="/admin/pluginInvitations/resend/'.$this->id.'" class="btn btn-sm btn-link"> <i class="la la-share"></i> '.$button_field.'</a>
                <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/pluginInvitations/'.$this->id.'" class="btn btn-sm btn-link" data-button-type="delete"><i class="la la-trash"></i>  '.$button_field2.'</a>';
            $html .='<script>

            if (typeof deleteEntry != \'function\') {
              $("[data-button-type=delete]").unbind(\'click\');

              function resendEntry(button){
                   var button = $(button);
                   var route = button.attr(\'data-route\');

                  swal({
                  title: "'.$title_swal.'",
                  text: "'.$subtitle_swal2.'",
                  icon: "warning",
                  buttons: {
                    cancel: {
                      text: "'.$button_swal.'",
                      value: null,
                      visible: true,
                      className: "bg-secondary",
                      closeModal: true,
                    },
                    delete: {
                      text: "'.$button_field.'",
                      value: true,
                      visible: true,
                      className: "bg-success",
                    }
                  },
                }).then((value) => {
                    if (value) {
                        $.ajax({
                          url: route,
                          type: \'GET\',
                          success: function(result) {
                              if (result == 1) {
                                  new Noty({
                                    type: "success",
                                    text: "<strong>'.$message_swal2.'</strong>"
                                  }).show();

                                  //location.reload();

                              } else {
                                  swal({
                                    title: "NON inviato",
                                    text: "C\'è stato un errore. L\'elemento potrebbe non essere stato reinvitato.",
                                    icon: "error",
                                    timer: 4000,
                                    buttons: false,
                                  });
                              }
                          },
                          error: function(result) {
                              // Show an alert with the result
                              swal({
                                title: "NON inviato",
                                text: "C\'è stato un errore. L\'elemento potrebbe non essere stato reinvitato.",
                                icon: "error",
                                timer: 4000,
                                buttons: false,
                              });
                          }
                      });
                    }
                });
              }

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

        return ''.$html.'';
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
