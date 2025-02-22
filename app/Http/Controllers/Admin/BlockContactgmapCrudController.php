<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlockContactgmapRequest;
use App\Http\Requests\BlockFlussoRequest;
use App\Models\BlockContactgmap;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BlockContactgmapCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlockContactgmapCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public $block = "blockContactgmap";
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlockContactgmap::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blockContactgmap');
        CRUD::setEntityNameStrings('Blocco Testo contatti e Mappa', 'Blocchi Testo contatti e Mappa');

        $this->crud->setListView('vendor.backpack.base.custom_list_multi');
        $this->crud->setReorderView('vendor.backpack.base.custom_reorder_multi');
        $this->crud->setCreateView('vendor.backpack.base.custom_create_multi');

        if(request()->has('block_id')){
            $this->crud->query->where("block_id", request()->get('block_id'));
        }

        $this->crud->query->orderBy("lft", "asc");

        $this->crud->isReorderEnabled();
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'address1');
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

            /* Qui dichiaro quali input voglio vedere nella tabella, quando clicco su lista per aggiungere o modificare i record del blocco */

            [
                'name'  => 'address1',
                'label' => 'Titolo',
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
        CRUD::setValidation(BlockContactgmapRequest::class);

        /* Qui ci vanno gli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        if(request()->has('multi')){

            $this->crud->addField([   // repeatable
                'name'  => 'name',
                'label' => 'Nome blocco',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            // Permette di scegliere uno o stili di un blocco (parte html)
            $this->crud->addField([   // select_from_array
                'name'        => 'style',
                'label'       => "Seleziona lo style",
                'type'        => 'select_from_array',
                'options'     => [1 => 'Usa la Google Map', 2 => 'Non usare la Google Map - Usa foto a sinistra', 3 => 'Usa solo indirizzo, links social e vari'],
                'allows_null' => false,
                'default'     => 1,
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes' => ['class' => 'form-group col-md-6']
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'margin_top',
                'label' => 'Imposta un margine alto in Pixel (es: 50)',
                'type'  => 'text',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-6'],
                'default' => '50'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'margin_bottom',
                'label' => 'Imposta un margine basso in Pixel (es: 50)',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'default' => '50'
            ]);


            /* FINE degli input che vedo quando modifica il nome del blocco - gli input tecnici no moltiligua */

        }else{

            /* Qui invece ci vanno gli input che non devono essere tradotti in multilingua */
            /* Perchè il resto dei input multilingua li dichiaro nel file app/Model/blocks/nomeblocco.php */

            $this->crud->addField([   // repeatable
                'name'  => 'address1',
                'label' => 'Indirizzo (Riga 1)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);
            $this->crud->addField([   // repeatable
                'name'  => 'address2',
                'label' => 'Indirizzo (Riga 2)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'address3',
                'label' => 'Indirizzo (Riga 3)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'phone1',
                'label' => 'Telefono 1',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'phone2',
                'label' => 'Telefono 2',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'phone3',
                'label' => 'Telefono 3',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'fax',
                'label' => 'Fax',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'whatsapp',
                'label' => 'WhatsApp (Rispetta il formato seguente: 393472349421)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'facebook',
                'label' => 'URL pagina Facebook',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'instagram',
                'label' => 'URL pagina Instagram',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'linkedin',
                'label' => 'URL pagina LinkedIn',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'email1',
                'label' => 'Email 1',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'email2',
                'label' => 'Email 2',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'email3',
                'label' => 'Email 3',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'pec',
                'label' => 'PEC',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'orari',
                'label' => 'Orari di apertura',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'come_raggiungerci',
                'label' => 'Come raggiungerci (ES: incolla url di Google map)',
                'type'  => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'bg_box',
                'label' => 'Colore di Sfondo',
                'type'  => 'color_picker',
                //'default' => '#ffffff',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'color_txt',
                'label' => 'Colore testo (Colore Icone, Testo, Titoletto e Titolo)',
                'type'  => 'color_picker',
                //'default' => '#000000',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'url',
                'label' => 'Incolla qui l\'URL della Mappa (<a href="https://www.google.it/maps?hl=it" target="_blank">Apri Google Maps</a>)',
                'type'  => 'textarea',
                'default' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d179218.42332672668!2d11.240318256453511!3d45.42369820000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8c3d4cf7e9eeb781!2sWebisland%20-%20Creazione%20siti%20web%20%26%20E-Commerce!5e0!3m2!1sit!2sit!4v1638978118249!5m2!1sit!2sit',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);

            $this->crud->addField([   // Browse
                'name'  => 'foto',
                'label' => 'Foto (nel caso non vuoi utilizzare la Google Map)',
                'type'  => 'browse'
            ]);

            $this->crud->addField([   // repeatable
                'name'  => 'height_gmap',
                'label' => 'Altezza contenitore Testo e Mappa in Pixel (es: 500px)',
                'type'  => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-12']
            ]);


            /* FINE degli input che vedo quando aggiungo le righe al blocco multilingua */


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

    /***************************** questa è la funzione per il salvataggio ****************************/
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
            $this->crud->entry->margin_top = $request->get('margin_top');
            $this->crud->entry->margin_bottom = $request->get('margin_bottom');
            $this->crud->entry->style = $request->get('style');

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

        // Questo serve per evitare di fare il riordina ad ogni nuovo record aggiunto
        $lft = BlockContactgmap::orderBy("lft", "desc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft + 2;
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }
}
