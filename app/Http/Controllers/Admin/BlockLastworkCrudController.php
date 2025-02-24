<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockFlussoRequest;
use App\Http\Requests\BlockLastworkRequest;
use App\Models\BlockFlusso;
use App\Models\BlockLastwork;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockLastworkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockLastworkCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockLastwork";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockLastwork::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockLastwork');
        CRUD::setEntityNameStrings('Blocco Ultimi 6 progetti', 'Blocchi Ultimi 6 progetti');

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
        $this->crud->set('reorder.label', 'title');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("delete");
        $this->crud->removeButton("update");
        $this->crud->removeButton("show");

        // Columns.
        $this->crud->setColumns([

            /* Qui dichiaro quali input voglio vedere nella tabella, quando clicco su lista per aggiungere o modificare i record del blocco */

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
        CRUD::setValidation(BlockLastworkRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona stile",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Versione 1', 2 => 'Versione 2'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([
                // CustomHTML
                'name'  => 'separator',
                'type'  => 'custom_html',
                'value' => '<hr>'
            ]);


            // provo a mettere qui questi input in modo da levarli dalla parte multilingua che cicla

            $this->crud->addField([   // repeatable
                'name'  => 'color_subtitle',
                'label' => 'Colore Titoletto',
                'type'  => 'color_picker',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titolo',
                'type'  => 'color_picker',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bg_color',
                'label' => 'Colore sfondo box sinistra',
                'type'  => 'color_picker',
                'default' => '#fefefe',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel AdminLanguageController */

            $this->crud->addField([   // Browse
                'name'  => 'foto_1',
                'label' => 'Foto Progetto 1 (Dimensione immagini consigliate 800x600 px)',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_2',
                'label' => 'Foto Progetto 2',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_3',
                'label' => 'Foto Progetto 3',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_4',
                'label' => 'Foto Progetto 4 ',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_5',
                'label' => 'Foto Progetto 5',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_6',
                'label' => 'Foto Progetto 6 ',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_1',
                'label'       => "Apertura link progetto 1",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_2',
                'label'       => "Apertura link progetto 2",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_3',
                'label'       => "Apertura link progetto 3",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_4',
                'label'       => "Apertura link progetto 4",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_5',
                'label'       => "Apertura link progetto 5",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_6',
                'label'       => "Apertura link progetto 6",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
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
        }

        if($request->has('style')){
            $this->crud->entry->style = $request->get('style');
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
        $lft = BlockLastwork::orderBy("lft", "asc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft + 2;
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
