<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminLanguageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AdminLanguageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminLanguageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        $this->crud->query->where("is_active", "1");
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }

    public function setup()
    {
        if(backpack_user()->roles[0]->id != 1){
            die;
        }

        CRUD::setModel(\App\Models\AdminLanguage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/adminLanguage');
        CRUD::setEntityNameStrings('lingua', 'Lingue');

        $this->crud->query->orderBy("lft", "asc");
        $this->crud->isReorderEnabled();
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
                'name'  => 'label',
                'label' => 'Lingua',
                'type'  => 'text',
            ],
            [
                'name'  => 'name',
                'label' => 'Lingua',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_active',
                'label' => 'Attivo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsActive', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_frontend',
                'label' => 'Sito', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsFrontend', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
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
        CRUD::setValidation(AdminLanguageRequest::class);

        $this->crud->addField([
            'name' => 'label',
            'label' => "Nome Lingua",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => "Lingua",
            'type' => 'text',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Lingua attiva in admin?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_frontend',
            'label' => 'Lingua attiva nel sito?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
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

        return 'success for '.$count.' items';
    }
}
