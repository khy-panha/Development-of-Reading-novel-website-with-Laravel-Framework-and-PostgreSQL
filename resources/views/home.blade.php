@extends('layouts.app')

@section('main')
  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css\book\style_book.css') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">

  <!-- Preload Image -->
  <link rel="preload" as="image" href="./assets/images/hero-banner.png">
</head>

<body>

<main>
<article>

  <!-- HERO Section -->
  <section class="section hero" id="home" aria-label="home">
    <div class="container">
      <div class="hero-content-home">
        <p class="section-subtitle">Let's Make The Best Investment</p>
        <h1 class="h1 hero-title">Read More And Make Success The Result Of Perfection.</h1>
        <p class="section-text">
          Get lost in another world, one page at a time.
        </p>
        <div class="genre-buttons" style="margin-bottom: 20px;">
          @php
              $genres = [
                  'Fantasy', 'Science Fiction', 'Romance', 'Mystery', 'Thriller', 'Horror',
                  'Historical Fiction', 'Adventure', 'Drama', 'Comedy', 'Crime',
                  'Paranormal', 'Dystopian', 'Post-Apocalyptic', 'Coming-of-Age',
                  'Slice of Life', 'Superhero', 'Western', 'Mythology', 'Urban Fantasy'
              ];
          @endphp
      
          @foreach ($genres as $genre)
              <a href="{{ route('books.byGenre', ['genre' => $genre]) }}" class="btn btn-outline-primary m-1">
                  {{ $genre }}
              </a>
          @endforeach
      </div>
      
      </div>

      <div class="hero-banner has-before">
        <a href="{{ route('book.detail', $randomBook->id) }}">
        <img src="{{ asset('uploads/books/' . $randomBook->image) }}" alt="{{ $randomBook->title }}" class="card-image" loading="lazy" width="300" height="596"style="border-radius:5px">
        
        <button class="play-btn" aria-label="play video">
          <ion-icon name="play-outline" aria-hidden="true"></ion-icon>
        </button>
        </a>
      </div>

    </div>
  </section>

  <!-- NEW NOVEL Section -->
  <section class="section benefits" id="newNovel" aria-label="benefits">
    <div class="container">
      <div class="grid-list" id="bookList">

        <li class="benefits-content ">
          <h2 class="h2 section-title">New Upload</h2>
          <p class="section-text">Get lost in another world, one page at a time.</p>
        </li>

        @if($books->isNotEmpty())
        @foreach ($books as $book)
          <li class="book-item">
            <div class="benefits-card has-before has-after">
              @php
                $latestStory = $book->stories->sortByDesc('created_at')->first();
              @endphp

              <h3 class="h3 card-title">
                Title: {{ $book->title }}

              </h3>
              <div class="h4 text-muted">Author:{{$book->author}}</div>
              <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
                @php
                $isNewBook = $book->created_at->diffInDays(now()) <= 2;
                $latestStory = $book->stories->sortByDesc('created_at')->first();
                $isNewPart = $latestStory && $latestStory->created_at->diffInDays(now()) <= 2;
              @endphp
              
              @if($isNewBook)
                <span class="top-ifor-card">New🔥</span>
              @elseif($isNewPart)
                <span class="top-ifor-card">New Part</span>
              @endif
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="Book Image" class="card-image" loading="lazy">
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

                      <div class="front-stars" style="width: {{ $book->averageRating() * 20}}%">
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
                <span class="theme-font text-muted">({{ $book->comments()->count()}} Review)</span>
              </div>
            
              <p>Total views:&nbsp;{{ $book->views()->count()}}</p>
            </div>
          </li>
        @endforeach
      @endif
    </div>
  </div>
</section>
  
  <!-- POPULAR Section -->
  <section class="section benefits" id="popular" aria-label="benefits">
    <div class="container">
      <div class="grid-list" id="bookList">

        <li class="benefits-content">
          <h2 class="h2 section-title">Popular</h2>
          <p class="section-text">Get lost in another world, one page at a time.</p>
        </li>

        @if($books->isNotEmpty())
        @foreach ($popularBooks as $book)
          <li class="book-item">
            <div class="benefits-card has-before has-after">
              <h3 class="h3 card-title">Title:{{ $book->title }}</h3>

              <div class="h4 text-muted">Author:{{$book->author}}</div>
              <a href="{{ route('book.detail', $book->id) }}" class="btn-link">
              <img src="{{ asset('uploads/books/' . $book->image) }}" alt="Book Image" class="card-image" loading="lazy">
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

                      <div class="front-stars" style="width: {{ $book->averageRating() * 20}}%">
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
                <span class="theme-font text-muted">( Review{{ $book->comments()->count()}})</span>
              </div>
            
              <p>Total views:&nbsp;{{ $book->views()->count() }}</p>
            </div>
             

          </li>
        @endforeach
      @endif
    </div>
  </div>
</section>

  <!-- RECOMMENDED Section -->
  <section class="section benefits" aria-label="benefits">
    <div class="container">
      <div class="grid-list" id="bookList">

        <li class="benefits-content">
          <h2 class="h2 section-title">Recommend</h2>
          <p class="section-text">Get lost in another world, one page at a time. </p>
        </li>

 
          @foreach($relatedBooks as $relatedBook)
          <li class="book-item">
            <div class="benefits-card has-before has-after">
              <h3 class="h3 card-title">Title:{{ $relatedBook->title }}</h3>

              <div class="h4 text-muted">Author:{{$relatedBook->author}}</div>
              <a href="{{ route('book.detail', $relatedBook->id) }}" class="btn-link">
              <img src="{{ asset('uploads/books/' . $relatedBook->image) }}" alt="Book Image" class="card-image" loading="lazy">
              </a>
              <a href="{{ route('book.detail', $relatedBook->id) }}" class="btn-link">
                <span class="span">Read more</span>
                <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
              </a>
              <div class="star-rating d-inline-flex ml-2" title="">
                <span class="rating-text theme-font theme-yellow">{{ $relatedBook->averageRating() }} / 5</span>
                <div class="star-rating d-inline-flex mx-2" title="">
                    <div class="back-stars ">
                        <i class="fa fa-star " aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                        <div class="front-stars" style="width: {{ $relatedBook->averageRating() * 20}}%">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <span class="theme-font text-muted">({{ $relatedBook->comments()->count()}} Review)</span>
                
            </div>
              <p>Total views: &nbsp; {{ $relatedBook->views()->count() }}</p>
            </p>
            </div>
            
          </li>
          @endforeach
   

      </div>
    </div>
  </section>

  <!-- API BOOK -->
  <section class="section benefits" id="benefits" aria-label="benefits">
    <div class="container">
      <div class="grid-list" id="bookList">
  
        <li class="benefits-content">
          <h2 class="h2 section-title">Novel From Google</h2>
          <p class="section-text">Get lost in another world, one page at a time.</p>
        </li>
  
        @foreach ($apiBooks as $book)
          @php $info = $book['volumeInfo']; @endphp
  
          <li class="book-item">
            <div class="benefits-card has-before has-after">
              <h3 class="h3 card-title">Title: {{ $info['title'] ?? 'N/A' }}</h3>
              <div class="h4 text-muted">Author: {{ $info['authors'][0] ?? 'Unknown' }}</div>
  
              @if (isset($info['imageLinks']['thumbnail']))
                <img src="{{ $info['imageLinks']['thumbnail'] }}" alt="Book Image" class="card-image" loading="lazy">
              @endif
  
              <a href="{{ $info['infoLink'] ?? '#' }}" class="btn-link" target="_blank">
                <span class="span">Read more</span>
                <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
              </a>
  
           
  
              <p>Total views: 999+</p>
            </div>
          </li>
        @endforeach
  
      </div>
    </div>
  </section>

  <!-- CONTACT Section -->
  <section class="section contact" id="contact" aria-label="contact">
    <div class="container">

      <p class="section-subtitle">Contact</p>

      <h2 class="h2 section-title has-underline">
        Write me anything
        <span class="span has-before"></span>
      </h2>

      <div class="wrapper">

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Contact Form -->
        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required class="input-field" value="{{ old('name') }}">
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror

            <input type="email" name="email_address" placeholder="Your Email" required class="input-field" value="{{ old('email_address') }}">
            @error('email_address')<span class="text-danger">{{ $message }}</span>@enderror

            <input type="text" name="subject" placeholder="Subject" required class="input-field" value="{{ old('subject') }}">
            @error('subject')<span class="text-danger">{{ $message }}</span>@enderror

            <textarea name="message" placeholder="Your Message" class="input-field">{{ old('message') }}</textarea>
            @error('message')<span class="text-danger">{{ $message }}</span>@enderror

            <button type="submit" class="btn btn-primary">Send Now</button>
        </form>

        <ul class="contact-card">
          <li>
            <p class="card-title">Address: Phnom Penh</p>
            <address class="address">16, Lankaway<br>Phnom Penh, Cambodia</address>
          </li>
          <li>
            <p class="card-title">Phone: +855 123 456</p>
            <a href="tel:+855123456" class="card-link">+855 123 456</a>
          </li>
          <li>
            <p class="card-title">Email:</p>
            <a href="mailto:support@Teameme.com" class="card-link">support@Teameme.com</a>
          </li>
          <li>
            <p class="social-list-title h3">Our Contact</p>
            <ul class="social-list">
              <ul class="social-list">
                <li><a href="https://facebook.com" class="social-link" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a></li>
                <li><a href="https://twitter.com" class="social-link" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a></li>
                <li><a href="https://linkedin.com" class="social-link" target="_blank"><ion-icon name="logo-linkedin"></ion-icon></a></li>
                <li><a href="https://youtube.com" class="social-link" target="_blank"><ion-icon name="logo-youtube"></ion-icon></a></li>
                <li><a href="https://whatsapp.com" class="social-link" target="_blank"><ion-icon name="logo-whatsapp"></ion-icon></a></li>
            </ul>
            
            </ul>
          </li>
        </ul>

      </div>

    </div>
  </section>

</article>
</main>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="footer-bottom">
      <p class="copyright">
        &copy; 2025 All right reserved. Made with ❤ by MemeTeam.
      </p>
    </div>
  </div>
</footer>

<!-- Custom JS -->
<script src="{{ asset('js/script.js') }}"></script>

<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@endsection
