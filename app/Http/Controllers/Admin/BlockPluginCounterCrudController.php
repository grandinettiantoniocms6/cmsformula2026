<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPluginCounterRequest;
use App\Models\PluginCounter;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPluginCounterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPluginCounterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockPluginCounter";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockPluginCounter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPluginCounter');
        CRUD::setEntityNameStrings('contatore plugin', 'contatore plugin');

        $this->crud->setListView(backpack_view('custom_list_multi'));
        $this->crud->setReorderView(backpack_view('custom_reorder_multi'));
        $this->crud->setCreateView(backpack_view('custom_create_multi'));

        if(request()->has('block_id')){
            $this->crud->query->where("block_id", request()->get('block_id'));
        }

        $this->crud->query->orderBy("lft", "asc");

        $this->crud->isReorderEnabled();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'plugin_counter_id');
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
        $this->crud->removeButton("delete");
        $this->crud->removeButton("update");
        $this->crud->removeButton("show");

        // Columns.
        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'plugin_counter_id',
                'label' => 'Contatore', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCounter', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_in_menu',
                'label' => 'Azioni', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getMenu', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ]
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
        CRUD::setValidation(BlockPluginCounterRequest::class);

        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-12'],
            ]);


            $this->crud->addField([   // Browse
                'name'  => 'bgimage',
                'label' => 'Seleziona immagine di sfondo',
                'type'  => 'browse',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
            ]);


            $this->crud->addField([   // repeatable
                'name'  => 'alpha',
                'label' => 'Filigrana immagine (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
                'type'  => 'number',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Oppure seleziona un colore di sfondo',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [ 'class' => 'form-group col-md-12'],
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona uno style",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class'       => 'custom-select',
                ],
                'options'     => [1 => 'Style 1: classico', 2 => 'Style 2: Da fare...'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Quanti Contatori vuoi visualizzare per riga?',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class'       => 'custom-select',
                ],
                'options'     => [12 => '1 per riga', 6 => '2 per riga', 4 => '3 per riga', 3 => '4 per riga'],
                'allows_null' => false,
                'default'     => 3,
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([
                'name'  => 'height',
                'label' => 'Altezza contenitore Contatore (Es: 500px)',
                'type'  => 'text',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-4']
            ]);



        }else{

            $counters = PluginCounter::get()->pluck("title", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'plugin_counter_id',
                'label'       => "Contatore",
                'type'        => 'select2_from_array',
                'options'     => $counters,
                'allows_null' => false,
                'default'     => null,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            if(request()->has('block_id')){
                $this->crud->addField([   // repeatable
                    'name'  => 'block_id',
                    'value' => request()->get('block_id'),
                    'type'  => 'hidden',
                ]);
            }
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

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->bgimage = $request->get('bgimage');
            $this->crud->entry->alpha = $request->get('alpha');
            $this->crud->entry->bgcolor = $request->get('bgcolor');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->height = $request->get('height');


            $this->crud->entry->save();
        }


        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

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

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->save();
        }

        return $this->crud->performSaveAction($item->getKey());
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
