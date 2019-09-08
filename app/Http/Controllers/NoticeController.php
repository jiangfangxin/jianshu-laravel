<?php

namespace App\Http\Controllers;

use App\Notice;

class NoticeController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $notices = $user->notices;
        return view('notice.index', compact('notices'));
    }
}
