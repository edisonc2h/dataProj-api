<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()
            ->json([
                'data' => $users,
            ]);
    }

    public function get(Request $request)
    {
        $user = User::where('id', $request['id'])->firstOrFail();
        if ($user) {
            if (isset($user['profile_id'])) {
                $profile = Profile::where('id', $user['profile_id'])->firstOrFail();
                if ($profile) {
                    $user['profile'] = $profile;
                }
            }
            return response()
                ->json($user);
        }
        return response()->json(['message' => 'Usuario no existe'], 500);
    }

    public function save (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:20',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'documentNumber' => 'required|string|max:255',
            'status' => ['required', Rule::in(['Activo', 'Inactivo']),],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'financialInstitution' => 'required',
            'portalDownload' => 'required',
            'consultingJudicialOrders' => 'required',
            'profile_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 500);
        }

        $user = User::create([
            'username' => $request->username ?? '',
            'name' => $request->name ?? '',
            'lastname' => $request->lastname ?? '',
            'documentNumber' => $request->documentNumber ?? '',
            'status' => $request->status ?? '',
            'email' => $request->email ?? '',
            'password' => Hash::make($request->password ?? ''),
            'financialInstitution' => $request->financialInstitution ?? '',
            'portalDownload' => $request->portalDownload ?? '',
            'consultingJudicialOrders' => $request->consultingJudicialOrders ?? '',
            'profile_id' => $request->profile_id ?? '',
        ]);
        return response()
            ->json(['data' => $user], 200);
    }

    public function update ($id, Request $request)
    {
        $newData = $request->all();
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->update($newData);
            return $user;
        }
        return response()->json(['message' => 'Usuario no existe'], 500);
    }

    public function changeUserPassword ($id, Request $request)
    {
        if ($request->isMethod('patch')) {

            $validator = Validator::make($request->all(),[
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $userData = $request->all();
            $user = User::where('id', $id)->first();
            if ($user) {
                $user->password = $userData['password'];
                $user->save();
                return $user;
            }
            return response()->json(['message' => 'Usuario no existe'], 500);
        }
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            User::destroy($id);
            return $id;
        }
        return response()->json(['message' => 'Usuario no existe'], 500);
    }
}
