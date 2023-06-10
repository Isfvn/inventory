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
            </div class="list-menu">
                <a href="/report">
                    </button>
                    

                    
                </a>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
