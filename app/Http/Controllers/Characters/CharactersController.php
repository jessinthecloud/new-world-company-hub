<?php

namespace App\Http\Controllers\Characters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\CharacterClass;
use App\Models\Characters\SkillType;
use App\Models\Companies\Company;
use App\Models\Companies\Rank;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function dump;
use function redirect;
use function route;
use function view;

class CharactersController extends Controller
{
    public function index()
    {
        $characters = Character::with('class.type')
            ->orderBy('name')
            ->orderBy('level')
            ->get()->mapWithKeys(function($character){
                return [$character->slug => $character->name 
                    .' (Level '.$character->level.') ' 
                    . $character->class->name.' ' 
                    . $character->class->type->name
                ];
        })->all();
        
        dump($characters);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $action
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function choose(Request $request, string $action = 'Submit') : View
    {
        $characters = Character::orderBy('name')
            ->orderBy('level')->get()
            ->mapWithKeys(function($character){
                return [
                    $character->slug => $character->name 
                        . (!empty($character->level)) 
                            ? ' (Level '.$character->level.')' 
                            : ''
                ];
        })->all();
        
        $form_action = route('characters.find');
        
        return view(
            'dashboard.character.choose', 
            compact(
                'characters', 
                'form_action', 
                'action'
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function find(Request $request)
    {
        return redirect(route('characters.'.$request->action, [
            'character'=>$request->character
        ]));
    }

    /**
     * Show Character create form
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->id => $rank->name];
        })->all();

        $classes = CharacterClass::with('type')->get()
            ->mapWithKeys(function($class){
            return [$class->id => $class->name.' ('.$class->type->name.')'];
        })->all();

        $companies = Company::with('faction')->get()
            ->mapWithKeys(function($company){
            return [
                $company->slug => $company->name . ' ('.$company->faction->name.')'
            ];
        })->all();

        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
        
    
        $form_action = route('characters.store');
        $button_text = 'Add';
    
        return view(
            'dashboard.character.create-edit', 
            compact('ranks', 'skillTypes', 'classes', 
                'companies', 'form_action', 'button_text')
        );
    }

    public function store( CharacterUpsertRequest $request )
    {
        $validated = $request->validated();
//dump($validated, $character, $character->skills->pluck('pivot')->pluck('level')/*, $request*/);
        $character = Character::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
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
        dump($character);
    }

    /**
     * Character edit form 
     * 
     * @param \App\Models\Characters\Character $character
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Character $character )
    {
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->id => $rank->name];
        })->all();

        $classes = CharacterClass::distinct()->get()->mapWithKeys(function($class){
            return [$class->id => $class->name.' ('.$class->type->name.')'];
        })->all();

        $companies = Company::with('faction')->get()
            ->mapWithKeys(function($company){
            return [$company->slug => $company->name.' ('.$company->faction->name.')'];
        })->all();

        $character = $character->load('skills', 'rank', 'company', 'class', 'user');
        
        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
        
        $rank_options = '<option value="'.null.'"></option>';
        foreach($ranks as $value => $text) {
            $rank_options .= '<option value="'.$value.'"';
                if($character->rank?->id === $value){
                    $rank_options .= ' SELECTED ';
                }
            $rank_options .= '>'.$text.'</option>';
        }

        $class_options = '';
        foreach($classes as $value => $text) {
            $class_options .= '<option value="'.$value.'"';
            if($character->class->id === $value){
                $class_options .= ' SELECTED ';
            }
            $class_options .= '>'.$text.'</option>';
        }

        $company_options = '';
        foreach($companies as $value => $text) {
            $company_options .= '<option value="'.$value.'"';
            if($character->company->slug === $value){
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
        $character->slug = isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
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
//dd($character);    
        Character::destroy($character->id);
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character deleted successfully'
            ]
        ]);
    }
}