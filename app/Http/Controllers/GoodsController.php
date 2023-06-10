<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Section;
use App\Models\GoodType;
use App\Models\StockHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;

// Test GIT code 

class GoodsExport implements FromArray
{
    public function array(): array
    {
        return DB::select('
            SELECT
                g.code AS kode_barang,
                g.name AS nama_barang,
                s.section_name AS bagian,
                sh.amount AS jumlah,
                sh.created_at AS tanggal
            FROM stock_histories sh
            JOIN goods g ON sh.good_id = g.id
            JOIN sections s ON sh.section_id = s.id
            WHERE sh.stock_type = "out"
            ORDER BY sh.id DESC
        ');
    }
}

class GoodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $data)
    {
        $sections = Section::all();
        $good_types = GoodType::all();

        $goods_query = '
            SELECT
                g.*,
                gt.type_name
            FROM goods g
            JOIN good_types gt ON g.good_type_id = gt.id
        ';

        if ($data->code) {
            $goods_query = $goods_query . " WHERE code = '" . $data['code'] . "'";
        }

        $goods = DB::select($goods_query . " ORDER BY id DESC");

        return view('goods', [
            'goods'=>$goods,
            'sections'=>$sections,
            'good_types'=>$good_types,
            'search'=>$data['code']
        ]);
    }

    public function add(Request $data): RedirectResponse
    {
        // error_log($data);

        Good::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'good_type_id' => $data['good_type_id'],
            'stock' => 0
        ]);

        return redirect('/goods');
    }

    public function search(Request $data): RedirectResponse
    {
        return redirect("/goods?code={$data['code']}");
    }

    public function in_out(Request $data, $id): RedirectResponse
    {
        $good = Good::find($id);
        $history = [
            'good_id' => $id,
            'section_id' => null,
            'stock_type' => $data['type'],
            'amount' => $data['stock']
        ];

        if ($data->type == 'in') {
            $good->update(['stock' => $good['stock'] + $data['stock']], ['touch' => false]);
        } else {
            $history['section_id'] = $data['section_id'];
            $good->update(['stock' => $good['stock'] - $data['stock']], ['touch' => false]);
        }

        error_log($history['section_id']);

        StockHistory::create($history);

        return redirect('/goods');
    }

    public function report()
    {
        $stock_history_query = '
            SELECT
                sh.*,
                g.code,
                g.name,
                s.section_name
            FROM stock_histories sh
            JOIN goods g ON sh.good_id = g.id
            JOIN sections s ON sh.section_id = s.id
            ORDER BY sh.id DESC
        ';

        $stock_histories = DB::select($stock_history_query);

        $goods_percentage = Good::select('name', 'stock')->pluck('name', 'stock');
        $goods_data = $goods_percentage->keys();
        $goods_label = $goods_percentage->values();

        $sections_data = DB::select('
            SELECT
                SUM(sh.amount) AS amount,
                s.section_name AS name
            FROM stock_histories sh
            JOIN sections s ON sh.section_id = s.id
            WHERE sh.stock_type = "out"
            GROUP BY s.section_name
        ');

        return view('report',  [
            'stock_histories'=>$stock_histories,
            'goods_data'=>$goods_data,
            'goods_label'=>$goods_label,
            'sections_data'=>$sections_data
        ]);
    }

    public function export() 
    {
        return Excel::download(new GoodsExport, 'Laporan Barang Keluar.xlsx');
    }
}
