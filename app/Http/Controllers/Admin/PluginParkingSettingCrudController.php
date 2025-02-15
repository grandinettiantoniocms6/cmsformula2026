<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginParkingSettingRequest;
use App\Models\PluginParkingHoliday;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class PluginParkingSettingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginParkingSettingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PluginParkingSetting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-parking-setting');
        CRUD::setEntityNameStrings('Impostazioni', 'Impostazioni');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('create');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('show');

        //CRUD::setFromDb(); // columns

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
        CRUD::setValidation(PluginParkingSettingRequest::class);


        $this->crud->addField([
            'label' => "Totale posti parcheggio SCOPERTO",
            'name' => "total_park_scoperto",
            'type'  => 'number',
        ]);

        $this->crud->addField([
            'label' => "Totale posti parcheggio COPERTO",
            'name' => "total_park_coperto",
            'type'  => 'number',
        ]);

        $this->crud->addField([
            'label' => "Euro aggiuntivi dopo max giorni parcheggio SCOPERTO",
            'name' => "euro_park_scoperto",
            'type'  => 'text',
        ]);

        $this->crud->addField([
            'label' => "Euro aggiuntivi dopo max giorni parcheggio COPERTO",
            'name' => "euro_park_coperto",
            'type'  => 'text',
        ]);

        $this->crud->addField([
            'label' => "Email per notifiche",
            'name' => "email",
            'type'  => 'email',
        ]);

        $this->crud->addField([
            'label' => "Email in copia per notifiche (dividere con virgola)",
            'name' => "ccn_email",
            'type'  => 'text',
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

    public function save_holidays(Request $request){
        $button = $request->get('button');
        $days = $request->get('days');
        $motivation = $request->get('motivation');

        if($days){
            foreach ($days as $day){
                $check = PluginParkingHoliday::where("day", $day)->first();
                if($check){
                    if($button == "open"){
                        $check->delete();
                    }else{
                        $check->motivation = $motivation;
                        $check->save();
                    }
                }else{
                    if($button == "close"){
                        PluginParkingHoliday::insert([
                           "day" => $day,
                           "motivation" => $motivation
                        ]);
                    }
                }
            }
        }

        \Alert::success("Dati salvati con successo")->flash();

        return redirect()->back();
    }

    public function sync(){
        \Alert::success("Sincronizzato con successo")->flash();

        \Artisan::call('import:parkos');

        return redirect()->back();
    }
}
