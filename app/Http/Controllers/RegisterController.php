<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // So that you can make MySQL statements
use Illuminate\Support\Facades\Hash;

use App\User as User;
/**
 * Description of LoginController
 *
 * @author DavinDeol
 */
class RegisterController extends Controller {
    
    /**
     * 
     * @return login view
     */
    public function register()
    {
        return view('register');
    }
    
    /**
     * This method takes the user's entered email and passwords and tests to see
     * if they're valid. If they are then it returns the name of the user,
     * otherwise it'll return false.
     * 
     * @param request -Stores the form data
     * @returns whether or not the user was valid
     */
    public function submitRegister(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|filled|email|max:127|unique:Users,email',
                'username' => 'required|filled|min:6|max:63',
                'password' => 'required|filled|min:6|max:20',
                'conFirmpassword' => 'required|filled|min:6|max:20|same:password',
                'firstName' => 'required|filled|min:1|max:63|alpha',
                'lastName' => 'present'
            ]
        );
        if (!$validator->fails()) {
            $email = $request->input("email");
            $username = $request->input("username");
            $password = Hash::make($request->input("password"));
            $firstName = $request->input("firstName");
            $lastName = $request->input("lastName");
            DB::insert("INSERT INTO Users (email, username, password, firstName, lastName) VALUES ('$email', '$username', '$password', '$firstName', '$lastName')");
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->route('home');
            }
        } else {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
    }
}
