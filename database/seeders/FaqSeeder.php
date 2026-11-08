<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi 40 data FAQ PraxisFit (8 judul kategori x 5 FAQ)
     * menggunakan bahasa Indonesia kasual-profesional dan 100% sumber kredibel asal Indonesia.
     */
    public function run(): void
    {
        // Bersihkan data FAQ lama agar referensi luar negeri tergantikan sepenuhnya
        Faq::truncate();

        $faqs = [
            // =========================================================================
            // 1. JUDUL: Panduan Fitur PraxisFit (panduan_praxisfit) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Gimana sih cara pakai fitur Kalkulator Protein harian di PraxisFit biar target otot cepat tercapai?',
                'jawaban_singkat' => 'Gampang banget! Pertama, buka menu Kalkulator Protein lalu lengkapi verifikasi data fisik Anda (berat badan, tinggi badan, dan jenis kelamin) supaya sistem bisa menghitung target protein harian yang pas buat tubuh Anda. Setelah itu, pilih bahan makanan yang baru Anda konsumsi dari daftar (seperti dada ayam, telur, tahu, atau tempe), ketik berat porsinya dalam satuan gram, lalu klik "Simpan ke Log". Sistem bakal otomatis menghitung kandungan proteinnya dan mengupdate sisa target harian Anda secara real-time.',
                'contoh' => 'Misalnya sehabis latihan Anda makan 150 gram Dada Ayam Fillet (~46,5g protein) dan 100 gram Tempe Murni (~19g protein). Tinggal masukkan keduanya ke log, maka 65,5 gram protein langsung tercatat mengurangi sisa target harian Anda.',
                'sumber_nama' => 'Kementerian Kesehatan RI - Tabel Komposisi Pangan Indonesia (TKPI) & dr. Dion Haryadi, PN1',
                'sumber_url' => 'https://panganku.org/',
                'kategori' => 'panduan_praxisfit',
            ],
            [
                'pertanyaan' => 'Bagaimana cara menyusun dan mengatur Katalog Gerakan ke dalam Jadwal Latihan mingguan saya?',
                'jawaban_singkat' => 'Buka menu Jadwal Latihan (Rutinku) dari bilah navigasi atas, lalu klik tombol "Tambah Jadwal Latihan" atau tombol "+ Tambah Ke [Hari]". Di jendela yang muncul, cari gerakan yang Anda inginkan lewat kotak pencarian yang sudah dilengkapi preview animasi, pilih hari latihan (Senin sampai Minggu), lalu isi jumlah Set, target Repetisi, serta catatan strategi latihan Anda sebelum menekan tombol Simpan.',
                'contoh' => 'Anda bisa mengatur hari Senin fokus otot dada & lengan (Push Up 4 set x 12 repetisi), lalu mengatur hari Selasa fokus otot kaki (Squat 4 set x 12 repetisi) agar jadwal latihan rapi sepanjang minggu.',
                'sumber_nama' => 'Ade Rai (Binaragawan Natural & Edukator Kebugaran Indonesia) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/olahraga',
                'kategori' => 'panduan_praxisfit',
            ],
            [
                'pertanyaan' => 'Gimana cara membaca panduan postur dan melihat demonstrasi gerakan yang benar di Katalog?',
                'jawaban_singkat' => 'Cukup buka menu Katalog Gerakan, gunakan filter kelompok otot di bagian atas, lalu klik kartu gerakan yang ingin Anda pelajari. Pada jendela detail gerakan, perhatikan peragaan animasi gerakan dari awal sampai akhir, lalu baca langkah "Instruksi Eksekusi" secara berurutan. Jika ada kata bergaris bawah putus-putus (seperti eccentric, core, tempo, atau failure), klik kata tersebut untuk membuka pop-up kamus penjelasan istilah medis secara instan.',
                'contoh' => 'Saat membuka detail gerakan Push Up dan mengklik kata "eccentric", akan muncul penjelasan bahwa fase tersebut adalah gerakan menahan tubuh turun secara perlahan demi mengoptimalkan kerja serat otot.',
                'sumber_nama' => 'dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'panduan_praxisfit',
            ],
            [
                'pertanyaan' => 'Saya masih pemula dan bingung meracik jadwal sendiri, apakah PraxisFit punya rekomendasi jadwal otomatis?',
                'jawaban_singkat' => 'Tentu ada! Anda tinggal masuk ke halaman Profil setelah login, lengkapi data fisik Anda, lalu pilih salah satu "Tujuan Latihan" yang tersedia—misalnya fokus pembentukan otot (Hypertrophy / Bulking Upper-Lower Split) atau pembakaran lemak (Fat Loss / Cutting Full Body HIIT). Begitu Anda klik "Simpan & Terapkan Rutinitas", jadwal di menu Rutinku akan langsung terisi otomatis!',
                'contoh' => 'Jika Anda memilih tujuan Fat Loss / Cutting, sistem otomatis menyusun sesi latihan sirkuit Full Body di hari Senin, Rabu, dan Jumat lengkap dengan jumlah set dan jeda istirahatnya.',
                'sumber_nama' => 'Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/latihan-kekuatan/',
                'kategori' => 'panduan_praxisfit',
            ],
            [
                'pertanyaan' => 'Kalau salah ketik berat makanan atau ingin mengubah target repetisi di jadwal, apakah datanya bisa diedit?',
                'jawaban_singkat' => 'Bisa banget kapan saja! Baik di halaman Kalkulator Protein maupun di halaman Jadwal Latihan (Rutinku), setiap catatan yang sudah tersimpan dilengkapi tombol "Edit" dan "Hapus". Anda tinggal klik "Edit" pada baris makanan atau kartu gerakan yang ingin diperbaiki, sesuaikan angkanya, lalu simpan kembali—total capaian protein maupun jadwal mingguan Anda langsung ter-update otomatis.',
                'contoh' => 'Tadinya Anda mencatat 100 gram telur rebus padahal yang dimakan 150 gram; cukup klik tombol Edit di tabel riwayat nutrisi, ubah menjadi 150 gram, lalu klik Perbarui Log.',
                'sumber_nama' => 'Kementerian Kesehatan RI - Pedoman Gizi Seimbang (Ayo Sehat Kemenkes)',
                'sumber_url' => 'https://ayosehat.kemkes.go.id/',
                'kategori' => 'panduan_praxisfit',
            ],

            // =========================================================================
            // 2. JUDUL: Seputar Latihan (latihan) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Apa sih bedanya Set dan Repetisi (Reps), dan berapa angka yang pas buat pemula?',
                'jawaban_singkat' => 'Repetisi (Reps) adalah satu kali hitungan gerakan penuh dari posisi awal hingga kembali lagi, sedangkan Set adalah sekumpulan repetisi yang dilakukan berturut-turut sebelum Anda istirahat sejenak. Buat pemula yang ingin membentuk otot sekaligus menjaga keamanan sendi, kisaran 3–4 set dengan 8–12 repetisi per gerakan adalah titik paling ideal.',
                'contoh' => 'Tertulis "3 Set x 10 Reps" artinya Anda melakukan 10 kali gerakan Push Up tanpa henti, istirahat sekitar 60–90 detik, lalu mengulanginya sampai total 3 putaran.',
                'sumber_nama' => 'dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'latihan',
            ],
            [
                'pertanyaan' => 'Apa itu prinsip Progressive Overload dan kenapa sering disebut kunci utama membesarkan otot?',
                'jawaban_singkat' => 'Progressive overload adalah cara meningkatkan tantangan latihan secara bertahap dari waktu ke waktu agar otot terus beradaptasi menjadi lebih kuat dan padat. Kalau beban, jumlah repetisi, atau tingkat kesulitan gerakan Anda sama terus selama berbulan-bulan, tubuh akan merasa nyaman dan tidak lagi punya alasan untuk menebalkan jaringan otot.',
                'contoh' => 'Minggu lalu Anda kuat Squat 3 set x 10 repetisi. Minggu ini, tingkatkan menjadi 3 set x 12 repetisi, perlambat tempo turunnya menjadi 3 detik, atau tambahkan beban tas ransel.',
                'sumber_nama' => 'Ade Rai (Binaragawan Natural & Edukator Kebugaran Indonesia) via KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'latihan',
            ],
            [
                'pertanyaan' => 'Seberapa sering frekuensi latihan beban yang paling optimal dalam satu minggu?',
                'jawaban_singkat' => 'Secara medis dan fisiologi olahraga, melatih setiap kelompok otot sebanyak 2 kali seminggu terbukti memberikan rangsangan pembentukan otot yang lebih optimal dibanding hanya 1 kali seminggu. Bagi pemula, berlatih total 3–4 hari per minggu sudah sangat bagus karena memberi keseimbangan antara latihan intens dan waktu pemulihan tubuh.',
                'contoh' => 'Jadwal Senin (Upper Body), Selasa (Lower Body), Rabu (Istirahat), Kamis (Upper Body), dan Jumat (Lower Body) membuat setiap otot terlatih 2 kali seminggu dengan efektif.',
                'sumber_nama' => 'dr. Sophia Hage, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'latihan',
            ],
            [
                'pertanyaan' => 'Kalau ingin membakar lemak sekaligus menjaga otot, sebaiknya kardio sebelum atau sesudah angkat beban?',
                'jawaban_singkat' => 'Sebaiknya lakukan kardio SETELAH sesi latihan beban selesai, atau lakukan di hari yang berbeda. Melakukan kardio berat sebelum latihan beban akan menguras cadangan energi gula otot (glikogen) lebih dulu, sehingga tenaga Anda justru habis saat harus mengeksekusi gerakan angkatan utama dengan postur yang stabil.',
                'contoh' => 'Fokuskan tenaga penuh untuk latihan beban/calisthenics selama 35–45 menit terlebih dahulu, lalu tutup sesi dengan jalan cepat atau jogging ringan selama 15–20 menit.',
                'sumber_nama' => 'Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/olahraga',
                'kategori' => 'latihan',
            ],
            [
                'pertanyaan' => 'Apakah setiap set latihan harus selalu dipaksa sampai "Failure" (benar-benar gagal angkat)?',
                'jawaban_singkat' => 'Tidak harus di setiap set! Berlatih terus-menerus sampai gagal mutlak di semua set justru cepat membuat sistem saraf kelelahan dan meningkatkan risiko postur berantakan. Menyisakan sekitar 1 hingga 2 repetisi cadangan sebelum gagal (masih sanggup 1–2 angkatan rapi lagi) sudah memberikan stimulus pertumbuhan otot yang setara namun jauh lebih aman.',
                'contoh' => 'Jika batas maksimal Push Up Anda adalah 15 kali sampai ambruk, berhentilah di hitungan ke-13 atau ke-14 pada set awal, dan simpan tenaga maksimal untuk set terakhir saja.',
                'sumber_nama' => 'dr. Michael Triangto, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'latihan',
            ],

            // =========================================================================
            // 3. JUDUL: Latihan di Rumah (Home Workout) (latihan_di_rumah) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Apakah latihan di rumah dengan alat seadanya benar-benar efektif membentuk otot seperti di gym?',
                'jawaban_singkat' => 'Sangat efektif! Otot manusia tidak punya mata untuk melihat apakah beban yang Anda angkat berasal dari mesin gym mahal atau barang rumahan—serat otot hanya merespons tegangan mekanik dan konsistensi latihan. Manfaatkan informasi "Alternatif Alat (Home Workout)" pada Katalog Gerakan PraxisFit agar latihan di rumah tetap menantang.',
                'contoh' => 'Memasukkan beberapa buku tebal atau botol air penuh ke dalam tas ransel saat melakukan Squat atau Push Up memberikan beban tambahan nyata yang merangsang pertumbuhan otot.',
                'sumber_nama' => 'Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'latihan_di_rumah',
            ],
            [
                'pertanyaan' => 'Saya belum kuat melakukan Pull-Up murni sama sekali, gerakan apa yang cocok untuk melatihnya bertahap?',
                'jawaban_singkat' => 'Jangan berkecil hati, itu sangat wajar! Mulailah dengan variasi regresi seperti Negative Pull-Up (fokus menahan badan turun perlahan) atau Australian/Inverted Row. Menahan fase turun secara terkontrol terbukti sangat ampuh melatih kekuatan saraf serta otot punggung dan lengan sebelum Anda sanggup menarik berat badan penuh ke atas.',
                'contoh' => 'Gunakan pijakan kursi kecil untuk membantu posisi dagu di atas palang pintu, lalu turunkan tubuh Anda perlahan-lahan selama 3–5 detik pada setiap repetisi.',
                'sumber_nama' => 'Ade Rai & Tim Edukasi Kebugaran Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'latihan_di_rumah',
            ],
            [
                'pertanyaan' => 'Bagaimana cara melatih otot punggung (back) di rumah kalau tidak punya pull-up bar sama sekali?',
                'jawaban_singkat' => 'Fungsi utama otot punggung lebar (latissimus dorsi) dan punggung tengah adalah menarik beban mendekati tubuh. Tanpa palang gantung sekalipun, Anda bisa memanfaatkan gaya tarik horizontal menggunakan meja makan yang kokoh, handuk tebal di tiang, atau tas ransel berat yang ditarik sambil membungkuk stabil (Bent-Over Backpack Row).',
                'contoh' => 'Pegang tas ransel berisi buku dengan satu tangan, tumpukan tangan satunya di kursi dengan punggung lurus, lalu tarik tas ke arah pinggang (One-Arm Backpack Row) sebanyak 12 repetisi per sisi.',
                'sumber_nama' => 'Bobby Ida (Praktisi Calisthenics & Natural Bodybuilding Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'latihan_di_rumah',
            ],
            [
                'pertanyaan' => 'Gerakan latihan kaki (paha & bokong) apa yang paling terasa berat kalau latihan di rumah tanpa barbel?',
                'jawaban_singkat' => 'Kuncinya adalah beralih ke gerakan satu kaki (unilateral) seperti Bulgarian Split Squat, Lunges, atau Pistol Squat berbantu! Saat Anda menumpukan seluruh berat tubuh hanya pada satu kaki, beban kerja yang diterima otot paha depan dan bokong langsung berlipat ganda sehingga sangat efektif membentuk otot kaki tanpa barbel berat.',
                'contoh' => 'Letakkan punggung telapak kaki belakang di atas sofa atau kursi, lalu tekuk kaki depan turun perlahan (Bulgarian Split Squat) sebanyak 3 set x 10 repetisi untuk masing-masing kaki.',
                'sumber_nama' => 'dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/olahraga',
                'kategori' => 'latihan_di_rumah',
            ],
            [
                'pertanyaan' => 'Saya tinggal di kamar kos ukuran 3x3 meter, olahraga apa yang paling efektif membakar kalori tanpa lari keluar?',
                'jawaban_singkat' => 'Latihan sirkuit HIIT (High-Intensity Interval Training) tanpa lompatan keras adalah jawabannya! Menggabungkan beberapa gerakan beban tubuh dengan jeda istirahat singkat akan memacu detak jantung tinggi dan menjaga pembakaran kalori tetap aktif bahkan beberapa jam setelah sesi latihan selesai, cukup di atas selembar matras.',
                'contoh' => 'Rangkai 40 detik Mountain Climbers, 40 detik Bodyweight Squat cepat, dan 40 detik Plank dengan jeda istirahat 20 detik antar gerakan, ulangi sebanyak 4–5 putaran di kamar.',
                'sumber_nama' => 'Yulia Baltschun (Praktisi Kebugaran & Certified Fitness Specialist Indonesia) via KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'latihan_di_rumah',
            ],

            // =========================================================================
            // 4. JUDUL: Protein & Nutrisi (nutrisi) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Berapa kebutuhan protein harian yang ideal untuk orang Indonesia yang rutin berolahraga beban?',
                'jawaban_singkat' => 'Bagi Anda yang aktif berlatih beban atau calisthenics untuk membangun maupun mempertahankan massa otot, asupan protein harian yang disarankan berada di kisaran 1,6 hingga 2,2 gram per kilogram berat badan. Angka ini bisa langsung Anda pantau dengan mudah lewat fitur Kalkulator Protein PraxisFit.',
                'contoh' => 'Jika berat badan Anda 65 kg, maka target protein harian Anda berkisar antara 104 gram hingga 143 gram yang dibagi merata ke dalam 3–4 kali waktu makan.',
                'sumber_nama' => 'dr. Dion Haryadi, PN1 & Perhimpunan Dokter Spesialis Gizi Klinik Indonesia (PDGKI) via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/fungsi-protein-penting-untuk-tubuh',
                'kategori' => 'nutrisi',
            ],
            [
                'pertanyaan' => 'Kapan waktu terbaik makan sumber protein—apakah harus langsung dalam 30 menit setelah latihan?',
                'jawaban_singkat' => 'Total kecukupan protein harian Anda jauh lebih menentukan hasil dibanding sekadar terburu-buru makan 5 menit sehabis latihan. Meski begitu, membagi porsi protein secara merata sekitar 25–40 gram setiap kali makan (sarapan, makan siang, setelah latihan, dan makan malam) akan menjaga proses perbaikan otot berjalan optimal sepanjang hari.',
                'contoh' => 'Sarapan 3 butir telur (~18–20g protein), makan siang dada ayam (~35g), camilan sore tempe/tahu (~20g), dan makan malam ikan atau daging sapi tanpa lemak (~30g).',
                'sumber_nama' => 'Ade Rai & dr. Dion Haryadi, PN1 (Edukator Gizi & Kebugaran Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/nutrisi/fakta-gizi/',
                'kategori' => 'nutrisi',
            ],
            [
                'pertanyaan' => 'Apa bedanya program Bulking dan Cutting, lalu mana yang sebaiknya saya mulai duluan?',
                'jawaban_singkat' => 'Bulking adalah fase makan sedikit di atas kebutuhan kalori harian (surplus kalori terukur) untuk fokus menambah massa otot, sedangkan Cutting adalah fase mengurangi porsi kalori harian (defisit kalori) sambil tetap tinggi protein agar kadar lemak tubuh turun namun otot tetap terjaga. Pilih sesuai kondisi persentase lemak tubuh Anda saat ini.',
                'contoh' => 'Jika tubuh masih tergolong sangat kurus, mulailah dengan Lean Bulking (+200–300 kkal dari makanan bergizi). Sebaliknya jika perut masih berlemak berlebih, fokuslah pada Cutting ringan sambil rutin latihan beban.',
                'sumber_nama' => 'Yulia Baltschun & Tim Medis Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/nutrisi',
                'kategori' => 'nutrisi',
            ],
            [
                'pertanyaan' => 'Berapa banyak air putih yang wajib diminum setiap hari supaya performa latihan tidak cepat loyo?',
                'jawaban_singkat' => 'Sebagian besar jaringan otot terdiri dari air, sehingga kekurangan cairan sedikit saja bisa langsung bikin tenaga angkatan turun drastis dan memicu kram. Kementerian Kesehatan RI menganjurkan minimal 2 liter (8 gelas) air putih per hari untuk aktivitas biasa, dan wajib ditambah 500–1.000 ml ekstra bagi Anda yang berkeringat saat berolahraga.',
                'contoh' => 'Minumlah 1–2 gelas air putih 30 menit sebelum latihan, sesap sedikit air di sela istirahat antar set, dan penuhi kembali cairan tubuh setelah selesai berolahraga.',
                'sumber_nama' => 'Kementerian Kesehatan RI - Direktorat Promosi Kesehatan (Ayo Sehat Kemenkes)',
                'sumber_url' => 'https://ayosehat.kemkes.go.id/',
                'kategori' => 'nutrisi',
            ],
            [
                'pertanyaan' => 'Apakah sumber protein nabati lokal seperti tempe dan tahu efektif membentuk otot dibanding daging?',
                'jawaban_singkat' => 'Sangat efektif dan bernutrisi tinggi! Tempe murni hasil fermentasi kedelai merupakan kebanggaan pangan Indonesia yang mudah dicerna dan mengandung sekitar 19 gram protein per 100 gramnya. Agar profil asam aminonya makin lengkap, kombinasikan tempe dan tahu dengan sumber protein lain seperti telur, ikan, ayam, atau kacang-kacangan dalam menu harian Anda.',
                'contoh' => 'Mengombinasikan 100 gram tempe panggang/kukus dengan 2 butir telur rebus saat makan siang sudah menyumbang lebih dari 30 gram protein berkualitas tinggi dengan biaya sangat hemat.',
                'sumber_nama' => 'Kementerian Kesehatan RI - Tabel Komposisi Pangan Indonesia (TKPI)',
                'sumber_url' => 'https://panganku.org/',
                'kategori' => 'nutrisi',
            ],

            // =========================================================================
            // 5. JUDUL: Pola Tidur & Recovery (pola_tidur) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Berapa jam waktu tidur malam yang ideal agar pemulihan dan pertumbuhan otot berjalan maksimal?',
                'jawaban_singkat' => 'Orang dewasa yang aktif berolahraga membutuhkan tidur berkualitas selama 7 hingga 9 jam setiap malam. Saat Anda memasuki fase tidur lelap (deep sleep), tubuh melepaskan hormon pertumbuhan alami secara maksimal untuk menambal dan memperkuat serat-serat otot yang bekerja keras saat latihan siang atau sore tadi.',
                'contoh' => 'Biasakan jadwal tidur yang konsisten, misalnya mulai memejamkan mata pukul 22.00 dan bangun segar pukul 05.30 pagi tanpa terganggu layar ponsel.',
                'sumber_nama' => 'dr. Tirta Mandira Hudhi, M.B.A. & Kementerian Kesehatan RI via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/pentingnya-tidur-cukup-bagi-kesehatan',
                'kategori' => 'pola_tidur',
            ],
            [
                'pertanyaan' => 'Benarkah kebiasaan sering begadang bisa bikin otot susah besar dan lemak perut justru menumpuk?',
                'jawaban_singkat' => 'Benar sekali! Kurang tidur kronis akibat sering begadang akan memicu lonjakan hormon kortisol (hormon stres) dan mengacaukan hormon pengatur rasa lapar. Dampaknya ganda: proses pembentukan protein otot terhambat, nafsu makan makanan manis meningkat, dan tubuh cenderung menyimpan cadangan lemak di area perut.',
                'contoh' => 'Latihan keras 1 jam di sore hari hasilnya bisa sia-sia apabila malamnya Anda terus-menerus begadang sampai jam 2–3 pagi.',
                'sumber_nama' => 'Ade Rai & dr. Tirta Mandira Hudhi, M.B.A. via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/tidur',
                'kategori' => 'pola_tidur',
            ],
            [
                'pertanyaan' => 'Otot terasa pegal-pegal (DOMS) sehari setelah latihan, apakah boleh langsung dilatih keras lagi?',
                'jawaban_singkat' => 'Rasa pegal 1–2 hari pasca latihan (Delayed Onset Muscle Soreness / DOMS) adalah tanda adaptasi mikro pada serat otot. Sebaiknya jangan menghajar otot yang sedang pegal berat dengan gerakan yang sama; alihkan jadwal latihan hari ini ke kelompok otot lain yang masih segar agar otot yang pegal punya waktu pulih sempurna.',
                'contoh' => 'Kalau otot dada dan bahu masih terasa kaku setelah latihan Push Up kemarin, hari ini fokuslah melatih otot kaki (Squat/Lunges) atau otot perut (Plank).',
                'sumber_nama' => 'dr. Sophia Hage, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'pola_tidur',
            ],
            [
                'pertanyaan' => 'Apa yang dimaksud dengan Active Recovery saat hari libur latihan (Rest Day)?',
                'jawaban_singkat' => 'Active recovery adalah tetap bergerak ringan di hari istirahat tanpa memberikan beban berat pada otot maupun sendi. Aktivitas ringan ini memperlancar aliran darah yang membawa oksigen dan zat gizi menuju jaringan otot, sehingga rasa kaku atau pegal pasca-latihan justru lebih cepat hilang dibanding rebahan seharian penuh.',
                'contoh' => 'Di hari Minggu yang merupakan Rest Day Anda di PraxisFit, lakukan jalan pagi santai 20–30 menit atau peregangan ringan seluruh tubuh.',
                'sumber_nama' => 'dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/',
                'kategori' => 'pola_tidur',
            ],
            [
                'pertanyaan' => 'Apa itu minggu pemulihan (Deload Week) dan kapan saya perlu menerapkannya di jadwal latihan?',
                'jawaban_singkat' => 'Deload week adalah satu minggu khusus setelah Anda berlatih intens selama 6–8 minggu berturut-turut, di mana jumlah set atau beban latihan sengaja dikurangi sekitar 40–50%. Tujuannya adalah memberi kesempatan bagi persendian, tendon, dan sistem saraf pusat untuk pulih total supaya Anda kembali lebih kuat di minggu berikutnya.',
                'contoh' => 'Jika biasanya Anda melakukan 4 set x 12 repetisi hingga hampir batas kemampuan, pada minggu deload cukup lakukan 2 set x 10 repetisi dengan ritme santai dan fokus pada teknik.',
                'sumber_nama' => 'Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'pola_tidur',
            ],

            // =========================================================================
            // 6. JUDUL: Suplemen & Mitos (suplemen_mitos) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Bisa nggak sih mengecilkan lemak perut doang dengan sit-up ratusan kali tiap hari (Spot Reduction)?',
                'jawaban_singkat' => 'Itu adalah mitos olahraga paling populer yang keliru! Tubuh manusia membakar cadangan lemak secara menyeluruh dari ujung kepala hingga kaki lewat defisit kalori, bukan hanya di bagian otot yang sedang digerakkan. Gerakan perut seperti Sit-Up atau Plank berfungsi mengencangkan otot perut, tetapi lapisan lemak di atasnya baru menipis jika pola makan Anda terjaga.',
                'contoh' => 'Kombinasikan defisit kalori sehat, kecukupan protein di Kalkulator Protein PraxisFit, serta latihan beban seluruh tubuh agar lingkar perut menyusut secara efektif.',
                'sumber_nama' => 'dr. Dion Haryadi, PN1 & Yulia Baltschun via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'suplemen_mitos',
            ],
            [
                'pertanyaan' => 'Apakah lari siang bolong pakai jaket parasut biar banjir keringat artinya membakar lemak lebih banyak?',
                'jawaban_singkat' => 'Bukan! Keringat hanyalah mekanisme alami tubuh untuk mendinginkan suhu badan agar tidak mengalami sengatan panas (heatstroke), bukan cairan lemak yang meleleh keluar pori-pori. Memaksa olahraga memakai jaket plastik tertutup di cuaca panas justru sangat berbahaya karena memicu dehidrasi berat dan gangguan elektrolit.',
                'contoh' => 'Angka timbangan yang turun 1 kg tepat setelah berkeringat deras hanyalah berat air yang hilang dan akan kembali normal begitu Anda minum air putih.',
                'sumber_nama' => 'dr. Tirta Mandira Hudhi, M.B.A. & Tim Medis KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'suplemen_mitos',
            ],
            [
                'pertanyaan' => 'Apakah pemula wajib membeli suplemen Whey Protein dan Creatine supaya otot bisa terbentuk?',
                'jawaban_singkat' => 'Tidak wajib sama sekali! Sesuai namanya, suplemen hanyalah pelengkap, bukan pengganti makanan utama. Jika target protein harian Anda sudah tercukupi dari makanan utuh (ayam, telur, ikan, tahu, tempe), otot tetap tumbuh optimal. Suplemen seperti Whey atau Creatine Monohydrate baru bersifat opsional bila jadwal Anda super padat atau ingin dorongan tenaga ekstra.',
                'contoh' => 'Prioritaskan anggaran bulanan Anda untuk belanja bahan makanan segar berprotein tinggi terlebih dahulu sebelum memikirkan beli suplemen bubuk.',
                'sumber_nama' => 'Ade Rai & Bobby Ida (Binaragawan Natural Indonesia) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/nutrisi',
                'kategori' => 'suplemen_mitos',
            ],
            [
                'pertanyaan' => 'Benarkah wanita yang rajin latihan angkat beban badannya bakal jadi kekar seperti binaragawan pria?',
                'jawaban_singkat' => 'Itu mitos yang tidak perlu ditakuti! Secara alami, kadar hormon testosteron pada wanita berkali-kali lipat lebih rendah dibandingkan pria, sehingga secara biologis wanita tidak akan berubah menjadi kekar besar hanya karena rutin angkat beban. Justru latihan beban membuat postur tubuh wanita tampak lebih kencang, tegap, sehat, dan mencegah pengeroposan tulang (osteoporosis).',
                'contoh' => 'Wanita yang rutin melakukan Squat, Lunges, dan Push Up akan mendapatkan tubuh yang bugar, kencang, dan metabolisme pembakaran kalori yang lebih baik.',
                'sumber_nama' => 'Yulia Baltschun & dr. Sophia Hage, Sp.KO via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'suplemen_mitos',
            ],
            [
                'pertanyaan' => 'Apakah makan nasi putih atau karbohidrat di atas jam 7 malam otomatis berubah jadi tumpukan lemak?',
                'jawaban_singkat' => 'Mitos! Sistem pencernaan manusia tidak punya jam malam yang otomatis mengubah nasi menjadi lemak tepat pukul 7 malam. Kenaikan berat badan murni ditentukan oleh total kalori yang masuk dibanding kalori yang keluar selama 24 jam penuh. Selama total porsi makan harian Anda masih sesuai kebutuhan, makan malam sehabis latihan justru membantu memulihkan energi otot.',
                'contoh' => 'Jika Anda baru sempat latihan pukul 19.00 malam, makan nasi secukupnya dengan lauk dada ayam pada pukul 20.30 tetap aman dan mendukung pemulihan tubuh.',
                'sumber_nama' => 'dr. Dion Haryadi, PN1 & Perhimpunan Dokter Spesialis Gizi Klinik Indonesia (PDGKI) via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/kesehatan',
                'kategori' => 'suplemen_mitos',
            ],

            // =========================================================================
            // 7. JUDUL: Cedera & Keamanan (keamanan) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Berapa lama durasi pemanasan (Warm-Up) yang ideal sebelum mulai latihan beban atau calisthenics?',
                'jawaban_singkat' => 'Cukup luangkan waktu 5 hingga 10 menit untuk pemanasan dinamis sebelum masuk ke gerakan inti! Pemanasan ini bertujuan menaikkan suhu otot secara bertahap, melumasi persendian dengan cairan sinovial, dan menyiapkan detak jantung agar tubuh tidak kaget saat menerima beban latihan.',
                'contoh' => 'Awali dengan jalan cepat di tempat 3 menit, dilanjutkan putaran bahu, ayunan lengan, rotasi pinggul, dan 10 kali Squat ringan tanpa beban.',
                'sumber_nama' => 'Perhimpunan Dokter Spesialis Kedokteran Olahraga (PDSKO) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/artikel/pentingnya-pemanasan-sebelum-olahraga',
                'kategori' => 'keamanan',
            ],
            [
                'pertanyaan' => 'Kenapa peregangan statis (menahan tarikan otot lama-lama) sebaiknya ditaruh sesudah latihan, bukan sebelumnya?',
                'jawaban_singkat' => 'Menahan regangan otot dalam posisi diam terlalu lama (lebih dari 45–60 detik) tepat sebelum angkat beban dapat menurunkan daya ledak dan kesiapan kontraksi otot untuk sementara waktu. Karena itu, gunakan gerakan peregangan aktif/dinamis sebelum latihan, dan simpan peregangan statis yang menenangkan untuk sesi pendinginan (cooling down) setelah selesai latihan.',
                'contoh' => 'Sebelum Squat lakukan gerakan mengayun kaki dan jongkok dinamis; setelah seluruh jadwal latihan tuntas, barulah tahan peregangan paha dan betis masing-masing 30 detik.',
                'sumber_nama' => 'dr. Andi Kurniawan, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/',
                'kategori' => 'keamanan',
            ],
            [
                'pertanyaan' => 'Bagaimana cara membedakan rasa panas/pegal otot yang normal dengan rasa nyeri tanda cedera?',
                'jawaban_singkat' => 'Sensasi terbakar ringan atau pegal merata di perut otot saat repetisi terakhir adalah hal wajar dari kerja otot. Namun, jika Anda merasakan nyeri tajam seperti tertusuk, ngilu di satu titik sendi (bahu, siku, lutut, pergelangan, atau pinggang bawah), atau bunyi sendi disertai rasa sakit, segera hentikan gerakan detik itu juga untuk mencegah cedera serius.',
                'contoh' => 'Jika bahu depan terasa ngilu menusuk saat melakukan Push Up, periksa kembali posisi siku Anda agar membentuk sudut sekitar 45 derajat (tidak melebar lurus ke samping).',
                'sumber_nama' => 'dr. Michael Triangto, Sp.KO (Dokter Spesialis Kedokteran Olahraga) via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/cedera-olahraga',
                'kategori' => 'keamanan',
            ],
            [
                'pertanyaan' => 'Bagaimana teknik mengatur napas yang benar supaya tidak pusing saat melakukan gerakan berat?',
                'jawaban_singkat' => 'Jangan pernah menahan napas terus-menerus sepanjang satu set penuh karena bisa membuat tekanan darah melonjak mendadak dan memicu pusing berkunang-kunang! Rumus praktisnya mudah diingat: tarik napas melalui hidung saat fase menurunkan/menahan beban (fase ringan), lalu embuskan napas kuat lewat mulut saat mendorong atau mengangkat beban (fase terberat).',
                'contoh' => 'Saat melakukan Push Up, tarik napas sembari menurunkan dada mendekati lantai, lalu buang napas dengan mantap saat mendorong tubuh kembali naik ke atas.',
                'sumber_nama' => 'dr. Sophia Hage, Sp.KO & Tim Medis KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/gaya-hidup/sehat-bugar',
                'kategori' => 'keamanan',
            ],
            [
                'pertanyaan' => 'Apakah anak remaja usia sekolah aman latihan beban & calisthenics, atau benar bikin badan pendek?',
                'jawaban_singkat' => 'Anggapan bahwa latihan beban bikin tubuh pendek adalah mitos lama! Selama dilakukan dengan teknik postur yang benar, terarah, dan tidak memaksakan beban ekstrem yang merusak tulang rawan sendi, latihan beban tubuh (calisthenics) maupun resistensi terukur justru memperkuat kepadatan tulang dan mendukung postur tumbuh kembang remaja.',
                'contoh' => 'Remaja usia 14–17 tahun sangat baik melatih gerakan dasar seperti Push Up, Pull Up, Plank, dan Bodyweight Squat sembari mencukupi gizi protein harian.',
                'sumber_nama' => 'Ikatan Dokter Anak Indonesia (IDAI) & Kemenkes RI via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'keamanan',
            ],

            // =========================================================================
            // 8. JUDUL: Mindset & Konsistensi (mindset) - 5 FAQ
            // =========================================================================
            [
                'pertanyaan' => 'Berapa lama perubahan bentuk badan akan mulai terlihat nyata kalau saya rutin latihan?',
                'jawaban_singkat' => 'Pada 2 hingga 4 minggu pertama, perubahan paling terasa ada pada peningkatan stamina, kualitas tidur, dan kekuatan saraf saat mengangkat beban. Sementara perubahan visual bentuk otot dan penurunan lingkar lemak yang tampak jelas di cermin maupun ukuran pakaian rata-rata mulai terlihat nyata setelah 8 hingga 12 minggu konsistensi.',
                'contoh' => 'Ambil foto progres pribadi setiap 4 minggu sekali di pencahayaan yang sama supaya Anda bisa melihat perubahan nyata yang sering tidak disadari mata sehari-hari.',
                'sumber_nama' => 'Ade Rai & Bobby Ida (Praktisi Kebugaran Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/',
                'kategori' => 'mindset',
            ],
            [
                'pertanyaan' => 'Apa tips paling ampuh supaya tetap disiplin jalanin jadwal latihan saat lagi malas banget?',
                'jawaban_singkat' => 'Jangan menunggu motivasi datang baru bergerak, karena motivasi selalu naik-turun mengikuti suasana hati. Gunakan "Aturan 5 Menit": berkomitmenlah cukup ganti pakaian olahraga dan lakukan pemanasan serta 1 set ringan saja dari jadwal Rutinku hari ini. Begitu tubuh mulai bergerak dan hormon endorfin keluar, rasa malas biasanya langsung hilang sendiri!',
                'contoh' => 'Saat pulang kerja/kuliah terasa malas, katakan pada diri sendiri "cukup lakukan 1 set Push Up saja sore ini"—begitu mulai, Anda hampir pasti lanjut menyelesaikan sesi.',
                'sumber_nama' => 'Ade Rai (Edukator Kebugaran & Gaya Hidup Sehat Indonesia) via Halodoc',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/olahraga',
                'kategori' => 'mindset',
            ],
            [
                'pertanyaan' => 'Saya suka minder atau malu mulai olahraga karena badan masih gemuk atau terlalu kurus, gimana mengatasinya?',
                'jawaban_singkat' => 'Setiap atlet dan binaragawan profesional pun pernah memulai dari titik nol! Fokuslah berbanding lurus dengan diri Anda yang kemarin, bukan membandingkan bab ke-1 perjalanan Anda dengan bab ke-100 orang lain. Selain itu, seluruh katalog gerakan dan fitur jadwal di PraxisFit dirancang sangat ramah untuk dieksekusi dengan nyaman dari privasi rumah Anda sendiri.',
                'contoh' => 'Mulai bangun rasa percaya diri dengan menuntaskan jadwal latihan rumahan 3 kali seminggu di kamar sendiri hingga tubuh terasa makin kuat dan bugar.',
                'sumber_nama' => 'Yulia Baltschun & Tim Psikologi Olahraga KlikDokter',
                'sumber_url' => 'https://www.klikdokter.com/psikologi',
                'kategori' => 'mindset',
            ],
            [
                'pertanyaan' => 'Kenapa setelah beberapa bulan latihan, perkembangan otot dan angkatan terasa mentok (Plateau)?',
                'jawaban_singkat' => 'Fase mentok (plateau) terjadi ketika tubuh sudah terlalu terbiasa dengan variasi gerakan, jumlah repetisi, atau asupan gizi yang itu-itu saja. Untuk menembusnya kembali, cobalah mengganti variasi sudut gerakan di Katalog PraxisFit, mengecek ulang apakah target protein harian Anda sudah tercapai di Kalkulator Protein, serta memastikan waktu tidur tidak kurang.',
                'contoh' => 'Jika sudah 2 bulan terus melakukan Push Up biasa tanpa progres repetisi, gantilah variasi di jadwal Rutinku menjadi Decline Push Up atau Diamond Push Up selama 4 minggu ke depan.',
                'sumber_nama' => 'Bobby Ida (Binaragawan Natural & Certified Fitness Trainer Indonesia) via Hello Sehat',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan/',
                'kategori' => 'mindset',
            ],
            [
                'pertanyaan' => 'Buat pemula yang baru mulai hidup sehat, lebih baik langsung tancap gas tiap hari atau mulai pelan-pelan?',
                'jawaban_singkat' => 'Jauh lebih baik mulai secara bertahap namun konsisten jangka panjang! Kesalahan terbesar pemula adalah langsung memaksakan latihan berat 6–7 kali seminggu plus diet ekstrem di minggu pertama, yang akhirnya berujung kelelahan parah dan berhenti total di minggu kedua. Mulailah dengan 3 sesi latihan terukur per minggu dan nikmati prosesnya.',
                'contoh' => 'Susun jadwal latihan di hari Senin, Rabu, dan Jumat saja terlebih dahulu selama sebulan pertama; setelah menjadi kebiasaan otomatis, baru tambah hari latihan jika diperlukan.',
                'sumber_nama' => 'dr. Tirta Mandira Hudhi, M.B.A. & dr. Dion Haryadi, PN1 via Alodokter',
                'sumber_url' => 'https://www.alodokter.com/olahraga',
                'kategori' => 'mindset',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command?->info('✅ Sukses memuat ' . count($faqs) . ' data FAQ PraxisFit (8 Judul x 5 Pertanyaan) dengan sumber kredibel Indonesia!');
    }
}
