<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function index()
    {
        $banners = DB::table('banners')->orderBy('display_order')->get();
        return response()->json(['success' => true, 'data' => $banners]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|string'
        ]);

        $id = DB::table('banners')->insertGetId([
            'title' => $request->title,
            'image_url' => $request->image_url,
            'link_url' => $request->link_url,
            'display_order' => $request->display_order ?? 0,
            'rotation_time' => $request->rotation_time ?? 5,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        DB::table('banners')->where('id', $id)->update([
            'title' => $request->title,
            'image_url' => $request->image_url,
            'link_url' => $request->link_url,
            'display_order' => $request->display_order ?? 0,
            'rotation_time' => $request->rotation_time ?? 5,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? true,
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        DB::table('banners')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120'
        ]);

        $file = $request->file('image');
        $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
        
        $destinationPath = base_path('../assets/img');
        $file->move($destinationPath, $filename);

        return response()->json([
            'success' => true,
            'filename' => $filename,
            'path' => 'assets/img/' . $filename
        ]);
    }

    public function delete(Request $request)
    {
        $filename = $request->input('filename');
        $path = base_path('../assets/img/' . $filename);
        
        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
