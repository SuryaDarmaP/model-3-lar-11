@extends('layouts.admin.main')
@section('title', 'Admin Tambah Product')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.product') }}">Produk</a>
                </div>
                <div class="breadcrumb-item">Tambah Produk</div>
            </div>
        </div>

        <a href="{{ route('admin.product') }}" class="btn btn-icon icon-left btn-warning"> Kembali</a>

        <div class="card mt-4">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Produk -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input id="name" type="text" class="form-control" name="name" required="">
                                <div class="invalid-feedback">Kolom ini harus di isi!</div>
                            </div>
                        </div>

                        <!-- Harga Produk -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Harga Produk (Point)</label>
                                <input id="price" type="number" class="form-control" name="price" required="">
                                <div class="invalid-feedback">Kolom ini harus di isi!</div>
                            </div>
                        </div>

                        <!-- Kategori Produk -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="category">Kategori Produk</label>
                                <input id="category" type="text" class="form-control" name="category" required="">
                                <div class="invalid-feedback">Kolom ini harus di isi!</div>
                            </div>
                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Deskripsi Produk</label>
                                <textarea id="description" class="form-control" name="description" cols="30" rows="10" required=""></textarea>
                                <div class="invalid-feedback">Isi berita harus di isi!</div>
                            </div>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input id="customFile" type="file" class="custom-file-input" name="image" required="">
                                    <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                </div>
                                <div class="invalid-feedback">Kolom ini harus di isi!</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
