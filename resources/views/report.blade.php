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
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 15px">
                    <div class="card">    
                        <div class="card-header">{{ __('Diagram Barang') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="myChart" height="100" width="100"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="myChart2" height="100" width="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ __('Laporan Keluar Masuk Barang') }}
                                </div>
                                <div class="col-md-6" style="text-align: right">
                                    <a href="/report/export">Download Excel</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Penerima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_histories as $k => $v)
                                        <tr>
                                            <th scope="row">{{ $v->created_at }}</th>
                                            <td>{{ $v->code }}</td>
                                            <td>{{ $v->name }}</td>
                                            <td>{{ $v->amount }}</td>
                                            <td>{{ $v->section_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var goods_label =  {{ Js::from($goods_label) }};
    var goods_data =  {{ Js::from($goods_data) }};
    var percentageData = [];

    for (const data of goods_data) {
        var countAll = goods_data.reduce((a, b) => a + b);
        percentageData.push((Number(data) / Number(countAll)) * 100);
    }

    new Chart(
        document.getElementById('myChart'),
        {
            type: 'pie',
            data: {
                labels: goods_label,
                datasets: [{
                    label: 'Diagram Barang',
                    data: percentageData,
                }]
            },
            options: {}
        }
    );

    var sections = {{ Js::from($sections_data) }};
    var sections_label = [];
    var sections_data = [];

    for (const section of sections) {
        sections_label.push(section.name);
        sections_data.push(section.amount);
    }

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        {
            type: 'bar',
            data: {
                labels: sections_label,
                datasets: [{
                    label: 'Diagram Bagian',
                    data: sections_data,
                }]
            },
            options: {}
        }
    );
</script>
@endsection