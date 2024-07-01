<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
        {
            $user = User::find(Auth::user()->id);
            return view('account.profile', ['user'=>$user]);
        }
}
