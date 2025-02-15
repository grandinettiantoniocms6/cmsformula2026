<?php
namespace App\Exports;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PluginParkingMonitorExport implements FromView, WithTitle, WithColumnFormatting
{
    public $reservations_in;
    public $reservations_out;
    public $date;

    public function __construct($reservations_in, $reservations_out, $date)
    {
        $this->reservations_in = $reservations_in;
        $this->reservations_out = $reservations_out;
        $this->date = $date;
    }

    public function view(): View
    {
        setlocale(LC_TIME, 'it', 'it_IT', 'italian');
        Carbon::setLocale('it');

        return view('exports.pluginParkingMonitor', [
            'reservations_in' => $this->reservations_in,
            'reservations_out' => $this->reservations_out,
            'date' => $this->date,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Monitor';
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
           //  'B' => \NumberFormatter::FORMAT_WIDTH
        ];
    }


}
