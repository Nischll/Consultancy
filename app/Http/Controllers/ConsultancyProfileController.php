<?php

namespace App\Http\Controllers;

use App\Models\ConsultancyProfile;
use Illuminate\Http\Request;

class ConsultancyProfileController extends Controller
{
    public function index()
    {
        $profile = ConsultancyProfile::first();
        return view('consultancy.profile.index', compact('profile'));
    }

    public function create()
    {
        $profile = ConsultancyProfile::first();
        if ($profile) {
            return redirect()->route('consultancy.profile.edit', $profile);
        }
        return view('consultancy.profile.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'advertisement' => 'nullable|string',
            'advertisement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'services' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('consultancy'), $logoName);
            $validated['logo'] = 'consultancy/' . $logoName;
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('consultancy'), $bannerName);
            $validated['banner'] = 'consultancy/' . $bannerName;
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = 'image_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('consultancy/images'), $imageName);
                $images[] = 'consultancy/images/' . $imageName;
            }
            $validated['images'] = $images;
        }

        // Handle advertisement image upload
        if ($request->hasFile('advertisement_image')) {
            $adImage = $request->file('advertisement_image');
            $adImageName = 'advertisement_' . time() . '.' . $adImage->getClientOriginalExtension();
            $adImage->move(public_path('consultancy'), $adImageName);
            $validated['advertisement_image'] = 'consultancy/' . $adImageName;
        }

        // Handle social links
        if ($request->filled('social_links')) {
            $validated['social_links'] = [
                'facebook' => $request->input('social_links.facebook'),
                'twitter' => $request->input('social_links.twitter'),
                'linkedin' => $request->input('social_links.linkedin'),
                'instagram' => $request->input('social_links.instagram'),
            ];
        }

        ConsultancyProfile::create($validated);

        return redirect()->route('consultancy.profile.index')
            ->with('success', 'Consultancy profile created successfully!');
    }

    public function show(ConsultancyProfile $profile)
    {
        return view('consultancy.profile.show', compact('profile'));
    }

    public function edit(ConsultancyProfile $profile)
    {
        return view('consultancy.profile.edit', compact('profile'));
    }

    public function update(Request $request, ConsultancyProfile $profile)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'advertisement' => 'nullable|string',
            'advertisement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'services' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($profile->logo && file_exists(public_path($profile->logo))) {
                unlink(public_path($profile->logo));
            }
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('consultancy'), $logoName);
            $validated['logo'] = 'consultancy/' . $logoName;
        }

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($profile->banner && file_exists(public_path($profile->banner))) {
                unlink(public_path($profile->banner));
            }
            $banner = $request->file('banner');
            $bannerName = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('consultancy'), $bannerName);
            $validated['banner'] = 'consultancy/' . $bannerName;
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $existingImages = $profile->images ?? [];
            $newImages = [];
            foreach ($request->file('images') as $image) {
                $imageName = 'image_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('consultancy/images'), $imageName);
                $newImages[] = 'consultancy/images/' . $imageName;
            }
            $validated['images'] = array_merge($existingImages, $newImages);
        }

        // Handle advertisement image upload
        if ($request->hasFile('advertisement_image')) {
            // Delete old advertisement image
            if ($profile->advertisement_image && file_exists(public_path($profile->advertisement_image))) {
                unlink(public_path($profile->advertisement_image));
            }
            $adImage = $request->file('advertisement_image');
            $adImageName = 'advertisement_' . time() . '.' . $adImage->getClientOriginalExtension();
            $adImage->move(public_path('consultancy'), $adImageName);
            $validated['advertisement_image'] = 'consultancy/' . $adImageName;
        }

        // Handle social links
        if ($request->filled('social_links')) {
            $validated['social_links'] = [
                'facebook' => $request->input('social_links.facebook'),
                'twitter' => $request->input('social_links.twitter'),
                'linkedin' => $request->input('social_links.linkedin'),
                'instagram' => $request->input('social_links.instagram'),
            ];
        }

        $profile->update($validated);

        return redirect()->route('consultancy.profile.index')
            ->with('success', 'Consultancy profile updated successfully!');
    }

    public function destroy(ConsultancyProfile $profile)
    {
        // Delete associated files
        if ($profile->logo && file_exists(public_path($profile->logo))) {
            unlink(public_path($profile->logo));
        }
        if ($profile->banner && file_exists(public_path($profile->banner))) {
            unlink(public_path($profile->banner));
        }
        if ($profile->advertisement_image && file_exists(public_path($profile->advertisement_image))) {
            unlink(public_path($profile->advertisement_image));
        }
        if ($profile->images) {
            foreach ($profile->images as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

        $profile->delete();

        return redirect()->route('consultancy.profile.index')
            ->with('success', 'Consultancy profile deleted successfully!');
    }

    public function removeImage(Request $request, ConsultancyProfile $profile)
    {
        $imagePath = $request->input('image_path');
        if ($imagePath && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }
        
        $images = $profile->images ?? [];
        $images = array_filter($images, function($img) use ($imagePath) {
            return $img !== $imagePath;
        });
        $profile->update(['images' => array_values($images)]);

        return redirect()->back()->with('success', 'Image removed successfully!');
    }
}
