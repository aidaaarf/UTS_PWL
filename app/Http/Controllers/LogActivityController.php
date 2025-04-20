<?php 
namespace App\Http\Controllers;

use App\Models\LogActivityModel;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
 
    public function index()
    {
        $logActivities = LogActivityModel::with('user')
        ->latest() // Urutkan berdasarkan created_at DESC
        ->take(20)  
        ->get();
      
        return view('log_activity.index', [
            'logActivities' => $logActivities,
            'activeMenu' => 'log_activity' 
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:login,logout'
        ]);

        // Simpan activity ke database
        LogActivityModel::create([
            'user_id' => $request->user_id,
            'action' => $request->action
        ]);

        // Kembalikan dengan pesan sukses
        return redirect()->route('log_activity.index')->with('success', 'Activity logged successfully!');
    }
}
