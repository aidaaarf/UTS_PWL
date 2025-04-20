<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $activeMenu = 'dashboard'; // Set aktif menu 'dashboard'
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Pengecekan role apakah admin atau pegawai
        if ($user->role == 'admin') {
            // Ambil jumlah barang dan pegawai (admin view)
            $jumlahBarang = BarangModel::count();
            $jumlahPegawai = UserModel::where('role', 'pegawai')->count();
            $transaksiTerbaru = TransaksiModel::with('barang', 'user')->latest()->limit(5)->get();

            // Query grafik transaksi (jumlah per bulan)
            $grafikTransaksi = TransaksiModel::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw("SUM(CASE WHEN keterangan = 'masuk' THEN jumlah ELSE 0 END) as masuk"),
                DB::raw("SUM(CASE WHEN keterangan = 'keluar' THEN jumlah ELSE 0 END) as keluar")
            )
                ->groupBy('bulan')
                ->orderBy('bulan', 'desc')
                ->limit(6)
                ->get()
                ->reverse(); // Mengurutkan grafik dari bulan paling lama ke baru

            // Ambil stok barang rendah (stok < 10)
            $stokRendah = BarangModel::where('stok', '<', 10)->get();

            return view('dashboard.index', [
                'jumlahBarang' => $jumlahBarang,
                'jumlahPegawai' => $jumlahPegawai,
                'transaksiTerbaru' => $transaksiTerbaru,
                'grafikTransaksi' => $grafikTransaksi,
                'stokRendah' => $stokRendah,
                'activeMenu' => 'dashboard'
            ]);
        }

        // Jika role adalah pegawai
        elseif ($user->role == 'pegawai') {
            // Ambil transaksi yang dilakukan oleh pegawai, diurutkan dari yang terbaru
            $transaksiPegawai = TransaksiModel::where('user_id', $user->id)
                ->latest() // Mengurutkan berdasarkan created_at secara menurun
                ->limit(5) // Menampilkan 5 transaksi terbaru
                ->get();

            // Ambil stok barang yang rendah (stok <= 10)
            $stokRendah = BarangModel::where('stok', '<=', 10)->get(); // Stok rendah = 10

            return view('dashboard.pegawai', [
                'transaksiPegawai' => $transaksiPegawai,
                'stokRendah' => $stokRendah,
                'activeMenu' => 'dashboard'
            ]);
        }

        // Jika role tidak sesuai, logout atau tampilkan error
        return redirect('/login')->withErrors(['message' => 'Role tidak dikenali']);
    }
}
