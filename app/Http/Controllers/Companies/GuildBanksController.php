<?php

namespace App\Http\Controllers\Companies;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\ItemType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\GuildBank;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddInventoryRequest;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\Attribute;
use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;
use App\Models\Items\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function collect;
use function redirect;
use function route;
use function view;

class GuildBanksController extends Controller
{
    public function __construct() 
    {
         
    }

    public function index(Request $request)
    {
        
    }
    
    public function create( GuildBank $guildBank )
    {
        // add items to bank
        
        $base_armor = BaseArmor::where('named', 0)->distinct()
            ->orderBy('name')/*->dd()->toSql();*/
            ->get()->mapWithKeys(function($base_armor){
        
            $wtype = $base_armor->type;
            $type = !empty($wtype) ? constant("App\Enums\ArmorType::$wtype")->value : null;
        
            return [$base_armor->slug => $base_armor->name . " (".(!empty($base_armor->weight_class) ? $base_armor->weight_class.' ' : '').$type.") Tier ".$base_armor->tier];
        })->all();
//        ddd($guildBank, $companies, $base_armor);

        $base_armor_options = '<option value=""></option>';
        foreach($base_armor as $value => $text) {
            $base_armor_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $base_weapons = BaseWeapon::/*with('perks')->*/where('named', 0)->orderBy('name')->orderBy('tier')->distinct()->get()->mapWithKeys(function($base_weapon){
        $wtype = $base_weapon->type;
        $type = !empty($wtype) ? constant("App\Enums\WeaponType::$wtype")->value : null;
        
            return [$base_weapon->slug => $base_weapon->name . " ($type) Tier ".$base_weapon->tier];
        })->all();

        $base_weapon_options = '<option value=""></option>';
        foreach($base_weapons as $value => $text) {
            $base_weapon_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();

        $perk_options = '<option value=""></option>';
        foreach($perks as $value => $text) {
            $perk_options .= '<option value="'.$value.'">'.$text.'</option>';
        }

        $weapon_type_options = '';
        foreach(collect(WeaponType::cases())->sortBy('value')->all() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $armor_type_options = '';
        foreach(collect(ArmorType::cases())->sortBy('value')->all() as $type) {
            $armor_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $rarity_options = '<option value=""></option>';
        foreach(Rarity::cases() as $type) {
            $rarity_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $weight_class_options = '<option value="">None</option>';
        foreach(WeightClass::cases() as $type) {
            $weight_class_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $attribute_options = '<option value=""></option>';
        foreach(collect(AttributeType::cases())->sortBy('value')->all() as $type) {
            $attribute_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }

        return view(
            'dashboard.guild-bank.create-edit',
            [
                'base_armor_options' => $base_armor_options,
                'base_weapon_options' => $base_weapon_options,
                'armor_type_options' => $armor_type_options,
                'weapon_type_options' => $weapon_type_options,
                'perk_options' => $perk_options,
                'rarity_options' => $rarity_options,
                'tier_options' => $tier_options,
                'weight_class_options' => $weight_class_options,
                'attribute_options' => $attribute_options,
                'method' => 'POST',
                'form_action' => route('guild-banks.store', ['guildBank'=>$guildBank->slug]),
                'button_text' => 'Add Item',
            ]
        );
    } // end create()

    public function store( AddInventoryRequest $request, GuildBank $guildBank )
    {

        // Retrieve the validated input data...
        $validated = $request->validated();

/*dump(
//'missing: ', array_diff_key($request->all(), $validated), 
$validated 
);*/

        $rarity_input = $validated['rarity'];
        $rarity = !empty($rarity_input) ? constant("App\Enums\Rarity::$rarity_input")?->value : null;
        
        $tier_input = $validated['tier'];
        $tier = !empty($tier_input) ? constant("App\Enums\Tier::$tier_input")?->value : null;      
        
/*dump(
'tier: '.$tier,
'rarity: '.$rarity
); */ 
        
        // create instanced item
        if($validated['is_weapon']){
            
            // get base weapon
            $base = BaseWeapon::where('slug', $validated['weapon'])->first();
            
            $type_input = $validated['weapon_type'];
            $type = !empty($type_input) ? constant("App\Enums\WeaponType::$type_input")?->value : null;
/*dump(
$base,
'type: '.$type,
'gear score: '.($validated['gear_score'] ?? $validated['weapon_gear_score'] ?? null)
);*/            
            $item = Weapon::create([
                'name' => $validated['name'] ?? $base->name,
                'slug' => isset($validated['name']) ? Str::slug($validated['name']) : $base->slug,
                'type' => $type ?? $base->type,
                'description' => $validated['description'] ?? $base?->description ?? null,
                'tier' => $tier ?? $base?->tier ?? null,
                'rarity' => $rarity ?? $base?->rarity ?? null,
                'gear_score' => $validated['gear_score'] ?? $validated['weapon_gear_score'] ?? $base?->gear_score ?? null,
           ]);

        }
        else{
            // get base armor
            $base = BaseArmor::where('slug', $validated['armor'])->first();
            
            $type_input = $validated['armor_type'];
            $type = !empty($type_input) ? constant("App\Enums\ArmorType::$type_input")?->value : null;
            
            $weight_class = !empty($validated['weight_class']) ? WeightClass::from($validated['weight_class'])->name : null;
/*dump(
$base,
'weight class: '.$weight_class, 
'type: '.$type,
'gear score: '.($validated['gear_score'] ?? $validated['armor_gear_score'] ?? null)
); */           
            $item = Armor::create([
                'name' => $validated['name'] ?? $base?->name ?? null,
                'slug' => isset($validated['name']) ? Str::slug($validated['name']) : $base->slug,
                'type' => $type ?? $base->type,
                'description' => $validated['description'] ?? $base?->description ?? null,
                'tier' => $tier ?? $base?->tier ?? null,
                'rarity' => $rarity ?? $base?->rarity ?? null,
                'weight_class' => $weight_class ?? $base?->weight_class ?? null,
                'gear_score' => $validated['gear_score'] ?? $validated['armor_gear_score'] ?? $base?->gear_score ?? null,
           ]);
        }
        
        if(isset($base)) {
            // attach to base item
            $item->base()->associate($base);
            $item->save();
        }
        
        // attach perks
        $perks = Perk::whereIn('slug', $validated['perks'])->get();
//dump('perks: ', $perks, $perks->pluck('id')->all());
        if(!empty(array_filter($perks->pluck('id')->all()))) {
            $item->perks()->attach($perks->pluck('id')->all());
        }
        
        // attach attributes
        if(!empty(array_filter($validated['attrs']))) {
            $attrs = [];
            $amounts = [];
            foreach($validated['attrs'] as $key => $attr){
                $attr_slug = constant("App\Enums\AttributeType::$attr")?->value;
                $attrs []= $attr_slug;
                $amounts [strtolower($attr_slug)]= $validated['attribute_amounts'][$key];
            }
      
            $attributes = Attribute::whereIn( 'slug', $attrs)->get();
/*ddd(
$attrs,
'attributes: ',
$attributes,
$attributes->pluck( 'id' )->all(),
'Guild Bank: ' . $guildBank->id
);*/
            if ( !empty( $attributes->pluck( 'id' )->all() ) ) {
                // also attach with amounts
                foreach($attributes as $attribute){
                    $item->attributes()->attach($attribute->id, ['amount' => $amounts[$attribute->slug]]);
                }
            }
        }
        
        // attach to bank
        $item->company()->associate($guildBank->company()->id);
        $item->save();
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory added successfully: '.($item->name ?? $base->name)
            ]
        ]);    
    } // end store()

    /** 
     * @param \App\GuildBank $guildBank
     * @param                $itemType // Weapon/Armor/Material
     * @param                $item // slug of specific item
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit( Request $request, GuildBank $guildBank )
    {
        $itemSlug = $request->item;
        $itemType = $request->itemType;
        // get item specifics
        $model = 'App\Models\Items\\'.Str::title($itemType);
        $item = $model::with('perks','base','attributes')->where('slug', $itemSlug)->sole();
//dump($itemSlug, $itemType,$item, $item->rarity);        
        $base_armors = BaseArmor::where('named', 0)->distinct()
            ->orderBy('name')/*->dd()->toSql();*/
            ->get()->mapWithKeys(function($base_armor){
        
            $wtype = $base_armor->type;
            $type = !empty($wtype) ? constant("App\Enums\ArmorType::$wtype")->value : null;
        
            return [$base_armor->slug => $base_armor->name . " (".(!empty($base_armor->weight_class) ? $base_armor->weight_class.' ' : '').$type.") Tier ".$base_armor->tier];
        })->all();
//        ddd($guildBank, $companies, $base_armor);

        $base_armor_options = '<option value=""></option>';
        foreach($base_armors as $value => $text) {
            $base_armor_options .= '<option value="'.$value.'"';
                if($value == $item->slug){
                    $base_armor_options .= ' SELECTED ';
                }
            $base_armor_options .= '>'.$text.'</option>';
        }
        
        $base_weapons = BaseWeapon::/*with('perks')->*/where('named', 0)->orderBy('name')->orderBy('tier')->distinct()->get()->mapWithKeys(function($base_weapon){
        $wtype = $base_weapon->type;
        $type = !empty($wtype) ? constant("App\Enums\WeaponType::$wtype")->value : null;
        
            return [$base_weapon->slug => $base_weapon->name . " ($type) Tier ".$base_weapon->tier];
        })->all();

        $base_weapon_options = '<option value=""></option>';
        foreach($base_weapons as $value => $text) {
            $base_weapon_options .= '<option value="'.$value.'"';
                if($value == $item->slug){
                    $base_weapon_options .= ' SELECTED ';
                }
            $base_weapon_options .= '>'.$text.'</option>';
        }
        
        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();

        $perk_options = '<option value=""></option>';
        foreach($perks as $value => $text) {
            $perk_options .= '<option value="'.$value.'"';
                if(in_array($value, $item->perks->pluck('slug')->all())){
                    $perk_options .= ' selected="selected" ';
                }
            $perk_options .= '>'.$text.'</option>';
        }

        $weapon_type_options = '';
        foreach(collect(WeaponType::cases())->sortBy('value')->all() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'"';
                if(strtolower($value) == strtolower($itemType)){
                    $weapon_type_options .= ' SELECTED ';
                }
            $weapon_type_options .= '>'.$type->value.'</option>';
        }
        
        $armor_type_options = '';
        foreach(collect(ArmorType::cases())->sortBy('value')->all() as $type) {
            $armor_type_options .= '<option value="'.$type->name.'"';
                if(strtolower($value) == strtolower($itemType)){
                    $armor_type_options .= ' SELECTED ';
                }
            $armor_type_options .= '>'.$type->value.'</option>';
        }
        
        $rarity_options = '<option value=""></option>';
        foreach(Rarity::cases() as $type) {
             $rarity_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($item->rarity)){
                    $rarity_options .= ' SELECTED ';
                }
            $rarity_options .= '>'.$type->value.'</option>';
        }
        
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($item->tier)){
                    $tier_options .= ' SELECTED ';
                }
            $tier_options .= '>'.$type->value.'</option>';
        }
        
        $weight_class_options = '<option value="">None</option>';
        foreach(WeightClass::cases() as $type) {
            $weight_class_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($item->weight_class)){
                    $weight_class_options .= ' SELECTED ';
                }
            $weight_class_options .= '>'.$type->value.'</option>';
        }
        
        $attribute_options = '<option value=""></option>';
        foreach(collect(AttributeType::cases())->sortBy('value')->all() as $type) {
            $attribute_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($item->attribute)){
                    $attribute_options .= ' SELECTED ';
                }
            $attribute_options .= '>'.$type->value.'</option>';
        }

        return view(
            'dashboard.guild-bank.create-edit',
            [
                'base_armor_options' => $base_armor_options,
                'base_weapon_options' => $base_weapon_options,
                'item' => $item,
                'itemType' => $itemType,
                'isWeapon' => strtolower($itemType) == 'weapon' ? 1 : 0,
                'isArmor' => strtolower($itemType) == 'armor' ? 1 : 0,
                'newEntry' => isset($item?->base?->id) ? 0 : 1,
                'armor_type_options' => $armor_type_options,
                'weapon_type_options' => $weapon_type_options,
                'perk_options' => $perk_options,
                'rarity_options' => $rarity_options,
                'tier_options' => $tier_options,
                'weight_class_options' => $weight_class_options,
                'attribute_options' => $attribute_options,
                'method' => 'PUT',
                'form_action' => route('guild-banks.update', ['guildBank'=>$guildBank->slug]),
                'button_text' => 'Edit Item',
            ]
        );
    }

    public function update( AddInventoryRequest $request, GuildBank $guildBank )
    {

        // Retrieve the validated input data...
        $validated = $request->validated();

/*dump(
//'missing: ', array_diff_key($request->all(), $validated), 
$validated 
);*/

        $rarity_input = $validated['rarity'];
        $rarity = !empty($rarity_input) ? constant("App\Enums\Rarity::$rarity_input")?->value : null;
        
        $tier_input = $validated['tier'];
        $tier = !empty($tier_input) ? constant("App\Enums\Tier::$tier_input")?->value : null;      
        
/*dump(
'tier: '.$tier,
'rarity: '.$rarity
); */ 
        
        // create instanced item
        if($validated['is_weapon']){
            
            // get base weapon
            $base = BaseWeapon::where('slug', $validated['weapon'])->first();
            
            $type_input = $validated['weapon_type'];
            $type = !empty($type_input) ? constant("App\Enums\WeaponType::$type_input")?->value : null;
/*dump(
$base,
'type: '.$type,
'gear score: '.($validated['gear_score'] ?? $validated['weapon_gear_score'] ?? null)
);*/            
            $item = Weapon::create([
                'name' => $validated['name'] ?? $base->name,
                'slug' => isset($validated['name']) ? Str::slug($validated['name']) : $base->slug,
                'type' => $type ?? $base->type,
                'description' => $validated['description'] ?? $base?->description ?? null,
                'tier' => $tier ?? $base?->tier ?? null,
                'rarity' => $rarity ?? $base?->rarity ?? null,
                'gear_score' => $validated['gear_score'] ?? $validated['weapon_gear_score'] ?? $validated['armor_gear_score'] ?? $base?->gear_score ?? null,
           ]);

        }
        else{
            // get base armor
            $base = BaseArmor::where('slug', $validated['armor'])->first();
            
            $type_input = $validated['armor_type'];
            $type = !empty($type_input) ? constant("App\Enums\ArmorType::$type_input")?->value : null;
            
            $weight_class = !empty($validated['weight_class']) ? WeightClass::from($validated['weight_class'])->name : null;
/*dump(
$base,
'weight class: '.$weight_class, 
'type: '.$type,
'gear score: '.($validated['gear_score'] ?? $validated['armor_gear_score'] ?? null)
); */           
            $item = Armor::create([
                'name' => $validated['name'] ?? $base?->name ?? null,
                'slug' => isset($validated['name']) ? Str::slug($validated['name']) : $base->slug,
                'type' => $type ?? $base->type,
                'description' => $validated['description'] ?? $base?->description ?? null,
                'tier' => $tier ?? $base?->tier ?? null,
                'rarity' => $rarity ?? $base?->rarity ?? null,
                'weight_class' => $weight_class ?? $base?->weight_class ?? null,
                'gear_score' => $validated['gear_score'] ?? $validated['armor_gear_score'] ?? $base?->gear_score ?? null,
           ]);
        }
        
        if(isset($base)) {
            // attach to base item
            $item->base()->associate($base);
            $item->save();
        }
        
        // attach perks
        $perks = Perk::whereIn('slug', $validated['perks'])->get();
//dump('perks: ', $perks, $perks->pluck('id')->all());
        if(!empty(array_filter($perks->pluck('id')->all()))) {
            $item->perks()->attach($perks->pluck('id')->all());
        }
        
        // attach attributes
        if(!empty(array_filter($validated['attrs']))) {
            $attrs = [];
            $amounts = [];
            foreach($validated['attrs'] as $key => $attr){
                $attr_slug = constant("App\Enums\AttributeType::$attr")?->value;
                $attrs []= $attr_slug;
                $amounts [strtolower($attr_slug)]= $validated['attribute_amounts'][$key];
            }
      
            $attributes = Attribute::whereIn( 'slug', $attrs)->get();
/*ddd(
$attrs,
'attributes: ',
$attributes,
$attributes->pluck( 'id' )->all(),
'Guild Bank: ' . $guildBank->id
);*/
            if ( !empty( $attributes->pluck( 'id' )->all() ) ) {
                // also attach with amounts
                foreach($attributes as $attribute){
                    $item->attributes()->attach($attribute->id, ['amount' => $amounts[$attribute->slug]]);
                }
            }
        }
        
        // attach to bank
        $item->company()->associate($guildBank->company()->id);
        $item->save();
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory edited successfully: '.($item->name ?? $base->name)
            ]
        ]);    
    }
    
    public function choose(Request $request, $action=null )
    {
//    dump('action: '.$request->action, 'item type: '.$request->itemType, 'item: '.$request->item, 'guildBank: '.$request->guildBank);

        $action = $request->action;
        
        if($request->action == 'edit-item-type'){

            // already chose guildBank
            $guildBank = $request->guildBank;
            $form_action = route('guild-banks.find', [
                'action'=>$request->action,
                'guildBank'=>$request->guildBank
            ]);
            
            $itemTypes = ItemType::toAssociative();

            return view(
                'dashboard.guild-bank.choose',
                compact('guildBank', 'action', 'form_action', 'itemTypes')
            );
        }
        
        if($request->action == 'edit-item'){
        
            // already chose guildBank and item type
            $guildBank = $request->guildBank;
            $itemType = $request->itemType;
            $form_action = route('guild-banks.find', [
                'action'=>$request->action,
                'guildBank'=>$request->guildBank
            ]);
            
            $model = 'App\Models\Items\\'.Str::title($itemType);
//            dump('App\Models\Items\\'.Str::title($itemType), $request->guildBank,'company: ',$guildBank);
            $items = $model::whereRelation('company', 'slug', $guildBank?->slug ?? $guildBank)->get()->mapWithKeys(function($item){
                return [$item->slug => $item->name];
            })->all();

            return view(
                'dashboard.guild-bank.choose',
                compact('guildBank', 'action', 'form_action', 'itemType', 'items')
            );
        }
        
        $guildBanks = Company::orderBy('name')->get()->mapWithKeys(function($guildBank){
            return [$guildBank->slug => $guildBank->name.' Guild Bank'];
        })->all();
        $form_action = route('guild-banks.find', ['action'=>$request->action]);
        
//dump('FORM ACTION: '.$form_action);

        return view(
            'dashboard.guild-bank.choose',
            compact('guildBanks', 'action', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    dd('action: '.$request->action, 'item type: '.$request->itemType, 'item: '.$request->item, 'guildBank: '.$request->guildBank);

//    ddd($request);
        // if editing and already chose a company,send back to choose an item to edit
        if($request->action == 'edit' && empty($request->item)){
            return redirect(
                route('guild-banks.choose', [
                    'guildBank'=>$request->guildBank,
                    'action' => 'edit-item-type'
                ])
            );
        } 
        
        if($request->action == 'edit-item-type' && empty($request->item)){
            return redirect(
                route('guild-banks.choose', [
                    'guildBank'=>$request->guildBank,
                    'itemType'=>$request->itemType,
                    'action' => 'edit-item'
                ])
            );
        } 
        
        if($request->action == 'edit-item'){
            return redirect(
                route('guild-banks.edit', [
                    'guildBank'=>$request->guildBank,
                    'itemType'=>$request->itemType,
                    'item'=>$request->item,
                    'action' => 'edit'
                ])
            );
        } 
        
        return redirect(
            route('guild-banks.'.$request->action, [
                'guildBank'=>$request->guildBank->slug ?? $request->guildBank,
                'action' => $request->action,
            ])
        );
    }
    
    
    // if guildbank is not in URL, defaults to current logged-in user's selected company to create one 
    public function show(Request $request, GuildBank $guildBank=null)
    {
        if(!isset($guildBank?->company()->id)){
            $company = $request->user()->company();
            $guildBank = new GuildBank($company);
        }
        
        $company = $guildBank->company();

        $armors = ArmorType::valueToAssociative();
        $weapons = WeaponType::valueToAssociative();
        $weight_class = WeightClass::valueToAssociative();
        $rarity = Rarity::valueToAssociative();
        
        $perks = Perk::orderBy('name')->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        });

        // add "Any" to the front of the filter arrays
        $armors = collect($armors)->prepend('Any', '')->all();
        $weapons = collect($weapons)->prepend('Any', '')->all();
        $weight_class = collect($weight_class)->prepend('Any', '')->all();
        $rarity = collect($rarity)->prepend('Any', '')->all();
        $perks = $perks->prepend('Any', '')->all();

        $types = [''=>'Any', 'Weapon'=>'Weapon', 'Armor'=>'Armor'];

        return view('guild-bank.show', 
            compact(
                'guildBank',
                'company',
                'armors',
                'weapons',
                'types',
                'weight_class',
                'rarity',
                'perks'
            )
        );
    }

    public function destroy( GuildBank $guildBank )
    {
        // governor / (super-admin)
    }
}