<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profiles()
    {
        $data = Profile::all();
        return response()
            ->json([
                'data' => $data,
            ]);
    }

    public function get(Request $request)
    {
        $user = Profile::where('id', $request['id'])->firstOrFail();
        if ($user) {
            $user->menu = json_decode($user->menu, true);
            return response()
                ->json($user);
        }
        return response()->json(['message' => 'Perfil no existe'], 500);
    }

    public function save (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|unique:profiles|max:20',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $user = Profile::create([
            'code' => $request->code ?? '',
            'description' => $request->description ?? '',
            'menu' => $request->menu ? json_encode(array_values($request->menu)) : '[]'
        ]);
        return response()
            ->json(['data' => $user], 200);
    }

    public function update ($id, Request $request)
    {
        $newData = $request->all();
        $profile = Profile::where('id', $id)->first();
        if ($profile) {
            $newData['menu'] = array_values($newData['menu']);
            $profile->update($newData);
            return $profile;
        }
        return response()->json(['message' => 'Perfil no existe'], 500);
    }

    public function delete($id)
    {
        $profile = Profile::where('id', $id)->first();
        if ($profile) {
            Profile::destroy($id);
            return $id;
        }
        return response()->json(['message' => 'Perfil no existe'], 500);
    }
}
