@extends('FE/layouts/master')

@section('title', "{$story->title} - {$chapter->title}")

@section('meta_description', "{$story->title} - {$chapter->title} - {$chapter->meta_description}")

@push('styles')
    <style>
        .chapter-content-custom{
            font-size: 26px;
            font-family: 'Times New Roman', Times, serif;
        }
        
        .select-chapter__list{
            position: relative; /* Đảm bảo định vị */
        }
    </style>
    
    
@endpush

@section('content')
<main>
    <div class="chapter-wrapper container my-5">
        <a href="{{route('detailPage', ['slug' => $story->slug])}}" class="text-decoration-none">
            <h1 class="text-center text-success">{{$story->title}}</h1>
        </a>
        <a href="#" class="text-decoration-none">
            <p class="text-center text-dark">{{$chapter->title}}</p>
        </a>
        <hr class="chapter-start container-fluid">
        <div class="chapter-nav text-center">
            <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
                <a class="btn btn-success me-1 chapter-prev"
                    href="{{$prevChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $prevChapter->slug]) : "#"}}" title="">&larr;</a>

                <div class="dropdown select-chapter me-1">
                    <a class="btn btn-secondary dropdown-toggle" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Chọn chương
                    </a>

                    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink">
                        @foreach ($story->chaptersActiveOrderByChapterNum as $chapterListSelected)
                            <li class="{{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                <a 
                                    href="{{route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterListSelected->slug])}}" class="dropdown-item {{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                    Chương {{$chapterListSelected->chapter_num}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a class="btn btn-success chapter-next"
                    href="{{$nextChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $nextChapter->slug]) : "#"}}" title="">&rarr;</a>
            </div>
        </div>
        <hr class="chapter-end container-fluid">


        <div class="chapter-content mb-3 chapter-content-custom">
            {!!$chapter->description!!}
        </div>

        <hr class="chapter-start container-fluid">
        <div class="chapter-nav text-center">
            <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
                <a class="btn btn-success me-1 chapter-prev"
                    href="{{$prevChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $prevChapter->slug]) : "#"}}" title="">&larr;</a>

                <div class="dropdown select-chapter me-1">
                    <a class="btn btn-secondary dropdown-toggle" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Chọn chương
                    </a>

                    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink">
                        @foreach ($story->chaptersActiveOrderByChapterNum as $chapterListSelected)
                            <li class="{{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                <a 
                                    href="{{route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterListSelected->slug])}}" class="dropdown-item {{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                    Chương {{$chapterListSelected->chapter_num}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a class="btn btn-success chapter-next"
                    href="{{$nextChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $nextChapter->slug]) : "#"}}" title="">&rarr;</a>
            </div>
        </div>
        <hr class="chapter-end container-fluid">
        
        <div class="text-center px-2 py-2 alert alert-success d-none d-lg-block" role="alert">Bạn có thể dùng phím
            mũi tên hoặc WASD để
            lùi/sang chương</div>
    </div>

    <div class="chapter-actions chapter-actions-mobile d-flex align-items-center justify-content-center">
        <div class="chapter-nav text-center">
            <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
                <a class="btn btn-success me-1 chapter-prev"
                    href="{{$prevChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $prevChapter->slug]) : "#"}}" title="">&larr;</a>

                <div class="dropdown select-chapter me-1">
                    <a class="btn btn-secondary dropdown-toggle" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Chọn chương
                    </a>

                    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink">
                        @foreach ($story->chaptersActiveOrderByChapterNum as $chapterListSelected)
                            <li class="{{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                <a 
                                    href="{{route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterListSelected->slug])}}" class="dropdown-item {{$chapter->chapter_num == $chapterListSelected->chapter_num ? "active ": ""}}">
                                    Chương {{$chapterListSelected->chapter_num}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a class="btn btn-success chapter-next"
                    href="{{$nextChapter ? route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $nextChapter->slug]) : "#"}}" title="">&rarr;</a>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>

    document.querySelectorAll('.dropdown.select-chapter').forEach(dropdown => {
        
        dropdown.addEventListener('shown.bs.dropdown', function () {
            console.log(123);
            
            const activeItem = dropdown.querySelector(".dropdown-item.active");
            const menu = dropdown.querySelector(".dropdown-menu");
            if (menu && activeItem) {
            // Lấy vị trí của phần tử active
                const offsetTop = activeItem.offsetTop;
                console.log(offsetTop - menu.clientHeight / 2 + activeItem.clientHeight / 2);
                
                // Đặt thanh cuộn sao cho phần tử active nằm ở giữa (hoặc gần giữa)
                menu.scrollTop = offsetTop - menu.clientHeight / 2 + activeItem.clientHeight / 2;
            }
        });
    });


</script>
@endpush