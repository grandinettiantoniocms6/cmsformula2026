<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function settings()
    {
        $this->authorizeSuperAdmin();

        return view('vendor.backpack.ui.superadmin_settings', array_merge(
            $this->getGeneralSettings(),
            $this->getErrorAlertSettings()
        ));
    }

    public function updateSettings(Request $request)
    {
        $this->authorizeSuperAdmin();

        $ccEmails = $this->parseCcEmails((string) $request->input('error_alert_cc', ''));

        $validator = Validator::make(
            [
                'number_max_page' => $request->input('number_max_page'),
                'server_allocated_space' => $request->input('server_allocated_space'),
                'whatsapp_active' => $request->input('whatsapp_active'),
                'admin_panel_template' => $request->input('admin_panel_template'),
                'is_megamenu' => $request->input('is_megamenu'),
                'is_search_one_col' => $request->input('is_search_one_col'),
                'watermark_url' => $request->input('watermark_url'),
                'watermark_position' => $request->input('watermark_position'),
                'watermark_x' => $request->input('watermark_x'),
                'watermark_y' => $request->input('watermark_y'),
                'error_alert_email' => $request->input('error_alert_email'),
                'error_alert_cc' => $ccEmails,
                'error_alert_repeat_hours' => $request->input('error_alert_repeat_hours'),
                'error_alert_enabled' => $request->input('error_alert_enabled'),
            ],
            [
                'number_max_page' => 'nullable|integer|min:0',
                'server_allocated_space' => 'required|string|max:255',
                'whatsapp_active' => 'required|boolean',
                'logo_admin' => 'nullable|string|max:255',
                'logo_login' => 'nullable|string|max:255',
                'dashboard_gif' => 'nullable|string|max:255',
                'admin_topbar_background' => 'nullable|string|max:30',
                'admin_leftbar_background' => 'nullable|string|max:30',
                'admin_login_background' => 'nullable|string|max:255',
                'admin_panel_template' => 'required|in:white,modern_01,modern_02,future',
                'bacheca' => 'nullable|string|max:255',
                'is_megamenu' => 'required|boolean',
                'is_search_one_col' => 'required|boolean',
                'watermark_url' => 'nullable|string|max:255',
                'watermark_position' => 'nullable|string|max:50',
                'watermark_x' => 'nullable|string|max:50',
                'watermark_y' => 'nullable|string|max:50',
                'error_alert_email' => 'required|email',
                'error_alert_cc.*' => 'email',
                'error_alert_repeat_hours' => 'required|integer|min:1|max:8760',
                'error_alert_enabled' => 'required|boolean',
            ],
            [
                'number_max_page.integer' => 'Il numero di pagine deve essere un numero intero.',
                'number_max_page.min' => 'Il numero di pagine non puo\' essere negativo.',
                'server_allocated_space.required' => 'Inserisci lo spazio server allocato.',
                'server_allocated_space.max' => 'Lo spazio server allocato non puo\' superare 255 caratteri.',
                'admin_panel_template.required' => 'Seleziona il template pannello admin.',
                'admin_panel_template.in' => 'Il template pannello admin selezionato non e\' valido.',
                'error_alert_email.required' => 'Inserisci l\'indirizzo email principale.',
                'error_alert_email.email' => 'Inserisci un indirizzo email principale valido.',
                'error_alert_cc.*.email' => 'Uno degli indirizzi in copia non e\' valido.',
                'error_alert_repeat_hours.required' => 'Inserisci dopo quante ore reinviare lo stesso errore.',
                'error_alert_repeat_hours.integer' => 'Il limite ore deve essere un numero intero.',
                'error_alert_repeat_hours.min' => 'Il limite ore deve essere almeno 1.',
                'error_alert_repeat_hours.max' => 'Il limite ore non puo\' superare 8760.',
            ]
        );

        $validator->validate();

        if (!Schema::hasTable('website_settings')) {
            abort(500, 'La tabella website_settings non esiste.');
        }

        $websiteSettingId = DB::table('website_settings')->value('id') ?: 1;

        $websiteSettingPayload = [];

        if (Schema::hasColumn('website_settings', 'number_max_page')) {
            $numberMaxPage = $request->input('number_max_page');
            $websiteSettingPayload['number_max_page'] = $numberMaxPage === null || $numberMaxPage === '' ? null : (int) $numberMaxPage;
        }

        $directWebsiteSettingFields = [
            'whatsapp_active' => (int) $request->boolean('whatsapp_active'),
            'logo_admin' => trim((string) $request->input('logo_admin')),
            'logo_login' => trim((string) $request->input('logo_login')),
            'dashboard_gif' => trim((string) $request->input('dashboard_gif')),
            'admin_topbar_background' => trim((string) $request->input('admin_topbar_background')),
            'admin_leftbar_background' => trim((string) $request->input('admin_leftbar_background')),
            'admin_login_background' => trim((string) $request->input('admin_login_background')),
            'admin_panel_template' => $request->input('admin_panel_template'),
            'bacheca' => trim((string) $request->input('bacheca')),
            'is_megamenu' => (int) $request->boolean('is_megamenu'),
            'is_search_one_col' => (int) $request->boolean('is_search_one_col'),
            'watermark_url' => trim((string) $request->input('watermark_url')),
            'watermark_position' => trim((string) $request->input('watermark_position')),
            'watermark_x' => trim((string) $request->input('watermark_x')),
            'watermark_y' => trim((string) $request->input('watermark_y')),
        ];

        foreach ($directWebsiteSettingFields as $field => $value) {
            if (Schema::hasColumn('website_settings', $field)) {
                $websiteSettingPayload[$field] = $value;
            }
        }

        if (!empty($websiteSettingPayload)) {
            $websiteSettingPayload['updated_at'] = now();

            DB::table('website_settings')
                ->where('id', $websiteSettingId)
                ->update($websiteSettingPayload);
        }

        if (!Schema::hasTable('website_setting_extras') || !Schema::hasColumn('website_setting_extras', 'server_allocated_space')) {
            abort(500, 'Il campo spazio server allocato non esiste. Esegui le migration.');
        }

        DB::table('website_setting_extras')->updateOrInsert(
            ['website_setting_id' => $websiteSettingId],
            [
                'server_allocated_space' => trim((string) $request->input('server_allocated_space')),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        if (!$this->hasErrorAlertColumns()) {
            abort(500, 'I campi per gli avvisi errori non esistono. Esegui le migration.');
        }

        DB::table('website_setting_extras')->updateOrInsert(
            ['website_setting_id' => $websiteSettingId],
            [
                'error_alert_email' => trim((string) $request->input('error_alert_email')),
                'error_alert_cc' => implode(', ', $ccEmails),
                'error_alert_repeat_hours' => (int) $request->input('error_alert_repeat_hours'),
                'error_alert_enabled' => (int) $request->boolean('error_alert_enabled'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        \Alert::success('Impostazioni SuperAdmin aggiornate.')->flash();

        return redirect()->back();
    }

    public function edit()
    {
        $this->authorizeSuperAdmin();

        return redirect()->to(backpack_url('superadminsettings'));
    }

    public function update(Request $request)
    {
        $this->authorizeSuperAdmin();

        $ccEmails = $this->parseCcEmails((string) $request->input('error_alert_cc', ''));

        $validator = Validator::make(
            [
                'error_alert_email' => $request->input('error_alert_email'),
                'error_alert_cc' => $ccEmails,
                'error_alert_repeat_hours' => $request->input('error_alert_repeat_hours'),
                'error_alert_enabled' => $request->input('error_alert_enabled'),
            ],
            [
                'error_alert_email' => 'required|email',
                'error_alert_cc.*' => 'email',
                'error_alert_repeat_hours' => 'required|integer|min:1|max:8760',
                'error_alert_enabled' => 'required|boolean',
            ],
            [
                'error_alert_email.required' => 'Inserisci l\'indirizzo email principale.',
                'error_alert_email.email' => 'Inserisci un indirizzo email principale valido.',
                'error_alert_cc.*.email' => 'Uno degli indirizzi in copia non e\' valido.',
                'error_alert_repeat_hours.required' => 'Inserisci dopo quante ore reinviare lo stesso errore.',
                'error_alert_repeat_hours.integer' => 'Il limite ore deve essere un numero intero.',
                'error_alert_repeat_hours.min' => 'Il limite ore deve essere almeno 1.',
                'error_alert_repeat_hours.max' => 'Il limite ore non puo\' superare 8760.',
            ]
        );

        $validator->validate();

        $websiteSettingId = DB::table('website_settings')->value('id') ?: 1;

        if (!$this->hasErrorAlertColumns()) {
            abort(500, 'I campi per gli avvisi errori non esistono. Esegui le migration.');
        }

        DB::table('website_setting_extras')->updateOrInsert(
            ['website_setting_id' => $websiteSettingId],
            [
                'error_alert_email' => trim((string) $request->input('error_alert_email')),
                'error_alert_cc' => implode(', ', $ccEmails),
                'error_alert_repeat_hours' => (int) $request->input('error_alert_repeat_hours'),
                'error_alert_enabled' => (int) $request->boolean('error_alert_enabled'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        \Alert::success('Impostazioni avvisi errori aggiornate.')->flash();

        return redirect()->to(backpack_url('superadminsettings'));
    }

    private function authorizeSuperAdmin(): void
    {
        if (!backpack_user() || (int) backpack_user()->id !== 1) {
            abort(403);
        }
    }

    private function getErrorAlertSettings(): array
    {
        $default = [
            'errorAlertEmail' => 'info@webisland.it',
            'errorAlertCc' => '',
            'errorAlertRepeatHours' => 4,
            'errorAlertEnabled' => 1,
        ];

        if (!$this->hasErrorAlertColumns()) {
            return $default;
        }

        $extra = DB::table('website_setting_extras')
            ->orderBy('website_setting_id')
            ->first(['error_alert_email', 'error_alert_cc', 'error_alert_repeat_hours', 'error_alert_enabled']);

        if (!$extra) {
            return $default;
        }

        return [
            'errorAlertEmail' => $extra->error_alert_email ?: $default['errorAlertEmail'],
            'errorAlertCc' => $extra->error_alert_cc ?: '',
            'errorAlertRepeatHours' => (int) ($extra->error_alert_repeat_hours ?: $default['errorAlertRepeatHours']),
            'errorAlertEnabled' => (int) $extra->error_alert_enabled,
        ];
    }

    private function getGeneralSettings(): array
    {
        $default = [
            'numberMaxPage' => null,
            'serverAllocatedSpace' => '500 MB',
            'whatsappActive' => 0,
            'logoAdmin' => 'public/img/commons/admin/logo-cms-formula-5.png',
            'logoLogin' => 'public/img/commons/admin/logo-cms-formula-5_2.png',
            'dashboardGif' => '',
            'adminTopbarBackground' => '#1b2a4e',
            'adminLeftbarBackground' => '#1b2a4e',
            'adminLoginBackground' => '',
            'adminPanelTemplate' => 'white',
            'bacheca' => '',
            'isMegamenu' => 0,
            'isSearchOneCol' => 0,
            'watermarkUrl' => '',
            'watermarkPosition' => 'bottom-right',
            'watermarkX' => 10,
            'watermarkY' => 10,
            'shopAreasPresent' => Schema::hasTable('shop_areas'),
        ];

        if (!Schema::hasTable('website_settings')) {
            return $default;
        }

        $websiteSettingColumns = ['id'];
        foreach ([
            'number_max_page',
            'whatsapp_active',
            'logo_admin',
            'logo_login',
            'dashboard_gif',
            'admin_topbar_background',
            'admin_leftbar_background',
            'admin_login_background',
            'admin_panel_template',
            'bacheca',
            'is_megamenu',
            'is_search_one_col',
            'watermark_url',
            'watermark_position',
            'watermark_x',
            'watermark_y',
        ] as $column) {
            if (Schema::hasColumn('website_settings', $column)) {
                $websiteSettingColumns[] = $column;
            }
        }

        $websiteSetting = DB::table('website_settings')->orderBy('id')->first($websiteSettingColumns);

        if (!$websiteSetting) {
            return $default;
        }

        $serverAllocatedSpace = $default['serverAllocatedSpace'];

        if (Schema::hasTable('website_setting_extras') && Schema::hasColumn('website_setting_extras', 'server_allocated_space')) {
            $serverAllocatedSpace = DB::table('website_setting_extras')
                ->where('website_setting_id', $websiteSetting->id)
                ->value('server_allocated_space') ?: $serverAllocatedSpace;
        }

        return [
            'numberMaxPage' => $websiteSetting->number_max_page ?? null,
            'serverAllocatedSpace' => $serverAllocatedSpace,
            'whatsappActive' => (int) ($websiteSetting->whatsapp_active ?? $default['whatsappActive']),
            'logoAdmin' => $websiteSetting->logo_admin ?? $default['logoAdmin'],
            'logoLogin' => $websiteSetting->logo_login ?? $default['logoLogin'],
            'dashboardGif' => $websiteSetting->dashboard_gif ?? $default['dashboardGif'],
            'adminTopbarBackground' => $websiteSetting->admin_topbar_background ?? $default['adminTopbarBackground'],
            'adminLeftbarBackground' => $websiteSetting->admin_leftbar_background ?? $default['adminLeftbarBackground'],
            'adminLoginBackground' => $websiteSetting->admin_login_background ?? $default['adminLoginBackground'],
            'adminPanelTemplate' => $websiteSetting->admin_panel_template ?? $default['adminPanelTemplate'],
            'bacheca' => $websiteSetting->bacheca ?? $default['bacheca'],
            'isMegamenu' => (int) ($websiteSetting->is_megamenu ?? $default['isMegamenu']),
            'isSearchOneCol' => (int) ($websiteSetting->is_search_one_col ?? $default['isSearchOneCol']),
            'watermarkUrl' => $websiteSetting->watermark_url ?? $default['watermarkUrl'],
            'watermarkPosition' => $websiteSetting->watermark_position ?? $default['watermarkPosition'],
            'watermarkX' => $websiteSetting->watermark_x ?? $default['watermarkX'],
            'watermarkY' => $websiteSetting->watermark_y ?? $default['watermarkY'],
            'shopAreasPresent' => Schema::hasTable('shop_areas'),
        ];
    }

    private function parseCcEmails(string $value): array
    {
        return collect(explode(',', $value))
            ->map(function ($email) {
                return trim((string) $email);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function hasErrorAlertColumns(): bool
    {
        return Schema::hasTable('website_setting_extras')
            && Schema::hasColumn('website_setting_extras', 'error_alert_email')
            && Schema::hasColumn('website_setting_extras', 'error_alert_cc')
            && Schema::hasColumn('website_setting_extras', 'error_alert_repeat_hours')
            && Schema::hasColumn('website_setting_extras', 'error_alert_enabled');
    }
}
