<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopShippingsRequest;
use App\Models\Area;
use App\Models\Shipping;
use App\Models\ShippingArea;
use App\Models\ShippingRange;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopShippingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopShippingsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $block = "shopShipping";

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        if(in_array(backpack_user()->roles[0]->id, [4,5,6,7,8,9])){
            die;
        }

        CRUD::setModel(\App\Models\ShopShippings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopShippings');
        CRUD::setEntityNameStrings('spedizione', 'spedizioni');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('show');

        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => 'Nome',
            ],
            [
                'name'  => 'delay_description',
                'label' => 'Ritardo',
            ],
            [
                'name' => 'is_active',
                'label' => 'Attivo',
                'type' => 'boolean',
                // optionally override the Yes/No texts
                //'options' => [0 => 'Non attivo', 1 => 'Attivo']
            ],
            [
                'name' => 'is_send_email',
                'label' => 'Invio Email',
                'type' => 'boolean',
                // optionally override the Yes/No texts
                //'options' => [0 => 'Non attivo', 1 => 'Attivo']
            ],
            [
                'name' => 'is_contrassegno',
                'label' => 'Contrassegno',
                'type' => 'boolean',
                // optionally override the Yes/No texts
                //'options' => [0 => 'Non attivo', 1 => 'Attivo']
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
        CRUD::setValidation(ShopShippingsRequest::class);

        $zone = Area::with("countries")->get();
        $typeShip = "di prezzo";

        $parameters = \Route::current()->parameters();
        if(count($parameters)){
            $shippingID = (int) $parameters['id'];
            $shipItem = Shipping::find($shippingID);
            if($shipItem->type_ship == 0){
                $typeShip = "di prezzo";
            }else{
                $typeShip = "di peso";
            }
        }

        //<th></th>
        $html = "<table class='table table-sm table-bordered'><thead><tr><th>Zona</th><th>Fasce di {$typeShip}</th></tr></thead>";
        if($zone){
            foreach ($zone as $zona){
                $shippingZone = null;
                $checkedZone = "";
                $htmlRange = "";
                if(count($parameters)){
                    $shippingZone = ShippingArea::where("shipping_id", $shippingID)
                        ->where("area_id", $zona->id)->first();

                    if($shippingZone){
                        $checkedZone = "checked";
                    }

                    $checkedZone = "checked";

                    $shippingRange = ShippingRange::where("shipping_id", $shippingID)
                        ->where("area_id", $zona->id)->get();
                    if($shippingRange){
                        foreach ($shippingRange as $item){
                            $htmlRange .= "<tr id='old-{$item->id}'>
                                <td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>Da</span></div> <input type='text' class='form-control' name='min[{$item->area_id}][]' size='10' value='{$item->min}'></div></td>
                                <td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>A</span></div> <input type='text' class='form-control' name='max[{$item->area_id}][]' size='10' value='{$item->max}'></div></td>
                                <td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>&euro;</span></div> <input type='text' class='form-control' name='price[{$item->area_id}][]' size='10' value='{$item->price}'></div></td>
                                <td><a class='btn btn-primary' href='javascript:delete_range(\"old\", {$item->id})'><i class='las la-trash'></i></a></td>
                                </tr>";
                        }
                    }
                }

                //  <td><input type='hidden' name='area[]' value='{$zona->id}' {$checkedZone}></td>

                $html .= "<tr>
                            <td class='align-middle'><div class='d-flex justify-content-between'>{$zona->name} <input type='hidden' name='area[]' value='{$zona->id}' {$checkedZone}>
                            <a class='btn btn-sm btn-outline-primary' href='javascript:add_range({$zona->id})'><i class='las la-plus'></i></a></div>
                            </td>";
                $html .= "<td class='align-middle'>
                            <table class='table table-sm my-0' id='zona-{$zona->id}'>
                            $htmlRange
                            </tr>
                            </table>
                        </td>";
                $html .= "</tr>";
            }
        }
        $html .= "</table>";


        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Nome',
                'type'  => 'text',
                'tab' => 'Generale'
            ],
            [
                'name'  => 'delay_description',
                'label' => 'Testo Ritardo',
                'type'  => 'text',
                'tab' => 'Generale'
            ],
            [   // Checkbox
                'name' => 'is_active',
                'label' => 'Attivo',
                'type' => 'switch',
                'tab' => 'Generale',
                'wrapper' => ['class' => 'form-group col-md-4']
            ],
            [   // Checkbox
                'name' => 'is_send_email',
                'label' => 'Invio automatico email dopo cambio stato',
                'type' => 'switch',
                'tab' => 'Generale',
                'wrapper' => ['class' => 'form-group col-md-4']
            ],
            /*[   // Checkbox
                'name' => 'is_free',
                'label' => 'Spedizione gratuita?',
                'type' => 'checkbox',
                'tab' => 'Generale'
            ],*/
            [   // Checkbox
                'name' => 'is_contrassegno',
                'label' => 'Spedizione in contrassegno?',
                'type' => 'switch',
                'tab' => 'Generale',
                'wrapper' => ['class' => 'form-group col-md-4']
            ],
            [ // select_from_array
                'name' => 'type_ship',
                'label' => "Tipo spedizione",
                'type' => 'select_from_array',
                'options' => [0 => "In base al prezzo totale", 1 => "In base al peso totale"],
                'allows_null' => false,
                'default' => 0,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'tab' => 'Generale'
            ],

        ]);

        if(count($parameters)) {
            $this->crud->addField([   // CustomHTML
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => $html,
                'tab' => 'Zone'
            ], "update");
        }


        $trans = new AdminLanguageController();
        $trans->fields_lang($this->block, $this->crud);

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

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $area = $request->input('area');
        $min = $request->input('min');
        $max = $request->input('max');
        $price = $request->input('price');
        $shippingID = $this->crud->entry->id;

        ShippingArea::where("shipping_id", $shippingID)->delete();
        if($area) {
            ShippingRange::where("shipping_id", $shippingID)->delete();
            foreach ($area as $value){
                $last = ShippingArea::orderBy("id", "desc")->first();
                if(!$last){
                    $id = 1;
                }else{
                    $id = $last->id + 1;
                }

                if($min === null){
                    continue;
                }

                if(key_exists($value, $min)){
                    ShippingArea::insert([
                        "id" => $id,
                        "shipping_id" => $shippingID,
                        "area_id" => $value
                    ]);

                    foreach ($min[$value] as $k=>$v){
                        $last = ShippingRange::orderBy("id", "desc")->first();
                        if(!$last){
                            $id = 1;
                        }else{
                            $id = $last->id + 1;
                        }

                        ShippingRange::insert([
                            "id" => $id,
                            "shipping_id" => $shippingID,
                            "area_id" => $value,
                            "min" => $v,
                            "max" => $max[$value][$k],
                            "price" => $price[$value][$k]
                        ]);
                    }
                }

            }
        }

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }


    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang($this->block, $this->crud, $request);
        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
