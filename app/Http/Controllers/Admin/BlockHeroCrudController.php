<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockHeroRequest;
use App\Http\Requests\BlockMetroRequest;
use App\Models\BlockHero;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockHeroCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockHeroCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockHero";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockHero::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockHero');
        CRUD::setEntityNameStrings('Blocco Hero', 'Blocchi Hero');

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
        // define which model attribute will be shown on draggable elements se uso title mette solo scritta
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
                'name'  => 'sfondo',
                'label' => 'Sfondo', // Table column heading
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
        CRUD::setValidation(BlockHeroRequest::class);

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],

            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona stile",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Style 1 (immagine a destra)', 2 => 'Style 2 (immagine a sinistra)', 'Style 3 (immagine al centro testi sotto)'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);


            $this->crud->addField([   // repeatable
                'name'  => 'height',
                'label' => 'Altezza blocco Hero in pixel (es: 350px scrivere numero e sigla px)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'alpha',
                'label' => 'Filigrana (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

        }else{

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore di sfondo',
                'type'  => 'color_picker',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'sfondo',
                'label' => 'Immagine di sfondo (Per PC)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_mobile_1',
                'label' => 'Immagine di sfondo (Per SmartPhone)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine 2 (se lo stile la prevede)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_mobile_2',
                'label' => 'Immagine Mobile 2 (Per SmartPhone)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore del Titolo',
                'type'  => 'color_picker',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class']
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

            /*$this->crud->addField([   // color_picker
                'label'                => 'Background Color',
                'name'                 => 'background_color',
                'type'                 => 'color_picker',
                'default'              => '#000000',

                // optional
                'color_picker_options' => ['customClass' => 'custom-class']
            ]);*/

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
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->height = $request->get('height');
            $this->crud->entry->alpha = $request->get('alpha');

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
        $lft = BlockHero::orderBy("lft", "desc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft + 2;
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
