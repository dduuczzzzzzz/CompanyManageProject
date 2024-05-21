<?php

namespace App\Exports;

use App\Http\Resources\UserSession\UserSessionResource;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportUserSession implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'user_name',
            'user_id',
            'month',
            'year',
            'late_count',
            'leave_soon_count',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => 'FFA500', // Màu cam
                ],
            ],
        ]);
        $lastRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $lastRow; $row++) {
            $sheet->getStyle("A{$row}:Z{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }
        return [
            // Style the first row as bold text.
            1    => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }

    /**
    * @return array
    */
    public function map($userSession): array
    {
        $userSession = UserSessionResource::make($userSession);
        return [
            // $row['user_name'],
            // $row['user_id'],
            // $row['month'],
            // $row['year'],
            // $row['late_count'],
            // $row['leave_soon_count'],
            $userSession->user->name,
            $userSession->user_id,
            $userSession->month,
            $userSession->year,
            $userSession->late_count,
            $userSession->leave_soon_count
        ];
    }
}
