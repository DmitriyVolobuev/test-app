@extends('layouts.main')

@section('content')

    <div class="container">

        <h1 class="text-center mt-4">{{"Главная страница"}}</h1>

        <a href="{{ route('upload') }}">{{"Загрузите картинку"}}</a>

        <div class="row d-flex align-items-stretch">

            @foreach ($images as $image)

                <div class="col-md-4 mb-4">

                    <div class="card h-100">

                        <img src="{{ asset('storage/' . $image->url) }}" class="card-img-top rounded img-thumbnail" alt="Image" style="max-height: 300px;">

                        <div class="card-body">

                            <p class="card-text">Likes: {{ $image->likes }}</p>

                            <a href="{{ route('image.show', $image->hash) }}" class="btn btn-primary">{{"Просмотр"}}</a>

                        </div>

                    </div>

                </div>

                @if ($loop->iteration % 3 === 0)

        </div>

        <div class="row d-flex align-items-stretch">
            @endif
            @endforeach
        </div>

        {{ $images->links() }}
    </div>

@endsection
