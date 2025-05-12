<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginTutorialRequest;
use App\Models\PluginTutorial;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginTutorialCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginTutorialCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginTutorial::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginTutorial');
        CRUD::setEntityNameStrings('video', 'video');

        $this->crud->query->orderBy("lft", "asc");

        $this->crud->isReorderEnabled();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'title');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        if(backpack_user()->roles[0]->id >= 2){
            $this->crud->removeButton("create");
            $this->crud->removeButton("update");
            $this->crud->removeButton("delete");
            $this->crud->removeButton("reorder");
        }

        $this->crud->removeButton("show");

        $this->crud->setColumns([
            [
                'name'  => 'title',
                'label' => 'Titolo',
                'type'  => 'text',
                'limit' => 10000
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'url',
                'label' => 'Url', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getUrl', // the method in your Model
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
        if(backpack_user()->roles[0]->id > 1){
            die;
        }
        CRUD::setValidation(PluginTutorialRequest::class);

        $this->crud->addField([   // Checkbox
            'name'  => 'title',
            'label' => 'Titolo',
            'type'  => 'text'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'description',
            'label' => 'Descrizione',
            'type'  => 'ckeditor'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'url',
            'label' => 'Link url youtube',
            'type'  => 'text'
        ]);


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
        if(backpack_user()->roles[0]->id > 1){
            die;
        }
        $this->setupCreateOperation();
    }

    public function view(Request $request){
        $tutorials = PluginTutorial::orderBy("lft", "asc")->get();
        return view(backpack_view('plugins.pluginTutorials.index'), compact('tutorials'));
    }

    public function saveReorder()
    {
        $this->crud->hasAccessOrFail('reorder');

        $all_entries = \Request::input('tree');

        if(!is_array($all_entries)){
            $all_entries = json_decode($all_entries, true);
        }

        if (count($all_entries)) {
            $count = $this->crud->updateTreeOrder($all_entries);
        } else {
            return false;
        }

        return 'success for '.$count.' items';
    }
}
