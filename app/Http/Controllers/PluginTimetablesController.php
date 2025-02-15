<?php
namespace App\Http\Controllers;

use App\Models\BlockPluginTimetable;

class PluginTimetablesController extends Controller
{
    public function createPdf($id){
        $pdf = \App::make('snappy.pdf.wrapper');
        $thema = env('TEMA');

        $timetable = \App\Models\PluginTimetables::find($id);
        $timetables_days = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
            ->groupBy("day")
            ->get();


        $html = view("$thema.plugins.pluginTimetables.pdf", compact('timetable','timetables_days'))->render();
        $pdf->loadHTML($html)->setPaper('a4')->setOrientation('landscape');

        $footerHtml = "";
        $pdf->setOption('footer-html', $footerHtml );
        return $pdf->download("$timetable->name.pdf");
    }

}
