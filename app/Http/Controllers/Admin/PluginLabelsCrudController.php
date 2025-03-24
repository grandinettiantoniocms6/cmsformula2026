<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginLabelsRequest;
use App\Models\PluginInterventions;
use App\Models\PluginLabels;
use App\Models\PluginLabelsSettings;
use App\Models\PluginProducts;
use App\Models\Tax;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginLabelsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginLabelsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginLabels::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plugin-labels');
        CRUD::setEntityNameStrings('etichetta', 'etichette');

        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        $this->crud->setListView('vendor.backpack.base.plugins.pluginLabels.list');
        $this->crud->setEditView('vendor.backpack.base.plugins.pluginLabels.edit');
        $this->crud->setCreateView('vendor.backpack.base.plugins.pluginLabels.create');
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
                'name'  => 'title',
                'label' => 'Titolo',
                'type'  => 'text',
            ],
            [
                'name'  => 'created_at',
                'label' => 'Data creazione',
                'type'  => 'datetime',
            ],
            [
                'name'  => 'format',
                'label' => 'Formato',
                'type'  => 'text',
            ],
            [
                'name'  => 'lang',
                'label' => 'Lingua',
                'type'  => 'text',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PluginLabelsRequest::class);
        $parameters = \Route::current()->parameters();

        $item = null;
        if(count($parameters)){
            $item = \App\Models\PluginLabels::where("id", $parameters['id'])->first();
        }

        $products = PluginProducts::selectRaw("name,id")->pluck("name", "id")->toArray();
        $this->crud->addField([   // select2_from_array
            'name'        => 'plugin_product_id',
            'label'       => "Prodotto",
            'type'        => 'select2_from_array',
            'options'     => $products,
            'allows_null' => true,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $options = ["mini" => "Piccolo", "medium" => "Medio", "large" => "Grande"];
        $this->crud->addField([   // select2_from_array
            'name'        => 'format',
            'label'       => "Formato",
            'type'        => 'select2_from_array',
            'options'     => $options,
            'allows_null' => false,
            'default'     => "mini",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $options = ["it" => "Italiano", "en" => "Inglese", "it/en" => "Italiano/Inglese"];
        $this->crud->addField([   // select2_from_array
            'name'        => 'lang',
            'label'       => "Lingua",
            'type'        => 'select2_from_array',
            'options'     => $options,
            'allows_null' => false,
            'default'     => "it",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'number_elements',
            'label'       => "N.Elementi PDF",
            'type'        => 'number',
            'default'     => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'qrcode_link',
            'label' => 'QRCode Link',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'barcode',
            'label' => 'Barcode',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_product_lab',
            'label' => 'Prodotto in laboratorio',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_address_footer',
            'label' => 'Visualizza Indirizzo',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_logo_header',
            'label' => 'Visualizza Testata',
            'type'  => 'switch',
            'default' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
        ]);


        if(count($parameters)){
            $trans = new AdminLanguageController();
            $trans->fields_lang("pluginLabels", $this->crud, $item);
        }
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
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginLabels", $this->crud, $request);
        $this->crud->entry->save();


        if($request->get('plugin_product_id')){
            $product = \DB::table("plugins_products")->find($request->get('plugin_product_id'));
            if($product){
                $temp_title = json_decode($product->title_labels, true);
                $temp_desc = json_decode($product->description_labels, true);

                $item_temp = \DB::table("plugins_labels")->find($item->id);
                if($item_temp){
                    $temp_title2 = json_decode($item_temp->title, true);
                    $temp_desc2 = json_decode($item_temp->description, true);
                }

                if(count($temp_title2) && count($temp_title)){
                    foreach ($temp_title2 as $k=>$v){
                        if($v == null || trim($v) == ""){
                            $temp_title2[$k] = $temp_title[$k];
                        }
                    }

                    \DB::table("plugins_labels")->where("id", $item->id)->update([
                        "title" => json_encode($temp_title2)
                    ]);
                }

                if(count($temp_desc2) && count($temp_desc)){
                    foreach ($temp_desc2 as $k=>$v){
                        if($v == null || trim($v) == ""){
                            $temp_desc2[$k] = $temp_desc[$k];
                        }
                    }

                    \DB::table("plugins_labels")->where("id", $item->id)->update([
                        "description" => json_encode($temp_desc2)
                    ]);
                }
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->to("/admin/plugin-labels/$item->id/edit");
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginLabels", $this->crud, $request);
        $this->crud->entry->save();


        if($request->get('plugin_product_id')){
            $product = \DB::table("plugins_products")->find($request->get('plugin_product_id'));
            if($product){
                $temp_title = json_decode($product->title_labels, true);
                $temp_desc = json_decode($product->description_labels, true);

                $item_temp = \DB::table("plugins_labels")->find($item->id);
                if($item_temp){
                    $temp_title2 = json_decode($item_temp->title, true);
                    $temp_desc2 = json_decode($item_temp->description, true);
                }

                if(count($temp_title2) && count($temp_title)){
                    foreach ($temp_title2 as $k=>$v){
                        if($v == null || trim($v) == ""){
                            $temp_title2[$k] = $temp_title[$k];
                        }
                    }

                    \DB::table("plugins_labels")->where("id", $item->id)->update([
                        "title" => json_encode($temp_title2)
                    ]);
                }

                if(count($temp_desc2) && count($temp_desc)){
                    foreach ($temp_desc2 as $k=>$v){
                        if($v == null || trim($v) == ""){
                            $temp_desc2[$k] = $temp_desc[$k];
                        }
                    }

                    \DB::table("plugins_labels")->where("id", $item->id)->update([
                        "description" => json_encode($temp_desc2)
                    ]);
                }
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->to("/admin/plugin-labels/$item->id/edit");
    }

    public function preview($id)
    {
        $thema = env("TEMA");
        $thema = "Webshop";

        $setting = PluginLabelsSettings::first();
        $label = PluginLabels::find($id);

        $html = view("$thema.plugins.pluginLabels.preview", compact('setting', 'label'))->render();
        die($html);
    }

    // https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

    public function pdf($id)
    {
        $thema = env("TEMA");
        $thema = "Webshop";

        $setting = PluginLabelsSettings::first();
        $label = PluginLabels::find($id);
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'utf-8');
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-bottom', 5);
        $pdf->setOption('disable-smart-shrinking', true);


        $pdf->setPaper('A4', 'portrait');

        $html = view("$thema.plugins.pluginLabels.pdf", compact( 'setting', 'label'))->render();
        //die($html);

        $pdf->loadHTML($html);




        return $pdf->inline("Etichetta_$id.pdf");
        //return $pdf->download("Etichetta_$id.pdf");
    }
}
