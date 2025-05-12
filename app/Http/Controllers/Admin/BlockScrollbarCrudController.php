<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockScrollbarRequest;
use App\Models\BlockCarousel;
use App\Models\BlockScrollbar;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockScrollbarCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockScrollbarCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockScrollbar";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockScrollbar::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockScrollbar');
        CRUD::setEntityNameStrings('Blocco Scrollbar', 'Blocchi Scrollbar');

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
        CRUD::setValidation(BlockScrollbarRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
            ]);

            $this->crud->addField([
                'name'  => 'pc',
                'label' => 'Digita il numero di elementi da visualizzare per riga da schermo PC. Esempio: 4',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'notebook',
                'label' => 'Digita il numero di elementi da visualizzare per riga da schermo Notebook. Esempio: 3',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'tablet',
                'label' => 'Digita il numero di elementi da visualizzare per riga da Tablet. Esempio: 2',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([
                'name'  => 'smartphone',
                'label' => 'Digita il numero di elementi da visualizzare per riga da Smartphone. Esempio: 1',
                'type'  => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona stile",
                'type'        => 'select_from_array',
                'options'     => [
                    1 => 'Style 1: Scrollbar verticale classico con Immagine o icona, (link, titolo e pulsante solo se compilati)',

                ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titoli',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#000000',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo',
                'type'  => 'color_picker2',
                //'default' => 'transparent',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            /**  $this->crud->addField([   // repeatable
                'name'  => 'height',
                'label' => 'Altezza div contenitore: Imposta un valore numerico (Es: 35 - misura espressa in pixel )',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]); **/

            $this->crud->addField([   // select_from_array
                'name'        => 'speed',
                'label'       => "Seleziona velocità scroll",
                'type'        => 'select_from_array',
                'options'     => [
                    6000 => 'Molto lenta',
                    3000 => 'Lenta',
                    2000 => 'Normale',
                    1000 => 'Veloce',
                    500 => 'Molto veloce',

                ],
                'allows_null' => false,
                'default'     => 8,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'margin_top',
                'label' => 'Margin Top: Imposta un valore numerico (Es: 180 - misura espressa in pixel )',
                'type'  => 'text',
                //'default'  => '200',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'padding_item',
                'label' => 'Spazio tra le righe: Imposta un valore numerico (Es: 10 - misura espressa in pixel )',
                'type'  => 'text',
                //'default'  => '200',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);



            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */


        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel AdminLanguageController */

            $this->crud->addField([   // Upload
                'label' => "Icona <a href=\"https://fontawesome.com/icons?d=gallery\" target=\"_blank\">Clicca qui e seleziona la tua icona Free dal sito dedicato.</a> - Poi incolla tutto il codice HTML copiato dal sito.",
                'name' => "icon",
                'type' => 'text',
                //'default' => '<i class="fas fa-question"></i>',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto - Se non vuoi usare le icone, carica una foto PNG o JPG',
                'type'  => 'browse',
                //'default' => '<i class="fas fa-question"></i>',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'icon_color',
                'label' => 'Colore icona',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'icon_bgcolor',
                'label' => 'Colore sfondo icona',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
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
            $this->crud->entry->bgcolor = $request->get('bgcolor');
            $this->crud->entry->height = $request->get('height');

            $this->crud->entry->speed = $request->get('speed');
            $this->crud->entry->margin_top = $request->get('margin_top');
            $this->crud->entry->padding_item = $request->get('padding_item');

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
        $lft = BlockScrollbar::orderBy("lft", "asc")->first();
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
