<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockNewsRequest;
use App\Models\BlockDocument;
use App\Models\BlockNews;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class BlockNewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockNewsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }
    use \Backpack\EditableColumns\Http\Controllers\Operations\MinorUpdateOperation;

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        // whatever you want

        $old = BlockNews::find($id);
        // if you still want to call the old clone method
        $this->traitClone($id);
        $new = BlockNews::orderBy("id", "desc")->first();
        $new->is_active = 0;
        $new->save();

    }

    public $block = "blockNews";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockNews::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$this->block);
        CRUD::setEntityNameStrings('blocco news', 'blocchi news');

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
        $this->crud->set('reorder.label', 'foto', 'title');
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
        $this->crud->removeButton("clone");

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
                'name'  => 'is_default',
                'label' => 'In evidenza',
                'type'  => 'check',
            ],
            [
                'name'  => 'date',
                'label' => 'Data news',
                'type'  => 'date',
            ],
            [
                'name'  => 'date_end',
                'label' => 'Data fine news',
                'type'  => 'datetime',
            ],
            [
                'name'  => 'is_active',
                'label' => 'Attivo',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                'name'  => 'title',
                'label' => 'Nome',
                'type'  => 'text',
            ],
            /*[
                'name'  => 'description',
                'label' => 'Descrizione',
                'type'  => 'text', // se mi serve editor metto ckeditor
            ],*/
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

        if(request()->has('multi')){
            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'number_news',
                'label' => 'Attivo paginazione dopo quante news?',
                'type'  => 'number',
                'wrapper' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'number_news_home',
                'label' => 'Quante news vuoi visualizzare nella home? (compilare solo se ti trovi nella pagina Home)',
                'type'  => 'number',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'type_order',
                'label'       => "Tipo ordinamento",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ['id|DESC' => 'Ultimo inserito', 'id|ASC' => 'Primo inserito', 'title|DESC' => 'Titolo Z-A', 'title|ASC' => 'Titolo A-Z',
                    'date|DESC' => 'Data decrescente', 'date|ASC' => 'Data crescente', 'lft|asc' => 'Manualmente impostato'],
                'allows_null' => false,
                'default'     => 'id|DESC',
                'wrapper' => ['class' => 'form-group col-md-6']
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

                $this->crud->addField([   // repeatable
                    'name'  => 'height',
                    'label' => 'Imposta altezza box News in rem (Es: 35) - NB: 1 rem = 16px',
                    'type'  => 'text',
                    'default'     => '35',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // repeatable
                    'name' => 'col',
                    'label' => 'Numero di New per riga',
                    'type' => 'select_from_array',
                    'options' => ['3' => '4 new per riga', '4' => '3 news per riga', '6' => '2 news per riga', '12' => '1 news per riga'],
                    'allows_null' => false,
                    'default' => '6',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

                // Permette di scegliere uno o stili di un blocco (parte html)
                $this->crud->addField([   // select_from_array
                    'name'        => 'style',
                    'label'       => "Seleziona stile",
                    'type'        => 'select_from_array',
                    'attributes' => [
                        'class' => 'custom-select',
                    ],
                    'options'     => [1 => 'Style Classico', 2 => 'Style Metro', 3 => 'Variante Style Classico'],
                    'allows_null' => false,
                    'default'     => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

            } // FIne Perso per Webshop

            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Bexo' ) {

                // Permette di scegliere uno o stili di un blocco (parte html)
                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona stile",
                    'type' => 'select_from_array',
                    'attributes' => [
                        'class' => 'custom-select',
                    ],
                    'options' => [1 => 'Style 1', 2 => 'Style 2', 3 => 'Style 3'],
                    'allows_null' => false,
                    'default' => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

                $this->crud->addField([   // repeatable
                    'name'        => 'col',
                    'label'   => 'Numero di New per riga',
                    'type'        => 'select_from_array',
                    'options'     => ['3' => '4 new per riga', '4' => '3 news per riga', '6' => '2 news per riga', '12' => '1 news per riga' ],
                    'allows_null' => false,
                    'default'     => '2',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

            } // FIne Perso per Crafto



                // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                if(env('TEMA') == 'Crafto' ) {

                    // Permette di scegliere uno o stili di un blocco (parte html)
                    $this->crud->addField([   // select_from_array
                        'name' => 'style',
                        'label' => "Seleziona stile",
                        'type' => 'select_from_array',
                        'attributes' => [
                            'class' => 'custom-select',
                        ],
                        'options' => [1 => 'Style 1', 2 => 'Style 2', 3 => 'Style 3'],
                        'allows_null' => false,
                        'default' => 1,
                        // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                        'wrapperAttributes' => ['class' => 'form-group col-md-6']
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'        => 'col',
                        'label'   => 'Numero di New per riga',
                        'type'        => 'select_from_array',
                        'options'     => ['4' => '4 new per riga', '3' => '3 news per riga', '2' => '2 news per riga', '1' => '1 news per riga' ],
                        'allows_null' => false,
                        'default'     => '2',
                        'wrapper' => ['class' => 'form-group col-md-6']
                    ]);

                } // FIne Perso per Crafto

            // CAMPI VISUALIZZATI SOLO CON IL TEMA Corporate1 //////////////////
            if(env('TEMA') == 'Corporate1' ) {

                $this->crud->addField([   // repeatable
                    'name' => 'col',
                    'label' => 'Numero di New per riga',
                    'type' => 'select_from_array',
                    'options' => ['3' => '4 new per riga', '4' => '3 news per riga', '6' => '2 news per riga', '12' => '1 news per riga'],
                    'allows_null' => false,
                    'default' => '6',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

                // Permette di scegliere uno o stili di un blocco (parte html)
                $this->crud->addField([   // select_from_array
                    'name'        => 'style',
                    'label'       => "Seleziona stile",
                    'type'        => 'select_from_array',
                    'attributes' => [
                        'class' => 'custom-select',
                    ],
                    'options'     => [
                        1 => 'Style Unico',
                        //2 => 'Style Metro',
                        //3 => 'Variante Style Classico'
                    ],
                    'allows_null' => false,
                    'default'     => 1,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes' => ['class' => 'form-group col-md-6']
                ]);

            } // FIne Perso per Corporate1



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

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore di sfondo data',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'date_color',
                'label' => 'Colore testo data',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'title_cat_color',
                'label' => 'Colore Categoria News',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'title_news_color',
                'label' => 'Colore Titolo News',
                'type'  => 'color_picker2',
                // optional
                'default' => null,
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);



        }else{
            CRUD::setValidation(BlockNewsRequest::class, "aa");

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine principale',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto2',
                'label' => 'Immagine 2 (opzionale)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto3',
                'label' => 'Immagine 3 (opzionale)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto4',
                'label' => 'Immagine 4 (opzionale)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto5',
                'label' => 'Immagine 5 (opzionale)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto6',
                'label' => 'Immagine 6 (opzionale)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([
                'label' => "Data pubblicazione",
                'name' => "date",
                'type' => 'date',
                'default' => Carbon::now()->toDateString()
            ]);

            $this->crud->addField([
                'label' => "Data offline",
                'name' => "date_end",
                'type' => 'datetime',
            ]);

            $this->crud->addField([
                'label' => "In evidenza",
                'name' => "is_default",
                'type' => 'switch',
            ]);

            $this->crud->addField([
                'label' => "Visibile",
                'name' => "is_active",
                'type' => 'switch',
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

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Attivo',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

       // aggiungo qui in caso di title in setting blocco per aver il titolo multilang
       // $trans = new AdminLanguageController();
       // $trans->fields_lang("blockNewsConf", $this->crud);

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

        $this->crud->entry->number_news_home = (int) $request->get('number_news_home');
        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);

        if($request->has('name')){
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->number_news = $request->get('number_news');
            $this->crud->entry->type_order = $request->get('type_order');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->height = $request->get('height');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->bgcolor = $request->get('bgcolor');
            $this->crud->entry->date_color = $request->get('date_color');
            $this->crud->entry->title_cat_color = $request->get('title_cat_color');
            $this->crud->entry->title_news_color = $request->get('title_news_color');


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
        $lft = BlockNews::whereNotNull("block_id")
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

        $list = BlockNews::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}

