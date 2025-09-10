<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shop_orders';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'status_id',
        'comment',
        'invoice_date',
        'delivery_date',
        'shipping_address',
        'shipping_address_id',
        'billing_company_id',
        'shipping_id',
        'payment_id',
        'currency_id',
        'user_id',
        'billing_address',
        'total_discount',
        'total_discount_tax',
        'total_shipping',
        'total_shipping_tax',
        'total',
        'total_tax',
        'code_referral',
        'code_coupon',
        'cart_rule_id',
        'paypal_payment_id',
        'number_invoice',
        'year_invoice',
        'payment_date',
        'tracking_code',
        'template_tracking_id',
        'type_order',
        'is_express_checkout',
        'total_extra',
        'total_coupon',
        'total_giftcard',
        'number_giftcard'
    ];
    // protected $hidden = [];
    // protected $dates = [];


    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS VARIABLES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function get_status(){
        if($this->status){
            return  "<span class='badge badge-{$this->status->className}'>{$this->status->name}</span>";
        }
    }

    public function get_user(){
        if($this->user_id){
            $user = User::find($this->user_id);
            if($user){
                if($user->user_id){
                    $userBuyer = User::find($user->user_id);
                    if($userBuyer){
                        return $userBuyer->name;
                    }
                }
            }
        }
    }

    public function get_total(){
        $sum = OrderProduct::selectRaw("SUM(price_with_tax * quantity) as tot")->where("order_id", $this->id)->first();
        $total = ($this->total_tax - $this->total_coupon);

        if($sum){
            if($this->total_tax != round($sum->tot,2)){
                return "<span class='text text-danger'>".number_format($total, 2, ",", ".")."</span>";
            }
        }
        return "".number_format($total, 2, ",", "."). ' '.$this->currency->name;
    }

    public function get_payment(){
        $code = "";
        if($this->code_referral){
            $code = "<br><strong>Codice:</strong> <em>{$this->code_referral}</em>";
        }

        $code_coupon = "";
        if($this->code_coupon){
            $code_coupon = "<br><strong>Coupon:</strong> <em>{$this->code_coupon}</em>";
        }

        if($this->payment){
            return  "<span>{$this->payment->name} {$code} {$code_coupon}</span>";
        }
    }

    public function view_order(){
        return '<a href="/admin/shopOrders/'.$this->id.'/show" class="btn btn-sm btn-link"><i class="la la-edit"></i> Modifica</a>';
    }

    public function total_products()
    {
        return decimalFormat($this->products->sum(function ($product) {
            return $product->pivot->price_with_tax * $product->pivot->quantity;
        }, 0));
    }

    public function getMenu(){
        $type = "shopOrders";

        $buttonRemove = '';
        if(backpack_user()->roles[0]->id <= 3){
            $buttonRemove = '<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="/admin/'.$type.'/'.$this->id.'" class="dropdown-item" data-button-type="delete">Elimina</a>';
        }

        $orderXls = "";
        if(env('PROJECT_NAME') == "Maison-Flaneur"){
            $orderXls = '<a href="/admin/'.$type.'/printExcel/'.$this->id.'" class="dropdown-item" data-toggle="tooltip" data-original-title="Stampa XLS" target="_blank">Stampa XLS</a>';
        }


        $html = '<div class="dropdown">
                  <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestione
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="/admin/shopOrders/'.$this->id.'/show" class="dropdown-item" data-toggle="tooltip" data-original-title="Visualizza">Visualizza</a>
                    <a href="/admin/'.$type.'/printPDF/'.$this->id.'" class="dropdown-item" data-toggle="tooltip" data-original-title="Stampa PDF" target="_blank">Stampa PDF</a>
                    <a href="/admin/'.$type.'/printPDF/'.$this->id.'?no-price" class="dropdown-item" data-toggle="tooltip" data-original-title="Stampa No prezzi" target="_blank">Stampa No Prezzi</a>
                    '.$orderXls.'
                    '.$buttonRemove.'
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
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status_id');
    }

    public function statusHistory()
    {
        return $this->hasMany('App\Models\OrderStatusHistory')->orderBy('created_at', 'DESC');
    }

    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping', 'id', 'shipping_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'id','payment_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne('App\Models\Address', 'id', 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->hasOne('App\Models\Address', 'id', 'billing_address_id');
    }

    public function billingCompanyInfo()
    {
        return $this->hasOne('App\Models\Company', 'id', 'billing_company_id');
    }

    public function currency()
    {
        return $this->hasOne('App\Models\Currency', 'id', 'currency_id');
    }

    public function products()
    {
        return $this->belongsToMany(PluginProducts::class, "shop_order_product", "order_id", "product_id")->withPivot(['name', 'sku', 'price', 'price_with_tax',  'quantity','custom_label_1', 'custom_label_2','file','message','services', 'price_unit', 'price_add']);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
