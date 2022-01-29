<?php

namespace App\Http\Controllers\Characters;

use App\Enums\WeaponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterCreationRequest;
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

class CharacterLoginController extends Controller
{
    /**
     * Set this as primary character for logged-in user
     *
     * @param \Illuminate\Http\Request         $request
     * @param \App\Models\Characters\Character $character
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login( Request $request, Character $character )
    {
        $request->session()->put('character', $character);

        return redirect(RouteServiceProvider::DASHBOARD);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $action
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function choose(Request $request, string $action = 'Submit')
    {
        $characters = Character::forUser($request->user()->id)
            ->get()
            ->mapWithKeys(function($character){
                return [
                    $character->slug => $character->name 
                        . (!empty($character->level)) 
                            ? ' (Level '.$character->level.')' 
                            : ''
                ];
        })->all();
               
        $form_action = route('characters.find');
        $action = 'login';
        
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

        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
        
        $weapons = WeaponType::valueToAssociative();
        asort($weapons);
    
        $form_action = route('characters.login.store');
        $button_text = 'Add';
    
        return view(
            'dashboard.character.create-edit', 
            compact('skillTypes', 'weapons',
                'form_action', 'button_text')
        );
    }

    public function store( CharacterCreationRequest $request )
    {
        $validated = $request->validated();
//dump($validated, $character, $character->skills->pluck('pivot')->pluck('level')/*, $request*/);

        $user_roles = $request->user()->getRoleNames()->all();
//dump('user roles',$user_roles);
        // get class from user roles
        $class = CharacterClass::whereIn('name', $user_roles)->first();
//dump('class',$class);
        // get rank from user roles
        $rank = Rank::whereIn('name', $user_roles)->orderBy('order')->first();
//dump('rank',$rank);        
        // if no ranks, but have member role, add settler rank
        if(empty($rank) && in_array('breakpoint-member', $user_roles)){
            $rank = Rank::where('name', 'Settler')->first();
        }
//dd('rank',$rank); 
        $character = Character::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
//            'level' => $validated['level'],
            'mainhand' => $validated['mainhand'],
            'offhand' => $validated['offhand'],
            // relations
            'character_class_id' => $class->id,
            'rank_id' => $rank->id,
            'company_id' => getPermissionsTeamId(),
            'user_id' => $request->user()->id,
        ]);
        
        // update skills levels related to this character on pivot table
        /*foreach($validated['skills'] as $skill_id => $level){
            // don't need to ->save()
            $character->skills()->attach($skill_id, ['level'=>$level ?? 0]);
        }*/

//        dump($character, $character->skills->pluck('pivot')->pluck('level'));
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character '.$validated['name'].' created successfully'
            ]
        ]);
    }
}