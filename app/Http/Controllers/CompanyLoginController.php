<?php

namespace App\Http\Controllers;

use App\Models\Companies\Company;
use App\Providers\RouteServiceProvider;
use App\Services\DiscordService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CompanyLoginController extends Controller
{
    public function __construct(protected DiscordService $discordService) { }

    /**
     * Set this as primary company for logged-in user
     *
     * @param \Illuminate\Http\Request         $request
     * @param \App\Models\Companies\Company $company
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login( Request $request, Company $company )
    {
        // set the team id for roles/permissions lookups
        // @see : https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions#working-with-teams-permissions
        $request->session()->put('team_id', $company->id);
        
        $user = $request->user();
       
        // assign users their discord role
        
        // get their roles for the discord guild
        $discord_user_info = $this->discordService->fetchGuildMember($user, $company->discord_guild_id);
//dump($discord_user_info);
                
        // match role(s) to the ones in the app
        $roles = $this->discordService->syncUserRoles($user, $company->id, $discord_user_info['roles']);

        // TODO : check for characters belonging to this User+Company combo
        // TODO: set character rank based on matching roles

        return redirect(RouteServiceProvider::DASHBOARD);
    }
    
    public function choose(Request $request)
    {
        $companies = Company::forUser($request->user()->id)->get()
            ->mapWithKeys(function($company){
                return [$company->slug => $company->name.' ('.$company->faction->name.')'];
            })->all();
        $form_action = route('companies.login.find');

        return view(
            'dashboard.company.choose',
            compact('companies', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(
            route('companies.login.login', [
                'company'=>$request->company
            ])
        );
    }
}