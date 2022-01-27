<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterCreationRequest;
use App\Http\Requests\CharacterUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\CharacterClass;
use App\Models\Characters\SkillType;
use App\Models\Companies\Company;
use App\Models\Companies\Rank;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
        
        $user = $request->user();
        // assign users their discord role
        // get their roles for the discord guild
        $discord_user_info = Cache::remember('user_'.$user->id.'_guild_info', 900, 
            function() use($user) {
                return Http::withHeaders([
                       "Authorization" => "Bearer " . $user->discord_data->token
                    ])
                    ->acceptJson()
                    ->get( "https://discord.com/api/users/@me/guilds/895006799319666718/member" )
                    ->json()
                    ;
        });
//dump($discord_user_info);                
        // match role(s) to the ones we have
        foreach($discord_user_info['roles'] as $discord_role_id){

            $dr = DB::table('discord_roles')
                ->select('role_id')
                ->where('company_id', '=', 1)
                ->where('id', '=', intval($discord_role_id))
                ->first();
                
            $role_id = $dr->role_id;
                    
            $role = Role::where('id', '=', $role_id)->first();

            if(!empty($role)){
                $user->assignRole($role);
            }
        } // end each discord role

        return redirect(RouteServiceProvider::DASHBOARD);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function choose(Request $request) : View
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
    public function find(Request $request) : RedirectResponse
    {
        return redirect(route('characters.login.login', [
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
        $classes = CharacterClass::with('type')->get()
            ->mapWithKeys(function($class){
            return [$class->id => $class->name.' ('.$class->type->name.')'];
        })->all();

        $skillTypes = SkillType::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
    
        $form_action = route('characters.store');
        $button_text = 'Add';
    
        return view(
            'dashboard.character.create-edit', 
            compact('skillTypes', 'classes', 'form_action', 'button_text')
        );
    }

    public function store( CharacterCreationRequest $request )
    {
        // todo: assign character rank to match roles
        
        $ranks = Rank::distinct()->get()->mapWithKeys(function($rank){
            return [$rank->id => $rank->name];
        })->all();
    
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
}