<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kostum', function (Blueprint $table) {
            $table->integer('stok_permanen')->default(0)->after('harga_sewa');
            $table->integer('stok_aktual')->default(0)->after('stok_permanen');
            $table->json('stok_permanen_per_ukuran')->nullable()->after('ukuran');
            $table->json('stok_aktual_per_ukuran')->nullable()->after('stok_permanen_per_ukuran');
        });

        // Data Migration
        $kostums = DB::table('kostum')->get();
        foreach ($kostums as $kostum) {
            $stokPermanen = $kostum->stok;
            $stokPermanenPerUkuranStr = $kostum->stok_per_ukuran;
            $stokPermanenPerUkuran = $stokPermanenPerUkuranStr ? json_decode($stokPermanenPerUkuranStr, true) : [];
            
            $stokAktual = $stokPermanen;
            $stokAktualPerUkuran = is_array($stokPermanenPerUkuran) ? $stokPermanenPerUkuran : [];

            // Compute active bookings
            $activeStatuses = ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar', 'Disewa'];
            $activeDetails = DB::table('detail_transaksi')
                ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
                ->where('detail_transaksi.kostum_id', $kostum->id)
                ->whereIn('transaksi.status', $activeStatuses)
                ->select('detail_transaksi.ukuran')
                ->get();
            
            foreach ($activeDetails as $detail) {
                $stokAktual--;
                if ($detail->ukuran && isset($stokAktualPerUkuran[$detail->ukuran])) {
                    $stokAktualPerUkuran[$detail->ukuran]--;
                }
            }
            
            $stokAktual = max(0, $stokAktual);
            foreach ($stokAktualPerUkuran as $k => $v) {
                $stokAktualPerUkuran[$k] = max(0, $v);
            }

            DB::table('kostum')
                ->where('id', $kostum->id)
                ->update([
                    'stok_permanen' => $stokPermanen,
                    'stok_aktual' => $stokAktual,
                    'stok_permanen_per_ukuran' => json_encode($stokPermanenPerUkuran),
                    'stok_aktual_per_ukuran' => json_encode($stokAktualPerUkuran),
                ]);
        }

        Schema::table('kostum', function (Blueprint $table) {
            $table->dropColumn(['stok', 'stok_per_ukuran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kostum', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('harga_sewa');
            $table->json('stok_per_ukuran')->nullable()->after('ukuran');
        });

        $kostums = DB::table('kostum')->get();
        foreach ($kostums as $kostum) {
            DB::table('kostum')
                ->where('id', $kostum->id)
                ->update([
                    'stok' => $kostum->stok_permanen,
                    'stok_per_ukuran' => $kostum->stok_permanen_per_ukuran,
                ]);
        }

        Schema::table('kostum', function (Blueprint $table) {
            $table->dropColumn([
                'stok_permanen',
                'stok_aktual',
                'stok_permanen_per_ukuran',
                'stok_aktual_per_ukuran'
            ]);
        });
    }
};
