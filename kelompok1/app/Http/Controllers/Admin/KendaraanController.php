<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter Status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter Tipe Kendaraan
        if ($request->filled('tipe') && $request->tipe !== 'Semua') {
            $query->where('tipe', $request->tipe);
        }

        // Pencarian Nama Motor / Plat Nomor
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nama_motor', 'like', "%{$cari}%")
                  ->orWhere('plat_nomor', 'like', "%{$cari}%");
            });
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $tipes = Product::select('tipe')->distinct()->pluck('tipe');

        return view('admin.kendaraan.index', compact('products', 'tipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_motor'     => 'required|string|max:255',
            'tipe'           => 'required|in:Matic,Motor Bebek,Sport,Listrik',
            'harga_per_hari' => 'required|numeric',
            'plat_nomor'     => 'required|string|unique:products,plat_nomor',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama_motor', 'tipe', 'harga_per_hari', 'plat_nomor']);
        $data['status'] = 'tersedia';
        $data['fl_aktif'] = 'Y';

        if ($request->hasFile('image')) {

            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);

            $upload = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'products'
                ]
            );

            $data['image_url'] = $upload['secure_url'];

        } else {

            $data['image_url'] = 'https://i.ibb.co.com/VYfhgqm4/image-44.png';

        }
        Product::create($data);

        return response()->json(['success' => true, 'message' => 'Kendaraan berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_motor'     => 'required|string|max:255',
            'tipe' => 'required|in:Matic,Motor Bebek,Sport,Listrik',
            'harga_per_hari' => 'required|numeric',
            'plat_nomor'     => 'required|string|unique:products,plat_nomor,' . $id,
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama_motor', 'tipe', 'harga_per_hari', 'plat_nomor', 'fl_aktif']);

        if ($request->hasFile('image')) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]);

            $upload = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'products'
                ]
            );

            $data['image_url'] = $upload['secure_url'];

        }

        $product->update($data);

        return response()->json(['success' => true, 'message' => 'Kendaraan berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Kendaraan berhasil dihapus.']);
    }
}