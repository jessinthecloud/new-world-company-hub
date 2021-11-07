<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Rank;
use App\Models\Skill;
use App\Models\SkillType;
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

        $skills = Skill::distinct()->get()->all();
    
        return view(
            'dashboard.character.create-edit', 
            compact('ranks', 'skills')
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

    /**
     * Character edit form 
     * 
     * @param \App\Models\Character $character
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Character $character )
    {
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->name => $rank->id];
        })->all();

        $classes = CharacterClass::distinct()->get()->mapWithKeys(function($class){
            return [$class->name => $class->id];
        })->all();

        $character = $character->load('skills', 'rank', 'company', 'class', 'user');
        
        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
        
        $rank_options = '';
        foreach($ranks as $text => $value) {
            $rank_options .= '<option value="'.$value.'"';
                if($character->rank->id === $value){
                    $rank_options .= ' SELECTED ';
                }
            $rank_options .= '>'.$text.'</option>';
        }

        $class_options = '';
        foreach($classes as $text => $value) {
            $class_options .= '<option value="'.$value.'"';
            if($character->class->id === $value){
                $class_options .= ' SELECTED ';
            }
            $class_options .= '>'.$text.'</option>';
        }
        
        return view(
            'dashboard.character.create-edit', 
            [
                'character' => $character,
                'skillTypes' => $skillTypes,
                'rank_options' => $rank_options,
                'class_options' => $class_options,
                'method' => 'PUT',
                'form_action' => route('characters.update', ['character'=>$character]) 
            ]
        );
    }

    public function update( Request $request, Character $character )
    {
    
    }

    public function destroy( Character $character )
    {
        //
    }
}