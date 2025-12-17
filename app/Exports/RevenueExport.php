<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $month;
    protected $year;

    // Konstruktor biar bisa filter bulan/tahun
    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil data order yang SUDAH LUNAS (FINISHED) di bulan/tahun tsb
        return Order::with(['user', 'category', 'mandor'])
                    ->where('status', 'FINISHED')
                    ->whereMonth('created_at', $this->month)
                    ->whereYear('created_at', $this->year)
                    ->get();
    }

    /**
     * Judul Kolom (Header)
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Tanggal Pesan',
            'Nama Pemesan',
            'Layanan',
            'Mandor',
            'Status',
            'Total Biaya (Rp)',
        ];
    }

    /**
     * Mapping Data per Baris
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->created_at->format('d-m-Y H:i'),
            $order->user->name,
            $order->category->name,
            $order->mandor->name ?? '-',
            $order->status,
            $order->estimated_cost, // Angka mentah biar bisa di-sum di Excel
        ];
    }

    /**
     * Styling Header (Bold)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}