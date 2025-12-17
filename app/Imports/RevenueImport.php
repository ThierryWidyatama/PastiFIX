<?php

namespace App\Imports;

use App\Models\ImportedRevenue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RevenueImport implements ToModel, WithHeadingRow
{
    /**
     * Mapping data Excel ke Database
     */
    public function model(array $row)
    {
        // Debugging? Uncomment ini kalau mau lihat isi barisnya
        // dd($row); 

        // Variabel penampung
        $date = null;
        $amount = null;
        $description = 'Imported Data';

        // SKENARIO 1: Template Manual (Header: Tanggal, Jumlah, Keterangan)
        // Library mengubah header jadi lowercase: 'tanggal', 'jumlah', 'keterangan'
        if (isset($row['tanggal']) && isset($row['jumlah'])) {
            $date = $row['tanggal'];
            $amount = $row['jumlah'];
            $description = $row['keterangan'] ?? 'Manual Import';
        }
        
        // SKENARIO 2: File Export (Header: Tanggal Pesan, Total Biaya (Rp))
        // Library mengubah header jadi: 'tanggal_pesan', 'total_biaya_rp'
        elseif (isset($row['tanggal_pesan'])) {
            $date = $row['tanggal_pesan'];
            // Cari kolom duit (bisa 'total_biaya_rp' atau 'total_biaya')
            $amount = $row['total_biaya_rp'] ?? $row['total_biaya'] ?? 0;
            
            $nama = $row['nama_pemesan'] ?? 'User';
            $layanan = $row['layanan'] ?? 'Service';
            $description = "Backup: $layanan - $nama";
        }
        
        // Kalau gak nemu kolom yang pas, skip baris ini
        else {
            return null;
        }

        // PARSING TANGGAL (PENTING!)
        try {
            if (is_numeric($date)) {
                // Jika Excel mengirim Serial Number (45234) -> Aman, Excel yang handle
                $finalDate = Date::excelToDateTimeObject($date)->format('Y-m-d');
            } else {
                // Jika Excel mengirim Teks
                // Kita coba paksa baca format Indonesia (dd/mm/yyyy) dulu
                try {
                    // Ganti separator lain (.-) jadi slash (/) biar seragam
                    $dateFixed = str_replace(['-', '.'], '/', $date); 
                    $finalDate = Carbon::createFromFormat('d/m/Y', $dateFixed)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Kalau gagal (mungkin formatnya udah Y-m-d), coba parse biasa
                    $finalDate = Carbon::parse($date)->format('Y-m-d');
                }
            }
        } catch (\Exception $e) {
            return null; // Tanggal tidak valid, skip
        }

        // BERSIHKAN JUMLAH UANG (Hapus "Rp", Titik, Koma)
        $cleanAmount = preg_replace('/[^0-9]/', '', $amount);

        // SIMPAN
        return new ImportedRevenue([
            'id' => Str::uuid(),
            'revenue_date' => $finalDate,
            'amount' => $cleanAmount,
            'description' => $description,
        ]);
    }
}