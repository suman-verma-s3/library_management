<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BooksExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Data source — kaunsa data export karna hai
     */
    public function collection()
    {
        return Book::with('category')->get();
    }

    /**
     * Headers — Excel ke top row mein kya dikhega
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Author',
            'Category',
            'ISBN',
            'Publisher',
            'Year',
        ];
    }

    /**
     * Mapping — har row ka data kaise arrange hoga
     */
    public function map($book): array
    {
        return [
            $book->id,
            $book->title,
            $book->author,
            $book->category->name ?? '—',
            $book->isbn ?? '—',
            $book->publisher ?? '—',
            $book->publication_year ?? '—',
        ];
    }

    /**
     * Styling — headers ko bold + colored background
     */
    public function styles(Worksheet $sheet)
    {
        // Auto-size all columns
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => 'solid',
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }
}