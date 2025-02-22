<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockImageRequest;
use App\Http\Requests\BlockVideobgRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockVideobgCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockVideobgCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "blockVideobg";

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockVideobg::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockVideobg');
        CRUD::setEntityNameStrings('Blocco video BG', 'Blocchi video BG');
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
        CRUD::setValidation(BlockVideobgRequest::class);

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

        $this->crud->addField([
            'name'  => 'video',
            'label' => 'Incolla l\'url del Video Youtube (Es: https://www.youtube.com/watch?v=0123456 )',
            'type'  => 'text',
           //'youtube_api_key' => 'AIzaSycLRoVwovRmbIf_BH3X12IcTCudAErRlCE',
        ]);

        $this->crud->addField([   // radio
            'name'        => 'controls', // the name of the db column
            'label'       => 'Mostra pulsanti Player?', // the input label
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => "No",
                1 => "Si",
            ],
            'default'     => '0',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // radio
            'name'        => 'autoplay', // the name of the db column
            'label'       => 'Attiva Autoplay?', // the input label
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => "No",
                1 => "Si",
            ],
            'default'     => '1',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);

        $this->crud->addField([   // radio
            'name'        => 'mute', // the name of the db column
            'label'       => 'Attiva il mute?', // the input label
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => "No",
                1 => "Si",
            ],
            'default'     => '1',
            'wrapper' => ['class' => 'form-group col-md-4']
        ]);


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

        if($request->has('name')){
            // gli input di settaggio blocco da memorizzare
            $this->crud->entry->autoplay = $request->get('autoplay');
            $this->crud->entry->controls = $request->get('controls');
            $this->crud->entry->mute = $request->get('mute');

            $this->crud->entry->save();
        }

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
