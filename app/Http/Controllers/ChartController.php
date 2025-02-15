<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index(){
        $userData = User::select(\DB::raw("COUNT(*) as count"))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');
        return view('charts.index', compact('userData'));
    }
}
