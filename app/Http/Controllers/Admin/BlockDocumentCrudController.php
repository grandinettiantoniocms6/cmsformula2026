<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockDocumentRequest;
use App\Models\BlockDocument;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockDocumentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockDocumentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockDocument";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockDocument::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$this->block);
        CRUD::setEntityNameStrings('Documento', 'Documenti');

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
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'file',
                'label' => 'File', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getFile', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100000, // Limit the number of characters shown
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
        CRUD::setValidation(BlockDocumentRequest::class);

        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore Titolo presentazione blocco',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo titolo presentazione blocco',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     => [
                    '1' => 'Style 1: Icona PDF senza pulsante (semplice)',
                    '2' => 'Style 2: Colore o immagine di sfondo + Titolo e pulsante (avanzato only Crafto)',
                ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'text_align',
                'label'   => 'Allineamento titoli documenti',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class'       => 'custom-select',
                ],
                'options'     => ['left' => 'Sinistra', 'center' => 'centrato', 'right' => 'destra'],
                'allows_null' => false,
                'default'     => 'center',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);



            /*
             $this->crud->addField([   // repeatable
                'name'  => 'color_text_button',
                'label' => 'Colore testo pulsanti documenti',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_bg_button',
                'label' => 'Colore sfondo pulsanti documenti',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            */


            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Selezione il numero di documenti per riga',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class'       => 'custom-select',
                ],
                'options'     => ['3' => '4 file per riga', '4' => '3 file per riga', '6' => '2 file per riga', '12' => '1 file per riga'],
                'allows_null' => false,
                'default'     => '6',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name' => 'pt',
                'label' => 'Distanza dal margine alto (0 nullo | 5 massimo )',
                'type' => 'number',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);



        }else{


            $this->crud->addField([   // Upload
                'label' => "Carica il File PDF che vuoi far scaricare (Max 16MB)",
                'name' => "file",
                'type'      => 'browse',
                // optional:
                'temporary' => 10, // if using a service, such as S3, that requires you to make temporary URLs this
                // will make a URL that is valid for the number of minutes specified
                'wrapperAttributes' => ['class' => 'form-group col-md-12']

            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link documento (stessa pagina o nuova pagina del browser)",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_blank',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore di sfondo blocco documento',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Logo del brand (Misura consigliata: 200x80 pixel)',
                'type'  => 'browse',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore titolo nome documento',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
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

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

        // aggiungo qui in caso di title in setting blocco per aver il titolo multilang
                $trans = new AdminLanguageController();
                $trans->fields_lang("blockDocumentConf", $this->crud);


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
            $this->crud->entry->color_title = $request->get('color_title');
            $this->crud->entry->text_align = $request->get('text_align');
            $this->crud->entry->bgcolor = $request->get('bgcolor');
            $this->crud->entry->color_text_button = $request->get('color_text_button');
            $this->crud->entry->color_bg_button = $request->get('color_bg_button');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->pt = $request->get('pt');
            $this->crud->entry->col = $request->get('col');

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
        $lft = BlockDocument::whereNotNull("block_id")
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

        $list = BlockDocument::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }

}

