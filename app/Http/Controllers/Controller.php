<?php

namespace App\Http\Controllers;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Product;


abstract class Controller
{
    public function detail_product($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.user.detail', compact('product'));
    }
    public function purchase ($productId, $userId)
    {
        $product = Product::findOrFail($productId);
        $user = User::findOrFail($userId);

        if ($user->point >>$product->price) {
            $totalPoints = $user->point - $product->price;
            
            $user->update([
                'point' => $totalPoints,
            ]);

            Alert::success('Berhasil!', 'Produk berhasil dibeli!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Point anda tidak cukup!');
            return redirect()->back();
        }
    }
    //
}
