<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RosterMainImport implements ToCollection, WithHeadingRow, HasReferencesToOtherSheets /*WithCalculatedFormulas*/
// WithCalcFormulas is turning everything into #NAME?
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
//        dump('Roster Main Import Class');
        //  heading keys are formatted with the Laravel str_slug() helper.
        // E.g. this means all spaces are converted to _
        /*foreach ($rows as $row) 
        {
//            dump();
        }*/
        
//        dump($rows);
    }
    
    public function headingRow(): int
    {
        return 2;
    }
}
