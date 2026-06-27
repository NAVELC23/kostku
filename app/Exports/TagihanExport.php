<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TagihanExport implements FromCollection, WithHeadings
{
    /**
    * Ambil data tagihan beserta relasi user/penghuninya
    */
    public function collection()
    {
        return Tagihan::with('penghuni.user')->get()->map(function($item) {
            return [
                'Nama Penghuni' => $item->penghuni->user->name ?? 'Tidak Ditemukan',
                'Bulan' => $item->bulan,
                'Nominal Tagihan' => 'Rp ' . number_format($item->nominal_tagihan, 0, ',', '.'),
                'Status' => $item->status_bayar,
            ];
        });
    }

    /**
    * Header kolom Excel
    */
    public function headings(): array
    {
        return [
            'Nama Penghuni',
            'Bulan',
            'Nominal Tagihan',
            'Status Pembayaran',
        ];
    }
}