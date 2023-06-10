@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3 left-menu">
            <div class="list-menu">
                <a href="/home">
                    <button type="button" class="btn btn-primary">Dashboard</button>
                </a>
            </div>
            <div class="list-menu">
                <a href="/goods">
                    <button type="button" class="btn btn-primary">Barang</button>
                </a>
            </div>
            <div class="list-menu">
                <a href="/report">
                    <button type="button" class="btn btn-primary">Laporan</button>
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Master Barang') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addGoods">
                                Tambah Barang
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <form method="POST" action="{{ route('search_goods') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Cari kode barang" name="code", id="code" value="{{ $search }}">
                                    <button class="btn btn-outline-info" type="submit">Cari Barang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr />
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"># Kode</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jenis barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goods as $k => $v)
                                <tr>
                                    <th scope="row">{{ $v->code }}</th>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->type_name }}</td>
                                    <td>{{ $v->stock }}</td>
                                    <td>
                                        <form method="POST" action="{{ url('/goods/in_out/' . $v->id) }}">
                                            @csrf

                                            <table class="tbl-goods-in-out">
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="type" type="radio" name="flexRadioDefault" id="in_goods" value="in" checked>
                                                            <label class="form-check-label" for="in_goods">
                                                                Barang Masuk
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="type" type="radio" name="flexRadioDefault" id="out_goods" value="out">
                                                            <label class="form-check-label" for="out_goods">
                                                                Barang Keluar
                                                            </label>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text" for="form-check form-check-inline">Seksi</label>
                                                            <select class="form-check-label" id="section_id" name="section_id">
                                                                <option selected>Pilih Seksi</option>
                                                                @foreach ($sections as $l => $m)
                                                                    <option value="{{ $m->id }}">Seksi {{ $m->section_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" name="stock" class="form-control form-control-sm" placeholder="Total">
                                                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addGoods" tabindex="-1" aria-labelledby="addGoodsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('add_goods') }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="addGoodsLabel">Tambah Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="code" class="col-sm-3 col-form-label">Kode Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Masukan kode barang">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">Nama Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama barang">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">Jenis Barang</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="good_type_id" name="good_type_id">
                                        <option selected>Pilih Jenis</option>
                                        @foreach ($good_types as $l => $m)
                                            <option value="{{ $m->id }}">{{ $m->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div> 
            </div>      
        </div>
    </div>
</div>
@endsection
