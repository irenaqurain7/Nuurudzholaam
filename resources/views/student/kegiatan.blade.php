@extends('student.layout')

@section('student-content')
<div style="max-width: 1000px;">
    <h1 style="color: #2D4438; margin-bottom: 30px; font-size: 28px;">Kegiatan Sekolah</h1>

    @if($activities->isEmpty())
        <div style="background: #F4F7F5; border-left: 4px solid #709D88; padding: 20px; border-radius: 8px;">
            <p style="color: #666; margin: 0;">Belum ada kegiatan terbaru.</p>
        </div>
    @else
        <div style="display: grid; gap: 20px;">
            @foreach($activities as $activity)
                <div style="background: white; border-left: 4px solid #709D88; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <h2 style="margin: 0; color: #2D4438; font-size: 20px;">{{ $activity->name }}</h2>
                        <span style="background: #E2ECE8; color: #2D4438; padding: 5px 12px; border-radius: 20px; font-size: 12px;">
                            {{ $activity->date->format('d M Y') }}
                        </span>
                    </div>
                    <p style="color: #666; margin: 0 0 15px 0; line-height: 1.6;">
                        {{ $activity->description }}
                    </p>
                    @if($activity->location)
                        <p style="color: #709D88; margin: 0; font-size: 14px;">
                            <i class="fas fa-map-marker-alt"></i> {{ $activity->location }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
