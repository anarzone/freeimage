@extends('layout.app')

@section('title','Save images')

@section('content')
    <div class="row mt-2 image-container">
        @foreach($images as $image)
            <div class="col-4 mb-2">
                <div class="card" style="width: 25rem;">
                    <img src="{{asset('storage/'.\App\Media::MAIN_PATH.'/'.\App\Media::STANDARD_PATH.'/'.$image->name)}}" class="card-img-top" alt="">
                </div>
            </div>
        @endforeach

        {{$images->links()}}

    </div>
@endsection
