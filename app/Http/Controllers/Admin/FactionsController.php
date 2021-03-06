<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FactionUpsertRequest;
use App\Models\Faction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function dump;
use function redirect;
use function route;
use function view;

class FactionsController extends Controller
{
    public function index()
    {
        $factions = Faction::orderBy('name')->get()->mapWithKeys(function($faction){
            return [$faction->slug => $faction->name];
        })->all();
        
        dump($factions);
    }

    public function choose()
    {
        $factions = Faction::orderBy('name')->get()->mapWithKeys(function($faction){
            return [$faction->slug => $faction->name];
        })->all();
        $form_action = route('factions.find');

        return view(
            'dashboard.faction.choose',
            compact('factions', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(route('factions.'.$request->action, ['faction' => $request->faction]));
    }

    /**
     * Show Faction create form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $factions = Faction::orderBy('name')->get()->mapWithKeys(function($faction){
            return [$faction->slug => $faction->name];
        })->all();

        $form_action = route('factions.store');
        $button_text = 'Create';

        return view(
            'dashboard.faction.create-edit',
            compact('factions', 'form_action', 'button_text')
        );
    }

    public function store( FactionUpsertRequest $request )
    {
        $validated = $request->validated();

        Faction::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Faction '.$validated['name'].' created successfully'
            ]
        ]);
    }

    public function show( Faction $faction )
    {
        //
    }

    /**
     * Faction edit form
     *
     * @param \App\Models\Faction $faction
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Faction $faction )
    {
        $factions = Faction::distinct()->get()->mapWithKeys(function($faction){
            return [$faction->slug => $faction->name];
        })->all();

        return view(
            'dashboard.faction.create-edit',
            [
                'faction' => $faction,
                'method' => 'PUT',
                'form_action' => route('factions.update', ['faction'=>$faction]),
                'button_text' => 'Edit',
            ]
        );
    }

    public function update( FactionUpsertRequest $request, Faction $faction )
    {
        $validated = $request->validated();

        $faction->name = $validated['name'];
        $faction->slug = isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $faction->save();

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Faction '.$validated['name'].' updated successfully'
            ]
        ]);
    }

    public function destroy( Faction $faction )
    {
        Faction::destroy($faction);

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Faction '.$faction->name.' deleted successfully'
            ]
        ]);
    }
}