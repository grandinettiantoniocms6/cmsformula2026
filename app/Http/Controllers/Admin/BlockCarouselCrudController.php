<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockCarouselRequest;
use App\Models\BlockCarousel;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockCarouselCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockCarouselCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockCarousel";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockCarousel::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockCarousel');
        CRUD::setEntityNameStrings('carosello', 'caroselli');

        $this->crud->setListView(backpack_view('custom_list_multi'));
        $this->crud->setReorderView(backpack_view('custom_reorder_multi'));
        $this->crud->setCreateView(backpack_view('custom_create_multi_enhanced'));

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

        /* Qui dichiaro quali input voglio vedere nella tabella, quando clicco su lista per aggiungere o modificare i record del blocco */
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
        CRUD::setValidation(BlockCarouselRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

            $this->crud->addField([
                'name'  => 'pc',
                'label' => 'Digita il numero di elementi da visualizzare per riga da schermo PC.
                           <br>Esempio: 4',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'notebook',
                'label' => 'Digita il numero di elementi da visualizzare per riga da schermo Notebook.
                           <br>Esempio: 3',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'tablet',
                'label' => 'Digita il numero di elementi da visualizzare per riga da Tablet.
                           <br>Esempio: 2',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'smartphone',
                'label' => 'Digita il numero di elementi da visualizzare per riga da Smartphone.
                           <br>Esempio: 1',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'options' => [
                        1 => 'Style 1: Carosello: classico con Immagine e testo',
                        2 => 'Style 2: Recensioni: Effetto carosello con Titolo, sfondo colorato e testo',
                        3 => 'Style 3: Primi Piani con foto, titolo testo e bordino grigio',
                        4 => 'Style 4: Semplice: in verticale con lista immagini (no thumb) + link',

                    ],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // repeatable
                    'name' => 'color_title',
                    'label' => 'Colore Titoli',
                    'type' => 'color_picker2',
                    // optional
                    'default' => null,
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // repeatable
                    'name' => 'height',
                    'label' => 'Altezza div contenitore: Imposta un valore numerico (Es: 35 - misura espressa in rem - 1 rem = 16pixel )',
                    'type' => 'text',
                    'wrapper' => ['class' => 'form-group col-md-12']
                ]);

            }
            // FINE CAMPI VISUALIZZATI TEMA WEBSHOP//////////////////

            $this->crud->addField([   // select_from_array
                'name' => 'style',
                'label' => "Seleziona stile",
                'type' => 'select_from_array',
                'options' => [
                    1 => 'Style 1',
                    2 => 'Style 2',
                    3 => 'Style 3',
                    4 => 'Style 4',
                    5 => 'Style 5',

                ],
                'allows_null' => false,
                'default' => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);





            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */


        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel AdminLanguageController */

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo Box',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
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
            // solo name se non ho aggiunto campi aggiuntivi al blocco
            $this->crud->entry->name = $request->get('name');
            // qui eventuali input aggiuntivi
            $this->crud->entry->pc = $request->get('pc');
            $this->crud->entry->notebook = $request->get('notebook');
            $this->crud->entry->tablet = $request->get('tablet');
            $this->crud->entry->smartphone = $request->get('smartphone');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->color_title = $request->get('color_title');
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

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        // Se metto desc ogni nuovo record aggiunto va all'inizio
        $lft = BlockCarousel::whereNotNull("block_id")
            ->where("id", "!=", $this->crud->entry->id)
            ->orderBy("lft", "asc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft - 1;
        }else{
            $this->crud->entry->lft = 1000;
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

        $list = BlockCarousel::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}

