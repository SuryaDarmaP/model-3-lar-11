<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Http\Controllers\Admin\DistributorController;



class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $data = DB:: table('distributors')
            ->join('products', 'distributors.id', '=', 'products.id_distributor')
            ->select('distributors.*', 'products.*')
            ->get();

        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');
        
        return view('pages.admin.product.index', compact('data'));
        
    }  

    /**
     * Menampilkan form untuk menambah produk.
     */
    public function create()
    {
        $distributor = Distributor::all();

        return view('pages.admin.product.create', compact('distributor'));

    }

    /**
     * Menampilkan detail produk berdasarkan ID.
     */
    public function detail($id)
    {
        $data = DB::table('distributors')
                ->join('products', 'distributors.id', '=', 'products.id_distributor')
                ->select('products.*', 'distributors.*')
                ->where('products.id', '=', $id)
                ->first();

        return view('pages.admin.product.detail', compact('data'));
    }

    /**
     * Menyimpan data produk baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_distributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'numeric|required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg',
            'discount' => 'nullable|numeric|min:0|max:100', // Discount validation
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
                'id_distributor' => $request->id_distributor,
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'description' => $request->description,
                'image' => $imageName,
                'discount' => $request->discount ?? 0, // Set discount or default to 0
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
        $distributor = Distributor::all();

        return view('pages.admin.product.edit', compact('product', 'distributor'));
    }

    /**
     * Mengupdate data produk.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_distributor' => 'required|numeric',
            'name' => 'required',
            'price' => 'numeric|required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpeg,jpg',
            'discount' => 'nullable|numeric|min:0|max:100', // Discount validation
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
            'id_distributor' => $request->id_distributor,
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imageName,
            'discount' => $request->discount ?? 0, // Update discount
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