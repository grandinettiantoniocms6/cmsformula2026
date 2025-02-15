<?php
$days = config('config.days');
?>

<div class="row align-items-center mt-4 mb-2">
    <h2 class="col mb-0">Orari</h2>
    <div class="col-auto">
        <button class="btn btn-success btn-sm" type="button" onclick="add_day()">Aggiungi Giorno</button>
    </div>
</div>
<div id="box_days" class="row">
    @if($timetables_days)
        @foreach($timetables_days as $timetable)
            <?php
            $orari = \App\Models\PluginTimetablesDay::where("plugin_timetable_id",  $id)
                ->where("day", $timetable->day)
                ->get();
            ?>
            <div class="col-sm-6 px-2 mb-4" id="box-{{ $timetable->day }}">
                <div class="card-header border bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <select class="custom-select" name="days[]" id="day_select_{{ $timetable->day }}">
                                @foreach($days as $k=>$v)
                                    <option value="{{ $k }}" @if($k==$timetable->day) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto px-1">
                            <button class="btn-danger btn btn-sm" type="button" onclick="delete_day({{ $timetable->day }})">Elimina Giorno</button>
                        </div>
                        <div class="col-auto px-1">
                            <button class="btn btn-info btn-sm" type="button" onclick="add_time({{ $timetable->day }})"><span>Aggiungi Orario</span></button>
                        </div>
                    </div>
                </div>
                <div id="timetable_{{ $timetable->day }}">
                    @if($orari)
                        @foreach($orari as $o)
                            <div class="card p-2 my-1" id="time_{{ $o->id }}">
                                <table class="table-sm">
                                    <tr>
                                        <td class="align-middle font-weight-bold" width="100">Orario</td>
                                        <td class="align-middle"><input type="text" class="form-control" name="time_title[{{ $timetable->day }}][]" placeholder="Orario" value="{{ $o->title }}"></td>
                                        <td class="align-middle" width="170">
                                            <select name="time_is_special[{{ $timetable->day }}][]" class="custom-select">
                                                @if($o->is_special == 1)
                                                    <option value="0">Orario normale</option>
                                                    <option value="1" selected>Orario speciale</option>
                                                @else
                                                    <option value="0" selected>Orario normale</option>
                                                    <option value="1">Orario speciale</option>
                                                @endif
                                            </select>
                                        </td>
                                        <td class="align-middle" width="50"><button class="btn btn-sm btn-danger" type="button" onclick="delete_time({{ $o->id }})"><i class="la la-trash la-lg"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td class="align-top font-weight-bold" width="100">Descrizione</td>
                                        <td class="align-middle" colspan="3">
                                            <textarea class="form-control summernote" name="time_description[{{ $timetable->day }}][]" placeholder="Descrizione" id="editor_{{ $o->id }}">{{ $o->description }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
