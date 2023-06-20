@extends('layouts.main')

@section('content')

    <div class="container">

        <h1 class="text-center mt-4">{{"Просмотр картинки"}}</h1>

        <a href="{{ route('home') }}">{{ 'Назад' }}</a>

        <div id="app" class="row justify-content-center">

            <div class="col-md-4 mb-4 mx-auto">

                <div class="card">

                    <img src="{{ asset('storage/' . $image->url) }}" class="card-img-top rounded img-thumbnail" alt="Image" style="max-height: 300px;">

                    <div class="card-body text-center">

                        <p class="card-text">Likes: <span id="likes-count">{{ $image->likes }}</span></p>

                        <button class="btn btn-primary" @click="toggleLike" v-if="!liked">{{"Лайк"}}</button>

                        <button class="btn btn-danger" @click="toggleLike" v-if="liked">{{"Дизлайк"}}</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        const app = Vue.createApp({
            data() {
                return {
                    liked: localStorage.getItem('liked_{{ $image->hash }}') === 'true',
                    likesCount: {{ $image->likes }},
                };
            },
            methods: {
                toggleLike() {
                    const likeUrl = `/{{ $image->hash }}/like`;
                    const dislikeUrl = `/{{ $image->hash }}/dislike`;

                    const url = this.liked ? dislikeUrl : likeUrl;

                    axios.post(url)
                        .then(response => {
                            this.liked = !this.liked;
                            const likesCountElement = document.getElementById('likes-count');
                            if (likesCountElement) {
                                likesCountElement.textContent = response.data.likesCount;

                                localStorage.setItem('liked_{{ $image->hash }}', this.liked.toString());
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                getImageUrl() {
                    return "{{ asset('storage/' . $image->url) }}";
                }
            }
        });

        app.mount('#app');
    </script>

@endsection
