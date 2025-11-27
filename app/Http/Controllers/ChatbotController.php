<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatBotController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;

        return view('chatbot.index', [
            'title' => 'AI Asisten Apoteker',
            'userName' => $userName
        ]);
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        $userName = Auth::check() ? Auth::user()->name : 'Pelanggan';

        $produks = Produk::with(['kategori', 'satuan'])->get();

        $productList = "";
        if ($produks->count() > 0) {
            foreach ($produks as $produk) {
                $kategori = $produk->kategori->nama_kategori ?? 'Umum';
                $satuan = $produk->satuan->nama_satuan ?? 'Pcs';
                $deskripsi = substr($produk->deskripsi ?? 'Tidak ada deskripsi.', 0, 150) . '...';

                $productList .= "- Nama Produk: {$produk->nama_produk} (Kategori: {$kategori}). Harga Jual: Rp" . number_format($produk->harga_jual) . ". Stok Tersedia: {$produk->stok} {$satuan}. Deskripsi Singkat: {$deskripsi}\n";
            }
        } else {
            $productList = "Saat ini tidak ada data produk di sistem kami. Informasikan kepada pelanggan bahwa kamu tidak memiliki data produk.";
        }

        $systemContext = "
            PERAN:
            Kamu adalah 'Asisten Apoteker AI' yang bertugas di Apotek Web 'SHANN APOTEK'. Kamu adalah chatbot yang profesional, informatif, ramah, dan mengutamakan kesehatan serta keselamatan pelanggan.

            ATURAN PENTING:
            1. JANGAN PERNAH merekomendasikan produk yang TIDAK ADA di daftar data 'DATA PRODUK APOTEK' di bawah ini. Jika user menanyakan produk yang tidak ada (misalnya obat di luar data), informasikan bahwa produk tersebut belum tersedia di stok, lalu tawarkan produk serupa (jika ada) dari daftar yang ADA, dengan menyebutkan nama, harga, dan stoknya.
            2. Selalu bersikap sopan dan ramah. Panggil pengguna HANYA dengan nama mereka: '{$userName}' di setiap balasan, dan HINDARI menggunakan 'Bapak/Ibu' untuk menyapa pengguna.
            3. Jaga jawaban tetap ringkas, jelas, dan fokus pada informasi dari data produk.

            DATA PRODUK APOTEK YANG TERSEDIA (Hafalkan ini):
            {$productList}

            TUGAS:
            Jawablah pertanyaan user ini berdasarkan data produk di atas, meliputi ketersediaan, harga, atau deskripsi produk.
        ";

        $model = 'gemini-2.5-flash';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $systemContext . "\n\nPertanyaan User: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API call failed', ['status' => $response->status(), 'response' => $response->body()]);
                return response()->json(['reply' => "Mohon maaf, terjadi gangguan pada sistem AI. Silakan coba beberapa saat lagi."]);
            }

            $data = $response->json();
            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Mohon maaf, saya kurang mengerti pertanyaan Anda. Bisa diulang?';
            return response()->json(['reply' => $aiReply]);

        } catch (\Exception $e) {
            Log::error('Error in sendMessage: ' . $e->getMessage());
            return response()->json(['reply' => "Terjadi masalah internal. Mohon maaf atas ketidaknyamanannya."]);
        }
    }
}
