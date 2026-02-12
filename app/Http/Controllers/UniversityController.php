<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::orderBy('name')->paginate(20);
        return view('universities.index', compact('universities'));
    }

    public function publicIndex(Request $request)
    {
        $query = University::orderBy('name');
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        $universities = $query->get();
        $countries = config('destinations.countries', []);
        return view('universities.public-index', compact('universities', 'countries'));
    }

    public function create()
    {
        return view('universities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_japanese' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'established' => 'nullable|integer|min:1800|max:2030',
            'number_of_international_students' => 'nullable|integer|min:0',
            'type' => 'required|in:university,college,school,vocational',
            'institution_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'prefecture' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'tuition_fee' => 'nullable|numeric|min:0',
            'banner_image' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('banner_image')) {
            $banner = $request->file('banner_image');
            $bannerName = 'banner_' . uniqid() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('images/universities'), $bannerName);
            $validated['banner_image'] = 'images/universities/' . $bannerName;
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/universities'), $logoName);
            $validated['logo'] = 'images/universities/' . $logoName;
        }

        $university = University::create($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University created successfully!');
    }

    public function show(University $university)
    {
        $university->increment('view_count');
        return view('universities.show', compact('university'));
    }

    public function edit(University $university)
    {
        return view('universities.edit', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_japanese' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'established' => 'nullable|integer|min:1800|max:2030',
            'number_of_international_students' => 'nullable|integer|min:0',
            'type' => 'required|in:university,college,school,vocational',
            'institution_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'prefecture' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'tuition_fee' => 'nullable|numeric|min:0',
            'banner_image' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($university->banner_image && file_exists(public_path($university->banner_image))) {
                unlink(public_path($university->banner_image));
            }
            $banner = $request->file('banner_image');
            $bannerName = 'banner_' . uniqid() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('images/universities'), $bannerName);
            $validated['banner_image'] = 'images/universities/' . $bannerName;
        }

        if ($request->hasFile('logo')) {
            if ($university->logo && file_exists(public_path($university->logo))) {
                unlink(public_path($university->logo));
            }
            $logo = $request->file('logo');
            $logoName = 'logo_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/universities'), $logoName);
            $validated['logo'] = 'images/universities/' . $logoName;
        }

        $university->update($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University updated successfully!');
    }

    public function destroy(University $university)
    {
        if ($university->banner_image && file_exists(public_path($university->banner_image))) {
            unlink(public_path($university->banner_image));
        }
        if ($university->logo && file_exists(public_path($university->logo))) {
            unlink(public_path($university->logo));
        }
        
        $university->delete();

        return redirect()->route('admin.universities.index')
            ->with('success', 'University deleted successfully!');
    }
}
