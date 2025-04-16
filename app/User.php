<?php

namespace App;

use App\Models\Address;
use App\Models\Company;
use App\Models\PluginProducts;
use App\Models\UserSubscription;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','code','active','mobile', 'provider', 'provider_id','city','country_id', 'check_privacy', 'check_newsletter',
        'text_privacy', 'text_cookie', 'date_newsletter','business_name', 'vat', 'pec', 'sdi', 'address_invoice',
        'street_invoice', 'zip_invoice', 'city_invoice', 'province_invoice', 'state_invoice','plugin_product_id', 'user_id', 'type_client'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class, "user_id");
    }

    public function getCheck(){
        return "<input type='checkbox' class='checkbox' name='ids[]' value='{$this->id}'>";
    }

    public function getTypeClient(){
        if(is_numeric($this->type_client)){
            if($this->type_client == 0){
                return "<span class='badge badge-info'>Privato</span>";
            }
            if($this->type_client == 1){
                return "<span class='badge badge-warning'>Azienda</span>";
            }
        }
    }

    public function getSubscription(){
        if($this->subscriptions){
            $count = count($this->subscriptions);

            if($count > 0){
                return "<a href='/admin/user-subscription?user_id={$this->id}'>$count</a>";
            }
            return $count;
        }
    }

    public function get_buyer(){
        if($this->user_id){
            $userBuyer = User::find($this->user_id);
            if($userBuyer){
                return $userBuyer->name;
            }
        }
    }

    public function getMenu($var = null){
        $type = "pluginProductsClients";
        if($var == "buyer"){
            $type = "pluginProductsBuyers";
        }

        $url_edit = "/admin/$type/$this->id/edit";

        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";

        $access = route('access', $this->id);
        if($this->active == 1){
            $link_editing .= "<a class=\"dropdown-item\" href=\"$access\">Accedi</a>";
        }

        $count_addresses = Address::where("user_id", $this->id)->count();
        $count_companies = Company::where("user_id", $this->id)->count();

        $link_editing .= "<a class=\"dropdown-item\" href=\"/admin/shopAddresses?user_id=$this->id\">Spedizione ($count_addresses)</a>";
        $link_editing .= "<a class=\"dropdown-item\" href=\"/admin/shopCompanies?user_id=$this->id\">Fatturazione ($count_companies)</a>";


        $link_delete = "";
        if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2){
            $link_delete = '<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>';
        }

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$icon_editing.' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.$link_editing.'
                    '.$link_delete.'
                  </div>
                </div>';


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

    public function getMenuBooking($var = null){
        $type = "pluginBookingClients";
        $url_edit = "/admin/$type/$this->id/edit";

        $icon_editing = "";
        $link_editing = "<a class=\"dropdown-item\" href=\"$url_edit\">Modifica</a>";

        $access = route('access', $this->id);
        if($this->active == 1){
            $link_editing .= "<a class=\"dropdown-item\" href=\"$access\">Accedi</a>";
        }

        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$icon_editing.' Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    '.$link_editing.'
                    <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>
                  </div>
                </div>';


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

}
