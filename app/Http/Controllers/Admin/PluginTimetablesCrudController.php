<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginTimetablesRequest;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginTimetables;
use App\Models\PluginTimetablesDay;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PluginTimetablesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginTimetablesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }


    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        // whatever you want

        $old = PluginTimetables::find($id);
        // if you still want to call the old clone method
        $this->traitClone($id);
        $new = PluginTimetables::orderBy("id", "desc")->first();
        $new->save();

        $list = \DB::table("plugins_timetables_days")
            ->where("plugin_timetable_id", $id)->get();
        if($list){
            foreach ($list as $item){
                PluginTimetablesDay::insert([
                    "plugin_timetable_id" => $new->id,
                    "day" => $item->day,
                    "title" => $item->title,
                    "description" => $item->description,
                    "is_special" => $item->is_special,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);
            }
        }
        //dd($old->id, $new->id);
    }


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginTimetables::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-timetables');
        CRUD::setEntityNameStrings('orario', 'orari');

        $this->crud->setEditView(backpack_view('plugins.pluginTimetable.edit'));

        if(backpack_user()->roles[0]->id >= 4){
            die;
        }
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
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
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
        CRUD::setValidation(PluginTimetablesRequest::class);

        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Nome',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'title',
            'label' => 'Titolo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'abstract',
            'label' => 'Sottotitolo',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);


        $this->crud->addField([   // Browse
            'name'  => 'logo',
            'label' => 'Logo',
            'type'  => 'browse',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'foto',
            'label' => 'Foto',
            'type'  => 'browse',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);


        $timetables_days = [];
        $id = null;
        $parameters = \Route::current()->parameters(); //se sono in modifica
        if(count($parameters) > 0){
            $timetables_days = PluginTimetablesDay::where("plugin_timetable_id",  $parameters['id'])
                ->groupBy("day")
                ->get();

            $id = $parameters['id'];

            $this->crud->addField([   // CustomHTML
                'name' => 'separator_days',
                'type' => 'custom_html',
                'value' => view(backpack_view('plugins.pluginTimetable.days'), compact('timetables_days', 'id'))->render(),
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

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->to("/admin/plugin-timetables/{$this->crud->entry->id}/edit");

        //return $this->crud->performSaveAction($item->getKey());
    }


    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $days = $request->get('days');
        $time_title = $request->get('time_title');
        $time_description = $request->get('time_description');
        $time_is_special = $request->get('time_is_special');

        PluginTimetablesDay::where("plugin_timetable_id", $item->id)->delete();

        if($days){
            if($time_title){
                foreach ($time_title as $k1=>$v1){
                    foreach ($v1 as $k2=>$value){
                        PluginTimetablesDay::insert([
                            "plugin_timetable_id" => $item->id,
                            "day" => $k1,
                            "title" => $value,
                            "description" => $time_description[$k1][$k2],
                            "is_special" => $time_is_special[$k1][$k2]
                        ]);
                    }
                }
            }
        }

        return $this->crud->performSaveAction($item->getKey());
    }
}
