<?php

namespace App\Imports;

use App\Models\Products;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */
    // public function collection(Collection $collection)
    // {
    //     //
    // }

    public function model(array $row)
    {
        return new Products([
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'buyingPrice' => $row['buying_price'],
            'sellingPrice' => $row['selling_price'],
            'description' => $row['description'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'quantity' => 'required|integer|min:1',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'description' => 'nullable',
        ];
    }
}
