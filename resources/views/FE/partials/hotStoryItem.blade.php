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