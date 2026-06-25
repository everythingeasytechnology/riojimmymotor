<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings panels.
     */
    public function index()
    {
        $settings = [
            'site_name' => Setting::getValue('site_name', 'Rio Jimmy Motor'),
            'contact_phone' => Setting::getValue('contact_phone', '+1 (800) 555-0199'),
            'contact_email' => Setting::getValue('contact_email', 'support@riojimmymotor.com'),
            'office_address' => Setting::getValue('office_address', '100 Industrial Pkwy, Detroit, MI 48201'),
            'business_hours' => Setting::getValue('business_hours', 'Mon - Sat: 8:00 AM - 6:00 PM EST'),
            'google_analytics_id' => Setting::getValue('google_analytics_id', ''),
            'clarity_project_id' => Setting::getValue('clarity_project_id', ''),
            'facebook_pixel_id' => Setting::getValue('facebook_pixel_id', ''),
            'custom_header_scripts' => Setting::getValue('custom_header_scripts', ''),
            'custom_footer_scripts' => Setting::getValue('custom_footer_scripts', '')
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Save/update site settings.
     */
    public function update(Request $request)
    {
        // General site settings
        Setting::setValue('site_name', $request->site_name);
        Setting::setValue('contact_phone', $request->contact_phone);
        Setting::setValue('contact_email', $request->contact_email);
        Setting::setValue('office_address', $request->office_address);
        Setting::setValue('business_hours', $request->business_hours);

        // Integration Scripts
        Setting::setValue('google_analytics_id', $request->google_analytics_id);
        Setting::setValue('clarity_project_id', $request->clarity_project_id);
        Setting::setValue('facebook_pixel_id', $request->facebook_pixel_id);
        Setting::setValue('custom_header_scripts', $request->custom_header_scripts);
        Setting::setValue('custom_footer_scripts', $request->custom_footer_scripts);

        // Handle Site Logo uploads
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            $logoPath = '/uploads/settings/' . $filename;
            Setting::setValue('site_logo', $logoPath);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Global website configurations updated.');
    }
}
