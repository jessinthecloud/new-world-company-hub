<?php

namespace App\Http\Controllers\Companies;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
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

    public function edit( GuildBank $guildBank )
    {
        // add items to bank
        // or edit company attached (super-admin)
        
        $companies = Company::orderBy('name')->distinct()->get()->mapWithKeys(function($company){
            return [$company->slug => $company->name];
        })->all();

        $company_options = '';
        foreach($companies as $value => $text) {
            $company_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $armor = BaseArmor::distinct()->with('perks')
            ->where('named', 0)->orderBy('name')->get()->mapWithKeys(function($armor){
        
            $wtype = $armor->type;
            $type = !empty($wtype) ? constant("App\Enums\ArmorType::$wtype")->value : null;
        
            return [$armor->slug => $armor->name . " (".(!empty($armor->weight_class) ? $armor->weight_class.' ' : '').$type.") Tier ".$armor->tier];
        })->all();

        $armor_options = '<option value=""></option>';
        foreach($armor as $value => $text) {
            $armor_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $weapons = BaseWeapon::with('perks')->where('named', 0)->orderBy('name')->orderBy('tier')->distinct()->get()->mapWithKeys(function($weapon){
        $wtype = $weapon->type;
        $type = !empty($wtype) ? constant("App\Enums\WeaponType::$wtype")->value : null;
        
            return [$weapon->slug => $weapon->name . " ($type) Tier ".$weapon->tier];
        })->all();

        $weapon_options = '<option value=""></option>';
        foreach($weapons as $value => $text) {
            $weapon_options .= '<option value="'.$value.'">'.$text.'</option>';
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
        
        $rarity_options = '';
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
                'armor_options' => $armor_options,
                'weapon_options' => $weapon_options,
                'armor_type_options' => $armor_type_options,
                'weapon_type_options' => $weapon_type_options,
                'perk_options' => $perk_options,
                'rarity_options' => $rarity_options,
                'tier_options' => $tier_options,
                'weight_class_options' => $weight_class_options,
                'attribute_options' => $attribute_options,
                'company_options' => $company_options,
                'method' => 'PUT',
                'form_action' => route('guild-banks.update', ['guild_bank'=>$guildBank]),
                'button_text' => 'Update',
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
        if(!empty($perks->pluck('id')->all())) {
            $item->perks()->attach($perks->pluck('id')->all());
        }
        
        // attach attributes
        if(!empty($validated['attrs'])) {
        
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
        $item->companies()->attach($guildBank->company->id);
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory added successfully: '.($item->name ?? $base->name)
            ]
        ]);    
    }
    
    public function choose()
    {
        $guildBanks = GuildBank::get()->sortBy('company.name')->mapWithKeys(function($guildBank){
            return [$guildBank->id => $guildBank->company->name.' Guild Bank'];
        })->all();
        $form_action = route('guild-banks.find');

        return view(
            'dashboard.guild-bank.choose',
            compact('guildBanks', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(
            route('guild-banks.'.$request->action, [
                'guild_bank'=>$request->guildBank
            ])
        );
    }
    
    // if guildbank is not in URL, defaults to current logged-in user's selected company to create one 
    public function show(Request $request, GuildBank $guildBank)
    {
        if(!isset($guildBank->company()->id)){
            $company = $request->user()->company();
            $guildBank = new GuildBank($company);
        }
    
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
        
//        $company = $request->user()->company();

        return view('guild-bank.show', 
            compact('guildBank',
                'armors',
                'weapons',
                'types',
                'weight_class',
                'rarity',
                'perks'
            )
        );
    }

    public function create()
    {
        // (super-admin)
    }

    public function store( Request $request )
    {
        // (super-admin)
    }

    public function destroy( GuildBank $guildBank )
    {
        // governor / (super-admin)
    }
}