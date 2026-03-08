<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class DeleteAccountController extends Controller
{

    public function delete(Request $request)
{
$user = $request->user();

$user->tokens()->delete();

$user->delete();

return response()->json([
"message"=>"Account deleted"
]);
}
}
