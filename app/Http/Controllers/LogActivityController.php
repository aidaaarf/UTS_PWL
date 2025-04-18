<?php

namespace App\Http\Controllers;

use App\Models\LogActivityModel;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logActivities = LogActivityModel::with('user')->get(); // Mengambil data log activity beserta informasi user
        return view('log_activity.index', compact('logActivities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|in:login,logout'
        ]);
        LogActivityModel::create([
            'user_id' => $request->user_id,
            'action' => $request->action
        ]);

        return redirect()->route('logactivity.index')->with('success', 'Activity logged successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $logActivity = LogActivityModel::findOrFail($id);
        $logActivity->delete();

        return redirect()->route('logactivity.index')->with('success', 'Log activity deleted successfully!');
    }
}
