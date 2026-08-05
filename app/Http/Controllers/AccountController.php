<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $recentOrders = $request->user()->orders()->latest()->take(3)->get();
        $addressCount = $request->user()->addresses()->count();
        $wishlistCount = $request->user()->wishlists()->count();

        return view('account.index', compact('recentOrders', 'addressCount', 'wishlistCount'));
    }
}
