<?php

namespace App\Http\Controllers;

use App\Models\AuditEvent;

class AuditController extends Controller
{
    public function index()
    {
        $events = AuditEvent::latest('id')->paginate(20);

        return view('audit.index', compact('events'));
    }
}
