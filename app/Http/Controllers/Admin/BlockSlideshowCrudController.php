<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockSlideshowRequest;
use App\Models\BlockSlideshow;
use App\Models\Page;
use App\Models\PluginBookingType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockSlideshowCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockSlideshowCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockSlideshow";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockSlideshow::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$this->block);
        CRUD::setEntityNameStrings('slideshow', 'slideshow');

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
        CRUD::setValidation(BlockSlideshowRequest::class);

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
            ]);

                    // CAMPI VISUALIZZATI SOLO CON IL TEMA CRAFTO//////////////////
                    if(env('TEMA') == 'Crafto' ) {

                        $this->crud->addField([   // select_from_array
                            'name' => 'style',
                            'label' => "Seleziona uno style di slideshow",
                            'type' => 'select_from_array',
                            'options' => [
                                1 => 'Style 1: Immagini che scorrono con freccie laterali',
                                2 => 'Style 2: Immagini che scorrono con puntini di scorrimento in basso',
                                3 => 'Style 3: Sfondo a sinistra ed immagine a destra - (No Thumbs: dimensioni immagini 1200px x 1000px)',
                                4 => 'Style 4: Immagini a carosello quadrate scorrevoli con titolo, descrizione, pulsante e sfumatura fissa',
                                5 => 'Style 5: Immagine fissa con titolo, descrizione e pulsante'
                            ],
                            'allows_null' => false,
                            'default' => 1,
                            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                            'wrapperAttributes' => ['class' => 'form-group col-md-6']
                        ]);

                        $this->crud->addField([   // repeatable
                            'name'  => 'alpha',
                            'label' => 'Filigrana (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
                            'type'  => 'number',
                            'wrapperAttributes' => [
                                'class' => 'form-group col-md-6'
                            ],
                        ]);

                    } // fine perso input Crafto



                    // CAMPI VISUALIZZATI SOLO CON IL TEMA CORPORATE1 //////////////////
                    if(env('TEMA') == 'Corporate1' ) {
                            $this->crud->addField([   // select_from_array
                                'name' => 'style',
                                'label' => "Seleziona uno style di slideshow",
                                'type' => 'select_from_array',
                                'options' => [
                                    1 => 'Style 1: Immagini che scorrono con freccie laterali',

                                ],
                                'allows_null' => false,
                                'default' => 1,
                                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                                'wrapperAttributes' => ['class' => 'form-group col-md-6']
                            ]);


                    } // fine perso input Corporate1

////////// SETTAGGI VISIBILE SU TUTTI I TEMPLATE \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            $this->crud->addField([   // repeatable
                'name'  => 'slide_height',
                'label' => 'Altezza immagini slideshow su PC in pixel (es: 350px)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'slide_height_mobile',
                'label' => 'Altezza immagini slideshow su Mobile in pixel (es: 350px)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // select_from_array
                'name'        => 'effect',
                'label'       => "Seleziona un effetto slide",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ['slide' => 'Slide', 'fade' => 'Fade', 'cube' => 'Cube', 'coverflow' => 'Coverflow', 'flip' => 'Flip', 'creative' => 'Creative' ],
                'allows_null' => false,
                'default'     => 'slide',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);




                    // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                    if(env('TEMA') == 'Webshop' ){

                        $this->crud->addField([   // repeatable
                            'name'  => 'slide_height',
                            'label' => 'Altezza immagini slideshow su PC in pixel (es: 350px)',
                            'type'  => 'text',
                            'wrapperAttributes' => [
                                'class' => 'form-group col-md-6'
                            ],
                        ]);

                        $this->crud->addField([   // repeatable
                            'name'  => 'slide_height_mobile',
                            'label' => 'Altezza immagini slideshow su Mobile in pixel (es: 350px)',
                            'type'  => 'text',
                            'wrapperAttributes' => [
                                'class' => 'form-group col-md-6'
                            ],
                        ]);

                        $this->crud->addField([   // select_from_array
                            'name'        => 'style',
                            'label'       => "Seleziona layout da Template",
                            'type'        => 'select_from_array',
                            'attributes' => [
                                'class'       => 'custom-select',
                            ],
                            'options'     => [1 => 'Style 1', 2 => 'Style 2', 3 => 'Style 3' ],
                            'allows_null' => false,
                            'default'     => 1,
                            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                            'wrapperAttributes' => ['class' => 'form-group col-md-6']
                        ]);

                        $this->crud->addField([   // repeatable
                            'name'  => 'alpha',
                            'label' => 'Filigrana (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
                            'type'  => 'number',
                            'wrapperAttributes' => [
                                'class' => 'form-group col-md-6'
                            ],
                        ]);

                        $this->crud->addField([   // select_from_array
                        'name'        => 'animate_in',
                        'label'       => "Animazione ingresso",
                        'type'        => 'select_from_array',
                        'attributes' => [
                            'class' => 'custom-select',
                        ],
                        'options'     => [
                            'animate__fadeIn' => 'fadeIn',
                            'animate__fadeInDown' => 'fadeInDown',
                            'animate__fadeInLeft' => 'fadeInLeft',
                            'animate__slideInUp' => 'slideInUp',
                            'animate__zoomIn' => 'ZoomIn'
                        ],
                        'allows_null' => false,
                        'default'     => 'animate__fadeIn',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([   // select_from_array
                        'name'        => 'animate_out',
                        'label'       => "Animazione uscita",
                        'type'        => 'select_from_array',
                        'attributes' => [
                            'class' => 'custom-select',
                        ],
                        'options'     => [
                            'animate__fadeOut' => 'fadeOut',
                            'animate__fadeOutDown' => 'fadeOutDown',
                            'animate__fadeOutLeft' => 'fadeOutLeft',
                            'animate__slideOutUp' => 'slideOutUp',
                            'animate__zoomOut' => 'ZoomOut'
                        ],
                        'allows_null' => false,
                        'default'     => 'animate__fadeOut',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'border_color',
                        'label' => 'Colore bordo',
                        'type'  => 'color_picker2',
                        // optional
                        'default' => null,
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'wrapperAttributes' => ['class' => 'form-group col-md-6']
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'thickness_border',
                        'label' => 'Spessore bordo su PC in pixel (es: 40px)',
                        'type'  => 'text',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'thickness_border_mobile',
                        'label' => 'Spessore bordo su Mobile in pixel (es: 20px)',
                        'type'  => 'text',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);


                    $this->crud->addField([   // select_from_array
                        'name'        => 'effect',
                        'label'       => "Seleziona un effetto slide",
                        'type'        => 'select_from_array',
                        'attributes' => [
                            'class' => 'custom-select',
                        ],
                        'options'     => ['slide' => 'Slide', 'fade' => 'Fade', 'cube' => 'Cube', 'coverflow' => 'Coverflow', 'flip' => 'Flip', 'creative' => 'Creative' ],
                        'allows_null' => false,
                        'default'     => 'slide',
                        // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                        'wrapperAttributes' => ['class' => 'form-group col-md-6']
                    ]);

                        $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
                        if($adminPluginBooking){
                            $this->crud->addField([   // repeatable
                                'name'  => 'is_search_booking',
                                'label' => 'Barra di ricerca BOOKING visibile?',
                                'type'  => 'switch',
                            ]);

                            $types = PluginBookingType::get()->pluck("name", "id")->toArray();
                            $this->crud->addField([   // select2_from_array
                                'name'        => 'booking_type_id',
                                'label'       => "Tipologia prenotazione",
                                'type'        => 'select2_from_array',
                                'options'     => $types,
                                'allows_null' => false,
                                'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
                            ]);

                            $this->crud->addField([   // repeatable
                                'name'  => 'form_booking_bgcolor',
                                'label' => 'Colore sfondo form Booking',
                                'type'  => 'color_picker2',
                                // optional
                                //'default' => '#1ab42f',
                                'color_picker_options' => ['customClass' => 'custom-class'],
                                'wrapperAttributes' => ['class' => 'form-group col-md-4']
                            ]);

                            $this->crud->addField([   // repeatable
                                'name'  => 'form_booking_border_color',
                                'label' => 'Colore bordo form Booking',
                                'type'  => 'color_picker2',
                                // optional
                                //'default' => '#1ab42f',
                                'color_picker_options' => ['customClass' => 'custom-class'],
                                'wrapperAttributes' => ['class' => 'form-group col-md-4']
                            ]);

                            $this->crud->addField([   // repeatable
                                'name'  => 'form_booking_border_radius',
                                'label' => 'Arrotondamento Bordo (es: 20px)',
                                'type'  => 'text',
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-4'
                                ],
                            ]);

                            $this->crud->addField([   // repeatable
                                'name'  => 'form_booking_border_width',
                                'label' => 'Spessore Bordo (es: 5px)',
                                'type'  => 'text',
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-4'
                                ],
                            ]);

                            $this->crud->addField([   // repeatable
                                'name'  => 'form_booking_top',
                                'label' => 'Distaza dal margine basso (es: 300px)',
                                'type'  => 'text',
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-4'
                                ],
                            ]);

                        }

                    } // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP




        }else{

            /*$this->crud->addField([
                'label' => "Foto",
                'name' => "foto",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);*/

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Immagine per PC',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto_mobile',
                'label' => 'Immagine per dispositivi mobili',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'title_background',
                'label' => 'Colore Titolo',
                'type'  => 'color_picker2',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);



                    // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                    if(env('TEMA') == 'Crafto' ){

                        $this->crud->addField([   // repeatable
                            'name'  => 'left_bgcolor',
                            'label' => 'Colore sfondo a sinistra',
                            'type'  => 'color_picker2',
                            // optional
                            'color_picker_options' => ['customClass' => 'custom-class'],
                            'wrapperAttributes' => [
                                'class' => 'form-group col-md-6'
                            ],
                        ]);


                    } // Fine PERSO WEBSHOP





                    // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                    if(env('TEMA') == 'Webshop' ){

                    $this->crud->addField([   // select_from_array
                        'name'        => 'text_align',
                        'label'       => "Allineamento Titolo e Sottotitolo",
                        'type'        => 'select_from_array',
                        'attributes' => [
                            'class' => 'custom-select',
                        ],
                        'options'     => ['1' => 'In alto a sinistra', '2' => 'In alto al Centro', '3' => 'In alto a destra', '4' => 'In centro a sinistra', '5' => 'In centro al centro', '6' => 'In centro a destra', '7' => 'In basso a sinistra', '8' => 'In basso al centro', '9' => 'In basso a destra'],
                        'allows_null' => false,
                        'default'     => '4',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([   // Checkbox
                        'name'  => 'is_alphabg',
                        'label' => 'Attiva sfondo Titolo e Sottotitolo?',
                        'type'  => 'switch',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-12'
                        ]
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'bgcolor',
                        'label' => 'Colore di sfondo Titolo e Sottotitolo',
                        'type'  => 'color_picker2',
                        // optional
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'alpha_bgtext',
                        'label' => 'Trasparenza sfondo Titolo e Sottotitolo (00 nulla - 10 leggera - 90 pesante - tra 20 e 80 custom)',
                        'type'  => 'number',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                        'attributes' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 10,
                        ],
                        'default' => 0
                    ]);

                    $this->crud->addField([   // repeatable
                        'name'  => 'padding',
                        'label' => 'Specificare il padding del box titolo e sottotitolo (Esempio: 10px 5px 5px 10px)',
                        'type'  => 'text',
                        'default' => '30px 30px 30px 30px',
                        'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                    ]);


                    }
                    // FINE CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP






            $this->crud->addField([   // select_from_array
                'name'        => 'type_href',
                'label'       => "Apertura link pulsante",
                'type'        => 'select_from_array',
                'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
                'allows_null' => false,
                'default'     => '_self',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
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
            // qui se serve metto i nuovi campi
            //$this->crud->entry->col = $request->get('col');
            $this->crud->entry->is_search_booking = $request->get('is_search_booking');
            $this->crud->entry->booking_type_id = $request->get('booking_type_id');
            $this->crud->entry->animate_out = $request->get('animate_out');
            $this->crud->entry->slide_height = $request->get('slide_height');
            $this->crud->entry->animate_in = $request->get('animate_in');
            $this->crud->entry->alpha = $request->get('alpha');
            $this->crud->entry->style = $request->get('style');
            $this->crud->entry->effect = $request->get('effect');
            $this->crud->entry->thickness_border = $request->get('thickness_border');
            $this->crud->entry->border_color = $request->get('border_color');
            $this->crud->entry->slide_height_mobile = $request->get('slide_height_mobile');
            $this->crud->entry->thickness_border_mobile = $request->get('thickness_border_mobile');
            $this->crud->entry->form_booking_bgcolor = $request->get('form_booking_bgcolor');
            $this->crud->entry->form_booking_top = $request->get('form_booking_top');
            $this->crud->entry->form_booking_border_radius = $request->get('form_booking_border_radius');
            $this->crud->entry->form_booking_border_color = $request->get('form_booking_border_color');
            $this->crud->entry->form_booking_border_width = $request->get('form_booking_border_width');

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
        $lft = BlockSlideshow::whereNotNull("block_id")
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

        $list = BlockSlideshow::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
