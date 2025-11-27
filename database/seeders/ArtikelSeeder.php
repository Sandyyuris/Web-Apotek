<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Carbon\Carbon;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori ada, atau buat jika belum ada
        $obat = KategoriArtikel::firstOrCreate(['slug' => 'obat'], ['nama_kategori' => 'Obat']);
        $tips = KategoriArtikel::firstOrCreate(['slug' => 'tips-hidup-sehat'], ['nama_kategori' => 'Tips Hidup Sehat']);

        $fixedPhotoUrl = 'https://res.cloudinary.com/dklm74kwy/image/upload/v1763803959/main-sample.png';

        $articles = [
            [
                'id_kategori_artikel' => $tips->id_kategori_artikel,
                'judul' => '7 Cara Alami Meningkatkan Daya Tahan Tubuh di Musim Hujan',
                'isi' => 'Musim hujan seringkali membawa berbagai penyakit seperti flu dan batuk. Untuk menjaga tubuh tetap fit, pastikan Anda mengonsumsi makanan kaya vitamin C seperti jeruk dan jambu biji. Selain itu, istirahat yang cukup dan rutin berolahraga ringan di dalam rumah juga sangat membantu menjaga imunitas.',
            ],
            [
                'id_kategori_artikel' => $obat->id_kategori_artikel,
                'judul' => 'Mengenal Paracetamol: Manfaat, Dosis, dan Efek Samping',
                'isi' => 'Paracetamol adalah obat analgesik dan antipiretik yang populer digunakan untuk meredakan sakit kepala dan menurunkan demam. Meskipun aman, penggunaan berlebihan dapat merusak hati. Selalu ikuti anjuran dosis pada kemasan atau resep dokter.',
            ],
            [
                'id_kategori_artikel' => $tips->id_kategori_artikel,
                'judul' => 'Pentingnya Minum Air Putih 8 Gelas Sehari',
                'isi' => 'Dehidrasi dapat menyebabkan kelelahan, sakit kepala, dan masalah kulit. Membiasakan minum air putih minimal 8 gelas sehari membantu melancarkan pencernaan, menjaga suhu tubuh, dan meningkatkan konsentrasi.',
            ],
            [
                'id_kategori_artikel' => $obat->id_kategori_artikel,
                'judul' => 'Bahaya Resistensi Antibiotik dan Cara Mencegahnya',
                'isi' => 'Mengonsumsi antibiotik tanpa resep dokter atau tidak menghabiskannya sesuai aturan dapat menyebabkan bakteri menjadi kebal. Ini membuat pengobatan infeksi di masa depan menjadi lebih sulit. Gunakan antibiotik dengan bijak.',
            ],
            [
                'id_kategori_artikel' => $tips->id_kategori_artikel,
                'judul' => 'Manfaat Tidur Cukup bagi Kesehatan Mental',
                'isi' => 'Kurang tidur dapat memicu stres dan kecemasan. Tidur berkualitas selama 7-8 jam setiap malam membantu otak memproses emosi dan memperbaiki sel-sel tubuh yang rusak, sehingga Anda bangun dengan perasaan lebih segar.',
            ],
            [
                'id_kategori_artikel' => $obat->id_kategori_artikel,
                'judul' => 'Cara Mengatasi Maag Kambuh Secara Cepat',
                'isi' => 'Sakit maag bisa sangat mengganggu. Pertolongan pertama yang bisa dilakukan adalah minum air hangat dan mengonsumsi antasida. Hindari makanan pedas, asam, dan berlemak untuk mencegah iritasi lambung lebih lanjut.',
            ],
            [
                'id_kategori_artikel' => $tips->id_kategori_artikel,
                'judul' => 'Olahraga Ringan untuk Pekerja Kantoran',
                'isi' => 'Duduk terlalu lama berbahaya bagi kesehatan. Cobalah melakukan peregangan leher dan punggung setiap 2 jam. Berjalan kaki saat makan siang atau menggunakan tangga alih-alih lift bisa menjadi cara mudah untuk tetap aktif.',
            ],
            [
                'id_kategori_artikel' => $obat->id_kategori_artikel,
                'judul' => 'Perbedaan Obat Generik dan Obat Paten',
                'isi' => 'Banyak yang mengira obat paten lebih ampuh dari generik, padahal kandungan zat aktifnya sama. Perbedaannya terletak pada nama dagang dan harga. Obat generik adalah pilihan ekonomis dengan efektivitas yang setara.',
            ],
            [
                'id_kategori_artikel' => $tips->id_kategori_artikel,
                'judul' => 'Khasiat Madu untuk Kesehatan Kulit Wajah',
                'isi' => 'Madu memiliki sifat antibakteri dan anti-inflamasi alami. Menggunakannya sebagai masker wajah dapat membantu mengurangi jerawat, melembapkan kulit kering, dan memberikan efek glowing alami.',
            ],
            [
                'id_kategori_artikel' => $obat->id_kategori_artikel,
                'judul' => 'Vitamin D: Sumber dan Manfaatnya untuk Tulang',
                'isi' => 'Vitamin D sangat penting untuk penyerapan kalsium. Kekurangan vitamin ini dapat menyebabkan tulang keropos. Sumber terbaiknya adalah sinar matahari pagi, ikan berlemak, dan suplemen jika diperlukan.',
            ],
        ];

        foreach ($articles as $index => $data) {
            Artikel::create([
                'id_kategori_artikel' => $data['id_kategori_artikel'],
                'judul' => $data['judul'],
                'path_foto' => $fixedPhotoUrl,
                'isi' => $data['isi'],
                'created_at' => Carbon::now()->subDays($index),
            ]);
        }
    }
}
