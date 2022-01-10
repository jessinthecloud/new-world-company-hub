<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RosterImport implements WithCalculatedFormulas, WithMultipleSheets
{
    use WithConditionalSheets;

    /**
     * Should be name of an \App\Models\Company 
     */
    private string $company;

    public function __construct( string $company )
    {
        $this->company = $company;
    }

    public function sheets() : array
    {
        return [
            0 => new RosterMainImport(),
//            1 => '', this is hidden roster sheet
            2 => new FormResponseImport($this->company),
        ];
    }


    public function conditionalSheets() : array
    {
        return [
            0 => new RosterMainImport(),
//            1 => '', this is hidden roster sheet
            2 => new FormResponseImport(),
        ];
    }
}
