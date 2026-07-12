<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiUsage;
use Illuminate\Http\Request;

class AiUsageController extends Controller
{
    public function index()
    {
        $usages = AiUsage::with('user')->latest()->paginate(20);
        return view('admin.ai_usages.index', compact('usages'));
    }
}
