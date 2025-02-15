<?php

$timetable = \App\Models\PluginTimetables::find($item->plugin_timetable_id);
if ($timetable){
    $timetables_days = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
        ->groupBy("day")
        ->get();
}
?>
@if($timetable)
<section class="block-timetable" id="block-timetable-{{ $item->id }}">
    <div class="container">
        @if($timetable->foto)
            <div class="mb-4 text-center">
                <img src="{{ url($timetable->foto) }}" class="foto img-fluid" loading="lazy">
            </div>
        @endif
        <div class="row align-items-center">
            @if($timetable->logo)
            <div class="col-md-auto text-center mb-4">
                <img src="{{ url($timetable->logo) }}" width="auto" class="logo" loading="lazy">
            </div>
            @endif
            <div class="col-md text-center mb-4 @if(!$timetable->logo) text-md-end @endif">
                <h3 class="title">{{ $timetable->title }}</h3>
                <div class="description">{{ $timetable->abstract }}</div>
            </div>
        </div>

        @if($timetables_days)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3">
                @foreach($timetables_days as $t)
                    <?php
                    $orari = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
                        ->where("day", $t->day)
                        ->where("is_special", "!=", 1)
                        ->get();

                    $orari_special = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $timetable->id)
                        ->where("day", $t->day)
                        ->where("is_special", "=", 1)
                        ->get();
                    ?>
                    <?php if($t->day < 6): ?>
                        <div class="col mb-3">
                            <div class="card">
                                <div class="card-header">
                                    @if(key_exists($t->day, config("config.days")))
                                        <span>{{ config("config.days")[$t->day] }}</span>
                                    @endif
                                </div>
                                @if($orari)
                                    <div class="card-body px-0">
                                        <table class="table table-sm table-borderless table-hover my-0">
                                            @foreach($orari as $o)
                                                <tr>
                                                    <td class="align-top" width="130">{{ $o->title }}</td>
                                                    <td class="align-top">{!! $o->description !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                                @if($orari_special)
                                    @if(count($orari_special) > 0)
                                    <div class="card-footer p-0">
                                        <table class="table table-sm table-borderless table-hover my-0">
                                            @foreach($orari_special as $o)
                                                <tr>
                                                    <td class="align-top" width="130">{{ $o->title }}</td>
                                                    <td class="align-top">{!! $o->description !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    @endif
                                @endif
                             </div>
                        </div>
                    <?php else: ?>
                        <?php if($t->day == 6): ?>
                            <div class="col mb-3">
                        <?php endif; ?>
                            <div class="card h-auto style_1">
                                <div class="card-header">
                                    @if(key_exists($t->day, config("config.days")))
                                        <span>{{ config("config.days")[$t->day] }}</span>
                                    @endif
                                </div>
                                @if($orari)
                                    <div class="card-body px-0">
                                        <table class="table table-sm table-borderless table-hover my-0">
                                            @foreach($orari as $o)
                                                <tr>
                                                    <td class="align-middle" width="130">{{ $o->title }}</td>
                                                    <td class="align-middle">{!! $o->description !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                                @if($orari_special)
                                    @if(count($orari_special) > 0)
                                        <div class="card-footer p-0">
                                            <table class="table table-sm table-borderless table-hover my-0">
                                                @foreach($orari_special as $o)
                                                    <tr>
                                                        <td class="align-middle" width="130">{{ $o->title }}</td>
                                                        <td class="align-middle">{!! $o->description !!}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        <?php if($t->day == 7): ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                @endforeach
            </div>

            @if($item->download_pdf)
                <div class="text-center my-3">
                    <a href="{{ route('pluginTimetables.pdf', $timetable->id) }}" class="btn btn-primary btn-lg">Scarica orari</a>
                </div>
            @endif
        @endif
    </div>
</section>
@endif

