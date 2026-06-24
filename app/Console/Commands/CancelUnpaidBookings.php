<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CancelUnpaidBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-unpaid-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel bookings that have been waiting for payment for more than 12 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deadline = Carbon::now()->subHours(12);

        $expiredTransactions = Transaksi::with('detailTransaksi.kostum')
            ->where('status', 'Menunggu Pembayaran')
            ->where('created_at', '<=', $deadline)
            ->get();

        $count = 0;

        foreach ($expiredTransactions as $transaksi) {
            DB::beginTransaction();
            try {
                // ===============================================
                // Tambahkan kembali stok_aktual karena transaksi auto-canceled
                // ===============================================
                foreach ($transaksi->detailTransaksi as $detail) {
                    if ($detail->kostum) {
                        $size = $detail->ukuran ?? '';
                        $detail->kostum->incrementStokAktual($size, 1);
                    }
                }

                $transaksi->update([
                    'status'        => 'Batal',
                    'catatan_admin' => 'Auto-canceled: Exceeded 12-hour payment deadline',
                ]);

                DB::commit();
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Failed to cancel transaction #{$transaksi->id}: " . $e->getMessage());
            }
        }

        $this->info("Successfully canceled {$count} unpaid bookings.");
    }
}
