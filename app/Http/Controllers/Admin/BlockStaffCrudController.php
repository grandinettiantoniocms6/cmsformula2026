<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockStaffRequest;
use App\Models\BlockStaff;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockStaffCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockStaffCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockStaff";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockStaff::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockStaff');
        CRUD::setEntityNameStrings('Blocco Staff', 'Blocchi Staff');

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
                'name'  => 'name_surname',
                'label' => 'Nome e Cognone',
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
        CRUD::setValidation(BlockStaffRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA CRAFTO //////////////////
            if(env('TEMA') == 'Crafto' ) {

                $this->crud->addField([   // select_from_array
                    'name'        => 'style',
                    'label'       => "Seleziona stile",
                    'type'        => 'select_from_array',
                    'options'     => [

                        1 => 'Style 1: : Foto rotonda con sfondo + ombra',
                        2 => 'Style 2: Foto quadrata con sfondo + ombra',
                        3 => 'Style 3: Foto con effetto fade'],

                    'allows_null' => false,
                    'default'     => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-4']
                ]);

                $this->crud->addField([   // repeatable
                    'name'        => 'col',
                    'label'   => 'Numero di foto per riga',
                    'type'        => 'select_from_array',
                    'options'     => ['12' => '1 foto per riga', '6' => '2 foto per riga', '4' => '3 foto per riga', '3' => '4 foto per riga'],
                    'allows_null' => false,
                    'default'     => '6',
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




            }else {

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona stile",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Style 1: : Foto rotonda con sfondo + ombra', 2 => 'Style 2: Foto quadrata con sfondo + ombra', 3 => 'Style 3: Effetto mosaico: consigliato per visualizzare solo la foto'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-4']
                ]);

            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Numero di foto per riga',
                'type'        => 'select_from_array',
                'options'     => ['12' => '1 foto per riga', '6' => '2 foto per riga', '4' => '3 foto per riga', '3' => '4 foto per riga', '2' => '6 foto per riga' ],
                'allows_null' => false,
                'default'     => '4',
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





            }/* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che vedo quando aggiungo le righe al blocco multilingua */

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto Staff',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            /*$this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo Box',
                'type'  => 'color_picker2',
                // optional
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);*/

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link interno",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_1',
                'label'       => "Apertura link FACEBOOK",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_2',
                'label'       => "Apertura link INSTAGRAM",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_3',
                'label'       => "Apertura link LINKEDIN",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href_4',
                'label'       => "Apertura link TWITTER",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
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


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */


        // aggiungo qui in caso di title in setting blocco per aver il titolo multilang
        $trans = new AdminLanguageController();
        $trans->fields_lang("blockStaffConf", $this->crud);


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
        $lft = BlockStaff::whereNotNull("block_id")
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

        $list = BlockStaff::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
