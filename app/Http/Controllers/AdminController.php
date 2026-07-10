<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Prompt;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        // Count unique users who have a successful transaction as active subscriptions
        $activeSubscriptions = Transaction::where('status', 'success')->distinct('user_id')->count('user_id');
        $totalPrompts = Prompt::count();

        return view('admin.dashboard', compact('totalUsers', 'activeSubscriptions', 'totalPrompts'));
    }
}
