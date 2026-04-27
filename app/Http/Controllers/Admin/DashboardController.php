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
use App\Models\DashboardTodo;
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
use Illuminate\Support\Str;

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

            if (\App\Models\WebsiteSetting::isAdminFutureTemplate() && $website_setting->bacheca === 'dashboard') {
                return view(backpack_view('dashboard_future'));
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

    public function azzera_ordini()
    {
        \Artisan::call('app:truncate-order-client');
        \Alert::success("Ordini svuotati con successo!")->flash();
        return redirect()->back();
    }

    public function set_shop_areas()
    {
        \Artisan::call('app:set-shop-areas');
        \Alert::success("Shop area caricati con successo!")->flash();
        return redirect()->back();
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
        return view(backpack_view('tutorials'));
    }

    public function quick_search(Request $request)
    {
        if (!backpack_auth()->check()) {
            return redirect()->to(backpack_url('dashboard'));
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return redirect()->to(backpack_url('dashboard'));
        }

        $searchRaw = trim((string) $request->get('search', $request->get('q', '')));
        if ($searchRaw === '') {
            return redirect()->back();
        }

        $search = Str::lower($searchRaw);

        foreach ($this->getQuickSearchSettingsItems() as $settingItem) {
            $keywords = array_map(static function ($keyword) {
                return Str::lower((string) $keyword);
            }, $settingItem['keywords'] ?? []);

            foreach ($keywords as $keyword) {
                if ($keyword !== '' && (Str::contains($search, $keyword) || Str::contains($keyword, $search))) {
                    return redirect()->to($settingItem['url']);
                }
            }
        }

        $hasPageMatch = Page::query()
            ->whereNull('deleted_at')
            ->where(function ($query) use ($searchRaw) {
                $like = '%' . $searchRaw . '%';
                $query->where('name', 'like', $like)
                    ->orWhere('title', 'like', $like)
                    ->orWhere('slug', 'like', $like);
            })
            ->exists();

        if ($hasPageMatch) {
            return redirect()->to(backpack_url('page') . '?search=' . urlencode($searchRaw));
        }

        return redirect()->to(backpack_url('page') . '?search=' . urlencode($searchRaw));
    }

    public function quick_search_suggest(Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['items' => []], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['items' => []], 403);
        }

        $query = trim((string) $request->get('q', ''));
        if (Str::length($query) < 2) {
            return response()->json(['items' => []]);
        }

        $queryLower = Str::lower($query);
        $items = [];

        foreach ($this->getQuickSearchSettingsItems() as $settingItem) {
            $labelLower = Str::lower((string) ($settingItem['label'] ?? ''));
            $descriptionLower = Str::lower((string) ($settingItem['description'] ?? ''));
            $keywords = array_map(static function ($keyword) {
                return Str::lower((string) $keyword);
            }, $settingItem['keywords'] ?? []);

            $match = Str::contains($labelLower, $queryLower) || Str::contains($descriptionLower, $queryLower);
            if (!$match) {
                foreach ($keywords as $keyword) {
                    if ($keyword !== '' && (Str::contains($keyword, $queryLower) || Str::contains($queryLower, $keyword))) {
                        $match = true;
                        break;
                    }
                }
            }

            if ($match) {
                $items[] = [
                    'label' => $settingItem['label'],
                    'description' => $settingItem['description'],
                    'url' => $settingItem['url'],
                    'type' => 'setting',
                ];
            }
        }

        $pageMatches = Page::query()
            ->whereNull('deleted_at')
            ->where(function ($queryBuilder) use ($query) {
                $like = '%' . $query . '%';
                $queryBuilder->where('name', 'like', $like)
                    ->orWhere('title', 'like', $like)
                    ->orWhere('slug', 'like', $like);
            })
            ->orderByDesc('id')
            ->limit(8)
            ->get(['id', 'name', 'title', 'slug']);

        foreach ($pageMatches as $pageItem) {
            $pageName = trim((string) $pageItem->name);
            $pageTitle = $this->extractQuickSearchText($pageItem->title);
            $pageSlug = $this->extractQuickSearchText($pageItem->slug);

            $items[] = [
                'label' => $pageName !== '' ? $pageName : ($pageTitle !== '' ? $pageTitle : 'Pagina #' . $pageItem->id),
                'description' => $pageSlug !== '' ? 'Pagina: /' . ltrim($pageSlug, '/') : 'Elenco pagine',
                'url' => backpack_url('page') . '?search=' . urlencode($pageName !== '' ? $pageName : $query),
                'type' => 'page',
            ];
        }

        return response()->json([
            'items' => array_slice($items, 0, 10),
        ]);
    }

    public function mark_news_seen(Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        if (!$this->canQueryAdminNewsConnection()) {
            return response()->json(['ok' => true, 'unread' => 0]);
        }

        try {
            $newsConnection = 'mysql_2';
            try {
                \DB::connection($newsConnection)->getPdo();
            } catch (\Throwable $e) {
                $newsConnection = 'mysql_2_fallback';
            }

            $latestNewsCreatedAt = \DB::connection($newsConnection)
                ->table("news")
                ->whereNull("deleted_at")
                ->where("is_active", 1)
                ->max("created_at");

            if($latestNewsCreatedAt){
                $userId = (int) backpack_user()->id;
                $lastSeenAt = (string) $latestNewsCreatedAt;
                $cacheKey = 'admin_news_last_seen_at_' . $userId;

                \Cache::forever($cacheKey, $lastSeenAt);
                session()->put($cacheKey, $lastSeenAt);
            }
        } catch (\Throwable $e) {
            return response()->json(['ok' => false], 500);
        }

        return response()->json(['ok' => true, 'unread' => 0]);
    }

    public function support_send(Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:180',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:6000',
        ]);

        try {
            $destinationEmail = 'info@webisland.it';
            $adminUser = backpack_user();
            $body = implode("\n", [
                'Nuova richiesta assistenza da pannello admin',
                '',
                'Sito: ' . config('app.url'),
                'Utente admin ID: ' . ($adminUser ? $adminUser->id : '-'),
                'Nome: ' . $validated['name'],
                'Email: ' . $validated['email'],
                '',
                'Messaggio:',
                $validated['message'],
            ]);

            \Mail::raw($body, function ($mail) use ($destinationEmail, $validated) {
                $mail->to($destinationEmail);
                $mail->replyTo($validated['email'], $validated['name']);
                $mail->subject('[CMS Assistenza] ' . trim((string) $validated['subject']));
            });
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Invio non riuscito. Riprova tra qualche secondo.',
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Richiesta inviata con successo.',
        ]);
    }

    public function dashboard_todos_store(Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $request->validate([
            'title' => 'required|string|max:60000',
            'priority' => 'nullable|in:bassa,media,alta',
        ]);

        $nextSortOrder = (int) DashboardTodo::where('user_id', backpack_user()->id)->max('sort_order') + 1;

        $sanitizedTitle = $this->sanitize_dashboard_todo_html((string) $request->get('title'));
        if ($sanitizedTitle === '') {
            return response()->json(['ok' => false, 'message' => 'Titolo non valido'], 422);
        }

        $todo = DashboardTodo::create([
            'user_id' => backpack_user()->id,
            'title' => $sanitizedTitle,
            'priority' => $request->get('priority', 'media'),
            'is_done' => 0,
            'sort_order' => $nextSortOrder,
        ]);

        return response()->json([
            'ok' => true,
            'todo' => $todo,
        ]);
    }

    public function dashboard_todos_update($id, Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $request->validate([
            'title' => 'required|string|max:60000',
            'priority' => 'nullable|in:bassa,media,alta',
        ]);

        $todo = DashboardTodo::where('id', $id)
            ->where('user_id', backpack_user()->id)
            ->first();

        if (!$todo) {
            return response()->json(['ok' => false], 404);
        }

        $sanitizedTitle = $this->sanitize_dashboard_todo_html((string) $request->get('title'));
        if ($sanitizedTitle === '') {
            return response()->json(['ok' => false, 'message' => 'Titolo non valido'], 422);
        }

        $todo->title = $sanitizedTitle;
        $todo->priority = (string) $request->get('priority', $todo->priority ?: 'media');
        $todo->save();

        return response()->json([
            'ok' => true,
            'todo' => $todo,
        ]);
    }

    public function dashboard_todos_reorder(Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = array_values(array_unique(array_map('intval', (array) $request->get('ids'))));
        $validIds = DashboardTodo::where('user_id', backpack_user()->id)
            ->whereIn('id', $ids)
            ->pluck('id')
            ->toArray();

        if (count($ids) !== count($validIds)) {
            return response()->json(['ok' => false], 422);
        }

        foreach ($ids as $index => $todoId) {
            DashboardTodo::where('id', $todoId)
                ->where('user_id', backpack_user()->id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    public function dashboard_todos_toggle($id, Request $request)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $todo = DashboardTodo::where('id', $id)
            ->where('user_id', backpack_user()->id)
            ->first();

        if (!$todo) {
            return response()->json(['ok' => false], 404);
        }

        $isDone = $request->has('is_done')
            ? (int) $request->boolean('is_done')
            : (int) !$todo->is_done;

        $todo->is_done = $isDone;
        $todo->save();

        return response()->json([
            'ok' => true,
            'todo' => $todo,
        ]);
    }

    public function dashboard_todos_destroy($id)
    {
        if (!backpack_auth()->check()) {
            return response()->json(['ok' => false], 401);
        }

        if (backpack_user()->roles[0]->id >= 5) {
            return response()->json(['ok' => false], 403);
        }

        $todo = DashboardTodo::where('id', $id)
            ->where('user_id', backpack_user()->id)
            ->first();

        if (!$todo) {
            return response()->json(['ok' => false], 404);
        }

        $todo->delete();

        return response()->json(['ok' => true]);
    }

    private function canQueryAdminNewsConnection(): bool
    {
        if (!app()->environment('local')) {
            return true;
        }

        $cacheKey = 'admin_news_mysql2_reachable';
        $cachedReachability = \Cache::get($cacheKey);
        if ($cachedReachability !== null) {
            return (bool) $cachedReachability;
        }

        $isReachable = true;
        try {
            $mysql2Config = config('database.connections.mysql_2', []);
            $mysql2Host = (string) ($mysql2Config['host'] ?? '');
            $mysql2Port = (int) ($mysql2Config['port'] ?? 3306);

            if ($mysql2Host !== '') {
                $probeTimeout = (float) env('ADMIN_NEWS_DB_PROBE_TIMEOUT', 0.35);
                $errno = 0;
                $errstr = '';
                $socket = @fsockopen($mysql2Host, $mysql2Port, $errno, $errstr, $probeTimeout);
                if (is_resource($socket)) {
                    fclose($socket);
                } else {
                    $isReachable = false;
                }
            }
        } catch (\Throwable $e) {
            $isReachable = false;
        }

        \Cache::put($cacheKey, $isReachable, now()->addSeconds($isReachable ? 60 : 180));

        return $isReachable;
    }

    private function getQuickSearchSettingsItems(): array
    {
        $websiteSettingUrl = backpack_url('websiteSetting/1/edit');

        return [
            [
                'label' => 'Impostazioni sito',
                'description' => 'Configurazione generale sito',
                'url' => $websiteSettingUrl,
                'keywords' => ['impostazioni', 'website setting', 'website settings', 'sito', 'favicon', 'logo', 'mailchimp', 'cookie', 'iubenda', 'consent', 'social', 'seo'],
            ],
            [
                'label' => 'Impostazioni > Header/Topbar',
                'description' => 'Colori e comportamento header',
                'url' => $websiteSettingUrl,
                'keywords' => ['header', 'topbar', 'menu', 'menubar', 'hamburger', 'sidebar', 'sfondo topbar'],
            ],
            [
                'label' => 'Impostazioni > Avvisi',
                'description' => 'Messaggi popup e periodo pubblicazione',
                'url' => $websiteSettingUrl,
                'keywords' => ['avvisi', 'popup', 'data inizio', 'data fine', 'modale', 'messaggio'],
            ],
            [
                'label' => 'Impostazioni > Manutenzione/Extra',
                'description' => 'Online/offline, extra e pannello admin',
                'url' => $websiteSettingUrl,
                'keywords' => ['manutenzione', 'offline', 'online', 'extra', 'watermark', 'admin panel', 'pannello admin', 'whatsapp'],
            ],
        ];
    }

    private function extractQuickSearchText($value): string
    {
        if ($value === null) {
            return '';
        }

        if (is_array($value)) {
            $localized = $value[App::getLocale()] ?? $value['it'] ?? reset($value);
            return trim((string) ($localized ?? ''));
        }

        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $localized = $decoded[App::getLocale()] ?? $decoded['it'] ?? reset($decoded);
            return trim((string) ($localized ?? ''));
        }

        return $raw;
    }

    private function sanitize_dashboard_todo_html(string $value): string
    {
        $html = str_replace(["\r\n", "\r"], "\n", $value);
        $html = preg_replace('#<(script|style)[^>]*>.*?</\1>#is', '', $html);
        $html = str_ireplace(['<br/>', '<br />'], '<br>', $html);
        $html = strip_tags($html, '<p><br><strong><b><em><i><u><ul><ol><li><a><blockquote>');

        $html = preg_replace('/\s+on\w+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/iu', '', $html);

        $html = preg_replace_callback('/<a\b[^>]*>/iu', function ($matches) {
            $tag = $matches[0];
            $href = '';
            if (preg_match('/href\s*=\s*("|\')(.*?)\1/iu', $tag, $hrefMatch)) {
                $href = trim((string) $hrefMatch[2]);
            }

            if ($href === '' || !preg_match('/^(https?:\/\/|mailto:|tel:|#|\/)/iu', $href)) {
                return '<a>';
            }

            $safeHref = e($href);
            return '<a href="' . $safeHref . '" target="_blank" rel="noopener noreferrer">';
        }, $html);

        $html = preg_replace('/<(p|br|strong|b|em|i|u|ul|ol|li|blockquote)\b[^>]*>/iu', '<$1>', $html);
        $html = preg_replace('/\s{2,}/u', ' ', $html);
        $html = trim((string) $html);

        $plainText = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
        if ($plainText === '') {
            return '';
        }

        return $html;
    }

    public function pages_blocks(Page $page){
        return view(backpack_view('pages_blocks'), compact('page'));
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

                if($request->has('quick_add')){
                    return redirect()->back();
                }

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

        if($table == "plugins_products" && $field == "is_active"){
            \Artisan::call('set:products_search', ['id'=> $id]);
            \Artisan::call('set:products_categories_search');
        }

        if($table == "plugins_products_categories" && $field == "is_active"){
            \Artisan::call('set:products_categories_search');
        }

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
                if($tempSlug){
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
