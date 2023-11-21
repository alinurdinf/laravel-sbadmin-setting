<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        return view('home', compact('widget'));
    }

    public function generateQr()
    {
        $str = 'Hello, world!';
        $qrcode = QrCode::size(200)->generate($str);
        return view('testqr/generateqr', compact('qrcode'));
    }

    public function scanQr()
    {
        $str = 'Hello, world!';
        $qrcode = QrCode::size(200)->generate($str);
        return view('testqr/scanqr', compact('qrcode'));
    }
}
