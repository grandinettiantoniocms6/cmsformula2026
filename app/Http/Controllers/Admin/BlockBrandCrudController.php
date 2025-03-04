<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockBrandRequest;
use App\Models\BlockBrand;
use App\Models\BlockFlusso;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockBrandCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockBrandCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockBrand";

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockBrand::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockBrand');
        CRUD::setEntityNameStrings('Blocco Brand', 'Blocchi Brands');

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
        $this->crud->set('reorder.label', 'foto');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
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
            // Nuovo modo di chiamare le foto + funzione Thumb
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'foto',
                'label' => 'Foto', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'get_foto_mini', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'title',
                'label' => 'Nome',
                'type'  => 'text',
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
        CRUD::setValidation(BlockBrandRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([
                'name'  => 'name',
                'label' => 'Nome blocco (uso interno)',
                'type'  => 'text',
            ]);

            $this->crud->addField([
                'name'  => 'title_it',
                'label' => 'Titolo (Lato Front)',
                'type'  => 'text',
            ]);

            $this->crud->addField([
                'name'  => 'txtcolor',
                'label' => 'Colore Titolo',
                'type'  => 'color_picker',
                // optional
                //'default' => '#1ab42f',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([
                'name'        => 'title_align',
                'label'   => 'Allineamento Titolo',
                'type'        => 'select_from_array',
                'options'     => ['center' => 'Centrato', 'left' => 'Sinistra', 'right' => 'Destra'],
                'allows_null' => false,
                'default'     => 'center',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([
                'name'        => 'col',
                'label'   => 'Seleziona Brand per riga (valido solo per Style Griglia)',
                'type'        => 'select_from_array',
                'options'     => ['12' => '1 per riga', '6' => '2 x riga', '4' => '3 x riga', '3' => '4 x riga', '2' => '6 x riga'],
                'allows_null' => false,
                'default'     => '3',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Griglia senza bordo', 2 => 'Griglia con bordo', 3 => 'Carosello', 4 => 'Senza usare il sistema Thumb'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel AdminLanguageController */

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto .png o .jpg (Dimensioni  consigliate: 200x90px)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link pulsante",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);


            /* FINE degli input che vedo quando aggiungo le righe al blocco multilingua */


            $trans = new AdminLanguageController();
            $trans->fields_lang($this->block, $this->crud);

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

    /** questa è la funzione per il salvataggio */
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

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->txtcolor = $request->get('txtcolor');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->title_align = $request->get('title_align');
            $this->crud->entry->title_it = $request->get('title_it');

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

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        // Questo serve per evitare di fare il riordina ad ogni nuovo record aggiunto
        $lft = BlockBrand::orderBy("lft", "asc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft + 2;
        }

        $this->crud->entry->save();

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
