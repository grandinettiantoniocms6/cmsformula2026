<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PluginLabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //\App\Models\PluginProductsLabels::truncate();

        //PLUGIN PRODOTTI V1 E V2

        $vet = [];
        $vet["it"] = "Accessori";
        $vet["en"] = "Accessories";
        $vet["fr"] = "Accessoires";
        $vet["de"] = "Zubehör";
        $vet["es"] = "Accesorios";
        $vet["ru"] = "Аксессуары";
        $vet["srb"] = "Pribor";
        $vet["ro"] = "Accesorii";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "accessori"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Proprietà";
        $vet["en"] = "Proprierties";
        $vet["fr"] = "Proprierties";
        $vet["de"] = "Proprierties";
        $vet["es"] = "Proprierties";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "titolo-options"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Filtri";
        $vet["en"] = "Filters";
        $vet["fr"] = "Filtres";
        $vet["de"] = "Filter";
        $vet["es"] = "filtros";
        $vet["ru"] = "";
        $vet["srb"] = "Filteri";
        $vet["ro"] = "Filtre";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-filtri"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Brand";
        $vet["en"] = "Brand";
        $vet["fr"] = "Marque";
        $vet["de"] = "Filter";
        $vet["es"] = "filtros";
        $vet["ru"] = "";
        $vet["srb"] = "Marka";
        $vet["ro"] = "Marca";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-brand"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tag";
        $vet["en"] = "Tag";
        $vet["fr"] = "ÉTIQUETER";
        $vet["de"] = "SCHILD";
        $vet["es"] = "ETIQUETA";
        $vet["ru"] = "";
        $vet["srb"] = "Tag";
        $vet["ro"] = "Etichetă";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-tag"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cerca";
        $vet["en"] = "Search";
        $vet["fr"] = "Recherche";
        $vet["de"] = "Suchen";
        $vet["es"] = "Buscar";
        $vet["ru"] = "";
        $vet["srb"] = "Pretraga";
        $vet["ro"] = "Căutare";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "cerca"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Categorie";
        $vet["en"] = "Categories";
        $vet["fr"] = "Catégories";
        $vet["de"] = "Kategorien";
        $vet["es"] = "Categorías";
        $vet["ru"] = "xxx";
        $vet["srb"] = "Kategorije";
        $vet["ro"] = "Categorii";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-categorie"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Categorie";
        $vet["en"] = "Categories";
        $vet["fr"] = "Catégories";
        $vet["de"] = "Kategorien";
        $vet["es"] = "Categorías";
        $vet["ru"] = "";
        $vet["srb"] = "Kategorije";
        $vet["ro"] = "Categorii";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "categorie"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Categoria";
        $vet["en"] = "Category";
        $vet["fr"] = "Catégorie";
        $vet["de"] = "Kategorie";
        $vet["es"] = "Categoría";
        $vet["ru"] = "xxx";
        $vet["srb"] = "Kategorija";
        $vet["ro"] = "Categorie";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "categoria"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cod. Art.";
        $vet["en"] = "Sku";
        $vet["fr"] = "UGS";
        $vet["de"] = "Art.-Nr";
        $vet["es"] = "Sku";
        $vet["ru"] = "Артикул";
        $vet["srb"] = "Sku";
        $vet["ro"] = "Sku";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "sku"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tags";
        $vet["en"] = "Tags";
        $vet["fr"] = "Étiqueter";
        $vet["de"] = "Schild";
        $vet["es"] = "Etiquetas";
        $vet["ru"] = "";
        $vet["srb"] = "Oznake";
        $vet["ro"] = "Etichete";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "tags"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Scheda";
        $vet["en"] = "Product detail";
        $vet["fr"] = "Détail du produit";
        $vet["de"] = "Produktdetail";
        $vet["es"] = "Detalle del producto";
        $vet["ru"] = "";
        $vet["srb"] = "Detalj o proizvodu";
        $vet["ro"] = "Detaliile produsului";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "dettaglio-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Descrizione";
        $vet["en"] = "Description";
        $vet["fr"] = "Description";
        $vet["de"] = "Beschreibung";
        $vet["es"] = "Descripción";
        $vet["ru"] = "Описание";
        $vet["srb"] = "Opis";
        $vet["ro"] = "Descriere";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "descrizione-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Proprietà";
        $vet["en"] = "Properties";
        $vet["fr"] = "Propriétés";
        $vet["de"] = "Eigenschaften";
        $vet["es"] = "Propiedades";
        $vet["ru"] = "";
        $vet["srb"] = "Svojstva";
        $vet["ro"] = "Proprietăți";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "proprieta-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Scarica scheda";
        $vet["en"] = "Download datasheet";
        $vet["fr"] = "Télécharger la fiche technique";
        $vet["de"] = "Datenblatt herunterladen";
        $vet["es"] = "Descargar hoja de datos";
        $vet["ru"] = "";
        $vet["srb"] = "Preuzmite list sa podacima";
        $vet["ro"] = "Descărcați fișa de date";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "scarica-pdf"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Allegati";
        $vet["en"] = "Attachments";
        $vet["fr"] = "Pièces jointes";
        $vet["de"] = "Anhänge";
        $vet["es"] = "Archivos adjuntos";
        $vet["ru"] = "";
        $vet["srb"] = "Prilozi";
        $vet["ro"] = "Atasamente";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "allegati-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Altre info & Allegati";
        $vet["en"] = "More info & Attachments";
        $vet["fr"] = "Propriétés et pièces jointes";
        $vet["de"] = "Eigenschaften und Anhänge";
        $vet["es"] = "Propiedades y Adjuntos";
        $vet["ru"] = "";
        $vet["srb"] = "Više informacija i priloga";
        $vet["ro"] = "Mai multe informații și atașamente";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "altre-info"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Quantità";
        $vet["en"] = "Quantity";
        $vet["fr"] = "Quantité";
        $vet["de"] = "Menge";
        $vet["es"] = "Cantidad";
        $vet["ru"] = "";
        $vet["srb"] = "Količina";
        $vet["ro"] = "Cantitate";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "qty"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Richiedi preventivo";
        $vet["en"] = "Request Quote";
        $vet["fr"] = "Citation requise";
        $vet["de"] = "Angebot anfordern";
        $vet["es"] = "Solicitud de cotización";
        $vet["ru"] = "";
        $vet["srb"] = "Zahtevati informaciju";
        $vet["ro"] = "Cerere de informatii";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "richiedi-preventivo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai bisogno di misure personalizzate?";
        $vet["en"] = "Hai bisogno di misure personalizzate?";
        $vet["fr"] = "Hai bisogno di misure personalizzate?";
        $vet["de"] = "Hai bisogno di misure personalizzate?";
        $vet["es"] = "Hai bisogno di misure personalizzate?";
        $vet["ru"] = "Hai bisogno di misure personalizzate?";
        $vet["srb"] = "Hai bisogno di misure personalizzate?";
        $vet["ro"] = "Hai bisogno di misure personalizzate?";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "richiedi-personalizzazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Clicca qui per vedere il prezzo di questo prodotto";
        $vet["en"] = "";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "richiedi-prezzo"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Vedi tutti";
        $vet["en"] = "Show more";
        $vet["fr"] = "Montre plus";
        $vet["de"] = "Zeig mehr";
        $vet["es"] = "Mostrar más";
        $vet["ru"] = "";
        $vet["srb"] = "Prikaži više";
        $vet["ro"] = "Afișați mai multe";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "vedi-tutti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Lista";
        $vet["en"] = "List";
        $vet["fr"] = "Liste";
        $vet["de"] = "Aufführen";
        $vet["es"] = "Lista";
        $vet["ru"] = "Список";
        $vet["srb"] = "Lista";
        $vet["ro"] = "Listă";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "lista-pulsante"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Griglia";
        $vet["en"] = "Grid";
        $vet["fr"] = "Grille";
        $vet["de"] = "Netz";
        $vet["es"] = "Red";
        $vet["ru"] = "";
        $vet["srb"] = "Grid";
        $vet["ro"] = "Grilă";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "lista-griglia"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordina per";
        $vet["en"] = "Sort by";
        $vet["fr"] = "Trier par";
        $vet["de"] = "Sortiere nach";
        $vet["es"] = "Ordenar por";
        $vet["ru"] = "";
        $vet["srb"] = "Sortiraj po";
        $vet["ro"] = "Filtrează după";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "ordina-per"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Mostra";
        $vet["en"] = "View";
        $vet["fr"] = "Voir";
        $vet["de"] = "Sicht";
        $vet["es"] = "Vista";
        $vet["ru"] = "";
        $vet["srb"] = "Pogled";
        $vet["ro"] = "Vedere";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "mostra"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Meno recente";
        $vet["en"] = "Older";
        $vet["fr"] = "Plus ancien";
        $vet["de"] = "Älter";
        $vet["es"] = "Más viejo";
        $vet["ru"] = "";
        $vet["srb"] = "Stariji";
        $vet["ro"] = "Mai batran";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "meno-recente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Più recente";
        $vet["en"] = "Most recent";
        $vet["fr"] = "Le plus récent";
        $vet["de"] = "Neueste";
        $vet["es"] = "Más reciente";
        $vet["ru"] = "";
        $vet["srb"] = "Najnoviji";
        $vet["ro"] = "Cel mai recent";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "piu-recente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Titolo A-Z";
        $vet["en"] = "Title A-Z";
        $vet["fr"] = "Titre de A à Z";
        $vet["de"] = "Titel A-Z";
        $vet["es"] = "Título de la A a la Z";
        $vet["ru"] = "";
        $vet["srb"] = "Naslov A-Z";
        $vet["ro"] = "Titlul A-Z";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "title-az"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Titolo Z-A";
        $vet["en"] = "Title Z-A";
        $vet["fr"] = "Titre de Z à A";
        $vet["de"] = "Titel Z-A";
        $vet["es"] = "Título de la Z a la A";
        $vet["ru"] = "";
        $vet["srb"] = "Naslov Z-A";
        $vet["ro"] = "Titlul Z-A";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "title-za"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prezzo più basso";
        $vet["en"] = "Lowest price";
        $vet["fr"] = "";
        $vet["de"] = "Geringster Preis";
        $vet["es"] = "";
        $vet["ru"] = "Cel mai mic pret";
        $vet["srb"] = "Najniža cena";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "price-az"],[
            "value" => $vet,
        ]);

        $vet["it"] = "Prezzo più alto";
        $vet["en"] = "Higher price";
        $vet["fr"] = "";
        $vet["de"] = "Höherer Preis";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "Viša cena";
        $vet["ro"] = "Pret mai mare";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "price-za"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Descrizione";
        $vet["en"] = "Description";
        $vet["fr"] = "Description";
        $vet["de"] = "Beschreibung";
        $vet["es"] = "Descripción";
        $vet["ru"] = "";
        $vet["srb"] = "Opis";
        $vet["ro"] = "Descriere";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "description-long"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Se già registrato?";
        $vet["en"] = "Already registered?";
        $vet["fr"] = "Déjà enregistré?";
        $vet["de"] = "Bereits registriert?";
        $vet["es"] = "¿Ya registrado?";
        $vet["ru"] = "";
        $vet["srb"] = "Već registrovani?";
        $vet["ro"] = "Deja înregistrat?";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-title-login"],[
            "value" => $vet,
        ]);


        //PLUGIN PRODOTTI V3

        $vet = [];
        $vet["it"] = "Ultimi inseriti";
        $vet["en"] = "Last products";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-ultimi-inseriti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "In vetrina";
        $vet["en"] = "Featured Products";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-in-vetrina"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Più venduti";
        $vet["en"] = "Best Sellers";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-piu-venduti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "In promozione";
        $vet["en"] = "On sale";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-in-promozione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tutti";
        $vet["en"] = "All";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-tutti"],[
            "value" => $vet,
        ]);






        // Label Plugin Prodotti+ShopFormula: pagina cart.blade.php

        $vet = [];
        $vet["it"] = "Carrello";
        $vet["en"] = "Cart";
        $vet["fr"] = "";
        $vet["de"] = "Wagen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "Cart";
        $vet["ro"] = "Cart";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prodotto";
        $vet["en"] = "Product";
        $vet["fr"] = "";
        $vet["de"] = "Produkt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Quantità";
        $vet["en"] = "Quantity";
        $vet["fr"] = "";
        $vet["de"] = "Menge";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello-qta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prezzo";
        $vet["en"] = "Price";
        $vet["fr"] = "";
        $vet["de"] = "Preis";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello-prezzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "Gesamt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello-tot"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Continua lo Shopping";
        $vet["en"] = "Continue Shopping";
        $vet["fr"] = "";
        $vet["de"] = "Mit dem Einkaufen fortfahren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-continua-shopping"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inizia a fare i tuoi acquisti.";
        $vet["en"] = "Start Shopping.";
        $vet["fr"] = "";
        $vet["de"] = "Beginn mit dem Einkauf.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-inizia-acquisti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiorna il Carrello";
        $vet["en"] = "Update Cart";
        $vet["fr"] = "";
        $vet["de"] = "Warenkorb aktualisieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-aggiorna-carello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Riepilogo";
        $vet["en"] = "Summary";
        $vet["fr"] = "";
        $vet["de"] = "Zusammenfassung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-riepilogo-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Subtotale";
        $vet["en"] = "Subtotal";
        $vet["fr"] = "";
        $vet["de"] = "Zwischensumme";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-subtotale-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(Tasse escl.)";
        $vet["en"] = "(Excluded tax)";
        $vet["fr"] = "";
        $vet["de"] = "(Ohne Steuern)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-tasse-escl"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tasse";
        $vet["en"] = "Tax";
        $vet["fr"] = "";
        $vet["de"] = "Steuer";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-tasse"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "Gesamt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-totale-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Completa l'acquisto";
        $vet["en"] = "Checkout";
        $vet["fr"] = "";
        $vet["de"] = "Kasse";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-completa-acquisto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo carrello è vuoto.";
        $vet["en"] = "Your shopping cart is empty.";
        $vet["fr"] = "";
        $vet["de"] = "Dein Einkaufswagen ist leer.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-carrello-vuoto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Continua con gli acquisti";
        $vet["en"] = "Continue shopping";
        $vet["fr"] = "";
        $vet["de"] = "Mit dem Einkaufen fortfahren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-continua-acquisti"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina changePassword.blade.php

        $vet = [];
        $vet["it"] = "Imposta una nuova password";
        $vet["en"] = "Set a new password";
        $vet["fr"] = "";
        $vet["de"] = "Neues Passwort festlegen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-imposta-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sei già registrato?";
        $vet["en"] = "Are you already registered?";
        $vet["fr"] = "";
        $vet["de"] = "Sind Sie bereits registriert?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-gia-registrato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuova Password *";
        $vet["en"] = "New Password *";
        $vet["fr"] = "";
        $vet["de"] = "Neues Passwort *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma Password *";
        $vet["en"] = "Confirm password *";
        $vet["fr"] = "";
        $vet["de"] = "Bestätige das Passwort *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-conferma-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica Password";
        $vet["en"] = "Change Password";
        $vet["fr"] = "";
        $vet["de"] = "Passwort ändern";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-modifica-password"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina checkout.blade.php

        $vet = [];
        $vet["it"] = "Indirizzo di Spedizione";
        $vet["en"] = "Shipping address";
        $vet["fr"] = "";
        $vet["de"] = "Lieferanschrift";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-indirizzo-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome *";
        $vet["en"] = "First Name *";
        $vet["fr"] = "";
        $vet["de"] = "Vorname *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cognome *";
        $vet["en"] = "Last name *";
        $vet["fr"] = "";
        $vet["de"] = "Nachname *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nazione *";
        $vet["en"] = "Country *";
        $vet["fr"] = "";
        $vet["de"] = "Land *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona";
        $vet["en"] = "Select";
        $vet["fr"] = "";
        $vet["de"] = "Wählen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-seleziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Provincia *";
        $vet["en"] = "Province *";
        $vet["fr"] = "";
        $vet["de"] = "Provinz *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-provincia"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzo *";
        $vet["en"] = "Address *";
        $vet["fr"] = "";
        $vet["de"] = "Adresse *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Civico *";
        $vet["en"] = "House number *";
        $vet["fr"] = "";
        $vet["de"] = "Hausnummer *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-civico"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono *";
        $vet["en"] = "Phone *";
        $vet["fr"] = "";
        $vet["de"] = "Telefon *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Note spedizione per questo indirizzo";
        $vet["en"] = "Shipping notes for this address";
        $vet["fr"] = "";
        $vet["de"] = "Versandhinweise für diese Adresse";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-note-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Salva Indirizzo";
        $vet["en"] = "Save Address";
        $vet["fr"] = "";
        $vet["de"] = "Adresse speichern";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-salva-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dati di Fatturazione";
        $vet["en"] = "Billing information";
        $vet["fr"] = "";
        $vet["de"] = "Abrechnungsdaten";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-dati-fatturazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nominativo *";
        $vet["en"] = "Name *";
        $vet["fr"] = "";
        $vet["de"] = "Name *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nominativo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tipo di Cliente";
        $vet["en"] = "Customer type";
        $vet["fr"] = "";
        $vet["de"] = "Kundentyp";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-tipo-cliente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Privato";
        $vet["en"] = "Private customer";
        $vet["fr"] = "";
        $vet["de"] = "Privat";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-privato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Azienda";
        $vet["en"] = "Company";
        $vet["fr"] = "";
        $vet["de"] = "Unternehmen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-azienda"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ragione Sociale *";
        $vet["en"] = "Business name *";
        $vet["fr"] = "";
        $vet["de"] = "Firmenname *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-ragione-sociale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Correlati";
        $vet["en"] = "Related";
        $vet["fr"] = "";
        $vet["de"] = "Verwandt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "admin-tab-correlati"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Email PEC";
        $vet["en"] = "PEC";
        $vet["fr"] = "";
        $vet["de"] = "PEC";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-pec"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Codice SDI";
        $vet["en"] = "SDI Code";
        $vet["fr"] = "";
        $vet["de"] = "SDI";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-sdi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Partita Iva *";
        $vet["en"] = "VAT number *";
        $vet["fr"] = "";
        $vet["de"] = "Umsatzsteuer-Identifikationsnummer *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-piva"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Codice fiscale *";
        $vet["en"] = "Tax ID Code *";
        $vet["fr"] = "";
        $vet["de"] = "Steuernummer *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-codfis"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Partita Iva / Codice fiscale *";
        $vet["en"] = "VAT number / Tax ID code *";
        $vet["fr"] = "";
        $vet["de"] = "Umsatzsteuer-Identifikationsnummer / Steuernummer *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-piva-codfis"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Città *";
        $vet["en"] = "City *";
        $vet["fr"] = "";
        $vet["de"] = "Stadt *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-citta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Provincia *";
        $vet["en"] = "Province *";
        $vet["fr"] = "";
        $vet["de"] = "Provinz *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-provincia"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cap *";
        $vet["en"] = "Zip code *";
        $vet["fr"] = "";
        $vet["de"] = "PLZ *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-cap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi nuovo indirizzo";
        $vet["en"] = "Add New Address";
        $vet["fr"] = "";
        $vet["de"] = "Neue Adresse hinzufügen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-aggiungi-nuovo-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi nuovo indirizzo di fatturazione";
        $vet["en"] = "Add New Billing Address";
        $vet["fr"] = "";
        $vet["de"] = "Neue Rechnungsadresse hinzufügen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-aggiungi-nuovo-indirizzo-fatt"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Coupon";
        $vet["en"] = "Coupon";
        $vet["fr"] = "";
        $vet["de"] = "Coupon";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-coupon"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Disponi di un codice coupon?";
        $vet["en"] = "Do you have a coupon?";
        $vet["fr"] = "";
        $vet["de"] = "Sie besitzen einen coupon?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-hai-coupon"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci qui il codice Coupon:";
        $vet["en"] = "Enter the Coupon code here:";
        $vet["fr"] = "";
        $vet["de"] = "Geben Sie hier den Coupon ein:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-inserisci-coupon"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Applica";
        $vet["en"] = "Apply";
        $vet["fr"] = "";
        $vet["de"] = "Anwenden";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-applica"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Acquista Ora";
        $vet["en"] = "Buy Now";
        $vet["fr"] = "";
        $vet["de"] = "Kaufe jetzt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-acquista-ora"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Riepilogo Ordine";
        $vet["en"] = "Order Summary";
        $vet["fr"] = "";
        $vet["de"] = "Bestellübersicht";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-riepilogo-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(Tasse escl.)";
        $vet["en"] = "(Excluded taxes)";
        $vet["fr"] = "";
        $vet["de"] = "(Ohne Steuern)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-tasse-escl"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tasse";
        $vet["en"] = "Tax";
        $vet["fr"] = "";
        $vet["de"] = "Steuer";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-tasse"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(IVA)";
        $vet["en"] = "(VAT)";
        $vet["fr"] = "";
        $vet["de"] = "(Mehrwertsteuer)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-iva"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "€";
        $vet["en"] = "€";
        $vet["fr"] = "";
        $vet["de"] = "€";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-euro"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Note sull'ordine";
        $vet["en"] = "Order notes";
        $vet["fr"] = "";
        $vet["de"] = "Bestellhinweise";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-note-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Confermando il tuo ordine accetti integralmente le nostre Condizioni generali vendita. L'acquisto sarà completato solo con la conferma di spedizione.";
        $vet["en"] = "By confirming your order you fully accept our General Conditions of Sale. The purchase will be completed only with the shipping confirmation.";
        $vet["fr"] = "";
        $vet["de"] = "Mit der Bestätigung Ihrer Bestellung akzeptieren Sie unsere Allgemeinen Verkaufsbedingungen vollständig. Erst mit der Versandbestätigung wird der Kauf abgeschlossen.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-privacy"],[
            "value" => $vet,
        ]);


        // Label Plugin Prodotti+ShopFormula: pagina checkout_mini.blade.php

        $vet = [];
        $vet["it"] = "Invia ordine";
        $vet["en"] = "Send Order";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung absenden";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkoutmini-invia-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzo di fatturazione diverso da quello di spedizione?";
        $vet["en"] = "Billing address different from the shipping address?";
        $vet["fr"] = "";
        $vet["de"] = "Rechnungsadresse weicht von Lieferadresse ab?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-indirizzo-spedizione-diverso"],[
            "value" => $vet,
        ]);


        // Label Plugin Prodotti+ShopFormula: pagina chechout_nologin.blade.php

        $vet = [];
        $vet["it"] = "Sei già registrato?";
        $vet["en"] = "Already customer?";
        $vet["fr"] = "";
        $vet["de"] = "Bereits Kunde?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nologin-gia-cliente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Clicca quì ed accedi con le tue credenziali.";
        $vet["en"] = "Click here and log in with your credentials.";
        $vet["fr"] = "";
        $vet["de"] = "Klicken Sie hier und melden Sie sich mit Ihren Zugangsdaten an.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nologin-accedi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modalità di pagamento";
        $vet["en"] = "Method of Payment";
        $vet["fr"] = "";
        $vet["de"] = "Bezahlverfahren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-nologin-modalita-pagamento"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina error_facebook.blade.php

        $vet = [];
        $vet["it"] = "Errore da facebook!";
        $vet["en"] = "Error from facebook!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-errore-facebook"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina login.blade.php

        $vet = [];
        $vet["it"] = "Accedi con le tue credenziali";
        $vet["en"] = "Log in with your credentials";
        $vet["fr"] = "";
        $vet["de"] = "Melden Sie sich mit Ihren Zugangsdaten an";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-sottotitolo-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con Facebook";
        $vet["en"] = "Log in with Facebook";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-accedi-fb"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con Google";
        $vet["en"] = "Log in with Google";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-accedi-google"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "";
        $vet["de"] = "E-mail *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password *";
        $vet["en"] = "Password *";
        $vet["fr"] = "";
        $vet["de"] = "Passwort *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-password-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ricordami";
        $vet["en"] = "Remember me";
        $vet["fr"] = "";
        $vet["de"] = "Erinnere dich an mich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-ricorda-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non ricordi la password?";
        $vet["en"] = "Don't remember your password?";
        $vet["fr"] = "";
        $vet["de"] = "Erinnere dich an mich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-password-dimenticata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Login";
        $vet["fr"] = "";
        $vet["de"] = "Anmeldung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuovo Cliente?";
        $vet["en"] = "New Customer?";
        $vet["fr"] = "";
        $vet["de"] = "Neukunde?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-new-customer"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrazione Account";
        $vet["en"] = "Sign in";
        $vet["fr"] = "";
        $vet["de"] = "Anmelden";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registra-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Creando un account potrai effettuare gli acquisti più velocemente, controllare lo stato degli ordini ed avere a disposizione lo storico di tutti gli ordini effettuati.";
        $vet["en"] = "By creating an account you can make purchases faster, check the status of orders and have the history of all orders placed at your disposal.";
        $vet["fr"] = "";
        $vet["de"] = "Durch die Erstellung eines Kontos können Sie schneller einkaufen, den Status von Bestellungen überprüfen und den Verlauf aller aufgegebenen Bestellungen einsehen.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-descrizione-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "";
        $vet["de"] = "Anmelden";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "tramite il form";
        $vet["en"] = "through the form";
        $vet["fr"] = "";
        $vet["de"] = "durch das Formular";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-tramite-form"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina checkout_nologin.blade.php

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "";
        $vet["de"] = "E-mail *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-nologin"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina order_result.blade.php

        $vet = [];
        $vet["it"] = "Conferma Ordine";
        $vet["en"] = "Confirm order";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung bestätigen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-conferma-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Home";
        $vet["en"] = "Home";
        $vet["fr"] = "";
        $vet["de"] = "Startseite";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-home"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Inviato.";
        $vet["en"] = "Order Sent.";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung gesendet.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-inviato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "I miei ordini";
        $vet["en"] = "My orders";
        $vet["fr"] = "";
        $vet["de"] = "Meine Bestellungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-miei-ordini"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung bestätigt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-ordine-confermato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di eseguire il pagamento con PayPal.";
        $vet["en"] = "You have chosen to pay with PayPal.";
        $vet["fr"] = "";
        $vet["de"] = "Sie haben die Zahlung mit PayPal gewählt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-pay-to-paypal"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Esegui il pagamento.";
        $vet["en"] = "Make the payment.";
        $vet["fr"] = "";
        $vet["de"] = "Die Bezahlung durchführen.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-esegui-pagamento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo ordine sarà spedito entro <strong>48 ore lavorative</strong> dall'avvenuto pagamento.";
        $vet["en"] = "Your order will be shipped within <strong> 48 hours </strong> after payment has been made.";
        $vet["fr"] = "";
        $vet["de"] = "Der Versand Ihrer Bestellung erfolgt innerhalb von <strong> 48 Stunden </strong> nach Zahlungseingang.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-avviso-48ore-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung bestätigt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-ordine-confermato-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di pagare in Contrassegno.";
        $vet["en"] = "You have chosen to pay on delivery.";
        $vet["fr"] = "";
        $vet["de"] = "Sie haben die Zahlung per Nachnahme gewählt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-pay-to-contrassegno"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Grazie per il tuo acquisto.";
        $vet["en"] = "Thanks for your purchase.";
        $vet["fr"] = "";
        $vet["de"] = "Danke für ihren Einkauf.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-grazie-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo ordine sarà spedito entro <strong>48 ore lavorative</strong>.";
        $vet["en"] = "Your order will be shipped within <strong>48 hours</strong>.";
        $vet["fr"] = "";
        $vet["de"] = "Ihre Bestellung wird innerhalb von <strong>48 Stunden versendet";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-avviso-48ore-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Se vuoi annullare questo ordine ti preghiamo di contattarci subito tramite chat, telefono o e-mail altrimenti sarà evaso.";
        $vet["en"] = "If you want to cancel this order please contact us immediately via chat, phone or e-mail otherwise it will be processed. ";
        $vet["fr"] = "";
        $vet["de"] = "Wenn Sie diese Bestellung stornieren möchten, kontaktieren Sie uns bitte umgehend per Chat, Telefon oder E-Mail, andernfalls wird der Vorgang bearbeitet.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-annulla-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung bestätigt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-ordine-confermato-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di pagare con Bonifico Bancario.";
        $vet["en"] = "You have chosen to pay by bank transfer.";
        $vet["fr"] = "";
        $vet["de"] = "Sie haben die Zahlung per Banküberweisung gewählt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-pay-to-bonifico"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai cambiato idea?";
        $vet["en"] = "Did you change your mind?";
        $vet["fr"] = "";
        $vet["de"] = "Hast du deine Meinung geändert?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-cambio-tipo-pagamento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Vuoi pagare con Paypal?";
        $vet["en"] = "Do you want to pay with Paypal? ";
        $vet["fr"] = "";
        $vet["de"] = "Möchten Sie mit Paypal bezahlen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-scelgo-paypal"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "Bestellung bestätigt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-ordine-confermato-4"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Pagamento effettuato con successo.";
        $vet["en"] = "Payment made successfully.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-pagamento-ok"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Grazie per il tuo acquisto.";
        $vet["en"] = "Thanks for your purchase.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-grazie-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo ordine sarà spedito entro <strong>48 ore lavorative</strong>.";
        $vet["en"] = "Your order will be shipped within <strong>48 hours</strong>.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-avviso-48ore-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo Ordine";
        $vet["en"] = "Your Order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-tuo-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Torna allo shopping";
        $vet["en"] = "Back to shopping ";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-torna-allo-shopping"],[
            "value" => $vet,
        ]);


        // Label Plugin Prodotti+ShopFormula: pagina order_result_paypal.blade.php

        $vet = [];
        $vet["it"] = "Conferma Ordine";
        $vet["en"] = "Confirm order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-conferma-ordine-pp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-ordine-confermato-pp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di eseguire il pagamento con PayPal.";
        $vet["en"] = "You have chosen to pay with PayPal.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-result-pay-to-paypal-pp"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina promo.blade.php

        $vet = [];
        $vet["it"] = "Offerta scaduta!";
        $vet["en"] = "Offer expired! ";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-promo-scaduta"],[
            "value" => $vet,
        ]);


        // Label Plugin Prodotti+ShopFormula: pagina recovery_password.blade.php

        $vet = [];
        $vet["it"] = "Recupera la tua password";
        $vet["en"] = "Retrieve your password";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Riceverai all'indirizzo E-mail di registrazione un messaggio contenente il link che ti consentirà di impostare una nuova password.";
        $vet["en"] = "You will receive a message at the registration email address containing the link that will allow you to set a new password.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-msg-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Recupera Password";
        $vet["en"] = "Password recovery";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-recupera-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuovo Cliente?";
        $vet["en"] = "New Client?";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-nuovo-cliente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sei già registrato?";
        $vet["en"] = "Are you already registered?";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-gia-registrato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Login";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-recupera-psw-accedi"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina register.blade.php

        $vet = [];
        $vet["it"] = "Registra Account";
        $vet["en"] = "Register Account";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-nuovo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci i tuoi dati in basso. Possiedi già un account?";
        $vet["en"] = "Enter your details below. Do you already have an account?";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-info-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Login";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-accedi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati con Facebook";
        $vet["en"] = "Register with Facebook";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-fb"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con Google";
        $vet["en"] = "Sign in with Google";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-google"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome e Cognome *";
        $vet["en"] = "Name and Surname *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-nome-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci il tuo nome e cognome";
        $vet["en"] = "Please enter your first and last name";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-inserisci-nome-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci E-mail";
        $vet["en"] = "Enter your E-mail";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-inserisci-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua E-mail sarà protetta nel nostro database.";
        $vet["en"] = "Your e-mail will be protected in our database.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-info-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono *";
        $vet["en"] = "Phone *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password *";
        $vet["en"] = "Password *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-psw2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola ed almeno un numero (non può contenere spazi e caratteri speciali).";
        $vet["en"] = "Your password must contain at least 8 characters, one capital letter, one lowercase letter and at least one number (it cannot contain spaces and special characters).";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-info-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma Password";
        $vet["en"] = "Confirm password";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-conferma-psw2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(*) Dichiaro di aver letto e compreso la Privacy Policy e acconsento al trattamento dei miei dati personali per usufruire dei servizi riservati agli utenti registrati.";
        $vet["en"] = "(*) I have read and understood the Privacy Policy and consent to the processing of my personal data to use the services reserved for registered users.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-letto-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Acconsento";
        $vet["en"] = "I agree ";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-acconsento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non Acconsento";
        $vet["en"] = "I do not agree";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-non-acconsento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Autorizzo il trattamento dei miei dati personali, per scopi di profilazione, di marketing e per l'iscrizione alla newsletter.";
        $vet["en"] = "I authorize the processing of my personal data, for profiling, marketing and newsletter subscription purposes.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-info-4"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-registrati-3"],[
            "value" => $vet,
        ]);


        // Label Plugin Prodotti+ShopFormula: pagina inc/addcart.blade.php

        $vet = [];
        $vet["it"] = "Quantità";
        $vet["en"] = "Quantity";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-qta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi al carrello";
        $vet["en"] = "Add to Cart";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-add-to-cart"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prodotto già presente nel tuo carrello";
        $vet["en"] = "Product already in your cart";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-prod-nel-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica Carrello";
        $vet["en"] = "Edit Cart";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-edit-cart"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Completa l'acquisto";
        $vet["en"] = "Complete the purchase";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-completa-acquisto"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Attenzione! Massimo 1 abbonamento puoi acquistare";
        $vet["en"] = "Attenzione! Massimo 1 abbonamento puoi acquistare";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-completa-acquisto-error-abbonamenti"],[
            "value" => $vet,
        ]);



        // Label Plugin Prodotti+ShopFormula: pagina inc/addWISHLIST.blade.php

        $vet = [];
        $vet["it"] = "Rimuovi dai preferiti";
        $vet["en"] = "Remove from Whishlist";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-rimuovi-preferiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi ai preferiti";
        $vet["en"] = "Add to Whishlist";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-aggiungi-preferiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi ed aggiungi ai preferiti";
        $vet["en"] = "Log in and add to Whishlist";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-accedi-aggiungi-preferiti"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina inc/myarea_menu.blade.php

        $vet = [];
        $vet["it"] = "Menu";
        $vet["en"] = "Menu";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-menu-myarea"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il mio account";
        $vet["en"] = "My account";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-mio-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordini";
        $vet["en"] = "Orders";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-ordini"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Abbonamenti";
        $vet["en"] = "Subscriptions";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamenti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "I miei Preferiti";
        $vet["en"] = "My Wishlist";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-whishlist"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzi di Spedizione";
        $vet["en"] = "Shipping Addresses";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-indirizzi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dati di Fatturazione";
        $vet["en"] = "Billing information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-fatturazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Assistenza Clienti";
        $vet["en"] = "Customer service";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-assistenza"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Esci";
        $vet["en"] = "Logout";
        $vet["fr"] = "";
        $vet["de"] = "Ausloggen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-esci"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina inc/productList.blade.php

        $vet = [];
        $vet["it"] = "Area riservata";
        $vet["en"] = "Reserved area";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-area-riservata"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/box_order_shipping.blade.php

        $vet = [];
        $vet["it"] = "Metodo di Spedizione";
        $vet["en"] = "Shipping Method";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-metodo-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non Disponibile";
        $vet["en"] = "Unavailable";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-non-disponibile"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/box_shipping_cities.blade.php

        $vet = [];
        $vet["it"] = "Città *";
        $vet["en"] = "City *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-citta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "CAP *";
        $vet["en"] = "POSTAL CODE *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-cap"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/detail_order.blade.php

        $vet = [];
        $vet["it"] = "Prodotto";
        $vet["en"] = "Product";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-prodotto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Q.tà";
        $vet["en"] = "Qty";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-qta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prezzo unit.";
        $vet["en"] = "Unit price";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-prezzo-unit"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prezzo";
        $vet["en"] = "Price";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-prezzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale (Tasse esc.)";
        $vet["en"] = "Total (Tax excl.)";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tot-tasse-esc"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tasse Iva";
        $vet["en"] = "Taxes VAT";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tasse-iva"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale (Tasse inc.)";
        $vet["en"] = "Total (Tax inc.)";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tot-tasse-inc"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale Coupon";
        $vet["en"] = "Total Coupon";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tot-coupon"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Spedizione";
        $vet["en"] = "Shipping";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tot-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-totale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Spedizione";
        $vet["en"] = "Shipping";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tot-spedizione-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-totale-2"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/method/box_method_payments.blade.php

        $vet = [];
        $vet["it"] = "Modalità di pagamento";
        $vet["en"] = "Method of payment";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-mod-pag"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/method/box_method_shipping.blade.php

        $vet = [];
        $vet["it"] = "Metodo di Spedizione";
        $vet["en"] = "Shipping Method";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-met-sped"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Disponibile esclusivamente con i soli prodotti pronta consegna nel carrello.";
        $vet["en"] = "Available exclusively with only the products ready for delivery in the cart.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-pronta-consegna-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ci dispiace ma non possiamo spedire a questo indirizzo. Contattaci via chat o all'indirizzo E-mail";
        $vet["en"] = "We are sorry but we cannot ship to this address. Contact us via chat or email";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-no-spedizione"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/method/box_shipping.blade.php

        $vet = [];
        $vet["it"] = "Indirizzo di Spedizione";
        $vet["en"] = "Shipping Address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-indirizzo-sped"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(Iva incl.)";
        $vet["en"] = "(VAT incl.)";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-iva-inc"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Spedizione";
        $vet["en"] = "Shipping";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tit-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-tit-totale"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: pagina /partial/method/deteil-order-email.blade.php

        $vet = [];
        $vet["it"] = "Totale prodotti";
        $vet["en"] = "Total products";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-partials-totale-prodotti"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/address.blade.php

        $vet = [];
        $vet["it"] = "Nuovo indirizzo";
        $vet["en"] = "New address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nuovo-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica indirizzo";
        $vet["en"] = "Change Address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-mod-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Home";
        $vet["en"] = "Home";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-home"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzi di Spedizione";
        $vet["en"] = "Shipping Addresses";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-indirizzi-spedizione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "* Campi con asterisco sono obbligatori";
        $vet["en"] = "* Fields with an asterisk are required ";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-campi-obbligatori"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nominativo / Ragione Sociale *";
        $vet["en"] = "Name / Company name *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nome-azienda"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Elimina indirizzo di Spedizione";
        $vet["en"] = "Delete Shipping address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-elimina-indirizzo-sped"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Salva nuovo indirizzo di Spedizione";
        $vet["en"] = "Save new shipping address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-salva-nuovo-indirizzo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica indirizzo di Spedizione";
        $vet["en"] = "Change Shipping Address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-mod-ind-spedizione"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/addresses.blade.php

        $vet = [];
        $vet["it"] = "Aggiungi Indirizzo di Spedizione";
        $vet["en"] = "Add Shipping Address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-aggiungi-ind-sped"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica";
        $vet["en"] = "Edit";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-modifica"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/companies.blade.php

        $vet = [];
        $vet["it"] = "Dati di Fatturazione";
        $vet["en"] = "Billing information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-dati-fatturazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi Dati di Fatturazione";
        $vet["en"] = "Add Billing Information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-aggiungi-dati-fatt"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Partita Iva";
        $vet["en"] = "VAT number";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-piva"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Codice Fiscale";
        $vet["en"] = "Fiscal code";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-fiscalcode"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/company.blade.php

        $vet = [];
        $vet["it"] = "Nuovi dati di Fatturazione";
        $vet["en"] = "New Billing information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nuovi-dati-fatturazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica dati di Fatturazione";
        $vet["en"] = "Edit Billing Information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-mod-dati-fatt"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Partita Iva";
        $vet["en"] = "VAT number";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-piva"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Elimina dati di Fatturazione";
        $vet["en"] = "Delete billing data";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-elimina-dati-fatt"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Salva nuovi dati di Fatturazione";
        $vet["en"] = "Save new billing data";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-salva-nuovi-dati-fatt"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/dashoboard.blade.php

        $vet = [];
        $vet["it"] = "Il mio Account";
        $vet["en"] = "My Account";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-mio-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Informazioni Account";
        $vet["en"] = "Account Information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-info-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-Mail";
        $vet["en"] = "E-Mail";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nazionalità *";
        $vet["en"] = "Nationality *";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nazionalita"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non specificato";
        $vet["en"] = "Not specified";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-non-specificato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accessi";
        $vet["en"] = "Accesses";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-accessi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Vecchia Password";
        $vet["en"] = "Old password";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-vecchia-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuova Password";
        $vet["en"] = "New Password";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica dati";
        $vet["en"] = "Edit Data";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-modifica-dati"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/order_detail.blade.php

        $vet = [];
        $vet["it"] = "Dettaglio Ordine";
        $vet["en"] = "Order Detail";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-dettaglio-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine N.";
        $vet["en"] = "Order N. ";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-ordine-num"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data:";
        $vet["en"] = "Date:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-data"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Metodo di pagamento";
        $vet["en"] = "Payment method";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-metodo-di-pagamento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine Confermato.";
        $vet["en"] = "Order Confirmed.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-ordine-confermato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di pagare con";
        $vet["en"] = "You have chosen to pay with";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-hai-scelto-di-pagare-con"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Paga adesso";
        $vet["en"] = "Pay Now";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-paga-adesso"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Gift Card numero:";
        $vet["en"] = "Gift Card number:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-gift-card-numero"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Valore consumato:";
        $vet["en"] = "Consumed value:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-valore-consumato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Note Ordine";
        $vet["en"] = "Order note";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-note-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzo di fatturazione";
        $vet["en"] = "Billing address";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-indirizzo-fatturazione"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/order.blade.php

        $vet = [];
        $vet["it"] = "Storico Ordini";
        $vet["en"] = "Orders history";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-storico-ordini"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine";
        $vet["en"] = "Order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data e ora";
        $vet["en"] = "Date and time";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-data-ora"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Stato";
        $vet["en"] = "Status";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-stato-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-totale-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Richiedi Assistenza su questo ordine";
        $vet["en"] = "Request assistance on this order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-richiedi-assistenza-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun ordine effettuato.";
        $vet["en"] = "No orders found.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nessun-ordine-trovato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Abbonamenti";
        $vet["en"] = "Subscription";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-title-checkout-subscriptions"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nominativo Abbonamento";
        $vet["en"] = "Subscription name";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-name-checkout-subscriptions"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun abbonamento effettuato.";
        $vet["en"] = "No subscriptions found.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-nessun-abbonamento-trovato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome";
        $vet["en"] = "Name";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-nome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nominativo";
        $vet["en"] = "Nominative";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-nominativo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inizio";
        $vet["en"] = "Start";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-inizio"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Fine";
        $vet["en"] = "End";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-fine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Stato";
        $vet["en"] = "Status";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-stato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine";
        $vet["en"] = "Order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-abbonamento-ordine"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/support.blade.php

        $vet = [];
        $vet["it"] = "Per qualsiasi informazione sul tuo ordine, contattaci.";
        $vet["en"] = "For any information about your order, contact us.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-info-ordine-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Scrivici una mail";
        $vet["en"] = "Write us an mail";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-scrivici"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Chiamaci al numero:";
        $vet["en"] = "Call us at:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-chiamaci"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai bisogno di supporto per un ordine in particolare?";
        $vet["en"] = "Do you need support for a particular order?";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Compilare il modulo sottostante per richiedere assistenza";
        $vet["en"] = "Fill out the form below to request support";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-compila-modulo-assistenza"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Numero d'ordine";
        $vet["en"] = "Order number";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-numero-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Del";
        $vet["en"] = "Of";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-del"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona l'ordine per il quale richiedi supporto";
        $vet["en"] = "Select the order for which you ask support";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-ordine-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Oggetto dell'Assistenza";
        $vet["en"] = "Subject of Assistance";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-oggetto-richiesta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica Ordine";
        $vet["en"] = "Change order";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-modifica-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cancellazione Ordine";
        $vet["en"] = "Order cancellation";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-cancella-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Spedizione Ordine";
        $vet["en"] = "Order delivery";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-spedizione-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Pagamento Ordine";
        $vet["en"] = "Order payment";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-pagamento-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Altro";
        $vet["en"] = "Other";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-altro"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Messaggio";
        $vet["en"] = "Message";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-messaggio"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Richiedi Assistenza";
        $vet["en"] = "Request Assistance";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-supporto-invia-richiesta"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /myarea/wishlist.blade.php

        $vet = [];
        $vet["it"] = "I miei Preferiti";
        $vet["en"] = "My favorites";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-wishlist-miei-preferiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Preferiti";
        $vet["en"] = "Whishlist";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-wishlist-preferiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Disponibile";
        $vet["en"] = "Available";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-wishlist-disponibile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non disponibile";
        $vet["en"] = "Unavailable";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-wishlist-non-disponibile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun prodotto inserito nei preferiti.";
        $vet["en"] = "No products added to favorites.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-wishlist-no-prodotti"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: /common/pluginProducts/shop/

        $vet = [];
        $vet["it"] = "In evidenza";
        $vet["en"] = "Highlights";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-in-evidenza"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Attenzione:";
        $vet["en"] = "Attention:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-attenzione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prodotto non disponibile";
        $vet["en"] = "Product not available";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-prodotto-non-disponibile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nel carrello:";
        $vet["en"] = "In the cart:";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-nel-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prodotto già nel carrello";
        $vet["en"] = "Product already in the cart";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-prodotto-gia-nel-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi e aggiungi ai preferiti";
        $vet["en"] = "Log in and add to favorites";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-accedi-e-aggiungi-preferiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "SRP";
        $vet["en"] = "SRP";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-srp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Colore";
        $vet["en"] = "Color";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-colore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Guida alle taglie";
        $vet["en"] = "Size Guide";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "Водич за величину";
        $vet["ro"] = "Ghid marimi";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-guida-alle-teglie"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Chiudi";
        $vet["en"] = "Close";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "Близу";
        $vet["ro"] = "Închide";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-chiudi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai";
        $vet["en"] = "You have";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-hai"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "prodotti di";
        $vet["en"] = "products of";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-prodotti-di"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "nel carrello!";
        $vet["en"] = "in the cart!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-nel-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai nel carrello";
        $vet["en"] = "You have in the cart";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-hai-nel-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "prodotti, vai al carrello!";
        $vet["en"] = "products, go to cart!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varie-prodotti-vai-carello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine concluso con successo!";
        $vet["en"] = "Order completed successfully!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-order-inviato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiunto al carrello!";
        $vet["en"] = "Add to cart!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-alert-aggiunto-al-carrello"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Devi selezionare almeno una quantità!";
        $vet["en"] = "You must select at least one quantity!";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-alert-aggiunto-al-carrello-error"],[
            "value" => $vet,
        ]);

        // Label Plugin Prodotti+ShopFormula: resources/view/common/email/

        $vet = [];
        $vet["it"] = "Questo è il tuo primo ordine su ";
        $vet["en"] = "This is your first order on ";
        $vet["fr"] = "";
        $vet["de"] = "Dies ist Ihre erste Bestellung bei";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-benvenuto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ciao, grazie per aver effettuato il tuo primo ordine. Per poter vedere lo stato dell'ordine accedi con le seguenti credenziali:";
        $vet["en"] = "Hi, thank you for placing your first order. To see the status of the order, log in with the following credentials:";
        $vet["fr"] = "";
        $vet["de"] = "Hallo, danke für Ihre erste Bestellung. Um den Status der Bestellung anzuzeigen, melden Sie sich mit den folgenden Anmeldeinformationen an:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-grazie-primo-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail:";
        $vet["en"] = "E-mail:";
        $vet["fr"] = "";
        $vet["de"] = "E-mail";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-mail"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password:";
        $vet["en"] = "Password:";
        $vet["fr"] = "";
        $vet["de"] = "Passwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi al tuo account";
        $vet["en"] = "Log in to your account";
        $vet["fr"] = "";
        $vet["de"] = "Ins Konto einloggen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-login-page"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Attiva il tuo account";
        $vet["en"] = "Activate your account";
        $vet["fr"] = "";
        $vet["de"] = "aktiviere deinen Account";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-attivazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine n. #";
        $vet["en"] = "Order n. #";
        $vet["fr"] = "";
        $vet["de"] = "Bestell-Nr. #";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-num-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai dimenticato la password?";
        $vet["en"] = "Forget your password?";
        $vet["fr"] = "";
        $vet["de"] = "Passwort vergessen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-dimenticato-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data:";
        $vet["en"] = "Date:";
        $vet["fr"] = "";
        $vet["de"] = "Datum:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-data-ordine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Gift Card numero:";
        $vet["en"] = "Gift Card number:";
        $vet["fr"] = "";
        $vet["de"] = "Geschenkkartennummer:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-gift-card"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Clicca qui sotto per aggiornarla";
        $vet["en"] = "Click here to update it";
        $vet["fr"] = "";
        $vet["de"] = "Klicken Sie hier, um es zu aktualisieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-aggiorna-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica la tua password";
        $vet["en"] = "Change your password";
        $vet["fr"] = "";
        $vet["de"] = "Ändern Sie Ihr Passwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-modifica-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Se il link non dovesse funzionare copialo e incolla sul tuo browser:";
        $vet["en"] = "If the link doesn't work, copy and paste this link into your browser:";
        $vet["fr"] = "";
        $vet["de"] = "Wenn der Link nicht funktioniert, kopieren Sie diesen Link und fügen Sie ihn in Ihren Browser ein:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-link-non-funziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Benvenuto su";
        $vet["en"] = "Welcome to";
        $vet["fr"] = "";
        $vet["de"] = "Willkommen zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-benvenuto-su"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Clicca qui sotto per attivare il tuo profilo";
        $vet["en"] = "Click below to activate your profile";
        $vet["fr"] = "";
        $vet["de"] = "Klicken Sie unten, um Ihr Profil zu aktivieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-email-clicca-attiva-profilo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "COLORE DISPONIBILE";
        $vet["en"] = "AVAILABLE COLOR";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-list-count-singolar-variants"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "COLORI DISPONIBILI";
        $vet["en"] = "AVAILABLE COLOURS";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-list-count-plural-variants"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Richiesta di assistenza inviata con successo";
        $vet["en"] = "Support request sent successfully";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "richiesta-assistenza-inviata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun prodotto trovato";
        $vet["en"] = "No products found";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "Nema pronađenih proizvoda";
        $vet["ro"] = "Nu s-au găsit produse";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "no-results"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Torna indietro";
        $vet["en"] = "Go Back";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-go-back"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiungi";
        $vet["en"] = "Add";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "autocomplete-button-add-cart"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "";
        $vet["en"] = "";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-totale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Iva inclusa";
        $vet["en"] = "VAT included";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-label-iva-inclusa"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Iva esclusa";
        $vet["en"] = "VAT excluded";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-label-iva-esclusa"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I Accept";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I accept";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-registrati-newsletter"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(*) Accetto";
        $vet["en"] = "(*) I accept";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-condition-check"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indirizzo di fatturazione";
        $vet["en"] = "Billing information";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-indirizzo-fatturazione-no-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Condizioni di vendita";
        $vet["en"] = "Terms of sale";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-checkout-condizioni"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Registrazione avvenuta con successo";
        $vet["en"] = "Registration was successful";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "register-message"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Controlla la tua E-mail ed attiva il tuo account entro 72 ore! In caso contrario la richiesta di registrazione verrà annullata.";
        $vet["en"] = "Check your Email and activate your account within 72 hours! Otherwise the registration request will be canceled.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "register-submessage"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "varianti disponibili";
        $vet["en"] = "variants available";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-varianti-disponibili"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Visualizzazione rapida di";
        $vet["en"] = "Quick view of";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-visualizzazione-rapida"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Compara questo articolo";
        $vet["en"] = "Compare this item";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-compara-questo-articolo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Rimuovi da comparazione";
        $vet["en"] = "Remove from comparison";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-rimuovi-da-comparazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci un codice fiscale corretto.";
        $vet["en"] = "Enter a correct tax code.";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-register-codice-fiscale-non-corretto"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Inserisci una Partita Iva valida";
        $vet["en"] = "Enter a valid VAT number";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-register-partitaiva-non-corretta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci un indirizzo email valido";
        $vet["en"] = "Enter a valid email";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-register-email-non-corretta"],[
            "value" => $vet,
        ]);





        // Label Plugin Prodotti+ShopFormula: pagina comparatore.blade.php

        $vet = [];
        $vet["it"] = "Comparatore";
        $vet["en"] = "Compare";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-title-comparatore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Rimuovi";
        $vet["en"] = "Remove";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-rimuovi-comparatore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Proprietà";
        $vet["en"] = "Property";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-proprieta-comparatore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessuna";
        $vet["en"] = "None";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-nessuna-comparatore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun prodotto selezionato";
        $vet["en"] = "No product selected";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-no-prod-sel-comparatore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "AREA PERSONALE";
        $vet["en"] = "Personal Area";
        $vet["fr"] = "";
        $vet["de"] = "Persönlicher Bereich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-title-area-personale"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "AREA RISERVATA";
        $vet["en"] = "Reserved Area";
        $vet["fr"] = "";
        $vet["de"] = "Persönlicher Bereich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-title-area-riservata"],[
            "value" => $vet,
        ]);


        // Nuove label dalla riga successiva


        // ####### PLUGIN BOOKING ######################################

        $vet = [];
        $vet["it"] = "Il mio account";
        $vet["en"] = "My account";
        $vet["fr"] = "";
        $vet["de"] = "Mein Konto";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-mio-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sei nella tua Area Personale";
        $vet["en"] = "Your Personal Area";
        $vet["fr"] = "";
        $vet["de"] = "Sei in deinem persönlichen Bereich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-tua-area-personale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Felice di rivederti!";
        $vet["en"] = "Nice to see you again!";
        $vet["fr"] = "";
        $vet["de"] = "Ich freue mich, Sie wiederzusehen!";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-felice-di-rivederti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dettaglio prenotazione";
        $vet["en"] = "Booking details";
        $vet["fr"] = "";
        $vet["de"] = "Buchungsdetails";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-dettaglio-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Informazioni Account";
        $vet["en"] = "Account Information";
        $vet["fr"] = "";
        $vet["de"] = "Kontoinformationen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-info-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "* I campi contrassegnati con l'asterisco sono obbligatori";
        $vet["en"] = "* Fields marked with an asterisk are mandatory";
        $vet["fr"] = "";
        $vet["de"] = "* Mit einem Sternchen gekennzeichnete Felder sind Pflichtfelder";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-campi-obbligatori"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nominativo / Ragione Sociale *";
        $vet["en"] = "Name / Company Name *";
        $vet["fr"] = "";
        $vet["de"] = "Name / Firmenname *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-nome-azienda"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-Mail";
        $vet["en"] = "E-Mail";
        $vet["fr"] = "";
        $vet["de"] = "E-Mail";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono *";
        $vet["en"] = "Phone *";
        $vet["fr"] = "";
        $vet["de"] = "Telefon *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-checkout-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nazionalità *";
        $vet["en"] = "Nationality *";
        $vet["fr"] = "";
        $vet["de"] = "Staatsangehörigkeit *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-nazionalita"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non specificato";
        $vet["en"] = "Not specified";
        $vet["fr"] = "";
        $vet["de"] = "Nicht angegeben";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-non-specificato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Autorizzo il trattamento dei miei dati personali, per scopi di profilazione, di marketing e per l'iscrizione alla newsletter.";
        $vet["en"] = "I authorize the processing of my personal data, for profiling, marketing and newsletter subscription purposes.";
        $vet["fr"] = "";
        $vet["de"] = "Ich stimme der Verarbeitung meiner personenbezogenen Daten zu Profilierungs-, Marketing- und Newsletterabonnementzwecken zu.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-registrati-info-4"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I accept";
        $vet["fr"] = "";
        $vet["de"] = "Ich akzeptiere";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-registrati-newsletter"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cambio Password";
        $vet["en"] = "Change Password";
        $vet["fr"] = "";
        $vet["de"] = "Kennwort ändern";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-accessi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "* Campi con asterisco sono obbligatori";
        $vet["en"] = "* Fields with an asterisk are required";
        $vet["fr"] = "";
        $vet["de"] = "* Felder mit einem Sternchen sind Pflichtfelder";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-campi-obbligatori"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Vecchia Password";
        $vet["en"] = "Old Password";
        $vet["fr"] = "";
        $vet["de"] = "Altes Passwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-vecchia-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuova Password";
        $vet["en"] = "New Password";
        $vet["fr"] = "";
        $vet["de"] = "Neues Kennwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma la nuova Password *";
        $vet["en"] = "Confirm new password *";
        $vet["fr"] = "";
        $vet["de"] = "Bestätige neues Passwort *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-conferma-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Salve le modifiche";
        $vet["en"] = "Save changes";
        $vet["fr"] = "";
        $vet["de"] = "Hallo Änderungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-modifica-dati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dashboard";
        $vet["en"] = "Dashboard";
        $vet["fr"] = "";
        $vet["de"] = "Armaturenbrett";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-home"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Area Personale";
        $vet["en"] = "Personal Area";
        $vet["fr"] = "";
        $vet["de"] = "Persönlicher Bereich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-myarea-title-area-personale"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Sei già registrato? Esegui il login";
        $vet["en"] = "Are you already a registered customer? Log in";
        $vet["fr"] = "";
        $vet["de"] = "Sind Sie bereits registrierter Kunde? Anmeldung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-title"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Non sei ancora registrato?";
        $vet["en"] = "Not registered yet?";
        $vet["fr"] = "";
        $vet["de"] = "Noch nicht registriert?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-non-hai-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "";
        $vet["de"] = "Registrieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-registrati"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Recupera la tua password";
        $vet["en"] = "Recover your password";
        $vet["fr"] = "";
        $vet["de"] = "Stellen Sie Ihr Passwort wieder her";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-recupera-pwd"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Completa il modulo e ricevi le istruzioni via E-mail per recuperare la tua password";
        $vet["en"] = "Complete the form and receive instructions by E-mail to recover your password";
        $vet["fr"] = "";
        $vet["de"] = "Füllen Sie das Formular aus und erhalten Sie per E-Mail Anweisungen zur Wiederherstellung Ihres Passworts";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-recupera-pwd-info"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci il tuo indirizzo E-mail";
        $vet["en"] = "Please enter your email address";
        $vet["fr"] = "";
        $vet["de"] = "Geben Sie bitte Ihre Email-Adresse ein";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-recupera-pwd-email"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Recupera";
        $vet["en"] = "Recover";
        $vet["fr"] = "";
        $vet["de"] = "Genesen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-recupera-pwd-button"],[
            "value" => $vet,
        ]);



        $vet = [];
        $vet["it"] = "Hai dimenticato la Password?";
        $vet["en"] = "Forgot your password?";
        $vet["fr"] = "";
        $vet["de"] = "Haben Sie Ihr Passwort vergessen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-psw-dimenticata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Login";
        $vet["fr"] = "";
        $vet["de"] = "Einloggen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-login-accedi"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Registra Account";
        $vet["en"] = "Register Account";
        $vet["fr"] = "";
        $vet["de"] = "Account registrieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci i tuoi dati in basso. Possiedi già un account?";
        $vet["en"] = "Enter your details below. Already have an account?";
        $vet["fr"] = "";
        $vet["de"] = "Geben Sie unten Ihre Daten ein. Sie haben bereits ein Konto?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-subtitle"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Nome";
        $vet["en"] = "Name";
        $vet["fr"] = "";
        $vet["de"] = "Name";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-first-name"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cognome";
        $vet["en"] = "Last name";
        $vet["fr"] = "";
        $vet["de"] = "Nachname";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-last-name"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono";
        $vet["en"] = "Phone";
        $vet["fr"] = "";
        $vet["de"] = "Telefon";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-mobile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Crea una password";
        $vet["en"] = "Create a password";
        $vet["fr"] = "";
        $vet["de"] = "Erstellen Sie ein Passwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-create-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma password";
        $vet["en"] = "Confirm password";
        $vet["fr"] = "";
        $vet["de"] = "Bestätige das Passwort";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-confirm-psw"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "La tua password deve contenere almeno 8 caratteri, non può contenere spazi o emoji.";
        $vet["en"] = "Your password must be at least 8 characters, cannot contain spaces or emojis.";
        $vet["fr"] = "";
        $vet["de"] = "Ihr Passwort muss mindestens 8 Zeichen lang sein und darf keine Leerzeichen oder Emojis enthalten.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-register-psw-info"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "(*) Dichiaro di aver letto e compreso la Privacy Policy e acconsento al trattamento dei miei dati personali per usufruire dei servizi riservati agli utenti registrati.";
        $vet["en"] = "(*) I have read and understood the Privacy Policy and consent to the processing of my personal data to use the services reserved for registered users.";
        $vet["fr"] = "";
        $vet["de"] = "Ich habe die Datenschutzerklärung gelesen und verstanden und bin mit der Verarbeitung meiner personenbezogenen Daten zur Nutzung der für registrierte Benutzer reservierten Dienste einverstanden.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-letto-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Acconsento";
        $vet["en"] = "I agree";
        $vet["fr"] = "";
        $vet["de"] = "Ich stimme zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-acconsento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non Acconsento";
        $vet["en"] = "I do not agree";
        $vet["fr"] = "";
        $vet["de"] = "Ich stimme nicht zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-non-acconsento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Autorizzo il trattamento dei miei dati personali, per scopi di profilazione, di marketing e per l'iscrizione alla newsletter.";
        $vet["en"] = "I authorize the processing of my personal data, for profiling, marketing and newsletter subscription purposes.";
        $vet["fr"] = "";
        $vet["de"] = "Ich genehmige die Verarbeitung meiner personenbezogenen Daten für Profilierungs-, Marketing- und Newsletter-Abonnementzwecke.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-info-4"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I Accept";
        $vet["fr"] = "";
        $vet["de"] = "Ich nehme an";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-privacy"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I accept";
        $vet["fr"] = "";
        $vet["de"] = "Ich nehme an";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-registrati-newsletter"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Seleziona il periodo";
        $vet["en"] = "Select the period";
        $vet["fr"] = "";
        $vet["de"] = "Wählen Sie den Zeitraum aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Quando?";
        $vet["en"] = "When?";
        $vet["fr"] = "";
        $vet["de"] = "Wenn?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-quando"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Quanti siete?";
        $vet["en"] = "How many are you?";
        $vet["fr"] = "";
        $vet["de"] = "Wie viele seid ihr?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-quanti"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Quanti bimbi?";
        $vet["en"] = "How many are you?";
        $vet["fr"] = "";
        $vet["de"] = "Wie viele seid ihr?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-quanti-bimbi"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "A che ora?";
        $vet["en"] = "At what time?";
        $vet["fr"] = "";
        $vet["de"] = "Zu welcher Zeit?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-ora"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Da";
        $vet["en"] = "From";
        $vet["fr"] = "";
        $vet["de"] = "Aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-da"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "a";
        $vet["en"] = "to";
        $vet["fr"] = "";
        $vet["de"] = "zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-a"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dalle";
        $vet["en"] = "From";
        $vet["fr"] = "";
        $vet["de"] = "Aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-dalle"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "alle";
        $vet["en"] = "to";
        $vet["fr"] = "";
        $vet["de"] = "zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-alle"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Cerca disponibilità";
        $vet["en"] = "Search availability";
        $vet["fr"] = "";
        $vet["de"] = "Verfügbarkeit suchen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-cerca-button"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inizio";
        $vet["en"] = "Start";
        $vet["fr"] = "";
        $vet["de"] = "Start";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-start"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Fine";
        $vet["en"] = "End";
        $vet["fr"] = "";
        $vet["de"] = "Ende";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-date-end"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Dati - Ospite n.";
        $vet["en"] = "Data - Guest n.";
        $vet["fr"] = "";
        $vet["de"] = "Daten – Gast n.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-partecipant-title"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Nome";
        $vet["en"] = "Name";
        $vet["fr"] = "";
        $vet["de"] = "Name";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-partecipant-first-name"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cognome";
        $vet["en"] = "Last name";
        $vet["fr"] = "";
        $vet["de"] = "Nachname";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-partecipant-last-name"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data di nascita";
        $vet["en"] = "Date of birth";
        $vet["fr"] = "";
        $vet["de"] = "Geburtsdatum";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-partecipant-data"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Continua";
        $vet["en"] = "Continue";
        $vet["fr"] = "";
        $vet["de"] = "Weitermachen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-continua"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona un metodo di pagamento";
        $vet["en"] = "Select a Payment Method";
        $vet["fr"] = "";
        $vet["de"] = "Wählen Sie eine Zahlungsmethode aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-payment-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Adulti";
        $vet["en"] = "Adults";
        $vet["fr"] = "";
        $vet["de"] = "Erwachsene";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-ospiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Acquista e Prenota";
        $vet["en"] = "Buy and Book";
        $vet["fr"] = "";
        $vet["de"] = "Kaufen und buchen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-payment-acquista-prenota"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prenota ora";
        $vet["en"] = "Book now";
        $vet["fr"] = "";
        $vet["de"] = "Buchen Sie jetzt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-payment-prenota"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Riepilogo Prenotazione";
        $vet["en"] = "Reservation Summary";
        $vet["fr"] = "";
        $vet["de"] = "Reservierungsübersicht";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-title"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Quando";
        $vet["en"] = "When";
        $vet["fr"] = "";
        $vet["de"] = "Wenn";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-quando"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Dal";
        $vet["en"] = "From";
        $vet["fr"] = "";
        $vet["de"] = "Aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-dal"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "al";
        $vet["en"] = "to";
        $vet["fr"] = "";
        $vet["de"] = "zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-al"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "alle";
        $vet["en"] = "at";
        $vet["fr"] = "";
        $vet["de"] = "um";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-alle"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "nato/a il";
        $vet["en"] = "born on";
        $vet["fr"] = "";
        $vet["de"] = "Geb. am";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-nato-il"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Servizi aggiuntivi";
        $vet["en"] = "Additional services";
        $vet["fr"] = "";
        $vet["de"] = "Zusatzleitungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-servizi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di eseguire il pagamento con PayPal.";
        $vet["en"] = "You have chosen to pay with PayPal.";
        $vet["fr"] = "";
        $vet["de"] = "Sie haben sich für die Zahlung mit PayPal entschieden.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-order-result-pay-to-paypal"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "N. Adulti";
        $vet["en"] = "N. Guests";
        $vet["fr"] = "";
        $vet["de"] = "N. Gäste";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-n-ospiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "N. Bimbi (0-2)";
        $vet["en"] = "N. Guests (0-2)";
        $vet["fr"] = "";
        $vet["de"] = "N. Gäste (0-2)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-n-ospiti-bimbi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Bimbi";
        $vet["en"] = "Children";
        $vet["fr"] = "";
        $vet["de"] = "Kinder";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-n-bimbi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "N. Notti";
        $vet["en"] = "N. Nights";
        $vet["fr"] = "";
        $vet["de"] = "N. Nächte";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-n-notti"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Ospiti";
        $vet["en"] = "Guests";
        $vet["fr"] = "";
        $vet["de"] = "Gäste";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-ospiti"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "Gesamt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-totale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "giorno";
        $vet["en"] = "day";
        $vet["fr"] = "";
        $vet["de"] = "tag";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-giorno"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "giorni";
        $vet["en"] = "days";
        $vet["fr"] = "";
        $vet["de"] = "tage";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-riassume-giorni"],[
            "value" => $vet,
        ]);



        $vet = [];
        $vet["it"] = "Seleziona una delle soluzioni disponibili";
        $vet["en"] = "Select one of the available solutions";
        $vet["fr"] = "";
        $vet["de"] = "Wählen Sie eine der verfügbaren Lösungen aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona";
        $vet["en"] = "Select";
        $vet["fr"] = "";
        $vet["de"] = "Wählen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-seleziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cambia data";
        $vet["en"] = "Change date";
        $vet["fr"] = "";
        $vet["de"] = "Datum ändern";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-cambia-data"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non disponibile";
        $vet["en"] = "Not available";
        $vet["fr"] = "";
        $vet["de"] = "Nicht verfügbar";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-non-disponibile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessuna soluzione disponibile";
        $vet["en"] = "No solution available";
        $vet["fr"] = "";
        $vet["de"] = "Keine Lösung verfügbar";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-non-disponibile-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Torna nello step precedente e prova a modificare le date oppure il numero di ospiti.";
        $vet["en"] = "Go back to the previous step and try changing the dates or the number of guests.";
        $vet["fr"] = "";
        $vet["de"] = "Gehen Sie zurück zum vorherigen Schritt und versuchen Sie, die Daten oder die Anzahl der Gäste zu ändern.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-rooms-non-disponibile-info"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Seleziona un servizio aggiuntivo";
        $vet["en"] = "Select an additional service";
        $vet["fr"] = "";
        $vet["de"] = "Wählen Sie einen Zusatzdienst aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-services-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Indica la quantità";
        $vet["en"] = "Indicate the quantity";
        $vet["fr"] = "";
        $vet["de"] = "Geben Sie die Menge an";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-services-qty"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona";
        $vet["en"] = "Select";
        $vet["fr"] = "";
        $vet["de"] = "Wählen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-services-seleziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Vuoi pagare con Paypal?";
        $vet["en"] = "Do you want to pay with Paypal?";
        $vet["fr"] = "";
        $vet["de"] = "Möchten Sie mit Paypal bezahlen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-order-result-scelgo-paypal"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessun servizio disponibile";
        $vet["en"] = "No services available";
        $vet["fr"] = "";
        $vet["de"] = "Keine Dienste verfügbar";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-services-no-disponibile"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Potresti essere interessato a queste offerte:";
        $vet["en"] = "You may be interested in these offers:";
        $vet["fr"] = "";
        $vet["de"] = "Diese Angebote könnten Sie interessieren:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offers-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Offerta lampo";
        $vet["en"] = "Lightning offer";
        $vet["fr"] = "";
        $vet["de"] = "Blitzangebot";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offers-label"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Quantità";
        $vet["en"] = "quantity";
        $vet["fr"] = "";
        $vet["de"] = "Quantität";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offers-qty"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona";
        $vet["en"] = "Select";
        $vet["fr"] = "";
        $vet["de"] = "Wählen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offers-seleziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessuna offerta disponibile al momento";
        $vet["en"] = "No offers available at the moment";
        $vet["fr"] = "";
        $vet["de"] = "Zur Zeit sind keine Angebote verfügbar";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offers-no-disponibile"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Strutture";
        $vet["en"] = "Structures";
        $vet["fr"] = "";
        $vet["de"] = "Strukturen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-strutture"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Date";
        $vet["en"] = "Date";
        $vet["fr"] = "";
        $vet["de"] = "Datum";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-date"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Disponibilità";
        $vet["en"] = "Availability";
        $vet["fr"] = "";
        $vet["de"] = "Verfügbarkeit";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-disponibilita"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Servizi";
        $vet["en"] = "Services";
        $vet["fr"] = "";
        $vet["de"] = "Dienstleistungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-servizi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai scelto di pagare con Bonifico Bancario.";
        $vet["en"] = "You have chosen to pay by bank transfer.";
        $vet["fr"] = "";
        $vet["de"] = "Sie haben die Zahlung per Banküberweisung gewählt.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "order-result-pay-to-bonifico"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ospiti";
        $vet["en"] = "Guests";
        $vet["fr"] = "";
        $vet["de"] = "Gäste";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-ospiti"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Offerte";
        $vet["en"] = "Offers";
        $vet["fr"] = "";
        $vet["de"] = "Bietet an";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-offerte"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Checkout";
        $vet["en"] = "Checkout";
        $vet["fr"] = "";
        $vet["de"] = "Kasse";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-step-checkout"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Cosa desideri prenotare?";
        $vet["en"] = "What do you want to book?";
        $vet["fr"] = "";
        $vet["de"] = "Was möchten Sie buchen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-title"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Seleziona";
        $vet["en"] = "Select";
        $vet["fr"] = "";
        $vet["de"] = "Wählen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-seleziona"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sessione scaduta. Torna nella home e inizia una nuova ricerca disponibilità.";
        $vet["en"] = "Session expired. Go back to the home page and start a new availability search.";
        $vet["fr"] = "";
        $vet["de"] = "Sitzung abgelaufen. Kehren Sie zur Startseite zurück und starten Sie eine neue Verfügbarkeitssuche.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-home-sessione-scaduta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ragione Sociale";
        $vet["en"] = "Company";
        $vet["fr"] = "";
        $vet["de"] = "Firma";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-ragione-sociale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Partita Iva/Codice fiscale";
        $vet["en"] = "VAT number/Tax code";
        $vet["fr"] = "";
        $vet["de"] = "Umsatzsteuer-Identifikationsnummer/Steuercode";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-vat"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Pec";
        $vet["en"] = "Pec";
        $vet["fr"] = "";
        $vet["de"] = "Pec";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-pec"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "SDI";
        $vet["en"] = "SDI (electronic invoice code)";
        $vet["fr"] = "";
        $vet["de"] = "SDI (elektronischer Rechnungscode)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-sdi"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Indirizzo";
        $vet["en"] = "Address";
        $vet["fr"] = "";
        $vet["de"] = "Addresse";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-address"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Civico";
        $vet["en"] = "Civic";
        $vet["fr"] = "";
        $vet["de"] = "Bürgerlich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-street"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cap";
        $vet["en"] = "Postal Code";
        $vet["fr"] = "";
        $vet["de"] = "Postleitzahl";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-zip"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Città";
        $vet["en"] = "City";
        $vet["fr"] = "";
        $vet["de"] = "Stadt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-city"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Provincia";
        $vet["en"] = "County";
        $vet["fr"] = "";
        $vet["de"] = "County";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-province"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nazione";
        $vet["en"] = "Country";
        $vet["fr"] = "";
        $vet["de"] = "Nation";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-invoice-state"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Inizia i tuoi acquisti";
        $vet["en"] = "Start your shopping";
        $vet["fr"] = "";
        $vet["de"] = "Beginnen Sie Ihren Einkauf";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-inizia-acquisti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ti serve la fattura? Clicca qui";
        $vet["en"] = "Do you need an invoice? Click here";
        $vet["fr"] = "";
        $vet["de"] = "Sie benötigen eine Rechnung? klicken Sie hier";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-serve-fattura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Servizi inclusi";
        $vet["en"] = "Services included";
        $vet["fr"] = "";
        $vet["de"] = "Inklusivleistungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-servizi-inclusi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "L'offerta scade tra";
        $vet["en"] = "Offer expires in";
        $vet["fr"] = "";
        $vet["de"] = "Angebot läuft ab in";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-offerta-scade"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Controlla la tua casella E-mail per attivare il tuo account e procedere successivamente alla conferma della prenotazione.";
        $vet["en"] = "Check your e-mail box to activate your account and then proceed to confirm the booking.";
        $vet["fr"] = "";
        $vet["de"] = "Überprüfen Sie Ihr E-Mail-Postfach, um Ihr Konto zu aktivieren, und bestätigen Sie anschließend die Buchung.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-controlla-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai cambiato idea?";
        $vet["en"] = "Did you change your mind?";
        $vet["fr"] = "";
        $vet["de"] = "Hast du deine Meinung geändert?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-order-result-cambio-tipo-pagamento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dettaglio prenotazione";
        $vet["en"] = "Booking detail";
        $vet["fr"] = "";
        $vet["de"] = "Buchungsdetails";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-dettaglio-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prenotazione effettuata con successo!";
        $vet["en"] = "Reservation made successfully!";
        $vet["fr"] = "";
        $vet["de"] = "Buchung erfolgreich durchgeführt!";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-dettaglio-prenotazione-success"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Pagamento effettuato il giorno";
        $vet["en"] = "Payment made on the day";
        $vet["fr"] = "";
        $vet["de"] = "Bezahlung am selben Tag";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-dettaglio-prenotazione-effettuato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Hai caricato i documenti per il check in digitale?";
        $vet["en"] = "Have you uploaded the documents for the digital check?";
        $vet["fr"] = "";
        $vet["de"] = "Haben Sie die Unterlagen für den Digital-Check hochgeladen?";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-dettaglio-caricato-doc"],[
            "value" => $vet,
        ]);

        // MYAREA PLUGIN BOOKING

        $vet = [];
        $vet["it"] = "Home";
        $vet["en"] = "Home";
        $vet["fr"] = "";
        $vet["de"] = "Heim";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-home"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Dettaglio Prenotazione";
        $vet["en"] = "Details Booking";
        $vet["fr"] = "";
        $vet["de"] = "Details Reservierung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-dettaglio-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Le mie prenotazioni";
        $vet["en"] = "My reservations";
        $vet["fr"] = "";
        $vet["de"] = "Meine Reservierungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-le-mie-prenotazioni"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Storico prenotazioni";
        $vet["en"] = "Historical reservations";
        $vet["fr"] = "";
        $vet["de"] = "Historische Reservierungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-storico-prenotazioni"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "#ID";
        $vet["en"] = "#ID";
        $vet["fr"] = "";
        $vet["de"] = "#AUSWEIS";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-id"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data inizio";
        $vet["en"] = "Start date";
        $vet["fr"] = "";
        $vet["de"] = "Startdatum";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-data-inizio"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data fine";
        $vet["en"] = "End date";
        $vet["fr"] = "";
        $vet["de"] = "Endtermin";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-data-fine"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cosa";
        $vet["en"] = "What";
        $vet["fr"] = "";
        $vet["de"] = "Was";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-cosa"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Stato";
        $vet["en"] = "State";
        $vet["fr"] = "";
        $vet["de"] = "Zustand";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-stato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Totale";
        $vet["en"] = "Total";
        $vet["fr"] = "";
        $vet["de"] = "Gesamt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-totale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ore";
        $vet["en"] = "Hours";
        $vet["fr"] = "";
        $vet["de"] = "Std";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ore"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Guarda";
        $vet["en"] = "Look";
        $vet["fr"] = "";
        $vet["de"] = "Siehst du";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-guarda-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Paga";
        $vet["en"] = "Pay";
        $vet["fr"] = "";
        $vet["de"] = "Zahlen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-paga"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nessuna prenotazione effettuata";
        $vet["en"] = "No reservations made";
        $vet["fr"] = "";
        $vet["de"] = "Keine Reservierungen vorgenommen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-nessuna-prenotazione-effettuata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Esci";
        $vet["en"] = "Logout";
        $vet["fr"] = "";
        $vet["de"] = "Ausloggen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-esci"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Pagamento effettuato il giorno";
        $vet["en"] = "Payment made on the day";
        $vet["fr"] = "";
        $vet["de"] = "Bezahlung am selben Tag";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-pagamento-effettuato-il-giorno"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ordine N.";
        $vet["en"] = "Order N.";
        $vet["fr"] = "";
        $vet["de"] = "Bestell Nr.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ordine-numero"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Effettuato il";
        $vet["en"] = "Executed on";
        $vet["fr"] = "";
        $vet["de"] = "Ausgeführt auf";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ordine-effettuato-il"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "dal";
        $vet["en"] = "from";
        $vet["fr"] = "";
        $vet["de"] = "aus";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ordine-dal"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "al";
        $vet["en"] = "to";
        $vet["fr"] = "";
        $vet["de"] = "zu";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ordine-al"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Notti";
        $vet["en"] = "Nights";
        $vet["fr"] = "";
        $vet["de"] = "Nächte";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ordine-notti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "N. Ospiti";
        $vet["en"] = "Guests number";
        $vet["fr"] = "";
        $vet["de"] = "Gästeanzahl";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-numero-ospiti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "N. Bambini";
        $vet["en"] = "Number of Children";
        $vet["fr"] = "";
        $vet["de"] = "Anzahl der Kinder";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-numero-bambini"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Servizi aggiuntivi";
        $vet["en"] = "Additional services";
        $vet["fr"] = "";
        $vet["de"] = "Zusatzleistungen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-servizi-aggiuntivi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Effettua quì il Check-in Digitale";
        $vet["en"] = "Perform the Digital Check-in here";
        $vet["fr"] = "";
        $vet["de"] = "Führen Sie hier den Digitalen Check-in durch";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-effettua-check-in-digitale"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ospite #";
        $vet["en"] = "Guest #";
        $vet["fr"] = "";
        $vet["de"] = "Gast #";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-ospite"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome";
        $vet["en"] = "First name";
        $vet["fr"] = "";
        $vet["de"] = "Vorname";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-nome-ospite"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cognome";
        $vet["en"] = "Surname";
        $vet["fr"] = "";
        $vet["de"] = "Nachname";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-cognome-ospite"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data di nascita";
        $vet["en"] = "Date of birth";
        $vet["fr"] = "";
        $vet["de"] = "Geburtsdatum";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-data-di-nascita"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-Mail";
        $vet["en"] = "E-Mail";
        $vet["fr"] = "";
        $vet["de"] = "Email";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono";
        $vet["en"] = "Phone";
        $vet["fr"] = "";
        $vet["de"] = "Telefon";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Numero documento (Carta di Identità o Passporto)";
        $vet["en"] = "Document number (identity card or passport)";
        $vet["fr"] = "";
        $vet["de"] = "Dokumentennummer (Personalausweis oder Reisepass)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-numero-documento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Data di scadenza documento";
        $vet["en"] = "Document expiration date";
        $vet["fr"] = "";
        $vet["de"] = "Ablaufdatum des Dokuments";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-scadenza-documento"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Rilasciato da";
        $vet["en"] = "Issued by";
        $vet["fr"] = "";
        $vet["de"] = "Ausgestellt von";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-documento-rilasciato-da"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Documento File";
        $vet["en"] = "Document File";
        $vet["fr"] = "";
        $vet["de"] = "Dokumentieren Datei";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-documento-file"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Documento caricato";
        $vet["en"] = "Document uploaded";
        $vet["fr"] = "";
        $vet["de"] = "Dokument hochgeladen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-documento-caricato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Aggiorna dati";
        $vet["en"] = "Update data";
        $vet["fr"] = "";
        $vet["de"] = "Daten aktualisieren";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-aggiorna-dati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Prenota la tua vacanza";
        $vet["en"] = "Book your holiday";
        $vet["fr"] = "";
        $vet["de"] = "Buchen Sie Ihren Urlaub";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-prenota-la-tua-vacanza"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ciao";
        $vet["en"] = "Hi";
        $vet["fr"] = "";
        $vet["de"] = "Hallo";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-ciao"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La prenotazione N.";
        $vet["en"] = "Reservation No.";
        $vet["fr"] = "";
        $vet["de"] = "Reservierungsnr.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-prenotazione-n"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "è passata al seguente stato:";
        $vet["en"] = "It has gone to the following state:";
        $vet["fr"] = "";
        $vet["de"] = "ist in den folgenden Zustand übergegangen:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-cambio-stato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Potrai monitorare i futuri aggiornamenti effettuando l'accesso alla tua Area Riservata.";
        $vet["en"] = "You will be able to monitor future updates by logging into your Reserved Area.";
        $vet["fr"] = "";
        $vet["de"] = "Sie können zukünftige Updates überwachen, indem Sie sich in Ihrem reservierten Bereich anmelden.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-monitora-stato-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "nato/a il";
        $vet["en"] = "Born on";
        $vet["fr"] = "";
        $vet["de"] = "Geb. am";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-nato-il"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "a notte";
        $vet["en"] = "for night";
        $vet["fr"] = "";
        $vet["de"] = "für nachts";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-a-notte"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Adulti";
        $vet["en"] = "Adults";
        $vet["fr"] = "";
        $vet["de"] = "Erwachsene";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-adulti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Bambini";
        $vet["en"] = "Children";
        $vet["fr"] = "";
        $vet["de"] = "Kinder";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-bambini"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "bambini per questa camera";
        $vet["en"] = "children for this room";
        $vet["fr"] = "";
        $vet["de"] = "Kinder für dieses Zimmer";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-bambini-per-camera"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Lettini bambini non disponibili per questa camera";
        $vet["en"] = "Beds not available for this room";
        $vet["fr"] = "";
        $vet["de"] = "Für dieses Zimmer sind keine Babybetten verfügbar";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-lettini-non-disponibili"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "già prenotata!";
        $vet["en"] = "already booked!";
        $vet["fr"] = "";
        $vet["de"] = "bereits gebucht!";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-gia-prenotata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "a notte";
        $vet["en"] = "per night";
        $vet["fr"] = "";
        $vet["de"] = "pro Nacht";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-prenota-a-notte"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Riepilogo Prenotazione";
        $vet["en"] = "Reservation Summary";
        $vet["fr"] = "";
        $vet["de"] = "Reservierungsübersicht";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-email-oggetto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua prenotazione N.";
        $vet["en"] = "Your booking No.";
        $vet["fr"] = "";
        $vet["de"] = "Ihre Reservierungsnr.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-la-prenot.num"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "sul sito";
        $vet["en"] = "on the site";
        $vet["fr"] = "";
        $vet["de"] = "auf der Website";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sul-sito"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "ha un nuovo stato:";
        $vet["en"] = "has a new status:";
        $vet["fr"] = "";
        $vet["de"] = "hat einen neuen Zustand:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-ha-nuovo-stato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Puoi controllare lo stato della prenotazione accedendo alla tua MyArea.";
        $vet["en"] = "You can check the status of your reservation by accessing your Area.";
        $vet["fr"] = "";
        $vet["de"] = "Sie können den Status Ihrer Reservierung überprüfen, indem Sie sich in Ihrem Bereich anmelden.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-puoi-controllare-lo-stato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "A presto.";
        $vet["en"] = "See you soon.";
        $vet["fr"] = "";
        $vet["de"] = "Bis bald.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-a-presto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "lo Staff di";
        $vet["en"] = "the Staff of";
        $vet["fr"] = "";
        $vet["de"] = "der Stab von";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-lo-staff-di"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "ti ricorda di caricare, dalla tua Area riservata, tutti i documenti per la prenotazione del giorno:";
        $vet["en"] = "reminds you to upload, from your Reserved Area, all the documents for the reservation of the day:";
        $vet["fr"] = "";
        $vet["de"] = "erinnert Sie daran, aus Ihrem reservierten Bereich alle Dokumente für die Buchung des Tages hochzuladen:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-ti-ricorda-di-caricare-i-documenti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nota: questo messaggio è stato inviato da un indirizzo di notifiche automatiche. In caso di necessitò puoi rispondere a questo messaggio, grazie.";
        $vet["en"] = "Note: This message was sent from an automatic notification address. If necessary, you can reply to this message, thanks.";
        $vet["fr"] = "";
        $vet["de"] = "Hinweis: Diese Nachricht wurde von einer automatischen Benachrichtigungsadresse gesendet. Bei Bedarf können Sie auf diese Nachricht antworten, vielen Dank.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-risposta-automatica"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Il tuo PIN è:";
        $vet["en"] = "Your PIN is:";
        $vet["fr"] = "";
        $vet["de"] = "Ihre PIN lautet:";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-il-tuo-pin"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cordiali saluti.";
        $vet["en"] = "Best regards.";
        $vet["fr"] = "";
        $vet["de"] = "Beste grüße.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-cordiali-saluti"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome tua struttura IT";
        $vet["en"] = "Nome tua struttura EN";
        $vet["fr"] = "";
        $vet["de"] = "Nome tua struttura DE";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-nome-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tuo indirizzo qui";
        $vet["en"] = "Your address here";
        $vet["fr"] = "";
        $vet["de"] = "Ihre Adresse hier";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-indirizzo-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cell.";
        $vet["en"] = "Mobile";
        $vet["fr"] = "";
        $vet["de"] = "Mobiltelefon";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-telefono-label-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "+39 12345678";
        $vet["en"] = "+39 12345678";
        $vet["fr"] = "";
        $vet["de"] = "+39 12345678";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-telefono-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Web";
        $vet["en"] = "Website";
        $vet["fr"] = "";
        $vet["de"] = "Webseite";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-web-label-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "www.tuodominio.com";
        $vet["en"] = "www.tuodominio.com";
        $vet["fr"] = "";
        $vet["de"] = "www.tuodominio.com";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-url-website-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-Mail";
        $vet["en"] = "E-Mail";
        $vet["fr"] = "";
        $vet["de"] = "E-Mail";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-E-mail-label-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua e-mail";
        $vet["en"] = "Your E-Mail";
        $vet["fr"] = "";
        $vet["de"] = "Deine E-Mail";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-email-sollecito-email-struttura"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "PRIVACY";
        $vet["en"] = "PRIVACY";
        $vet["fr"] = "";
        $vet["de"] = "PRIVACY";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-label-privacy-testo-footer"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Questa E-mail e ogni file allegato hanno carattere riservato e sono indirizzati esclusivamente al/ai destinatari in indirizzo. Se non siete destinatari del messaggio, vogliate immediatamente darcene cortese comunicazione e cancellare il messaggio dal Vostro archivio. A norma del Regolamento EU 2016/679 GDPR Vi informiamo che il Vostro nominativo è incluso nei nostri archivi per adempiere ai normali obblighi amministrativi.";
        $vet["en"] = "This email and any attached files are confidential and are addressed exclusively to the addressee(s). If you are not the intended recipient of the message, please immediately inform us and delete the message from your archive. In accordance with EU Regulation 2016/679 GDPR, we inform you that your name is included in our archives to fulfill normal administrative obligations.";
        $vet["fr"] = "";
        $vet["de"] = "Diese E-Mail und alle angehängten Dateien sind vertraulich und ausschließlich an den/die betreffenden Empfänger gerichtet. Sollten Sie nicht der Empfänger der Nachricht sein, teilen Sie uns dies bitte umgehend mit und löschen Sie die Nachricht aus Ihrem Archiv. Gemäß der EU-Verordnung 2016/679 DSGVO informieren wir Sie darüber, dass Ihr Name in unsere Archive aufgenommen wird, um normale Verwaltungspflichten zu erfüllen.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-myarea-privacy-testo-completo-footer-mail"],[
            "value" => $vet,
        ]);




        $vet = [];
        $vet["it"] = "Inserisci una nota";
        $vet["en"] = "Enter a note";
        $vet["fr"] = "";
        $vet["de"] = "Geben Sie eine Notiz ein";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-inserisci-nota"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Comunicaci una nota...";
        $vet["en"] = "Leave us a note...";
        $vet["fr"] = "";
        $vet["de"] = "Schreiben Sie uns eine Nachricht...";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-descrizione-nota"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cambia date";
        $vet["en"] = "Change dates";
        $vet["fr"] = "";
        $vet["de"] = "Termine ändern";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-cambia-date"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Cerca";
        $vet["en"] = "Search";
        $vet["fr"] = "";
        $vet["de"] = "Nahe";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-cerca"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Chiudi";
        $vet["en"] = "Close";
        $vet["fr"] = "";
        $vet["de"] = "Schließen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-chiudi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Check-in";
        $vet["en"] = "Check-in";
        $vet["fr"] = "";
        $vet["de"] = "Check-in";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-check-in"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Check-out";
        $vet["en"] = "Check-out";
        $vet["fr"] = "";
        $vet["de"] = "Check-out";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-check-out"],[
            "value" => $vet,
        ]);





        // ###### PLUGIN PRENOTAZIONE PARKING #####    ###############################################################################


        //plugin Parking
        $vet = [];
        $vet["it"] = "TUTTE LE TARIFFE";
        $vet["en"] = "ALL RATES";
        $vet["fr"] = "";
        $vet["de"] = "ALLE PREISE";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-tutte-le-tariffe"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Giorni";
        $vet["en"] = "Days";
        $vet["fr"] = "";
        $vet["de"] = "Tage";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";


        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-giorni"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Scoperto";
        $vet["en"] = "Scoperto";
        $vet["fr"] = "";
        $vet["de"] = "Entdeckung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-scoperto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Coperto";
        $vet["en"] = "Coperto";
        $vet["fr"] = "";
        $vet["de"] = "Bedeckt";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-coperto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Promozioni";
        $vet["en"] = "Promotions";
        $vet["fr"] = "";
        $vet["de"] = "Werbeaktionen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-promozioni"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Promozioni per";
        $vet["en"] = "Promotions for";
        $vet["fr"] = "";
        $vet["de"] = "Aktionen für";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-promozioni-per"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Chiudi";
        $vet["en"] = "Close";
        $vet["fr"] = "";
        $vet["de"] = "Schließen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-chiudi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "PRENOTA ONLINE";
        $vet["en"] = "PRENOTA ONLINE";
        $vet["fr"] = "";
        $vet["de"] = "BUCHE ONLINE";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-prenota-online"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Tipologia";
        $vet["en"] = "Typology";
        $vet["fr"] = "";
        $vet["de"] = "Typologie";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-tipologia"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Giorno Ingresso";
        $vet["en"] = "Entry Day";
        $vet["fr"] = "";
        $vet["de"] = "Eintrittstag";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-giorno-ingresso"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ora Ingresso";
        $vet["en"] = "Entrance Time";
        $vet["fr"] = "";
        $vet["de"] = "Eintrittszeit";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-ora-ingresso"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Giorno Uscita";
        $vet["en"] = "Exit Day";
        $vet["fr"] = "";
        $vet["de"] = "Austrittstag";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-giorno-uscita"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ora Uscita";
        $vet["en"] = "Exit Time";
        $vet["fr"] = "";
        $vet["de"] = "Ausstiegszeit";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-ora-uscita"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Nome e Cognome";
        $vet["en"] = "Name and surname";
        $vet["fr"] = "";
        $vet["de"] = "Name und Nachname";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-nome-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono";
        $vet["en"] = "Phone";
        $vet["fr"] = "";
        $vet["de"] = "Telefon";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nr. volo di rientro o Città di provenienza del volo";
        $vet["en"] = "Return flight number or City of origin of the flight";
        $vet["fr"] = "";
        $vet["de"] = "Rückflugnummer oder Herkunftsort des Fluges";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-numero-volo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nr. Passeggeri";
        $vet["en"] = "No. of passengers";
        $vet["fr"] = "";
        $vet["de"] = "Anzahl der Passagiere";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-numero-passeggeri"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Targa veicolo (facoltativo)";
        $vet["en"] = "Vehicle registration plate (optional)";
        $vet["fr"] = "";
        $vet["de"] = "Kfz-Kennzeichen (optional)";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-targa-veicolo"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "TOTALE PRENOTAZIONE";
        $vet["en"] = "TOTAL BOOKING";
        $vet["fr"] = "";
        $vet["de"] = "Gesamtreservierung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-totale-prenotazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "INVIA PRENOTAZIONE";
        $vet["en"] = "SEND RESERVATION";
        $vet["fr"] = "";
        $vet["de"] = "RESERVIERUNG SENDEN";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-invia-prenotazione"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Acconsento al Trattamento dei miei Dati Personali nel rispetto della normativa Privacy.";
        $vet["en"] = "I consent to the processing of my personal data in compliance with the Privacy Policy.";
        $vet["fr"] = "";
        $vet["de"] = "Ich stimme der Verarbeitung meiner personenbezogenen Daten in Übereinstimmung mit den Datenschutzgesetzen zu.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Acconsento a ricevere comunicazioni promozionali.";
        $vet["en"] = "I agree to receive promotional communications.";
        $vet["fr"] = "";
        $vet["de"] = "Ich bin damit einverstanden, Werbemitteilungen zu erhalten.";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-newsletter"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Leggi";
        $vet["en"] = "Read";
        $vet["fr"] = "";
        $vet["de"] = "Lesen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-leggi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Invio richiesta";
        $vet["en"] = "Send request";
        $vet["fr"] = "";
        $vet["de"] = "Anfrage wird versendet";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-invio-richiesta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Attenzione! Email non autorizzata!";
        $vet["en"] = "Warning! Email not authorized!";
        $vet["fr"] = "";
        $vet["de"] = "Aufmerksamkeit! Unautorisierte E-Mail!";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-invio-richiesta-ko"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Richiesta inviata con successo!";
        $vet["en"] = "Request sent successfully!";
        $vet["fr"] = "";
        $vet["de"] = "Anfrage erfolgreich gesendet!";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginParkingLabel::firstOrCreate(["key" => "parking-invio-richiesta-ok"],[
            "value" => $vet,
        ]);



        $vet = [];
        $vet["it"] = "Area Riservata";
        $vet["en"] = "My Area";
        $vet["fr"] = "";
        $vet["de"] = "Reservierter Bereich";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "booking-area-riservata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono *";
        $vet["en"] = "Phone *";
        $vet["fr"] = "";
        $vet["de"] = "Telefon *";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\PluginBookingLabels::firstOrCreate(["key" => "shop-checkout-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Esci";
        $vet["en"] = "Logout";
        $vet["fr"] = "";
        $vet["de"] = "Ausloggen";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-esci"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Torna al sito";
        $vet["en"] = "Return to the site";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-myarea-button-homepage"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Compara";
        $vet["en"] = "Compare";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-compara"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Rimuovi da comparazione";
        $vet["en"] = "Remove from comparison";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-rimuovi-da-comparazione"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Vai alla Comparazione";
        $vet["en"] = "Go to Comparison";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\PluginProductsLabels::firstOrCreate(["key" => "shop-vai-alla-comparazione"],[
            "value" => $vet,
        ]);

















    }
}
