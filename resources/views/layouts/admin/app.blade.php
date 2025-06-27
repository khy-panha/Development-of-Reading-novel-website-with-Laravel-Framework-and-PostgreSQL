<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Review App</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>


{{-- 
    <link rel="stylesheet" href="{{ asset('css/style_part.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    {{-- <script src="/ckeditor/ckeditor.js"></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style_book.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/admin/style_admin_dashbord.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style_pending.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style_admin_sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/style_header.css') }}">

    
    <title>Admin Dashboard</title>
</head>

        <header class="admin-header">
            <h1>Admin Dashboard</h1>
            <div class="admin-header-controls">
           
                <a href="{{route('home')}}" class="logo">ReadNovel</a>
              
                <div class="navbar-item">
                    <span class="admin-header-user-info">👤 Admin {{ Auth::user()->name }}</span>
                    {{-- <a href="#contact" class="navbar-link" data-nav-link>Account</a> --}}
                    @if (Auth::check())
                    <a href="{{route ('account.profile')}}" class="navbar-link"">My Account</a>
                    @else
                    
                    <a href="{{route ('account.login')}}" class="navbar-link">Login</a>
                    <a href="{{route ('account.register')}}" class="navbar-link">Register</a>
                    @endif
                </div>
                  <form method="POST" action="{{ route('account.logout') }}" class="account-card logout-form">
                    @csrf
                    <button type="submit" class="admin-logout-button" ">Logout 🔓</button>
                </form>
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
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @yield('script')

</body>
</html>
