<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view( 'dashboard.index', ['form_action' => route( 'dashboard' )] );
    }
}