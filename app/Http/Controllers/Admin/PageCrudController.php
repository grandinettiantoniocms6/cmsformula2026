<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use App\Models\AdminLanguage;
use App\Models\AdminPlugin;
use App\Models\BlockImage;
use App\Models\BlockSlideshow;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\WebsiteSetting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class PageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation { clone as traitClone; }
    use \Backpack\EditableColumns\Http\Controllers\Operations\MinorUpdateOperation;


    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        // whatever you want


        $old = Page::find($id);
        // if you still want to call the old clone method
        $this->traitClone($id);
        $new = Page::orderBy("id", "desc")->first();
        $new->is_active = 0;
        $new->save();

        //blocks
        $list = \DB::table("blocks_pages")->where("page_id", $id)
            ->whereNull("deleted_at")->get();
        if($list){
            foreach ($list as $block){
                $adminBlock = \App\Models\AdminBlock::where("name", $block->type)->first();
                if($adminBlock) {
                    $item = \DB::table($adminBlock->name_table)->find($block->obj_id);
                    if($item){
                        $resultArray = json_decode(json_encode($item), true);
                        unset($resultArray['id']);

                        if($block->is_ereditable_from_id){

                            PageBlock::insert([
                                "type" => $block->type,
                                "obj_id" => $block->obj_id,
                                "page_id" => $new->id,
                                "position" => $block->position,
                                "col" => $block->col,
                                "order" => $block->order,
                                "is_active" => $block->is_active,
                                "is_ereditable" => $block->is_ereditable,
                                "is_ereditable_from_id" => $block->is_ereditable_from_id,
                                "created_at" => Carbon::now()->toDateTimeString()
                            ]);

                            if($adminBlock->is_multi == 1){
                                $block_list_items = \DB::table($adminBlock->name_table)->where("block_id", $block->obj_id)->get();
                                if($block_list_items){
                                    foreach ($block_list_items as $bItem){
                                        $resultArray = json_decode(json_encode($bItem), true);
                                        unset($resultArray['id']);

                                        $resultArray['block_id'] = $block->id;
                                        \DB::table($adminBlock->name_table)->insert($resultArray);
                                    }
                                }
                            }

                        }else{
                            \DB::table($adminBlock->name_table)->insert($resultArray);

                            $last = \DB::table($adminBlock->name_table)->where("name", $resultArray['name'])
                                //  ->whereNull("deleted_at")
                                ->orderBy("id", "desc")
                                ->first();

                            if($last){
                                PageBlock::insert([
                                    "type" => $block->type,
                                    "obj_id" => $last->id,
                                    "page_id" => $new->id,
                                    "position" => $block->position,
                                    "col" => $block->col,
                                    "order" => $block->order,
                                    "is_active" => $block->is_active,
                                    "is_ereditable" => $block->is_ereditable,
                                    "is_ereditable_from_id" => $block->is_ereditable_from_id,
                                    "created_at" => Carbon::now()->toDateTimeString()
                                ]);

                                if($adminBlock->is_multi == 1){
                                    $block_list_items = \DB::table($adminBlock->name_table)->where("block_id", $block->obj_id)->get();
                                    if($block_list_items){
                                        foreach ($block_list_items as $bItem){
                                            $resultArray = json_decode(json_encode($bItem), true);
                                            unset($resultArray['id']);

                                            $resultArray['block_id'] = $last->id;
                                            \DB::table($adminBlock->name_table)->insert($resultArray);
                                        }
                                    }
                                }
                            }
                        }


                    }
                }
            }
        }
        //dd($old->id, $new->id);

    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings('pagina', 'pagine');
        $this->crud->setListView(backpack_view('pages'));

        $slug_shop_formula = config('config.slug_shop_formula');
        $slug_plugin_booking = config('config.slug_plugin_booking');

        if(!request()->has('shop') && !request()->has('booking')){
            $this->crud->query->whereNotIn("name", $slug_shop_formula);
            $this->crud->query->whereNotIn("name", $slug_plugin_booking);
        }else{
            if(request()->has('shop')){
                $this->crud->query->whereIn("name", $slug_shop_formula);
            }
            if(request()->has('booking')){
                $this->crud->query->whereIn("name", $slug_plugin_booking);
            }
        }

        $this->crud->query->orderBy("lft", "asc");

        $this->crud->setDefaultPageLength(50);

        if(backpack_user()->roles[0]->id <= 3){
            $this->crud->isReorderEnabled();
        }
    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 3);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        $this->crud->addButtonFromModelFunction('line', 'getMenu', 'getMenu', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model

        $pages_count = Page::count();
        $website = WebsiteSetting::first();
        $number = null;
        if($website->number_max_page){
            $number = $website->number_max_page - $pages_count;
        }

        if($number <= 0){
            $this->crud->removeButton("create");
        }

        $this->crud->removeButton("update");
        $this->crud->removeButton("delete");
        $this->crud->removeButton("show");
        $this->crud->removeButton("clone");

        // Columns.
        $this->crud->setColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'name',
                'label' => 'Nome', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'get_name', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
            [
                'name'  => 'slug',
                'label' => 'Permalink',
                'type'  => 'text',
            ],
            [
                'name'  => 'is_active',
                'label' => 'Visibile',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                'name'  => 'is_in_menu',
                'label' => 'Menu',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
            [
                'name'  => 'is_in_topbar',
                'label' => 'Topbar',
                'type'  => 'editable_switch',

                // Optionals
                // All the options available on editable_checkbox are available here too, plus;
                'color'   => 'success',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ],
        ]);


        $adminPlugin = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->first();
        if($adminPlugin){
            if($adminPlugin->version == 3){
                // simple filter
                $this->crud->addFilter([
                    'type'  => 'simple',
                    'name'  => 'shop',
                    'label' => 'Mostra pagine shop'
                ],
                    false,
                    function() { // if the filter is active
                        // $this->crud->addClause('active'); // apply the "active" eloquent scope
                    } );
            }
        }



        $adminPluginBooking = \App\Models\AdminPlugin::where("name", "pluginBookings")->where("is_active", 1)->first();
        if($adminPluginBooking){
            // simple filter
            $this->crud->addFilter([
                'type'  => 'simple',
                'name'  => 'booking',
                'label' => 'Mostra pagine booking'
            ],
                false,
                function() { // if the filter is active
                    // $this->crud->addClause('active'); // apply the "active" eloquent scope
                } );
        }

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        /*$pages_count = Page::count();
        $website = WebsiteSetting::first();
        $number = null;
        if($website->number_max_page){
            $number = $website->number_max_page - $pages_count;
        }

        if($number <= 0){
            dd("Hai superato il limite di pagine acquistato. Per sbloccare il limite contatta Webisland.");
        }*/

        CRUD::setValidation(PageRequest::class);

        //CRUD::setFromDb(); // fields

        $this->crud->addField([   // CustomHTML
            'name'  => 'separator1',
            'type'  => 'custom_html',
            'value' => '<h5 class="text text-primary mb-0">Impostazioni Pagina</h5>'
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => "Nome",
            'type' => 'text',
            'attributes' => ['class' => 'form-control', 'id'=> "title_page"],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'icon',
            'label' => 'Icona',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $trans = new AdminLanguageController();
        $trans->fields_lang("page", $this->crud);

        $this->crud->addField([   // CustomHTML
            'name'  => 'separator4',
            'type'  => 'custom_html',
            'value' => '<hr><h5 class="text text-primary mb-0">Impostazioni</h5>'
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_in_menu',
            'label' => 'Includere nel menu?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_in_topbar',
            'label' => 'Includere in topbar?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
        ]);

        $adminPlugin = AdminPlugin::where("name", "pluginProducts")->first();
        if($adminPlugin->version >= 2){
            $this->crud->addField([   // Checkbox
                'name'  => 'is_in_search_bar',
                'label' => 'In search bar?',
                'type'  => 'switch',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2'
                ],
            ]);

        }

        $this->crud->addField([   // Checkbox
            'name'  => 'is_in_menu',
            'label' => 'Nel menu?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_in_blank',
            'label' => 'Apertura in nuova finestra?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Visibile nel sito?',
            'type'  => 'switch',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-2'
            ],
        ]);

        $this->crud->addField([   // select2_from_array
            'name'        => 'template',
            'label'       => "Template contenuto",
            'type'        => 'select2_from_array',
            'options'     => config('config.templates'),
            'allows_null' => false,
            'default'     => 'full_page',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $page = Page::where("is_homepage", 1)->first();
        if($page){
            $label = "(Ereditato Home)";
            $v_ = [
                'readonly'    => 'readonly',
                'disabled'    => 'disabled',
            ];
            if(count(\request()->route()->parameters) && \request()->route()->parameters['id'] == $page->id){
                $label = "";
                $v_ = [];
                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_header',
                    'label'       => "Template header $label",
                    'type'        => 'select2_from_array',
                    'options'     => config('config.templates_header'),
                    'allows_null' => false,
                    'default'     => 'full_page',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ],
                    'attributes' => $v_, // change the HTML attributes of your input
                    'value' => $page->template_header
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ]);

                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_footer',
                    'label'       => "Template footer $label",
                    'type'        => 'select2_from_array',
                    'options'     => config('config.templates_footer'),
                    'allows_null' => false,
                    'default'     => 'full_page',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'attributes' => $v_, // change the HTML attributes of your input
                    'value' => $page->template_footer
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ]);
            }else{


                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_header',
                    'type'        => 'hidden',
                    'value' => $page->template_header
                ]);

                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_footer',
                    'type'        => 'hidden',
                    'value' => $page->template_footer
                ]);

                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_header_',
                    'label'       => "Template header $label",
                    'type'        => 'select2_from_array',
                    'options'     => config('config.templates_header'),
                    'allows_null' => false,
                    'default'     => 'full_page',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ],
                    'attributes' => $v_, // change the HTML attributes of your input
                    'value' => $page->template_header
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ]);

                $this->crud->addField([   // select2_from_array
                    'name'        => 'template_footer_',
                    'label'       => "Template footer $label",
                    'type'        => 'select2_from_array',
                    'options'     => config('config.templates_footer'),
                    'allows_null' => false,
                    'default'     => 'full_page',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'attributes' => $v_, // change the HTML attributes of your input
                    'value' => $page->template_footer
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                ]);
            }


        }else{
            $this->crud->addField([   // select2_from_array
                'name'        => 'template_header',
                'label'       => "Template header",
                'type'        => 'select2_from_array',
                'options'     => config('config.templates_header'),
                'allows_null' => false,
                'default'     => 'full_page',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

            $this->crud->addField([   // select2_from_array
                'name'        => 'template_footer',
                'label'       => "Template footer",
                'type'        => 'select2_from_array',
                'options'     => config('config.templates_footer'),
                'allows_null' => false,
                'default'     => 'full_page',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);

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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        //check slug
        $lang = \App::getLocale();
        $slug = $request->get('slug');
        $count = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->count();
        if($count){
            $new_slug = "$slug-$count";
            $request->offsetSet('slug', $new_slug);
        }


        if(strtolower($request->get('name')) == "home"){
            $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
            $request["slug"] = "/";
            foreach ($langs as $l){
               if(key_exists("slug_$l", $request)){
                   $request["slug_$l"] = "/";
               }
            }
        }

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        $lang = new AdminLanguageController();
        $lang->store_lang("page", $this->crud, $request);

        if(strtolower($request->get('name')) == "home"){
            $this->crud->entry->is_homepage = 1;
        }

        // Se metto desc ogni nuovo record aggiunto va all'inizio
        $lft = Page::where("id", "!=", $this->crud->entry->id)
            ->orderBy("lft", "asc")->first();
        if($lft){
            $this->crud->entry->lft = $lft->lft - 1;
        }else{
            $this->crud->entry->lft = 1000;
        }

        $this->crud->entry->parent_id = null;
        $this->crud->entry->depth = 1;

        $this->crud->entry->save();

        //salvo tutte le ereditarietà per la pagina create
        $list = PageBlock::where("is_ereditable", 1)->get();
        if($list){
            foreach ($list as $item){
                $check = PageBlock::where("type", $item->type)->where("obj_id", $item->obj_id)->where("page_id", $this->crud->entry->id)->where("position", $item->position)->first();
                if(!$check){
                    PageBlock::insert([
                        "type" => $item->type,
                        "obj_id" => $item->obj_id,
                        "page_id" => $this->crud->entry->id,
                        "position" => $item->position,
                        "col" => $item->col,
                        "order" => $item->order,
                        "is_active" => $item->is_active,
                        "is_ereditable_from_id" => $item->id,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }

        $header = BlockImage::create([
           "name" => "Header",
           "alpha" => 30,
           "bgcolor" => "#000000",
           "style" => 1
        ]);

        PageBlock::insert([
            "type" => "blockImage",
            "obj_id" => $header->id,
            "page_id" => $this->crud->entry->id,
            "position" => "header",
            "col" => 1,
            "is_active" => 1,
            "created_at" => Carbon::now()->toDateTimeString()
        ]);

        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        if(strtolower($request->get('name')) == "home"){
            $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
            $request["slug"] = "/";
            foreach ($langs as $l){
                if(key_exists("slug_$l", $request->all())){
                    $request["slug_$l"] = "/";
                }
            }
        }

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        $lang = new AdminLanguageController();
        $lang->update_lang("page", $this->crud, $request);

        if(strtolower($request->get('name')) == "home"){
            $this->crud->entry->is_homepage = 1;

            Page::where("id", "!=", $this->crud->entry->id)->update([
               "template_header" => $this->crud->entry->template_header,
               "template_footer" => $this->crud->entry->template_footer
            ]);
        }

        $this->crud->entry->save();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        PageBlock::where("page_id", $id)->delete();

        return $this->crud->delete($id);
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

        $list = Page::get();
        if($list){
            foreach ($list as $item){
                $item->lft = $item->lft * 1000;
                $item->save();
            }
        }

        return 'success for '.$count.' items';
    }
}
