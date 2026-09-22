<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class DataAwalSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================
        // Data FAQ & Bantuan Kebugaran
        // ====================================================
        $faqs = [
            // --- Kategori Latihan ---
            [
                'pertanyaan' => 'Apakah aman mengganti beban dengan batu atau tas berisi buku?',
                'jawaban_singkat' => 'Sangat aman. Otot manusia tidak bisa melihat dari mana beban berasal, otot hanya merasakan resistensi atau daya tarik gravitasi. Selama beban bisa dipegang dengan stabil, prinsip "progressive overload" (peningkatan beban bertahap) tetap berjalan.',
                'contoh' => 'Daripada membeli dumbbell seberat 5kg, Anda bisa memasukkan 5 buku paket tebal ke dalam ransel untuk melakukan gerakan Bicep Curl dengan efek tarikan otot yang sama persis.',
                'sumber_nama' => 'Halodoc - Olahraga',
                'sumber_url' => 'https://www.halodoc.com/kesehatan/olahraga',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apa bedanya Set dan Repetisi (Reps)?',
                'jawaban_singkat' => 'Repetisi adalah jumlah gerakan fisik yang dilakukan berulang kali tanpa henti. Sedangkan Set adalah kelompok dari repetisi tersebut yang dipisahkan oleh waktu istirahat antar kelompok.',
                'contoh' => 'Jika jadwal Anda tertulis "Push-up 3 Set, 10 Repetisi", artinya Anda melakukan 10 kali push-up (sebagai 1 set), lalu istirahat 1 menit. Setelah istirahat, ulangi lagi 10 push-up hingga mencapai 3 kali putaran (total 30 kali push-up).',
                'sumber_nama' => 'HelloSehat - Repetisi dan Set',
                'sumber_url' => 'https://hellosehat.com/kebugaran/kekuatan-tubuh/repetisi-dan-set-saat-olahraga/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Saya belum kuat melakukan Pull-Up, apa alternatif pemulanya?',
                'jawaban_singkat' => 'Jika otot punggung (lats) dan lengan belum cukup kuat mengangkat beban tubuh total, Anda bisa melakukan gerakan regresi (penurunan kesulitan) untuk membangun pondasi otot tersebut terlebih dahulu.',
                'contoh' => 'Lakukan "Australian Pull-up" dengan cara berpegangan pada ujung meja makan yang kokoh, berbaring di bawahnya, lalu tarik dada ke atas meja. Atau lakukan "Negative Pull-up" dengan melompat ke atas tiang dan menahan tubuh turun dengan sangat lambat.',
                'sumber_nama' => 'Alodokter - Cara Membentuk Otot',
                'sumber_url' => 'https://www.alodokter.com/cara-membentuk-otot-tubuh',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Seberapa sering saya harus latihan dalam seminggu?',
                'jawaban_singkat' => 'Idealnya 3-5 kali seminggu, tergantung program yang Anda jalani. Pemula disarankan memulai dengan 3 hari Full Body, sedangkan yang sudah berpengalaman bisa memakai sistem split.',
                'contoh' => 'Pemula bisa berlatih hari Senin, Rabu, dan Jumat (Full Body). Hari lainnya digunakan untuk istirahat total atau peregangan ringan.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apa itu Progressive Overload?',
                'jawaban_singkat' => 'Ini adalah kunci utama perkembangan otot; prinsip menambah beban, repetisi, atau intensitas secara bertahap dari waktu ke waktu.',
                'contoh' => 'Minggu ini Anda mengangkat 10kg sebanyak 10 kali. Minggu depan, Anda harus mencoba mengangkat 10kg sebanyak 11 kali, atau naik beban menjadi 12kg.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Cardio sebaiknya sebelum atau sesudah angkat beban?',
                'jawaban_singkat' => 'Selalu angkat beban terlebih dahulu saat energi Anda masih penuh. Lakukan cardio sesudahnya atau di hari yang terpisah agar performa angkatan Anda maksimal.',
                'contoh' => 'Jika Anda melakukan lari 5km lalu mencoba Squat berat, kaki Anda sudah terlalu lelah, yang meningkatkan risiko cedera.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apakah saya harus berlatih sampai "Failure" (Gagal Angkat)?',
                'jawaban_singkat' => 'Tidak harus di setiap set karena bisa menyebabkan kelelahan saraf (CNS fatigue). Namun, Anda harus berlatih mendekati failure (menyisakan 1-2 repetisi di tangki).',
                'contoh' => 'Jika Anda merasa masih bisa mengangkat beban 5 kali lagi setelah set selesai, berarti beban Anda terlalu ringan.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],

            // --- Kategori Nutrisi ---
            [
                'pertanyaan' => 'Berapa kebutuhan protein harian untuk orang yang rutin berolahraga?',
                'jawaban_singkat' => 'Orang yang aktif melatih otot membutuhkan lebih banyak protein (1.6 hingga 2.2 gram per kilogram berat badan per hari) dibandingkan orang biasa.',
                'contoh' => 'Jika berat badan Anda 60 kg, target protein harian Anda sekitar 96 hingga 132 gram.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Kapan waktu terbaik mengonsumsi makanan tinggi protein?',
                'jawaban_singkat' => 'Mengonsumsi protein secara merata di setiap waktu makan adalah kunci utamanya. Fase Anabolic Window (langsung setelah latihan) itu baik, tapi total harian jauh lebih penting.',
                'contoh' => 'Makan 30g protein saat sarapan, 40g saat makan siang, 30g setelah latihan, dan 40g saat makan malam.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apa bedanya Bulking dan Cutting?',
                'jawaban_singkat' => 'Bulking adalah makan kalori berlebih (surplus) untuk membangun otot. Cutting adalah makan kurang dari yang dibakar (defisit) untuk memangkas lemak.',
                'contoh' => 'Saat bulking, Anda menargetkan surplus 300-500 kalori per hari di atas TDEE Anda.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Bolehkah makan fast-food/manis saat sedang Bulking (Dirty Bulking)?',
                'jawaban_singkat' => 'Boleh sesekali (aturan 80% makanan utuh sehat, 20% bebas), tapi jika kalori berlebihnya terlalu ekstrem dan berasal dari junk food, yang bertambah justru lemak, bukan massa otot murni.',
                'contoh' => 'Sesekali memakan donat tidak masalah, tetapi menjadikan pizza sebagai makanan utama setiap hari akan merusak komposisi tubuh.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],

            // --- Kategori Pola Tidur & Recovery ---
            [
                'pertanyaan' => 'Berapa lama waktu tidur yang ideal untuk pemulihan otot?',
                'jawaban_singkat' => 'Tidur selama 7-9 jam di malam hari sangat esensial. Saat Anda memasuki fase tidur paling dalam, tubuh melepaskan Human Growth Hormone (HGH).',
                'contoh' => 'Tidur kurang dari 6 jam secara kronis akan menurunkan produksi testosteron secara signifikan.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apakah sering begadang bisa menghilangkan massa otot?',
                'jawaban_singkat' => 'Ya, kurang tidur memicu produksi kortisol (hormon stres) yang bersifat katabolik, memecah jaringan otot untuk energi dan menghalangi penyerapan protein.',
                'contoh' => 'Begadang akan membuat hasil latihan berat Anda keesokan harinya tidak dapat diperbaiki oleh tubuh secara optimal.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Otot saya sangat pegal (DOMS), apakah boleh latihan lagi?',
                'jawaban_singkat' => 'Delayed Onset Muscle Soreness (DOMS) adalah normal. Jika pegalnya sangat parah, latihlah kelompok otot yang lain, atau lakukan istirahat aktif.',
                'contoh' => 'Jika dada sangat pegal setelah hari Senin, latih punggung atau kaki di hari Selasa, jangan melatih dada lagi.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apa itu Active Recovery?',
                'jawaban_singkat' => 'Melakukan aktivitas fisik ringan di hari libur latihan untuk memperlancar aliran darah yang membawa nutrisi ke otot.',
                'contoh' => 'Berjalan santai selama 30 menit atau bersepeda ringan pada rest day (hari libur).',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Bolehkah melatih bagian otot yang sama berturut-turut tiap hari?',
                'jawaban_singkat' => 'Sangat tidak disarankan. Otot membutuhkan waktu pemulihan 48-72 jam agar sel yang robek bisa dibangun kembali lebih besar.',
                'contoh' => 'Push-up setiap hari berturut-turut tanpa jeda istirahat justru menghambat pertumbuhan otot dada.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],

            // --- Kategori Suplemen & Mitos ---
            [
                'pertanyaan' => 'Bisa nggak kecilin perut doang (Spot Reduction)?',
                'jawaban_singkat' => 'MITOS BESAR. Lemak menurun secara proporsional di seluruh tubuh melalui diet defisit kalori, bukan hanya dari bagian yang dilatih.',
                'contoh' => 'Melakukan Sit-up 1000x sehari tidak akan membakar lemak di perut Anda, hanya akan mengencangkan otot di baliknya.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apakah suplemen Whey Protein itu wajib?',
                'jawaban_singkat' => 'TIDAK WAJIB. Makanan utuh (ayam, telur, daging) selalu yang terbaik. Suplemen hanya berfungsi jika asupan dari makanan masih kurang.',
                'contoh' => 'Jika target Anda 150g dan Anda sudah mendapatkannya dari makanan, Anda sama sekali tidak perlu whey protein.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apa fungsi suplemen Creatine?',
                'jawaban_singkat' => 'Creatine membantu memproduksi energi (ATP) secara instan, meningkatkan tenaga, dan membuat otot terlihat lebih "penuh" karena menahan air di dalam otot.',
                'contoh' => 'Konsumsi 5 gram creatine monohydrate per hari dapat meningkatkan performa rep maks Anda.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apakah wanita yang angkat beban akan berotot seperti pria?',
                'jawaban_singkat' => 'MITOS. Wanita tidak memiliki kadar hormon testosteron yang tinggi. Angkat beban justru akan membuat tubuh lebih kencang (toned) dan proporsional.',
                'contoh' => 'Berlatih angkat beban bagi wanita akan membentuk lekuk tubuh (curves) yang atletis, bukan mengubah badan menjadi kekar.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],

            // --- Kategori Cedera & Keamanan ---
            [
                'pertanyaan' => 'Bagaimana cara terbaik mencegah cedera?',
                'jawaban_singkat' => 'Selalu mulai dengan pemanasan (dynamic stretching) dan fokuslah pada postur (form) angkatan yang benar, bukan semata-mata pamer beban terberat.',
                'contoh' => 'Lakukan gerakan Squat tanpa beban 1-2 set sebelum menaruh plat beban berat di pundak Anda.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'keamanan'
            ],
            [
                'pertanyaan' => 'Saya merasakan nyeri tiba-tiba, apakah harus tetap latihan?',
                'jawaban_singkat' => 'Berhenti segera! Nyeri tajam (sharp pain) yang menusuk sendi atau tulang adalah indikasi awal cedera, berbeda dengan rasa pegal otot biasa.',
                'contoh' => 'Jika lutut terasa nyeri seperti tertusuk saat squat, segera hentikan latihan kaki untuk hari itu.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'keamanan'
            ],

            // --- Kategori Mindset & Konsistensi ---
            [
                'pertanyaan' => 'Kapan saya mulai bisa melihat hasilnya?',
                'jawaban_singkat' => 'Perubahan tenaga akan terasa di 4 minggu pertama. Dalam 2 bulan Anda melihatnya di cermin. Butuh 3-6 bulan bagi orang lain untuk menyadari perubahan Anda.',
                'contoh' => 'Jangan menyerah jika di minggu ke-3 Anda merasa belum ada perubahan drastis, ini adalah maraton, bukan lari sprint.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'mindset'
            ],
            [
                'pertanyaan' => 'Apa yang harus saya lakukan saat sedang tidak ada motivasi?',
                'jawaban_singkat' => 'Disiplin mengalahkan motivasi. Jadikan berolahraga layaknya rutinitas sikat gigi. Begitu Anda mulai pemanasan, endorfin akan membuat Anda semangat dengan sendirinya.',
                'contoh' => 'Terkadang datang ke gym adalah bagian tersulit. Begitu Anda melewati pintunya, sisanya akan terasa jauh lebih mudah.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'mindset'
            ],
            [
                'pertanyaan' => 'Saya malu berolahraga di gym karena badan saya belum bagus.',
                'jawaban_singkat' => 'Semua orang di gym pernah menjadi pemula. Faktanya, 99% orang di gym terlalu sibuk mengurus latihan mereka sendiri untuk menghakimi orang lain.',
                'contoh' => 'Orang-orang berotot besar justru biasanya yang paling ramah dan suportif terhadap pemula yang mau belajar.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'mindset'
            ],

            // --- Kategori Latihan di Rumah (Home Workout) ---
            [
                'pertanyaan' => 'Apakah saya bisa membentuk otot hanya dengan latihan beban tubuh (Bodyweight/Kalistenik) di rumah?',
                'jawaban_singkat' => 'Tentu bisa. Otot tidak tahu bedanya beban besi atau beban badan sendiri. Asalkan Anda terus menambah tingkat kesulitan (Progressive Overload), otot akan tumbuh.',
                'contoh' => 'Jika push-up biasa sudah terlalu mudah, Anda bisa beralih ke archer push-up atau mengenakan tas berisi beban saat push-up.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Alat olahraga apa yang paling wajib dimiliki untuk pemula di rumah?',
                'jawaban_singkat' => 'Tiga alat paling direkomendasikan: Sepasang dumbbell yang bisa dibongkar pasang beratnya (adjustable), matras yoga, dan resistance band.',
                'contoh' => 'Hanya dengan sepasang dumbbell, Anda sudah bisa melatih otot dada, punggung, bahu, lengan, dan kaki sepenuhnya di ruang tamu.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Bagaimana cara melatih otot punggung jika tidak punya pull-up bar di rumah?',
                'jawaban_singkat' => 'Gunakan benda di sekitar Anda. Anda bisa melakukan gerakan tarikan menggunakan meja kuat, menggunakan resistance band di engsel pintu, atau latihan "Superman" di lantai.',
                'contoh' => 'Towel Row: Kaitkan handuk tebal di pilar rumah atau pegangan pintu yang kokoh, lalu tarik badan Anda ke arah pilar tersebut.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Saya tidak punya banyak ruang (kos-kosan), olahraga apa yang cocok?',
                'jawaban_singkat' => 'Latihan HIIT (High-Intensity Interval Training) atau senam lantai tanpa alat. Anda hanya membutuhkan ruang seukuran matras untuk berkeringat deras.',
                'contoh' => 'Kombinasi gerakan Burpees, Jumping Jacks, dan Mountain Climbers selama 15 menit sudah cukup membakar kalori setara jogging 30 menit.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan_di_rumah'
            ],
            
            // --- Tambahan Kategori Latihan ---
            [
                'pertanyaan' => 'Apa bedanya latihan hipertrofi dan kekuatan (strength)?',
                'jawaban_singkat' => 'Hipertrofi fokus pada pembesaran ukuran otot (biasanya dengan beban sedang, 8-12 repetisi). Kekuatan fokus pada beban maksimal yang bisa diangkat (beban sangat berat, 1-5 repetisi).',
                'contoh' => 'Seorang binaragawan berlatih hipertrofi untuk bentuk tubuh, sedangkan atlet angkat besi berlatih strength untuk mengangkat seberat mungkin.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Seberapa penting Mind-Muscle Connection?',
                'jawaban_singkat' => 'Sangat penting. Merasakan otot yang bekerja memastikan Anda tidak hanya memindahkan beban dari titik A ke B menggunakan momentum, tetapi benar-benar merangsang serat otot target.',
                'contoh' => 'Saat melakukan Bicep Curl, fokuskan pikiran pada otot bisep yang memendek dan menegang, jangan hanya sekadar mengayunkan beban ke atas.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan'
            ],

            // --- Tambahan Kategori Latihan di Rumah ---
            [
                'pertanyaan' => 'Apa latihan kaki terbaik tanpa alat di rumah?',
                'jawaban_singkat' => 'Gerakan unilateral (satu kaki) sangat efektif meski tanpa beban ekstra. Contohnya Pistol Squats, Bulgarian Split Squats, atau Jump Squats untuk ledakan tenaga.',
                'contoh' => 'Taruh satu kaki di atas sofa belakang Anda (Bulgarian Split Squat) lalu lakukan squat satu kaki. Ini sangat membakar otot paha depan dan bokong.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'latihan_di_rumah'
            ],

            // --- Tambahan Kategori Nutrisi ---
            [
                'pertanyaan' => 'Berapa banyak air yang harus saya minum setiap hari?',
                'jawaban_singkat' => 'Minimal 2-3 liter per hari, atau lebih banyak jika Anda banyak berkeringat. Sel otot terdiri dari sekitar 70% air, sehingga dehidrasi akan menurunkan performa dan penyusutan volume otot.',
                'contoh' => 'Minum 500ml air satu jam sebelum latihan, dan teguk secara berkala selama latihan.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apakah saya harus menghindari garam/sodium sepenuhnya?',
                'jawaban_singkat' => 'Tidak! Sodium sangat penting untuk kontraksi otot dan membantu mendapatkan "pump" (aliran darah ke otot) saat latihan. Hanya hindari asupan berlebihan dari junk food.',
                'contoh' => 'Sedikit garam pada makanan utuh Anda tidak akan membuat Anda gemuk, malah mencegah kram otot.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'nutrisi'
            ],

            // --- Tambahan Kategori Pola Tidur & Recovery ---
            [
                'pertanyaan' => 'Apakah tidur siang membantu pemulihan?',
                'jawaban_singkat' => 'Ya, sangat membantu, terutama jika durasi tidur malam Anda kurang. Tidur siang (Power Nap) selama 20-40 menit dapat memulihkan kesegaran sistem saraf pusat.',
                'contoh' => 'Jika Anda hanya tidur 5 jam tadi malam, tidur siang 30 menit sebelum latihan sore bisa mengembalikan tenaga yang hilang.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apa itu "Deload Week"?',
                'jawaban_singkat' => 'Satu minggu penuh di mana Anda sengaja mengurangi intensitas beban atau volume latihan (sekitar 50%) agar persendian dan sistem saraf bisa pulih total.',
                'contoh' => 'Setelah 6 minggu berlatih sangat berat secara konsisten, ambil 1 minggu untuk mengangkat beban ringan saja sebelum kembali ke program beban berat.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'pola_tidur'
            ],

            // --- Tambahan Kategori Suplemen & Mitos ---
            [
                'pertanyaan' => 'Apakah berkeringat banyak berarti membakar lemak lebih banyak?',
                'jawaban_singkat' => 'MITOS. Keringat hanyalah mekanisme tubuh untuk mendinginkan suhu. Keringat yang keluar sebagian besar adalah air, bukan lemak yang mencair.',
                'contoh' => 'Memakai jaket parasut saat lari siang hari hanya akan membuat Anda dehidrasi parah, bukan membuat Anda lebih cepat kurus.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Benarkah makan karbohidrat di malam hari bikin gemuk?',
                'jawaban_singkat' => 'MITOS. Tubuh tidak punya "jam alarm" yang mengubah kalori menjadi lemak setelah jam 6 sore. Yang membuat gemuk adalah jika total kalori harian Anda melebihi batas.',
                'contoh' => 'Makan sepiring nasi jam 8 malam tidak apa-apa selama total asupan kalori Anda hari itu masih dalam batas defisit/maintenance.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'suplemen_mitos'
            ],

            // --- Tambahan Kategori Keamanan ---
            [
                'pertanyaan' => 'Bolehkah memakai sabuk angkat berat (Lifting Belt) terus-menerus?',
                'jawaban_singkat' => 'Tidak disarankan dipakai untuk setiap set. Gunakan HANYA pada set terberat (1-3 repetisi maksimal) agar otot core (inti) Anda secara alami terlatih menopang tulang belakang tanpa alat bantu.',
                'contoh' => 'Jangan pakai sabuk saat pemanasan atau saat melakukan latihan tangan (Bicep Curl). Pakai sabuk hanya untuk set terberat Squat atau Deadlift.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'keamanan'
            ],

            // --- Tambahan Kategori Mindset ---
            [
                'pertanyaan' => 'Saya merasa "stuck", angkatan beban dan berat badan tidak naik-naik (Plateau).',
                'jawaban_singkat' => 'Plateau adalah hal wajar setelah beberapa bulan. Solusinya: Ubah variasi gerakan, tambah asupan kalori (jika bulking), atau ambil Deload Week. Tubuh Anda mungkin sudah terlalu beradaptasi atau terlalu lelah.',
                'contoh' => 'Jika Barbell Bench Press Anda stuck di 60kg selama sebulan, coba ganti dengan Dumbbell Press selama 3 minggu untuk memberikan rangsangan berbeda.',
                'sumber_nama' => 'PraxisFit Guide',
                'sumber_url' => '#',
                'kategori' => 'mindset'
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['pertanyaan' => $faq['pertanyaan']], $faq);
        }

        $this->command->info('✅ Sukses memuat seluruh data FAQ & Bantuan Kebugaran!');
    }
}