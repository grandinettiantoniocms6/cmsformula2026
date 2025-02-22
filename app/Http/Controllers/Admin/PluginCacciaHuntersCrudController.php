<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PluginCacciaExport;
use App\Http\Requests\PluginCacciaHuntersRequest;
use App\Models\PluginCacciaHunters;
use App\Models\PluginCacciaHuntersChiefs;
use App\Models\PluginCacciaHuntersPoints;
use App\Models\PluginCacciaSettings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PluginCacciaHuntersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginCacciaHuntersCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginCacciaHunters::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-caccia-hunters');
        CRUD::setEntityNameStrings('cacciatore', 'cacciatori');

        $this->crud->setListView('vendor.backpack.base.plugins.pluginCaccia.list');
        $this->crud->setEditView('vendor.backpack.base.plugins.pluginCaccia.edit');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("show");

        // Columns.
        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'id',
                'label' => '<input type="checkbox" id="select_all"/>', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCheck', // the method in your Model
                'limit' => 1000,
                'orderable' => false
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            ],
            [
                'name'  => 'code',
                'label' => 'Codice',
                'type'  => 'text',
            ],
            [
                'name'  => 'first_name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => 'Cognome',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'points',
                'label' => 'Punti', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getPoints', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'chiefs',
                'label' => 'Capi', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getChiefs', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
        ]);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginCacciaHuntersRequest::class);

        $this->crud->addField([   // select2_from_array
            'name'        => 'code',
            'label'       => "Codice",
            'type'        => 'text',
            "attributes" => ["disabled" => "disabled"],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-1'
            ],
            "tab" => "Dati"
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'first_name',
            'label'       => "Nome",
            'type'        => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            "tab" => "Dati"
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'last_name',
            'label'       => "Cognome",
            'type'        => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            "tab" => "Dati"
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'note',
            'label'       => "Note",
            'type'        => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            "tab" => "Dati"
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'note',
            'label'       => "Note",
            'type'        => 'ckeditor',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            "tab" => "Dati"
        ]);

        $id = null;
        $parameters = \Route::current()->parameters(); //se sono in modifica
        if(count($parameters) > 0){
            $points = PluginCacciaHuntersPoints::where("hunter_id",  $parameters['id'])->orderBy("id", "desc")->get();
            $chiefs = PluginCacciaHuntersChiefs::where("hunter_id",  $parameters['id'])->orderBy("id", "desc")->get();

            $id = $parameters['id'];

            $this->crud->addField([   // CustomHTML
                'name' => 'separator_points',
                'type' => 'custom_html',
                'value' => view(backpack_view('plugins.pluginCaccia.history_points'), compact('points', 'id'))->render(),
                'tab' => 'Cronologia Punti',
            ]);

            $this->crud->addField([   // CustomHTML
                'name' => 'separator_chiefs',
                'type' => 'custom_html',
                'value' => view(backpack_view('plugins.pluginCaccia.history_chiefs'), compact('chiefs', 'id'))->render(),
                'tab' => 'Cronologia Capi',
            ]);
        }



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function graduatoria(Request $request){
        $button = $request->get('button');
        if($button == "export"){
            $sql = $request->get('sql');

            return \Excel::download(new PluginCacciaExport($sql), "Graduatoria.xlsx");
        }

        $year = Carbon::now()->format("Y");
        if($request->has('year')){
            $year = $request->get('year');
        }


        $list = PluginCacciaHuntersPoints::selectRaw("SUM(point) as tot, hunter_id")
            ->whereRaw("(created_at >= '$year-01-01 00:00:00' AND created_at <= '$year-12-31 23:59:59')")
            ->groupBy("hunter_id")
            ->orderBy("tot", "desc")
            ->get();

        $sql = PluginCacciaHuntersPoints::selectRaw("SUM(point) as tot, hunter_id")
            ->whereRaw("(created_at >= '$year-01-01 00:00:00' AND created_at <= '$year-12-31 23:59:59')")
            ->groupBy("hunter_id")
            ->orderBy("tot", "desc")
            ->toSql();

        return view("vendor.backpack.base.plugins.pluginCaccia.graduatoria", compact('list', 'year', 'sql'));
    }

    public function import(){
        return view(backpack_view("plugins.pluginCaccia.import"));
    }

    public function import_save(Request $req){
        $req->validate([
            'file' => 'required|max:20480'
        ]);

        if($req->file()) {
            $temp = explode("." , $req->file->getClientOriginalName());
            $fileName = "import.$temp[1]";
            $req->file('file')->storeAs('/', $fileName, 'public_plugin_caccia');

            $file = url("/plugins/pluginCaccia/import.csv");
            $row = 1;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                    foreach ($data as $item){
                        $temp = explode(",", $item);

                        $check = PluginCacciaHunters::where("first_name", trim($temp[0]))
                            ->where("last_name", trim($temp[1]))->first();

                        if(!$check){
                            $hunter = PluginCacciaHunters::create([
                                "first_name" => trim($temp[0]),
                                "last_name" => trim($temp[1])
                            ]);

                            $number = 1000 + $hunter->id;
                            $hunter->code = $number;
                            $hunter->save();
                        }
                    }
                    $row++;
                }
            }

            return back()
                ->with('success','File caricato con successo')
                ->with('file', $fileName);
        }
    }


    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $number = 1000 + $item->id;
        $item->code = $number;
        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function actions(Request $request){
        $button = $request->get('button');
        $ids = $request->get('ids');
        if($ids == null){
            return redirect()->back();
        }

        $ok = [];
        $ko = [];
        $setting = PluginCacciaSettings::first();

        switch ($button){
            case "delete":
                PluginCacciaHunters::withTrashed()->whereIn("id", $ids)->update([
                    "deleted_at" => Carbon::now()->toDateTimeString()
                ]);

                \Alert::success("Operazione effettuata con successo!")->flash();
                break;
            case "points":
                $chief_id = $request->get('chief_id');
                $type = $request->get('type');
                $note = $request->get('note');
                $point = $request->get('point');

                foreach ($ids as $id){
                    PluginCacciaHuntersPoints::insert([
                        "hunter_id" => $id,
                        "chief_id" => $chief_id,
                        "user_id" => backpack_user()->id,
                        "point" => ($type == 1) ? $point : -$point,
                        "note" => $note,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
                break;

            case "chiefs":
                $chief_id = $request->get('chief_id');
                $status = $request->get('status');
                $date = $request->get('date');



                foreach ($ids as $id){
                    $hunter = PluginCacciaHunters::find($id);

                    $point = $hunter->points()->sum("point");

                    if($point < $setting->min_points){
                        $ko[] = $id;
                        continue;
                    }

                    PluginCacciaHuntersChiefs::insert([
                        "hunter_id" => $id,
                        "chief_id" => $chief_id,
                        "user_id" => backpack_user()->id,
                        "date_associate" => $date,
                        "status_id" => $status,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);

                    $ok[] = $id;
                }

                break;
        }

        return redirect()->back()->withInput(array('ok' => $ok, 'ko' => $ko));
    }


}
