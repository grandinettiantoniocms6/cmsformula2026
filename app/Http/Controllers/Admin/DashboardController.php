<?php

namespace App\Http\Controllers\Admin;


use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\AdminTemplate;
use App\Models\BlockGallery;
use App\Models\BlockHtml;
use App\Models\BlockImage;
use App\Models\BlockNews;
use App\Models\BlockSlideshow;
use App\Models\Card;
use App\Models\Client;
use App\Models\ClientNote;
use App\Models\Course;
use App\Models\CourseClient;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginProductsLangs;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WebsiteSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request){
        if(backpack_user()->roles[0]->id < 5) {
            $website_setting = WebsiteSetting::first();
            if ($website_setting->bacheca == null || $website_setting->bacheca == "") {
                $website_setting->bacheca = "dashboard";
            }

            if(env('DASHBOARD_ADMIN')){
                return redirect()->to(env('DASHBOARD_ADMIN'));
            }

            return view(backpack_view("$website_setting->bacheca"));
        }

        if(backpack_user()->roles[0]->id == 6) {
            return redirect()->to("/admin/pluginInvitations");
        }

        if(backpack_user()->roles[0]->id == 7) {
            return redirect()->to("/admin/shopOrders");
        }
    }

    public function access($id){
        if(in_array(backpack_user()->roles[0]->id, [1,2,7])){
            \Session::put("user_id", $id);

            $check = \DB::table("model_has_roles")->where("model_id", $id)->first();
            if($check){
                if($check->role_id == 7){
                    $user = User::find($id);
                    backpack_auth()->login($user);
                }
            }

            \Auth::logout();
            \Auth::loginUsingId($id);
        }

        return redirect()->to("../");
    }

    public function tutorials(Request $request){
        return view('vendor.backpack.base.tutorials');
    }

    public function pages_blocks(Page $page){
        return view('vendor.backpack.base.pages_blocks', compact('page'));
    }

    public function pages_blocks_switch(Page $page, Request $request){
        $position = $request->get('position');
        $col = $request->get('col');
        $type = $request->get('type');
        $page_id = $request->get('page_id');
        $redirect = $request->get('redirect');

        \Session::put('redirect', $redirect);

        $page_block = PageBlock::where("position", $position)->where("col", $col)->where("type", $type)->where("page_id", $page_id)->first();
        if(!$page_block){
            $order = 0;
        }else{
            $order = $page_block->order + 1;
        }

        if(is_numeric($type)){
            $itemPageBlock = PageBlock::find($type);
            $page_block = PageBlock::create([
                "obj_id" => $itemPageBlock->obj_id,
                "position" => $position,
                "col" => $col,
                "type" => $itemPageBlock->type,
                "page_id" => $page_id,
                "order" => $order
            ]);
            \Alert::success("Blocco aggiunto con successo!")->flash();
            return redirect()->back();
        }else{

            $page_block = PageBlock::create([
                "position" => $position,
                "col" => $col,
                "type" => $type,
                "page_id" => $page_id,
                "order" => $order
            ]);

            $adminBlock = AdminBlock::where("name", $type)->first();
            if($adminBlock){
                $lastCreated = \DB::table($adminBlock->name_table)->orderBy("id", "desc")->first();
                $nextId = 1;
                if($lastCreated){
                    $nextId = $lastCreated->id + 1;
                }

                $name = null;
                if($request->has('name')){
                    $name = $request->get('name');
                }

                \DB::table($adminBlock->name_table)->insert([
                    "id" => $nextId,
                    "name" => $name
                ]);

                $lastCreated = \DB::table($adminBlock->name_table)->orderBy("id", "desc")->first();
                $page_block->obj_id = $lastCreated->id;
                $page_block->save();

                if($adminBlock->is_multi == 1){
                    return redirect()->back();
                }

                return redirect()->to("/admin/{$adminBlock->name}/{$lastCreated->id}/edit");
            }
        }

        \Alert::error("Selezionare un blocco")->flash();
        return redirect()->back();
    }

    public function pages_blocks_save_order(Page $page, Request $request){
        $positions = $request->get("positions");
        if($positions){
            foreach ($positions as $vet){
                PageBlock::where("id", $vet[0])->update(["order" => $vet[1]]);
            }
        }
        dd($request->all());
    }


    public function pages_blocks_save_order_single_block($type, $id, Request $request){
        $data = $request->get('positions');
        $item = \DB::table("$type")->where("id", $id)->first();
        $temp_content = json_decode($item->content, true);
        $content_ = [];

        if(key_exists("it", $temp_content)){
            $langs = AdminLanguage::where("is_active", 1)->get()->pluck("name")->toArray();
            if($langs){
                foreach ($langs as $lang){
                    if(key_exists($lang, $temp_content)){
                        $content = json_decode($temp_content[$lang], true);
                        if($content){
                            $vet = [];
                            foreach ($content as $k=>$item){
                                foreach ($data as $val){
                                    if($val[0] == $item['title']){
                                        $item['order'] = $val[1];
                                    }
                                }
                                $vet[] = $item;
                            }
                        }
                        $content_[$lang] = json_encode($vet);
                    }
                }
                \DB::table("$type")->where("id", $id)->update([
                    "content" => $content_,
                    "reorder" => 1
                ]);
            }

        }else{
            $content = $temp_content;
            if($content){
                foreach ($content as $k=>$item){
                    foreach ($data as $val){
                        if($val[0] == $item['title']){
                            $content[$k]['order'] = $val[1];
                        }
                    }
                }
            }

            \DB::table("$type")->where("id", $id)->update([
                "content" => $content,
                "reorder" => 1
            ]);
        }
    }

    public function pages_blocks_delete(Page $page, $id){
        $item = PageBlock::where("id", $id)->where("page_id", $page->id)->first();
        if($item){

            if($item->is_ereditable == 1){
                PageBlock::where("type", $item->type)->where("obj_id", $item->obj_id)->delete();
            }

            //cancello l'associazione blocco - pagina
            $item->delete();

            $count_if_exist = PageBlock::where("type", $item->type)->where("obj_id", $item->obj_id)->count();

            $admin_block = AdminBlock::where("name", $item->type)->first();
            if($admin_block){
                if($count_if_exist == 0){
                    \DB::table($admin_block->name_table)->where("id", $item->obj_id)->delete();
                }
            }

            \Alert::success("blocco cancellato con successo!")->flash();
        }else{
            \Alert::error("blocco non cancellato!")->flash();
        }

        return redirect()->back();
    }

    public function order_list($type, $id){
        $item = \DB::table($type)->where("id", $id)->first();
        if($item){
            $temp_content = json_decode($item->content, true);

            if(key_exists("it", $temp_content)){
                $content_ = json_decode($temp_content['it'], true);
            }else{
                $content_ = $temp_content;
            }

            if($item->reorder == 1){
                $content = [];
                if($content_){
                    foreach ($content_ as $k=>$v){
                        $content[$v['order']] = $v;
                    }
                }
                ksort($content);
            }else{
                $content = $content_;
            }

            $adminBlock = AdminBlock::where("name_table", $type)->first();
            if($adminBlock){
                $type_singular = $adminBlock->name;
            }
            $block_page = PageBlock::where("type", $type_singular)->where("obj_id", $id)->first();
            $page = Page::find($block_page->page_id);

            return view(backpack_view('blocks_orders'), compact('item', 'content', 'type', 'page', 'id'));
        }
        return redirect()->back();
    }


    public function set_field_boolean($table, $id, $field, $value){
        \DB::table($table)->where("id", $id)->update([
            "$field" => $value
        ]);

        \Alert::success("Dati salvati con successo!")->flash();
        return redirect()->back();
    }

    public function sanitize_string(Request $request){
        return response()->json([
            "string" => \Str::slug($request->get('string'))
        ]);
    }

    public function eredita(PageBlock $id){
        if($id->is_ereditable === null){
            $id->is_ereditable = 1;
        }else{
            $id->is_ereditable = !$id->is_ereditable;
        }

        switch ($id->is_ereditable){
            case 1:
                $pages = Page::where("is_homepage", 0)->get();
                if($pages){
                    foreach ($pages as $page){
                        $check = PageBlock::where("type", $id->type)->where("obj_id", $id->obj_id)->where("page_id", $page->id)->where("position", $id->position)->first();
                        if(!$check){
                            PageBlock::insert([
                               "type" => $id->type,
                               "obj_id" => $id->obj_id,
                               "page_id" => $page->id,
                               "position" => $id->position,
                               "col" => $id->col,
                               "order" => $id->order,
                               "is_active" => $id->is_active,
                               "is_ereditable_from_id" => $id->id,
                               "created_at" => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                }
                break;
            case 0:
                $pages = Page::where("is_homepage", 0)->get();
                if($pages){
                    foreach ($pages as $page){
                        $check = PageBlock::where("type", $id->type)->where("obj_id", $id->obj_id)->where("page_id", $page->id)
                            ->where("position", $id->position)
                            ->where("is_ereditable_from_id", $id->id)
                            ->first();
                        if($check){
                            $check->delete();
                        }
                    }
                }
                break;
        }

        $id->save();

        \Alert::success("Ereditarietà salvata con successo!")->flash();
        return redirect()->back();
    }

    public function attivazione(PageBlock $id)
    {
       $id->is_active = !$id->is_active;
       $id->save();

       \Alert::success("Attivazione salvata con successo!")->flash();
       return redirect()->back();
    }

    public function putPermanentEnv($key, $value)
    {
        if(backpack_user()->roles[0]->id == 1){
            if($key == "TEMA") {
                $path = app()->environmentFilePath();

                $escaped = preg_quote('=' . env($key), '/');

                file_put_contents($path, preg_replace(
                    "/^{$key}{$escaped}/m",
                    "{$key}={$value}",
                    file_get_contents($path)
                ));
            }
        }

        return redirect()->to("/admin/adminTemplate");
    }

    public function changeTemplate(Request $request){
        $value = $request->get('template');
        $id = $request->get('id');

        $template = AdminTemplate::find($id);
        if($template){
            if(backpack_user()->roles[0]->id == 1){
                $key = "TEMA";
                if($key == "TEMA") {
                    $path = app()->environmentFilePath();

                    $escaped = preg_quote('=' . env($key), '/');

                    file_put_contents($path, preg_replace(
                        "/^{$key}{$escaped}/m",
                        "{$key}={$value}",
                        file_get_contents($path)
                    ));
                }

                if($request->has('header')){
                    $template->header = $request->get('header');
                }

                if($request->has('footer')){
                    $template->footer = $request->get('footer');
                }

                if($request->has('nav_style')){
                    $template->nav_style = $request->get('nav_style');
                }

                if($request->has('inc')){
                    $template->inc = $request->get('inc');
                }

                $template->save();
            }
        }


        return redirect()->to("/admin/adminTemplate");
    }

    public function check_duplicate_slug($table){
        $langs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("name", "name")->toArray();

        if($table == "plugins_products"){
            $is_variant = 0;
            if(\Request::route()->getName() == "shopProductsVariants.index"){
                $is_variant = 1;
            }

            if(count($langs) > 1) {
                $list = \DB::table($table)
                    ->selectRaw("name, slug")
                    ->where("is_variant", $is_variant)
                    ->whereNull("deleted_at")->get();
            }else{
                $list = \DB::table($table)
                    ->selectRaw("COUNT(*) as tot, slug")
                    ->where("is_variant", $is_variant)
                    ->whereNull("deleted_at")
                    ->orderBy("tot", "DESC")
                    ->groupBy("slug")
                    ->havingRaw("tot >= 1")
                    ->get();
            }

        }else{
            if(count($langs) > 1) {
                $list = \DB::table($table)
                    ->selectRaw("name, slug")->whereNull("deleted_at")->get();
            }else{
                $list = \DB::table($table)
                    ->selectRaw("COUNT(*) as tot, slug")
                    ->whereNull("deleted_at")
                    ->orderBy("tot", "DESC")
                    ->groupBy("slug")
                    ->havingRaw("tot >= 1")
                    ->get();
            }
        }

        if(count($langs) > 1) {
            $limitMin = 1;
            $vLangSlug = [];
            foreach ($list as $pp){
                $tempSlug = json_decode($pp->slug, true);
                if($tempSlug){
                    foreach ($langs as $lang){
                        if(key_exists($lang, $tempSlug)){
                            $vLangSlug[$lang][$pp->name] = $tempSlug[$lang];
                        }else{
                            if(key_exists("it", $tempSlug)){
                                $vLangSlug[$lang][$pp->name] = $tempSlug['it'];
                            }
                        }
                    }
                }
            }

            $vCheckSlug = [];
            if($vLangSlug){
                foreach ($vLangSlug as $namePage=>$vet){
                    foreach ($vet as $k=>$label){
                        if($label == "/"){
                            continue;
                        }

                        if($label == ""){
                            continue;
                        }

                        if($label === null){
                            continue;
                        }

                        $cont = \DB::table($table)
                            ->whereNull("deleted_at")
                            ->whereRaw("slug LIKE '%\"$label\"%'")->count();

                        /*$cont = 0;
                        $vWhere = [];
                        foreach ($langs as $lang){
                            if(count($langs) > 1) {
                                if ($lang == $namePage) {
                                    continue;
                                }
                            }

                            if($vLangSlug[$lang][$k] == $label){
                                $cont++;
                                $vWhere[] = $lang;
                            }
                        }*/

                        if($cont > $limitMin){
                            if(!in_array($label, config('config.slug_shop_formula'))){
                                if(trim($label) != ""){
                                    $vCheckSlug[$label] = "<p>Permalink. <strong>$label</strong> presente <strong>$cont volte</strong></p>";
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $vCheckSlug = [];

            foreach ($list as $pp){
                $tempSlug = json_decode($pp->slug, true);
                foreach ($tempSlug as $v){
                    $label = $v;

                    if($label == "/"){
                        continue;
                    }

                    if($label == ""){
                        continue;
                    }

                    if($label === null){
                        continue;
                    }

                    $cont = $pp->tot;
                    if($cont > 1){
                        $vCheckSlug[$label] = "<p>Permalink <strong>$label</strong> presente <strong>$cont volte</strong></p>";
                    }
                }
            }
        }

        return $vCheckSlug;
    }

    public function actions(Request $request){
        $button = $request->get('button');
        $ids = $request->get('ids');
        $type = $request->get('type');
        if($ids == null){
            return redirect()->back();
        }

        switch ($button){
            case "delete":

                if($type == "blockGallery"){
                    BlockGallery::whereIn("id", $ids)->delete();
                }
                break;
        }

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }

    public function delete_image_special($id){
       PluginProductsLangs::where("id", $id)->update([
            "image" => null
       ]);

        \Alert::success("Operazione effettuata con successo!")->flash();

        return redirect()->back();
    }

}
