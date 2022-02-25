<?php

namespace App\Http\Controllers\WarBoards;

use App\Http\Controllers\Controller;
use App\Models\Events\WarBoard;
use Illuminate\Http\Request;

class WarBoardsController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $chars = \App\Models\Characters\Character::where('company_id', $request->user()->company()->id)
            ->orderBy('name')
            ->get()
            ->sortBy('class.name');
     
        return view('dashboard.event.war-board.create-edit',
            ['chars'=>$chars]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(WarBoard $warBoard)
    {
        //
    }

    public function edit(WarBoard $warBoard)
    {
        //
    }

    public function update(Request $request, WarBoard $warBoard)
    {
        //
    }

    public function destroy(WarBoard $warBoard)
    {
        //
    }
}