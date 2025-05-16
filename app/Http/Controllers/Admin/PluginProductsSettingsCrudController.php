<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PluginProductsSettingsRequest;
use App\Models\AdminPlugin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PluginProductsSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PluginProductsSettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PluginProductsSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pluginProductsSettings');
        CRUD::setEntityNameStrings('impostazione', 'impostazioni');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(PluginProductsSettingsRequest::class);

        $trans = new AdminLanguageController();
        $trans->fields_lang("pluginProductsSettings", $this->crud);

        $this->crud->addField([
            'label' => "Foto",
            'name' => "image",
            'type'  => 'browse',
            'tab' => 'Generale',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        /*$this->crud->addField([
            'name'        => 'sidebar_position',
            'label'       => "Effetto Header",
            'type'        => 'select_from_array',
            'options'     => ["parallax" => "Parallax movimento", "fixed" => "Immagine bloccata"],
            'allows_null' => false,
            'default'     => "parallax",
            'tab' => "Generale"
        ]);*/

        $this->crud->addField([   // Checkbox
            'name'  => 'image_height',
            'label' => 'Altezza Header (Misure consigliate: min 200 max 600) in pixel',
            'type'  => 'number',
            'tab' => 'Generale'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'facebook_id_shop',
            'label' => 'ID Facebook Shop',
            'type'  => 'text',
            'tab' => 'Generale'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'dati_footer_pdf',
            'label' => 'Dati footer pdf',
            'type'  => 'text',
            'tab' => 'Generale'
        ]);

        $this->crud->addField([
            'name'  => 'number_product',
            'label' => 'N.prodotti x pagina DESKTOP',
            'type'  => 'number',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'number_product_mobile',
            'label' => 'N.prodotti x pagina MOBILE',
            'type'  => 'number',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'col_products_for_row',
            'label' => 'Numero colonne prodotti',
            'type'  => 'number',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([
            'name'  => 'show_banner',
            'label' => 'Visualizza banner sul mobile',
            'type'  => 'switch',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'order_field',
            'label'       => "Campo ordinamento",
            'type'        => 'select_from_array',
            'options'     => ['id' => 'ID', 'name' => 'Nome prodotto', 'lft' => "Ordine manuale"],
            'allows_null' => false,
            'default'     => 'name',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name'        => 'order_type',
            'label'       => "Tipo ordinamento",
            'type'        => 'select_from_array',
            'options'     => ['asc' => 'Crescente', 'desc' => 'Decrescente'],
            'allows_null' => false,
            'default'     => 'asc',
            'tab' => 'Generale',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version > 1){

            /*
            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 1',
                'name'                 => 'custom_color_1',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 2',
                'name'                 => 'custom_color_2',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);
            */

            $this->crud->addField([   // Checkbox
                'name'  => 'show_prices',
                'label' => 'Mostra il prezzo dei prodotti ai visitatori?',
                'type'  => 'switch',
                'tab' => 'Generale',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            if($adminPlugin->version == 3) {
                $this->crud->addField([   // Checkbox
                    'name' => 'is_price_on_demand',
                    'label' => 'Mostra il prezzo previa registrazione?',
                    'type' => 'switch',
                    'tab' => 'Generale',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'is_add_to_cart',
                    'label' => 'Mostra il Pulsante aggiungi al carrello anche per i visitatori?',
                    'type'  => 'switch',
                    'tab' => 'Generale',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'is_qty_infinite',
                    'label' => 'Quantità prodotti infinita?',
                    'type'  => 'switch',
                    'tab' => 'Generale',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                ]);
            }



            $this->crud->addField([   // Checkbox
                'name'  => 'show_quantities',
                'label' => 'Visualizza quantità prodotti?',
                'type'  => 'switch',
                'tab' => 'Generale',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'view_topbar_ecommerce',
                'label' => 'Visualizza Search Bar nella lista e nel dettaglio prodotti?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'categories_topbar_ecommerce',
                'label' => 'Aggiungere browse categorie alla search bar?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore sfondo Search Bar',
                'name'                 => 'topbar_background',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Autocomplete hover Search bar',
                'name'                 => 'color_hover_autocomplete_topbar_ecommerce',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Pulsante CATEGORIE Search bar',
                'name'                 => 'bg_btn_search_topbar_ecommerce',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore sfondo Submenu pulsante CATEGORIE Search bar',
                'name'                 => 'bg_submenu_search_topbar_ecommerce',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            // non so se riusciremo ad usarlo per regolare l'alpha del submenu pulsante SearchBar
            $this->crud->addField([   // color_picker
                'label'                => 'Trasparenza Submenu CATEGORIE Search bar',
                'name'                 => 'alpha_submenu_search_topbar_ecommerce',
                'type'                 => 'range',
                'wrapper' => ['class' => 'form-group col-md-4'],
                //optional
                'attributes' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore testo pulsante CATEGORIE Search bar',
                'name'                 => 'txtcolor_btn_search_topbar_ecommerce',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore testo submenu CATEGORIE Search bar',
                'name'                 => 'txtcolor_submenu_search_topbar_ecommerce',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => null,
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Grandezza testo pulsante CATEGORIE Search bar',
                'name'                 => 'size_btn_search_topbar_ecommerce',
                'type'                 => 'text',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Grandezza testo submenu CATEGORIE Search bar',
                'name'                 => 'size_submenu_search_topbar_ecommerce',
                'type'                 => 'text',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Icona aggiungi al carrello nella Search bar',
                'name'                 => 'icon_button_autocomplete_topbar_ecommerce',
                'type'                 => 'text',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Testo libero da mettere nel lato dx della searchbar',
                'name'                 => 'html_free_topbar_ecommerce',
                'type'                 => 'ckeditor',
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'autocomplete_topbar_ecommerce',
                'label' => 'Aggiungere autocomplete di ricerca?',
                'type'  => 'switch',
                'tab' => 'Search bar'
            ]);



            $this->crud->addField([   // Checkbox
                'name'  => 'view_price_autocomplete_topbar_ecommerce',
                'label' => 'Visualizzare anche i prezzi nella topbar?',
                'type'  => 'switch',
                'tab' => 'Search bar'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'view_addcart_autocomplete_topbar_ecommerce',
                'label' => 'Visualizzare anche pulsante carrello nella topbar?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Search bar'
            ]);

            if($adminPlugin->version <= 3) {
                $this->crud->addField([   // Checkbox
                    'name' => 'show_form_contact',
                    'label' => 'Visualizza form contatti nel dettaglio prodotti?',
                    'type' => 'switch',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'tab' => 'Generale'
                ]);
            }

            $this->crud->addField([   // Checkbox
                'name'  => 'show_tags',
                'label' => 'Visualizza elenco tags sidebar',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'type'  => 'switch',
                'tab' => 'Filtri Ricerca'
            ]);

            if($adminPlugin->version == 3){
                $this->crud->addField([   // Checkbox
                    'name'  => 'show_prices_sidebar',
                    'label' => 'Visualizza filtri prezzi in sidebar',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'type'  => 'switch',
                    'tab' => 'Filtri Ricerca'
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'show_attributes_sidebar',
                    'label' => 'Visualizza filtri attributi in sidebar',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'type'  => 'switch',
                    'tab' => 'Filtri Ricerca'
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'show_brands_sidebar',
                    'label' => 'Visualizza filtri brand in sidebar',
                    'type'  => 'switch',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'tab' => 'Filtri Ricerca'
                ]);
            }

            $this->crud->addField([   // Checkbox
                'name'  => 'show_attributes_form_contact',
                'label' => 'Visualizza checkbox lista accessori nel form?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'show_related_products',
                'label' => 'Visualizza Accessori nel dettaglio prodotto?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'show_brands',
                'label' => 'Visualizzare lista brands?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'is_print_pdf',
                'label' => 'Visualizza pulsante Stampa PDF scheda prodotto?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'show_sku',
                'label' => 'Visualizza Codice Articolo in lista prodotti',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([
                'label' => "Foto per PDF",
                'name' => "foto_pdf",
                'type'  => 'browse',
                'tab' => 'Generale',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            if($adminPlugin->version == 3) {
                $this->crud->addField([   // select2_from_array
                    'name' => 'type_registration_form',
                    'label' => "Tipo registrazione utente form",
                    'type' => 'select2_from_array',
                    'options' => [0 => "Semplice", 1 => "Solo privati", 2 => "Solo aziende", 3 => "Privati e Aziende"],
                    'allows_null' => false,
                    'default' => 1,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2'
                    ],
                    'tab' => 'Generale',
                ]);

                $this->crud->addField([   // Checkbox
                    'name'  => 'is_comparations',
                    'label' => 'Visualizza pulsanti di comparazione',
                    'type'  => 'switch',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'tab' => 'Generale'
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

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $lang = new AdminLanguageController();
        $lang->update_lang("pluginProductsSettings", $this->crud, $request);

        $this->crud->entry->save();

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->back();
    }
}
