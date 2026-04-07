<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WebsiteSettingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WebsiteSettingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WebsiteSettingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\WebsiteSetting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/websiteSetting');
        CRUD::setEntityNameStrings('impostazioni', 'impostazioni');
        $this->crud->setEditView(backpack_view('editWebsiteSetting'));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        return redirect()->to("/admin/websiteSetting/1/edit");
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(WebsiteSettingRequest::class);

        die;
        CRUD::setFromDb(); // fields

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
        if(env("APP_URL") == "https://dev.cmsformula.it"){

            /*  ### TAB SITO ###  */
            $this->crud->addField([
                'name' => 'test',
                'label' => "TEST",
                'type' => 'lfm_image',
                'tab' => 'test'
            ]);
        }


        // image
        $this->crud->addField([
            'label' => "Logo",
            'name' => "logo",
            'type'  => 'browse',
            'tab' => 'Sito',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Logo 2",
            'name' => "logo2",
            'type'  => 'browse',
            'tab' => 'Sito',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Logo 3",
            'name' => "logo3",
            'type'  => 'browse',
            'tab' => 'Sito',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'logo_email',
            'label'       => "Logo per email",
            'type'        => 'select_from_array',
            'options'     => ['logo1' => 'Logo 1', 'logo2' => 'Logo 2', 'logo3' => 'Logo 3'],
            'allows_null' => false,
            'attributes' => [
                'class'       => 'custom-select',
            ],
            'default'     => 'logo1',
            'tab' => 'Sito',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'label' => "Favicon",
            'name' => "favicon",
            'type'  => 'browse',
            'tab' => 'Sito',
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        // image
        /*$this->crud->addField([
            'label' => "Logo 2",
            'name' => "logo2",
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);*/

        $this->crud->addField([   // color_picker
            'label'                => 'Colore di sfondo generale (Body background))',
            'name'                 => 'site_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Sito'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo generale',
            'name'                 => 'site_color',
            'type'                 => 'color_picker2',
            'default'              => "#040404FF",
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Sito'
        ]);

        $this->crud->addField([
            'label'                => 'Dimensione testo generale in pixel (es: 14px)',
            'name'                 => 'font_size',
            'type'                 => 'text',
            'default'              => null,
            // optional
            'tab' => 'Sito'
        ]);

        /************ TAB: INTEGRAZIONI HEAD ES: MAILCHIMP **************************************/

        $this->crud->addField([
            'name' => 'mailchimp_user',
            'label' => "MAILCHIMP: Incolla qui il codice users di MailChimp Newsletter (esempio: d000bf00c00e0d0b00bf00a0/a00000000a0bb00ba00a0000)",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Head'
        ]);

        $this->crud->addField([
            'label'                => 'Iubenda Privacy Client ID (mettere solo i numeri)',
            'name'                 => 'iubenda_client_id',
            'type'                 => 'text',
            'default'              => null,
            // optional
            'tab' => 'Head'
        ]);

        $this->crud->addField([
            'name' => 'consent_solution_iubenda',
            'label' => "Consent Solution Iubenda",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Head'
        ]);

        $this->crud->addField([
            'name' => 'cookieyes',
            'label' => "CookieYes Head",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Head'
        ]);

        $this->crud->addField([
            'name' => 'cookiebot',
            'label' => "CookieBot Head",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Head'
        ]);

        $this->crud->addField([
            'name' => 'usercentrics',
            'label' => "Usercentrics Head",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Head'
        ]);

        /************ TAB: HEADER/TOP MENU **************************************/

        $this->crud->addField([   // Checkbox
            'name'  => 'is_topbar_fixed_desktop',
            'label' => 'Header fissa su PC/Desktop',
            'type'  => 'switch',
            'default' => 0,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_extra_button_menu',
            'label' => 'Utilizza pulsante extra Top menu (solo su Crafto)',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore di sfondo pulsante extra Top menu (solo su Crafto)',
            'name'                 => 'bgcolor_extra_button_menu',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore del testi pulsante extra Top menu (solo su Crafto)',
            'name'                 => 'txtcolor_extra_button_menu',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'type_href',
            'label'       => "Apertura link pulsante extra Top menu (solo su Crafto)",
            'type'        => 'select_from_array',
            'options'     => ['_blank' => 'Nuova pagina', '_self' => 'Stessa pagina'],
            'allows_null' => false,
            'default'     => '_self',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Header'

        ]);

        CRUD::addField([
            'name'  => 'divider1',
            'type'  => 'custom_html',
            'value' => '<hr>',
            'tab' => 'Header'
        ]);







                // CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP//////////////////
                if(env('TEMA') == 'Webshop' ){
                    $adminPluginProduct = \App\Models\AdminPlugin::where("name", "pluginProducts")->first();
                    if($adminPluginProduct){
                        if($adminPluginProduct->version >=2){
                            $this->crud->addField([   // Checkbox
                                'name'  => 'is_search_in_header',
                                'label' => 'Search bar in header',
                                'type'  => 'switch',
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-2'
                                ],
                                'tab' => 'Header'
                            ]);


                        }
                    }

                    $this->crud->addField([   // Checkbox
                        'name'  => 'transparent_header',
                        'label' => 'Header trasparente su PC/Desktop',
                        'type'  => 'switch',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                        'tab' => 'Header'
                    ]);

                    $this->crud->addField([   // Checkbox
                        'name'  => 'transparent_header_mobile',
                        'label' => 'Header trasparente su Mobile',
                        'type'  => 'switch',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-6'
                        ],
                        'tab' => 'Header'
                    ]);

                    $this->crud->addField([
                        'label'                => 'Altezza MENU BAR HEADER in pixel (Es: 250px)',
                        'name'                 => 'menubar_height',
                        'type'                 => 'text',
                        'default'              => null,
                        // optional
                        'tab' => 'Header'
                    ]);

                    $this->crud->addField([   // color_picker
                        'label'                => 'Colore sfondo HEADER FISSA',
                        'name'                 => 'header_background',
                        'type'                 => 'color_picker2',
                        'default'              => null,
                        // optional
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'tab' => 'Header'
                    ]);

                    $this->crud->addField([   // color_picker
                        'label' => 'Colore di sfondo HEADER non fissa',
                        'name' => 'topbar_fixed_background',
                        'type' => 'color_picker2',
                        'default' => null,
                        // optional
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'tab' => 'Header'
                    ]);



                    $this->crud->addField([   // color_picker
                        'label' => 'Colore sfondo SUB-MENU MOBILE',
                        'name' => 'submenu_bgcolor',
                        'type' => 'color_picker2',
                        'default' => null,
                        // optional
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'tab' => 'Header'
                    ]);

                    $this->crud->addField([   // color_picker
                        'label' => 'Colore sfondo Active SUB-MENU MOBILE',
                        'name' => 'bgcolor_active_submenu',
                        'type' => 'color_picker2',
                        'default' => null,
                        // optional
                        'color_picker_options' => ['customClass' => 'custom-class'],
                        'tab' => 'Header'
                    ]);





                }  // FINE DEI CAMPI VISUALIZZATI SOLO CON IL TEMA WEBSHOP \\\\\\\\\\\\\\\\\



        $this->crud->addField([
            'label'                => 'Altezza MENU BAR HEADER in pixel (Es: 250px)',
            'name'                 => 'menubar_height',
            'type'                 => 'text',
            'default'              => null,
            // optional
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo HEADER FISSA',
            'name'                 => 'header_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo HEADER PC',
            'name'                 => 'header_color',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo HEADER al passaggio del mouse',
            'name'                 => 'header_color_hover',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'photo_header',
            'label' => 'Immagine di sfondo HEADER',
            'type'  => 'browse',
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo SUB-MENU (Desktop & Mobile)',
            'name'                 => 'submenu_desktop_bgcolor',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo SUB-MENU (Desktop & Mobile)',
            'name'                 => 'submenu_txt_color',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label' => 'Colore sfondo MENU (Mobile)',
            'name' => 'mobile_menu_bgcolor',
            'type' => 'color_picker2',
            'default' => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label' => 'Colore testo MENU (Mobile)',
            'name' => 'mobile_menu_color',
            'type' => 'color_picker2',
            'default' => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        $this->crud->addField([   // color_picker
            'label' => 'Colore HAMBURGER MENU',
            'name' => 'bgcolor_menu_mobile',
            'type' => 'color_picker2',
            'default' => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Header'
        ]);

        // IMPOSTAZIONI SOLO PER WEBSHOP

        if(env('TEMA') == 'Crafto') {






        }



        /*  ### TAB GOOGLE FONT ###  */

        $this->crud->addField([
            'label'                => '<br />
                                       Personalizza al massimo il layout del tuo sito con un Google Font. Per recuperare il codice html da incollare qui sotto, visita il sito Google Font <a target="_blank" href="https://fonts.google.com/"> cliccando direttamente qui</a>.
Una volta recuperata la stringa html del relativo font (esempio: https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;700&display=swap) incollala nei due campi sottostanti e salva.<br /><br /><br />
                                       Font per Titoli (h1... h6)',
            'name'                 => 'h_family',
            'type'                 => 'text',
            'tab' => 'Google Font'
        ]);

        $this->crud->addField([
            'label'                => 'Font per testo semplice e pulsanti',
            'name'                 => 'p_family',
            'type'                 => 'text',
            'tab' => 'Google Font'
        ]);

        $this->crud->addField([
            'label'                => 'Font per pannello admin (URL Google Fonts)',
            'name'                 => 'admin_panel_font',
            'type'                 => 'text',
            'hint'                 => 'Incolla un URL css2 di Google Fonts, es: https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap',
            'tab' => 'Google Font'
        ]);


        /*  ### TAB FOOTER ###  */

        /*$this->crud->addField([
            'name' => 'description_footer',
            'label' => "Testo footer",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Footer'
        ]);*/

        $this->crud->addField([   // color_picker
            'label'                => 'Colore di sfondo Footer',
            'name'                 => 'footer_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo Footer',
            'name'                 => 'footer_color',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo Footer al passaggio mouse',
            'name'                 => 'footer_color_hover',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'photo_footer',
            'label' => 'Immagine di sfondo Footer (ripetuta)',
            'type'  => 'browse',
            'tab' => 'Footer'
        ]);


      /*  $trans = new AdminLanguageController();
        $trans->fields_lang("websiteSetting", $this->crud);*/

        /* Se il cliente non utilizza Iubenda per il Cookie Banner uso questi */

        $this->crud->addField([   // color_picker
            'label'                => '<h3>BANNER COOKIE</h3><br> Colore di sfondo banner cookie',
            'name'                 => 'cookie_div_bg',
            'type'                 => 'color_picker2',
            'default'              => '#000000',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo banner cookie',
            'name'                 => 'cookie_txt_color',
            'type'                 => 'color_picker2',
            'default'              => '#ffffff',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore pulsante accetta cookie',
            'name'                 => 'cookie_btn_bg',
            'type'                 => 'color_picker2',
            'default'              => '#F5D948',
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'cookie_position',
            'label'       => "Posizione Banner cookie",
            'type'        => 'select_from_array',
            'attributes' => [
                'class' => 'custom-select',
            ],
            'options'     => ['bottom-left' => 'Basso/Sinistra', 'bottom-right' => 'Basso/Destra'],
            'allows_null' => false,
            'default'     => 'bottom-left',
            'tab' => 'Footer',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        /* Altrimenti se il cliente attiva i servizi Iubenda uso questi */

        /* Servizi Iubenda Generatore di Privacy e Cookie Policy  */

        /*$this->crud->addField([
            'name' => 'iubenda_privacy',
            'label' => "<h3>IMPOSTAZIONI IUBENDA</h3><br> Incolla qui il codice della Privacy Policy by Iubenda",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Footer'
        ]);

        $this->crud->addField([
            'name' => 'iubenda_cookie',
            'label' => "Incolla qui il codice della Cookie Policy by Iubenda",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Footer'
        ]); */

        /* Se il cliente attiva i servizi Iubenda Cookie Banner uso questi */

        /*$this->crud->addField([
            'name' => 'iubenda_cookie_banner',
            'label' => "Incolla qui il codice del Cookie Banner by Iubenda",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Footer'
        ]);*/


        $this->crud->addField([   // Browse
            'name'  => 'photo_credits',
            'label' => 'Immagine credits',
            'type'  => 'browse',
            'tab' => 'Footer'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'link_credits',
            'label' => 'Link credits',
            'type'  => 'text',
            'tab' => 'Footer'
        ]);

        /* TAB DESIGN E COLORI */

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo Pulsanti',
            'name'                 => 'btn_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore bordo Pulsanti',
            'name'                 => 'btn_colorborder',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo Pulsanti',
            'name'                 => 'btn_txt_color',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);


        $this->crud->addField([   // color_picker
            'label'                => 'Colore hover Bottoni',
            'name'                 => 'btn_hover_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo Generico 1 Blocchi',
            'name'                 => 'color_gen1',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo Generico 2 Blocchi',
            'name'                 => 'color_gen2',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore sfondo Generico 3 Blocchi',
            'name'                 => 'color_gen3',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "CSS Shop-Formula Personalizzato",
            'name' => "style_css_shoppy",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "CSS Style Custom (qui usare: css_custom/custom_style.css) in quanto racchiude tutte le migliorie CSS fatte. ",
            'name' => "style_css",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "CSS Skin <!--<a href='#' data-toggle='tooltip' data-html='true' title='' data-original-title='<em>Tooltip</em> <u>with</u> <b>HTML</b>'>Tooltip with HTML</a>-->",
            'name' => "skin_css",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "Url Custom Css <!--<a href='#' data-toggle='tooltip' title='' data-original-titletitle='The last tip!'>twitter handle</a>-->",
            'name' => "custom_css",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "Url Custom Responsive Css",
            'name' => "responsive_css",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "Url Mega Menu Css",
            'name' => "mega_menu",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([
            'label' => "Url Form Contact Css",
            'name' => "form_contact",
            'type'  => 'text',
            'tab' => 'Style'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'CSS custom in linea',
            'name'                 => 'custom_css_style',
            'type'                 => 'textarea',
            'attributes' => [
                'rows' => 20,
            ],
            'tab' => 'Style'
        ]);



        /*  ### TAB ANALYTICS ###  */

        $this->crud->addField([
            'name' => 'analytics',
            'label' => "Google Analytics (Incolla SOLO l'ID Cliente di Analytics - ES: G-123456489) ",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);

        $this->crud->addField([
            'name' => 'googlegta',
            'label' => "Google Tag Manager (Incolla SOLO l'ID Cliente di GTA - ES: GTM-T9XXXXX) ",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);

        $this->crud->addField([
            'name' => 'googleads1',
            'label' => "Google ADS (Incolla SOLO l'ID Cliente della sponsorizzata ADS - ES: AW-123456489/abdcodicespons) ",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);

        $this->crud->addField([
            'name' => 'googleads2',
            'label' => "Conversione Google ADS (Incolla SOLO l'ID della conversione ADS - ES: AW-123456489) ",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);

        $this->crud->addField([
            'name' => 'pixelfb',
            'label' => "Pixel di Facebook (Incolla SOLO l'ID del pixel Cliente - se attivo) ",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);

        $this->crud->addField([
            'name' => 'shinystat',
            'label' => "Shinystat Analytics (Incolla SOLO lo username Shinystat del Cliente - ES: nomeCliente)",
            'type' => 'textarea',
            'attributes' => ['class' => 'form-control'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'G-TAG'
        ]);


        /*  ### Whatsapp ###  */

        /* WAPP UTENTE 1 */



        $this->crud->addField([   // Browse
            'name'  => 'wapp_css1',
            'label' => '<br><h4><b>PARAMENTRI WHATSAPP - UTENTE 1</b></h4> <br>CSS WhatsApp utente 1',
            'type'  => 'text',
            'tab' => 'Whatsapp',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'cellulare_wapp1',
            'label' => 'Cellulare WhatsApp utente 1 (Formato: 393470000111)',
            'type'  => 'text',
            'tab' => 'Whatsapp',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => "avatar_wapp1",
            'label' => "Logo WhatsApp utente 1",
            'type'  => 'browse',
            'tab' => 'Whatsapp',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        /* CHECKBOX DEI 7 GIORNI UTENTE 1*/

        $this->crud->addField([
            'name'  => 'sunday',
            'label' => 'Domenica',
            'default' => 'sunday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsustart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '23:58',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsuend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '23:59',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'monday',
            'label' => 'Lunedì',
            'default' => 'monday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hmostart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hmoend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'tuesday',
            'label' => 'Martedì',
            'default' => 'tuesday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'htustart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'htuend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'wednesday',
            'label' => 'Mercoledì',
            'default' => 'wednesday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hwestart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hweend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'thursday',
            'label' => 'Giovedì',
            'default' => 'thursday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hthstart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hthend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'friday',
            'label' => 'Venerdì',
            'default' => 'friday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hfrstart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hfrend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
           'name'  => 'saturday',
           'label' => 'Sabato',
           'default' => 'saturday',
           'attributes' => [
               'readonly' => 'readonly',
           ],
           'wrapperAttributes' => [
               'class' => 'form-group col-md-4'
           ],
           'tab' => 'Whatsapp'
       ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsastart',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsaend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        /* FINE SETTING WHATSAPP UTENTE 1*/



        /************** WAPP UTENTE 2 ****************/


        $this->crud->addField([   // Browse
            'name'  => 'wapp_css2',
            'label' => '<br><h4><b>PARAMENTRI WHATSAPP - UTENTE 2</h4></b> <br>CSS WhatsApp utente 2',
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-12'],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'cellulare_wapp2',
            'label' => 'Cellulare WhatsApp utente 2',
            'type'  => 'text',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name' => "avatar_wapp2",
            'label' => "Avatar utente 2",
            'type'  => 'browse',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            'tab' => 'Whatsapp'
        ]);

        /* GIORNI E ORA DELLA SETTIMANA UNTENTE 2 */

        $this->crud->addField([
            'name'  => 'sunday2',
            'type'  => 'text',
            'label' => 'Domenica',
            'default' => 'sunday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);


        $this->crud->addField([   // Browse
            'name'  => 'hsu2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '23:58',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsu2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '23:59',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'monday2',
            'label' => 'Lunedì',
            'type'  => 'text',
            'default' => 'monday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hmo2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hmo2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'tuesday2',
            'label' => 'Martedì',
            'type'  => 'text',
            'default' => 'tuesday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'htu2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'htu2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'wednesday2',
            'label' => 'Mercoledì',
            'type'  => 'text',
            'default' => 'wednesday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hwe2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hw2eend',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'thursday2',
            'label' => 'Giovedì',
            'type'  => 'text',
            'default' => 'thursday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hth2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hth2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'friday2',
            'label' => 'Venerdì',
            'type'  => 'text',
            'default' => 'friday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hfr2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hfr2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([
            'name'  => 'saturday2',
            'label' => 'Sabato',
            'type'  => 'text',
            'default' => 'saturday',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsa2start',
            'label' => 'Ora inizio',
            'type'  => 'text',
            'default' => '08:00',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);

        $this->crud->addField([   // Browse
            'name'  => 'hsa2end',
            'label' => 'Ora fine',
            'type'  => 'text',
            'default' => '20:30',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'tab' => 'Whatsapp'
        ]);







        /*  ### TAB SOCIAL ###  */

        $this->crud->addField([   // repeatable
            'name'  => 'socials',
            'label' => 'Social',
            'type'  => 'repeatable',
            'tab' => 'Social',
            'fields' => [
                [
                    'name'    => 'name',
                    'type'    => 'text',
                    'label'   => 'Nome social',
                    'wrapper' => ['class' => 'form-group col-md-2'],
                ],
                [   // repeatable
                    'name'  => 'icon',
                    'label' => 'Icona (Es: fa-brands fa-facebook ) - <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Clicca qui e cerca icona</a>',
                    'type'  => 'text',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ],
                [
                    'name'    => 'url',
                    'type'    => 'text',
                    'label'   => 'Url',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
            ],
            // optional
            'new_item_label'  => 'Aggiungi social', // customize the text of the button
        ]);

        /*  ### TAB TOPBAR ###  */

        $this->crud->addField([   // Checkbox
            'name'  => 'topbar_active',
            'label' => 'Vuoi attivare la Topbar?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'topbar_scrolltext_active',
            'label' => 'Vuoi attivare il testo scorrevole nella Topbar?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'        => 'sizeicon',
            'label'   => 'Grandezza Icone Topbar e Social',
            'type'        => 'select_from_array',
            'attributes' => [
                'class' => 'custom-select',
            ],
            'options'     => ['fa-lg' => '1x', 'fa-2x' => '2x', 'fa-3x' => '3x'],
            'allows_null' => false,
            'default'     => 'fa-1x',
            'wrapper' => ['class' => 'form-group col-md-12'],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'topbar_contact_email',
            'label' => 'E-mail di contatto',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'icon_topbar1',
            'label' => 'Icona (Es: fas fa-map-marker-alt ) - <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">Clicca qui e seleziona la tua icona</a>',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'topbar_contact_mobile',
            'label' => 'Cellulare di contatto',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'icon_topbar2',
            'label' => 'Icona (Es: fas fa-map-marker-alt ) - <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">Clicca qui e seleziona la tua icona</a>',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'icon_topbar3',
            'label' => 'Icona Frase generica (Es: fas fa-map-marker-alt ) - <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">Clicca qui e seleziona la tua icona</a>',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'name'  => 'topbar_address_icon',
            'label' => 'Icona Indirizzo (Es: fas fa-map-marker-alt ) - <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">Clicca qui e seleziona la tua icona</a>',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore Icone',
            'name'                 => 'color_icon_topbar',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore di sfondo TOPBAR',
            'name'                 => 'topbar_background',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([   // color_picker
            'label'                => 'Colore testo TOPBAR',
            'name'                 => 'color_txt_topbar',
            'type'                 => 'color_picker2',
            'default'              => null,
            // optional
            'color_picker_options' => ['customClass' => 'custom-class'],
            'tab' => 'Topbar'
        ]);

        $this->crud->addField([
            'label'                => 'Dimensione testo TOPBAR in pixel (es: 14px)',
            'name'                 => 'font_size_topbar',
            'type'                 => 'text',
            'default'              => null,
            // optional
            'tab' => 'Topbar'
        ]);


        /*  ### TAB IMPOSTAZIONI ###  */


        $this->crud->addField([   // Checkbox
            'name'  => 'is_online',
            'label' => 'Visibile Online?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Manutenzione'
        ]);


        $this->crud->addField([   // Checkbox
            'name'  => 'popup_start',
            'label' => 'Data inizio',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Avvisi'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'popup_end',
            'label' => 'Data fine',
            'type'  => 'date',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Avvisi'
        ]);

        $this->crud->addField([   // select_from_array
            'name'        => 'popup_pages',
            'label'       => "Visibile",
            'type'        => 'select_from_array',
            'attributes' => [
                'class' => 'custom-select',
            ],
            'options'     => ['1' => 'Solo in Homepage', '2' => 'Tutte le pagine'],
            'allows_null' => false,
            'default'     => '1',
            'tab' => 'Avvisi'
        ]);

        /*  ### TAB IMPOSTAZIONI EXTRA ###  */

        $this->crud->addField([   // Checkbox
            'name'  => 'whatsapp_active',
            'label' => 'Attiva Widget WhatsApp',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],
            'tab' => 'Extra'
        ]);


        if(backpack_user()->roles[0]->id == 1) {


             $this->crud->addField([   // Checkbox
                 'name'  => 'watermark_url',
                 'label' => 'Url',
                 'type'  => 'browse',
                 'wrapperAttributes' => [
                     'class' => 'form-group col-md-12'
                 ],
                 'tab' => 'Watermark'
             ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'watermark_position',
                'label' => 'Posizione',
                'type'  => 'text',
                'hint' => "top-left, top, top-right, left, center, right, bottom-left, bottom, bottom-right",
                'default' => "bottom-right",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Watermark'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'watermark_x',
                'label' => 'Posizione X',
                'hint' => "Optional relative offset of the new image on x-axis of the current image. Offset will be calculated relative to the position parameter. Default: 0",
                'type'  => 'text',
                'default' => 10,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Watermark'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'watermark_y',
                'label' => 'Posizione Y',
                'hint' => "Optional relative offset of the new image on y-axis of the current image. Offset will be calculated relative to the position parameter. Default: 0",
                'type'  => 'text',
                'default' => 10,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'tab' => 'Watermark'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'is_megamenu',
                'label' => 'Attiva megamenu sulla pagina PRODOTTI',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ],
                'tab' => 'Extra'
            ]);

            $this->crud->addField([   // Checkbox
                'name'  => 'is_search_one_col',
                'label' => 'Megamenu (se attivo) monocolonna',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2'
                ],
                'tab' => 'Impostazioni Extra'
            ]);

            $this->crud->addField([
                'name'  => 'azzera_ordini',
                'type'  => 'custom_html',
                'value' => '
                    <a href="'.route('azzera_ordini').'"
                       class="btn btn-danger"
                       onclick="return confirm(\'Sei sicuro di voler azzerare tutti gli ordini?\')">
                        Azzera ordini
                    </a>
                ',
                'tab' => 'Impostazioni Extra',
            ]);


            $abilitato = !\Schema::hasTable('shop_areas');

            $this->crud->addField([
                'name'  => 'set_shop_areas',
                'type'  => 'custom_html',
                'value' => '
        <a href="'.route('set_shop_areas').'"
           class="btn btn-danger '.(!$abilitato ? 'disabled' : '').'"
           '.($abilitato
                        ? 'onclick="return confirm(\'Sei sicuro di voler caricare shop areas?\')"'
                        : 'onclick="return false;"').'>
            Carica shop area zone
        </a>
        '.(!$abilitato
                        ? '<small class="text-muted d-block mt-1">Shop areas già presenti</small>'
                        : '').'
    ',
                'tab' => 'Impostazioni Extra',
            ]);


            $this->crud->addField([   // Checkbox
                'name' => 'number_max_page',
                'label' => 'Numero di pagine',
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2'
                ],
                'tab' => 'Extra'
            ]);

            $this->crud->addField([
                'label' => "Logo pannello admin",
                'name' => "logo_admin",
                'type'  => 'browse',
                'default' => 'public/img/commons/admin/logo-dashboard-CMS6_s2.png',
                'tab' => 'Extra',
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            $this->crud->addField([
                'label' => "Logo Accesso admin (Dimensioni: 180x90px)",
                'name' => "logo_login",
                'type'  => 'browse',
                'default' => 'public/img/commons/admin/logo-dashboard-CMS6_s2_login.png',
                'tab' => 'Extra',
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ]);

            $this->crud->addField([
                'label' => "GIF Dashboard (se vuoto usa quella di default)",
                'name' => "dashboard_gif",
                'type'  => 'browse',
                'tab' => 'Extra'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Sfondo topbar',
                'name'                 => 'admin_topbar_background',
                'type'                 => 'color_picker2',
                'default'              => '#1b2a4e',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'tab' => 'Extra'
            ]);

            $this->crud->addField([   // color_picker
                'label'                => 'Sfondo barra di sinistra',
                'name'                 => 'admin_leftbar_background',
                'type'                 => 'color_picker2',
                'default'              => '#1b2a4e',
                'color_picker_options' => ['customClass' => 'custom-class'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'tab' => 'Extra'
            ]);

            $this->crud->addField([
                'label' => "Sfondo login pannello admin (responsive)",
                'name' => "admin_login_background",
                'type'  => 'browse',
                'hint'  => "Se vuoto resta lo sfondo bianco di default",
                'tab' => 'Extra'
            ]);

            $this->crud->addField([
                'label' => "Bacheca da far vedere (nome blade)",
                'name' => "bacheca",
                'type'  => 'text',
                'tab' => 'Extra'
            ]);



        }

        $trans = new AdminLanguageController();
        $trans->fields_lang("website", $this->crud);

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
        $lang->update_lang("website", $this->crud, $request);
        $this->crud->entry->save();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return redirect()->back();
    }
}
