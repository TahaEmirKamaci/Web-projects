<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Record;
use App\Http\Controllers\RecordController;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function kullan()
    {

        return view('dashboard');
    }

    public function Lara(Request $request)

    {

        $user = Auth::user();

        $records = Record::all();

        $page = $request->input('page', 1);
        $records = Record::whereNull('Date_exit')->get();
        $all_records = Record::orderBy('Date', 'desc')->paginate(10); // Her sayfada 5 kayıt göster
        $user = Auth::user();

        return view('dashboard', [
            'user' => $user,
            'page' => $page,
            'records' => $records,
            'all_records' => $all_records,
            'total_pages' => $all_records->lastPage(),

        ]);
    }

    public function showDashboard()
{


        $user = Auth::user();

        // Kullanıcı bilgilerini Blade şablonuna geçir
        return view('dashboard', [
            'user' => $user
        ]);

}
}
