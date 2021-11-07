<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterUpsertRequest;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Company;
use App\Models\Rank;
use App\Models\Skill;
use App\Models\SkillType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public function index()
    {
    }

    public function choose()
    {
        $characters = Character::orderBy('name')->orderBy('level')->get()->mapWithKeys(function($character){
            return [$character->name.' ( Level '.$character->level.')' => $character->id];
        })->all();
        $form_action = route('characters.find');
        
        return view(
            'dashboard.character.choose', 
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

        $classes = CharacterClass::with('type')->get()->mapWithKeys(function($class){
            return [$class->name.' ('.$class->type->name.')' => $class->id];
        })->all();

        $companies = Company::with('faction')->get()->mapWithKeys(function($company){
            return [$company->name.' ('.$company->faction->name.')' => $company->id];
        })->all();

        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
        
    
        $form_action = route('characters.store');
        $button_text = 'Create';
    
        return view(
            'dashboard.character.create-edit', 
            compact('ranks', 'skillTypes', 'classes', 'companies', 'form_action', 'button_text')
        );
    }

    public function store( CharacterUpsertRequest $request )
    {
        $validated = $request->validated();
//dump($validated, $character, $character->skills->pluck('pivot')->pluck('level')/*, $request*/);
        $character = Character::create([
            'name' => $validated['name'],
            'level' => $validated['level'],
            // relations
            'character_class_id' => $validated['class'],
            'rank_id' => $validated['rank'],
            'company_id' => $validated['company'],
        ]);
        // update skills levels related to this character on pivot table
        foreach($validated['skills'] as $skill_id => $level){
            // don't need to ->save()
            $character->skills()->attach($skill_id, ['level'=>$level ?? 0]);
        }

//        dump($character, $character->skills->pluck('pivot')->pluck('level'));
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character created successfully'
            ]
        ]);
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
            return [$class->name.' ('.$class->type->name.')' => $class->id];
        })->all();

        $companies = Company::with('faction')->get()->mapWithKeys(function($company){
            return [$company->name.' ('.$company->faction->name.')' => $company->id];
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

        $company_options = '';
        foreach($companies as $text => $value) {
            $company_options .= '<option value="'.$value.'"';
            if($character->company->id === $value){
                $company_options .= ' SELECTED ';
            }
            $company_options .= '>'.$text.'</option>';
        }
        
        return view(
            'dashboard.character.create-edit', 
            [
                'character' => $character,
                'skillTypes' => $skillTypes,
                'rank_options' => $rank_options,
                'class_options' => $class_options,
                'company_options' => $company_options,
                'method' => 'PUT',
                'form_action' => route('characters.update', ['character'=>$character]), 
                'button_text' => 'Edit',
            ]
        );
    }

    public function update( CharacterUpsertRequest $request, Character $character )
    {
        $validated = $request->validated();
//dump($validated, $character, $character->skills->pluck('pivot')->pluck('level')/*, $request*/);
        $character->name = $validated['name'];
        $character->level = $validated['level'];
        // relations
        $character->rank()->associate($validated['rank']);
        $character->class()->associate($validated['class']);
        $character->company()->associate($validated['company']);
        $character->save();
        // update skills levels related to this character on pivot table
        foreach($validated['skills'] as $skill => $level){
            // don't need to save
            $character->skills()->updateExistingPivot($skill, ['level'=>$level ?? 0]);
        }
        
//        dump($character, $character->skills->pluck('pivot')->pluck('level'));
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character updated successfully'
            ]
        ]);
    }

    public function destroy( Character $character )
    {
        Character::destroy($character);
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character deleted successfully'
            ]
        ]);
    }
}