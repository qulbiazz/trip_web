<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PublicBookingController extends Controller
{
    public function create($jadwal_id)
    {
        $jadwal = Jadwal::with('destinasi')->findOrFail($jadwal_id);
        
        if ($jadwal->status !== 'tersedia' || $jadwal->sisa_kursi <= 0) {
            return redirect()->route('destinasi.show', $jadwal->destinasi_id)
                ->with('error', 'Maaf, jadwal ini sudah penuh atau tidak tersedia.');
        }

        if (Carbon::parse($jadwal->tanggal_berangkat)->endOfDay()->isPast()) {
            return redirect()->route('destinasi.show', $jadwal->destinasi_id)
                ->with('error', 'Maaf, waktu pemesanan untuk jadwal ini sudah ditutup karena tanggal keberangkatan sudah lewat.');
        }

        $promos = Promo::where('is_aktif', true)
            ->where(function($q) {
                $q->whereNull('expired_at')->orWhereDate('expired_at', '>=', now());
            })->get();

        return view('booking-form', compact('jadwal', 'promos'));
    }

    public function store(Request $request, $jadwal_id)
    {
        $jadwal = Jadwal::with('destinasi')->findOrFail($jadwal_id);

        if ($jadwal->status !== 'tersedia' || $jadwal->sisa_kursi <= 0) {
            return redirect()->route('destinasi.show', $jadwal->destinasi_id)
                ->with('error', 'Maaf, jadwal ini sudah penuh atau tidak tersedia.');
        }

        if (Carbon::parse($jadwal->tanggal_berangkat)->endOfDay()->isPast()) {
            return redirect()->route('destinasi.show', $jadwal->destinasi_id)
                ->with('error', 'Maaf, waktu pemesanan untuk jadwal ini sudah ditutup karena tanggal keberangkatan sudah lewat.');
        }

        $rules = [
            'nama_pelanggan' => 'required|string|max:255',
            'email_pelanggan' => 'required|email|max:255',
            'nomor_handphone' => 'required|string|max:50',
            'jumlah_peserta' => 'required|integer|min:1|max:' . $jadwal->sisa_kursi,
            'promo_id' => 'nullable|exists:promos,id',
        ];

        if (str_contains(strtolower($jadwal->destinasi->nama), 'bromo')) {
            $rules['alamat_penjemputan'] = 'required|string|max:1000';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $total_bayar = $jadwal->destinasi->harga_dasar * $validated['jumlah_peserta'];
            
            if (!empty($validated['promo_id'])) {
                $promo = Promo::find($validated['promo_id']);
                if ($promo && $promo->is_aktif && ($promo->expired_at == null || !Carbon::parse($promo->expired_at)->endOfDay()->isPast())) {
                    if ($promo->tipe_diskon === 'persentase') {
                        $diskon = $total_bayar * ($promo->nilai_diskon / 100);
                        $total_bayar -= $diskon;
                    } else {
                        $total_bayar -= $promo->nilai_diskon;
                    }
                    $total_bayar = max(0, $total_bayar);
                } else {
                    $validated['promo_id'] = null;
                }
            }

            $booking = new Booking();
            $booking->jadwal_id = $jadwal->id;
            $booking->promo_id = $validated['promo_id'] ?? null;
            $booking->nama_pelanggan = $validated['nama_pelanggan'];
            $booking->email_pelanggan = $validated['email_pelanggan'];
            $booking->nomor_handphone = $validated['nomor_handphone'];
            if (isset($validated['alamat_penjemputan'])) {
                $booking->alamat_penjemputan = $validated['alamat_penjemputan'];
            }
            $booking->jumlah_peserta = $validated['jumlah_peserta'];
            $booking->total_bayar = $total_bayar;
            $booking->status = 'pending';
            
            $booking->save();

            DB::commit();

            return redirect()->route('bookings.invoice.show', $booking->id)
                ->with('success', 'Pemesanan berhasil dibuat! Silakan simpan invoice Anda.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal membuat pesanan: ' . $e->getMessage()]);
        }
    }
}
