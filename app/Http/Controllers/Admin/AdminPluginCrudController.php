<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminPluginRequest;
use App\Models\AdminLanguage;
use App\Models\Page;
use App\Models\PageBlock;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class AdminPluginCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdminPluginCrudController extends CrudController
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
        if(backpack_user()->roles[0]->id != 1){
            die;
        }

        CRUD::setModel(\App\Models\AdminPlugin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/adminPlugin');
        CRUD::setEntityNameStrings('Admin Plugin', 'Admin Plugins');
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
        $this->crud->removeButton("create");
        $this->crud->removeButton("delete");
        //$this->crud->removeButton("update");

        $this->crud->setColumns([
            [
                'name'  => 'label',
                'label' => 'Plugin',
                'type'  => 'text',
            ],
            [
                'name'  => 'name',
                'label' => 'Rotta',
                'type'  => 'text',
            ],
            [
                'name'  => 'version',
                'label' => 'Versione',
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'is_active',
                'label' => 'Attivo', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getIsActive', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 10000, // Limit the number of characters shown
            ],
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
        CRUD::setValidation(AdminPluginRequest::class);

        $this->crud->addField([   // repeatable
            'name'  => 'label',
            'label' => 'Voce menù',
            'type'  => 'text',
        ]);


        $this->crud->addField([   // repeatable
            'name'  => 'version',
            'label' => 'Versione',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'icon',
            'label' => 'Icona',
            'type'  => 'text',
        ]);

        $this->crud->addField([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Attivare Plugin',
            'type'  => 'switch',
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


        if($this->crud->entry->name == "pluginProducts"){
            $lang = "it";
            $pages_dedicated = config('config.slug_shop_formula');
            if($this->crud->entry->version == 3){
                $check = \DB::table('roles')->where("name", "Cliente")->first();
                if(!$check){
                    \DB::table('roles')->insert([
                        "name" => "Cliente",
                        "guard_name" => "web"
                    ]);
                }

                $list = PageBlock::where("is_ereditable", 1)->get();
                $page_home = Page::where("is_homepage", 1)->first();
                foreach ($pages_dedicated as $slug){
                    $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();

                    $v_slug = [];

                    $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
                    foreach ($langs as $l){
                       /*if($l != "it"){
                            $v_slug["$l"] = "$slug-$l";
                        }else{*/
                            $v_slug["$l"] = "$slug";
                        //}
                    }

                    if(!$page){
                        $in_topbar = 0;
                        if($slug == env("SLUG_CART") || $slug == env("SLUG_LOGIN") || $slug == env("SLUG_REGISTER")){
                            $in_topbar = 1;
                        }

                        $page = Page::create([
                            "name" => "$slug",
                            "title" => "$slug",
                            "slug" => $v_slug,
                            "is_in_topbar" => $in_topbar,
                            "is_in_menu" => 0,
                            "is_active" => 1,
                            "template" => $page_home->template,
                            "template_header" => $page_home->template_header,
                            "template_footer" => $page_home->template_footer,
                            "parent_id" => null,
                            "is_homepage" => 0,
                            "title_page" => "$slug"
                        ]);
                    }else{
                        $page->slug = $v_slug;
                        $page->save();
                    }

                    //salvo tutte le ereditarietà per la pagina create
                    if($list){
                        foreach ($list as $item){
                            $check = PageBlock::where("type", $item->type)->where("obj_id", $item->obj_id)->where("page_id", $page->id)
                                ->where("position", $item->position)->first();
                            if(!$check){
                                PageBlock::insert([
                                    "type" => $item->type,
                                    "obj_id" => $item->obj_id,
                                    "page_id" => $page->id,
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
                }

            }else{
                //\DB::table('roles')->where("name", "Cliente")->delete();
            }

        }

        if($this->crud->entry->name == "pluginBookings"){
            $lang = "it";
            $pages_dedicated = config('config.slug_plugin_booking');
            $list = PageBlock::where("is_ereditable", 1)->get();
            $page_home = Page::where("is_homepage", 1)->first();
            foreach ($pages_dedicated as $slug){
                $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();

                $v_slug = [];

                $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name", "name")->toArray();
                foreach ($langs as $l){
                    /*if($l != "it"){
                         $v_slug["$l"] = "$slug-$l";
                     }else{*/
                    $v_slug["$l"] = "$slug";
                    //}
                }

                if(!$page){
                    $in_topbar = 0;
                    if($slug == env("SLUG_CART") || $slug == env("SLUG_LOGIN") || $slug == env("SLUG_REGISTER")){
                        $in_topbar = 1;
                    }

                    $page = Page::create([
                        "name" => "$slug",
                        "title" => "$slug",
                        "slug" => $v_slug,
                        "is_in_topbar" => $in_topbar,
                        "is_in_menu" => 0,
                        "is_active" => 1,
                        "template" => $page_home->template,
                        "template_header" => $page_home->template_header,
                        "template_footer" => $page_home->template_footer,
                        "parent_id" => null,
                        "is_homepage" => 0,
                        "title_page" => "$slug"
                    ]);
                }else{
                    $page->slug = $v_slug;
                    $page->save();
                }

                //salvo tutte le ereditarietà per la pagina create
                if($list){
                    foreach ($list as $item){
                        $check = PageBlock::where("type", $item->type)->where("obj_id", $item->obj_id)->where("page_id", $page->id)
                            ->where("position", $item->position)->first();
                        if(!$check){
                            PageBlock::insert([
                                "type" => $item->type,
                                "obj_id" => $item->obj_id,
                                "page_id" => $page->id,
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
            }
        }


        if($this->crud->entry->name == "pluginInvitations"){
            $check = \DB::table('roles')->where("name", "Agente")->first();
            if(!$check){
                \DB::table('roles')->insert([
                    "name" => "Agente",
                    "guard_name" => "web"
                ]);
            }

            $check = \DB::table('roles')->where("name", "Buyer")->first();
            if(!$check){
                \DB::table('roles')->insert([
                    "name" => "Buyer",
                    "guard_name" => "web"
                ]);
            }
        }

        if($this->crud->entry->name == "pluginCaccia"){
            $check = \DB::table('roles')->where("name", "RPS")->first();
            if(!$check){
                \DB::table('roles')->insert([
                    "name" => "RPS",
                    "guard_name" => "web"
                ]);
            }
        }

        return $this->crud->performSaveAction($item->getKey());
    }
}
