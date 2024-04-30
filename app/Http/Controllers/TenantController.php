<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:tenants',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $tenant = Tenant::create([
            'name' => $request->name,
            'admin_user_id' => Auth::id(),
        ]);

        return response()->json(['tenant' => $tenant], 201);
    }
}
