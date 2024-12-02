@extends('FE/layouts/master')

@section('title', "{$story->title} - Đọc truyện chữ online")

@section('meta_description', "{$story->title} - Đọc truyện chữ online - {$story->meta_description}")

@push('styles')
    
@endpush

@section('content')
<main>
    <input type="hidden" id="story_slug" value="nang-khong-muon-lam-hoang-hau">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="head-title-global d-flex justify-content-between mb-4">
                    <div class="col-12 col-md-12 col-lg-4 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                title="Thông tin truyện">Thông
                                tin truyện</span>
                        </h2>
                    </div>
                </div>

                <div class="story-detail">
                    <div class="story-detail__top align-items-start">
                        <div class="row align-items-start" style="with: 100%">
                            <div class="col-12 col-md-12 col-lg-3 story-detail__top--image">
                                <div class="book-3d">
                                    <img 
                                        src="{{$story->avatar}}"
                                        {{-- src="{{asset('FE/assets/images/nang_khong_muon_lam_hoang_hau.jpg')}}" --}}
                                        alt="{{$story->title}}" class="img-fluid w-100" width="200"
                                        height="300" loading="lazy">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-9">
                                <h3 class="text-center story-name">{{$story->title}}</h3>
                                <div class="rate-story mb-2">
                                    <div class="rate-story__holder" data-score="7.0">


                                        <img alt="1" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="2" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="3" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="4" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="5" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="6" src="{{asset('FE/assets/images/star-on.png')}}">



                                        <img alt="7" src="{{asset('FE/assets/images/star-half.png')}}">



                                        <img alt="8" src="{{asset('FE/assets/images/star-off.png')}}">



                                        <img alt="9" src="{{asset('FE/assets/images/star-off.png')}}">



                                        <img alt="10" src="{{asset('FE/assets/images/star-off.png')}}">




                                    </div>
                                    <em class="rate-story__text"></em>
                                    <div class="rate-story__value" itemprop="aggregateRating" itemscope=""
                                        itemtype="https://schema.org/AggregateRating">
                                        <em>Đánh giá:
                                            <strong>
                                                <span itemprop="ratingValue">7.0</span>
                                            </strong>
                                            /
                                            <span class="" itemprop="bestRating">10</span>
                                            từ
                                            <strong>
                                                <span itemprop="ratingCount">415</span>
                                                lượt
                                            </strong>
                                        </em>
                                    </div>
                                </div>

                                <div class="story-detail__top--desc px-3" style="max-height: 285px;">
                                    {!!$story->description!!}
                                </div>

                                <div class="info-more">
                                    <div class="info-more--more active" id="info_more">
                                        <span class="me-1 text-dark">Xem thêm</span>
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.70749 7.70718L13.7059 1.71002C14.336 1.08008 13.8899 0.00283241 12.9989 0.00283241L1.002 0.00283241C0.111048 0.00283241 -0.335095 1.08008 0.294974 1.71002L6.29343 7.70718C6.68394 8.09761 7.31699 8.09761 7.70749 7.70718Z"
                                                fill="#2C2C37"></path>
                                        </svg>
                                    </div>

                                    <a class="info-more--collapse text-decoration-none"
                                        href="#info_more">
                                        <span class="me-1 text-dark">Thu gọn</span>
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.70749 0.292817L13.7059 6.28998C14.336 6.91992 13.8899 7.99717 12.9989 7.99717L1.002 7.99717C0.111048 7.99717 -0.335095 6.91992 0.294974 6.28998L6.29343 0.292817C6.68394 -0.097606 7.31699 -0.0976055 7.70749 0.292817Z"
                                                fill="#2C2C37"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="story-detail__bottom mb-3">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3 story-detail__bottom--info">
                                <p class="mb-1">
                                    <strong>Tác giả:</strong>
                                    <a href="{{$story->acthor ? route('categoryPage', ['slug'=>$story->acthor->slug]) : ""}}"
                                        class="text-decoration-none text-dark hover-title">{{$story->acthor->name ?? ""}}</a>
                                </p>
                                <div class="d-flex align-items-center mb-1 flex-wrap">
                                    @php
                                        $storyCategories = $story->categories();
                                    @endphp
                                    <strong class="me-1">Thể loại:</strong>
                                    <div class="d-flex align-items-center flex-warp">
                                        @foreach ($storyCategories as $category)
                                            <a href="{{route('categoryPage', ['slug'=>$category->slug])}}"
                                                class="text-decoration-none text-dark hover-title  me-1 "
                                                style="width: max-content;">{{$category->name}} ,
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <p class="mb-1">
                                    <strong>Trạng thái:</strong>
                                    <span class="text-info">Full</span>
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="story-detail__list-chapter">
                        <div class="head-title-global d-flex justify-content-between mb-4">
                            <div class="col-6 col-md-12 col-lg-4 head-title-global__left d-flex">
                                <h2 class="me-2 mb-0 border-bottom border-secondary pb-1" id="list-chapters">
                                    <span href="#"
                                        class="d-block text-decoration-none text-dark fs-4 title-head-name"
                                        title="Truyện hot">Danh sách chương</span>
                                </h2>
                            </div>
                        </div>

                        <div class="story-detail__list-chapter--list">
                            <div class="row">
                                @foreach ($chapters as $key => $chapter)
                                    @if ($key == 0 || $key == 25)
                                    <div class="col-12 col-sm-6 col-lg-6 story-detail__list-chapter--list__item">
                                        <ul>
                                    @endif
                                    
                                    <li>
                                        <a href="{{route('detailChapter', ['slugStory' => $story->slug, 'slugChapter' => $chapter->slug])}}"
                                            class="text-decoration-none text-dark hover-title">{{$chapter->title}}</a>
                                    </li>
                                    
                                    @if ($key == 24 || $key == 49)
                                        </ul>
                                    </div>
                                    
                                    @elseif($loop->last)
                                        </ul>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="pagination" style="justify-content: center;">
                        {{-- <ul>
                            <li class="pagination__item  page-current">
                                <a class="page-link story-ajax-paginate"
                                    data-url="https://suustore.com/truyen/nang-khong-muon-lam-hoang-hau?page=1"
                                    style="cursor: pointer;">1</a>
                            </li>
                            <li class="pagination__item ">
                                <a class="page-link story-ajax-paginate"
                                    data-url="https://suustore.com/truyen/nang-khong-muon-lam-hoang-hau?page=2"
                                    style="cursor: pointer;">2</a>
                            </li>

                            <div class="dropup-center dropup choose-paginate me-1">
                                <button class="btn btn-success dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Chọn trang
                                </button>
                                <div class="dropdown-menu">
                                    <input type="number" class="form-control input-paginate me-1" value="">
                                    <button class="btn btn-success btn-go-paginate">
                                        Đi
                                    </button>
                                </div>
                            </div>

                            <li class="pagination__arrow pagination__item">
                                <a data-url="https://suustore.com/truyen/nang-khong-muon-lam-hoang-hau?page=2"
                                    style="cursor: pointer;"
                                    class="text-decoration-none w-100 h-100 d-flex justify-content-center align-items-center story-ajax-paginate">
                                    &gt;&gt;
                                </a>
                            </li>
                        </ul> --}}
                        {{ $chapters->onEachSide(3)->links('FE.partials.pagination') }}
                    </div>
                </div>
                
                
            </div>

            <div class="col-12 col-md-5 col-lg-4 sticky-md-top">
                <div class="section-list-category bg-light p-2 rounded card-custom">
                    <div class="head-title-global mb-2">
                        <div class="col-12 col-md-12 head-title-global__left">
                            <h2 class="mb-0 border-bottom border-secondary pb-1">
                                <span href="#" class="d-block text-decoration-none text-dark fs-4"
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
</main>
@endsection

@push('scripts')
    
@endpush