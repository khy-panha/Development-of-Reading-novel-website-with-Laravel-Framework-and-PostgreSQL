@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles1.css') }}">
<body>
    @include('layouts.message')

    <div class="series-container">
        <div class="series1">
            <button class="create-button1">1 Series</button>
        </div>
        <div class="series2">
            <button class="create-button2">2 Series</button>
        </div>
    </div>

    <form action="{{route('books.update',$book->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="create-container">
            <div class="upload-container">
                <input type="file" id="fileInput" accept="image/*" name="image" style="display: none;">
                <button type="button" id="uploadButton" class="btn btn-primary @error('image') is-invalid @enderror">Upload Image</button>
                <br>
                <img id="uploadedImage" alt="Uploaded Image" style="display: none; max-width: 100px;">
                @error('image')
                    <p class='invalid-feedback'>{{$message}}</p>
                @enderror
            </div>

            <div class="form-container">
                <div class="form-group-container">
                    <div class="form-group1">
                        <label for="selectOne">Genre 1</label>
                        <select class="form-control" id="selectOne" name="genre1">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    
                    <div class="form-group1">
                        <label for="selectTwo">Genre 2</label>
                        <select class="form-control" id="selectTwo" name="genre2">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" placeholder="Title" value="{{old('title',$book->title)}}" >
                    @error('title')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="authorInput">Author</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="authorInput" name="author" placeholder="Author" value="{{old('author',$book->author)}}">
                    @error('author')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="descriptionTextarea">Description</label>
                    <textarea class="editor form-control @error('description') is-invalid @enderror" id="descriptionTextarea" name="description" rows="3">{{old('description',$book->description)}}</textarea>
                    @error('description')
                        <p class='invalid-feedback'>{{$message}}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" style="width: 100%;">
                        <option value="1" {{ $book->status == 1 ? 'selected':'' }}>On-going</option>
                        <option value="0" {{ $book->status == 0 ? 'selected':'' }}>Complete</option>
                    </select>
                </div>
                
                <div class="button-container">
                    <button type="submit" class="create-button">Edit</button>
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
</body>
@endsection