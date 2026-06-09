<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Actions\Action;

class Laporan extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected string $view = 'filament.pages.laporan';

    protected static ?string $title = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan';

    public array $stats = [];
    public array $popularDestinations = [];

    public function mount(): void
    {
        // 1. Booking Stats
        $bookingsGrouped = Booking::select('status', DB::raw('count(*) as count'), DB::raw('sum(total_bayar) as total_amount'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $this->stats['bookings_total'] = Booking::count();
        $this->stats['bookings_paid'] = $bookingsGrouped->get('dibayar')?->count ?? 0;
        $this->stats['bookings_confirmed'] = $bookingsGrouped->get('dikonfirmasi')?->count ?? 0;
        $this->stats['bookings_pending'] = $bookingsGrouped->get('pending')?->count ?? 0;
        $this->stats['bookings_cancelled'] = $bookingsGrouped->get('dibatalkan')?->count ?? 0;
        $this->stats['bookings_success'] = $this->stats['bookings_paid'] + $this->stats['bookings_confirmed'];

        // 2. Revenue Stats
        $this->stats['revenue_total'] = ($bookingsGrouped->get('dibayar')?->total_amount ?? 0) + ($bookingsGrouped->get('dikonfirmasi')?->total_amount ?? 0);
        $this->stats['revenue_pending'] = $bookingsGrouped->get('pending')?->total_amount ?? 0;
        $this->stats['revenue_cancelled'] = $bookingsGrouped->get('dibatalkan')?->total_amount ?? 0;

        // 3. User Stats
        $this->stats['users_total'] = User::count();
        $this->stats['users_new_30d'] = User::where('created_at', '>=', now()->subDays(30))->count();
        $this->stats['users_growth'] = $this->stats['users_total'] > 0 ? round(($this->stats['users_new_30d'] / $this->stats['users_total']) * 100, 1) : 0;

        // 4. Popular Destinations
        $this->popularDestinations = DB::table('bookings')
            ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
            ->join('destinasis', 'jadwals.destinasi_id', '=', 'destinasis.id')
            ->select('destinasis.nama', DB::raw('count(bookings.id) as total_bookings'), DB::raw('sum(bookings.total_bayar) as total_revenue'))
            ->whereIn('bookings.status', ['dibayar', 'dikonfirmasi'])
            ->groupBy('destinasis.id', 'destinasis.nama')
            ->orderByDesc('total_bookings')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\LaporanStatsOverview::class,
            \App\Filament\Widgets\PopularDestinationsTable::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')
                ->label('Ekspor Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    return response()->streamDownload(function () {
                        // Create spreadsheet
                        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setTitle('Statistik Laporan');

                        // Style helper arrays
                        $titleStyle = [
                            'font' => [
                                'bold' => true,
                                'size' => 14,
                            ],
                        ];
                        $sectionStyle = [
                            'font' => [
                                'bold' => true,
                                'size' => 11,
                            ],
                        ];
                        $headerStyle = [
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '1B6DFF'],
                            ],
                        ];

                        // 1. Header & Title
                        $sheet->setCellValue('A1', 'LAPORAN STATISTIK TRIP WEB');
                        $sheet->getStyle('A1')->applyFromArray($titleStyle);
                        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . now()->toDateTimeString());
                        
                        // Query Data (Booking Stats)
                        $bookingsGrouped = Booking::select('status', DB::raw('count(*) as count'), DB::raw('sum(total_bayar) as total_amount'))
                            ->groupBy('status')
                            ->get()
                            ->keyBy('status');

                        $bookingsTotal = Booking::count();
                        $bookingsPaid = $bookingsGrouped->get('dibayar')?->count ?? 0;
                        $bookingsConfirmed = $bookingsGrouped->get('dikonfirmasi')?->count ?? 0;
                        $bookingsPending = $bookingsGrouped->get('pending')?->count ?? 0;
                        $bookingsCancelled = $bookingsGrouped->get('dibatalkan')?->count ?? 0;
                        $bookingsSuccess = $bookingsPaid + $bookingsConfirmed;

                        // 2. Booking Stats Block
                        $sheet->setCellValue('A4', 'I. STATISTIK PEMESANAN');
                        $sheet->getStyle('A4')->applyFromArray($sectionStyle);
                        $sheet->setCellValue('A5', 'Kategori');
                        $sheet->setCellValue('B5', 'Jumlah');
                        $sheet->getStyle('A5:B5')->applyFromArray($headerStyle);
                        
                        $sheet->setCellValue('A6', 'Total Pemesanan');
                        $sheet->setCellValue('B6', $bookingsTotal);
                        $sheet->setCellValue('A7', 'Pemesanan Berhasil');
                        $sheet->setCellValue('B7', $bookingsSuccess);
                        $sheet->setCellValue('A8', 'Menunggu Pembayaran');
                        $sheet->setCellValue('B8', $bookingsPending);
                        $sheet->setCellValue('A9', 'Pemesanan Dibatalkan');
                        $sheet->setCellValue('B9', $bookingsCancelled);

                        // 3. Revenue Stats Block
                        $revenueTotal = ($bookingsGrouped->get('dibayar')?->total_amount ?? 0) + ($bookingsGrouped->get('dikonfirmasi')?->total_amount ?? 0);
                        $revenuePending = $bookingsGrouped->get('pending')?->total_amount ?? 0;
                        $revenueCancelled = $bookingsGrouped->get('dibatalkan')?->total_amount ?? 0;

                        $sheet->setCellValue('A11', 'II. STATISTIK PEMASUKAN');
                        $sheet->getStyle('A11')->applyFromArray($sectionStyle);
                        $sheet->setCellValue('A12', 'Kategori');
                        $sheet->setCellValue('B12', 'Jumlah (IDR)');
                        $sheet->getStyle('A12:B12')->applyFromArray($headerStyle);
                        
                        $sheet->setCellValue('A13', 'Pemasukan Berhasil');
                        $sheet->setCellValue('B13', $revenueTotal);
                        $sheet->setCellValue('A14', 'Pemasukan Pending');
                        $sheet->setCellValue('B14', $revenuePending);
                        $sheet->setCellValue('A15', 'Potensi Hilang (Batal)');
                        $sheet->setCellValue('B15', $revenueCancelled);
                        
                        // Format Revenue numbers
                        $sheet->getStyle('B13:B15')->getNumberFormat()->setFormatCode('#,##0');

                        // 4. User Stats Block
                        $usersTotal = User::count();
                        $usersNew30d = User::where('created_at', '>=', now()->subDays(30))->count();
                        $growth = $usersTotal > 0 ? round(($usersNew30d / $usersTotal) * 100, 1) : 0;

                        $sheet->setCellValue('A17', 'III. STATISTIK PENGGUNA');
                        $sheet->getStyle('A17')->applyFromArray($sectionStyle);
                        $sheet->setCellValue('A18', 'Kategori');
                        $sheet->setCellValue('B18', 'Jumlah / Persentase');
                        $sheet->getStyle('A18:B18')->applyFromArray($headerStyle);
                        
                        $sheet->setCellValue('A19', 'Total Pengguna Terdaftar');
                        $sheet->setCellValue('B19', $usersTotal);
                        $sheet->setCellValue('A20', 'Pengguna Baru (30 Hari)');
                        $sheet->setCellValue('B20', $usersNew30d);
                        $sheet->setCellValue('A21', 'Rasio Pertumbuhan');
                        $sheet->setCellValue('B21', $growth . '%');

                        // 5. Popular Destinations Block
                        $popularDestinations = DB::table('bookings')
                            ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
                            ->join('destinasis', 'jadwals.destinasi_id', '=', 'destinasis.id')
                            ->select('destinasis.nama', DB::raw('count(bookings.id) as total_bookings'), DB::raw('sum(bookings.total_bayar) as total_revenue'))
                            ->whereIn('bookings.status', ['dibayar', 'dikonfirmasi'])
                            ->groupBy('destinasis.id', 'destinasis.nama')
                            ->orderByDesc('total_bookings')
                            ->get();

                        $sheet->setCellValue('A23', 'IV. DESTINASI TERPOPULER');
                        $sheet->getStyle('A23')->applyFromArray($sectionStyle);
                        $sheet->setCellValue('A24', 'Nama Destinasi');
                        $sheet->setCellValue('B24', 'Jumlah Pemesanan');
                        $sheet->setCellValue('C24', 'Total Pendapatan (IDR)');
                        $sheet->getStyle('A24:C24')->applyFromArray($headerStyle);
                        
                        $row = 25;
                        foreach ($popularDestinations as $dest) {
                            $sheet->setCellValue('A' . $row, $dest->nama);
                            $sheet->setCellValue('B' . $row, $dest->total_bookings . ' x');
                            $sheet->setCellValue('C' . $row, $dest->total_revenue);
                            $row++;
                        }
                        
                        // Format Popular Destinations Revenue numbers
                        if ($row > 25) {
                            $sheet->getStyle('C25:C' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');
                        }

                        // Auto-fit column width for A, B, C
                        foreach (range('A', 'C') as $col) {
                            $sheet->getColumnDimension($col)->setAutoSize(true);
                        }

                        // Save Excel to output stream
                        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                        $writer->save('php://output');
                    }, 'laporan_statistik_' . now()->format('Y-m-d') . '.xlsx', [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
                }),
            Action::make('print')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->extraAttributes([
                    'onclick' => 'window.print()',
                ]),
        ];
    }
}
