<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Soal;
use App\Models\PilihanJawaban;

class SoalPretestBADosenSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::where('nama_event', 'like', '%Baitul Arqam%')->first() ?: Event::first();
        if (!$event) {
            $this->command->warn('Tidak ada event yang ditemukan untuk menempelkan Soal Pretest.');
            return;
        }

        // 20 soal asli dari file DOCX
        $questions = [
            [
                'teks' => 'Salah satu aspek penting dalam Ideologi Muhammadiyah adalah Matan Keyakinan dan Cita-Cita Hidup Muhammadiyah (MKCH). MKCH berfungsi sebagai:',
                'pilihan' => [
                    ['A', 'Pedoman administratif organisasi dalam pengelolaan PTM', false],
                    ['B', 'Rujukan utama dalam memahami Al-Qur’an dan Hadis', false],
                    ['C', 'Dasar keyakinan yang mengikat setiap kader Muhammadiyah dalam berpikir dan bertindak', true],
                    ['D', 'Standar kurikulum pendidikan Muhammadiyah di tingkat perguruan tinggi', false]
                ]
            ],
            [
                'teks' => '“Islam Berkemajuan” dalam konsep Muhammadiyah menekankan pada:',
                'pilihan' => [
                    ['A', 'Mempertahankan tradisi tanpa perubahan', false],
                    ['B', 'Mengutamakan kepentingan kelompok di atas kepentingan umat', false],
                    ['C', 'Perpaduan antara nilai-nilai keislaman dengan perkembangan ilmu pengetahuan dan teknologi', true],
                    ['D', 'Menolak pemikiran modern dalam memahami ajaran Islam', false]
                ]
            ],
            [
                'teks' => 'Dalam Manhaj Tarjih Muhammadiyah, pendekatan yang digunakan dalam memahami hukum Islam adalah:',
                'pilihan' => [
                    ['A', 'Taklid kepada mazhab tertentu', false],
                    ['B', 'Bayani, Burhani dan Irfani', true],
                    ['C', 'Mengacu sepenuhnya pada pendapat ulama klasik tanpa pembaruan', false],
                    ['D', 'Hanya mengikuti pemikiran Imam Syafi’i', false]
                ]
            ],
            [
                'teks' => 'Konsep 12 Langkah Muhammadiyah bertujuan untuk:',
                'pilihan' => [
                    ['A', 'Memisahkan urusan agama dari kehidupan sosial', false],
                    ['B', 'Mengembangkan pola pikir pragmatis dalam berorganisasi', false],
                    ['C', 'Memperkokoh amal usaha Muhammadiyah dengan nilai-nilai Islam', true],
                    ['D', 'Mengurangi peran Muhammadiyah dalam pendidikan dan dakwah', false]
                ]
            ],
            [
                'teks' => 'Prinsip utama dalam Pedoman Hidup Islami Warga Muhammadiyah (PHIWM) adalah:',
                'pilihan' => [
                    ['A', 'Menjaga eksklusivitas warga Muhammadiyah dari masyarakat umum', false],
                    ['B', 'Menyelaraskan kehidupan pribadi, sosial, dan organisasi dengan nilai-nilai Islam', true],
                    ['C', 'Mengutamakan aspek formal organisasi dibandingkan akhlak individu', false],
                    ['D', 'Membatasai interaksi warga Muhammadiyah dengan kelompok lain', false]
                ]
            ],
            [
                'teks' => 'KH Ahmad Dahlan dikenal sebagai tokoh pembaharu Islam di Indonesia karena:',
                'pilihan' => [
                    ['A', 'Mengajarkan Islam dengan pendekatan tradisional tanpa perubahan', false],
                    ['B', 'Menolak pendidikan modern dalam sistem Islam', false],
                    ['C', 'Mengintegrasikan nilai-nilai Islam dengan pendidikan dan sosial kemasyarakatan', true],
                    ['D', 'Menghapus sistem pendidikan formal dalam Islam', false]
                ]
            ],
            [
                'teks' => 'Dalam Manhaj Tarjih Muhammadiyah, konsep Tajdid merujuk pada:',
                'pilihan' => [
                    ['A', 'Mengikuti tradisi lama tanpa perubahan', false],
                    ['B', 'Pembaruan pemikiran dan praktik keislaman berdasarkan dalil yang sahih', true],
                    ['C', 'Menolak semua pendapat ulama terdahulu', false],
                    ['D', 'Mengadopsi semua pemikiran modern tanpa seleksi', false]
                ]
            ],
            [
                'teks' => 'Salah satu tantangan utama Muhammadiyah dalam menghadapi ideologi Islam (lain) di Indonesia adalah:',
                'pilihan' => [
                    ['A', 'Kurangnya kader yang memahami prinsip Islam Berkemajuan', true],
                    ['B', 'Tidak adanya pengaruh Muhammadiyah dalam dunia pendidikan', false],
                    ['C', 'Penolakan Muhammadiyah terhadap pemikiran keislaman global', false],
                    ['D', 'Muhammadiyah tidak memiliki Amal Usaha yang kuat', false]
                ]
            ],
            [
                'teks' => 'Profil Dosen Muhammadiyah idealnya mencerminkan:',
                'pilihan' => [
                    ['A', 'Profesionalisme akademik tanpa keterlibatan dalam dakwah', false],
                    ['B', 'Penguasaan ilmu pengetahuan yang berpihak pada kepentingan pribadi', false],
                    ['C', 'Sinergi antara kompetensi akademik dan komitmen terhadap nilai-nilai Muhammadiyah', true],
                    ['D', 'Independensi total dari organisasi keislaman', false]
                ]
            ],
            [
                'teks' => 'Peran dosen dalam penguatan nilai-nilai sosial kemanusiaan di PTM mencakup:',
                'pilihan' => [
                    ['A', 'Menjaga eksklusivitas ilmu hanya untuk kalangan tertentu', false],
                    ['B', 'Menjunjung tinggi keadilan, kepedulian sosial, dan keteladanan dalam sikap', true],
                    ['C', 'Memisahkan aspek moral dari kehidupan akademik', false],
                    ['D', 'Menekankan keuntungan materi dalam menjalankan profesi', false]
                ]
            ],
            [
                'teks' => 'Outbond dalam perkaderan Muhammadiyah bertujuan untuk:',
                'pilihan' => [
                    ['A', 'Mengajarkan teknik bertahan hidup di alam bebas', false],
                    ['B', 'Memperkuat keterampilan kepemimpinan dan kerja sama tim', true],
                    ['C', 'Melatih peserta dalam menghadapi konflik politik', false],
                    ['D', 'Mengembangkan keterampilan akademik tanpa aspek sosial', false]
                ]
            ],
            [
                'teks' => 'Risalah Akhlak Dosen Muhammadiyah menekankan pada:',
                'pilihan' => [
                    ['A', 'Keunggulan akademik sebagai satu-satunya indikator keberhasilan dosen', false],
                    ['B', 'Penguatan akhlak sebagai dasar interaksi dengan mahasiswa dan masyarakat', true],
                    ['C', 'Fokus pada pencapaian individu tanpa memperhatikan lingkungan sekitar', false],
                    ['D', 'Menjaga jarak dengan mahasiswa untuk mempertahankan profesionalisme', false]
                ]
            ],
            [
                'teks' => 'Sinergi antara PTM dan cabang/ranting Muhammadiyah diperlukan untuk:',
                'pilihan' => [
                    ['A', 'Memperkuat basis kaderisasi dan dakwah di lingkungan akademik dan masyarakat', true],
                    ['B', 'Memisahkan dunia akademik dari gerakan sosial keagamaan', false],
                    ['C', 'Meningkatkan jumlah mahasiswa tanpa memperhatikan aspek ideologis', false],
                    ['D', 'Mengurangi interaksi antara akademisi dan masyarakat', false]
                ]
            ],
            [
                'teks' => 'Muhammadiyah menekankan pentingnya peran PTM sebagai media dakwah, salah satunya dengan:',
                'pilihan' => [
                    ['A', 'Mengembangkan riset dan kajian yang berbasis nilai Islam Berkemajuan', true],
                    ['B', 'Menjaga PTM tetap netral dari nilai-nilai agama', false],
                    ['C', 'Mengurangi keterlibatan dosen dalam kegiatan sosial keagamaan', false],
                    ['D', 'Menyediakan pendidikan eksklusif untuk kader Muhammadiyah', false]
                ]
            ],
            [
                'teks' => 'Bagaimana penerapan Islam Berkemajuan dapat diintegrasikan dalam proses pembelajaran?',
                'pilihan' => [
                    ['A', 'Mengintegrasikan nilai-nilai Islam dalam setiap mata kuliah yang diajarkan', true],
                    ['B', 'Mengutamakan pendekatan sekuler dalam pengajaran', false],
                    ['C', 'Memisahkan nilai-nilai keislaman dari metode pengajaran', false],
                    ['D', 'Mengabaikan aspek spiritual dalam kurikulum', false]
                ]
            ],
            [
                'teks' => 'Seorang dosen Muhammadiyah harus menjadi teladan dalam akhlak dan keilmuan. Langkah konkret yang paling tepat adalah:',
                'pilihan' => [
                    ['A', 'Fokus pada pengajaran tanpa interaksi dengan mahasiswa', false],
                    ['B', 'Menunjukkan keteladanan dalam sikap, tutur kata, dan tanggung jawab akademik', true],
                    ['C', 'Hanya mengikuti standar akademik tanpa menerapkan nilai-nilai Islam', false],
                    ['D', 'Mengandalkan prestasi individu tanpa kolaborasi', false]
                ]
            ],
            [
                'teks' => 'Dalam membangun sinergi antara PTM dan ranting Muhammadiyah, langkah strategis yang tepat adalah:',
                'pilihan' => [
                    ['A', 'Meningkatkan keterlibatan dosen dalam pengembangan dakwah berbasis akademik', true],
                    ['B', 'Mengurangi interaksi antara PTM and ranting Muhammadiyah', false],
                    ['C', 'Memusatkan kegiatan pada satu institusi saja', false],
                    ['D', 'Mengabaikan peran organisasi otonom dalam kaderisasi', false]
                ]
            ],
            [
                'teks' => 'Sikap terbaik dalam memahami ideologi Muhammadiyah bagi dosen PTMA adalah:',
                'pilihan' => [
                    ['A', 'Konsisten dalam menginternalisasi dan mengamalkan nilai-nilai Muhammadiyah', true],
                    ['B', 'Mengadaptasi nilai sesuai situasi tanpa konsistensi', false],
                    ['C', 'Menyesuaikan nilai dengan kepentingan pribadi', false],
                    ['D', 'Mengabaikan prinsip ideologi demi kemudahan akademik', false]
                ]
            ],
            [
                'teks' => 'Peran utama dosen PTMA dalam kaderisasi mahasiswa adalah:',
                'pilihan' => [
                    ['A', 'Menjadi mentor dan fasilitator dalam penguatan ideologi Muhammadiyah', true],
                    ['B', 'Hanya fokus pada pengajaran teoretis', false],
                    ['C', 'Mengutamakan penelitian tanpa pembinaan mahasiswa', false],
                    ['D', 'Menghindari keterlibatan dalam aktivitas sosial keagamaan', false]
                ]
            ],
            [
                'teks' => 'Pendekatan kepemimpinan yang sesuai dengan prinsip Muhammadiyah adalah:',
                'pilihan' => [
                    ['A', 'Kepemimpinan otoriter tanpa konsultasi', false],
                    ['B', 'Kepemimpinan kolektif berbasis musyawarah dan nilai-nilai Islam', true],
                    ['C', 'Kepemimpinan individualistik yang mengutamakan pendapat pribadi', false],
                    ['D', 'Kepemimpinan yang mengabaikan nilai spiritual dalam pengambilan keputusan', false]
                ]
            ]
        ];

        // Hapus soal pretest lama agar fresh
        $oldSoalIds = Soal::where('event_id', $event->id)->where('tipe', 'pretest')->pluck('id');
        PilihanJawaban::whereIn('soal_id', $oldSoalIds)->delete();
        Soal::whereIn('id', $oldSoalIds)->delete();

        $this->command->info("Menulis ulang " . count($questions) . " Soal Pretest dari DOCX...");

        $urutan = 1;
        foreach ($questions as $q) {
            $soal = Soal::create([
                'event_id'  => $event->id,
                'tipe'      => 'pretest',
                'teks_soal' => $q['teks'],
                'urutan'    => $urutan,
            ]);

            foreach ($q['pilihan'] as $p) {
                PilihanJawaban::create([
                    'soal_id'      => $soal->id,
                    'huruf'        => $p[0],
                    'teks_pilihan' => $p[1],
                    'is_correct'   => $p[2],
                ]);
            }
            $urutan++;
        }

        // Hapus & Duplikat soal posttest agar isinya sinkron
        $oldPostSoalIds = Soal::where('event_id', $event->id)->where('tipe', 'posttest')->pluck('id');
        PilihanJawaban::whereIn('soal_id', $oldPostSoalIds)->delete();
        Soal::whereIn('id', $oldPostSoalIds)->delete();

        $pretests = Soal::where('event_id', $event->id)->where('tipe', 'pretest')->with('pilihanJawaban')->get();
        foreach ($pretests as $pre) {
            $post = Soal::create([
                'event_id'  => $event->id,
                'tipe'      => 'posttest',
                'teks_soal' => $pre->teks_soal,
                'urutan'    => $pre->urutan,
            ]);

            foreach ($pre->pilihanJawaban as $pil) {
                PilihanJawaban::create([
                    'soal_id'      => $post->id,
                    'huruf'        => $pil->huruf,
                    'teks_pilihan' => $pil->teks_pilihan,
                    'is_correct'   => $pil->is_correct,
                ]);
            }
        }

        $this->command->info('Seeder Soal Pretest (20 Butir) dari file DOCX sukses disiapkan!');
    }
}
