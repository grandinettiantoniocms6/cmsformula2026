<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockStoreRequest;
use App\Models\BlockStaff;
use App\Models\BlockStore;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockStoreCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockStoreCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockStore";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockStore::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockStore');
        CRUD::setEntityNameStrings('Punto vendita', 'Punti Vendita');

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
        $this->crud->set('reorder.label', 'location');
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
                'label' => 'Comune Punto vendita',
                'type'  => 'text',
            ],
            [
                'name'  => 'category',
                'label' => 'Regione',
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
        CRUD::setValidation(BlockStoreRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Numero punti vendita per riga',
                'type'        => 'select_from_array',
                'options'     => ['1' => '1 punto vendita per riga', '2' => '2 punti vendita per riga', '3' => '3 punti vendita per riga', '4' => '4 punti vendita per riga', '5' => '5 punti vendita per riga' ],
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

            $this->crud->addField([
                'name'        => 'size_icon',
                'label'   => 'Grandezza Icone Tel e WhatsApp',
                'type'        => 'select_from_array',
                'options'     => ['fa-1x' => '1x', 'fa-2x' => '2x', 'fa-3x' => '3x'],
                'allows_null' => false,
                'default'     => 'fa-2x',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);


            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che vedo quando aggiungo le righe al blocco non multilingua */

            /*$this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto Negozio (non obbligatorio)',
                'type'  => 'browse',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
            ]); */

            $this->crud->addField([   // repeatable
                'name'  => 'phone',
                'label' => 'Telefono fisso',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'icon_phone',
                'label' => 'Icona Telefono fisso <a href="https://fontawesome.com/icons?d=gallery" target="_blank\">Clicca qui e seleziona la tua icona</a>',
                'type'  => 'text',
                'default' => 'fas fa-phone-alt',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            // grandezza icone?

            $this->crud->addField([   // repeatable
                'name'  => 'icon_color_phone',
                'label' => 'Colore icona telefono',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'whatsapp',
                'label' => 'Cellulare WhatsApp',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'icon_whatsapp',
                'label' => 'Icona WhatsApp <a href="https://fontawesome.com/icons?d=gallery" target="_blank\">Clicca qui e seleziona la tua icona</a>',
                'type'  => 'text',
                'default' => 'fab fa-whatsapp',
                'wrapper' => ['class' => 'form-group col-md-4']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'icon_color_whatsapp',
                'label' => 'Colore icona WhatsApp',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Seleziona il colore di Sfondo del riquadro',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'txt_color',
                'label' => 'Colore del testo',
                'type'  => 'color_picker2',
                'default' => '#0075a3',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_phone',
                'label'       => "Apertura link Telefono fisso",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_whatsapp',
                'label'       => "Apertura link WhatsApp",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link interno Punto vendita",
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
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->size_icon = $request->get('size_icon');
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
        $lft = BlockStore::whereNotNull("block_id")
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

        $list = BlockStore::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
