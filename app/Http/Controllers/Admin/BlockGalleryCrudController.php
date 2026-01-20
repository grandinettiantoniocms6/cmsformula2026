<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockGalleryRequest;
use App\Models\BlockGallery;
use App\Models\Page;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockGalleryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockGalleryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockGallery";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockGallery::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockGallery');
        CRUD::setEntityNameStrings('blocco gallery', 'blocco gallery');

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
                'name'  => 'id',
                'label' => '<input type="checkbox" id="select_all"/>', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCheck', // the method in your Model
                'limit' => 1000,
                'orderable' => false
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
            ],
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
                'name'  => 'description',
                'label' => 'Descrizione',
                'type'  => 'text', // se mi serve editor metto ckeditor
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'cartella',
                'label' => 'Cartella', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'get_cartella', // the method in your Model
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
        CRUD::setValidation(BlockGalleryRequest::class);

        if(request()->has('multi')){

            $trans = new AdminLanguageController();
            $trans->fields_lang($this->block, $this->crud);

            $this->crud->addField([
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
            ]);

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

            // CAMPI VISUALIZZATI SOLO CON IL TEMA CORPORATE1 //////////////////
            if(env('TEMA') == 'Corporate1' ) {

                $this->crud->addField([
                    'name'        => 'col',
                    'label'   => 'Seleziona il numero di colonne',
                    'type'        => 'select_from_array',
                    'options'     => ['6' => '2 foto per riga', '4' => '3 foto per riga', '3' => '4 foto per riga' ],
                    'allows_null' => false,
                    'default'     => '4',
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

            } // fINE PERSO TEMA CORPORATE1





            $this->crud->addField([
                'name'        => 'col',
                'label'   => 'Seleziona il numero di colonne',
                'type'        => 'select_from_array',
                'options'     => ['1' => '1 foto per riga', '2' => '2 foto per riga', '3' => '3 foto per riga', '4' => '4 foto per riga', '5' => '5 foto per riga' ],
                'allows_null' => false,
                'default'     => '3',
                'wrapper' => ['class' => 'form-group col-md-6']
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



            // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
            if(env('TEMA') == 'Webshop' ) {

                $this->crud->addField([   // select_from_array
                    'name' => 'style',
                    'label' => "Seleziona effetto zoom (solo per template predefinito)",
                    'type' => 'select_from_array',
                    'options' => [
                        0 => 'Senza effetto',
                        1 => 'Zoom In #1',
                        2 => 'Zoom In #2',
                        3 => 'Zoom Out #1',
                        4 => 'Zoom Out #2',
                        5 => 'Slide',
                        6 => 'Rotate',
                        7 => 'Blur',
                        8 => 'Gray Scale',
                        9 => 'Sepia',
                        10 => 'Blur + Gray Scale',
                        11 => 'Opacity #1',
                        12 => 'Opacity #2',
                        13 => 'Flashing',
                        14 => 'Shine',
                        15 => 'Circle'],
                    'allows_null' => false,
                    'default' => 0,
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapper' => ['class' => 'form-group col-md-6']
                ]);

            } // fINE PERSO TEMA WEBSHOP


            $this->crud->addField([   // repeatable
                'name'  => 'color_title',
                'label' => 'Colore titolo',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bgcolor',
                'label' => 'Colore sfondo box gallery',
                'type'  => 'color_picker2',
                'default' => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pt',
                'label' => 'Margine superiore: imposta un valore numerico (Esempio: 0 nullo, 2 normale - 5 massimo)',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pb',
                'label' => 'Margine inferiore: imposta un valore numerico (Esempio: 0 nullo, 2 normale - 5 massimo)',
                'type'  => 'text',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'text_align',
                'label'       => "Allineamento titolo",
                'type'        => 'select_from_array',
                'options'     => ['left' => 'Sinistra', 'center' => 'Centrato'],
                'allows_null' => false,
                'default'     => 'center',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);


            $this->crud->addField([   // select_from_array
                'name'        => 'style2',
                'label'       => "Seleziona uno stile (Non disponibile per il template predefinito)",
                'type'        => 'select_from_array',
                'options'     => [
                    1 => 'Style 1: Effetto Zoom-In (Da usare se caricate immagini scattate solo in orizzontale)',
                    2 => 'Style 2: Effetto Fade+Icona Lente (Da usare se caricate immagini scattate solo in orizzontale)',
                    3 => 'Style 3: Effetto Fade+Movimento (Da usare se caricate immagini scattate solo in orizzontale)',
                    4 => 'Style 4: Effetto Zoom-In (NB: Da usare se caricate immagini scattate in verticale e orizzontale)',
                ],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
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
                'label' => 'Immagine',
                'type'  => 'browse'
            ]);

            /*$this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link pulsante",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);


            /*$this->crud->addField([   // color_picker
                'label'                => 'Background Color',
                'name'                 => 'background_color',
                'type'                 => 'color_picker',
                'default'              => '#000000',

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
            // aggiungere gli input di settaggio blocco da memorizzare. altrimenti in admin non li salva
            $this->crud->entry->name = $request->get('name');
            $this->crud->entry->col = $request->get('col');
            $this->crud->entry->pt = $request->get('pt');
            $this->crud->entry->pb = $request->get('pb');
            $this->crud->entry->bgcolor = $request->get('bgcolor');
            $this->crud->entry->color_title = $request->get('color_title');
            $this->crud->entry->text_align = $request->get('text_align');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->style2 = $request->get('style2');
            $this->crud->entry->fullwidth = $request->get('fullwidth');
            $this->crud->entry->is_pagination = $request->get('is_pagination');
            $this->crud->entry->number_pagination = $request->get('number_pagination');

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
        $lft = BlockGallery::whereNotNull("block_id")
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

        $list = BlockGallery::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
