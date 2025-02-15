<?php
namespace App\Exports;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PluginInterventionsMonitorExport implements FromView, WithTitle, WithColumnFormatting
{
    public $reservations;
    public $date;

    public function __construct($reservations,  $date)
    {
        $this->reservations = $reservations;
        $this->date = $date;
    }

    public function view(): View
    {
        setlocale(LC_TIME, 'it', 'it_IT', 'italian');
        Carbon::setLocale('it');

        return view('exports.pluginInterventionsMonitor', [
            'reservations' => $this->reservations,
            'date' => $this->date,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Panoramica';
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
           //  'B' => \NumberFormatter::FORMAT_WIDTH
        ];
    }


}
