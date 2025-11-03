<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SliderLandingPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingLandingPageController extends Controller
{
    public function index()
    {
        $data = LandingPage::first();
        $slider = SliderLandingPage::get();
        $title = 'Pengaturan Landing Page';
        $subtitle = 'Pengaturan Landing Page';
        return view('admin.setting-landing-page.index', compact('data', 'slider', 'title', 'subtitle'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'full_name' => 'required',
            'about' => 'required',
            'new_slider_name.*' => 'required',
            'new_slider_status.*' => 'required',
            'new_slider_image.*' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'name.required' => 'Nama website wajib diisi',
            'full_name.required' => 'Nama Lengkap website wajib diisi',
            'about.required' => 'Deskripsi website wajib diisi',
            'new_slider_name.*.required' => 'Judul slider wajib diisi',
            'new_slider_status.*.required' => 'Status slider wajib diisi',
            'new_slider_image.*.required' => 'Gambar slider wajib diisi',
            'new_slider_image.*.mimes' => 'File harus berupa jpeg, png, jpg, gif, svg, webp',
            'new_slider_image.*.max' => 'File tidak boleh lebih dari 2 MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'pesan' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $option = LandingPage::find($id);
            $option->name = $request->name;
            $option->full_name = $request->full_name;
            $option->about = $request->about;
            $option->save();

            $existingSliders = SliderLandingPage::pluck('id')->toArray(); // Get all existing slider IDs
            $requestSliderIds = $request->slider_id ?? []; // Get slider IDs from the request

            // Delete old sliders that are not in the request
            foreach ($existingSliders as $existingId) {
                if (!in_array($existingId, $requestSliderIds)) {
                    $slider = SliderLandingPage::find($existingId);
                    if ($slider && file_exists(public_path($slider->file_path))) {
                        unlink(public_path($slider->file_path)); // Unlink the old image
                    }
                    $slider->delete(); // Delete the slider record
                }
            }

            // Update existing sliders
            foreach ($requestSliderIds as $index => $sliderId) {
                $slider = SliderLandingPage::find($sliderId);
                if ($slider) {
                    $slider->name = $request->slider_name[$index];
                    $slider->status = $request->slider_status[$index];

                    // Check if there's a new image uploaded for this slider
                    if ($request->hasFile("slider_image.$sliderId")) {
                        $image = $request->file("slider_image.$sliderId");
                        $filename = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();

                        // Remove the old image if it exists
                        if (file_exists(public_path($slider->file_path))) {
                            unlink(public_path($slider->file_path));
                        }

                        $image->move(public_path('slider'), $filename);
                        $slider->file_path = 'slider/' . $filename;
                    }

                    $slider->save();
                }
            }

            // Create new sliders (handled as in your existing code)
            if ($request->has('new_slider_name')) {
                foreach ($request->new_slider_name as $key => $value) {
                    $image = $request->new_slider_image[$key];
                    $filename = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('slider'), $filename);
                    $filename = 'slider/' . $filename;
                    $data = [
                        'id' => Str::uuid(),
                        'name' => $request->new_slider_name[$key],
                        'status' => $request->new_slider_status[$key],
                        'file_path' => $filename,
                        'order' => $key+1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    SliderLandingPage::create($data);
                }
            }

            DB::commit();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'pesan' => $e->getMessage()]);
        }
    }

}
