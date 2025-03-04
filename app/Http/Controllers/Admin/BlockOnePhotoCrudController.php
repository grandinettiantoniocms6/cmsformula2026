<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockOnePhotoRequest;
use App\Models\BlockOnePhoto;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockOnePhotoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockOnePhotoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockOnePhoto";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockOnePhoto::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockOnePhoto');
        CRUD::setEntityNameStrings('Una Foto e titolo effetto Macchina da scrivere ', 'Una Foto e titoli effetto Macchina da scrivere');

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
        CRUD::setValidation(BlockOnePhotoRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            /* Lo commento in quanto da mobile non va bene ***

            $this->crud->addField([   // repeatable
                'name'  => 'mt',
                'label' => 'Margine alto (es: 50px)',
                'type'  => 'text',
                //'default' => '350px',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);
            ****
            */

            $this->crud->addField([   // repeatable
                'name'  => 'height',
                'label' => 'Altezza contenitore Foto su PC/Laptop (es: 700px)',
                'type'  => 'text',
                //'default' => '350px',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'height_mobile',
                'label' => 'Altezza contenitore Foto su SmartPhone (es: 420px)',
                'type'  => 'text',
                //'default' => '350px',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'speed',
                'label' => 'Velocità effetto macchina da scrivere Titoli (es: 50 - rapidissimo / 200 - veloce / 400 lento / 1000 molto lento ecc..)',
                'type'  => 'number',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            /* adesso lo style non lo uso quindi commento

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona stile",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Style 1: Una colonna (Testo e foto al centro)', 2 => 'Style 2: Due colonne (Foto a sx e testo a dx)', 3 => 'Style 3: Due colonne (Foto a dx e testo a sx)', 4 => 'Style 4: Due colonne con Video (Testo a sx e Video a dx)', 5 => 'Style 5: Due colonne con Video (Video a sx e Testo a dx)'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);
            */



            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che vedo quando aggiungo le righe al blocco multilingua */

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Scegli un\'immagine di sfondo',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'alpha',
                'label' => 'Filigrana sopra la foto (0 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom - NB: se usi un colore imposta 100)',
                'type'  => 'number',
                //'default' => '0',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 10,
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bg_color',
                'label' => 'oppure scegli un colore di sfondo',
                'type'  => 'color_picker',
                //'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titolo',
                'type'  => 'color_picker',
                //'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'font_size_title',
                'label' => 'Grandezza font titolo (min. 24 max 180)',
                'type'  => 'text',
                //'default' => '350px',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'cursor_title',
                'label' => 'Cursore lampeggiante sul titolo?',
                'type'  => 'switch',
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);


            $this->crud->addField([   // repeatable
                'name'  => 'color_subtitle',
                'label' => 'Colore sotto titolo',
                'type'  => 'color_picker',
                //'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            /* disattivo gli H per il titolo così può mettere la dimensione che desidera
               // Permette di scegliere uno o stili di un blocco (parte html)
               $this->crud->addField([   // select_from_array
                   'name'        => 'h_subtitle',
                   'label'       => "Seleziona grandezza sotto titolo",
                   'type'        => 'select_from_array',
                   'options'     => [1 => 'H1', 2 => 'H2', 3 => 'H3', 4 => 'H4', 5 => 'H5', 6 => 'H6',],
                   'allows_null' => false,
                   'default'     => 3,
                   // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                   'wrapperAttributes' => ['class' => 'form-group col-md-6']
               ]);
            */

            $this->crud->addField([   // repeatable
                'name'  => 'font_size_subtitle',
                'label' => 'Grandezza font sotto titolo (min. 24 max 180)',
                'type'  => 'text',
                //'default' => '350px',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_description',
                'label' => 'Colore testo descrizione',
                'type'  => 'color_picker',
                //'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

           $this->crud->addField([   // select_from_array
               'name'        => 'text_align',
               'label'       => "Allineamento Titolo e Sottotitolo",
               'type'        => 'select_from_array',
               'options'     => ['1' => 'In alto a sinistra', '2' => 'In alto al Centro', '3' => 'In alto a destra', '4' => 'In centro a sinistra', '5' => 'In centro al centro', '6' => 'In centro a destra', '7' => 'In basso a sinistra', '8' => 'In basso al centro', '9' => 'In basso a destra'],
               'allows_null' => false,
               'default'     => '5',
               'wrapperAttributes' => [
                   'class' => 'form-group col-md-6'
               ],
           ]);

           $this->crud->addField([   // repeatable
               'name'  => 'color_button',
               'label' => 'Colore sfondo pulsante',
               'type'  => 'color_picker',
               //'default' => '#076E8E',
               // optional
               'color_picker_options' => ['customClass' => 'custom-class'],
               'wrapper' => ['class' => 'form-group col-md-4']
           ]);

           $this->crud->addField([   // repeatable
               'name'  => 'color_txt_button',
               'label' => 'Colore testo pulsante',
               'type'  => 'color_picker',
               //'default' => '#ffffff',
               // optional
               'color_picker_options' => ['customClass' => 'custom-class'],
               'wrapper' => ['class' => 'form-group col-md-4']
           ]);

           $this->crud->addField([   // select_from_array
               'name'        => 'type_href',
               'label'       => "Apertura link pulsante",
               'type'        => 'select_from_array',
               'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
               'allows_null' => false,
               'default'     => '_self',
               'wrapper' => ['class' => 'form-group col-md-4']
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
            $this->crud->entry->mt = $request->get('mt');
            $this->crud->entry->height = $request->get('height');
            $this->crud->entry->height_mobile = $request->get('height_mobile');
            $this->crud->entry->speed = $request->get('speed');
            //$this->crud->entry->style = $request->get('style');
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
        $lft = BlockOnePhoto::orderBy("lft", "desc")->first();
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
