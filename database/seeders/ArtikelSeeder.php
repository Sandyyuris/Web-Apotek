<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Carbon\Carbon;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $obatId = KategoriArtikel::where('slug', 'obat')->first()->id_kategori_artikel ?? 1;
        $tipsSehatId = KategoriArtikel::where('slug', 'tips-hidup-sehat')->first()->id_kategori_artikel ?? 2;

        $articles = [
            [
                'id_kategori_artikel' => $obatId, // <-- PERUBAHAN
                'judul' => 'Manfaat Luar Biasa dari Madu untuk Daya Tahan Tubuh',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Obat+Alami',
                'isi' => 'Madu telah lama dikenal sebagai superfood alami yang kaya antioksidan. Selain digunakan sebagai pemanis, madu juga memiliki khasiat luar biasa untuk meningkatkan sistem kekebalan tubuh, melawan infeksi bakteri, dan menenangkan tenggorokan yang sakit. Pilih madu mentah untuk mendapatkan manfaat maksimal.',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'id_kategori_artikel' => $tipsSehatId, // <-- PERUBAHAN
                'judul' => 'Panduan Tidur Cepat dan Nyenyak untuk Kesehatan Mental',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Tidur+Sehat',
                'isi' => 'Kualitas tidur yang buruk dapat berdampak negatif pada kesehatan mental Anda. Praktikkan kebiasaan "kebersihan tidur" seperti menghindari kafein di sore hari, menjaga suhu kamar tetap sejuk, dan membatasi paparan layar biru setidaknya satu jam sebelum tidur.',
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'id_kategori_artikel' => $obatId, // <-- PERUBAHAN
                'judul' => 'Cara Tepat Mengonsumsi Paracetamol untuk Demam Anak',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Obat+Demam',
                'isi' => 'Paracetamol adalah obat penurun demam yang umum. Namun, dosis yang tepat sangat krusial, terutama untuk anak-anak. Selalu hitung dosis berdasarkan berat badan anak, bukan hanya usia, dan jangan pernah melebihi dosis harian maksimum yang dianjurkan oleh dokter atau apoteker.',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'id_kategori_artikel' => $tipsSehatId, // <-- PERUBAHAN
                'judul' => '5 Resep Smoothie Sehat untuk Sarapan Cepat',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Resep+Sehat',
                'isi' => 'Smoothie adalah cara terbaik untuk mendapatkan nutrisi dengan cepat. Coba kombinasi seperti bayam, pisang, dan biji chia untuk energi, atau buah beri, yogurt, dan madu untuk antioksidan. Jangan lupakan protein untuk membuat Anda kenyang lebih lama.',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'id_kategori_artikel' => $obatId, // <-- PERUBAHAN
                'judul' => 'Mengenal Bahaya Antibiotik jika Dikonsumsi Berlebihan',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Antibiotik',
                'isi' => 'Penggunaan antibiotik yang tidak tepat atau berlebihan adalah penyebab utama resistensi antibiotik, ancaman kesehatan global. Antibiotik hanya efektif melawan bakteri, bukan virus. Konsumsi sesuai resep dokter dan habiskan seluruh dosis yang diberikan.',
                'created_at' => Carbon::now()->subDay(1),
            ],
            [
                'id_kategori_artikel' => $tipsSehatId, // <-- PERUBAHAN
                'judul' => 'Yoga Pagi: 10 Menit Gerakan untuk Meningkatkan Energi',
                'path_foto' => 'https://via.placeholder.com/400x250?text=Yoga+Pagi',
                'isi' => 'Memulai hari dengan yoga 10 menit dapat meningkatkan fleksibilitas dan energi. Beberapa gerakan sederhana seperti Surya Namaskar (Salam Matahari) atau Mountain Pose dapat membantu membangunkan tubuh dan mempersiapkan mental untuk aktivitas harian.',
                'created_at' => Carbon::now(),
            ],
            ];

        foreach ($articles as $articleData) {
            Artikel::create($articleData);
        }
    }
}
