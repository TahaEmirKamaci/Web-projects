<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Yanlış email veya şifre.']);
        }
    }

    public function logout(Request $request)
    {
        // Çıkış işlemi
        Auth::logout();

        // Session'a başarı mesajı ekle
        $request->session()->flash('success', 'Başarıyla çıkış yapıldı.');

        // Kullanıcıyı welcome rotasına yönlendir
        return redirect()->route('welcome');
    }
}
