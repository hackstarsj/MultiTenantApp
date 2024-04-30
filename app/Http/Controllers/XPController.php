<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XPoints;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class XPController extends Controller
{
    public function award(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'xp_amount' => 'required|integer',
            'tenant_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if($request->xp_amount < 0){
            return response()->json(['error' => 'XP amount cannot be negative'], 422);
        }
        if($request->xp_amount == 0){
            return response()->json(['error' => 'XP amount cannot be zero'], 422);
        }
        if($request->user_id == 0){
            return response()->json(['error' => 'User ID cannot be zero'], 422);
        }
        $user= User::find($request->user_id);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $xpRecord = XPoints::create($request->all());

        return response()->json(['xp_record' => $xpRecord], 201);
    }
}
