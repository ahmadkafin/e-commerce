<?php

namespace App\Imports;

use App\Models\Collection as ModelsCollection;
use App\Models\ProductCollection;
use App\Models\Products;
use App\Models\UkuranProducts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProductsImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {

            $sizes = ["s", "m", "l", "xl", "xxl", "xxxl"];
            foreach ($rows as $row) {

                $cols = ModelsCollection::select('id', 'name')->where('name', '=', $row['collection'])->exists();
                $ds = ModelsCollection::select('id', 'name')->where('name', $row['collection'])->first();
                Products::create([
                    'sku'           => $row['sku'],
                    'slugs'         => $row['slugs'],
                    'nama'          => $row['nama'],
                    'warna'         => $row['warna'],
                    'total'         => $row['total'],
                    'harga'         => $row['harga'],
                    'deskripsi'     => $row['deskripsi'],
                    'deleted_at'    => null,
                    'created_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                    'updated_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                ]);

                for ($x = 0; $x < count($sizes); $x++) {
                    UkuranProducts::create([
                        'uid_skuP'      => $row['sku'],
                        'size'          => $sizes[$x],
                        'jumlah'        => $row[$sizes[$x]],
                        'created_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                        'updated_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                    ]);
                }

                if ($cols) {
                    ProductCollection::create([
                        'fid_prod'      => $row['sku'],
                        'fid_col'       => $ds->id,
                        'created_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                        'updated_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                    ]);
                } else {
                    $colect = ModelsCollection::create([
                        'name'          => $row['collection'],
                        'slugs'         => $row['collection'],
                        '_isActive'     => 1,
                        'created_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                        'updated_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                    ]);

                    ProductCollection::create([
                        'fid_prod'      => $row['sku'],
                        'fid_col'       => $colect->id,
                        'created_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                        'updated_at'    => Carbon::now($tz = 'Asia/Jakarta'),
                    ]);
                }
            }
            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status'    => 500,
                'msg'       => $e->getMessage(),
            ]);
        }
    }
}
