<?php

use App\Models\Product;

function rupiah($str)
{
    return "Rp " . number_format($str, 0, ',', '.');
}

function foto_produk($str)
{
    if ($str) {
        if (!file_exists('assets/img/produk/' . $str)) {
            $str = 'no_image.jpg';
        }
    } else {
        $str = 'no_image.jpg';
    }

    return asset('assets/img/produk/' . $str);
}

function error_page($code, $title)
{

    return view('template/error', compact('code', 'title'));
}

function get_nama_produk($id)
{
    return Product::find($id)->nama_produk;
}
