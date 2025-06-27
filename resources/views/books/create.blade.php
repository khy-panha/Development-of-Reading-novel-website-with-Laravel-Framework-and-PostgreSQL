@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles1.css') }}">

<body>
    @include('layouts.message')

    <div class="series-container">
        <div class="series1">
            <button class="series1-button">1 Series</button>
        </div>
        <div class="series2">
            <button class="series2-button">2 Episode</button>
        </div>
    </div>

    <form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="create-container">
            <div class="upload-container">
                <input type="file" id="fileInput" accept="image/*" name="image" style="display: none;">
                <button type="button" id="uploadButton" class="btn-updoad @error('image') is-invalid @enderror">Upload Image</button>
                <br>
                <img id="uploadedImage" alt="Uploaded Image" style="display: none; max-width: 100px;">
                @error('image')
                    <p class='invalid-feedback'>{{$message}}</p>
                @enderror
            </div>

            <div class="form-container">
              
                <div class="form-group-container">
                    <div class="form-group1">
                        <label for="selectOne">Genre 1 (Required)</label>
                        <select class="form-control" id="selectOne" name="genre1" required>
                            <option value="">-- Select Genre --</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Romance">Romance</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Horror">Horror</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Drama">Drama</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Crime">Crime</option>
                            <option value="Paranormal">Paranormal</option>
                            <option value="Dystopian">Dystopian</option>
                            <option value="Post-Apocalyptic">Post-Apocalyptic</option>
                            <option value="Coming-of-Age">Coming-of-Age</option>
                            <option value="Slice of Life">Slice of Life</option>
                            <option value="Superhero">Superhero</option>
                            <option value="Western">Western</option>
                            <option value="Mythology">Mythology</option>
                            <option value="Urban Fantasy">Urban Fantasy</option>
                        </select>
                    </div>
                    
                    <div class="form-group1">
                        <label for="selectTwo">Genre 2 (Optional)</label>
                        <select class="form-control" id="selectTwo" name="genre2">
                            <option value="">-- Select Genre --</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Romance">Romance</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Horror">Horror</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Drama">Drama</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Crime">Crime</option>
                            <option value="Paranormal">Paranormal</option>
                            <option value="Dystopian">Dystopian</option>
                            <option value="Coming-of-Age">Coming-of-Age</option>
                            <option value="Slice of Life">Slice of Life</option>
                            <option value="Superhero">Superhero</option>
                            <option value="Western">Western</option>
                            <option value="Mythology">Mythology</option>
                            <option value="Urban Fantasy">Urban Fantasy</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" placeholder="Title" value="{{ old('title') }}">
                    @error('title')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="authorInput">Author</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="authorInput" name="author" placeholder="Author" value="{{ old('author') }}">
                    @error('author')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="descriptionTextarea">Description</label>
                    <textarea class="editor form-control @error('description') is-invalid @enderror" id="descriptionTextarea" name="description" rows="3">{{ old('description') }}</textarea>

                    @error('description')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" style="width: 100%;">
                        <option value="1">On-going</option>
                        <option value="0">Complete</option>
                    </select>
                </div>
                
                <div class="button-container">
                    <button type="submit" class="create-button">Create Series</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById('fileInput');
            const uploadButton = document.getElementById('uploadButton');
            const uploadedImage = document.getElementById('uploadedImage');

            uploadButton.addEventListener('click', function() {
                fileInput.click();
            });

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadedImage.src = e.target.result;
                        uploadedImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    uploadedImage.style.display = 'none';
                }
            });
        });
    </script>
    
    <script src="https://cdn.tiny.cloud/1/42e0dksgu5dxr89y7przyvjbjvsn0kh0u1p7w3z7edtt68e9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#descriptionTextarea',
            plugins: 'image link media table code lists',
            toolbar: 'undo redo | bold italic underline | link image media table',
        });
    </script>

@endsection