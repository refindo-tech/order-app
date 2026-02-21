<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Show the form for editing the hero banner (title & description).
     */
    public function edit()
    {
        $banner = HeroBanner::current();
        return view('admin.banner.edit', ['banner' => $banner]);
    }

    /**
     * Update the hero banner.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:500'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $banner = HeroBanner::current();
        $banner->update($validated);

        return redirect()
            ->route('admin.banner.edit')
            ->with('success', 'Banner beranda berhasil diperbarui.');
    }
}
