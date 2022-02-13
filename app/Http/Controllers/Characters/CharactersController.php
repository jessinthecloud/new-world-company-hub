<?php

namespace App\Http\Controllers\Characters;

use App\Enums\WeaponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\CharacterClass;
use App\Models\Characters\SkillType;
use App\Models\Companies\Company;
use App\Models\Companies\Rank;
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
        $characters = Character::asArrayForDropDown();
        
        dump($characters);
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param string                   $action
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function choose(Request $request, string $action = 'Submit') : View
    {
        $characters = Character::asArrayForDropDown();
        
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
     * Pass-through for sending specific model directly
     * to edit/show/delete route
     *
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
        $ranks = Rank::asArrayForDropDown();

        $classes = CharacterClass::asArrayForDropDown();

        $companies = Company::asArrayForDropDown();

        $skillTypes = SkillType::asArrayForDropDown();
    
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

        $character = Character::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'level' => $validated['level'],
            // relations
            'character_class_id' => $validated['class'],
        ]);
        
        // update skills levels related to this character on pivot table
        foreach($validated['skills'] as $skill_id => $level){
            // don't need to ->save()
            $character->skills()->attach($skill_id, ['level'=>$level ?? 0]);
        }
        
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
        $ranks = Rank::asArrayForDropDown();

        $classes = CharacterClass::asArrayForDropDown();

        $companies = Company::asArrayForDropDown();

        $character = $character->load('skills', 'rank', 'company', 'class', 'user');
        
        $skillTypes = SkillType::asArrayForDropDown();
        
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

        $character->name = $validated['name'];
        $character->slug = isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $character->level = $validated['level'] ?? 0;
        
        // relations
        $character->class()->associate($validated['class']);
        
        if($request->user()->can('edit company members')){
            $character->rank()->associate($validated['rank']);
            $character->company()->associate($validated['company']);
            // TODO: allow editing attached user if not current user's character
        }
        
        $character->save();
        
        if(isset($validated['skills'])) {
            // update skills levels related to this character on pivot table
            foreach ( $validated['skills'] as $skill => $level ) {
                // don't need to save
                $character->skills()->updateExistingPivot( $skill, ['level' => $level ?? 0] );
            }
        }
        
        // if this is the user's own character, update the session info
        if($request->user()->character()->id == $character->id){
            $request->session()->put('character', $character);
        }
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character updated successfully'
            ]
        ]);
    }

    public function destroy( Character $character )
    {

        Character::destroy($character->id);
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character deleted successfully'
            ]
        ]);
    }
}