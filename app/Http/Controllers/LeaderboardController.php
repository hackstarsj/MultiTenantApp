<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XPoints;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;

class LeaderboardController extends Controller
{
    public function show($tenant_id)
    {

        $name=Tenant::find($tenant_id);
        if(!$name){
            return view('leaderboard', ['leaderboard' => [],'name'=>'Not Found']);
        }

        $leaderboard = XPoints::join('users', 'users.id', '=', 'xp_records.user_id')
            ->select('users.*', 'user_id', DB::raw('SUM(xp_amount) as total_xp'))
            ->where('xp_records.tenant_id', $tenant_id)
            ->groupBy('user_id')
            ->orderByDesc('total_xp')
            ->limit(10)
            ->get();

        return view('leaderboard', ['leaderboard' => $leaderboard,'name'=>$name->name]);
    }
}
