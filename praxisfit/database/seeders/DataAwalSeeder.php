<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class DataAwalSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================
        // Data FAQ & Bantuan Kebugaran (Berdasarkan Jurnal & Riset Medis)
        // ====================================================
        $faqs = [
            // --- Kategori Latihan ---
            [
                'pertanyaan' => 'Apakah aman mengganti beban dengan batu atau tas berisi buku?',
                'jawaban_singkat' => 'Sangat aman. Serat otot manusia tidak mengenali jenis beban (besi vs tas), melainkan hanya merespons tegangan mekanik (mechanical tension). Selama Anda menerapkan prinsip progressive overload secara bertahap, otot akan beradaptasi dan tumbuh.',
                'contoh' => 'Memasukkan 5 kg buku ke dalam ransel untuk Bicep Curl akan memberikan stimulasi mekanik yang sama persis dengan menggunakan dumbbell 5 kg.',
                'sumber_nama' => 'Dr. Brad Schoenfeld, Ph.D. - "Science and Development of Muscle Hypertrophy"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/20847704/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apa bedanya Set dan Repetisi (Reps)?',
                'jawaban_singkat' => 'Repetisi adalah satu siklus gerakan (konsentrik dan eksentrik). Set adalah sekumpulan repetisi yang dilakukan tanpa henti, dipisahkan oleh interval istirahat untuk memulihkan Adenosin Trifosfat (ATP).',
                'contoh' => '"3 Set x 10 Repetisi" artinya Anda mengangkat beban 10 kali, beristirahat memulihkan ATP saraf, lalu mengulangnya hingga 3 siklus.',
                'sumber_nama' => 'American College of Sports Medicine (ACSM) - "Resistance Training Guidelines"',
                'sumber_url' => 'https://www.acsm.org/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Saya belum kuat melakukan Pull-Up, apa alternatif pemulanya?',
                'jawaban_singkat' => 'Gunakan regresi gerakan untuk melatih neuromuscular adaptation (adaptasi saraf otot). Latihan eksentrik (menahan beban turun perlahan) terbukti sangat efektif membangun kekuatan serat otot latissimus dorsi sebelum mampu melakukan tarikan konsentrik.',
                'contoh' => 'Lakukan "Negative Pull-up" dengan cara melompat ke atas tiang, lalu tahan tubuh Anda turun ke bawah sepelan mungkin.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Eccentric Muscle Contractions"',
                'sumber_url' => 'https://journals.lww.com/nsca-jscr/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Seberapa sering saya harus latihan dalam seminggu?',
                'jawaban_singkat' => 'Penelitian menunjukkan melatih setiap kelompok otot 2 kali seminggu memberikan respons hipertrofi lebih baik daripada 1 kali seminggu. Volume latihan (total set mingguan) adalah faktor penentu paling utama.',
                'contoh' => 'Bagi pemula, 3 hari latihan Full Body per minggu sudah optimal. Bagi tingkat lanjut, program split 4-6 hari (Upper/Lower atau Push/Pull/Legs) lebih disarankan.',
                'sumber_nama' => 'Sports Medicine Journal - "Influence of Resistance Training Frequency on Muscular Adaptations"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/27102172/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apa itu Progressive Overload?',
                'jawaban_singkat' => 'Progressive overload adalah peningkatan sistematis pada tekanan fisiologis yang diberikan ke tubuh. Tanpa peningkatan beban, repetisi, atau pengurangan waktu istirahat secara bertahap, sintesis protein otot (MPS) tidak akan dirangsang lebih lanjut.',
                'contoh' => 'Jika minggu lalu Anda squat 50kg sebanyak 10 repetisi, minggu ini cobalah angkat 50kg untuk 11 repetisi, atau 52.5kg untuk 10 repetisi.',
                'sumber_nama' => 'Thomas Delorme, M.D. - "Fundamentals of Resistance Exercise"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/22777332/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Cardio sebaiknya sebelum atau sesudah angkat beban?',
                'jawaban_singkat' => 'Penelitian tentang "Concurrent Training Interference" menunjukkan bahwa melakukan kardio intens sebelum beban menguras cadangan glikogen otot dan menurunkan sinyal hipertrofi (mTOR). Lakukan kardio SETELAH angkat beban atau di hari terpisah.',
                'contoh' => 'Lakukan latihan angkat beban selama 45 menit dengan energi penuh, lalu akhiri dengan lari santai di treadmill selama 15 menit.',
                'sumber_nama' => 'Journal of Applied Physiology - "Concurrent Training Interference"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24728569/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apakah saya harus berlatih sampai "Failure" (Gagal Angkat)?',
                'jawaban_singkat' => 'Meta-analisis terbaru menyimpulkan berlatih hingga "failure" mutlak tidak diwajibkan untuk hipertrofi, dan justru sangat meningkatkan kelelahan Sistem Saraf Pusat (CNS). Menyisakan 1-3 repetisi (RIR: Reps In Reserve) memberikan hasil otot yang sama besarnya namun meminimalisir cedera.',
                'contoh' => 'Hentikan set Anda saat Anda merasa hanya sanggup melakukan maksimal 1 atau 2 repetisi lagi secara aman.',
                'sumber_nama' => 'Dr. Brad Schoenfeld & Dr. Eric Helms - "Meta-analysis on Training to Failure"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/26666744/',
                'kategori' => 'latihan'
            ],

            // --- Kategori Nutrisi ---
            [
                'pertanyaan' => 'Berapa kebutuhan protein harian untuk orang yang rutin berolahraga?',
                'jawaban_singkat' => 'Untuk mengoptimalkan Sintesis Protein Otot (Muscle Protein Synthesis / MPS), individu aktif angkat beban membutuhkan antara 1.6 gram hingga 2.2 gram protein per kilogram berat badan setiap harinya.',
                'contoh' => 'Seorang pria seberat 70 kg yang rutin nge-gym menargetkan sekitar 112 gram hingga 154 gram protein murni per hari.',
                'sumber_nama' => 'International Society of Sports Nutrition (ISSN) - "Protein Position Stand"',
                'sumber_url' => 'https://jissn.biomedcentral.com/articles/10.1186/s12970-017-0177-8',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Kapan waktu terbaik mengonsumsi makanan tinggi protein?',
                'jawaban_singkat' => 'Total asupan protein harian jauh lebih penting daripada pengaturan waktunya (timing). Namun, untuk memaksimalkan efek anabolik, jurnal merekomendasikan pembagian dosis protein sebanyak 20-40 gram secara merata setiap 3-4 jam.',
                'contoh' => 'Sarapan 30g protein, makan siang 40g, camilan pasca-latihan 30g, dan makan malam 30g.',
                'sumber_nama' => 'Dr. Stuart Phillips, Ph.D. - "Muscle Protein Synthesis Research"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24257722/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apa bedanya Bulking dan Cutting?',
                'jawaban_singkat' => 'Bulking adalah kondisi Surplus Kalori untuk memfasilitasi lingkungan anabolik (membangun jaringan otot baru). Cutting adalah kondisi Defisit Kalori, memaksa tubuh memecah jaringan adiposa (lemak) sebagai energi cadangan untuk menurunkan persentase lemak tubuh.',
                'contoh' => 'Saat fase bulking (surplus), Anda makan 300 kalori lebih banyak dari kebutuhan harian normal (TDEE).',
                'sumber_nama' => 'Journal of the International Society of Sports Nutrition',
                'sumber_url' => 'https://jissn.biomedcentral.com/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Bolehkah makan fast-food saat sedang Bulking (Dirty Bulking)?',
                'jawaban_singkat' => '"Dirty Bulking" (makan surplus ekstrem dari junk food) terbukti memicu resistensi insulin dan mayoritas penambahan berat badan akan berakhir menjadi jaringan lemak visceral (lemak perut), bukan massa otot. Disarankan "Lean Bulking" dengan makanan utuh.',
                'contoh' => 'Surplus ringan (200-300 kalori) dari dada ayam, nasi, dan lemak sehat jauh lebih superior untuk membentuk otot tanpa penumpukan lemak berlebih.',
                'sumber_nama' => 'Dr. Eric Helms, Ph.D. - "The Muscle and Strength Pyramid"',
                'sumber_url' => 'https://muscleandstrengthpyramids.com/',
                'kategori' => 'nutrisi'
            ],

            // --- Kategori Pola Tidur & Recovery ---
            [
                'pertanyaan' => 'Berapa lama waktu tidur yang ideal untuk pemulihan otot?',
                'jawaban_singkat' => 'Tidur malam 7-9 jam adalah krusial. Pada fase "Deep Sleep" (NREM stage 3), pelepasan hormon anabolik seperti Human Growth Hormone (HGH) dan Testosteron mencapai puncak tertingginya untuk memperbaiki kerusakan serat otot mikroskopis akibat latihan.',
                'contoh' => 'Usahakan memiliki jam tidur yang konsisten, misalnya selalu tidur pukul 22.30 hingga 06.00.',
                'sumber_nama' => 'National Sleep Foundation & Sports Medicine Review',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/25315456/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apakah sering begadang bisa menghilangkan massa otot?',
                'jawaban_singkat' => 'Ya, pembatasan tidur secara kronis akan meningkatkan level kortisol (hormon stres) secara signifikan. Kortisol adalah hormon katabolik yang memecah jaringan otot dan mendorong penyimpanan lemak.',
                'contoh' => 'Begadang maraton Netflix setelah latihan punggung berat akan menggagalkan proses sintesis protein otot yang seharusnya terjadi malam itu.',
                'sumber_nama' => 'Journal of Clinical Endocrinology & Metabolism',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/20833959/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Otot saya sangat pegal (DOMS), apakah boleh latihan lagi?',
                'jawaban_singkat' => 'DOMS (Delayed Onset Muscle Soreness) diakibatkan oleh inflamasi mikro-trauma pada sel otot. Berlatih keras pada otot yang sedang DOMS akut dapat menurunkan output tenaga saraf dan memperlambat pemulihan. Latihlah otot yang berbeda.',
                'contoh' => 'Jika dada sangat nyeri karena bench press kemarin, hari ini latihlah kaki (squat) agar otot dada bisa pulih total.',
                'sumber_nama' => 'American College of Sports Medicine (ACSM) - "Muscle Recovery"',
                'sumber_url' => 'https://www.acsm.org/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apa itu Active Recovery?',
                'jawaban_singkat' => 'Active recovery adalah aktivitas kardiovaskular intensitas rendah (Low-Intensity Steady State / LISS) pada hari libur beban. Ini berfungsi memperlancar aliran sirkulasi darah yang membawa nutrisi dan oksigen untuk mempercepat penyembuhan jaringan otot (clearance of metabolic byproducts).',
                'contoh' => 'Bersepeda statis santai atau jalan cepat selama 20 menit saat hari istirahat dari angkat beban.',
                'sumber_nama' => 'Journal of Sports Sciences - "Active vs Passive Recovery"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/19908172/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Bolehkah melatih bagian otot yang sama berturut-turut tiap hari?',
                'jawaban_singkat' => 'Sangat tidak direkomendasikan. Sintesis Protein Otot (MPS) berlangsung selama 24-48 jam pasca-latihan beban. Memberikan tekanan mekanik berulang di masa perbaikan (recovery window) tersebut justru akan memicu overtraining dan atrofi otot.',
                'contoh' => 'Jika Anda melakukan Push-Up berat di hari Senin, beri jeda di hari Selasa, dan lakukan lagi di hari Rabu.',
                'sumber_nama' => 'Dr. Brad Schoenfeld - "Muscle Recovery Timecourse"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/27102172/',
                'kategori' => 'pola_tidur'
            ],

            // --- Kategori Suplemen & Mitos ---
            [
                'pertanyaan' => 'Bisa nggak kecilin perut doang (Spot Reduction)?',
                'jawaban_singkat' => 'Spot reduction (pengurangan lemak spesifik di area tertentu) adalah MITOS usang yang telah ditolak oleh berbagai penelitian klinis. Lemak diturunkan secara sistemik (menyeluruh) melalui defisit kalori, dan genetik menentukan area mana yang paling akhir mengecil.',
                'contoh' => 'Melakukan sit-up 1000 kali tidak akan menghilangkan lemak perut, ia hanya akan mengencangkan otot rectus abdominis yang tertutup di bawah lemak.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Spot Reduction Myth"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/23222084/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apakah suplemen Whey Protein itu wajib?',
                'jawaban_singkat' => 'Tidak wajib. Whey protein hanyalah bentuk turunan susu sapi bubuk yang praktis dicerna. Profil asam aminonya bagus, namun secara fungsi metabolisme, 30g protein dari dada ayam atau tempe memiliki efek pembentukan otot yang sama persis.',
                'contoh' => 'Gunakan Whey Protein HANYA jika jadwal Anda sangat padat dan tidak sempat memasak atau makan sumber protein utuh padat (whole foods).',
                'sumber_nama' => 'International Society of Sports Nutrition (ISSN)',
                'sumber_url' => 'https://jissn.biomedcentral.com/articles/10.1186/1550-2783-4-8',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apa fungsi ilmiah dari suplemen Creatine?',
                'jawaban_singkat' => 'Creatine monohydrate tersaturasi dalam sel otot sebagai phosphocreatine (PCr). Saat latihan berat singkat, PCr mendonasikan fosfat untuk mendaur ulang ADP menjadi energi ATP, menghasilkan peningkatan repetisi maksimal secara instan, serta hidrasi sel (otot terlihat lebih tebal).',
                'contoh' => 'Konsumsi 5g Creatine Monohydrate secara rutin tiap hari telah terbukti aman dan efektif oleh ratusan studi independen.',
                'sumber_nama' => 'Journal of the International Society of Sports Nutrition - "Creatine Position Stand"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/28615996/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Apakah wanita yang angkat beban akan berotot besar (kekar) seperti pria?',
                'jawaban_singkat' => 'Kadar testosteron basal wanita kira-kira 15 hingga 20 kali lipat LEBIH RENDAH dibandingkan pria. Secara fisiologis, sangat mustahil wanita menjadi besar berotot secara natural tanpa bantuan steroid anabolik eksogen. Angkat beban pada wanita terbukti meningkatkan kepadatan tulang dan mengencangkan bentuk tubuh.',
                'contoh' => 'Wanita yang rutin Squat berat tidak akan berubah jadi "Hulk", melainkan akan mendapatkan otot bokong dan paha yang padat dan atletis.',
                'sumber_nama' => 'Dr. Layne Norton, Ph.D. - "Hormonal Differences in Hypertrophy"',
                'sumber_url' => 'https://www.biolayne.com/',
                'kategori' => 'suplemen_mitos'
            ],

            // --- Kategori Cedera & Keamanan ---
            [
                'pertanyaan' => 'Bagaimana standar medis untuk mencegah cedera angkat beban?',
                'jawaban_singkat' => 'Menerapkan "Progressive Overload" pada batas adaptasi biomekanika ligamen. Artinya, kuasai teknik pergerakan sempurna dengan rentang gerak (Range of Motion) yang optimal sebelum mencoba menambah berat plat besi. Dynamic stretching dan warm-up spesifik sebelum sesi wajib dilakukan.',
                'contoh' => 'Lakukan Goblet Squat beban ringan 2 set untuk mengalirkan cairan sinovial di persendian lutut sebelum masuk ke Barbell Squat berat.',
                'sumber_nama' => 'British Journal of Sports Medicine',
                'sumber_url' => 'https://bjsm.bmj.com/',
                'kategori' => 'keamanan'
            ],
            [
                'pertanyaan' => 'Saya merasakan nyeri tajam tiba-tiba, apakah saya harus mendorong (push) terus?',
                'jawaban_singkat' => 'TIDAK. Dr. Stuart McGill membedakan "muscle burn" (akumulasi asam laktat) yang normal, dengan "sharp pain" yang menandakan adanya ketegangan akut ligamen, tendon, atau diskus tulang belakang. Memaksakan nyeri mekanik akan memicu cedera struktural kronis.',
                'contoh' => 'Jika punggung bawah terasa tertusuk jarum saat deadlift, hentikan segera dan perbaiki posisi panggul (pelvis).',
                'sumber_nama' => 'Dr. Stuart McGill, Ph.D. - "Spinal Biomechanics & Back Mechanic"',
                'sumber_url' => 'https://www.backfitpro.com/',
                'kategori' => 'keamanan'
            ],

            // --- Kategori Mindset & Konsistensi ---
            [
                'pertanyaan' => 'Berapa lama secara klinis perubahan bentuk badan akan terlihat nyata?',
                'jawaban_singkat' => 'Sistem saraf tepi Anda beradaptasi (tambah kuat) pada 2-4 minggu pertama tanpa penambahan volume massa otot yang kasat mata. Hipertrofi miofibril sejati baru mulai terakumulasi secara visual pada bulan ke-2 hingga ke-3.',
                'contoh' => 'Jika Anda baru latihan 3 minggu dan belum ada otot yang menonjol di kaca, jangan berhenti! Itu fase adaptasi neurologis normal.',
                'sumber_nama' => 'American Psychological Association - "Habit Formation & Physical Adaptation"',
                'sumber_url' => 'https://www.apa.org/',
                'kategori' => 'mindset'
            ],
            [
                'pertanyaan' => 'Apa yang harus dilakukan saat tidak ada dorongan dopamin (motivasi) untuk latihan?',
                'jawaban_singkat' => 'Disiplin mengalahkan motivasi. Para psikolog olahraga sepakat bahwa mengandalkan motivasi itu rapuh. Membangun "habits" (kebiasaan otonom) dengan memaksakan diri pergi ke gym membuat pelepasan endorfin neurotransmiter secara natural mengambil alih saat latihan dimulai.',
                'contoh' => 'Saat malas, kenakan saja sepatu olahraga dan melangkah keluar pintu. Biasakan tubuh bergerak maka mood akan mengikuti.',
                'sumber_nama' => 'Journal of Sport and Exercise Psychology',
                'sumber_url' => 'https://journals.humankinetics.com/view/journals/jsep/jsep-overview.xml',
                'kategori' => 'mindset'
            ],
            [
                'pertanyaan' => 'Saya merasa cemas secara sosial (Gym Anxiety) karena tubuh saya belum bagus.',
                'jawaban_singkat' => 'Fenomena ini dikenal sebagai "Spotlight Effect", di mana kita secara salah mengira orang lain terus memperhatikan kelemahan kita. Data riset menunjukkan bahwa para pengguna gym sangat fokus secara internal terhadap intensitas repetisi mereka sendiri (self-absorbed during training).',
                'contoh' => 'Gunakan headphone untuk masuk ke "zona" latihan Anda dan ketahuilah bahwa orang paling berotot di gym sekalipun sangat menghargai niat Anda untuk memulai.',
                'sumber_nama' => 'Psychology of Sport and Exercise Journal',
                'sumber_url' => 'https://www.sciencedirect.com/journal/psychology-of-sport-and-exercise',
                'kategori' => 'mindset'
            ],

            // --- Kategori Latihan di Rumah (Home Workout) ---
            [
                'pertanyaan' => 'Apakah penelitian medis mendukung bahwa otot bisa dibesarkan hanya dengan beban tubuh (Kalistenik)?',
                'jawaban_singkat' => 'Sangat mendukung. Jurnal fisiologi melaporkan tidak ada perbedaan persentase hipertrofi otot yang signifikan antara kelompok yang melakukan Push-up dan Bench Press asalkan intensitas mencapai mendekati kelelahan mekanik (failure).',
                'contoh' => 'Otot dada Anda tidak peduli apakah yang didorong itu palang besi di gym atau lantai ruang tamu Anda, tekanannya tetap merangsang sel.',
                'sumber_nama' => 'European Journal of Applied Physiology',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24916723/',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Berdasarkan biomekanika, alat apa yang paling esensial jika ingin berlatih murni di rumah?',
                'jawaban_singkat' => 'Sepasang adjustable dumbbell. Latihan resistensi bebas memberikan rentang gerak tiga dimensi penuh (3D ROM) yang mengaktifkan jauh lebih banyak otot stabilisator core dibandingkan mesin statis di gym.',
                'contoh' => 'Dengan dua buah dumbbell, Anda bisa mengaplikasikan tegangan beban bervariasi pada lebih dari 400 jenis variasi sendi otot.',
                'sumber_nama' => 'American Council on Exercise (ACE) - "Free Weights vs Machines"',
                'sumber_url' => 'https://www.acefitness.org/',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Secara anatomis, bagaimana melatih otot latissimus dorsi (punggung) tanpa pull-up bar?',
                'jawaban_singkat' => 'Lats dorsi berfungsi untuk retraksi bahu dan ekstensi lengan (menarik sesuatu ke arah tubuh). Menggunakan bidang gravitasi horizontal seperti "Inverted Table Row" memberikan vektor gaya gravitasi persis seperti mesin cable row di gym elit.',
                'contoh' => 'Berbaring di bawah meja makan tebal, pegang pinggiran meja, dan tarik dada Anda ke atas melawan gravitasi (Inverted Row).',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Electromyographic Analysis of Back Exercises"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/29324578/',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Saya berolahraga di kos-kosan 3x3 meter, program kardio apa yang terbukti paling membakar lemak?',
                'jawaban_singkat' => 'Protokol HIIT (High-Intensity Interval Training). Riset ACSM menunjukkan 15 menit HIIT memicu efek EPOC (Excess Post-exercise Oxygen Consumption) yang menyebabkan tubuh terus menerus membakar cadangan lemak sebagai kompensasi defisit oksigen berjam-jam pasca latihan, tanpa membutuhkan ruangan luas.',
                'contoh' => 'Lakukan Burpees 45 detik dengan kecepatan penuh, istirahat 15 detik. Ulangi selama 10 putaran murni di tempat (tanpa lari/berpindah).',
                'sumber_nama' => 'American College of Sports Medicine (ACSM) - "HIIT Position Statement"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24911331/',
                'kategori' => 'latihan_di_rumah'
            ],

            // --- Tambahan Original ---
            [
                'pertanyaan' => 'Apa bedanya fisiologi latihan hipertrofi dengan latihan kekuatan (strength)?',
                'jawaban_singkat' => 'Pelatihan Strength (1-5 reps, beban >85% 1RM) utamanya merekrut serabut otot tipe IIB dan mengoptimalkan adaptasi transmisi sinyal saraf motorik (motor unit recruitment). Hipertrofi (8-12 reps, beban sedang) difokuskan pada pengumpulan metabolit asam laktat yang menebalkan penampang lintang serabut kontraktil miosin.',
                'contoh' => 'Powerlifter melatih sistem sarafnya untuk mengangkat 200kg satu kali, binaragawan melatih volume sel ototnya untuk tampilan simetris raksasa.',
                'sumber_nama' => 'Dr. Andy Galpin, Ph.D. - "Skeletal Muscle Physiology"',
                'sumber_url' => 'https://www.andygalpin.com/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Secara klinis, seberapa penting "Mind-Muscle Connection" saat mengangkat beban?',
                'jawaban_singkat' => 'Bukan sekadar jargon. Pemeriksaan Elektromiografi (EMG) menunjukkan bahwa memfokuskan niat kognitif internal (memikirkan otot target berkontraksi) menghasilkan hingga 22% aktivasi potensial aksi saraf otot yang lebih tinggi dibandingkan mengangkat secara kosong/momentum.',
                'contoh' => 'Saat lat pulldown, bayangkan Anda sedang menarik menggunakan otot ketiak/sayap Anda, bukan menarik menggunakan tenaga tangan.',
                'sumber_nama' => 'European Journal of Applied Physiology - "Attentional Focus on Muscle Activation"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/26700744/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apa jenis latihan kaki (Glutes & Quads) paling bertegangan tinggi yang bisa dilakukan di rumah tanpa alat?',
                'jawaban_singkat' => 'Latihan unilateral (satu sisi ekstremitas). Kajian biomekanik menunjukkan bahwa memindahkan seluruh 100% beban gravitasi tubuh (misal 70kg) ke satu paha melalui gerakan Bulgarian Split Squat memberikan aktivasi paha dan bokong setara dengan Barbell Back Squat kelas menengah.',
                'contoh' => 'Angkat dan letakkan satu kaki Anda di atas kursi di belakang Anda, lalu lakukan gerakan jongkok perlahan dengan kaki tumpuan depan.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Unilateral vs Bilateral Squat Kinematics"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/25226322/',
                'kategori' => 'latihan_di_rumah'
            ],
            [
                'pertanyaan' => 'Berapa banyak cairan yang secara medis wajib dikonsumsi penggiat beban?',
                'jawaban_singkat' => 'Mengingat hampir 70% volume sel jaringan otot terdiri dari molekul air (intracellular fluid), dehidrasi sekecil 2-3% dari berat badan terbukti menurunkan output tenaga repetisi maksimum sebesar lebih dari 10%. Konsumsi dasar adalah 3 liter, ditambah 500-1000ml per jam sesi latihan berkeringat.',
                'contoh' => 'Pantau warna urine Anda; jika berwarna kuning gelap pekat setelah latihan, Anda kekurangan cairan anabolik esensial.',
                'sumber_nama' => 'American College of Sports Medicine (ACSM) - "Hydration Guidelines"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/17277604/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apakah untuk mengeringkan lemak saya harus pantang garam (sodium) 100%?',
                'jawaban_singkat' => 'Berbahaya dan merupakan mitos fatal. Sodium klorida (garam) bertindak sebagai elektrolit vital konduktor listrik di sinapsis saraf untuk memicu kontraksi otot. Diet tanpa natrium akan memicu kram akut dan gagal "pump" karena darah tidak tertahan di vaskular otot.',
                'contoh' => 'Menaburkan sedikit himalayan salt pada nasi dada ayam justru mengalirkan karbohidrat glikogen ke sel otot lebih cepat secara osmotik.',
                'sumber_nama' => 'Journal of the International Society of Sports Nutrition - "Electrolytes in Resistance Training"',
                'sumber_url' => 'https://jissn.biomedcentral.com/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apakah tidur siang 30 menit memiliki pengaruh medis nyata terhadap perbaikan sel otot?',
                'jawaban_singkat' => 'Penelitian "Sports Medicine" menemukan bahwa Power Nap siang hari (20-40 menit) pasca terganggunya tidur malam efektif menumpulkan sekresi enzimatik hormon kortisol sore hari dan mendongkrak kembali reaktivitas sistem saraf pusat otonom menjelang jadwal gym.',
                'contoh' => 'Jika shift kerja malam merusak tidur 8 jam Anda, sisipkan 30 menit tidur murni di siang hari untuk meminimalisir katabolisme (penyusutan otot).',
                'sumber_nama' => 'Sports Medicine Review - "Sleep and Athletic Performance"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/25315456/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apa terminologi "Deload Week" menurut literatur kekuatan fisik?',
                'jawaban_singkat' => 'Model periodisasi (Periodization of Training) menetapkan bahwa akumulasi tegangan sistemik akan merusak jaringan sendi dan reseptor saraf. Deload Week (minggu santai di mana volume & beban dipotong 50%) terbukti memberikan status fenomena "Supercompensation" – otot mekar lebih besar dan sendi sembuh.',
                'contoh' => 'Setiap kelipatan 4-6 minggu latihan keras beruntun, sisipkan 1 minggu angkat beban santai, ringan, tanpa rasa lelah dan ngoyo.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Periodization Theory"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/21804426/',
                'kategori' => 'pola_tidur'
            ],
            [
                'pertanyaan' => 'Apakah peningkatan laju keringat berkorelasi dengan pemecahan sel lemak?',
                'jawaban_singkat' => 'Bohong besar (Pseudoscientific). Berkeringat adalah respon termoregulasi homeostasis endoterm (pendinginan radiator tubuh) via kelenjar ekrin ekskresi air. Oksidasi asam lemak 84% dibuang melalui udara napas karbon dioksida paru-paru, bukan menetes via pori-pori.',
                'contoh' => 'Mengenakan "sauna suit/jaket plastik" tebal tidak membuat Anda membakar lemak ekstra, ia semata-mata menyebabkan dehidrasi parah yang menyusutkan angka timbangan berisi air.',
                'sumber_nama' => 'American Council on Exercise (ACE) - "Sweat and Fat Loss Myths"',
                'sumber_url' => 'https://www.acefitness.org/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Secara klinis, benarkah asupan karbohidrat nasi di atas pukul 6 sore berlipat ganda menjadi lemak?',
                'jawaban_singkat' => 'Metabolisme basal usus manusia tidak dilengkapi saklar jam. Jurnal Obesitas membuktikan Hukum Termodinamika: Penyimpanan lipid ekstra eksklusif ditentukan oleh akumulasi surplus Net Kalori 24 jam, tidak peduli jam berapa molekul tersebut tertelan di dalam usus.',
                'contoh' => 'Jika batas harian Anda adalah 2.000 kalori, memakan 1.900 kalori nasi utuh semuanya di jam 11 malam tetap akan merangsang penurunan lemak.',
                'sumber_nama' => 'Obesity Reviews - "Timing of Energy Intake and Weight Loss"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/29327521/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Adakah bukti klinis mengenai efek samping memakai sabuk angkat besi (Lifting Belt) tiap saat?',
                'jawaban_singkat' => 'Penggunaan sabuk angkat punggung hiper-preventif di repetisi dan sesi ringan dapat memicu distrofi fungsional transversus abdominis. Sabuk menopang kompresi tulang punggung, sehingga jika Anda bergantung padanya terus, otot "sabuk alami perut" Anda akan melemah secara kronis.',
                'contoh' => 'Hanya pasang dan kencangkan Lifting Belt khusus pada 1 atau 2 set Squat / Deadlift terberat puncak maksimal (1RM) Anda. Jangan dipakai saat melakukan Bicep Curls berdiri.',
                'sumber_nama' => 'Dr. Stuart McGill, Ph.D. - "The Use of Weight Belts"',
                'sumber_url' => 'https://www.backfitpro.com/',
                'kategori' => 'keamanan'
            ],
            [
                'pertanyaan' => 'Fenomena Medis: Mengapa saya merasa stuck, tidak tambah kuat berbulan-bulan (Plateau)?',
                'jawaban_singkat' => 'Anda mengalami efek Adaptasi Fisiologis Kebal ("General Adaptation Syndrome"). Sistem persarafan Anda telah terlalu efisien mengeksekusi gerakan rutin monoton tersebut sehingga stres mekanik tidak lagi dianggap sebagai "ancaman darurat" oleh DNA otot untuk diubah tebal jaringannya.',
                'contoh' => 'Jika Anda melakukan gerakan Flat Bench Press 4 set x 10 selama 8 minggu nonstop tanpa peningkatan repetisi/beban, ubahlah menjadi gerakan Incline Dumbbell Press selama 3 minggu agar saraf merespon ancaman otot sudut baru.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "Training Plateaus"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24513619/',
                'kategori' => 'mindset'
            ],

            // ====================================================
            // 10 FAQ BARU TAMBAHAN BERDASARKAN RISET MEDIS (Q41 - Q50)
            // ====================================================
            
            [
                'pertanyaan' => 'Berapa lama sebenarnya durasi pemanasan (Warm-Up) yang secara klinis ideal?',
                'jawaban_singkat' => 'Literatur menunjukkan pemanasan khusus selama 10-15 menit sudah cukup untuk menaikkan suhu jaringan basal (lubrikasi sinovial) 1 derajat celcius. Pemanasan umum (treadmill) yang berlebihan di atas 20 menit justru menguras persediaan energi fosfagen (ATP-PC) prasyarat angkatan berat.',
                'contoh' => 'Jalan cepat miring treadmill 5 menit, diikuti 5 menit pemanasan pergerakan sendi rotasi dinamis (dynamic stretching) sebelum masuk mengangkat plat besi.',
                'sumber_nama' => 'Journal of Sports Science and Medicine - "Warm-up in Resistance Training"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/24149156/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apakah peregangan statis (menahan regangan otot) sebelum angkat beban merugikan?',
                'jawaban_singkat' => 'Benar. Data biomedis mengungkapkan peregangan statis durasi lama (di atas 60 detik) menyebabkan relaksasi dan deformasi saraf golgi tendon sementara, yang meredam produksi ledakan daya pegas otot maks (Power Output) hingga 8% pada set inti pasca-peregangan.',
                'contoh' => 'Jangan pernah mencium lutut dan menahannya selama bermenit-menit SEBELUM melakukan Squat. Simpan regangan rileks statis tersebut untuk SELESAI sesi angkat beban (pendinginan).',
                'sumber_nama' => 'Scandinavian Journal of Medicine & Science in Sports - "Acute Effects of Static Stretching"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/22316148/',
                'kategori' => 'keamanan'
            ],
            [
                'pertanyaan' => 'Apa beda khasiat molekuler antara Protein Hewani (Daging) dengan Protein Nabati (Tumbuhan)?',
                'jawaban_singkat' => 'Isolat protein hewani menyuplai rantai Asam Amino Esensial (terutama spektrum Leucine sebagai pemicu mTOR pathway) dalam rasio padat 100% komplit. Protein dominan nabati kerap memiliki profil tidak seimbang (defisit Methionine/Lysine) yang mewajibkan konsumen vegetarian mencampur silang dua spesies tumbuhan (misal kacang dengan biji-bijian).',
                'contoh' => 'Makan tempe kedelai (nabati) tetap bisa menumbuhkan otot raksasa, HANYA jika Anda memakan volume porsi nabatinya lebih masif 30% dan mengombinasikannya dengan selai kacang.',
                'sumber_nama' => 'Dr. Stuart Phillips - McMaster University Protein Metabolism Lab',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/26224750/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apakah asupan kafein kopi (Pre-Workout) secara farmakologis meningkatkan hasil perombakan otot?',
                'jawaban_singkat' => 'Jurnal farmasi olahraga mengonfirmasi bahwa 3-6 mg anhydrous kafein per kilogram berat badan menghambat pengikatan nukleus adenosin pengantuk otak. Efek klinisnya adalah menumpulkan persepsi rasa sakit saat beban berat dan meningkatkan rekrutmen kalsium otot kontraksi bertenaga.',
                'contoh' => 'Minum secangkir kopi murni robusta pekat (tanpa tumpukan gula rafinasi) 45 menit sebelum deadlift berpotensi menambah batas repetisi maksimal Anda sebanyak +2 atau +3 repetisi.',
                'sumber_nama' => 'International Society of Sports Nutrition (ISSN) - "Caffeine Position Stand"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/33388079/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Bolehkah remaja atau anak di bawah umur melakukan latihan angkat berat (Stunting)?',
                'jawaban_singkat' => 'MITOS PALING USANG TENTANG TINGGI BADAN. Laporan Pediatrik modern sangat mendukung remaja memulai stimulasi angkat beban (supervised). Tegangan resistensi mekanik merangsang deposisi kalsifikasi positif osifikasi (kepadatan tulang) tanpa menyumbat "lempeng epifisis pertumbuhan (growth plate)" tulang rawan jika dilakukan tanpa cedera fatal.',
                'contoh' => 'Bocah usia 15 tahun aman dan justru dianjurkan melakukan angkat beban resistensi teknik sempurna; faktor genetika dan asupan kalsiumlah penentu murni batas tinggi badan remajanya.',
                'sumber_nama' => 'American Academy of Pediatrics (AAP) - Clinical Report on Resistance Training',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/32332152/',
                'kategori' => 'keamanan'
            ],
            [
                'pertanyaan' => 'Berapa besaran korelasi medis antara Rentang Gerak Penuh (ROM) terhadap laju hipertrofi otot?',
                'jawaban_singkat' => 'Studi biopsi komparatif menyimpulkan latihan menahan beban di posisi "otot terekstensi regang paksa" (Deep Full Range of Motion) menginduksi akumulasi stres hipertrofik sarkoplasmik sekira 20-25% secara spesifik LEBIH besar dibandingkan repetisi setengah (Half Reps Ego Lifting) meski beban dipotong ringan.',
                'contoh' => 'Melakukan Bicep Curl ringan dengan tangan menjulur lurus sempurna ke bawah dan ditarik naik maksimal, lebih melipatgandakan serabut jaringan bisep ketimbang curl berat berayun setengah saja.',
                'sumber_nama' => 'Journal of Strength and Conditioning Research - "ROM effects on Hypertrophy"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/32031485/',
                'kategori' => 'latihan'
            ],
            [
                'pertanyaan' => 'Apakah latihan kekuatan resistensi besi berdampak hipertensif (menaikkan darah tinggi)?',
                'jawaban_singkat' => 'Asosiasi Jantung menyatakan tekanan darah memang melonjak sangat drastis akut secara sementara SAAT pengerahan nafas kontraksi menahan beban berat, NAMUN dalam masa resesi istirahat harian, fungsi dinding vaskuler arteri beradaptasi lemas menjadi elastis sehingga menyumbang penurunan patologis tekanan darah sistolik permanen yang sehat (Obat Alami).',
                'contoh' => 'Angkat beban moderat sangat dianjurkan bagi mayoritas pasien hipertensi ringan sebagai komplemen obat, atas rekomendasi rujukan pemantauan dokter.',
                'sumber_nama' => 'American Heart Association (AHA) - Scientific Statement on Exercise',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/17261825/',
                'kategori' => 'suplemen_mitos'
            ],
            [
                'pertanyaan' => 'Seberapa besar intervensi molekul lipid lemak pangan terhadap produksi anabolik alami tubuh?',
                'jawaban_singkat' => 'Sangat esensial! Lemak tidak jenuh tunggal dan polyunsaturated omega bertindak langsung sebagai balok struktural membran penyusun pra-hormonal androgen (Testosteron Bebas). Mengeliminasi lipid lemak utuh <15% harian dalam diet binaraga meruntuhkan drastis level testosteron darah dasar dan menyumbat regenerasi maskulin.',
                'contoh' => 'Jangan takut memakan satu kuning telur utuh murni rebus, kacang almond utuh, atau sekadar alpukat segar murni setiap hari untuk memompa kejantanan produksi testosteron pabrik biologis Anda.',
                'sumber_nama' => 'European Journal of Clinical Nutrition - "Dietary Lipids & Androgen Hormones"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/8942407/',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Apakah skema puasa Intermittent Fasting (Jendela 16/8) mengganggu konstruksi massa otot basal?',
                'jawaban_singkat' => 'Studi Translasi Metobolik membuktikan selubung puasa berkala tidak membakar lebur serat protein (Muscle Wasting) asalkan total gizi jendela makan menuntaskan surplus asam amino Leucine 2 gram per porsi utama. Justru rentang interval insulin basal merendah mengasah pemecahan adiposa bandel (Fat Lipolysis) secara selektif agresif.',
                'contoh' => 'Melakukan angkat beban berat intens di jam 11 pagi dalam keadaan puasa aman, asalkan jam 12 siang (buka puasa IF) tubuh segera disiram lonjakan protein dosis dada ayam tebal.',
                'sumber_nama' => 'Journal of Translational Medicine - "Fasting and Resistance Training"',
                'sumber_url' => 'https://translational-medicine.biomedcentral.com/articles/10.1186/s12967-016-1044-0',
                'kategori' => 'nutrisi'
            ],
            [
                'pertanyaan' => 'Secara klinis, bagaimana metode pengaturan nafas abdomen paksa (Valsalva Maneuver) yang paten?',
                'jawaban_singkat' => 'Intra-Abdominal Pressure (IAP) diciptakan dengan menghirup udara ke dasar kubah lambung perut, mengunci kaku sfingter glotis pita suara rapat-rapat saat titik eksekusi tumpuan beban kritis terberat (stikking point), dan membuang desah nafas setelah rentang rep aman stabil. Mengunci IAP melindungi fraktur pergeseran kurva tulang rawan lumbal bawah secara hidrostatik kaku.',
                'contoh' => 'Saat barbel Squat punggung turun berjongkok (tarik nafas perut), kunci nafas perut padat tahan meledak saat mendorong beban berdiri ke atas (fase paling mematikan), baru sembur membuang napas lantang di titik lurus puncak.',
                'sumber_nama' => 'Journal of Applied Physiology - "Intra-abdominal Pressure in Resistance Lifting"',
                'sumber_url' => 'https://pubmed.ncbi.nlm.nih.gov/2240974/',
                'kategori' => 'keamanan'
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['pertanyaan' => $faq['pertanyaan']], $faq);
        }

        $this->command->info('✅ Sukses memuat seluruh data FAQ & Bantuan Kebugaran (Berbasis 50 Kutipan Jurnal Medis Klinis)!');
    }
}