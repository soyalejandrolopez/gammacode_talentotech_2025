<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recuperar todos los ajustes
        $settings = $this->getSettings();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the specified settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'footer_text' => 'nullable|string|max:1000',
            'currency_symbol' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'maintenance_mode' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener los ajustes actuales
        $settings = $this->getSettings();

        // Actualizar los ajustes con los nuevos valores
        $settings['site_name'] = $request->input('site_name');
        $settings['site_description'] = $request->input('site_description');
        $settings['contact_email'] = $request->input('contact_email');
        $settings['contact_phone'] = $request->input('contact_phone');
        $settings['contact_address'] = $request->input('contact_address');
        $settings['facebook_url'] = $request->input('facebook_url');
        $settings['instagram_url'] = $request->input('instagram_url');
        $settings['twitter_url'] = $request->input('twitter_url');
        $settings['youtube_url'] = $request->input('youtube_url');
        $settings['footer_text'] = $request->input('footer_text');
        $settings['currency_symbol'] = $request->input('currency_symbol');
        $settings['currency_code'] = $request->input('currency_code');
        $settings['tax_rate'] = $request->input('tax_rate');
        $settings['shipping_fee'] = $request->input('shipping_fee');
        $settings['min_order_amount'] = $request->input('min_order_amount');
        $settings['maintenance_mode'] = $request->has('maintenance_mode');

        // Manejar la carga o eliminación del logo
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if (isset($settings['logo']) && Storage::disk('public')->exists($settings['logo'])) {
                Storage::disk('public')->delete($settings['logo']);
            }

            // Guardar el nuevo logo
            $logoPath = $request->file('logo')->store('settings', 'public');
            $settings['logo'] = $logoPath;
        } elseif ($request->has('remove_logo')) {
            // Eliminar el logo si se solicitó
            if (isset($settings['logo']) && Storage::disk('public')->exists($settings['logo'])) {
                Storage::disk('public')->delete($settings['logo']);
            }
            $settings['logo'] = '';
        }

        // Manejar la carga o eliminación del favicon
        if ($request->hasFile('favicon')) {
            // Eliminar el favicon anterior si existe
            if (isset($settings['favicon']) && Storage::disk('public')->exists($settings['favicon'])) {
                Storage::disk('public')->delete($settings['favicon']);
            }

            // Guardar el nuevo favicon
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            $settings['favicon'] = $faviconPath;
        } elseif ($request->has('remove_favicon')) {
            // Eliminar el favicon si se solicitó
            if (isset($settings['favicon']) && Storage::disk('public')->exists($settings['favicon'])) {
                Storage::disk('public')->delete($settings['favicon']);
            }
            $settings['favicon'] = '';
        }

        // Guardar los ajustes actualizados
        $this->saveSettings($settings);

        // Limpiar la caché
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Los ajustes se han actualizado correctamente.');
    }

    /**
     * Get all settings from the JSON file.
     *
     * @return array
     */
    private function getSettings()
    {
        // Intentar recuperar los ajustes de la caché
        if (Cache::has('settings')) {
            return Cache::get('settings');
        }

        // Si no están en caché, leer del archivo JSON
        $path = storage_path('app/settings.json');

        if (file_exists($path)) {
            $settings = json_decode(file_get_contents($path), true);
        } else {
            // Valores por defecto si el archivo no existe
            $settings = [
                'site_name' => 'AgroGastro',
                'site_description' => 'Conectando productores rurales directamente con clientes',
                'contact_email' => 'info@agrogastro.co',
                'contact_phone' => '',
                'contact_address' => '',
                'facebook_url' => '',
                'instagram_url' => '',
                'twitter_url' => '',
                'youtube_url' => '',
                'logo' => '',
                'favicon' => '',
                'footer_text' => '© ' . date('Y') . ' AgroGastro. Todos los derechos reservados.',
                'currency_symbol' => '$',
                'currency_code' => 'COP',
                'tax_rate' => 19,
                'shipping_fee' => 0,
                'min_order_amount' => 0,
                'maintenance_mode' => false,
            ];
        }

        // Guardar en caché para futuras solicitudes
        Cache::put('settings', $settings, now()->addDay());

        return $settings;
    }

    /**
     * Save settings to the JSON file.
     *
     * @param  array  $settings
     * @return void
     */
    private function saveSettings($settings)
    {
        $path = storage_path('app/settings.json');
        file_put_contents($path, json_encode($settings, JSON_PRETTY_PRINT));

        // Actualizar la caché
        Cache::put('settings', $settings, now()->addDay());
    }
}
