<?php

namespace App\Http\Controllers;

use App\Models\ModelTableB;
use App\Models\ModelTableD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $total_transaksi = ModelTableB::sum('nominal_transaksi');
        $total_sales = ModelTableD::count('nama_sales');
        $nomor_1 = DB::select("
            SELECT 
                COALESCE(a2.kode_toko_baru, a1.kode_toko_baru, p.kode_toko) AS kode_toko_baru,
                SUM(p.nominal_transaksi) AS nominal_transaksi
            FROM table_b p
            LEFT JOIN table_a a1 ON p.kode_toko = a1.kode_toko_lama
            LEFT JOIN table_a a2 ON a1.kode_toko_baru = a2.kode_toko_lama
            GROUP BY kode_toko_baru
            ORDER BY kode_toko_baru
        ");
        
        $nomor_2 = DB::select("
            SELECT DISTINCT
                COALESCE(a1.kode_toko_baru, p.kode_toko) AS kode_toko_baru
            FROM table_b p
            LEFT JOIN table_a a1 ON p.kode_toko = a1.kode_toko_lama
            ORDER BY kode_toko_baru
        ");

        $nomor_3 = DB::select("
            SELECT 
                kode_toko_baru,
                SUM(nominal_transaksi) AS total_transaksi
            FROM (
                SELECT 
                    COALESCE(a1.kode_toko_baru, p.kode_toko) AS kode_toko_baru,
                    p.nominal_transaksi
                FROM table_b p
                LEFT JOIN table_a a1 ON p.kode_toko = a1.kode_toko_lama
            ) AS transaksi_mapping
            GROUP BY kode_toko_baru
            ORDER BY total_transaksi DESC
            LIMIT 1
        ");

        $nomor_4 = DB::select("
            SELECT 
                c.kode_toko,
                d.nama_sales
            FROM table_c c
            JOIN (
                SELECT 
                    LEFT(kode_sales, 1) AS area_sales,
                    nama_sales
                FROM table_d
                WHERE kode_sales IN (
                    SELECT MAX(kode_sales)
                    FROM table_d
                    GROUP BY LEFT(kode_sales, 1)
                )
            ) d ON c.area_sales = d.area_sales
            ORDER BY c.kode_toko
        ");

        $nomor_5 = DB::select("
            SELECT 
                d.nama_sales AS Kode_Baru,
                SUM(b.nominal_transaksi) AS Nominal_Transaksi
            FROM table_b b
            LEFT JOIN table_a a ON b.kode_toko = a.kode_toko_lama
            LEFT JOIN table_c c ON c.kode_toko = COALESCE(a.kode_toko_baru, b.kode_toko)
            JOIN (
                SELECT 
                    LEFT(kode_sales, 1) AS area_sales,
                    nama_sales
                FROM table_d
                WHERE kode_sales IN (
                    SELECT MAX(kode_sales)
                    FROM table_d
                    GROUP BY LEFT(kode_sales, 1)
                )
            ) d ON d.area_sales = c.area_sales
            GROUP BY d.nama_sales
        ");

        return view('pages.dashboard', compact('total_transaksi', 'total_sales', 'nomor_1', 'nomor_2', 'nomor_3', 'nomor_4', 'nomor_5'));
    }

    public function landingpage(){
        return view('pages.landing-page');
    }
}
