<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginBookingReservation extends Model
{
    use CrudTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'plugins_booking_reservations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id', 'rooms','send_status'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getUser(){
        $modal = '<div class="modal fade" id="exampleModalNote_'.$this->id.'">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel_'.$this->id.'">Contatti '.$this->user->name.'</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            '.$this->user->email.'
                            <br>
                             '.$this->user->mobile.'
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                          </div>
                        </div>
                      </div>
                    </div>';

        $data_created = Carbon::createFromFormat("Y-m-d H:i:s", $this->created_at)->format("d/m/Y");

        return '<a href="#" data-toggle="modal" data-target="#exampleModalNote_'.$this->id.'">'.$this->user->name.'</a>'.$modal.' <br><small>'.$data_created.'</small>';
    }

    public function getIsProcessed(){
        if($this->is_processed == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_reservations', $this->id, "is_processed", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_reservations',$this->id, "is_processed", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getRooms()
    {
        return \Cache::remember("reservation-rooms-html-{$this->id}", 300, function () {
            $html = '';

            foreach ($this->rooms as $roomRel) {
                $room = $roomRel->room;
                if ($room) {
                    $html .= "<span class='badge badge-light'>{$room->name}</span><br>";
                    $html .= "<span class='badge badge-warning'>{$room->sku}</span><br>";
                }
            }

            return $html ?: '-';
        });
    }

    public function getPayment(){
        if($this->payment)
             return "<small>{$this->payment->name}</small>";
    }

    public function getDateStartEnd(){
        $start = Carbon::createFromFormat("Y-m-d", $this->date_start)->format("d/m/Y");
        $end = Carbon::createFromFormat("Y-m-d", $this->date_end)->format("d/m/Y");

        if($start != $end){
            $label = "Dal <em>$start</em><br> al <em>$end</em>";
        }else{
            $label = "Il <em>$start</em>";
        }

        if($this->start_time && $this->end_time){
            $start_time = Carbon::createFromFormat("H:i:s", $this->start_time)->format("H:i");
            $end_time = Carbon::createFromFormat("H:i:s", $this->end_time)->format("H:i");

            $label .= "<br>ore $start_time-$end_time";
        }

        return "$label";
    }


    public function getIsPayed(){
        if($this->is_payed == 1){
            $url = route('dashboard.set.field.boolean', ['plugins_booking_reservations', $this->id, "is_payed", 0]);
            return "<a href='$url' class='text text-success'><i class=\"las la-eye\"></i></a>";
        }else{
            $url = route('dashboard.set.field.boolean', ['plugins_booking_reservations',$this->id, "is_payed", 1]);
            return "<a href='$url' class='text text-danger'><i class=\"las la-eye\"></i></a>";
        }
    }

    public function getStatus(){
        if($this->status){
            if($this->status->class){
                return "<span class='badge {$this->status->class}'>{$this->status->name}</span>";
            }
            return $this->status->name;
        }
    }

    public function numberPartecipant(){
        $html = "Adulti $this->total_qty";
        if($this->total_qty_bimbi){
            $html .= "<br>Bimbi $this->total_qty_bimbi";
        }
        return "<small>$html</small>";
    }

    public function getType(){
        if($this->type){
            return $this->type->name;
        }
    }

    public function checkDocument()
    {
        return \Cache::remember("reservation-checkdocs-{$this->id}", 300, function () {
            $missing = PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $this->id)
                ->whereNull("document_file")
                ->count();

            $total = PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $this->id)
                ->count();

            if ($total === 0) return '-';

            if ($missing > 0) {
                return "<span class='badge badge-danger'>Mancano $missing documenti</span>";
            }

            return "<span class='badge badge-success'>OK</span>";
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(PluginBookingStatus::class, "plugin_booking_status_id");
    }

    public function payment(){
        return $this->belongsTo(PluginBookingPayments::class, "plugin_booking_payment_id");
    }

    public function rooms()
    {
        return $this->hasMany(PluginBookingReservationRoom::class)->with('room');
    }

    public function type(){
        return $this->belongsTo(PluginBookingType::class, "type_id");
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
