<?php

namespace App\Console\Commands;

use App\Services\PaxelService;
use Illuminate\Console\Command;

class PaxelTestConnectionCommand extends Command
{
    protected $signature = 'paxel:test';

    protected $description = 'Test koneksi ke Paxel API (cek ongkir)';

    public function handle(PaxelService $paxelService): int
    {
        $this->info('Testing Paxel API connection...');
        $this->newLine();

        if (!$paxelService->isConfigured()) {
            $this->error('Paxel API belum dikonfigurasi.');
            $this->line('Pastikan PAXEL_API_KEY dan PAXEL_API_SECRET ada di .env');
            return self::FAILURE;
        }

        $this->line('Config: OK');
        $this->line('API URL: ' . config('paxel.api_url'));

        $destination = [
            'address' => 'Jl. Test',
            'province' => 'DKI Jakarta',
            'city' => 'Kota Jakarta Utara',
            'district' => 'Koja',
            'zip_code' => '14270',
        ];

        $result = $paxelService->getRates(
            $destination,
            1000,
            '30x25x15',
            'REGULAR'
        );

        if ($result['success']) {
            $this->newLine();
            $this->info('✓ Koneksi berhasil!');
            $data = $result['data'] ?? [];
            $price = $data['actual_price'] ?? $data['price'] ?? $data['rate'] ?? null;
            if ($price !== null) {
                $this->line('  Ongkir (REGULAR): Rp ' . number_format((float) $price, 0, ',', '.'));
            }
            return self::SUCCESS;
        }

        $this->newLine();
        $this->error('✗ Koneksi gagal');
        $this->line('  Error: ' . ($result['error'] ?? 'Unknown'));
        return self::FAILURE;
    }
}
