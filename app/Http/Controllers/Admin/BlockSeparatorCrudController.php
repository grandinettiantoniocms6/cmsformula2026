<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockSeparatorRequest;
use App\Models\BlockFlusso;
use App\Models\BlockSeparator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockSeparatorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockSeparatorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockSeparator";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockSeparator::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockSeparator');
        CRUD::setEntityNameStrings('Separatore con titolo', 'Separatori con titolo');

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
        CRUD::setValidation(BlockSeparatorRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'height',
                'label' => 'Altezza Separatore (dichiarare un valore in pixel solo se non si usano immagini) es: 350px ',
                'type'  => 'text',
                'default' => '',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);


            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'options' => [1 => 'Style 1: Una colonna (Testo e foto al centro)', 2 => 'Style 2: Due colonne (Foto a sx e testo a dx)', 3 => 'Style 3: Due colonne (Foto a dx e testo a sx)', 4 => 'Style 4: Due colonne con Video (Testo a sx e Video a dx)', 5 => 'Style 5: Due colonne con Video (Video a sx e Testo a dx)'],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);


            } // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////

            $this->crud->addField([   // select_from_array
                'name' => 'style',
                'label' => "Seleziona stile",
                'type' => 'select_from_array',
                'options' => [
                    1 => 'Style 1: Una colonna (Testo e foto al centro)',
                    2 => 'Style 2: Due colonne (Foto a sx e testo a dx)',
                    3 => 'Style 3: Due colonne (Foto a dx e testo a sx)',

                    //4 => 'Style 4: Due colonne con Video (Testo a sx e Video a dx)',
                    //5 => 'Style 5: Due colonne con Video (Video a sx e Testo a dx)'

                ],
                'allows_null' => false,
                'default' => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
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
                'label' => 'Filigrana immagine (0 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom - 100 colore pieno)',
                'type'  => 'number',
                'default' => '0',
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
                'name'  => 'bgcolor',
                'label' => 'oppure scegli un colore di sfondo',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto2',
                'label' => 'Immagine destra o sinistra (opzione valida solo in alcuni Stili blocco)',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'video',
                'label' => 'Video',
                'type'  => 'browse',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'video_height',
                'label' => 'Altezza Video (Es: per 600px digitare solo 600 - opzione valida solo in alcuni Stili)',
                'type'  => 'text',
                'default' => '',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titolo 1',
                'type'  => 'color_picker2',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'h_title',
                'label'       => "Seleziona Stile Titolo 1",
                'type'        => 'select_from_array',
                'options'     => [1 => 'H1', 2 => 'H2', 3 => 'H3', 4 => 'H4', 5 => 'H5', 6 => 'H6',],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_subtitle',
                'label' => 'Colore Titolo 2',
                'type'  => 'color_picker2',
                'default' => '#000000',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'h_subtitle',
                'label'       => "Seleziona Stile Titolo 2",
                'type'        => 'select_from_array',
                'options'     => [1 => 'H1', 2 => 'H2', 3 => 'H3', 4 => 'H4', 5 => 'H5', 6 => 'H6',],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'align',
                'label'       => "Seleziona allineamento Titoli 1 e 2",
                'type'        => 'select_from_array',
                'options'     => ['left' => 'Sinistra', 'right' => 'Destra', 'center' => 'Centrato'],
                'allows_null' => false,
                'default'     => 'left',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'mt',
                'label' => 'Margine superiore (Impostare un valore da 10 a 120 px)',
                'type'  => 'number',
                'default' => '',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'mb',
                'label' => 'Margine inferiore (Impostare un valore da 10 a 120 px)',
                'type'  => 'number',
                'default' => '',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_button',
                'label' => 'Colore sfondo pulsante',
                'type'  => 'color_picker2',
                'default' => '#076E8E',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_txt_button',
                'label' => 'Colore testo pulsante',
                'type'  => 'color_picker2',
                'default' => '#ffffff',
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
            $this->crud->entry->height = $request->get('height');
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

        // Se metto desc ogni nuovo record aggiunto va all'inizio
        $lft = BlockSeparator::whereNotNull("block_id")
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

        $list = BlockSeparator::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
