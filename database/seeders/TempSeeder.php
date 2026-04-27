<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 2; // Pelanggan Setia
        $transactions = [
            [
                'kostum_id' => 4, // Raiden Shogun
                'start' => '2026-04-15',
                'end' => '2026-04-18',
                'price' => 180000,
                'status' => 'Selesai'
            ],
            [
                'kostum_id' => 2, // Kafka
                'start' => '2026-04-05',
                'end' => '2026-04-08',
                'price' => 200000,
                'status' => 'Selesai'
            ],
            [
                'kostum_id' => 5, // Spider-Man
                'start' => '2026-03-28',
                'end' => '2026-03-31',
                'price' => 150000,
                'status' => 'Dibatalkan'
            ]
        ];

        foreach ($transactions as $t) {
            $status = $t['status'] === 'Dibatalkan' ? 'Batal' : $t['status'];
            $transaksi = \App\Models\Transaksi::create([
                'user_id' => $userId,
                'tanggal_mulai' => $t['start'],
                'tanggal_selesai' => $t['end'],
                'total_biaya' => $t['price'],
                'total_denda' => 0,
                'status' => $status
            ]);
            
            \App\Models\DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'kostum_id' => $t['kostum_id'],
                'harga_sewa_saat_transaksi' => $t['price']
            ]);
        }
    }
}
