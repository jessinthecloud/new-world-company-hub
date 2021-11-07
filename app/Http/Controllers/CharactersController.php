<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Rank;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public function index()
    {
        $characters = Character::orderBy('name')->orderBy('level')->get()->mapWithKeys(function($character){
            return [$character->name.' ( Level '.$character->level.')' => $character->id];
        })->all();
        $form_action = route('characters.find');
        
        return view(
            'dashboard.character.index', 
            compact('characters', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(route('characters.'.$request->action, ['character'=>$request->character]));
    }

    /**
     * Show Character create form
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->name => $rank->id];
        })->all();

        /*$skills = Skill::distinct()->get()->mapWithKeys(function($skill, $key){
            return [$skill->name => $skill->id];
        })->all();*/
    
        return view(
            'dashboard.character.create-edit', 
            compact('ranks')
        );
    }

    public function store( Request $request )
    {
        //
    }

    public function show( Character $character )
    {
        //
    }

    public function edit( Character $character )
    {
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->name => $rank->id];
        })->all();
        
        $options = '';
        foreach($ranks as $text => $value) {
            $options .= '<option value="'.$value.'"';
                if($character->rank->id === $value){
                    $options .= ' SELECTED ';
                }
            $options .= '>'.$text.'</option>';
        }
        
        return view(
            'dashboard.character.create-edit', 
            [
                'character' => $character, 
                'options' => $options,
                'method' => 'PUT',
                'form_action' => route('characters.update', ['character'=>$character]) 
            ]
        );
    }

    public function update( Request $request, Character $character )
    {
        //
    }

    public function destroy( Character $character )
    {
        //
    }
}