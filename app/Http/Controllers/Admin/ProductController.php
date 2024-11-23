<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $products = Product::all();
        confirmDelete('Hapus Data', 'Apakah anda yakin ingin menghapus data ini');
        return view('pages.admin.product.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk.
     */
    public function create()
    {
        return view('pages.admin.product.create');
    }

    /**
     * Menampilkan detail produk berdasarkan ID.
     */
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.admin.product.detail', compact('product'));
    }

    /**
     * Menyimpan data produk baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric|required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg'
        ]);

        // Jika validasi gagal, tampilkan pesan error
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);

            // Menyimpan data produk baru ke database
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'description' => $request->description,
                'image' => $imageName
            ]);

            // Jika produk berhasil ditambahkan, tampilkan pesan sukses
            if ($product) {
                Alert::success('Berhasil!', 'Produk berhasil ditambahkan!');
                return redirect()->route('admin.product');
            }
        }

        // Jika gagal, tampilkan pesan error
        Alert::error('Gagal!', 'Produk gagal ditambahkan!');
        return redirect()->back();
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        // Menemukan produk berdasarkan ID
        $product = Product::findOrFail($id);
        return view('pages.admin.product.edit', compact('product'));
    }

    /**
     * Mengupdate data produk.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric|required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpeg,jpg'
        ]);

        // Jika validasi gagal, tampilkan pesan error
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menemukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            $oldPath = public_path("images/{$product->image}");
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Menyimpan gambar baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images/', $imageName);
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $imageName = $product->image;
        }

        // Memperbarui data produk
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        // Menampilkan pesan berhasil atau gagal
        if ($product) {
            Alert::success('Berhasil!', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.product');
        } else {
            Alert::error('Gagal!', 'Produk gagal diperbarui!');
            return redirect()->back();
        }
    }

    /**
     * Menghapus data produk berdasarkan ID.
     */
    public function delete($id)
    {
        // Menemukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Menghapus gambar lama jika ada
        $oldPath = public_path('images/' . $product->image);
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }

        // Menghapus produk dari database
        $productDeleted = $product->delete();
        if ($productDeleted) {
            Alert::success('Berhasil!', 'Produk berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Produk gagal dihapus!');
            return redirect()->back();
        }
    }
}