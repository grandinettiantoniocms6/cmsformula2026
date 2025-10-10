<?php


namespace App\Http\Controllers;


use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\BlockContact;
use App\Models\BlockNews;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginProducts;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsSettings;
use App\Models\Product;
use App\Models\ShopSettings;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function get_menu(){
        $menu = Page::where("is_in_menu", 1)->where("is_active", 1)->where("parent_id", null)->orderBy("lft", "asc")->get();
        if($menu){
            foreach ($menu as $item){
                $check = Page::where("is_in_menu", 1)->where("parent_id", $item->id)->orderBy("lft", "asc")->get();
                if($check){
                    $item->figli = $check;

                    if($item->figli){
                        foreach ($item->figli as $figlio){
                            $check = Page::where("is_in_menu", 1)->where("parent_id", $figlio->id)->orderBy("lft", "asc")->get();
                            if($check){
                                $figlio->figli = $check;
                            }
                        }
                    }
                }
            }
        }
        return $menu;
    }

    public function check_page($slug = null){
        $slug_excluded = [];
        $slug_excluded[] = env('SLUG_LOGIN');
        $slug_excluded[] = env('SLUG_REGISTER');
        $slug_excluded[] = env('SLUG_COMPARE');
        $slug_excluded[] = env('SLUG_RECOVERY');
        $slug_excluded[] = env('SLUG_CHANGE_PSW');
        $slug_excluded[] = env('SLUG_CART');
        $slug_excluded[] = "checkout";


        if($slug !== null) {
            $currenturl = url()->full();
            $currentSlug = basename($currenturl);
            $currentSlug = addslashes($currentSlug);
            $adminLangs = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get();
            if ($adminLangs) {
                foreach ($adminLangs as $item_lang) {
                    $item = Page::whereRaw("slug LIKE '%\"{$item_lang->name}\":\"$currentSlug\"%'")->where("is_active", 1)->first();
                    if ($item) {
                        if(!in_array($slug, $slug_excluded)){
                            App::setLocale($item_lang->name);
                        }
                    }
                }
            }
        }


        $lang = \App::getLocale();
        if($slug === null){
            $page = Page::where("is_homepage", 1)->where("is_active", 1)->first();
        }else{
            $slug = addslashes($slug);

            $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->where("is_active", 1)->first();
            if(!$page){
                $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->where("is_active", 1)->first();
                if($page){
                    return "/$page->slug";
                }else{
                    return "/";
                }
            }
        }
        if(!$page){
            return "/";
        }

        return $page;
    }

    public function index($slug = null)
    {

        if(env('NASCONDI_FRONTEND') == 1){
            return redirect()->to("/admin");
        }

        $website = WebsiteSetting::first();
        $menu = $this->get_menu();
        $page = $this->check_page($slug);

        if(is_string($page)){
            return redirect()->to($page);
        }

        if($page){
            if(trim($page->url) != "" && $page->url !== null){
                return redirect()->to($page->url);
            }

            if(trim($page->url_interno) != "" && $page->url_interno !== null){
                return redirect()->to($page->url_interno);
            }
        }

        return view('index', compact('menu', 'page','website'));
    }

    public function paypal_test(){
        return view('paypal');
    }

    public function email_test()
    {
        $dest = "info@webisland.it";
        \Mail::send("common.emails.test", ['data' => null], function ($m) use ($dest) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->to($dest);
            $m->subject("Test");
        });
    }

    public function login()
    {
        $slug = env('SLUG_LOGIN');
        $website = WebsiteSetting::first();

        $menu = $this->get_menu();
        $page = $this->check_page($slug);

        if(is_string($page)){
            return redirect()->to($page);
        }

        $shopSetting = ShopSettings::first();
        return view('login', compact('menu', 'page','website','shopSetting'));
    }

    public function register()
    {
        $slug = env('SLUG_REGISTER');
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();
        $page = $this->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }

        $shopSetting = ShopSettings::first();
        if($shopSetting->is_registration_open == 0){
            return redirect()->to("/");
        }


        return view('register', compact('menu', 'page','website'));
    }

    public function recovery_password()
    {
        $slug = env('SLUG_RECOVERY');
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();
        $page = $this->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }

        $shopSetting = ShopSettings::first();
        return view('recoveryPassword', compact('menu', 'page','website','shopSetting'));
    }

    public function change_password($code)
    {
        $slug = env('SLUG_CHANGE_PSW');
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();
        $page = $this->check_page($slug);
        if(is_string($page)){
            return redirect()->to($page);
        }


        return view('changePassword', compact('menu', 'page','website','code'));
    }


    public function page_not_found($slug = null)
    {
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();

        $page = Page::where("is_homepage", 1)->where("is_active", 1)->first();

        return view('404', compact('menu', 'page','website'));
    }

    public function results(Request $request)
    {
        $s = $request->get('s');
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();

        $blocks = [];
        $list = PageBlock::where("is_active", 1)->whereNotNull("type")->get();
        if($list){
            foreach ($list as $block){
                $adminBlock = AdminBlock::where("name", $block->type)->first();
                if($adminBlock) {
                    $item = \DB::table($adminBlock->name_table)->where("id",$block->obj_id)->whereRaw("content LIKE '%$s%'")->first();
                    if ($item) {
                        $item->type = $adminBlock->name;

                        $page = Page::find($block->page_id);
                        if($page){
                            $block->title_page = $page->getTranslations('title', 'it');
                            $block->slug_page = $page->getTranslations('slug', 'it');
                        }
                        $blocks["{$block->type}-{$block->obj_id}"] = $block;
                    }
                }
            }
        }

        $page = null;
        return view('results', compact('menu', 'page','website', 'blocks','s'));
    }

    public function news_slug($slug, Request $request)
    {
        $website = WebsiteSetting::first();
        $lang = \App::getLocale();
        $menu = $this->get_menu();

        $news = null;

        $slug = addslashes($slug);

        $blockNews = BlockNews::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")
            ->where("is_active", 1)
            ->first();
        if(!$blockNews){
            return redirect()->to("/");
        }

        $padre = BlockNews::where("id", $blockNews->block_id)
            ->where("is_active", 1)
            ->first();

        $lang = \App::getLocale();
        $slug = "news";
        $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$page){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->first();
        }

        $news = null;
        if($padre){
            $news = BlockNews::whereRaw("block_id = $padre->id")
                ->where("is_active", 1)
                ->get();
        }


        return view('news', compact('menu', 'page','website', 'news','blockNews'));
    }

    public function news_tag($tag, Request $request)
    {
        $website = WebsiteSetting::first();
        $menu = $this->get_menu();

        $news = null;
        $blockNews = null;

        $lang = \App::getLocale();
        $slug = "news";
        $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$page){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->first();
        }

        if(!$page){
            return redirect()->to("/");
        }

        $paginate = 6;
        $order_type = "date|DESC";
        $pages_blocks_news = PageBlock::where("type", "blockNews")->where("is_active", 1)->where("page_id", $page->id)->first();
        if($pages_blocks_news){
            $padre_news = BlockNews::whereRaw("id = $pages_blocks_news->obj_id")
                ->where("is_active", 1)
                ->first();
            if($padre_news){
                $paginate = $padre_news->number_news;
                $order_type = $padre_news->type_order;
            }
        }

        $temp_order = explode("|", $order_type);

        $news = BlockNews::selectRaw("blocks_news.*")->whereRaw("tag LIKE '%$tag%'")
            ->join("blocks_pages", "blocks_pages.obj_id", "=", "blocks_news.block_id")
            ->where("type", "blockNews")
            ->where("blocks_news.is_active", 1)
            ->orderBy($temp_order[0], $temp_order[1])
            ->groupBy("blocks_news.id")
            ->paginate($paginate);

        return view('news', compact('menu', 'page','website', 'news','blockNews'));
    }

    public function news_category($category, Request $request)
    {
        $website = WebsiteSetting::first();

        $menu = $this->get_menu();

        $news = null;
        $blockNews = null;

        $lang = \App::getLocale();
        $slug = "news";
        $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$page){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->first();
        }

        if(!$page){
            return redirect()->to("/404");
        }

        $paginate = 6;
        $order_type = "date|DESC";
        $pages_blocks_news = PageBlock::where("type", "blockNews")->where("is_active", 1)->where("page_id", $page->id)->first();
        if($pages_blocks_news){
            $padre_news = BlockNews::whereRaw("id = $pages_blocks_news->obj_id")
                ->where("is_active", 1)
                ->first();
            if($padre_news){
                $paginate = $padre_news->number_news;
                $order_type = $padre_news->type_order;
            }
        }

        $temp_order = explode("|", $order_type);

      //  $category = urldecode($category);

        $category = addslashes($category);

        $news = BlockNews::selectRaw("blocks_news.*")
            ->whereRaw("category LIKE '%$category%'")
            ->join("blocks_pages", "blocks_pages.obj_id", "=", "blocks_news.block_id")
            ->where("type", "blockNews")
            ->where("blocks_news.is_active", 1)
            ->orderBy($temp_order[0], $temp_order[1])
            ->groupBy("blocks_news.id")
            ->paginate($paginate);

        return view('news', compact('menu', 'page','website', 'news','blockNews'));
    }

    public function preview_news($slug)
    {
        $website = WebsiteSetting::first();
        $lang = \App::getLocale();
        $menu = $this->get_menu();

        $news = null;

        $blockNews = BlockNews::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")
            ->first();
        if(!$blockNews){
            return redirect()->to("/");
        }

        $padre = BlockNews::where("id", $blockNews->block_id)
            ->first();

        $lang = \App::getLocale();
        $slug = "news";
        $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$page){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->first();
        }

        $news = null;
        if($padre){
            $news = BlockNews::whereRaw("block_id = $padre->id")
                ->get();
        }


        return view('news', compact('menu', 'page','website', 'news','blockNews'));
    }


    public function news(Request $request)
    {
        $website = WebsiteSetting::first();

        $menu = $this->get_menu();

        $lang = \App::getLocale();
        $slug = "news";
        $page = Page::whereRaw("slug LIKE '%\"$lang\":\"$slug\"%'")->first();
        if(!$page){
            $page = Page::whereRaw("slug LIKE '%:\"$slug\"%'")->first();
            if($page){
                return redirect()->to("/$page->slug");
            }else{
                return redirect()->to("/404");
            }
        }

        $paginate = 6;
        $order_type = "date|DESC";
        $pages_blocks_news = PageBlock::where("type", "blockNews")->where("is_active", 1)->where("page_id", $page->id)->first();
        if($pages_blocks_news){
            $padre_news = BlockNews::whereRaw("id = $pages_blocks_news->obj_id")
                ->where("is_active", 1)
                ->first();
            if($padre_news){
                $paginate = $padre_news->number_news;
                $order_type = $padre_news->type_order;
            }
        }

        $temp_order = explode("|", $order_type);

        $now = Carbon::now()->toDateTimeString();

        $news = null;
        $blockNews = null;
        if($request->has('id')){
            $id = $request->get('id');
            $news = BlockNews::whereRaw("block_id = $id")
                ->whereRaw("(date_end is null OR date_end >= '$now')")
                ->where("is_active", 1)
                ->orderBy("is_default", "desc")
                ->orderBy($temp_order[0], $temp_order[1])
                ->paginate($paginate);

            $news->setPath("".url()->current()."?id={$id}"); //I just use custom Url and set path to ''

        }else{
            $pages_blocks = PageBlock::where("type", "blockNews")
                //->where("is_active", 1)
                ->where("page_id", $page->id)
                ->get()->pluck("obj_id")->toArray();
            if(count($pages_blocks)){
                $news = BlockNews::whereIn("block_id", $pages_blocks)
                    ->whereRaw("(date_end is null OR date_end >= '$now')")
                    ->where("is_active", 1)
                    ->orderBy("is_default", "desc")
                    ->orderBy($temp_order[0], $temp_order[1])
                    ->paginate($paginate);
            }
        }

        return view('news', compact('menu', 'page','website', 'news', 'blockNews'));
    }

    public function switchLang($lang, Request $request)
    {
        $adminLang = AdminLanguage::where("is_active", 1)->where("is_frontend", 1)->get()->pluck("label", "name")->toArray();

        if (array_key_exists($lang, $adminLang)) {
            \Session::put('applocale', $lang);
        }

        $referer = [];
        if(isset($_SERVER['HTTP_REFERER'])){
            $referer = explode("/", $_SERVER['HTTP_REFERER']);
            $url_plugin_protect = [];
            if(count($adminLang)){
                foreach($adminLang as $k=>$lang1){
                    $k_up = strtoupper($k);
                    $url_plugin_protect["$k"] = env("PLUGIN_PRODUCTS_URL_$k_up");
                }
            }

            if(!key_exists(3, $referer)){
                return redirect()->to("/");
            }

            if(in_array($referer[3], $url_plugin_protect)){
                if(key_exists($lang, $url_plugin_protect)){
                    $referer[3] = $url_plugin_protect[$lang];

                    $new_url = "/$referer[3]";
                    switch (count($referer)){
                        case 5: //categoria
                            $category = \DB::table("plugins_products_categories")->whereNull("deleted_at")->whereRaw("slug LIKE '%\"$referer[4]\"%'")->first();
                            if($category){
                                $v = json_decode($category->slug, true);
                                if(key_exists($lang, $v)){
                                    $referer[4] = $v[$lang];
                                    $new_url = "/$referer[3]/$referer[4]";
                                }
                            }
                            break;
                        case 6: //prodotto
                            $category = \DB::table("plugins_products_categories")->whereNull("deleted_at")->whereRaw("slug LIKE '%\"$referer[4]\"%'")->first();
                            if($category){
                                $v = json_decode($category->slug, true);
                                if(key_exists($lang, $v)){
                                    $referer[4] = $v[$lang];
                                }

                                $product = \DB::table("plugins_products")->whereNull("deleted_at")->whereRaw("slug LIKE '%\"$referer[5]\"%'")->first();
                                if($product){
                                    $v = json_decode($product->slug, true);
                                    if(key_exists($lang, $v)){
                                        $referer[5] = $v[$lang];

                                        $new_url = "/$referer[3]/$referer[4]/$referer[5]";
                                    }
                                }
                            }
                            break;
                    }
                    return redirect()->to("$new_url");
                }
            }
        }


        if(key_exists(3, $referer)){
            $new_url = "/$referer[3]";
            $page = \DB::table("pages")->whereNull("deleted_at")->whereRaw("slug LIKE '%\"$referer[3]\"%'")->first();
            if($page){
                $v = json_decode($page->slug, true);
                if(key_exists($lang, $v)){
                    $referer[3] = $v[$lang];
                    $new_url = "/$referer[3]";
                }
            }
            return redirect()->to($new_url);
        }

        return redirect()->to("/");

    }

    public function contact_form_send(Request $request){
        /*$this->validate($request, [
            'g-recaptcha-response' => 'required|captcha',
        ]);*/

        $block_contact_id = $request->get('block_contact_id');
        $item = BlockContact::find($block_contact_id);

        if($item){
            $data = $request->except(['_token', 'block_contact_id']);
            $vet_email = ["request" => $data];

            $dst_email = $item->email;

            \Mail::send("common.emails.contact", ['data' => $vet_email], function ($m) use ($dst_email, $item, $data) {

                $m->from($data['email']);
                $m->to($dst_email);
                if($item->cc){
                    $cc_email = explode(",", $item->cc);
                    if(count($cc_email)){
                        foreach ($cc_email as $k=>$c_email){
                           $cc_email[$k] = trim($c_email);
                        }
                    }
                    $m->cc($cc_email);
                }

                if($item->ccn){
                    $ccn_email = explode(",", $item->ccn);
                    if(count($ccn_email)){
                        foreach ($ccn_email as $k=>$c_email){
                            $ccn_email[$k] = trim($c_email);
                        }
                    }

                    $m->bcc($ccn_email);
                }

                if($item->object_form){
                    $m->subject($item->getTranslation('object_form', \App::getLocale()));
                }else{
                    $m->subject("Richiesta informazioni");
                }
            });

            return redirect()->back()->with('message', $item->getTranslation('message_ringraziamento', \App::getLocale()));
        }
        return redirect()->back()->withErrors(['msg', 'Error']);

    }



}
