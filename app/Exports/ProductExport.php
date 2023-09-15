<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return Products::all(['name', 'quantity', 'buyingPrice', 'sellingPrice', 'description']);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Quantity',
            'Buying Price',
            'Selling Price',
            'Description',
        ];
    }
}
