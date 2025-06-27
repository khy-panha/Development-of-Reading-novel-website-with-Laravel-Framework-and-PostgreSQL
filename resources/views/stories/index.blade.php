@extends('layouts.app')

@section('main')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <div class="back-arrow">
        <a href="{{ url()->previous() }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
<div class="stories-container">

    {{-- Book banner (shown once) --}}
    <div class="profile-banner">
      <div class="profile-details">
          <a href="{{ route('stories.index', $book->id) }}">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="{{ $book->title }}" class="card-image">
          </a>
          <div class="profile-info">
              <h1>{{ $book->title }}</h1>
              <p>Romance • Drama</p>
              <p>by {{ $book->author }}</p>
          </div>
      </div>
      <a href="{{ route('stories.create', $book->id) }}" class="Add-Epersode">
          + Add Episode
      </a>
  </div>
  

    {{-- Chapters and description --}}
    <div class="chapters">
        <div class="chapter-list">
            {{-- Loop stories here to only show parts --}}
            @foreach ($stories as $story)
            <div class="chapter">
                <div class="chapter-meta">
                    <div class="item-text">
                        <a href="{{ route('story.part', ['bookId' => $book->id, 'storyId' => $story->id]) }}">
                        <strong>{{ $story->part }}</strong>
                        <span>Updated {{ $story->created_at->format('M d, Y') }}</span>
                        </a>
                    </div>
                    <span class="control-btton">   
                            <a href="{{ route('stories.create', $story->book_id) }}" class="Add-Epersode">
                            +Add 
                        </a>
                        <a href="{{ route('stories.edit', [$story->book_id, $story->id]) }}" class="Edit-Eperode">
                            Edit
                        </a>
                        <a href="{{ route('stories.destroy', [$story->book_id, $story->id]) }}" class="Delet-Epersode"
                        onclick="return confirm('Are you sure you want to delete this episode?')">
                            Delete 
                        </a>
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="sidebar">
            <p><strong>Description:</strong></p>
            <p>{{ $book->description }}</p>
        </div>
    </div>
</div>
@endsection
