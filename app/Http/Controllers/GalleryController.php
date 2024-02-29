<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Image::all();

        return view('index', [
            'images' => $images
        ]);
    }

    public function upload(Request $request)
    {
        $image = $request->file('photo');
        $title = $request->input('title');
        $name = $image->hashName();
        $return = $image->storePublicly('uploads', 'public', $name);
        $src = asset("/storage/" . $return);

        Image::create([
            'title' => $title,
            'url' => $src
        ]);

        return redirect()->route('index')->with('success', "Imagem salva com sucesso!");
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);
        $url = parse_url($image->url);
        $path = ltrim($url['path'], '/storage\/');
        $imageExists = Storage::disk('public')->exists($path);

        if ($imageExists) {
            Storage::disk('public')->delete($path);
            $image->delete();
            return redirect()->route('index')->with('success', 'Imagem excluída com sucesso!');
        }

        return redirect()->route('index')->with('error', 'Essa imagem não existe!');
    }
}
