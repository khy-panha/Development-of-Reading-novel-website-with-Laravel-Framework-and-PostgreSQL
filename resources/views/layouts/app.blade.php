<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read Novel</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <link rel="stylesheet" href="{{ asset('css/style_part.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="/ckeditor/ckeditor.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('css\book\style_book.css') }}">
    
</head>

    <header class="header active" data-header>
        <div class="container">
    
          <a href="{{route('home')}}" class="logo">ReadNovel</a>
    
          <nav class="navbar" data-navbar>
            <ul class="navbar-list">
    
              <li class="navbar-item">
                <a href="#home" class="navbar-link" data-nav-link>Home</a>
              </li>
    
              <li class="navbar-item">
                <a href="#newNovel" class="navbar-link" data-nav-link>NewNovel</a>
              </li>
    
              <li class="navbar-item">
                <a href="#popular" class="navbar-link" data-nav-link>Pupular</a>
              </li>
    
              <li class="navbar-item">
                
                <a href="#search" class="navbar-link" data-nav-link>
                <form action="{{ route('book.search') }}" method="GET" class="d-flex">
                  <input class="search-header " type="text" id="searchInput"
                      placeholder="Search for a book..." name="keyword"
                      placeholder="Search by title, author, or genre" value="{{ request('keyword') }}">
                      <button type="submit" class="search-button ">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
              </form>
            </a>
              </li>
    
              <li class="navbar-item">
                {{-- <a href="#contact" class="navbar-link" data-nav-link>Account</a> --}}
                @if (Auth::check())
                <a href="{{route ('account.profile')}}" class="navbar-link"">My Account</a>
                @else
                
                <a href="{{route ('account.login')}}" class="navbar-link">Login</a>
              </li>
              <li class="navbar-item">
                <a href="{{route ('account.register')}}" class="navbar-link">Register</a>
                @endif
              </li>
                
   
    
            </ul>
          </nav>
    
          <button class="nav-toggle-btn" aria-label="toggle menu" data-nav-toggler>
            <ion-icon name="menu-outline" aria-hidden="true" class="open"></ion-icon>
    
            <a href="#">
              <ion-icon name="close-outline" aria-hidden="true" class="close"></ion-icon>
            </a>
          </button>
    
        </div>
      </header>

    <body class="bg-light">

    @yield('main')

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    @yield('script')
</body>

</html>