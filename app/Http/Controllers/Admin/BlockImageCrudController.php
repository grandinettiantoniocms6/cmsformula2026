<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockImageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "blockImage";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockImage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$this->block);
        CRUD::setEntityNameStrings('blocco Header', 'blocchi Headers');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton("show");
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
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
            ],
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
        CRUD::setValidation(BlockImageRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => "Nome",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


       /* Commento upload+crop
       $this->crud->addField([
            'label' => "Foto",
            'name' => "foto",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);
       */

        $this->crud->addField([   // Browse
            'name'  => 'foto',
            'label' => 'Immagine Header',
            'type'  => 'browse',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'foto_mobile',
            'label' => '* Immagine Header su SmartPhone | * Solo per Template Webshop',
            'type'  => 'browse'
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'height_header',
            'label' => 'Altezza immagine Header in pixel (es: 350px)',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'alpha',
            'label' => '* Effetto trasparenza (00 nulla - 40 leggera - 80 pesante)',
            'type'  => 'number',
            'default' => '00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'bgcolor',
            'label' => 'Oppure seleziona un colore di Sfondo',
            'type'  => 'color_picker',
            'default' => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

                    // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                    if(env('TEMA') == 'Webshop' ) {

                        $this->crud->addField([   // select_from_array
                            'name' => 'style',
                            'label' => "Seleziona uno stile",
                            'type' => 'select_from_array',
                            'options' => [1 => 'Style 1', 2 => 'Style 2', 3 => 'Style 3'],
                            'allows_null' => false,
                            'default' => 1,
                            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                            'wrapperAttributes' => ['class' => 'form-group col-md-6']
                        ]);


                    }

                    // CAMPI VISUALIZZATI SOLO CON IL TEMA CORPORATE1//////////////////
                    if(env('TEMA') == 'Corporate1' ) {

                        $this->crud->addField([   // select_from_array
                            'name' => 'style',
                            'label' => "Seleziona uno stile",
                            'type' => 'select_from_array',
                            'options' => [1 => 'Style 1'],
                            'allows_null' => false,
                            'default' => 1,
                            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                            'wrapperAttributes' => ['class' => 'form-group col-md-6']
                        ]);



                    } // END CORPORATE1


        $this->crud->addField([   // select_from_array
            'name' => 'style',
            'label' => "Seleziona uno stile",
            'type' => 'select_from_array',
            'options' => [1 => 'Style 1', 2 => 'Style 2', 3 => 'Style 3', 4 => 'Style 4'],
            'allows_null' => false,
            'default' => 1,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);


        $this->crud->addField([   // select_from_array
            'name'        => 'text_align',
            'label'       => "* Allineamento Titolo e Sottotitolo | * Solo per Template Webshop",
            'type'        => 'select_from_array',
            'options'     => ['left' => 'Sinistra', 'right' => 'Destra', 'center' => 'Centrato'],
            'allows_null' => false,
            'default'     => 'left',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);


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

        return $this->crud->performSaveAction($item->getKey());
    }
}
