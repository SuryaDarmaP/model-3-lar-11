@extends('layouts.admin.main')
@section('title', 'Admin Distributor')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Distributor</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Distributor</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <a href="{{ route('distributor.create') }}" class="btn btn-icon icon-left btn-primary">
                    <i class="fas fa-plus"></i> Distributor
                </a>
                <a href="{{ route('distributor.export') }}" class="btn btn-icon icon-left btn-info">
                    <i class="fas fa-print"></i> Export
                </a>
            </div>
            <div class="col-md-8 col-sm-9">
                <form action="{{ route('distributor.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-center">
                        <div class="form-group mb-0 mr-2">
                            <div class="custom-file">
                                <input class="custom-file-input" name="file" id="customFile" type="file" required="">
                                <label class="custom-file-label" for="customFile">Pilih File Excel</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-icon icon-left btn-primary">
                            <i class="fas fa-plus"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>#</th>
                        <th>Nama Distributor</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @php
                        $no = 0;
                    @endphp
                    @forelse ($distributor as $item)
                        <tr>
                            <td>{{ $no += 1 }}</td>
                            <td>{{ $item->nama_distributor }}</td>
                            <td>{{ $item->kota }}</td>
                            <td>{{ $item->provinsi }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ route('distributor.edit', $item->id) }}" class="badge badge-warning">Edit</a>
                                <form action="{{ route('distributor.delete', $item->id) }}" method="POST" style="display: inline;" >
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0);" class="badge badge-danger" onclick="this.closest('form').submit();">Hapus</a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="7" class="text-center">Data Distributor Kosong</td>
                    @endforelse
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
