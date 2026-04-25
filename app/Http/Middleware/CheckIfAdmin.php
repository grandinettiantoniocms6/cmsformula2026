<?php

namespace App\Http\Middleware;

use App\Models\AdminBlock;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\UserNavigation;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class CheckIfAdmin
{
    /**
     * Checked that the logged in user is an administrator.
     *
     * --------------
     * VERY IMPORTANT
     * --------------
     * If you have both regular users and admins inside the same table,
     * change the contents of this method to check that the logged in user
     * is an admin, and not a regular user.
     *
     * @param [type] $user [description]
     *
     * @return bool [description]
     */
    private function checkIfUserIsAdmin($user)
    {
        $check = UserNavigation::where("user_id", backpack_user()->id)->first();
        $url = url()->current();

        $url = trim(str_replace(env('APP_URL'), "", $url));

        if(($url == "/admin/user" || $url == "/admin/role") && backpack_user()->roles[0]->id != 1){
            die;
        }

        if(!$check){
            UserNavigation::create([
               "user_id" => backpack_user()->id,
                "url" => $url
            ]);

        }else{
            $check->url = $url;
            $check->save();
        }

        // return ($user->is_admin == 1);
        return true;
    }

    private function trackPageUpdateFromBlockEdit($request): void
    {
        $normalizeBlockKey = static function ($value): string {
            return strtolower((string) preg_replace('/[^a-z0-9]/i', '', (string) $value));
        };

        if (!in_array(strtoupper((string) $request->method()), ['POST', 'PUT', 'PATCH'], true)) {
            return;
        }

        if ($request->isMethod('post')) {
            $spoofedMethod = strtolower((string) $request->input('_method', ''));
            $segments = $request->segments();
            $looksLikeDirectUpdatePost = count($segments) >= 3 && strtolower((string) $segments[0]) === 'admin' && ctype_digit((string) $segments[2]);
            if (!in_array($spoofedMethod, ['put', 'patch'], true) && !$looksLikeDirectUpdatePost) {
                return;
            }
        }

        if (!Schema::hasTable('pages') || !Schema::hasTable('blocks_pages') || !Schema::hasTable('admin_blocks')) {
            return;
        }

        if (!Schema::hasColumn('pages', 'updated_by')) {
            return;
        }

        $segments = $request->segments();
        if (count($segments) < 3 || strtolower((string) $segments[0]) !== 'admin') {
            return;
        }

        $blockType = (string) $segments[1];
        $objectId = (int) $segments[2];
        if ($objectId <= 0 || $blockType === '') {
            return;
        }

        static $validBlockNamesByLower = null;
        if ($validBlockNamesByLower === null) {
            $validBlockNamesByLower = AdminBlock::query()
                ->pluck('name')
                ->filter()
                ->mapWithKeys(function ($name) use ($normalizeBlockKey) {
                    return [$normalizeBlockKey($name) => (string) $name];
                })
                ->toArray();
        }

        $blockTypeLower = $normalizeBlockKey($blockType);
        if ($blockTypeLower === '' || !isset($validBlockNamesByLower[$blockTypeLower])) {
            return;
        }

        $canonicalBlockType = $validBlockNamesByLower[$blockTypeLower];
        $pageId = PageBlock::where('type', $canonicalBlockType)
            ->where('obj_id', $objectId)
            ->orderBy('id', 'desc')
            ->value('page_id');

        if (!$pageId) {
            $adminBlock = AdminBlock::where('name', $canonicalBlockType)->first(['name_table']);
            $nameTable = $adminBlock->name_table ?? null;

            if ($nameTable && Schema::hasTable($nameTable) && Schema::hasColumn($nameTable, 'block_id')) {
                $parentBlockId = (int) \DB::table($nameTable)->where('id', $objectId)->value('block_id');
                if ($parentBlockId > 0) {
                    $pageId = PageBlock::where('type', $canonicalBlockType)
                        ->where('obj_id', $parentBlockId)
                        ->orderBy('id', 'desc')
                        ->value('page_id');
                }
            }
        }

        if (!$pageId) {
            return;
        }

        $pageUpdates = [
            'updated_by' => backpack_user()->id,
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('pages', 'updated_context')) {
            $pageUpdates['updated_context'] = 'block';
        }

        if (Schema::hasColumn('pages', 'updated_block_type')) {
            $pageUpdates['updated_block_type'] = $canonicalBlockType;
        }

        Page::where('id', $pageId)->update($pageUpdates);
    }

    /**
     * Answer to unauthorized access request.
     *
     * @param [type] $request [description]
     *
     * @return [type] [description]
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //App::setLocale("it");

        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        if (! $this->checkIfUserIsAdmin(backpack_user())) {
            return $this->respondToUnauthorizedRequest($request);
        }

        $this->trackPageUpdateFromBlockEdit($request);

        return $next($request);
    }
}
