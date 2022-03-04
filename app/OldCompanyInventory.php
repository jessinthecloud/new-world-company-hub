<?php

namespace App;

use App\Models\Characters\Character;
use App\Models\Companies\Company;

/** @deprecated */
class OldCompanyInventory extends Company
{
    protected $table = 'companies';
    protected string $ownerable_type = Company::class;
}