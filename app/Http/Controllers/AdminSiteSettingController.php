<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTranslatedFields;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSiteSettingController extends Controller
{
    use InteractsWithTranslatedFields;

    public function edit()
    {
        return view('admin.settings.form', [
            'settings' => SiteSetting::query()->firstOrCreate([], [
                'site_name' => 'شركة نفوذ المستقبل',
            ]),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'logo_url' => ['nullable', 'url', 'max:2048'],
            'logo_file' => ['nullable', 'image', 'max:4096'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string'],
            'map_embed_url' => ['nullable', 'url', 'max:2048'],
            'whatsapp_number' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'about_text' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'default_article_image_url' => ['nullable', 'url', 'max:2048'],
            'default_article_image_file' => ['nullable', 'image', 'max:4096'],
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string'],
            'default_meta_keywords' => ['nullable', 'string'],
            'translations' => ['nullable', 'array'],
        ]);

        $settings = SiteSetting::query()->firstOrCreate([]);

        $translatedFields = $this->extractTranslationFields($request, [
            'site_name',
            'site_tagline',
            'contact_address',
            'vision',
            'mission',
            'about_text',
            'footer_text',
            'default_meta_title',
            'default_meta_description',
            'default_meta_keywords',
        ], app()->getFallbackLocale());

        if (empty($validated['site_name']) && empty($translatedFields['site_name'])) {
            return back()
                ->withErrors(['site_name' => __('The site name field is required.')])
                ->withInput();
        }

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = $this->storeUploadedFile($request->file('logo_file'), 'site');
        }

        if ($request->hasFile('default_article_image_file')) {
            $validated['default_article_image_path'] = $this->storeUploadedFile($request->file('default_article_image_file'), 'site');
        }

        $validated = array_merge($validated, $translatedFields);

        if (empty($validated['site_name'])) {
            $validated['site_name'] = $settings->site_name;
        }

        $settings->update($validated);

        return redirect()->route('admin.settings.edit')->with('success', 'تم تحديث إعدادات الموقع بنجاح.');
    }

    protected function storeUploadedFile($file, string $directory): string
    {
        $relativeDirectory = public_path('uploads/'.$directory);

        if (! is_dir($relativeDirectory)) {
            mkdir($relativeDirectory, 0777, true);
        }

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($relativeDirectory, $filename);

        return 'uploads/'.$directory.'/'.$filename;
    }
}
