<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    public function show($slug)
    {
        $page = LegalPage::where('slug', $slug)->first();
        
        // Check if page doesn't exist or is still using the default placeholder text
        $isPlaceholder = !$page || str_contains($page->content, 'tahap penyusunan');
        
        if ($isPlaceholder) {
            $title = '';
            $content = '';
            
            if ($slug === 'privacy-policy') {
                $title = 'Kebijakan Privasi';
                $content = $this->privacyPolicyContent();
            } elseif ($slug === 'terms') {
                $title = 'Syarat & Ketentuan';
                $content = $this->termsContent();
            } else {
                $title = ucwords(str_replace('-', ' ', $slug));
                $content = '<h2>' . $title . '</h2><p>Konten halaman ini sedang dalam tahap penyusunan. Admin dapat mengubah teks ini melalui menu <strong>Legal Pages</strong> di Dashboard Admin.</p>';
            }
            
            if ($page) {
                $page->update([
                    'title' => $title,
                    'content' => $content,
                    'status' => 'Published'
                ]);
            } else {
                $page = LegalPage::create([
                    'slug' => $slug,
                    'title' => $title,
                    'language' => 'ID',
                    'version' => 'v1.0.0',
                    'status' => 'Published',
                    'content' => $content
                ]);
            }
        }
        
        return view('pages.show', compact('page'));
    }

    private function privacyPolicyContent(): string
    {
        return <<<'HTML'
<p>Terakhir diperbarui: 12 Juli 2026</p>

<p>Kebijakan Privasi ini menjelaskan bagaimana <strong>Master Skripsi</strong> (dioperasikan oleh Fayel Intelligence Labs, selanjutnya disebut "Kami") mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan platform kami di <strong>masterskripsi.my.id</strong> dan seluruh layanan terkait.</p>

<h2>1. Informasi yang Kami Kumpulkan</h2>

<h3>1.1. Informasi yang Anda Berikan Secara Langsung</h3>
<ul>
    <li><strong>Data Akun:</strong> Nama lengkap, alamat email, dan kata sandi saat Anda mendaftar akun.</li>
    <li><strong>Data Profil:</strong> Informasi tambahan seperti universitas, program studi, dan foto profil (opsional).</li>
    <li><strong>Konten Pengguna:</strong> Judul penelitian, teks proposal, bab skripsi/tesis, referensi literatur, dan semua konten lain yang Anda masukkan ke dalam platform.</li>
    <li><strong>Data Pembayaran:</strong> Informasi transaksi yang diproses melalui penyedia layanan pembayaran pihak ketiga (Midtrans). Kami <strong>tidak menyimpan</strong> data kartu kredit/debit Anda secara langsung.</li>
</ul>

<h3>1.2. Informasi yang Dikumpulkan Secara Otomatis</h3>
<ul>
    <li><strong>Data Log:</strong> Alamat IP, jenis browser, halaman yang dikunjungi, waktu akses, dan data diagnostik lainnya.</li>
    <li><strong>Cookies:</strong> Kami menggunakan cookies untuk menjaga sesi login dan meningkatkan pengalaman pengguna.</li>
    <li><strong>Data Perangkat:</strong> Jenis perangkat, sistem operasi, dan pengaturan bahasa.</li>
</ul>

<h2>2. Bagaimana Kami Menggunakan Informasi Anda</h2>
<p>Kami menggunakan informasi yang dikumpulkan untuk tujuan berikut:</p>
<ul>
    <li>Menyediakan, mengoperasikan, dan memelihara layanan Master Skripsi.</li>
    <li>Memproses dan mengelola akun serta langganan Anda.</li>
    <li>Menghasilkan konten berbasis AI sesuai permintaan Anda (judul, bab, literatur review).</li>
    <li>Memproses pembayaran dan mengirimkan konfirmasi transaksi.</li>
    <li>Mengirimkan pemberitahuan penting terkait perubahan layanan.</li>
    <li>Menganalisis penggunaan platform untuk peningkatan kualitas layanan.</li>
    <li>Mencegah penipuan dan menjaga keamanan platform.</li>
</ul>

<h2>3. Penggunaan AI dan Pemrosesan Data</h2>
<p>Master Skripsi menggunakan teknologi kecerdasan buatan (AI) dari penyedia pihak ketiga (OpenRouter API) untuk memproses permintaan Anda. Perlu Anda ketahui:</p>
<ul>
    <li>Konten yang Anda masukkan akan dikirim ke API AI pihak ketiga untuk diproses dan menghasilkan output.</li>
    <li>Kami tidak menggunakan konten akademik Anda untuk melatih model AI.</li>
    <li>Hasil output AI bersifat <strong>bantuan referensi</strong> dan bukan pengganti karya ilmiah orisinal Anda.</li>
    <li>Anda bertanggung jawab penuh untuk memverifikasi, mengedit, dan memastikan orisinalitas dari setiap output yang dihasilkan oleh AI.</li>
</ul>

<h2>4. Penyimpanan dan Keamanan Data</h2>
<ul>
    <li>Data Anda disimpan pada server yang aman dengan enkripsi standar industri.</li>
    <li>Kata sandi Anda di-hash menggunakan algoritma bcrypt dan tidak pernah disimpan dalam bentuk teks biasa.</li>
    <li>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang wajar untuk melindungi data Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran.</li>
    <li>Meskipun demikian, tidak ada metode transmisi atau penyimpanan elektronik yang 100% aman, dan kami tidak dapat menjamin keamanan absolut.</li>
</ul>

<h2>5. Berbagi Data dengan Pihak Ketiga</h2>
<p>Kami <strong>tidak menjual</strong> data pribadi Anda kepada pihak ketiga. Kami hanya membagikan data Anda dalam situasi berikut:</p>
<ul>
    <li><strong>Penyedia Layanan Pembayaran:</strong> Midtrans, untuk memproses transaksi pembayaran Anda.</li>
    <li><strong>Penyedia Layanan AI:</strong> OpenRouter, untuk memproses permintaan pembuatan konten.</li>
    <li><strong>Kewajiban Hukum:</strong> Jika diwajibkan oleh hukum, regulasi, proses hukum, atau permintaan pemerintah yang sah.</li>
</ul>

<h2>6. Hak-Hak Anda</h2>
<p>Sebagai pengguna, Anda memiliki hak untuk:</p>
<ul>
    <li><strong>Mengakses</strong> data pribadi Anda yang kami simpan.</li>
    <li><strong>Memperbarui atau memperbaiki</strong> informasi akun Anda melalui halaman Profil.</li>
    <li><strong>Menghapus</strong> akun dan data Anda dengan menghubungi tim support kami.</li>
    <li><strong>Menarik persetujuan</strong> atas pemrosesan data Anda kapan saja.</li>
    <li><strong>Mengajukan keluhan</strong> kepada otoritas perlindungan data yang berwenang.</li>
</ul>

<h2>7. Retensi Data</h2>
<p>Kami menyimpan data pribadi Anda selama akun Anda aktif atau selama diperlukan untuk menyediakan layanan. Jika Anda menghapus akun, kami akan menghapus data pribadi Anda dalam waktu <strong>30 hari kerja</strong>, kecuali jika penyimpanan lebih lanjut diperlukan oleh hukum.</p>

<h2>8. Perlindungan Anak</h2>
<p>Layanan kami tidak ditujukan untuk anak di bawah usia 17 tahun. Kami tidak secara sengaja mengumpulkan data dari anak-anak. Jika Anda mengetahui bahwa seorang anak telah memberikan data pribadi kepada kami, silakan hubungi kami agar kami dapat menghapusnya.</p>

<h2>9. Perubahan Kebijakan Privasi</h2>
<p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan berlaku efektif segera setelah dipublikasikan di halaman ini. Kami akan memberi tahu Anda tentang perubahan material melalui email atau pemberitahuan di platform.</p>

<h2>10. Hubungi Kami</h2>
<p>Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini, silakan hubungi kami melalui:</p>
<ul>
    <li><strong>Email:</strong> admin@masterskripsi.my.id</li>
    <li><strong>Perusahaan:</strong> Fayel Intelligence Labs</li>
</ul>
HTML;
    }

    private function termsContent(): string
    {
        return <<<'HTML'
<p>Terakhir diperbarui: 12 Juli 2026</p>

<p>Selamat datang di <strong>Master Skripsi</strong>. Syarat dan Ketentuan ini mengatur penggunaan Anda atas platform Master Skripsi yang dioperasikan oleh <strong>Fayel Intelligence Labs</strong> ("Kami", "Milik Kami"). Dengan mengakses atau menggunakan layanan kami, Anda menyetujui untuk terikat oleh syarat-syarat ini.</p>

<h2>1. Definisi</h2>
<ul>
    <li><strong>"Platform"</strong> mengacu pada situs web Master Skripsi dan seluruh fitur yang tersedia di dalamnya.</li>
    <li><strong>"Pengguna"</strong> mengacu pada setiap individu yang mendaftar dan menggunakan Platform.</li>
    <li><strong>"Layanan"</strong> mengacu pada seluruh fitur dan fungsi yang disediakan oleh Platform, termasuk namun tidak terbatas pada pembuatan judul, bab, literature review, dan fitur AI lainnya.</li>
    <li><strong>"Konten AI"</strong> mengacu pada seluruh output yang dihasilkan oleh sistem kecerdasan buatan dalam Platform.</li>
</ul>

<h2>2. Persyaratan Penggunaan</h2>
<ul>
    <li>Anda harus berusia minimal <strong>17 tahun</strong> untuk menggunakan layanan kami.</li>
    <li>Anda harus mendaftar akun dengan informasi yang akurat dan terkini.</li>
    <li>Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi akun Anda.</li>
    <li>Anda tidak diizinkan untuk membagikan akun Anda dengan pihak lain.</li>
</ul>

<h2>3. Layanan yang Disediakan</h2>
<p>Master Skripsi menyediakan alat berbasis kecerdasan buatan (AI) untuk <strong>membantu</strong> proses penyusunan karya ilmiah. Layanan kami meliputi:</p>
<ul>
    <li>Generator judul skripsi dan tesis berbasis AI.</li>
    <li>Generator bab/bagian karya ilmiah.</li>
    <li>Pencarian dan review literatur.</li>
    <li>Manajemen proyek penelitian.</li>
</ul>

<h2>4. Batasan Penggunaan & Disclaimer AI</h2>
<p><strong>PENTING:</strong> Anda harus memahami dan menyetujui hal-hal berikut:</p>
<ul>
    <li>Konten AI yang dihasilkan oleh Platform bersifat <strong>referensi dan alat bantu</strong>, bukan karya ilmiah final.</li>
    <li>Copyright/Hak Cipta output AI tetap menjadi tanggung jawab penuh pengguna.</li>
    <li>Anda <strong>wajib memverifikasi</strong>, mengedit, dan menyesuaikan seluruh output AI sebelum menggunakannya dalam karya akademik Anda.</li>
    <li>Master Skripsi <strong>tidak menjamin</strong> akurasi, kelengkapan, atau orisinalitas dari konten yang dihasilkan AI.</li>
    <li>Anda bertanggung jawab penuh atas penggunaan konten AI dalam karya akademik Anda, termasuk terhadap aturan anti-plagiarisme dari institusi Anda.</li>
    <li>Kami <strong>tidak bertanggung jawab</strong> atas konsekuensi akademik, hukum, atau profesional yang timbul dari penggunaan output AI secara langsung tanpa modifikasi.</li>
</ul>

<h2>5. Hak Kekayaan Intelektual</h2>
<ul>
    <li><strong>Konten Anda:</strong> Anda mempertahankan hak atas konten orisinal yang Anda masukkan ke dalam Platform.</li>
    <li><strong>Output AI:</strong> Output yang dihasilkan oleh AI dapat digunakan oleh Anda untuk tujuan akademik, namun Anda memahami bahwa output serupa dapat dihasilkan untuk pengguna lain.</li>
    <li><strong>Platform:</strong> Seluruh hak kekayaan intelektual atas Platform (desain, kode, merek dagang) adalah milik Fayel Intelligence Labs.</li>
</ul>

<h2>6. Langganan dan Pembayaran</h2>
<ul>
    <li>Beberapa fitur Platform memerlukan langganan berbayar.</li>
    <li>Harga dan paket langganan tertera pada halaman Langganan dan dapat berubah dengan pemberitahuan sebelumnya.</li>
    <li>Pembayaran diproses melalui penyedia layanan pihak ketiga (Midtrans).</li>
    <li>Langganan berlaku sesuai periode yang dipilih dan <strong>tidak diperpanjang otomatis</strong> kecuali dinyatakan lain.</li>
</ul>

<h2>7. Kebijakan Pengembalian Dana</h2>
<ul>
    <li>Pengembalian dana dapat diminta dalam waktu <strong>7 hari</strong> setelah pembayaran jika Anda belum menggunakan fitur AI secara signifikan.</li>
    <li>Permintaan pengembalian dana akan diproses dalam waktu <strong>14 hari kerja</strong>.</li>
    <li>Kami berhak menolak pengembalian dana jika layanan telah digunakan secara substansial.</li>
</ul>

<h2>8. Larangan Penggunaan</h2>
<p>Anda dilarang menggunakan Platform untuk:</p>
<ul>
    <li>Melanggar hukum atau regulasi yang berlaku.</li>
    <li>Menghasilkan konten yang bersifat menyesatkan, memfitnah, atau melanggar hak pihak lain.</li>
    <li>Melakukan reverse engineering, scraping, atau menyalahgunakan API Platform.</li>
    <li>Mendistribusikan ulang output AI secara komersial tanpa izin tertulis.</li>
    <li>Menggunakan Platform untuk tujuan yang melanggar kebijakan integritas akademik.</li>
</ul>

<h2>9. Penghentian Layanan</h2>
<ul>
    <li>Kami berhak menangguhkan atau menghentikan akun Anda jika terjadi pelanggaran terhadap Syarat & Ketentuan ini.</li>
    <li>Anda dapat menghentikan penggunaan layanan dan menghapus akun Anda kapan saja.</li>
</ul>

<h2>10. Pembatasan Tanggung Jawab</h2>
<p>Sejauh diizinkan oleh hukum yang berlaku, Master Skripsi dan Fayel Intelligence Labs <strong>tidak bertanggung jawab</strong> atas:</p>
<ul>
    <li>Kerugian tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan Platform.</li>
    <li>Gangguan layanan, kehilangan data, atau ketidakakuratan output AI.</li>
    <li>Tindakan pihak ketiga, termasuk penyedia layanan pembayaran dan AI.</li>
</ul>

<h2>11. Hukum yang Berlaku</h2>
<p>Syarat & Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum <strong>Republik Indonesia</strong>. Setiap perselisihan yang timbul akan diselesaikan melalui musyawarah mufakat terlebih dahulu, dan jika tidak tercapai, akan diselesaikan melalui pengadilan yang berwenang di Indonesia.</p>

<h2>12. Perubahan Syarat & Ketentuan</h2>
<p>Kami berhak untuk mengubah Syarat & Ketentuan ini kapan saja. Perubahan akan berlaku efektif segera setelah dipublikasikan di halaman ini. Penggunaan Platform secara berkelanjutan setelah perubahan dianggap sebagai persetujuan Anda terhadap syarat yang diperbarui.</p>

<h2>13. Hubungi Kami</h2>
<p>Jika Anda memiliki pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami:</p>
<ul>
    <li><strong>Email:</strong> admin@masterskripsi.my.id</li>
    <li><strong>Perusahaan:</strong> Fayel Intelligence Labs</li>
</ul>
HTML;
    }
}
