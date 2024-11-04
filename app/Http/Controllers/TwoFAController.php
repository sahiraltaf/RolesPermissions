<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

use App\UserCode;
class TwoFAController extends Controller
{
    public function index()
    {
        return view('2fa');
    }
    public function store(Request $request)
    {
        $request->validate(['code'=>'required']);
        $find = UserCode::where('user_id', auth()->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();
        if (!is_null($find)) {

            // Session::put('2fa_completed', true);
            Session::put('2fa_completed', auth()->user()->id);
            return redirect()->route('home');
        }
        return back()->with('error', 'You entered wrong code.');
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function resend()
    {
        auth()->user()->generateCode();
        return back()->with('success', 'We sent you code on your email.');

    }
}
