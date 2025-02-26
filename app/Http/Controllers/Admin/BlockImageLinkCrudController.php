<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockImageLinkRequest;
use App\Models\BlockImageLink;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockImageLinkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockImageLinkCrudController extends CrudController
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockImageLink";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockImageLink::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockImageLink');
        CRUD::setEntityNameStrings('Blocco Immagine sx Link', 'Blocchi Immagine sx Link');

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
        CRUD::setValidation(BlockImageLinkRequest::class);

        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pb',
                'label' => 'Padding (00 nullo | 150 massimo) Accetta valori multipli di 10.',
                'type'  => 'number',
                'default'     => 30,
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);


            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ){


            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Style 1: Foto a sx - Testo a dx con sfondo sovrapposto a immagine (col 7/5)',
                                  2 => 'Style 2: Foto a dx - Testo a sx con sfondo sovrapposto a immagine (col 7/5)',
                                  3 => 'Style 3: Foto a sx - Testo a dx senza sfondo colorato (col 5/7)',
                                  4 => 'Style 4: Foto a dx - Testo a sx senza sfondo colorato (col 5/7)',
                                  5 => 'Style 5: Foto a sx - Testo a dx con sfondo sovrapposto a immagine (col 6/6)',
                                  6 => 'Style 6: Foto a dx - Testo a sx con sfondo sovrapposto a immagine (col 6/6)',
                                  7 => 'Style 7: Foto a sx (no thumb) - Testo a dx senza sfondo sovrapposto a immagine  (col 4/8)',
                                  8 => 'Style 8: Foto a dx (no thumb) - Testo a sx senza sfondo sovrapposto a immagine (col 8/4)',
                                  9 => 'Style 9: Testo in alto e Foto (no thumb) in basso (col 12/12)',
                                 10 => 'Style 10: Foto (no thumb) in alto e Testo in basso (col 12/12)',
                                 11 => 'Style 11: Foto a sx - Testo a dx senza sfondo sovrapposto a immagine (col 6/6)',
                                 12 => 'Style 12: Foto a dx - Testo a sx senza sfondo sovrapposto a immagine (col 6/6)',
                                 13 => 'Style 13: Foto (se presente - no thumb) e testo centrati in alto con link e se compilato titolo e testo in basso (col 12/12)',
                                 14 => 'Style 14: Foto non obbligatoria, testo e titolo a sinistra',
                                 //15 => 'Style 15: al momento non serve...',


                                 ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);


            }
            // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP



            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     =>
                    [
                        1 => 'Style 1: immagine a sx e testo a dx',
                        2 => 'Style 2: testo a sx e immagine a dx',
                        //3 => 'Style 3: xxxx ',

                    ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);





            $this->crud->addField([   // repeatable
                'name'        => 'fullwidth',
                'label'   => 'Seleziona larghezza blocco',
                'type'        => 'select_from_array',
                'options'     => ['container' => 'Normale', 'container-fluid' => 'Full Width'],
                'allows_null' => false,
                'default'     => 'container',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

        }else{


            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine',
                'type'  => 'browse'
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Crafto' ){

            $this->crud->addField([   // Browse
                'name'  => 'foto3',
                'label' => 'Immagine 2 (solo per Style 2)',
                'type'  => 'browse'
            ]);





            }
            // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA CRAFTO

           $this->crud->addField([   // select_from_array
               'name'        => 'type_href',
               'label'       => "Apertura link pulsante",
               'type'        => 'select_from_array',
               'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
               'allows_null' => false,
               'default'     => '_self',
               // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
           ]);

            $this->crud->addField([   // Upload
                'label' => "Icona <a href=\"https://fontawesome.com/icons?d=gallery\" target=\"_blank\">Clicca qui, seleziona la tua icona</a> ed incolla tutto il codice HTML",
                'name' => "icon",
                'type' => 'text',
                'attributes' => [
                    'placeholder' => '<i class="fas fa-search"></i>',
                    'class'       => 'form-control some-class',
                ],
                //'default' => '<i class="fas fa-question"></i>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto2',
                'label' => 'Se non vuoi usare un\'icona, carica una foto .png o .jpg (Dimensioni richieste: 100x100 px)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'txtcolor',
                'label' => 'Colore Titolo e Icona',
                'type'  => 'color_picker',
                // optional
                'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo Box',
                'type'  => 'color_picker',
                // optional
                'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
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
            $this->crud->entry->pb = $request->get('pb');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
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
        $lft = BlockImageLink::orderBy("lft", "desc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft + 2;
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
