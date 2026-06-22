<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display global SEO management dashboard.
     */
    public function index()
    {
        $seo_settings = [
            'meta_title' => Setting::getValue('seo_meta_title', 'Auto Parts Marketplace | Certified Used OEM Parts'),
            'meta_description' => Setting::getValue('seo_meta_description', 'Find high-quality used engines, transmissions, headlights and wheels with free shipping.'),
            'canonical_url' => Setting::getValue('seo_canonical_url', 'https://autopartsmarket.com'),
            'robots_meta' => Setting::getValue('seo_robots_meta', 'index, follow'),
            'schema_organization' => Setting::getValue('seo_schema_organization', '{}'),
            'schema_local_business' => Setting::getValue('seo_schema_local_business', '{}')
        ];

        return view('admin.seo.index', compact('seo_settings'));
    }

    /**
     * Update global SEO configurations.
     */
    public function update(Request $request)
    {
        $request->validate([
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string'
        ]);

        Setting::setValue('seo_meta_title', $request->meta_title);
        Setting::setValue('seo_meta_description', $request->meta_description);
        Setting::setValue('seo_canonical_url', $request->canonical_url);
        Setting::setValue('seo_robots_meta', $request->robots_meta);
        Setting::setValue('seo_schema_organization', $request->schema_organization);
        Setting::setValue('seo_schema_local_business', $request->schema_local_business);

        return redirect()->route('admin.seo.index')->with('success', 'Global SEO parameters updated successfully.');
    }
}
