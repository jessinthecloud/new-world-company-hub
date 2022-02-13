<?php

namespace App\Exports;

use App\Models\Companies\Company;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyMembersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(protected Company $company) { }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->company->characters();
    }

    /**
     * @return array
     */
    public function headings() : array
    {
        return [
            'Name',
            'Discord',
            'Class',
            'Registered',
        ];
    }

    /**
     * @param $character
     *
     * @return array
     */
    public function map($character) : array
    {
        return [
            $character->name,
            $character->user->discord?->name,
            $character->class->name,
            Carbon::createFromFormat('Y-m-d H:i:s', $character->created_at)->format('F j, Y g:i:s A'),
        ];
    }

    /**
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     *
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
         return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }}
