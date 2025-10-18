<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use App\Models\BlockBanner;
use App\Models\BlockBrand;
use App\Models\BlockCarousel;
use App\Models\BlockCollage;
use App\Models\BlockContact;
use App\Models\BlockContactgmap;
use App\Models\BlockDocument;
use App\Models\BlockFaq;
use App\Models\BlockFlusso;
use App\Models\BlockGallery;
use App\Models\BlockGrid;
use App\Models\BlockHero;
use App\Models\BlockHightlight;
use App\Models\BlockHtml;
use App\Models\BlockHtmlImage;
use App\Models\BlockHtmlTwocol;
use App\Models\BlockIcon;
use App\Models\BlockImage;
use App\Models\BlockImageLink;
use App\Models\BlockLastwork;
use App\Models\BlockMetro;
use App\Models\BlockMetrox;
use App\Models\BlockNews;
use App\Models\BlockOnePhoto;
use App\Models\BlockParallax;
use App\Models\BlockPluginBookingSearchType;
use App\Models\BlockPluginParking;
use App\Models\BlockPluginProduct;
use App\Models\BlockPortfolio;
use App\Models\BlockPortfolio2;
use App\Models\BlockPrice;
use App\Models\BlockReference;
use App\Models\BlockScrollbar;
use App\Models\BlockSeparator;
use App\Models\BlockSlideshow;
use App\Models\BlockStaff;
use App\Models\BlockStore;
use App\Models\BlockTab;
use App\Models\BlockTimeline;
use App\Models\BlockVideobg;
use App\Models\BlockVideotut;
use App\Models\Label;
use App\Models\Page;
use App\Models\PluginBookingLabels;
use App\Models\PluginBookingPayments;
use App\Models\PluginBookingRoom;
use App\Models\PluginBookingServices;
use App\Models\PluginBookingSettings;
use App\Models\PluginBookingStatus;
use App\Models\PluginBookingType;
use App\Models\PluginCounter;
use App\Models\PluginForms;
use App\Models\PluginInvitationsSettings;
use App\Models\PluginLabels;
use App\Models\PluginParkingLabel;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsAttributes;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsSettings;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesOptions;
use App\Models\ShopExtra;
use App\Models\ShopSettings;
use App\Models\ShopShippings;
use App\Models\WebsiteSetting;

class AdminLanguageController extends \App\Http\Controllers\Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function fields_lang($chiave, $crud, $custom = null){
        $parameters = \Route::current()->parameters();
        $pages = Page::orderBy("name", "asc")->get()->pluck("name", "slug")->toArray();
        $news = BlockNews::whereNull("name")->orderBy("title", "asc")->get()->pluck("title", "slug")->toArray();

        $v_urls = [];
        if($pages){
            foreach ($pages as $slug=>$name){
                $v_urls[$slug] = "Pagina > $name";
            }
        }

        if($news){
            foreach ($news as $slug=>$name){
                $v_urls["news/$slug"] = "News > $name";
            }
        }


        /*$langs_list = AdminLanguage::where("is_active", 1)
            ->where("name", "!=", "it")
            ->get()->pluck("name", "name")->toArray();*/

        $langs_list = AdminLanguage::where("is_active", 1)
            ->orderBy("lft", "asc")
            ->get()->pluck("name", "name")->toArray();


        $langs = [];
       // $langs["it"] = "it";
        if($langs_list){
            foreach ($langs_list as $lang){
                $langs[$lang] = $lang;
            }
        }

        $langs_label = $langs;

        if(count($parameters)){
            $item_id = $parameters['id'];
        }
        $item = null;
        $adminBlock = AdminBlock::where("name", $chiave)->first();

        $customTab = "";
        if($adminBlock){
            switch ($chiave){

                case "blockHtml":
                    $fields = ["content"];
                    $fields_label = ["Contenuto"];
                    $fields_types = ["content"];
                    if(count($parameters)) {
                        $item = BlockHtml::find($item_id);
                    }
                    break;
                case "blockImage":
                    if(count($parameters)) {
                        $fields = ["content"];
                        $fields_types = ["image"];
                        $fields_label = ["Immagine di Header (testata pagina)"];
                        $item = BlockImage::find($item_id);
                        //$field_image = ["content"];
                    }
                    break;
                case "blockNews":
                    $fields = ["title","slug",'abstract','description','category','tag','meta_title', 'meta_description', 'meta_keywords'];
                    $fields_types = ["text", "text", "text", "content", "text", "text", "text",  "text",  "text"];
                    $fields_label = ["Titolo", "Permalink","Riassunto", "Notizia", "Categoria", "Tag", "Meta title", "Meta description", "Meta Keywords"];

                    if(count($parameters)) {
                        $item = BlockNews::find($item_id);
                    }
                    break;
                case "blockSlideshow":
                    $fields = ["title",'abstract','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Sottotitolo", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockSlideshow::find($item_id);
                    }
                    break;
                case "blockHero":
                    $fields = ["title",'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockHero::find($item_id);
                    }
                    break;
                case "blockDocument":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Nome documento", "Descrizione"];
                    if(count($parameters)) {
                        $item = BlockDocument::find($item_id);
                    }
                    break;
                case "blockCarousel":
                    $fields = ["title",'abstract', 'description', 'url_interno','url','button'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Sottotitolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];

                    if(count($parameters)) {
                        $item = BlockCarousel::find($item_id);
                    }
                    break;
                case "blockContact":
                    if(count($parameters)) {
                        $fields = ['title_form','subtitle_form', "object_form", "message_ringraziamento", "content"];
                        $fields_types = ["text", "text", "text", "text", "custom"];
                        $fields_label = ["Titolo form", "Sottotitolo form", "Oggetto email","Messaggio ringraziamento post invio", "Campi"];
                        $item = BlockContact::find($item_id);
                    }
                    break;
                case "blockIcon":
                    $fields = ["title", 'description', 'url_interno', 'url', 'button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Testo", "URL interno", "URL esterno", "Testo pulsante"];

                    if(count($parameters)) {
                        $item = BlockIcon::find($item_id);
                    }
                    break;

                case "blockPluginProduct":
                    $fields = ["title", "description"];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Testo"];

                    if(count($parameters)) {
                        $item = BlockPluginProduct::find($item_id);
                    }
                    break;
                case "blockPluginParking":
                    $fields = ["title", "subtitle", "description", "description_tariffe"];
                    $fields_types = ["text", "content",  "content", "content"];
                    $fields_label = ["Titolo", "Sottotitolo", "Descrizione", "Descrizione tariffe"];

                    if(count($parameters)) {
                        $item = BlockPluginParking::find($item_id);
                    }
                    break;
                case "blockHtmlImage":
                    $fields = ["title",'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockHtmlImage::find($item_id);
                    }
                    break;
                case "blockImageLink":
                    $fields = ["title",'description','text_box_icon','url_interno','url','button'];
                    $fields_types = ["text", "content", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "Testo box Icona", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockImageLink::find($item_id);
                    }
                    break;
                case "blockTab":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Descrizione"];
                    if(count($parameters)) {
                        $item = BlockTab::find($item_id);
                    }
                    break;
                case "blockParallax":
                    $fields = ["title", 'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockParallax::find($item_id);
                    }
                    break;
                case "blockHightlight":
                    $fields = ["title",'abstract','description','url_interno','url','button'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo/Nome", "Sottotitolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockHightlight::find($item_id);
                    }
                    break;

                case "blockPortfolio2":
                    $fields = ['title','description','url_interno','url','button'];
                    $fields_types = ["text", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Sottotitolo", "URL interno", "URL esterno", "Testo pulsante"];

                    if(count($parameters)) {
                        $item = BlockPortfolio2::find($item_id);
                    }
                    break;
                case "blockGallery":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "text"];
                    $fields_label = ["Nome", "Sottotitolo"];
                    if(count($parameters)) {
                        $item = BlockGallery::find($item_id);
                    }
                    break;
                case "blockReference":
                    $fields = ["title",'category','description','url_interno','url','button'];
                    $fields_types = ["text", "text", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Categoria", "Sottotitolo", "URL interno", "URL esterno", "Testo pulsante"];

                    if(count($parameters)) {
                        $item = BlockReference::find($item_id);
                    }
                    break;
                case "blockVideobg":
                    $fields = ["name",'url'];
                    $fields_types = ["text", "video"];
                    $fields_label = ["Titolo", "URL"];
                    if(count($parameters)) {
                        $item = BlockVideobg::find($item_id);
                    }
                    break;
                case "blockFaq":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Domanda", "Risposta"];
                    if(count($parameters)) {
                        $item = BlockFaq::find($item_id);
                    }
                    break;
                case "blockBanner":
                    $fields = ["title",'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockBanner::find($item_id);
                    }
                    break;
                case "blockMetro":
                    $fields = ["title",'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockMetro::find($item_id);
                    }
                    break;
                case "blockHtmlTwocol":
                    $fields = ["title",'description','url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockHtmlTwocol::find($item_id);
                    }
                    break;
                case "blockCollage":
                    $fields = ["title_dx",'title_sx','description_dx','description_sx','url_dx_interno','url_dx','button_dx','url_sx_interno','url_sx','button_sx'];
                    $fields_types = ["text", "text", "content", "content", "select2_from_array", "text", "text","select2_from_array", "text", "text"];
                    $fields_label = ["Titolo destra", "Titolo sinistra", "Descrizione destra", "Descrizione sinistra", "URL destro interno", "URL destro esterno", "Testo pulsante destro", "URL sinistro interno", "URL sinistro esterno", "Testo pulsante sinistro"];
                    if(count($parameters)) {
                        $item = BlockCollage::find($item_id);
                    }
                    break;
                case "blockFlusso":
                    $fields = ["title",'number','description','url_interno','url','button'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Numero", "Descrizione", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockFlusso::find($item_id);
                    }
                    break;
                case "blockTimeline":
                    $fields = ["title",'description','date'];
                    $fields_types = ["text", "content", "text"];
                    $fields_label = ["Titolo", "Descrizione", "Data"];
                    if(count($parameters)) {
                        $item = BlockTimeline::find($item_id);
                    }
                    break;
                case "blockScrollbar":
                    $fields = ["title", 'description', 'url_interno','url','button'];
                    $fields_types = ["text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];

                    if(count($parameters)) {
                        $item = BlockScrollbar::find($item_id);
                    }
                    break;
                case "blockStaff":
                    $fields = ['name_surname','role','phone','email','social_1','url_1','social_2','url_2','social_3','url_3','social_4','url_4','url_interno','url','button'];
                    $fields_types = ["text", "text", "text","text","text","text","text","text","text","text","text","text","select2_from_array", "text", "text"];
                    $fields_label = ["Nome e Cognome", "Ruolo o Reparto", "Telefono", "E-Mail", "Nome Social FACEBOOK", "URL del tuo Profilo/Pagina FACEBOOK", "Nome Social INSTAGRAM", "URL del tuo Profilo/Pagina INSTAGRAM", "Nome Social LINKEDIN", "URL del tuo Profilo/Pagina LINKEDIN", "Nome Social TWITTER", "URL del tuo Profilo/Pagina TWITTER", "URL interno", "URL esterno", "Label pulsante" ];
                    if(count($parameters)) {
                        $item = BlockStaff::find($item_id);
                    }
                    break;
                case "blockContactgmap":
                    $fields = ["subtitle",'title','description','description2'];
                    $fields_types = ["text", "text", "content", "content"];
                    $fields_label = ["Titoletto", "Titolo", "Descrizione", "Descrizione 2"];
                    if(count($parameters)) {
                        $item = BlockContactgmap::find($item_id);
                    }
                    break;
                case "blockVideotut":
                    $fields = ["subtitle",'title','description'];
                    $fields_types = ["text", "text", "content"];
                    $fields_label = ["Titoletto", "Titolo", "Descrizione"];
                    if(count($parameters)) {
                        $item = BlockVideotut::find($item_id);
                    }
                    break;
                case "blockLastwork":
                    $fields = ['subtitle','title','description','url_interno','url','button','workname_1','worktype_1','url_interno_1','url_1','button_1','workname_2','worktype_2','url_interno_2','url_2','button_2','workname_3','worktype_3','url_interno_3','url_3','button_3','workname_4','worktype_4','url_interno_4','url_4','button_4','workname_5','worktype_5','url_interno_5','url_5','button_5','workname_6','worktype_6','url_interno_6','url_6','button_6'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text", "text", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Sotto titolo", "Titolo", "Descrizione generica", "URL interno", "URL esterno", "Label pulsante", "Nome Progetto 1", "Tipologia Sito 1", "URL interno Progetto 1", "URL esterno Progetto 1", "Label pulsante Progetto 1", "Nome Progetto 2", "Tipologia Sito 2", "URL interno Progetto 2", "URL esterno Progetto 2", "Label pulsante Progetto 2", "Nome Progetto 3", "Tipologia Sito 3", "URL interno Progetto 3", "URL esterno Progetto 3", "Label pulsante Progetto 3", "Nome Progetto 4", "Tipologia Sito 4", "URL interno Progetto 4", "URL esterno Progetto 4", "Label pulsante Progetto 4", "Nome Progetto 5", "Tipologia Sito 5", "URL interno Progetto 5", "URL esterno Progetto 5", "Label pulsante Progetto 5", "Nome Progetto 6", "Tipologia Sito 6", "URL interno Progetto 6", "URL esterno Progetto 6", "Label pulsante Progetto 6"];
                    if(count($parameters)) {
                        $item = BlockLastwork::find($item_id);
                    }
                    break;
                case "blockSeparator":
                    $fields = ["title", 'subtitle', 'description', 'url_interno', 'url', 'button'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo 1", "Titolo 2", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockSeparator::find($item_id);
                    }
                    break;
                case "blockOnePhoto":
                    $fields = ["title", 'subtitle', 'description', 'url_interno', 'url', 'button'];
                    $fields_types = ["text", "text", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo 1", "Sotto titolo", "Descrizione", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockOnePhoto::find($item_id);
                    }
                    break;
                case "blockStore":
                    $fields = ["title",'name_company','location', 'category', 'url_interno','url','button'];
                    $fields_types = ["text", "text", "text", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Comune (PR)", "Nome struttura / Centro commerciale o semplicemente indirizzo", "Nome punto vendita/Negozio/Centro", "Regione", "URL interno", "URL esterno", "Nome pulsante"];
                    if(count($parameters)) {
                        $item = BlockStore::find($item_id);
                    }
                    break;
                case "blockBrand":
                    $fields = ['url_interno','url'];
                    $fields_types = ["select2_from_array", "text"];
                    $fields_label = ["URL interno", "URL esterno"];
                    if(count($parameters)) {
                        $item = BlockBrand::find($item_id);
                    }
                    break;
                case "blockPrice":
                    $fields = ['title','license_subtitle','service_title','service_subtitle','listing','description','license_note','url_interno','url','button'];
                    $fields_types = ["text","text","text","text","text","content","text","select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Sotto Titolo Servizio", "Testo Prezzo riga 1", "Testo Prezzo riga 2", "Lista caratteristiche", "Descrizione generica", "Note finali", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockPrice::find($item_id);
                    }
                    break;
                case "blockGrid":
                    $fields = ["title",'description','text_etichetta','url_interno','url','button'];
                    $fields_types = ["text", "content", "text", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Descrizione", "Testo etichetta", "URL interno", "URL esterno", "Testo pulsante"];
                    if(count($parameters)) {
                        $item = BlockGrid::find($item_id);
                    }
                    break;
                case "blockPluginBookingSearchType":
                    $fields = ["description"];
                    $fields_types = ["content"];
                    $fields_label = ["Descrizione"];

                    if(count($parameters)) {
                        $item = BlockPluginBookingSearchType::find($item_id);
                    }
                    break;
                case "blockMetrox":
                    $fields = ["title",'subtitle','description','url_interno','url','button'];
                    $fields_types = ["text", "text", "content", "select2_from_array", "text", "text"];
                    $fields_label = ["Titolo", "Sotto Titolo", "Descrizione", "URL interno", "URL esterno", "Label pulsante"];
                    if(count($parameters)) {
                        $item = BlockMetrox::find($item_id);
                    }
                    break;
                // qui incollo nuovi blocchi futuri


            }


        }else{
            // dopo lo switch creo le nuove regole dei titoli blocchi multilang


            switch ($chiave) {


    // XCONF1 QUI creo i vari case per avere titolo e descrizione nei "CONF" dei blocchi dove mi serve tit e desc multilingua lato front
    // quando cambio il nome del blocco nella parte evidenziata in giallo, devo poi selezionare: App/Model

                case "blockIconConf":
                    $fields = ["title", 'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Testo"];

                    if(count($parameters)) {
                        $item = BlockIcon::find($item_id);
                    }
                    break;

                case "blockNewsConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockNews::find($item_id);
                    }
                    break;

                case "blockGridConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockGrid::find($item_id);
                    }
                    break;

                case "blockReferenceConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockReference::find($item_id);
                    }
                    break;

                case "blockHtmlImageConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Descrizione Lavoro"];

                    if(count($parameters)) {
                        $item = BlockHtmlImage::find($item_id);
                    }
                    break;

                case "blockHightlightConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockHightlight::find($item_id);
                    }
                    break;

                case "blockDocumentConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockDocument::find($item_id);
                    }
                    break;

                case "blockMetroxConf":
                    $fields = ["title",'description'];
                    $fields_types = ["text", "content"];
                    $fields_label = ["Titolo", "Riassunto"];

                    if(count($parameters)) {
                        $item = BlockMetrox::find($item_id);
                    }
                    break;


    // Fine dei nuovi case stampa tit e descr lato front

                case "website":
                    $fields = ["title", "dati", "title_footer_1", "text_footer_1", "title_footer_2",
                        "text_footer_2", "title_footer_3", "text_footer_3",
                        "title_footer_4", "text_footer_4",
                        "meta_description", "meta_keywords", "topbar_contact_description",
                        "offline_description", "popup_title", "popup_text",
                        "iubenda_privacy", "iubenda_cookie", "iubenda_cookie_banner",
                        "iubenda_termini"];
                    $fields_types = ["text", "text", "text", "content","text",
                        "content","text", "content","text", "content", "textarea", "textarea", "text", "content", "text", "content", "textarea", "textarea", "textarea", "textarea"];
                    $fields_label = ["Titolo Sito", "Nome Azienda e P.IVA", "Titolo 1 (Footer)", "Testo 1 (Footer)","Titolo 2 (Footer)", "Testo 2 (Footer)","Titolo 3 (Footer)", "Testo 3 (Footer)",
                        "Titolo 4 (Footer)", "Testo 4 (Footer)", "Meta description", "Meta keywords", "Frase generica (Topbar)",
                        "Testo quando sito è offline", "Titolo Popup", "Testo Popup", "Iubenda Privacy (Footer)", "Iubenda Cookie (Footer)",
                        "Iubenda Banner (Footer)", "Iubenda Termini (footer)"];
                    if(count($parameters)) {
                        $item = WebsiteSetting::find($item_id);
                    }

                    //$customTab = "Iubenda";

                    break;
                case "page":
                    $fields = ["slug", "title_page", "subtitle_page", "color_title_page", "color_subtitle_page", "title", "meta_title", "meta_description", "meta_keywords",'url_interno','url'];
                    $fields_label = ["Permalink (univoco)", "Titolo pagina", "Sottotitolo pagina", "Colore titolo pagina", "Colore sottotitolo pagina", "Titolo nel menu", "Meta title", "Meta description", "Meta keywords", "REDIRECT Url Interno", "REDIRECT Url esterno"];
                    $fields_types = ["text", "text", "text", "color_picker", "color_picker", "text", "text", "text", "text", "select2_from_array", "text"];
                    if (count($parameters)) {
                        $item = Page::find($item_id);
                    }
                    break;
                case "pluginProductsBrands":
                    $fields = ["name",'slug', 'meta_description'];
                    $fields_types = ["text", "text", "text"];
                    $fields_label = ["Nome", "Permalink", "Meta description (max 120 caratteri)"];

                    if(count($parameters)) {
                        $item = PluginProductsBrands::find($item_id);
                    }
                    break;
                case "pluginProductsCategories":
                    $fields = ["name",'slug', 'description', 'meta_description'];
                    $fields_types = ["text", "text", "content", "text"];
                    $fields_label = ["Nome", "Permalink", "Descrizione", "Meta description (max 120 caratteri)"];

                    if(count($parameters)) {
                        $item = PluginProductsCategories::find($item_id);
                    }
                    break;

                case "pluginProductsAttributes":
                    $fields = ["name"];
                    $fields_types = ["text"];
                    $fields_label = ["Nome"];


                    if(count($parameters)) {
                        $item = PluginProductsAttributes::find($item_id);
                    }
                    break;

                case "pluginProductsSettings":
                    $fields = ["title", "subtitle", "no_results", "label_qty_success", "label_qty_error", "message_info_list_products"];
                    $fields_types = ["text", "text", "content", "text", "text", "content"];
                    $fields_label = ["Titolo", "Sottotitolo", "Messaggio nessun risultato prodotti",
                        "Etichetta quando prodotto disponibile (se lasci vuoto verrà visualizzato il numero in magazzino)",
                        "Etichetta quando prodotto esaurito (se lasci vuoto verrà visualizzato il numero in magazzino)", "Messaggio da inserire a fondo pagina nella lista prodotti"];

                    if(count($parameters)) {
                        $item = PluginProductsSettings::find($item_id);
                    }
                    break;


                case "pluginBookingTypes":
                    $fields = ["title", "description", "label_checkout", "info","description_post_register", "email_preconferma", "email", "email_pin", "email_sollecito", "description_reminder"];
                    $fields_types = ["text", "content", "text", "content", "content", "content", "content", "content", "content", "content"];
                    $fields_label = ["Titolo", "Descrizione", "Label checkout", "Messaggio generico da mostrare da non loggato", "Messaggio info aggiunte fine prenotazione", "Testo email ricezione richiesta prenotazione",  "Testo email prenotazione", "Testo email istruzioni PIN", "Testo email sollecito documenti", "Testo promemoria avviso Cliente"];

                    if(count($parameters)) {
                        $item = PluginBookingType::find($item_id);
                    }
                    break;

                case "pluginBookingStatus":
                    $fields = ["name"];
                    $fields_types = ["text"];
                    $fields_label = ["Nome"];

                    if(count($parameters)) {
                        $item = PluginBookingStatus::find($item_id);
                    }
                    break;

                case "pluginBookingSettings":
                    $fields = ["title", "subtitle"];
                    $fields_types = ["text", "text"];
                    $fields_label = ["Titolo", "Sottotitolo"];

                    if(count($parameters)) {
                        $item = PluginBookingSettings::find($item_id);
                    }
                    break;

                case "pluginBookingRooms":
                    $fields = ["name",'abstract', 'description', 'meta_title', 'meta_description', 'meta_key'];
                    $fields_types = ["text", "text", "content", "text", "text", "text"];
                    $fields_label = ["Nome", "Descrizione corta", "Descrizione", "Meta title", "Meta description", "Meta keywords"];

                    if(count($parameters)) {
                        $item = PluginBookingRoom::find($item_id);
                    }
                    break;

                case "pluginProducts":
                    $adminPluginLabels = AdminPlugin::where("name", "pluginLabel")->first();
                    if($adminPluginLabels){
                        $fields = ["name",'slug', 'description_short', 'description', 'meta_title', 'meta_description', 'meta_key', 'tags','custom_1', 'custom_2', 'info_extra_list','title_labels', 'description_labels'];
                        $fields_types = ["text", "text", "text", "content", "text", "text", "text", "text", "text", "text", "content", "text", "content"];
                        $fields_label = ["Nome", "Permalink", "Descrizione corta", "Descrizione", "Meta title", "Meta description", "Meta keywords", "Tags (dividere con virgola)", "Etichetta 1", "Etichetta 2", "Info Extra in lista prodotti", "Titolo Plugin ETICHETTE", "Descrizione Plugin ETICHETTE"];

                    }else{
                        $fields = ["name",'slug', 'description_short', 'description', 'meta_title', 'meta_description', 'meta_key', 'tags','custom_1', 'custom_2', 'info_extra_list'];
                        $fields_types = ["text", "text", "text", "content", "text", "text", "text", "text", "text", "text", "content"];
                        $fields_label = ["Nome", "Permalink", "Descrizione corta", "Descrizione", "Meta title", "Meta description", "Meta keywords", "Tags (dividere con virgola)", "Etichetta 1", "Etichetta 2", "Info Extra in lista prodotti"];
                    }

                    if(count($parameters)) {
                        $item = PluginProducts::find($item_id);
                    }

                    if($custom){
                        $count_variant = PluginProducts::where("group_id", $custom->group_id)->where("is_variant", 1)->count();

                        $item = $custom;

                        $vetNameLang = [];
                        $vetSlugLang = [];
                        $vetDescriptionLang = [];
                        foreach ($langs as $lang) {
                            if($lang != "it"){
                                $vetNameLang[$lang] = "$item->name $count_variant $lang";
                                $vetSlugLang[$lang] = "$item->slug-$count_variant-$lang";
                            }else{
                                $vetNameLang[$lang] = "$item->name $count_variant";
                                $vetSlugLang[$lang] = "$item->slug-$count_variant";
                            }

                            $vetDescriptionLang[$lang] = "$item->description";
                        }

                        $item->name = $vetNameLang;
                        $item->slug = $vetSlugLang;
                        $item->description = $vetDescriptionLang;
                    }

                    break;
                case "pluginProductsContacts":
                    $fields = ['title_form','subtitle_form', "object_form", "message_ringraziamento", "content"];
                    $fields_types = ["text", "text", "text", "text", "custom"];
                    $fields_label = ["Titolo form", "Sottotitolo form", "Oggetto email","Messaggio ringraziamento post invio", "Campi"];
                    if(count($parameters)) {
                        $item = PluginProductsContacts::find($item_id);
                    }
                    break;

                case "pluginProductsOptions":
                    $fields = ['value'];
                    $fields_types = ["text"];
                    $fields_label = ["Valore"];
                    if(count($parameters)) {
                        $item = PluginProductsOptions::find($item_id);
                    }
                    break;
                case "pluginProductsAttachments":
                    $fields = ['name', 'file'];
                    $fields_types = ["text", "browse"];
                    $fields_label = ["Nome", "Allegato"];
                    if(count($parameters)) {
                        $item = PluginProductsAttachments::find($item_id);
                    }
                    break;

                case "pluginProductsLabels":
                    $fields = ['value'];
                    $fields_types = ["text"];
                    $fields_label = ["Valore"];
                    if(count($parameters)) {
                        $item = PluginProductsLabels::find($item_id);
                    }
                    break;
                case "pluginBookingLabels":
                    $fields = ['value'];
                    $fields_types = ["text"];
                    $fields_label = ["Valore"];
                    if(count($parameters)) {
                        $item = PluginBookingLabels::find($item_id);
                    }
                    break;

                case "pluginParkingLabels":
                    $fields = ['value'];
                    $fields_types = ["text"];
                    $fields_label = ["Valore"];
                    if(count($parameters)) {
                        $item = PluginParkingLabel::find($item_id);
                    }
                    break;

                case "pluginCounters":
                    $fields = ['title','description'];
                    $fields_types = ["text", "text"];
                    $fields_label = ["Titolo", "Frase"];
                    if(count($parameters)) {
                        $item = PluginCounter::find($item_id);
                    }
                    break;
                case "labels":
                    $fields = ['value'];
                    $fields_types = ["text"];
                    $fields_label = ["Valore"];
                    if(count($parameters)) {
                        $item = Label::find($item_id);
                    }
                    break;

                case "pluginForms":
                    $fields = ['title_form','subtitle_form', "object_form", "message_ringraziamento", "content"];
                    $fields_types = ["text", "text", "text", "text", "custom"];
                    $fields_label = ["Titolo form", "Sottotitolo form", "Oggetto email","Messaggio ringraziamento post invio", "Campi"];
                    if(count($parameters)) {
                        $item = PluginForms::find($item_id);
                    }
                    break;
                case "pluginInvitationsSettings":
                    $fields = ['description'];
                    $fields_types = ["content"];
                    $fields_label = ["Descrizione"];
                    if(count($parameters)) {
                        $item = PluginInvitationsSettings::find($item_id);
                    }
                    break;

                case "shopSetting":
                    $fields = ["email_subscriptions"];
                    $fields_label = ["Testo email promemoria ABBONAMENTI"];
                    $fields_types = ["content"];
                    if(count($parameters)) {
                        $item = ShopSettings::find($item_id);
                    }
                    break;

                case "shopShipping":
                    $fields = ["email_description"];
                    $fields_label = ["Testo email quando Stato ordine diventerà COMPLETATO"];
                    $fields_types = ["content"];
                    if(count($parameters)) {
                        $item = ShopShippings::find($item_id);
                    }
                    break;

                case "shopExtra":
                    $fields = ["name", "description"];
                    $fields_label = ["Titolo", "Descrizione"];
                    $fields_types = ["text", "text"];
                    if(count($parameters)) {
                        $item = ShopExtra::find($item_id);
                    }
                    break;

                case "pluginBookingServices":
                    $fields = ["name", "description"];
                    $fields_label = ["Nome", "Descrizione"];
                    $fields_types = ["text", "text"];
                    if(count($parameters)) {
                        $item = PluginBookingServices::find($item_id);
                    }
                    break;

                case "pluginBookingPayments":
                    $fields = ["name", "description"];
                    $fields_label = ["Nome", "Descrizione"];
                    $fields_types = ["text", "text"];
                    if(count($parameters)) {
                        $item = PluginBookingPayments::find($item_id);
                    }
                    break;

                case "shopAttributes":
                    $fields = ["name"];
                    $fields_label = ["Nome"];
                    $fields_types = ["text"];
                    if(count($parameters)) {
                        $item = ShopAttributes::find($item_id);
                    }
                    break;

                case "shopAttributesOptions":
                    $fields = ["value"];
                    $fields_label = ["Opzione"];
                    $fields_types = ["text"];
                    if(count($parameters)) {
                        $item = ShopAttributesOptions::find($item_id);
                    }
                    break;

                case "pluginLabels":

                    $fields = ['title','ingredients','description','table_nutr','weight','production','end_date'];
                    $fields_types = ["text", "summernote", "summernote", "summernote", "text", "text", "text"];
                    $fields_label = ["Titolo", "Ingredienti", "Descrizione", "Tabella nutrizionale", "Peso", "Produzione", "Scadenza"];
                    if(count($parameters)) {
                        $item = PluginLabels::find($item_id);
                    }
                    break;
            }
        }

        if($langs) {
            foreach ($langs as $lang) {
                foreach ($fields as $k => $v) {
                    $valore = "";
                    if($item){
                        $valore = $item->getTranslation("$v", $lang);
                    }

                    $typeField = $fields_types[$k];
                    switch ($typeField){

                        // aggiunta Webisland campo data//
                        case "date":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'date_picker',
                                'value' => $valore, //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'attributes' => ['class' => 'form-control', 'id'=> "{$v}_{$lang}"],
                                //'wrapper' => ['class' => 'form-group col-md-6']
                                // lo commento perchè applica col-md-6 a tutti gli input text
                            ]);
                            break;

                        case "time":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'time',
                                'value' => $valore, //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'attributes' => ['class' => 'form-control', 'id'=> "{$v}_{$lang}"],
                                //'wrapper' => ['class' => 'form-group col-md-6']
                                // lo commento perchè applica col-md-6 a tutti gli input text
                            ]);
                            break;

                        // fine aggiunta Webisland

                        case "text":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'text',
                                'value' => trim($valore), //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'attributes' => ['class' => 'form-control', 'id'=> "{$v}_{$lang}"],
                                //'wrapper' => ['class' => 'form-group col-md-6']
                                // lo commento perchè applica col-md-6 a tutti gli input text
                            ]);
                            break;
                        case "color_picker":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'color_picker2',
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'attributes' => ['class' => 'form-control', 'id'=> "{$v}_{$lang}"],
                                'default' => null
                            ]);
                            break;
                        case "textarea":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'textarea',
                                'value' => $valore, //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'attributes' => ['rows' => 10],
                            ]);
                            break;
                        case "content":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'ckeditor',
                                'value' => $valore, //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'options' => ['height' => 400],
                            ]);
                            break;
                        case "summernote":
                            $crud->addField([
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type' => 'summernote',
                                'value' => $valore, //count($parameters) ? $valore : "",
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                               // 'options' => ['height' => 300],
                                'attributes' => ['id'=> "{$v}_{$lang}"],
                                'options' => [
                                    'height' => 300,
                                    /*'toolbar' => [
                                        ['style', ['bold', 'italic', 'underline', 'clear']],
                                        ['font', ['fontname']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'paragraph','table']],
                                        ['misc', ['codeview', 'undo', 'redo']]
                                    ]*/
                                ],
                            ]);
                            break;
                        case "custom":
                            $custom['name'] = $lang == "it" ? "$v" : "{$v}_{$lang}";
                            $custom['label'] = "$fields_label[$k] <em>({$langs_label[$lang]})</em>";
                            $custom['tab'] =  $customTab != "" ? "$customTab $lang" : $lang;
                            $custom['value'] = count($parameters) ? $valore : "";
                            $crud->addField($custom);
                            break;
                        case "image":
                            $crud->addField([
                                'label' => "Immagine <em>($lang)</em>",
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'type' => 'image',
                                'crop' => true, // set to true to allow cropping, false to disable
                                'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
                            ]);
                            break;
                        case "browse":
                            $temp_decode = json_decode($item, true);
                            if($temp_decode === null){
                                $temp_decode[$v] = [];
                            }

                            //dd($temp_decode, $item, $temp_decode[$v]);


                            if($temp_decode[$v] === null){
                                $temp_decode[$v] = [];
                            }

                            $crud->addField([   // Upload
                                'label' => "File <em>($lang)</em>",
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'type'      => 'browse',
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'value' => key_exists($lang, $temp_decode[$v]) ? $temp_decode[$v][$lang] : null,
                                // optional:
                                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
                            ]);

                            break;
                        case "upload":
                            $crud->addField([   // Upload
                                'label' => "File <em>($lang)</em>",
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'type'      => 'upload',
                                'upload'    => true,
                                // optional:
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
                            ]);
                            break;
                        case "select2_from_array":
                            $news = BlockNews::whereNull("name")->orderBy("title", "asc")->get();
                            $pages = Page::orderBy("name", "asc")->get();

                            $v_urls = [];
                            if($pages){
                                foreach ($pages as $itemK){
                                    foreach ($langs as $langAll){
                                        $name = $itemK->getTranslation('title_page', $langAll);
                                        $slug = $itemK->getTranslation('slug', $langAll);

                                        $name_temp = $itemK->name;

                                        if(trim($name) != ""){
                                            $v_urls[$slug] = "Pagina ($langAll) > $name";
                                        }else{
                                            $v_urls[$slug] = "Pagina ($langAll) > $name_temp";
                                        }

                                    }
                                }
                            }

                            if($news){
                                foreach ($news as $itemK){
                                    foreach ($langs as $langAll){
                                        $name = $itemK->getTranslation('title', $langAll);
                                        $slug = $itemK->getTranslation('slug', $langAll);
                                        $v_urls["news/$slug"] = "News ($langAll) > $name";
                                    }
                                }
                            }

                            $crud->addField( [   // select2_from_array
                                'name' => $lang == "it" ? "$v" : "{$v}_{$lang}",
                                'label' => "$fields_label[$k] <em>({$langs_label[$lang]})</em>",
                                'type'        => 'select2_from_array',
                                'options'     => $v_urls,
                                'allows_null' => true,
                                'default'     => '',
                                'wrapper' => ['class' => 'form-group col-md-6'],
                                'tab' => $customTab != "" ? "$customTab $lang" : $lang,
                                'value' => $valore
                            ]);

                            break;
                    }
                }
            }
        }

        return $crud;
    }

    public function store_lang($chiave, $crud, $request){
        /*$langs = AdminLanguage::where("is_active", 1)
            ->where("name", "!=", "it")
            ->get()->pluck("name", "name")->toArray(); */

        $langs = AdminLanguage::where("is_active", 1)
            ->orderBy("lft", "asc")
            ->get()->pluck("name", "name")->toArray();

        $v_langs = [];
        //$v_langs[] = "it";
        if($langs){
            foreach ($langs as $lang){
                $v_langs[] = $lang;
            }
        }



        switch ($chiave){
            case "page":
                $fields = ["slug", "title_page", "subtitle_page", "color_title_page", "color_subtitle_page", "title", "meta_title", "meta_description", "meta_keywords", 'url_interno','url'];
                break;
        }


        foreach ($fields as $k=>$field){
            $vet = [];
            foreach ($v_langs as $t=>$lang){
                $getField = ($lang == "it") ? $field : "{$field}_{$lang}";

                if($lang != "it"){
                    if($request["{$getField}"] === null){
                        if($field == "slug"){
                            $request["{$getField}"] = "{$vet[0]['it']}_en";
                        }else{
                            $request["{$getField}"] = $vet[0]['it'];
                        }
                    }
                }else{
                    if($request["{$getField}"] === null){
                        $request["{$getField}"] = " ";
                    }
                }

                $vet[] = ["$lang" => $request["{$getField}"]];
            }


            $translations = $this->array_flatten($vet, $v_langs);
            $crud->entry->setTranslations($field, $translations);
        }

    }

    public function update_lang($chiave, $crud, $request){
        /*$langs = AdminLanguage::where("is_active", 1)
          ->where("name", "!=", "it")
          ->get()->pluck("name", "name")->toArray(); */

        $langs = AdminLanguage::where("is_active", 1)
            ->orderBy("lft", "asc")
            ->get()->pluck("name", "name")->toArray();

        $v_langs = [];
        //$v_langs[] = "it";
        if($langs){
            foreach ($langs as $lang){
                $v_langs[] = $lang;
            }
        }

        switch ($chiave){


        // XCONF2 qui incollo il secondo case dei futuri nuovi blocchi


            case "blockIconConf":
                $fields = ["title", "description"];
                break;
            case "blockNewsConf":
                $fields = ["title", "description"];
                break;
            case "blockGridConf":
                $fields = ["title", "description"];
                break;
            case "blockReferenceConf":
                $fields = ["title", "description"];
                break;
            case "blockHtmlImageConf":
                $fields = ["title", "description"];
                break;
            case "blockHightlightConf":
                $fields = ["title", "description"];
                break;
            case "blockDocumentConf":
                $fields = ["title", "description"];
                break;
            case "blockMetroxConf":
                $fields = ["title", "description"];
                break;





            // END di XCONF2


            case "blockHtml":
                $fields = ["content"];
                break;
            case "blockImage":
                $fields = ["content"];
                break;
            case "blockNews":
                $fields = ["title",'slug','abstract','description','category','tag','meta_title', 'meta_description', 'meta_keywords'];
                break;
            case "page":
                $fields = ["slug", "title", "meta_title", "meta_description", "meta_keywords", "title_page", "subtitle_page", "color_title_page", "color_subtitle_page",'url_interno','url'];
                break;
            case "blockDocument":
                $fields = ["title", "description"];
                break;
            case "blockContact":
                $fields = ["content", "object_form", "message_ringraziamento", 'title_form','subtitle_form'];
                break;
            case "blockCarousel":
                $fields = ['title','abstract', 'description', 'url_interno','url','button'];
                break;
            case "blockIcon":
                $fields = ["title", "description", 'url_interno', 'url', 'button'];
                break;
            case "blockHtmlImage":
                $fields = ['title', 'description', 'url_interno','url','button'];
                break;
            case "blockImageLink":
                $fields = ['title', 'description', 'text_box_icon', 'url_interno','url','button'];
                break;
            case "blockTab":
                $fields = ['title', 'description'];
                break;
            case "blockPluginProduct":
                $fields = ['title', 'description'];
                break;
            case "blockPluginParking":
                $fields = ['title','subtitle', 'description', 'description_tariffe'];
                break;
            case "blockParallax":
                $fields = ['title', 'description', 'url_interno','url','button'];
                break;
            case "blockHightlight":
                $fields = ['title','abstract','description','url_interno','url','button'];
                break;
            case "blockScrollbar":
                $fields = ["title", 'description', 'url_interno','url','button'];
                break;
            case "blockSlideshow":
                $fields = ["title",'abstract','url_interno','url','button'];
                break;
            case "blockHero":
                $fields = ['title','description','url_interno','url','button'];
                break;
            case "blockPortfolio2":
                $fields = ['title','description','url_interno','url','button'];
                break;

            case "blockGallery":
                $fields = ["title", "description"];
                break;
            case "blockReference":
                $fields = ['title','category','description','url_interno','url','button'];
                break;
            case "blockBanner":
                $fields = ['title','description','url_interno','url','button'];
                break;
            case "blockMetro":
                $fields = ['title','description','url_interno','url','button'];
                break;
            case "blockCollage":
                $fields = ['title_dx','title_sx','description_dx','description_sx','url_dx_interno','url_dx','button_dx','url_sx_interno','url_sx','button_sx'];
                break;
            case "blockHtmlTwocol":
                $fields = ['title','description','url_interno','url','button'];
                break;
            case "blockFlusso":
                $fields = ["title",'number','description','url_interno','url','button'];
                break;
            case "blockTimeline":
                $fields = ["title",'description','date'];
                break;
            case "blockStaff":
                $fields = ['name_surname','role','phone','email','social_1','url_1','social_2','url_2','social_3','url_3','social_4','url_4','url_interno','url','button'];
                break;
            case "blockContactgmap":
                $fields = ['subtitle','title','description','description2'];
                break;
            case "blockVideotut":
                $fields = ['subtitle','title','description'];
                break;
            case "blockLastwork":
                $fields = ['subtitle','title','description','url_interno','url','button','workname_1','worktype_1','url_interno_1','url_1','button_1','workname_2','worktype_2','url_interno_2','url_2','button_2','workname_3','worktype_3','url_interno_3','url_3','button_3','workname_4','worktype_4','url_interno_4','url_4','button_4','workname_5','worktype_5','url_interno_5','url_5','button_5','workname_6','worktype_6','url_interno_6','url_6','button_6'];
                break;
            case "blockSeparator":
                $fields = ['title', 'subtitle', 'description', 'url_interno','url','button'];
                break;
            case "blockOnePhoto":
                $fields = ['title', 'subtitle', 'description', 'url_interno','url','button'];
                break;
            case "blockStore":
                $fields = ['title','name_company','location','category','url_interno','url','button'];
                break;
            case "blockBrand":
                $fields = ['url_interno','url'];
                break;
            case "shopExtra":
                $fields = ['name','description'];
                break;
            case "shopShipping":
                $fields = ['email_description'];
                break;
            case "shopSetting":
                $fields = ['email_subscriptions'];
                break;
            case "blockPrice":
                $fields = ['title','license_subtitle','service_title','service_subtitle','listing','description','license_note','url_interno','url','button'];
                break;
            case "blockGrid":
                $fields = ['title','description','text_etichetta','url_interno','url','button'];
                break;
            case "blockMetrox":
                $fields = ['title','subtitle','description','url_interno','url','button'];
                break;


            // Qui i case dei blocchi Plugins
            case "blockPluginBookingSearchType":
                $fields = ["description"];
                break;
            case "pluginBookingSettings":
                $fields = ["title", "subtitle"];
                break;
            case "pluginProductsBrands":
                $fields = ['name','slug'];
                break;
            case "pluginProductsCategories":
                $fields = ['name','slug','description'];
                break;
            case "pluginProductsSettings":
                $fields = ["title", "subtitle", "no_results", "label_qty_success", "label_qty_error", "message_info_list_products"];
                break;
            case "pluginProductsAttributes":
                $fields = ['name'];
                break;
            case "pluginProductsOptions":
                $fields = ['value'];
                break;
            case "pluginProductsAttachments":
                $fields = ['name', 'file'];
                break;
            case "pluginProductsContacts":
                $fields = ['title_form','subtitle_form', "object_form", "message_ringraziamento", "content"];
                break;
            case "pluginProducts":
                $adminPluginLabels = AdminPlugin::where("name", "pluginLabel")->first();
                if($adminPluginLabels){
                    $fields = ["name",'slug', 'description_short', 'info_extra_list', 'description', 'meta_title', 'meta_description', 'meta_key','tags','custom_1','custom_2', 'title_labels', 'description_labels'];
                }else{
                    $fields = ["name",'slug', 'description_short', 'info_extra_list', 'description', 'meta_title', 'meta_description', 'meta_key','tags','custom_1','custom_2'];
                }

                break;
            case "pluginProductsLabels":
                $fields = ['value'];
                break;
            case "pluginBookingLabels":
                $fields = ['value'];
                break;
            case "pluginParkingLabels":
                $fields = ['value'];
                break;
            case "labels":
                $fields = ['value'];
                break;
            case "blockVideobg":
                $fields = ['name', 'url'];
                break;
            case "blockFaq":
                $fields = ['title', 'description'];
                break;
            case "pluginForms":
                $fields = ['title_form','subtitle_form', "object_form", "message_ringraziamento", "content"];
                break;
            case "pluginCounters":
                $fields = ['title','description'];
                break;
            case "pluginInvitationsSettings":
                $fields = ['description'];
                break;
            case "pluginBookingServices":
                $fields = ["name", "description"];
                break;
            case "pluginBookingTypes":
                $fields = ["title", "description", "label_checkout", "info", "description_post_register", "email_preconferma",  "email", "email_pin", "email_sollecito", "description_reminder"];
                break;
            case "pluginBookingStatus":
                $fields = ["name"];
                break;
            case "pluginBookingPayments":
                $fields = ["name", "description"];
                break;
            case "shopAttributes":
                $fields = ["name"];
                break;
            case "shopAttributesOptions":
                $fields = ["value"];
                break;
            case "pluginBookingRooms":
                $fields = ["name",'abstract', 'description', 'meta_title', 'meta_description', 'meta_key'];
                break;
            case "pluginLabels":
                $fields = ['title','description','ingredients','table_nutr','weight','production','end_date'];
                break;
            case "website":
                $fields = ["title", "dati", "title_footer_1", "text_footer_1", "title_footer_2",
                    "text_footer_2", "title_footer_3", "text_footer_3",
                    "title_footer_4", "text_footer_4",
                    "meta_description", "meta_keywords", "topbar_contact_description",
                    "offline_description", "popup_title", "popup_text",
                    "iubenda_privacy", "iubenda_cookie", "iubenda_cookie_banner",
                    "iubenda_termini"];
                break;
        }

        foreach ($fields as $k=>$field){
            $vet = [];
            foreach ($v_langs as $t=>$lang){
                $getField = ($lang == "it") ? $field : "{$field}_{$lang}";

                if($request["{$getField}"] === null){
                    $request["{$getField}"] = " ";
                }
                $vet[] = ["$lang" => $request["{$getField}"]];
            }

            $translations = $this->array_flatten($vet, $v_langs, $k);
            $crud->entry->setTranslations($field, $translations);
        }
    }


    public function array_flatten($array, $langs, $indice = null) {
        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){
                $return[$key] = reset($value);
                //$return = array_merge($return, \Arr::flatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        $vet = [];
        foreach ($return as $k=>$val){
            if(key_exists($k, $langs)){
                $vet[$langs[$k]] = $val;
            }

        }
        return $vet;
    }

}
