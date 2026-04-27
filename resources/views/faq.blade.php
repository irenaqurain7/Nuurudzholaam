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
            @if($faqs->count() > 0)
                @php
                    $categories = $faqs->groupBy('kategori');
                @endphp

                @foreach($categories as $category => $categoryFaqs)
                <div style="margin-bottom: 60px;">
                    <h2 style="color: var(--hijau-islam); font-size: 24px; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 3px solid var(--emas);">
                        <i class="fas fa-folder-open" style="color: var(--emas); margin-right: 10px;"></i>
                        {{ ucfirst($category) }}
                    </h2>

                    <div class="accordion">
                        @foreach($categoryFaqs as $faq)
                        <div class="accordion-item" style="margin-bottom: 15px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                            <div class="accordion-header" style="padding: 20px; background-color: #f7fafc; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease; user-select: none;" onclick="toggleAccordion(event)">
                                <h3 style="margin: 0; color: var(--hijau-islam); font-size: 16px; font-weight: 600;">
                                    {{ $faq->pertanyaan }}
                                </h3>
                                <i class="fas fa-chevron-down" style="color: var(--emas); transition: transform 0.3s ease; font-size: 18px;"></i>
                            </div>
                            <div class="accordion-content" style="padding: 0; max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease;">
                                <div style="padding: 20px; background-color: var(--putih); border-top: 2px solid #e2e8f0; color: var(--text-light); line-height: 1.8;">
                                    {{ $faq->jawaban }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
            <div style="text-align: center; padding: 80px 20px;">
                <i class="fas fa-inbox" style="font-size: 64px; color: var(--hijau-islam-lighter); margin-bottom: 20px; opacity: 0.5;"></i>
                <h3 style="color: var(--text-light); margin-bottom: 10px;">Belum ada FAQ</h3>
                <p style="color: var(--text-light); margin-bottom: 30px;">FAQ akan ditampilkan di sini. Silakan hubungi kami jika memiliki pertanyaan.</p>
                <a href="{{ route('kontak') }}" class="btn-primary">Hubungi Kami</a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background-color: #f7fafc; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h2 style="color: var(--hijau-islam); font-size: 32px; margin-bottom: 20px; font-weight: bold;">Pertanyaan Anda Tidak Terjawab?</h2>
        <p style="color: var(--text-light); font-size: 16px; margin-bottom: 30px;">Jangan ragu untuk menghubungi kami. Tim kami siap membantu menjawab setiap pertanyaan Anda.</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('kontak') }}" class="btn-primary">Kirim Pesan</a>
            <a href="mailto:{{ $school->email }}" class="btn-secondary">Email Kami</a>
        </div>
    </div>
</div>

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
                elContent.style.maxHeight = '0px';
                elContent.style.padding = '0px';
                elContent.parentElement.style.backgroundColor = '#f7fafc';
                elIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle current item
        if(isActive) {
            content.style.maxHeight = '0px';
            content.style.padding = '0px';
            header.style.backgroundColor = '#f7fafc';
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.padding = '20px';
            header.style.backgroundColor = 'var(--hijau-islam)';
            header.style.color = 'white';
            header.querySelector('h3').style.color = 'white';
            icon.style.color = 'var(--emas)';
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Initialize first accordion as open
    document.addEventListener('DOMContentLoaded', function() {
        const firstItem = document.querySelector('.accordion-item');
        if(firstItem) {
            const firstHeader = firstItem.querySelector('.accordion-header');
            if(firstHeader) {
                toggleAccordion({ currentTarget: firstHeader });
            }
        }
    });
</script>
@endpush
