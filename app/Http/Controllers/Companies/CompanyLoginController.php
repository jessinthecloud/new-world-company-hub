<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Providers\RouteServiceProvider;
use App\Services\DiscordService;
use Illuminate\Http\Request;

use function redirect;
use function route;
use function setPermissionsTeamId;
use function view;

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
        if(empty($request->session()->get('team_id'))) {
            // set the team id for roles/permissions lookups
            // @see : https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions#working-with-teams-permissions
            setPermissionsTeamId( $company->id );
            $request->session()->put( 'team_id', $company->id );
            //dump('team id set: '.getPermissionsTeamId());        
        }
        
        $user = $request->user();
       
        // assign users their discord role
        
        // get their roles for the discord guild
        $discord_user_info = $this->discordService->fetchGuildMember($user, $company->discord_guild_id);
//dump($discord_user_info);
                
        // match role(s) to the ones in the app
        $roles = $this->discordService->syncUserRoles($user, $company->id, $discord_user_info['roles']);

        // TODO: check for characters belonging to this User+Company combo
        // TODO: find user's roles that match character classes
        // TODO: set character rank based on matching roles
/*dd( 
        $request->session(), 
//        $roles,
//        $request->user()->getAllPermissions()->pluck('name')->all(),
        $request->user()->getRoleNames()->all(),
//        $request->user()->character()?->company->name 
     );*/
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