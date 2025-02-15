<?php
namespace App\Exports;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PluginCacciaExport implements FromView, WithTitle
{
    public $sql;
    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    public function view(): View
    {
        setlocale(LC_TIME, 'it', 'it_IT', 'italian');
        Carbon::setLocale('it');

        $list = \DB::select($this->sql);

        return view('exports.pluginCaccia', [
            'list' => $list,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Graduatoria';
    }

    public function columnFormats(): array
    {
        return [
            //  'G' => \NumberFormatter::FORMAT_NUMBER_00
        ];
    }


}
