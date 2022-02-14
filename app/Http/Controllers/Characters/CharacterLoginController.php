<?php

namespace App\Http\Controllers\Characters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterCreationRequest;
use App\Models\Characters\Character;
use App\Models\Characters\CharacterClass;
use App\Models\Characters\SkillType;
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
        // explain to user that this is required
        $request->session()->flash('status', [
           'type'    => 'warning',
           'message' => 'You must choose a character before accessing the dashboard.',
       ]);
           
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
        // explain to user that this is required
        request()->session()->flash('status', [
           'type'    => 'warning',
           'message' => 'You must create a character before accessing the dashboard.',
       ]);
        
        $classes = CharacterClass::asArrayForDropDown();
    
        $skillTypes = SkillType::asArrayForDropDown();
        
        // pre-select class if it is assigned in discord
        $user_roles = request()->user()->getRoleNames()->all();
        $current_classes = CharacterClass::whereIn('name', $user_roles)->get();
        $class_ids = $current_classes->pluck('id')->all();
        
        $class_options = '';
        foreach($classes as $value => $text) {
            $class_options .= '<option value="'.$value.'"';
            if(in_array($value, $class_ids)){
                $class_options .= ' SELECTED ';
            }
            $class_options .= '>'.$text.'</option>';
        }
    
        $form_action = route('characters.login.store');
        $button_text = 'Add';
    
        return view(
            'dashboard.character.create-edit', 
            compact('skillTypes', 
                'form_action', 'button_text', 'class_options')
        );
    }

    public function store( CharacterCreationRequest $request )
    {
        $validated = $request->validated();

        $user_roles = $request->user()->getRoleNames()->all();
        
        // get rank from user roles
        $rank = Rank::whereIn('name', $user_roles)->orderBy('order')->first();
       
        // if no ranks, but have member role, add settler rank
        if(empty($rank) && in_array('breakpoint-member', $user_roles)){
            $rank = Rank::where('name', 'Settler')->first();
        }

        $character = Character::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
//            'level' => $validated['level'],
            // relations
            'character_class_id' => $validated['class'], //$class->id,
            'rank_id' => $rank?->id ?? null,
            'company_id' => getPermissionsTeamId(),
            'user_id' => $request->user()->id,
        ]);
        
        // update skills levels related to this character on pivot table
        /*foreach($validated['skills'] as $skill_id => $level){
            // don't need to ->save()
            $character->skills()->attach($skill_id, ['level'=>$level ?? 0]);
        }*/

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character '.$validated['name'].' created successfully'
            ]
        ]);
    }
}