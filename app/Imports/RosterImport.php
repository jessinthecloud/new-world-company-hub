<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RosterImport implements WithCalculatedFormulas, WithMultipleSheets
{
    use WithConditionalSheets;

    public function sheets() : array
    {
        return [
            0 => new RosterMainImport(),
//            1 => '', this is hidden roster sheet
            2 => new FormResponseImport(),
        ];
    }
    

    public function conditionalSheets(): array
    {
        return [
            0 => new RosterMainImport(),
//            1 => '', this is hidden roster sheet
            2 => new FormResponseImport(),
        ];
    }
}
