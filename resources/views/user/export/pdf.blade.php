<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $project->title }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 2cm 3cm 2cm 3cm;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 1rem;
        }
        h1 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        h2 {
            font-size: 14pt;
            font-weight: bold;
        }
        .chapter-title {
            page-break-before: always;
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            text-align: left;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .content {
            text-align: justify;
        }
        .cover {
            text-align: center;
            page-break-after: always;
            padding-top: 5cm;
        }
        .cover-title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 3cm;
        }
        .cover-author {
            font-size: 14pt;
            margin-bottom: 1cm;
        }
        .references {
            page-break-before: always;
        }
        .ref-item {
            margin-bottom: 10px;
            text-align: justify;
            text-indent: -30px;
            padding-left: 30px;
        }
    </style>
</head>
<body>
    <div class="cover">
        <div class="cover-title">{{ strtoupper($project->title) }}</div>
        <div class="cover-author">
            Disusun Oleh:<br>
            <strong>{{ auth()->user()->name }}</strong>
        </div>
        <div style="margin-top: 5cm;">
            <strong>SKRIPSI</strong><br>
            Dibuat menggunakan JokiSkripsi
        </div>
    </div>

    @foreach($chapters as $chapter)
        <div class="chapter-title">
            <h2>BAB {{ $chapter->chapter_number }}<br>{{ strtoupper($chapter->title) }}</h2>
        </div>
        @foreach($chapter->sections as $section)
            <div class="section-title">
                {{ $chapter->chapter_number }}.{{ $section->order }} {{ $section->title }}
            </div>
            <div class="content">
                {!! nl2br(e($section->content)) !!}
            </div>
        @endforeach
    @endforeach

    @if($references->count() > 0)
    <div class="references">
        <h2>DAFTAR PUSTAKA</h2>
        @foreach($references as $ref)
            <div class="ref-item">
                {!! $ref->citation_text ?? $ref->title !!}
            </div>
        @endforeach
    </div>
    @endif
</body>
</html>
