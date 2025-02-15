<?php
namespace App\Exports;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderExport implements FromView, WithTitle
{
    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function view(): View
    {
        setlocale(LC_TIME, 'it', 'it_IT', 'italian');
        Carbon::setLocale('it');

        $details = OrderProduct::where("order_id", $this->order->id)->get();

        return view('exports.order', [
            'order' => $this->order,
            'details' => $details
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Dettaglio ordine';
    }

    public function columnFormats(): array
    {
        return [
            //  'G' => \NumberFormatter::FORMAT_NUMBER_00
        ];
    }


}
