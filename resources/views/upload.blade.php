@extends('layouts.main')

@section('content')
<div class="container">

    <div id="upload-app">

        <div v-if="successMessage" class="alert alert-success">

            @{{ successMessage }}
            <div v-for="path in successPaths" :key="path">

                <a :href="path" target="_blank">@{{ path }}</a>

            </div>

        </div>

        <div v-if="errorMessage" class="alert alert-danger">
            @{{ errorMessage }}
        </div>

        <a href="{{ route('home') }}">{{ 'Назад' }}</a>

        <form @submit="uploadImages" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="images" class="form-label">{{ "Выберите картинки" }}</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">{{"Загрузить"}}</button>

        </form>

    </div>

</div>

    <script>

        const app = Vue.createApp({
            data() {
                return {
                    successMessage: '',
                    successPaths: [],
                    errorMessage: ''
                };
            },
            methods: {
                uploadImages(event) {
                    event.preventDefault();

                    const formData = new FormData(event.target);

                    axios.post('{{ route("image.upload") }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then(response => {
                            this.successMessage = 'Картинки успешно загружены.';
                            this.successPaths = response.data.map(image => `${window.location.origin}/${image.hash}`);
                            this.errorMessage = '';
                        })
                        .catch(error => {
                            this.errorMessage = 'Ошибка загрузки картинок.';
                            this.successMessage = '';
                        });
                }
            }
        });

        app.mount('#upload-app');
    </script>

@endsection
