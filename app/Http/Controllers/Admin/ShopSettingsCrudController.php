<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopSettingsRequest;
use App\Models\AdminPlugin;
use App\Models\OrderStatus;
use App\Models\Page;
use App\Models\ShopSettings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Spatie\Permission\Models\Role;

/**
 * Class ShopSettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopSettingsCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id > 2){
            die;
        }

        CRUD::setModel(\App\Models\ShopSettings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shopSettings');
        CRUD::setEntityNameStrings('Impostazione', 'impostazioni');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        die;
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
        CRUD::setValidation(ShopSettingsRequest::class);

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();

        // Qui incollo cosa far vedere agli amministatori su ShopFormula > Impostazioni
        if(backpack_user()->roles[0]->id == 2) {
        // Qui incollo cosa far vedere agli amministatori su ShopFormula > Impostazioni

            if($adminPlugin->version == 3){

                if(env('PROJECT_NAME') != "Maison-Flaneur"){
                    $this->crud->addField([   // Checkbox
                        'name'  => 'ccn_registered',
                        'label' => 'Emails (divisi per virgola) in copia nascosta quando avviene una registrazione',
                        'type'  => 'textarea',
                        'tab' => 'Email'
                    ]);

                    $this->crud->addField([   // Checkbox
                        'name'  => 'ccn_ordered',
                        'label' => 'Emails (divisi per virgola) in copia nascosta quando avviene un ordine',
                        'type'  => 'textarea',
                        'tab' => 'Email'
                    ]);
                }


                $this->crud->addField([   // Checkbox
                    'name' => 'checkout',
                    'label' => 'Effettuare il checkout normale?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'visitors_buy',
                    'label' => 'I visitatori possono acquistare?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'is_registration_open',
                    'label' => 'Ci si può registrare liberamente?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);


                $statusOrder = OrderStatus::get()->pluck("name", "id")->toArray();
                $this->crud->addField([
                    'name' => 'status_default_order',
                    'label' => "Status ordine post checkout",
                    'type' => 'select_from_array',
                    'options' => $statusOrder,
                    'allows_null' => false,
                    'default' => null,
                    'tab' => "Generale"
                ]);

                $this->crud->addField([
                    'name' => 'status_default_nonpagato',
                    'label' => "Status default non pagato",
                    'type' => 'select_from_array',
                    'options' => $statusOrder,
                    'allows_null' => false,
                    'default' => null,
                    'tab' => "Generale"
                ]);

            }

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 1',
                'name'                 => 'custom_color_1',
                'type'                 => 'color_picker2',
                'default'              => "#ED0D0D",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);


            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 2',
                'name'                 => 'custom_color_2',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => "#0AA412",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);

            // TAB LISTA
            $this->crud->addField([   // Checkbox
                'name' => 'show_search_in_list',
                'label' => 'Visualizzare search in lista prodotti?',
                'type' => 'switch',
                'tab' => "Lista"
            ]);

            if($adminPlugin->version == 3) {
                $this->crud->addField([   // Checkbox
                    'name' => 'search_with_price',
                    'label' => 'Visualizzare anche il prezzo nei suggerimenti search?',
                    'type' => 'switch',
                    'tab' => "Lista"
                ]);
            }

            $this->crud->addField([
                'name' => 'mouseover_image_number',
                'label' => 'Al mouseover nelle liste fai vedere la foto numero:',
                'type' => 'number',
                'tab' => "Lista"
            ]);

            $v = [1 => "Visualizza totale numero varianti + modal", 2 => "Visualizza attributi"];
            $this->crud->addField([
                'name' => 'view_variants_in_list',
                'label' => "Info aggiuntive al box lista",
                'type' => 'select_from_array',
                'options' => $v,
                'allows_null' => true,
                'default' => null,
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name' => 'list_image_width',
                'label' => 'Pixel immagini width',
                'type' => 'text',
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name' => 'list_image_height',
                'label' => 'Pixel immagini height',
                'type' => 'text',
                'tab' => "Lista"
            ]);

            $this->crud->addField([   // select2_from_array
                'name'        => 'list_image_fit',
                'label'       => "Object fit image",
                'type'        => 'select2_from_array',
                'options'     => ["contain" => "contain" , "cover" => "cover"],
                'allows_null' => false,
                'default'     => "contain",
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name'        => 'shop_view_list',
                'label'       => "Visualizzazione lista prodotti",
                'type'        => 'select_from_array',
                'options'     => ["grid" => "Griglia", "list" => "Lista"], //"list" => "Lista"
                'allows_null' => false,
                'default'     => "grid",
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name'        => 'sidebar_position',
                'label'       => "Posizione sidebar",
                'type'        => 'select_from_array',
                'options'     => ["sx" => "Sinistra", "dx" => "Destra"],
                'allows_null' => false,
                'default'     => "sx",
                'tab' => "Lista"
            ]);

            // TAB DETTAGLIO
            $this->crud->addField([
                'name' => 'type_detail_photo',
                'label' => "Tipo di dettaglio foto",
                'type' => 'select_from_array',
                'options' => ["1" => "3 piccole a dx - 1 grande", "2" => "4 grandi", "3" => "1 grande + thumb modalità compatta"],
                'allows_null' => false,
                'default' => 5,
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'name' => 'delete_zoom_hover',
                'label' => 'Al mouseover eliminare lo zoom alla foto',
                'type' => 'switch',
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'name' => 'box_attachments',
                'label' => 'Box allegati a parte',
                'type' => 'switch',
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'name' => 'icon_attachments',
                'label' => 'Icona per allegati',
                'type' => 'text',
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'label' => "Immagine guida alle taglie",
                'name' => "photo_size",
                'type'  => 'browse',
                'tab' => "Dettaglio"
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            $pages = Page::orderBy("name", "asc")->get()->pluck("name", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'page_id_size',
                'label'       => "Pagina guida alle taglie",
                'type'        => 'select2_from_array',
                'options'     => $pages,
                'allows_null' => true,
                'default'     => null,
                'tab' => "Dettaglio"
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([
                'label' => "Aprire pagina guida alle taglie in una nuova finestra?",
                'name' => "page_size_type_href",
                'type'  => 'switch',
                'tab' => "Dettaglio"
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            // TAB CHECKOUT
            if($adminPlugin->version == 3) {
                $this->crud->addField([   // repeatable
                    'name' => 'custom_fields_checkout',
                    'label' => 'Campi aggiuntivi al checkout per il cliente indirizzo fatturazione',
                    'type' => 'repeatable',
                    'fields' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'label' => 'Label',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'placeholder',
                            'type' => 'text',
                            'label' => 'Placeholder',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'col',
                            'label' => 'Colonna',
                            'type' => 'select_from_array',
                            'options' => ['12' => '12', '6' => '6', '4' => '4'],
                            'allows_null' => false,
                            'default' => '12',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // select_from_array
                            'name' => 'type',
                            'label' => "Tipo",
                            'type' => 'select_from_array',
                            'options' => [0 => "Privato", 1 => "Azienda"],
                            'allows_null' => false,
                            'default' => 'text',
                            'wrapper' => ['class' => 'form-group col-md-2'],
                        ],
                        [
                            'name' => 'ordine',
                            'type' => 'text',
                            'label' => 'Ordine',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // Checkbox
                            'name' => 'required',
                            'label' => 'Campo obbligatorio?',
                            'type' => 'switch'
                        ],
                    ],

                    // optional
                    'new_item_label' => 'Nuovo campo', // customize the text of the button
                    'tab' => "Checkout"
                ]);

                $this->crud->addField([   // repeatable
                    'name' => 'custom_fields_shipping',
                    'label' => 'Campi aggiuntivi al checkout per il cliente indirizzo spedizione',
                    'type' => 'repeatable',
                    'fields' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'label' => 'Label',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'placeholder',
                            'type' => 'text',
                            'label' => 'Placeholder',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'col',
                            'label' => 'Colonna',
                            'type' => 'select_from_array',
                            'options' => ['12' => '12', '6' => '6', '4' => '4'],
                            'allows_null' => false,
                            'default' => '12',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [
                            'name' => 'ordine',
                            'type' => 'text',
                            'label' => 'Ordine',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // Checkbox
                            'name' => 'required',
                            'label' => 'Campo obbligatorio?',
                            'type' => 'checkbox'
                        ],
                    ],

                    // optional
                    'new_item_label' => 'Nuovo campo', // customize the text of the button
                    'tab' => "Checkout"
                ]);
            }


        }
        // Fine cosa far vedere agli amministatori su ShopFormula > Impostazioni


        // STESSE IMPOSTAZIONI PER SUPER ADMIN

        // TAB GENERALE VERSIONE 3 SHOP
        if(backpack_user()->roles[0]->id == 1) {
            if($adminPlugin->version == 3) {
                if(env('PROJECT_NAME') != "Maison-Flaneur"){
                    $this->crud->addField([   // Checkbox
                        'name'  => 'ccn_registered',
                        'label' => 'E-mail  (divise da virgola) per ricevere in copia quando avviene una registrazione',
                        'type'  => 'textarea',
                        'tab' => 'Email'
                    ]);

                    $this->crud->addField([   // Checkbox
                        'name'  => 'ccn_ordered',
                        'label' => 'E-mail (divisi per virgola) in copia nascosta quando avviene un ordine',
                        'type'  => 'textarea',
                        'tab' => 'Email'
                    ]);
                }

                $this->crud->addField([   // Checkbox
                    'name' => 'checkout',
                    'label' => 'Effettuare il checkout normale?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'visitors_buy',
                    'label' => 'I visitatori possono acquistare?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'is_registration_open',
                    'label' => 'Ci si può registrare liberamente?',
                    'type' => 'switch',
                    'tab' => "Generale"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'is_subscriptions',
                    'label' => 'Attiva scelta ABBONAMENTO nei prodotti',
                    'type' => 'switch',
                    'tab' => "Abbonamenti"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'is_subscriptions_email',
                    'label' => 'Attiva cron promemoria Email scadenza',
                    'type' => 'switch',
                    'tab' => "Abbonamenti"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'gg_before_subscriptions',
                    'label' => 'Quanti giorni prima inviare promemoria',
                    'type' => 'number',
                    'tab' => "Abbonamenti"
                ]);

                $statusOrder = OrderStatus::get()->pluck("name", "id")->toArray();
                $this->crud->addField([
                    'name' => 'subscription_status_id',
                    'label' => "Status ordine post checkout",
                    'type' => 'select_from_array',
                    'options' => $statusOrder,
                    'allows_null' => false,
                    'default' => null,
                    'tab' => "Abbonamenti"
                ]);

                $parameters = \Route::current()->parameters();
                $shopSetting = ShopSettings::find($parameters['id']);


                $roles = Role::get()->pluck("name", "id")->toArray();
                $this->crud->addField([
                    'name' => 'role_default_register',
                    'label' => "Ruolo cliente post registrazione front end",
                    'type' => 'select_from_array',
                    'options' => $roles,
                    'allows_null' => false,
                    'default' => 5,
                    'tab' => "Generale"
                ]);

                $statusOrder = OrderStatus::get()->pluck("name", "id")->toArray();
                $this->crud->addField([
                    'name' => 'status_default_order',
                    'label' => "Status ordine post checkout",
                    'type' => 'select_from_array',
                    'options' => $statusOrder,
                    'allows_null' => false,
                    'default' => null,
                    'tab' => "Generale"
                ]);

                $this->crud->addField([
                    'name' => 'status_default_nonpagato',
                    'label' => "Status default non pagato",
                    'type' => 'select_from_array',
                    'options' => $statusOrder,
                    'allows_null' => false,
                    'default' => null,
                    'tab' => "Generale"
                ]);
            }

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 1',
                'name'                 => 'custom_color_1',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => "#ED0D0D",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore Etichetta 2',
                'name'                 => 'custom_color_2',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => "#0AA412",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Generale'
            ]);


            // TAB LISTA
            $this->crud->addField([   // Checkbox
                'name' => 'show_search_in_list',
                'label' => 'Visualizzare search in lista prodotti?',
                'type' => 'switch',
                'tab' => "Lista"
            ]);

            if($adminPlugin->version == 3) {
                $this->crud->addField([   // Checkbox
                    'name' => 'search_with_price',
                    'label' => 'Visualizzare anche il prezzo nei suggerimenti search?',
                    'type' => 'switch',
                    'tab' => "Lista"
                ]);
            }

            $this->crud->addField([
                'name' => 'mouseover_image_number',
                'label' => 'Al mouseover nelle liste fai vedere la foto numero:',
                'type' => 'number',
                'tab' => "Lista"
            ]);

            $v = [1 => "Visualizza totale numero varianti + modal", 2 => "Visualizza attributi"];
            $this->crud->addField([
                'name' => 'view_variants_in_list',
                'label' => "Info aggiuntive al box lista",
                'type' => 'select_from_array',
                'options' => $v,
                'allows_null' => true,
                'default' => null,
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name' => 'list_image_width',
                'label' => 'Pixel immagini width',
                'type' => 'text',
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name' => 'list_image_height',
                'label' => 'Pixel immagini height',
                'type' => 'text',
                'tab' => "Lista"
            ]);

            $this->crud->addField([   // select2_from_array
                'name'        => 'list_image_fit',
                'label'       => "Object fit image",
                'type'        => 'select2_from_array',
                'options'     => ["contain" => "contain" , "cover" => "cover"],
                'allows_null' => false,
                'default'     => "contain",
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name'        => 'shop_view_list',
                'label'       => "Visualizzazione lista prodotti",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ["grid" => "Griglia", "list" => "Lista"],
                'allows_null' => false,
                'default'     => "grid",
                'tab' => "Lista"
            ]);

            $this->crud->addField([
                'name'        => 'sidebar_position',
                'label'       => "Posizione sidebar",
                'type'        => 'select_from_array',
                'attributes' => [
                    'class' => 'custom-select',
                ],
                'options'     => ["sx" => "Sinistra", "dx" => "Destra"],
                'allows_null' => false,
                'default'     => "sx",
                'tab' => "Lista"
            ]);



            // TAB DETTAGLIO VERSIONE 3 SHOP
            if($adminPlugin->version == 3) {
                $this->crud->addField([
                    'name' => 'type_view_variant',
                    'label' => "Tipo di dettaglio varianti",
                    'type' => 'select_from_array',
                    'options' => ["1" => "Select con redirect - foto variante - aggiunta carrello singolo", "2" => "Tabella multi carrello - padre visibile - varianti non visibili", "3" => "Padre non visibile, Varianti no select, multi carrello", "4" => "Radio Button"],
                    'allows_null' => false,
                    'default' => 5,
                    'tab' => "Dettaglio"
                ]);
            }

            $this->crud->addField([
                'name' => 'type_detail_photo',
                'label' => "Tipo di dettaglio foto",
                'type' => 'select_from_array',
                'options' => ["1" => "3 piccole a dx - 1 grande", "2" => "4 grandi", "3" => "1 grande + thumb modalità compatta"],
                'allows_null' => false,
                'default' => 5,
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'name' => 'delete_zoom_hover',
                'label' => 'Al mouseover eliminare lo zoom alla foto',
                'type' => 'checkbox',
                'tab' => "Dettaglio"
            ]);

            $this->crud->addField([
                'name' => 'bread_crumbs',
                'label' => 'Visualizza i Bread Crumbs (sezione Header > percorso dove sei in dettaglio prodotto)',
                'type' => 'switch',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-12'],
            ]);

            $this->crud->addField([
                'name' => 'height_section_bc',
                'label' => 'Altezza Header BC (es: 50)',
                'type' => 'text',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([
                'name' => 'padding_section_bc',
                'label' => 'Padding Header BC (es: 1)',
                'type' => 'text',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore sfondo header BC',
                'name'                 => 'bgcolor_bc',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-12'],
                'default'              => "#F3EDED",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Dettaglio'
            ]);

            $this->crud->addField([
                'name' => 'text_size_bc',
                'label' => 'Font-size Bread crumbs (es: 12)',
                'type' => 'text',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Colore testo Bread crumbs',
                'name'                 => 'text_color_bc',
                'type'                 => 'color_picker2',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'default'              => "##000000",
                // optional
                'color_picker_options' => ['customClass' => 'custom-class'],
                'tab' => 'Dettaglio'
            ]);

            $this->crud->addField([
                'name' => 'box_properties',
                'label' => 'Nascondi le Proprietà (visualizza solo gli allegati in TAB)',
                'type' => 'switch',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-12'],
            ]);

            $this->crud->addField([
                'name' => 'box_attachments',
                'label' => 'Box allegati a parte (da attivare solo se Nascondi le proprietà non è attivo)',
                'type' => 'switch',
                'tab' => "Dettaglio",
                'wrapper' => ['class' => 'form-group col-md-6'],
            ]);

            $this->crud->addField([
                'name' => 'icon_attachments',
                'label' => 'Icon per allegati',
                'type' => 'text',
                'tab' => "Dettaglio"
            ]);


            $this->crud->addField([
                'label' => "Immagine guida alle taglie",
                'name' => "photo_size",
                'type'  => 'browse',
                'tab' => "Dettaglio"
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            $pages = Page::orderBy("name", "asc")->get()->pluck("name", "id")->toArray();
            $this->crud->addField([   // select2_from_array
                'name'        => 'page_id_size',
                'label'       => "Pagina guida alle taglie",
                'type'        => 'select2_from_array',
                'options'     => $pages,
                'allows_null' => true,
                'default'     => null,
                'tab' => "Dettaglio"
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([
                'label' => "Aprire pagina guida alle taglie in una nuova finestra?",
                'name' => "page_size_type_href",
                'type'  => 'switch',
                'tab' => "Dettaglio"
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);



            // TAB CHECKOUT VERSIONE 3 SHOP
            if($adminPlugin->version == 3) {
                $this->crud->addField([   // repeatable
                    'name' => 'custom_fields_checkout',
                    'label' => 'Campi aggiuntivi al checkout per il cliente indirizzo fatturazione',
                    'type' => 'repeatable',
                    'fields' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'label' => 'Label',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'placeholder',
                            'type' => 'text',
                            'label' => 'Placeholder',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'col',
                            'label' => 'Colonna',
                            'type' => 'select_from_array',
                            'options' => ['12' => '12', '6' => '6', '4' => '4'],
                            'allows_null' => false,
                            'default' => '12',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // select_from_array
                            'name' => 'type',
                            'label' => "Tipo",
                            'type' => 'select_from_array',
                            'options' => [0 => "Privato", 1 => "Azienda"],
                            'allows_null' => false,
                            'default' => 'text',
                            'wrapper' => ['class' => 'form-group col-md-2'],
                        ],
                        [
                            'name' => 'ordine',
                            'type' => 'text',
                            'label' => 'Ordine',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // Checkbox
                            'name' => 'required',
                            'label' => 'Campo obbligatorio?',
                            'type' => 'switch'
                        ],
                    ],

                    // optional
                    'new_item_label' => 'Nuovo campo', // customize the text of the button
                    'tab' => "Checkout"
                ]);

                $this->crud->addField([   // repeatable
                    'name' => 'custom_fields_shipping',
                    'label' => 'Campi aggiuntivi al checkout per il cliente indirizzo spedizione',
                    'type' => 'repeatable',
                    'fields' => [
                        [
                            'name' => 'title',
                            'type' => 'text',
                            'label' => 'Label',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'placeholder',
                            'type' => 'text',
                            'label' => 'Placeholder',
                            'wrapper' => ['class' => 'form-group col-md-4'],
                        ],
                        [
                            'name' => 'col',
                            'label' => 'Colonna',
                            'type' => 'select_from_array',
                            'options' => ['12' => '12', '6' => '6', '4' => '4'],
                            'allows_null' => false,
                            'default' => '12',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [
                            'name' => 'ordine',
                            'type' => 'text',
                            'label' => 'Ordine',
                            'wrapper' => ['class' => 'form-group col-md-1'],
                        ],
                        [   // Checkbox
                            'name' => 'required',
                            'label' => 'Campo obbligatorio?',
                            'type' => 'checkbox'
                        ],
                    ],

                    // optional
                    'new_item_label' => 'Nuovo campo', // customize the text of the button
                    'tab' => "Checkout"
                ]);

                // TAB URL

                $this->crud->addField([   // Checkbox
                    'name' => 'url_privacy',
                    'label' => 'Inserire url privacy (interna)',
                    'type' => 'text',
                    'tab' => "Url"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'url_condition',
                    'label' => 'Inserire url condizioni di vendita',
                    'type' => 'text',
                    'tab' => "Url"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'text_privacy',
                    'label' => 'Inserire testo privacy da salvare nel DB quando uno si registra',
                    'type' => 'ckeditor',
                    'tab' => "Url"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'text_cookie',
                    'label' => 'Inserire testo cookie da salvare nel DB quando uno si registra',
                    'type' => 'ckeditor',
                    'tab' => "Url"
                ]);

                /*$this->crud->addField([   // Checkbox
                    'name' => 'privacy_iubenda',
                    'label' => 'Incolla codice da iubenda per la privacy',
                    'type' => 'textarea',
                    'tab' => "Url Iubenda"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'termini_iubenda',
                    'label' => 'Incolla codice da iubenda per termini e condizioni',
                    'type' => 'textarea',
                    'tab' => "Url Iubenda"
                ]);

                $this->crud->addField([   // Checkbox
                    'name' => 'cookie_iubenda',
                    'label' => 'Incolla codice da iubenda per i cookie',
                    'type' => 'textarea',
                    'tab' => "Url Iubenda"
                ]);*/

                $trans = new AdminLanguageController();
                $trans->fields_lang("shopSetting", $this->crud, $shopSetting);


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

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        $lang = new AdminLanguageController();
        $lang->update_lang("shopSetting", $this->crud, $request);
        $item->save();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->back();
    }
}
