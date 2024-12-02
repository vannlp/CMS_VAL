@extends('FE/layouts/master')


@section('title', "Danh mục {$category->name}")

@section('meta_description', "{$category->name} - {$category->short_description}")

@push('styles')
    
@endpush

@section('content')
<main>
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9 mb-3">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-12 col-md-12 col-lg-12 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span href="#" class="d-block text-decoration-none text-dark fs-4 category-name"
                                title="Ngôn Tình">{{$category->name}}</span>
                        </h2>
                    </div>
                </div>

                <div class="list-story-in-category section-stories-hot__list">
                    @foreach ($getStoryByCategory as $storyPost)
                        <div class="story-item">
                            <a href="{{route('detailPage', ['slug' => $storyPost->slug])}}" class="d-block text-decoration-none">
                                <div class="story-item__image">
                                    <img src="{{$storyPost->avatar}}" alt="{{$storyPost->title}}" class="img-fluid" width="150"
                                        height="230" loading="lazy">
                                </div>
                                <h3 class="story-item__name text-one-row story-name">{{$storyPost->title}}</h3>

                                <div class="list-badge">
                                    @foreach (\App\Models\StoryPost::TYPE as $key => $type)
                                        @if(in_array($key,$storyPost->type)) 
                                        <span class="{{$type['class']}}">{{$type['name']}}</span>
                                        @endif
                                    @endforeach

                                </div>
                            </a>
                        </div> 
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="category-description bg-light p-2 rounded mb-3 card-custom">
                    {{$category->description}}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
@endpush