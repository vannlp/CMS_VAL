@extends('FE/layouts/master')

@section('title', "Đọc truyện chữ tại cms.test")

@section('meta_description', "Đọc truyện chữ tại cms.test")


@push('styles')
    
@endpush

@section('content')
<main>
    <div class="section-stories-hot mb-3">
        <div class="container">
            <div class="row">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <a href="#" class="d-block text-decoration-none text-dark fs-4 story-name"
                                title="Truyện Hot">Truyện Hot</a>
                        </h2>
                        <i class="fa-solid fa-fire-flame-curved"></i>
                    </div>

                    <div class="col-4 col-md-3 col-lg-2">
                        <select class="form-select select-stories-hot" aria-label="Truyen hot">
                            <option selected="" value="0">Tất cả</option>
                            @foreach ($categoryOption as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="section-stories-hot__list">
                        @foreach ($topStoryPostViews as $storyPost)
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

                    <div class="section-stories-hot__list wrapper-skeleton d-none">
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9">
                <div class="section-stories-new mb-3">
                    <div class="row">
                        <div class="head-title-global d-flex justify-content-between mb-2">
                            <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
                                <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                                    <a href="https://suustore.com/#"
                                        class="d-block text-decoration-none text-dark fs-4 story-name"
                                        title="Truyện Mới">Truyện Mới</a>
                                </h2>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="section-stories-new__list">
                                @foreach ($newStorys as $story)
                                <div class="story-item-no-image">
                                    <div class="story-item-no-image__name d-flex align-items-center">
                                        <h3 class="me-1 mb-0 d-flex align-items-center">

                                            <svg style="width: 10px; margin-right: 5px;"
                                                xmlns="http://www.w3.org/2000/svg" height="1em"
                                                viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z">
                                                </path>
                                            </svg>
                                            <a href="#"
                                                class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">{{$story->title}}</a>
                                        </h3>
                                        @foreach (\App\Models\StoryPost::TYPE as $key => $type)
                                            @if(in_array($key,$storyPost->type)) 
                                            <span class="{{$type['class']}} me-1">{{$type['name']}}</span>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
                                        <p class="mb-0">
                                            @foreach ($story->categories as $category)
                                            <a href="{{route('categoryPage', ['slug' => $category->slug])}}"
                                            class="hover-title text-decoration-none text-dark category-name">{{$category->name}}, </a>
                                            @endforeach
                                        </p>
                                    </div>

                                    <div class="story-item-no-image__chapters ms-2">
                                        <a href="#" class="hover-title text-decoration-none text-info">Chương
                                            {{$story->newChapter->chapter_num ?? ""}}</a>
                                    </div>


                                </div>
                                @endforeach
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="row">

                    <div class="col-12">
                        <div class="section-list-category bg-light p-2 rounded card-custom">
                            <div class="head-title-global mb-2">
                                <div class="col-12 col-md-12 head-title-global__left">
                                    <h2 class="mb-0 border-bottom border-secondary pb-1">
                                        <span class="d-block text-decoration-none text-dark fs-4"
                                            title="Truyện đang đọc">Thể loại truyện</span>
                                    </h2>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Horizontal under breakpoint -->
                                <ul class="list-category">
                                    @foreach ($categories as $category)
                                    <li class="">
                                        <a href="{{route('categoryPage', ['slug' => $category->slug])}}" class="text-decoration-none text-dark hover-title">{{$category->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-stories-full mb-3 mt-3">
        <div class="container">
            <div class="row">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-12 col-md-4 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                title="Truyện đã hoàn thành">Truyện đã hoàn thành</span>
                        </h2>
                        <!-- <i class="fa-solid fa-fire-flame-curved"></i> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="section-stories-full__list">
                        
                        @foreach ($fullStorys as $story)
                        <div class="story-item-full text-center">
                            <a href="#" class="d-block story-item-full__image">
                                <img src="{{$story->avatar}}" alt="{{$story->title}}" class="img-fluid w-100"
                                    width="150" height="230" loading="lazy">
                            </a>
                            <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
                                <a href="#"
                                    class="text-decoration-none text-one-row story-name">
                                    {{$story->title}}
                                </a>
                            </h3>
                            <span class="story-item-full__badge badge text-bg-success">Full - {{$story->chapters_active_count}} chương</span>
                        </div>  
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script>
        
        const selectStoriesHot = $(".select-stories-hot");
        const wrapperSkeletonStoriesHot = $(".wrapper-skeleton")
        
        if (selectStoriesHot) {
            function handleChangeListHot(category_id) {
                window.axios.get("{{route('getStoryHtml', ['category_id' => '__ID__'])}}".replace('__ID__', category_id))
                    .then(function(response) {
                        var html = $(response);
                        
                        $('.section-stories-hot__list:not(.wrapper-skeleton)').html(html);
                        $('.section-stories-hot__list:not(.wrapper-skeleton)').removeClass('d-none');
                        wrapperSkeletonStoriesHot.addClass('d-none')
                        
                    }).catch((err) => {
                        alert(`${err}`);
                    })
                
                // fetch(route('get.list.story.hot'), {
                //     method: 'POST',
                //     headers: {
                //         'Accept': 'application/json',
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': window.SuuTruyen.csrfToken,
                //     },
                //     body: JSON.stringify({
                //         category_id: category_id
                //     })
                // })
                //     .then(res => res.json())
                //     .then(data => {
                //         if (data.success) {
                //             var html = $(data.html);
                //             var list = $('.section-stories-hot__list:not(.wrapper-skeleton)', html);
                //             $('.section-stories-hot__list:not(.wrapper-skeleton)').replaceWith(list);
                //             wrapperSkeletonStoriesHot.addClass('d-none')
                //         }
                //     })
                //     .catch(function (error) {
                //         console.log(error);
                //         if (error.status !== 500) {
                //             let errorMessages = error.responseJSON.errors;
                //         } else {
                //             errorContent = error.responseJSON.message;
                //         }
                //     })
            }

            selectStoriesHot.on('change', function (e) {
                const categoryId = $(this).val()

                $('.section-stories-hot__list').addClass('d-none')
                wrapperSkeletonStoriesHot.removeClass('d-none')

                handleChangeListHot(categoryId)
            })

            const themeMode = $(".theme_mode")
            if (themeMode) {
                themeMode.on('change', function (e) {
                    let valueThemeMode = $(this).is(":checked") ? 'dark' : 'light'

                    window.setCookie('bg_color', valueThemeMode, 1)
                    if ($(this).is(":checked")) {
                        $("body").addClass('dark-theme')
                    } else {
                        $("body").removeClass('dark-theme')
                    }
                    // window.location.reload()
                })
            }

            let x = setInterval(() => {
                const selectStoriesHot = document.querySelector('.select-stories-hot')
                if (!selectStoriesHot) {
                    clearInterval(x)
                } else {
                    const options = selectStoriesHot.querySelectorAll('option')

                    let valueSelected = null
                    options.forEach((option, index) => {
                        if (option.hasAttribute('selected')) {
                            valueSelected = option.getAttribute('value')
                        }
                        option.removeAttribute('selected')
                    })
                    // console.log(valueSelected);

                    // $('.select-stories-hot option:selected').next().attr('selected', 'selected');
                    if (valueSelected == null) {
                        $('.select-stories-hot option:first').next().attr('selected', 'selected');
                    } else {
                        $(`.select-stories-hot option[value="${valueSelected}"]`).next().attr('selected', 'selected');
                    }

                    if ($(".select-stories-hot").val() != 'Tất cả') {
                        handleChangeListHot($(".select-stories-hot").val())
                    } else {
                        $('.select-stories-hot option:selected').next().attr('selected', 'selected');
                    }
                }

            }, 50000);
        } 
    </script>
@endpush