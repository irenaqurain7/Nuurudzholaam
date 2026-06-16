<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\Program;
use App\Models\SchoolInfo;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    protected function schoolInfo(): SchoolInfo
    {
        try {
            return SchoolInfo::first() ?? new SchoolInfo();
        } catch (\Exception $e) {
            return new SchoolInfo();
        }
    }

    public function index()
    {
        $school = $this->schoolInfo();
        $announcements = Announcement::where('status', 'aktif')->orderBy('tanggal_mulai', 'desc')->take(3)->get();
        $activities = Activity::where('visibility', 'publik')->orderBy('tanggal', 'desc')->take(6)->get();
        $programs = Program::all();
        $galleries = Gallery::orderBy('tanggal', 'desc')->take(8)->get();

        // PPDB Status
        $today = now();
        $ppdbStatus = 'inactive'; // inactive, coming, open, closed

        if ($school && $school->ppdb_active) {
            if ($school->ppdb_start_date && $school->ppdb_end_date) {
                if ($today < $school->ppdb_start_date) {
                    $ppdbStatus = 'coming';
                } elseif ($today >= $school->ppdb_start_date && $today <= $school->ppdb_end_date) {
                    $ppdbStatus = 'open';
                } else {
                    $ppdbStatus = 'closed';
                }
            }
        }

        return view('index', compact('school', 'announcements', 'activities', 'programs', 'galleries', 'ppdbStatus'));
    }

    public function ppdb()
    {
        $school = $this->schoolInfo();
        $programs = Program::all();
        $announcements = Announcement::where('status', 'aktif')->where('tipe', 'ppdb')->first();

        return view('ppdb', compact('school', 'programs', 'announcements'));
    }

    public function kegiatan()
    {
        $school = $this->schoolInfo();
        $activities = Activity::where('visibility', 'publik')->orderBy('tanggal', 'desc')->paginate(9);

        return view('kegiatan', compact('school', 'activities'));
    }

    public function showActivity($id)
    {
        $school = $this->schoolInfo();
        $activity = Activity::where('visibility', 'publik')->findOrFail($id);
        $relatedActivities = Activity::where('visibility', 'publik')
            ->where('id', '!=', $id)
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();

        return view('kegiatan-detail', compact('school', 'activity', 'relatedActivities'));
    }

    public function program()
    {
        $school = $this->schoolInfo();

        return view('program', compact('school'));
    }

    public function profil()
    {
        $school = $this->schoolInfo();
        $galleries = Gallery::orderBy('tanggal', 'desc')->take(12)->get();
        $teachers = Teacher::with('user')->whereHas('user', function ($query) {
            $query->whereNotNull('profile_photo');
        })->get();

        // Mapping foto guru dari public/images/
        $teacherPhotos = [
            'A. Dede Ali, S.Pd' => 'a-dede-ali-s-pd.jpeg',
            'Wiwi Suherti, S.Pd' => 'wiwi-suherti-s-pd.jpeg',
            'Ade Royani, S.Pd' => 'ade-royani-s-pd.jpeg',
            'Siti Rokayah' => 'siti-rokayah.jpeg',
            'Siti Aminah' => 'siti-aminah.jpeg',
            'Warnengsih' => 'Warnengsih.jpeg',
            'Rinda Maryani, S.Pd' => 'rinda-maryani-s-pd.jpeg',
            'Mochamad Fazhri Syamsi' => 'mochamad-fazhri-syamsi.jpeg',
            'Dinda Aulia Putri' => 'dinda-aulia-putri.jpeg',
            'Kurnia Amelia' => 'Kurnia Amelia.jpeg',
            'Ananda Jihan Kamilah' => 'Ananda Jihan Kamilah.jpeg',
        ];

        // Fallback data jika tidak ada guru di database
        $defaultTeachers = [
            (object)['name' => 'A. Dede Ali, S.Pd', 'role' => 'Kepala Yayasan Raudhah Syarifah', 'photo' => $teacherPhotos['A. Dede Ali, S.Pd'] ?? null],
            (object)['name' => 'Wiwi Suherti, S.Pd', 'role' => 'Kepala Sekolah Nuurudzholaam', 'photo' => $teacherPhotos['Wiwi Suherti, S.Pd'] ?? null],
            (object)['name' => 'Ade Royani, S.Pd', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Ade Royani, S.Pd'] ?? null],
            (object)['name' => 'Siti Rokayah', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Siti Rokayah'] ?? null],
            (object)['name' => 'Siti Aminah', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Siti Aminah'] ?? null],
            (object)['name' => 'Warnengsih', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Warnengsih'] ?? null],
            (object)['name' => 'Rinda Maryani, S.Pd', 'role' => 'Tenaga Pendidik TK Nuurudzholaam', 'photo' => $teacherPhotos['Rinda Maryani, S.Pd'] ?? null],
            (object)['name' => 'Mochamad Fazhri Syamsi', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Mochamad Fazhri Syamsi'] ?? null],
            (object)['name' => 'Dinda Aulia Putri', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Dinda Aulia Putri'] ?? null],
            (object)['name' => 'Kurnia Amelia', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => $teacherPhotos['Kurnia Amelia'] ?? null],
            (object)['name' => 'Ananda Jihan Kamilah', 'role' => 'Tenaga Pendidik TK Nuurudzholaam', 'photo' => $teacherPhotos['Ananda Jihan Kamilah'] ?? null],
        ];

        // Coba deteksi foto otomatis di public/images berdasarkan nama guru
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        foreach ($defaultTeachers as $idx => $t) {
            // jika sudah ada foto ditentukan, cek apakah file ada; jika tidak, coba ekstensi lain
            if (!empty($t->photo)) {
                $path = public_path('images/' . $t->photo);
                if (!file_exists($path)) {
                    $base = pathinfo($t->photo, PATHINFO_FILENAME);
                    // try same base with other extensions
                    foreach ($extensions as $ext) {
                        $try = public_path("images/{$base}.{$ext}");
                        if (file_exists($try)) {
                            $defaultTeachers[$idx]->photo = basename($try);
                            break;
                        }
                    }

                    // try slug/underscore variants of the base
                    $variants = [Str::slug($base, '-'), Str::slug($base, '_')];
                    foreach ($variants as $v) {
                        foreach ($extensions as $ext) {
                            $try = public_path("images/{$v}.{$ext}");
                            if (file_exists($try)) {
                                $defaultTeachers[$idx]->photo = basename($try);
                                break 2;
                            }
                        }
                    }
                }
                continue;
            }

            // buat kandidat nama file dari nama guru
            $name = $t->name;
            $normalizedName = str_replace('.', ' ', $name);
            $candidates = [];
            $candidates[] = $name; // asli
            $candidates[] = preg_replace('/[.,]/', '', $name); // tanpa tanda baca
            $candidates[] = Str::slug($name, '-'); // slug
            $candidates[] = Str::slug($name, '_'); // underscore
            $candidates[] = Str::slug($normalizedName, '-'); // slug setelah titik jadi spasi
            $candidates[] = Str::slug($normalizedName, '_'); // underscore setelah titik jadi spasi

            $found = false;
            foreach ($candidates as $cand) {
                foreach ($extensions as $ext) {
                    $file = public_path("images/{$cand}.{$ext}");
                    if (file_exists($file)) {
                        $defaultTeachers[$idx]->photo = basename($file);
                        $found = true;
                        break 2;
                    }
                }
            }
        }

        return view('profil', compact('school', 'galleries', 'teachers', 'defaultTeachers'));
    }

    public function kontak()
    {
        $school = $this->schoolInfo();

        return view('kontak', compact('school'));
    }

    public function faq()
    {
        $school = $this->schoolInfo();
        try {
            $faqs = FAQ::orderBy('urutan')->get();
            // Paksa alamat Purwakarta jika data ditarik dari database
            foreach ($faqs as $faq) {
                if (str_contains(strtolower($faq->pertanyaan), 'lokasi sekolah')) {
                    $faq->jawaban = 'Sekolah Nuurudzholaam berlokasi di Kp, Jl. Sindang reret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181.';
                }
                if (str_contains(strtolower($faq->pertanyaan), 'apa itu nuurudzholaam')) {
                    $faq->jawaban = 'Nuurudzholaam (Nuzo) adalah pondok pesantren dan lembaga pendidikan Islam terpadu yang menyelenggarakan program pendidikan mulai dari TK, SD, SMP, SMK hingga pondok pesantren dengan memadukan kurikulum berbasis pesantren dan formal.';
                }
                if (str_contains(strtolower($faq->pertanyaan), 'antar-jemput') || str_contains(strtolower($faq->pertanyaan), 'biaya pendidikan')) {
                    $faq->pertanyaan = 'Berapa biaya pendidikan untuk sekolah?';
                    $faq->jawaban = 'Mengenai biaya pendidikan anda bisa langsung tanyakan kepada admin dengan cara menghubungi nomor yang tertera dan untuk anak yatim dan piatu biaya pendidikan gratis atau di tanggung oleh lembaga (yayasan).';
                }
                if (str_contains(strtolower($faq->pertanyaan), 'sistem pembelajaran')) {
                    $faq->jawaban = 'Pembelajaran dilaksanakan dengan sistem Full Day School dari hari Senin hingga Jumat  yang mengintegrasikan kurikulum dinas pendidikan dan program pembiasaan keagamaan seperti shalat dhuha berjama\'ah setiap hari, Apel pagi setiap hari senin, hapalan zuz amma setiap hari selasa, senam gembira setiap hari rabu, kegiatan literasi setiap hari kamis serta olahraga bersama setiap hari jumat dan seluruh kegiatan di laksanakan sebelum pembelajaran dimulai.';
                }
                if (str_contains(strtolower($faq->pertanyaan), 'fasilitas apa saja')) {
                    $faq->jawaban = 'Fasilitas pendukung di Nuurudzholaam meliputi ruang kelas yang nyaman, lab komputer untuk praktek TIK, perpustakaan, masjid sekolah, lapangan olahraga, area bermain khusus TK, Kantin sekolah, BLK (Balai latihan kerja), asrama putra putri atau pondok pesantren serta lingkungan sekolah yang asri dan aman.';
                }
                if (str_contains(strtolower($faq->pertanyaan), 'tersedia asrama') || str_contains(strtolower($faq->pertanyaan), 'tersedia pondok')) {
                    $faq->jawaban = 'Ya, kami menyediakan fasilitas asrama (pondok pesantren) bagi siswa dan siswi yang ingin mondok sambil bersekolah umum. Pembinaan asrama dilakukan oleh ustadz/ustadzah yang berpengalaman.';
                }
            }
        } catch (\Exception $e) {
            $faqs = collect();
        }

        return view('faq', compact('school', 'faqs'));
    }

    public function informasi()
    {
        $school = $this->schoolInfo();
        $berita = Announcement::where('status', 'aktif')
            ->where('tipe', 'umum')
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate(10);

        return view('informasi', compact('school', 'berita'));
    }

    public function getInformasi($tipe)
    {
        $validTypes = ['umum', 'ppdb', 'libur', 'penting'];

        if (!in_array($tipe, $validTypes)) {
            abort(404);
        }

        $announcements = Announcement::where('status', 'aktif')
            ->where('tipe', $tipe)
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate(10);

        return view('informasi', [
            'school' => $this->schoolInfo(),
            'berita' => $announcements,
            'activeTipe' => $tipe
        ]);
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'subjek' => 'required|string',
            'pesan' => 'required|string',
        ]);

        // TODO: Simpan pesan kontak ke database atau kirim email
        // Untuk sekarang, hanya redirect dengan pesan sukses

        return redirect()->back()->with('success', 'Pesan Anda telah dikirim. Terima kasih!');
    }
}
