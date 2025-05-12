<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockIconRequest;
use App\Models\BlockIcon;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockIconCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockIconCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockIcon";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockIcon::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockIcon');
        CRUD::setEntityNameStrings('blocco icona', 'blocchi icona');

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
                'name'  => 'title',
                'label' => 'Nome',
                'type'  => 'text',
            ],
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
        CRUD::setValidation(BlockIconRequest::class);


        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Seleziona numero icone per riga',
                'type'        => 'select_from_array',
                'options'     => ['3' => '4 x 1', '4' => '3 x 1', '6' => '2 x 1','12' => '1 x 1'],
                'allows_null' => false,
                'default'     => '3',
                'wrapper' => ['class' => 'form-group col-md-4']
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

            $this->crud->addField([   // repeatable
                'name'  => 'color_icon',
                'label' => 'Colore Icone',
                'type'  => 'color_picker2',
                // optional
                'default' => '#1ab42f',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);



                            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                            if(env('TEMA') == 'Webshop' ){

                            // Permette di scegliere uno o stili di un blocco (parte html)
                            $this->crud->addField([   // select_from_array
                                'name'        => 'style',
                                'label'       => "Seleziona lo style",
                                'type'        => 'select_from_array',
                                'options'     => [
                                    '1' => 'Style 1: Icona/Immagine sopra, titolo e testo sotto - Allineamento: sinistra',
                                    '2' => 'Style 2: Icona/Immagine sopra, titolo e testo sotto - Allineamento: centrato',
                                    '3' => 'Style 3: Icona/Immagine a sinistra, titolo e testo a destra - Allineamento: sinistra',
                                    '4' => 'Style 4: Linea + Nome Blocco, Icona/Immagine sopra, titolo e testo sotto - Allineamento: sinistra (senza effetto ombra)',
                                    '5' => 'Style 5: Linea + Nome Blocco, Icona/Immagine sopra a dim. fisse (130x130px), titolo e testo sotto - Allineamento: sinistra (senza effetto ombra)',
                                    '6' => 'Style 6: Linea + Nome Blocco, Icona/Immagine sopra a dim. fisse (100x100px), titolo e testo sotto - Allineamento: sinistra (senza effetto ombra)',
                                    '7' => 'Style 7: Solo Pulsante e Titolo - Allineamento: Centrato',
                                    '8' => 'Style 8: Icona/Immagine sopra, titolo e testo sotto - Allineamento: centrato (senza effetto ombra)',
                                    '9' => 'Style 9: Icona/Immagine sopra, titolo e testo sotto a comparsa su hover - Allineamento: centrato (senza effetto ombra)',
                                    '10' => 'Style 10: Icona/Immagine a sinistra, titolo e testo a destra - Allineamento: sinistra (senza effetto ombra)',
                                ],
                                'allows_null' => false,
                                'default'     => 1,
                                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                                'wrapperAttributes' => ['class' => 'form-group col-md-12']
                            ]);

                                $this->crud->addField([   // repeatable
                                    'name'  => 'bgcolor_button_hover',
                                    'label' => 'Colore di sfondo Pulsanti effetto MouseOver',
                                    'type'  => 'color_picker2',
                                    // optional
                                    //'default' => '#074b10',
                                    'color_picker_options' => ['customClass' => 'custom-class'],
                                    'wrapperAttributes' => ['class' => 'form-group col-md-4']
                                ]);

                                $this->crud->addField([   // repeatable
                                    'name'  => 'bgcolor_hover',
                                    'label' => 'Colore di sfondo Box Icone',
                                    'type'  => 'color_picker2',
                                    // optional
                                    //'default' => '#074b10',
                                    'color_picker_options' => ['customClass' => 'custom-class'],
                                    'wrapperAttributes' => ['class' => 'form-group col-md-4']
                                ]);


                            }
                            // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP


            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     => [
                    '1' => 'Style 1: Icone senza pulsante e link',
                    '2' => 'Style 2: Icone con pulsante a scomparsa e link',
                    '3' => 'Style 3: Icone con pulsante a vista e link',

                ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);


            /*
            $this->crud->addField([
                'name'  => 'col',
                'label' => 'Numero elementi per riga (segui questo esempio per ottenere il risultato desiderato)
                           <br>Esempio:
                           <br>Imposta 3 se desideri visualizzare 4 elementi per riga
                           <br>Imposta 4 se desideri visualizzare 3 elementi per riga
                           <br>Imposta 6 se desideri visualizzare 2 elementi per riga
                           <br>Imposta 12 se desideri visualizzare 1 elemento per riga',

                'type'  => 'number',
            ]);
            */


        }else{

            $this->crud->addField([   // Upload
                'label' => "Icona <a href=\"https://fontawesome.com/icons?d=gallery\" target=\"_blank\">Clicca qui e seleziona la tua icona Free</a>",
                'name' => "icon",
                'type' => 'text',
                //'default' => '<i class="fas fa-question"></i>',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Se non vuoi usare le icone, carica una foto PNG o JPG (Misura consigliata: 100x100 pixel)',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo Box',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor_over',
                'label' => 'Colore sfondo Box Over',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titolo',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            /*$this->crud->addField([   // repeatable
                'name'  => 'bgcolor_hover',
                'label' => 'Colore sfondo Box MouseOver',
                'type'  => 'color_picker',
                // optional
                'default' => '#148223',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);*/

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor_button',
                'label' => 'Colore di sfondo Pulsante',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#148223',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);


            $this->crud->addField([   // repeatable
                'name'  => 'color_text_button',
                'label' => 'Colore testo pulsante',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
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
        $trans->fields_lang("blockIconConf", $this->crud);


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
            // gli input di settaggio blocco da memorizzare
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->color_icon = $request->get('color_icon');
            $this->crud->entry->bgcolor_button_hover = $request->get('bgcolor_button_hover');
            $this->crud->entry->bgcolor_hover = $request->get('bgcolor_hover');
            $this->crud->entry->bgcolor_over = $request->get('bgcolor_over');

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
        $lft = BlockIcon::orderBy("lft", "desc")->first();
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
