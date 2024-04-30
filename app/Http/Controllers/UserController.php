<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email|unique:users',
            'pronoun' => 'required|string',
            'instagram_handle' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as per your requirement
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $profileImage = null;

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')->store('public/profile_images');
            $profileImage = str_replace('public/', '/storage/', $profileImage); // Adjust path as needed
        }

        if($request->instagram_handle && !$this->validateInstagramUrl($request->instagram_handle)){
            return response()->json(['error' => 'Invalid Instagram URL'], 400);
        }

        $userData = $request->except('profile_image');
        $userData['profile_image'] = $profileImage;
        $user = User::create($userData);

        return response()->json(['user' => $user], 201);
    }

    public function validateInstagramUrl($url)
    {
        // Regular expression pattern to match Instagram URL
        $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:instagram\.com\/)([\w\.\-]+)\/?$/';

        // Check if the URL matches the pattern
        if (preg_match($pattern, $url, $matches)) {
            // Instagram URL is in valid format, now check if it's accessible and valid
            $response = Http::get("https://www.instagram.com/{$matches[1]}/?__a=1");

            // Check if the request was successful and if the response contains the error message
            if ($response->successful()) {
                $content = $response->body();
                if (strpos($content, 'This content is no longer available') !== false) {
                    // Profile does not exist or is not accessible
                    return false;
                } else {
                    // Profile exists
                    return true;
                }
            } else {
                // Error occurred while fetching profile data
                return false;
            }
        } else {
            // Instagram URL is not in the correct format
            return false;
        }
    }
}
