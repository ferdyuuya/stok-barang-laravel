<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokLog;
use App\Models\StokLogs;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $totalBarang;
    public $totalUser;
    public $recentUpdates;

    public function index()
    {
        $this->totalBarang = Barang::count();
        $this->recentUpdates = StokLog::latest()->take(2)->get();
        $this->totalUser = User::count();
        
        return view('dashboard.index')->with([
            'totalBarang' => $this->totalBarang,
            'totalUser' => $this->totalUser,
            'recentUpdates' => $this->recentUpdates,
        ]);
    }

    // public function __invoke()
    // {
    //     $this->totalBarang = Barang::count();
    //     $this->recentUpdates = StokLog::latest()->take(2)->get();
        
    //     return view('dashboard')->with([
    //         'totalBarang' => $this->totalBarang,
    //         'recentUpdates' => $this->recentUpdates,
    //     ]);
    // }


}
