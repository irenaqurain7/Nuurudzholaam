@extends('layouts.app')

@section('title', 'Pertanyaan Umum - FAQ')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Pertanyaan Umum</h1>
        <p>Temukan jawaban dari pertanyaan yang sering diajukan</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            @php
                $displayFaqs = $faqs;
                if ($faqs->isEmpty()) {
                    $displayFaqs = collect([
                        (object)[
                            'pertanyaan' => 'Apa itu Nuurudzholaam (Nuzo)?',
                            'jawaban' => 'Nuurudzholaam (Nuzo) adalah pondok pesantren dan lembaga pendidikan Islam terpadu yang menyelenggarakan program pendidikan mulai dari TK, SD, SMP, SMK hingga pondok pesantren dengan memadukan kurikulum berbasis pesantren dan formal.',
                            'kategori' => 'umum',
                            'urutan' => 1
                        ],
                        (object)[
                            'pertanyaan' => 'Di mana lokasi sekolah Nuurudzholaam?',
                            'jawaban' => 'Sekolah Nuurudzholaam berlokasi di Kp, Jl. Sindang reret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181.',
                            'kategori' => 'umum',
                            'urutan' => 2
                        ],
                        (object)[
                            'pertanyaan' => 'Berapa biaya pendidikan untuk sekolah?',
                            'jawaban' => 'Mengenai biaya pendidikan anda bisa langsung tanyakan kepada admin dengan cara menghubungi nomor yang tertera dan untuk anak yatim dan piatu biaya pendidikan gratis atau di tanggung oleh lembaga (yayasan).',
                            'kategori' => 'umum',
                            'urutan' => 3
                        ],
                        (object)[
                            'pertanyaan' => 'Bagaimana cara mendaftar sebagai siswa baru (PPDB)?',
                            'jawaban' => 'Pendaftaran dapat dilakukan secara online melalui menu PPDB di website resmi ini dengan mengisi formulir pendaftaran serta mengunggah dokumen persyaratan, atau datang langsung ke sekretariat pendaftaran di sekolah.',
                            'kategori' => 'ppdb',
                            'urutan' => 1
                        ],
                        (object)[
                            'pertanyaan' => 'Apa saja dokumen persyaratan untuk pendaftaran PPDB?',
                            'jawaban' => 'Dokumen yang diperlukan meliputi: Akta Kelahiran, Kartu Keluarga, KTP Orang Tua/Wali, Ijazah terakhir/Surat Keterangan Lulus (SKL), dan pas foto terbaru ukuran 3x4.',
                            'kategori' => 'ppdb',
                            'urutan' => 2
                        ],
                        (object)[
                            'pertanyaan' => 'Kapan pendaftaran PPDB dibuka dan ditutup?',
                            'jawaban' => 'Periode pendaftaran PPDB biasanya dibuka mulai awal tahun ajaran baru (sekitar Januari) hingga kuota kelas terpenuhi. Tanggal aktif pendaftaran saat ini dapat Anda lihat langsung di dashboard halaman utama website ini atau menu PPDB.',
                            'kategori' => 'ppdb',
                            'urutan' => 3
                        ],
                        (object)[
                            'pertanyaan' => 'Apa saja jenjang pendidikan yang tersedia di Nuurudzholaam?',
                            'jawaban' => 'Kami menyelenggarakan pendidikan terpadu untuk jenjang TK (Taman Kanak-Kanak), SD (Sekolah Dasar), SMP (Sekolah Menengah Pertama), dan SMK (Sekolah Menengah Kejuruan) dengan berbagai pilihan kompetensi keahlian.',
                            'kategori' => 'akademik',
                            'urutan' => 1
                        ],
                        (object)[
                            'pertanyaan' => 'Bagaimana sistem pembelajaran sehari-hari?',
                            'jawaban' => 'Pembelajaran dilaksanakan dengan sistem Full Day School dari hari Senin hingga Jumat  yang mengintegrasikan kurikulum dinas pendidikan dan program pembiasaan keagamaan seperti shalat dhuha berjama\'ah setiap hari, Apel pagi setiap hari senin, hapalan zuz amma setiap hari selasa, senam gembira setiap hari rabu, kegiatan literasi setiap hari kamis serta olahraga bersama setiap hari jumat dan seluruh kegiatan di laksanakan sebelum pembelajaran dimulai.',
                            'kategori' => 'akademik',
                            'urutan' => 2
                        ],
                        (object)[
                            'pertanyaan' => 'Apakah ada program hafalan (Tahfidz) Al-Qur\'an?',
                            'jawaban' => 'Ya, program Tahfidz Al-Qur\'an merupakan salah satu program unggulan kami di seluruh jenjang pendidikan, dengan target hafalan minimal yang disesuaikan untuk setiap tingkatnya.',
                            'kategori' => 'akademik',
                            'urutan' => 3
                        ],
                        (object)[
                            'pertanyaan' => 'Fasilitas apa saja yang disediakan untuk menunjang pembelajaran?',
                            'jawaban' => 'Fasilitas pendukung di Nuurudzholaam meliputi ruang kelas yang nyaman, lab komputer untuk praktek TIK, perpustakaan, masjid sekolah, lapangan olahraga, area bermain khusus TK, Kantin sekolah, BLK (Balai latihan kerja), asrama putra putri atau pondok pesantren serta lingkungan sekolah yang asri dan aman.',
                            'kategori' => 'fasilitas',
                            'urutan' => 1
                        ],
                        (object)[
                            'pertanyaan' => 'Apakah tersedia asrama/pondok bagi siswa?',
                            'jawaban' => 'Ya, kami menyediakan fasilitas asrama (pondok pesantren) bagi siswa dan siswi yang ingin mondok sambil bersekolah umum. Pembinaan asrama dilakukan oleh ustadz/ustadzah yang berpengalaman.',
                            'kategori' => 'fasilitas',
                            'urutan' => 2
                        ]
                    ]);
                }
                $categories = $displayFaqs->groupBy('kategori');
            @endphp

            <!-- Search Bar & Category Filters -->
            <div style="margin-bottom: 40px; text-align: center;">
                <div style="position: relative; max-width: 550px; margin: 0 auto 25px;">
                    <input type="text" id="faqSearch" onkeyup="filterFaqs()" placeholder="Cari pertanyaan atau jawaban..." style="width: 100%; padding: 14px 20px 14px 48px; border: 2px solid #e2e8f0; border-radius: 30px; font-size: 16px; outline: none; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); font-family: inherit;">
                    <i class="fas fa-search" style="position: absolute; left: 20px; top: 17px; color: #a0aec0; font-size: 16px;"></i>
                </div>
                
                <div class="category-tabs" style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <button class="tab-btn active" data-target="all" onclick="filterCategory('all')" style="padding: 10px 22px; border: none; border-radius: 25px; background-color: var(--hijau-islam); color: white; cursor: pointer; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: inherit;">Semua</button>
                    <button class="tab-btn" data-target="umum" onclick="filterCategory('umum')" style="padding: 10px 22px; border: 1px solid #e2e8f0; border-radius: 25px; background-color: white; color: var(--text-light); cursor: pointer; font-weight: 600; transition: all 0.3s ease; font-family: inherit;">Umum</button>
                    <button class="tab-btn" data-target="ppdb" onclick="filterCategory('ppdb')" style="padding: 10px 22px; border: 1px solid #e2e8f0; border-radius: 25px; background-color: white; color: var(--text-light); cursor: pointer; font-weight: 600; transition: all 0.3s ease; font-family: inherit;">PPDB</button>
                    <button class="tab-btn" data-target="akademik" onclick="filterCategory('akademik')" style="padding: 10px 22px; border: 1px solid #e2e8f0; border-radius: 25px; background-color: white; color: var(--text-light); cursor: pointer; font-weight: 600; transition: all 0.3s ease; font-family: inherit;">Akademik</button>
                    <button class="tab-btn" data-target="fasilitas" onclick="filterCategory('fasilitas')" style="padding: 10px 22px; border: 1px solid #e2e8f0; border-radius: 25px; background-color: white; color: var(--text-light); cursor: pointer; font-weight: 600; transition: all 0.3s ease; font-family: inherit;">Fasilitas</button>
                </div>
            </div>

            <!-- FAQ Accordions -->
            <div id="faqAccordionsContainer">
                @foreach($categories as $category => $categoryFaqs)
                <div class="category-container" data-cat="{{ $category }}" style="margin-bottom: 50px;">
                    <h2 style="color: var(--hijau-islam); font-size: 22px; margin-bottom: 25px; padding-bottom: 12px; border-bottom: 3px solid var(--emas); font-weight: bold; display: flex; align-items: center; text-transform: capitalize;">
                        <i class="fas @if($category == 'umum') fa-info-circle @elseif($category == 'ppdb') fa-user-plus @elseif($category == 'akademik') fa-graduation-cap @else fa-building @endif" style="color: var(--emas); margin-right: 12px;"></i>
                        {{ $category == 'ppdb' ? 'PPDB' : $category }}
                    </h2>

                    <div class="accordion">
                        @foreach($categoryFaqs as $faq)
                        <div class="accordion-item" data-category="{{ $faq->kategori }}" style="margin-bottom: 15px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02); background-color: white;">
                            <div class="accordion-header" style="padding: 20px; background-color: #f7fafc; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease; user-select: none;" onclick="toggleAccordion(event)">
                                <h3 style="margin: 0; color: var(--hijau-islam); font-size: 16px; font-weight: 600; line-height: 1.5;">
                                    {{ $faq->pertanyaan }}
                                </h3>
                                <i class="fas fa-chevron-down" style="color: var(--emas); transition: transform 0.3s ease; font-size: 16px; margin-left: 15px;"></i>
                            </div>
                            <div class="accordion-content" style="padding: 0; max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                                <div style="padding: 15px 20px 20px 20px; background-color: var(--putih); color: var(--text-light); line-height: 1.8; font-size: 15px;">
                                    {{ $faq->jawaban }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- No Search Results Found Alert -->
                <div id="noResultsAlert" style="display: none; text-align: center; padding: 50px 20px;">
                    <i class="fas fa-search" style="font-size: 48px; color: #a0aec0; margin-bottom: 15px; opacity: 0.5;"></i>
                    <h3 style="color: var(--text-light); margin-bottom: 5px;">Tidak Ada Hasil</h3>
                    <p style="color: var(--text-light); font-size: 15px;">Tidak menemukan pertanyaan atau jawaban dengan kata kunci tersebut.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit a Question Form Section -->
<div style="background-color: #f7fafc; padding: 60px 20px; border-top: 1px solid #e2e8f0;">
    <div class="container" style="max-width: 700px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: var(--hijau-islam); font-size: 28px; margin-bottom: 15px; font-weight: bold;">Punya Pertanyaan Lain?</h2>
            <p style="color: var(--text-light); font-size: 15px;">Kirimkan pertanyaan Anda langsung kepada kami. Kami akan merespons melalui email Anda sesegera mungkin.</p>
        </div>

        @if(session('success'))
            <div style="background-color: #c6f6d5; border-left: 4px solid #38a169; color: #22543d; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fas fa-check-circle" style="margin-right: 10px;"></i> {{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.style.display='none'" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #22543d;">&times;</button>
            </div>
        @endif

        <form action="{{ route('kontak.send') }}" method="POST" style="background-color: white; padding: 35px; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05); border: 1px solid #edf2f7;">
            @csrf
            <input type="hidden" name="subjek" value="Pertanyaan dari FAQ">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;" class="form-grid-mobile">
                <div>
                    <label for="nama" style="display: block; font-weight: 600; color: var(--text-light); margin-bottom: 8px; font-size: 14px;">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required placeholder="Masukkan nama Anda" style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--hijau-islam)'" onblur="this.style.borderColor='#cbd5e0'">
                </div>
                <div>
                    <label for="email" style="display: block; font-weight: 600; color: var(--text-light); margin-bottom: 8px; font-size: 14px;">Alamat Email</label>
                    <input type="email" name="email" id="email" required placeholder="name@example.com" style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--hijau-islam)'" onblur="this.style.borderColor='#cbd5e0'">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label for="pesan" style="display: block; font-weight: 600; color: var(--text-light); margin-bottom: 8px; font-size: 14px;">Pertanyaan Anda</label>
                <textarea name="pesan" id="pesan" rows="5" required placeholder="Tuliskan pertanyaan lengkap Anda di sini..." style="width: 100%; padding: 12px 16px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; outline: none; transition: border-color 0.2s; resize: vertical; font-family: inherit;" onfocus="this.style.borderColor='var(--hijau-islam)'" onblur="this.style.borderColor='#cbd5e0'"></textarea>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background-color 0.2s;">Kirim Pertanyaan</button>
        </form>
    </div>
</div>

<style>
    @media (max-width: 600px) {
        .form-grid-mobile {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    function toggleAccordion(event) {
        const header = event.currentTarget;
        const item = header.closest('.accordion-item');
        const content = item.querySelector('.accordion-content');
        const icon = header.querySelector('i');
        const isActive = content.style.maxHeight && content.style.maxHeight !== '0px';

        // Close all accordion items
        document.querySelectorAll('.accordion-item').forEach(el => {
            if(el !== item) {
                const elContent = el.querySelector('.accordion-content');
                const elIcon = el.querySelector('i');
                const elHeader = el.querySelector('.accordion-header');
                const elH3 = elHeader.querySelector('h3');
                
                elContent.style.maxHeight = '0px';
                elHeader.style.backgroundColor = '#f7fafc';
                elHeader.style.color = '';
                elH3.style.color = 'var(--hijau-islam)';
                elIcon.style.color = 'var(--emas)';
                elIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle current item
        if(isActive) {
            content.style.maxHeight = '0px';
            header.style.backgroundColor = '#f7fafc';
            header.style.color = '';
            header.querySelector('h3').style.color = 'var(--hijau-islam)';
            icon.style.color = 'var(--emas)';
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            header.style.backgroundColor = 'var(--hijau-islam)';
            header.style.color = 'white';
            header.querySelector('h3').style.color = 'white';
            icon.style.color = 'var(--emas)';
            icon.style.transform = 'rotate(180deg)';
        }
    }

    function filterFaqs() {
        const query = document.getElementById('faqSearch').value.toLowerCase().trim();
        const activeTabBtn = document.querySelector('.tab-btn.active');
        const activeCategory = activeTabBtn ? activeTabBtn.getAttribute('data-target') : 'all';
        
        let matchCount = 0;

        document.querySelectorAll('.category-container').forEach(container => {
            const containerCategory = container.getAttribute('data-cat');
            const accordionItems = container.querySelectorAll('.accordion-item');
            let visibleInContainer = 0;

            accordionItems.forEach(item => {
                const title = item.querySelector('.accordion-header h3').textContent.toLowerCase();
                const content = item.querySelector('.accordion-content').textContent.toLowerCase();
                const itemCategory = item.getAttribute('data-category');

                const matchesQuery = query === '' || title.includes(query) || content.includes(query);
                const matchesCategory = activeCategory === 'all' || itemCategory === activeCategory;

                if (matchesQuery && matchesCategory) {
                    item.style.display = 'block';
                    visibleInContainer++;
                    matchCount++;
                } else {
                    item.style.display = 'none';
                    
                    // If this item was active/open, close it when hiding
                    const itemContent = item.querySelector('.accordion-content');
                    if (itemContent.style.maxHeight && itemContent.style.maxHeight !== '0px') {
                        const itemHeader = item.querySelector('.accordion-header');
                        const itemIcon = itemHeader.querySelector('i');
                        itemContent.style.maxHeight = '0px';
                        itemContent.style.padding = '0px';
                        itemHeader.style.backgroundColor = '#f7fafc';
                        itemHeader.style.color = '';
                        itemHeader.querySelector('h3').style.color = 'var(--hijau-islam)';
                        itemIcon.style.color = 'var(--emas)';
                        itemIcon.style.transform = 'rotate(0deg)';
                    }
                }
            });

            // Show container if it has visible items and belongs to category
            if (visibleInContainer > 0 && (activeCategory === 'all' || containerCategory === activeCategory)) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        });

        // Show/hide no results alert
        const noResultsAlert = document.getElementById('noResultsAlert');
        if (matchCount === 0) {
            noResultsAlert.style.display = 'block';
        } else {
            noResultsAlert.style.display = 'none';
        }
    }

    function filterCategory(category) {
        // Update active tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.getAttribute('data-target') === category) {
                btn.classList.add('active');
                btn.style.backgroundColor = 'var(--hijau-islam)';
                btn.style.color = 'white';
                btn.style.border = 'none';
                btn.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            } else {
                btn.classList.remove('active');
                btn.style.backgroundColor = 'white';
                btn.style.color = 'var(--text-light)';
                btn.style.border = '1px solid #e2e8f0';
                btn.style.boxShadow = 'none';
            }
        });
        
        // Execute filtering
        filterFaqs();
    }

    // Initialize first visible accordion item as open on load
    document.addEventListener('DOMContentLoaded', function() {
        const firstVisibleItem = document.querySelector('.category-container .accordion-item');
        if (firstVisibleItem) {
            const header = firstVisibleItem.querySelector('.accordion-header');
            if (header) {
                toggleAccordion({ currentTarget: header });
            }
        }
    });
</script>
@endpush
