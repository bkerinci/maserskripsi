<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IpMonitorController extends Controller
{
    public function index()
    {
        // Get IPs that have multiple accounts
        $suspiciousIps = User::select('last_login_ip', DB::raw('count(*) as total_accounts'))
            ->whereNotNull('last_login_ip')
            ->where('last_login_ip', '!=', '127.0.0.1')
            ->where('last_login_ip', '!=', '::1')
            ->groupBy('last_login_ip')
            ->having('total_accounts', '>=', 2)
            ->orderBy('total_accounts', 'desc')
            ->paginate(20);

        // Fetch user details for those IPs
        $ipList = $suspiciousIps->pluck('last_login_ip')->toArray();
        $usersByIp = User::whereIn('last_login_ip', $ipList)
            ->get()
            ->groupBy('last_login_ip');

        return view('admin.ip_monitor.index', compact('suspiciousIps', 'usersByIp'));
    }
}
