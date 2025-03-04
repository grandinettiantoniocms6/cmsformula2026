<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockPriceRequest;
use App\Models\BlockPrice;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockPriceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockPriceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockPrice";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockPrice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockPrice');
        CRUD::setEntityNameStrings('Blocco Price', 'Blocchi Prices');

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
        $this->crud->set('reorder.label', 'number');
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

            /* Qui dichiaro quali input voglio vedere nella tabella, quando clicco su lista per aggiungere o modificare i record del blocco */

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
        CRUD::setValidation(BlockPriceRequest::class);

        /* Qui ci vanno gli input ingranaggio no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'service_intro',
                'label' => 'Introduzione tabella prezzi',
                'type'  => 'ckeditor',
                'default' => '',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Quante colonne vuoi visualizzare?',
                'type'        => 'select_from_array',
                'options'     => ['3' => '4 x 1', '4' => '3 x 1', '6' => '2 x 1','12' => '1 x 1'],
                'allows_null' => false,
                'default'     => '3',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_border',
                'label' => 'Colore bordo div prezzi',
                'type'  => 'color_picker',
                // optional
                'default' => '#dbd7d7',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);


            /* FINE degli input ingranaggio no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel AdminLanguageController */

            $this->crud->addField([   // repeatable
                'name'  => 'price_1',
                'label' => 'Prezzo di listino (senza simbolo Euro - usa il punto al posto della virgola | Esempio: 155.60 )',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'price_2',
                'label' => 'Prezzo in Promo',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_price_1',
                'label' => 'Colore Prezzo di listino',
                'type'  => 'color_picker',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_price_2',
                'label' => 'Colore Prezzo in Promo',
                'type'  => 'color_picker',
                'default' => '#54950f',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine (esempio: il più venduto - da associare ad un solo record)',
                'type'  => 'browse',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_license_title',
                'label' => 'Colore Titolo Servizio',
                'type'  => 'color_picker',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_license_subtitle',
                'label' => 'Colore Sotto titolo Servizio',
                'type'  => 'color_picker',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bg_color',
                'label' => 'Colore sfondo prezzo',
                'type'  => 'color_picker',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ]
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

            $this->crud->addField([   // repeatable
                'name'  => 'listing',
                'label' => 'Lista: clicca su Aggiungi riga e inserisci le voci',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'Caratteristica',
                        'wrapper' => ['class' => 'form-group col-md-12'],
                    ],
                ],
                // optional
                'new_item_label'  => 'Aggiungi riga', // customize the text of the button
                'init_rows' => 0, // number of empty rows to be initialized, by default 1
                'min_rows' => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 15, // maximum rows allowed, when reached the "new item" button will be hidden
            ]);

            if(request()->has('block_id')){
                $this->crud->addField([   // repeatable
                    'name'  => 'block_id',
                    'value' => request()->get('block_id'),
                    'type'  => 'hidden',
                ]);
            }


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
            $this->crud->entry->color_border = $request->get('color_border');
            $this->crud->entry->service_intro = $request->get('service_intro');
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
        $lft = BlockPrice::orderBy("lft", "desc")->first();
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
