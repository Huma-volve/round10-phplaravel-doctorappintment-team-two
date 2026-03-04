<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    use TraitReview;


    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        return $this->apiresponse($users, 'Users fetched successfully', 200);
    }


    public function store(Request $request)
    {
        try {

            $validate = $request->validate(User::rules());




            $validate['password'] = Hash::make($validate['password']);


            $user = User::create($validate);


            return $this->apiresponse($user, 'User created successfully', 201);
        } catch (ValidationException $e) {
            return $this->apiresponse($e->errors(), 'Validation failed', 422);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->apiresponse(null, 'User not found', 404);
        }

        return $this->apiresponse($user, 'User fetched successfully', 200);
    }


    public function update(Request $request, $id)
    {
        $User = User::find($id);

        if (!$User) {
            return $this->apiresponse(null, 'not found', 401);
        }

        try {
            $validated = $request->validate(User::rules());



            $User->update($validated);
            return $this->apiResponse($User, 'user updated successfully', 201);
        } catch (ValidationException $e) {


            return $this->apiResponse($e->errors(), 'Validation failed', 400);
        }
    }

    /**
     * حذف مستخدم محدد
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->apiresponse(null, 'User not found', 404);
        }

        $user->delete();

        return $this->apiresponse(null, 'User deleted successfully', 200);
    }
}
