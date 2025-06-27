
@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles_part.css') }}">
    <div class="series-container-story">
        <div class="series1">
            <button class="series-button1">1 Series</button>
        </div>
        <div class="series2">
            <button class="series-button2">2 Episode</button> 
        </div>
    </div>
    <div class="input-container">
        @include('layouts.message')
        <div class="list-title">
            <h2>Series Title:{{ $book->title }}</h2>
        </div>
        <form action="{{ route('stories.store', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titleInput">Part</label>
                <input type="text" class="form-control" id="titleInput" name="part" placeholder="Part" value="{{ old('part') }}">
            </div>
        
            <div class="form-group">
                <label for="story">Write Whole Story</label>
                <textarea class="editor form-control auto-expand" name="story" id="descriptionTextarea" placeholder="Story" rows="1">{{ old('story') }}</textarea>
            </div> 
        
            <div class="status-group">
                <label for="selectOne">Status</label>
                <select class="custom-select" id="inputGroupSelect04" name="status">   
                    <option value="1">On-going</option>
                    <option value="2">End</option>
                </select>
            </div>
        
            <div class="button-container">
                <button type="submit" class="create-button">Create Episode</button>
            </div>
        </form> 
        
    </div>
    
@endsection
@section('script')

<!-- Auto-expand Textarea -->

<script src="https://cdn.tiny.cloud/1/42e0dksgu5dxr89y7przyvjbjvsn0kh0u1p7w3z7edtt68e9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea#descriptionTextarea',
        plugins: 'image link media table code lists',
        toolbar: 'undo redo | bold italic underline | link image media table',
    });
</script>
@endsection