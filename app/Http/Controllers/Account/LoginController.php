<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

}