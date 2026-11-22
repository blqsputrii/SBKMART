<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    protected function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka bulat.',
            'numeric' => ':attribute harus berupa angka.',
            'in' => ':attribute tidak valid.',
            'array' => ':attribute tidak valid.',
            'min' => [
                'numeric' => ':attribute minimal :min.',
                'string' => ':attribute minimal :min karakter.',
                'array' => ':attribute minimal :min baris.',
            ],
            'max' => [
                'numeric' => ':attribute maksimal :max.',
                'string' => ':attribute maksimal :max karakter.',
            ],
        ];
    }

    protected function satu(string $sql, array $bind = [])
    {
        $rows = DB::select($sql, $bind);
        if (empty($rows)) {
            abort(404);
        }
        return $rows[0];
    }
}
