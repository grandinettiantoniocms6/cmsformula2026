<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockHtmlImageRequest;
use App\Models\BlockHtmlImage;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockHtmlImageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockHtmlImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockHtmlImage";

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockHtmlImage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockHtmlImage');
        CRUD::setEntityNameStrings('blocco html immagini', 'blocco html immagini');

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
        CRUD::setValidation(BlockHtmlImageRequest::class);

        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {


                $this->crud->addField([   // repeatable
                    'name' => 'pb',
                    'label' => 'Spazio tra le righe (0 nullo | 150 massimo ) - Imposta la spaziatura incrementando il valore di 10)',
                    'type' => 'number',
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

                // Permette di scegliere uno o stili di un blocco (parte html)
                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'options' => [
                        1 => 'Testo a sinistra - Immagini a destra',
                        2 => 'Immagini a sinistra - Testo a destra',
                        3 => 'Immagini in alto - Testo in basso',
                        4 => 'Testo in alto - Immagini in basso'],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

            }
            // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////

                // Permette di scegliere uno o stili di un blocco (parte html)
                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'options' => [
                            1 => 'Style 1: Carosello con box bianco, titolo e descrizione fissi',
                            2 => 'Style 2: Carosello con box bianco, titolo e descrizione fissi (Immagine no thumb)',
                                /*

                                 2 => 'Immagini a sinistra - Testo a destra',
                                 3 => 'Immagini in alto - Testo in basso',
                                 4 => 'Testo in alto - Immagini in basso'

                                */
                    ],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'bgcolor',
                    'label' => 'Colore sfondo carosello',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

            $this->crud->addField([   // repeatable
                'name'        => 'fullwidth',
                'label'   => 'Seleziona larghezza blocco',
                'type'        => 'select_from_array',
                'options'     => ['container' => 'Normale', 'container-fluid' => 'Full Width'],
                'allows_null' => false,
                'default'     => 'container',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);




        }else{



            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine 1',
                'type'  => 'browse'
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

                $this->crud->addField([   // Browse
                    'name'  => 'foto2',
                    'label' => 'Immagine 2',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto3',
                    'label' => 'Immagine 3',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto4',
                    'label' => 'Immagine 4',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto5',
                    'label' => 'Immagine 5',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto6',
                    'label' => 'Immagine 6',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto7',
                    'label' => 'Immagine 7',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto8',
                    'label' => 'Immagine 8',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto9',
                    'label' => 'Immagine 9',
                    'type'  => 'browse'
                ]);

                $this->crud->addField([   // Browse
                    'name'  => 'foto10',
                    'label' => 'Immagine 10',
                    'type'  => 'browse'
                ]);

            }



            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link pulsante",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

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
        $trans->fields_lang("blockHtmlImageConf", $this->crud);



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

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->pb = $request->get('pb');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->bgcolor = $request->get('bgcolor');
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
        $lft = BlockHtmlImage::orderBy("lft", "desc")->first();
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
