<?php

namespace App\Http\Controllers\Items;

use App\Contracts\InventoryItem;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Services\ArmorService;
use App\Services\WeaponService;
use Illuminate\Http\Request;

class CompanyInventoryController extends Controller
{
    public function __construct(protected ArmorService $armorService, protected WeaponService $weaponService) 
    {
         
    }
    
    public function index(Company $company)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store( Request $request )
    {
        //
    }

    public function show( Company $company )
    {
        //
    }

    public function edit( Company $company, string $type, InventoryItem $item )
    {
        //
    }

    public function update( Request $request, Company $company, string $type, InventoryItem $item )
    {
        //
    }

    public function destroy( Company $company, string $type, InventoryItem $item )
    {
        //
    }
}