<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockReferenceRequest;
use App\Models\BlockReference;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockReferenceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockReferenceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockReference";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockReference::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockReference');
        CRUD::setEntityNameStrings('blocco referenza', 'blocco referenze');

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
        // se volgio la thumbs nel riordina scrivo foto altrimenti title
        $this->crud->set('reorder.label', 'foto');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
    }

    protected function setupListOperation()
    {
        $this->crud->removeButton("delete");
        $this->crud->removeButton("update");
        $this->crud->removeButton("show");

        // Columns.
        $this->crud->setColumns([
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
                'name'  => 'category',
                'label' => 'Categoria',
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
        CRUD::setValidation(BlockReferenceRequest::class);

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'style',
                'label'   => 'Seleziona lo stile',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => [
                    '1' => 'Style 1',
                    '2' => 'Style 2',
                    '3' => 'Style 3',
                    '4' => 'Style 4'
                                ],
                'allows_null' => false,
                'default'     => '1',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ){

            $this->crud->addField([
                'name'  => 'is_pagination',
                'label' => 'Attivare paginazione?',
                'type'  => 'switch',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([
                'name'  => 'number_pagination',
                'label' => 'Quante foto per pagina?',
                'type'  => 'number',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'background_color',
                    'label' => 'Colore sfondo pulsante VEDI TUTTO',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'border_color',
                    'label' => 'Colore bordo pulsante VEDI TUTTO',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'text_color',
                    'label' => 'Colore testo pulsante VEDI TUTTO',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'background_color_cat',
                    'label' => 'Colore sfondo pulsanti CATEGORIE',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'border_color_cat',
                    'label' => 'Colore bordo pulsanti CATEGORIE',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'text_color_cat',
                    'label' => 'Colore testo pulsanti CATEGORIE',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'box_color',
                    'label' => 'Colore sfondo BOX FOTO',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'title_color',
                    'label' => 'Colore TITOLI',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'subtitle_color',
                    'label' => 'Colore SOTTO TITOLI',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'background_color_btn',
                    'label' => 'Colore sfondo pulsante LINK',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'border_color_btn',
                    'label' => 'Colore bordo pulsante LINK',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);

                $this->crud->addField([   // repeatable
                    'name'  => 'text_color_btn',
                    'label' => 'Colore testo pulsante LINK',
                    'type'  => 'color_picker2',
                    'default' => null,
                    // optional
                    'color_picker_options' => ['customClass' => 'custom-class'],
                    'wrapperAttributes' => [ 'class' => 'form-group col-md-4'],
                ]);


            }
            // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP



            $this->crud->addField([   // repeatable
                'name'        => 'col',
                'label'   => 'Seleziona il numero di colonne',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ['1' => '1 colonna (NB: servono immagini con larghezza  maggiore di 1800px)', '2' => '2 colonne', '3' => '3 colonne', '4' => '4 colonne' ],
                'allows_null' => false,
                'default'     => '3',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'        => 'fullwidth',
                'label'   => 'Seleziona larghezza blocco',
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ['container' => 'Normale', 'container-fluid' => 'Full Width'],
                'allows_null' => false,
                'default'     => 'container',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);








        }else{

            /*$this->crud->addField([
                'label' => "Foto",
                'name' => "foto",
                'type' => 'image',
                'crop' => false, // set to true to allow cropping, false to disable
                'aspect_ratio' => 0, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);*/

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto',
                'type'  => 'browse'
            ]);

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


            /*$this->crud->addField([   // color_picker
                'label'                => 'Background Color',
                'name'                 => 'background_color',
                'type'                 => 'color_picker2',
                'default' => null,

                // optional
                'color_picker_options' => ['customClass' => 'custom-class']
            ]);*/


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
        $trans->fields_lang("blockReferenceConf", $this->crud);


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
            // gli input di settaggio blocco da memorizzare
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->style = $request->get('style');

            $this->crud->entry->is_pagination = $request->get('is_pagination');
            $this->crud->entry->number_pagination = $request->get('number_pagination');

            $this->crud->entry->background_color = $request->get('background_color');
            $this->crud->entry->border_color = $request->get('border_color');
            $this->crud->entry->text_color = $request->get('text_color');

            $this->crud->entry->background_color_cat = $request->get('background_color_cat');
            $this->crud->entry->border_color_cat = $request->get('border_color_cat');
            $this->crud->entry->text_color_cat = $request->get('text_color_cat');

            $this->crud->entry->box_color = $request->get('box_color');
            $this->crud->entry->title_color = $request->get('title_color');
            $this->crud->entry->subtitle_color = $request->get('subtitle_color');

            $this->crud->entry->background_color_btn = $request->get('background_color_btn');
            $this->crud->entry->border_color_btn = $request->get('border_color_btn');
            $this->crud->entry->text_color_btn = $request->get('text_color_btn');


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
        $lft = BlockReference::whereNotNull("block_id")
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

        $list = BlockReference::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
