@props([
    'text' => '',
    'type' => 'primary',
    'className' => ''
])

<span class="badge {{$className}} bg-label-success" text-capitalized="">{{$text}}</span>