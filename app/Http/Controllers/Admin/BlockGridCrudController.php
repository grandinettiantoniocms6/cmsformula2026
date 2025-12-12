<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockGridRequest;
use App\Models\BlockGrid;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockGridCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockGridCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockGrid";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockGrid::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockGrid');
        CRUD::setEntityNameStrings('Blocco Griglia', 'Blocchi Griglia');

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
        CRUD::setValidation(BlockGridRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);


            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

                $this->crud->addField([   // repeatable
                    'name' => 'col',
                    'label' => 'Numero di colonne per riga',
                    'type' => 'select_from_array',
                    'options' => ['12' => '1 Colonna', '6' => '2 Colonne', '4' => '3 Colonne', '3' => '4 Colonne'],
                    'allows_null' => false,
                    'default' => '2',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'options' => [
                        1 => 'Style 1: Foto singola, Effetto Zoom',
                        2 => 'Style 2: Foto singola, Effetto Zoom + PDF',
                        3 => 'Style 3: Più Foto (max 10), Effetto Zoom',
                        4 => 'Style 4: No Thumb misure 600x900 Effetto Zoom',
                    ],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

            }

                            // CAMPI VISUALIZZATI SOLO CON IL TEMA CREFTO //////////////////
                            if(env('TEMA') == 'Crafto' ) {

                                $this->crud->addField([   // repeatable
                                    'name' => 'col',
                                    'label' => 'Numero di colonne per riga',
                                    'type' => 'select_from_array',
                                    'options' => ['1' => '1 Colonna', '2' => '2 Colonne', '3' => '3 Colonne', '4' => '4 Colonne'],
                                    'allows_null' => false,
                                    'default' => '2',
                                    'wrapper' => ['class' => 'form-group col-md-6']
                                ]);

                                $this->crud->addField([   // select_from_array
                                    'name' => 'style',
                                    'label' => "Seleziona stile",
                                    'type' => 'select_from_array',
                                    'options' =>
                                    [
                                        1 => 'Style 1',
                                        2 => 'Style 2',
                                        3 => 'Style 3',


                                    ],
                                    'allows_null' => false,
                                    'default' => 1,
                                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                                ]);

                            }

                            // CAMPI VISUALIZZATI SOLO CON IL TEMA CORPORATE1//////////////////
                            if(env('TEMA') == 'Corporate1' ) {

                                $this->crud->addField([   // repeatable
                                    'name' => 'col',
                                    'label' => 'Numero di colonne per riga',
                                    'type' => 'select_from_array',
                                    'options' => ['12' => '1 Colonna', '6' => '2 Colonne', '4' => '3 Colonne'],
                                    'allows_null' => false,
                                    'default' => '6',
                                    'wrapper' => ['class' => 'form-group col-md-6']
                                ]);

                                $this->crud->addField([   // select_from_array
                                    'name' => 'style',
                                    'label' => "Seleziona stile",
                                    'type' => 'select_from_array',
                                    'options' =>
                                        [
                                            1 => 'Style 1'


                                        ],
                                    'allows_null' => false,
                                    'default' => 1,
                                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                                ]);

                            }




            $this->crud->addField([   // repeatable
                'name'        => 'fullwidth',
                'label'   => 'Seleziona larghezza blocco',
                'type'        => 'select_from_array',
                'options'     => ['container' => 'Normale', 'container-fluid' => 'Full Width'],
                'allows_null' => false,
                'default'     => 'container',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'box_bgcolor',
                'label' => 'Colore sfondo Box',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'title_color',
                'label' => 'Colore titolo Box',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pt',
                'label' => 'Margine superiore: imposta un valore numerico (Esempio: 0 nullo, 2 normale - 5 massimo)',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pb',
                'label' => 'Margine inferiore: imposta un valore numerico (Esempio: 0 nullo, 2 normale - 5 massimo)',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            /*
             $this->crud->addField([   // repeatable
                'name'  => 'mt',
                'label' => 'Margin-top: Imposta un valore da 0 a max 120 (Es: 10, 20, 30 eccetera - 0 nessun margine)',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);
            */


            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che vedo quando aggiungo le righe al blocco multilingua */


            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto 1',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);


            $this->crud->addField([   // Browse
                'name'  => 'foto2',
                'label' => 'Foto 2 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto3',
                'label' => 'Foto 3 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto4',
                'label' => 'Foto 4 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto5',
                'label' => 'Foto 5 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto6',
                'label' => 'Foto 6 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto7',
                'label' => 'Foto 7 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto8',
                'label' => 'Foto 8 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto9',
                'label' => 'Foto 9 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto10',
                'label' => 'Foto 10 (solo per Style 3)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Upload
                'label' => "File",
                'name' => "file",
                'type'      => 'browse',
                // optional:
                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link interno",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'speed',
                'label' => 'Velocità carosello immagini --SOLO PER STYLE 3--  (Es: 2000 veloce - 4000 lento - 7000 molto lento)',
                'type'  => 'number',
                // optional
                'default' => 3500,
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo etichetta',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'txtcolor',
                'label' => 'Colore testo etichetta',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
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

        // aggiungo qui in caso di title in setting blocco per aver il titolo multilang
        $trans = new AdminLanguageController();
        $trans->fields_lang("blockGridConf", $this->crud);

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
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->mt = $request->get('mt');
            $this->crud->entry->pt = $request->get('pt');
            $this->crud->entry->pb = $request->get('pb');
            $this->crud->entry->box_bgcolor = $request->get('box_bgcolor');
            $this->crud->entry->title_color = $request->get('title_color');
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
        $lft = BlockGrid::whereNotNull("block_id")
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

        $list = BlockGrid::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
