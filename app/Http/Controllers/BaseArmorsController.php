<?php

namespace App\Http\Controllers;

use App\Models\BaseArmor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseArmorsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store( Request $request )
    {
        //
    }

    public function show( BaseArmor $armor )
    {
        return $armor->load('perks')->toJson();
    }

    public function edit( BaseArmor $armor )
    {
        //
    }

    public function update( Request $request, BaseArmor $armor )
    {
        //
    }

    public function destroy( BaseArmor $armor )
    {
        //
    }
}