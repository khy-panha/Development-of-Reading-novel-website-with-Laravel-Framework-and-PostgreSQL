@extends('layouts.app')

@section('main')
    <section class="section">
        <div class="container">
            <h2 class="h2 section-title">Search Results for "{{ $query }}"</h2>

            <div class="grid-list" id="bookList">
                @if ($books->isNotEmpty())
                    @foreach ($books as $book)
                        <li class="book-item">
                            <div class="benefits-card has-before has-after">
                                <h3 class="h3 card-title">Title: {{ $book->title }}</h3>
                                <div class="h4 text-muted">Author: {{ $book->author }}</div>
                                 <p>Total views: {{ $book->views()->count() }}</p>
                                <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                                    <img src="{{ asset('uploads/books/' . $book->image) }}" alt="Book Image"
                                        class="card-image" loading="lazy">
                                </a>
                                <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                                    <span class="span">Read more</span>
                                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                                </a>
                                <div class="star-rating d-inline-flex ml-2" title="">
                                    <span class="rating-text theme-font theme-yellow">{{ $book->averageRating() }} / 5</span>
                                    <div class="star-rating d-inline-flex mx-2" title="">
                                        <div class="back-stars ">
                                            <i class="fa fa-star " aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>

                                            <div class="front-stars" style="width: {{ $book->averageRating() * 20 }}%">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="theme-font text-muted">
                                        ({{ $book->comments()->count() }} Review)
                                    </span>
                                </div>


                            </div>
                        </li>
                    @endforeach
                @endif
                @if (count($apiBooks) > 0)
                    @foreach ($apiBooks as $book)
                        @php $info = $book['volumeInfo']; @endphp
                        <li class="book-item">
                            <div class="benefits-card has-before has-after">
                                <h3 class="h3 card-title">Title: {{ $info['title'] ?? 'N/A' }}</h3>
                                <div class="h4 text-muted">Author: {{ $info['authors'][0] ?? 'Unknown' }}</div>
                                <p>Total views: N/A</p>
                                @if (isset($info['imageLinks']['thumbnail']))
                                    <img src="{{ $info['imageLinks']['thumbnail'] }}" alt="Book Image"
                                        class="card-image" loading="lazy">
                                @endif

                                <a href="{{ $info['infoLink'] ?? '#' }}" class="btn-link" target="_blank">
                                    <span class="span">Read more</span>
                                    <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
                                </a>
                                 <div class="star-rating d-inline-flex ml-2">
                                        <span class="rating-text theme-font theme-yellow">N/A</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </div>
            @if ($books->isNotEmpty())
                {{ $books->links() }}
            @endif
        </div>
    </section>
@endsection