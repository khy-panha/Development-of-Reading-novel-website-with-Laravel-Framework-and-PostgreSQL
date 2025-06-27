@extends('layouts.admin.app')

@section('main')
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
    <div id="dashboard">
        <aside class="admin-sidebar">
            <nav class="admin-sidebar-nav">
                <h2>Navigation</h2>
                <a href="#overview" onclick="showSection('overview')">Dashboard</a>
                <a href="#users" onclick="showSection('users')">👤 User Management</a>
                <a href="#books" onclick="showSection('books')">📚 Book Management</a>
                <a href="#subscriptions" onclick="showSection('subscriptions')">💳 Pending To Become Author</a>
                <a href="#analytics" onclick="showSection('analytics')">📈 Analytics</a>
                <a href="#feedback" onclick="showSection('feedback')">📬 Feedback/Reports</a>
            </nav>
        </aside>
        
        <main>
            {{-- Dashboard Overview --}}
            <section id="overview" class="section active">
                <h1>Dashboard Overview</h1>
                <div class="stats">
                    <div class="stat-card">📊 Total Users: <strong>{{ $totalUsers }}</strong></div>
                    <div class="stat-card">📚 Total Books: <strong>{{ $totalBooks }}</strong></div>
                    <div class="stat-card">💳 Total Subscriptions: <strong>{{ $totalSubscriptions }}</strong></div>
                    <div class="stat-card">💖 Total Likes: <strong>{{ $totalLikes }}</strong> / Total Views: <strong>{{ $totalViews }}</strong></div>
                </div>
            <div class="graph">
                <h2>📅 Books Posted Per Day</h2>
                <canvas id="booksPerDayChart"></canvas>
            
                <!-- Graph for Subscription Trends -->
                <h2>📈 Subscription Trends</h2>
                <canvas id="subscriptionTrendsChart"></canvas>
            </div>
            
            </section>

            {{-- User Management --}}
            <section id="users" class="section">
                <h1>User Management</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="navbar-item">
                    <a href="{{route ('account.register')}}" class="navbar-link">Register</a>
                </div>

            </section>

            {{-- Book Management --}}
            <section id="books" class="section">
                <h1>Book Management</h1>
                <a href="{{ route('books.create') }}" class="create-button">+ Create Series</a>

                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->genre1 }}, {{ $book->genre2 }}</td>
                            <td>{{ $book->status }}</td>
                            <td>
                                <a href="{{route('books.destroy',$book->id)}}"><button class="btn-destroy"> Delate </button></a>
                                <a href="{{route('books.edit',$book->id)}}"><button class="btn-edit">  Edit </button></a>
                                <a href="{{route('stories.create',$book->id)}}"><button class="btn-create"> +Add </button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($stories->isNotEmpty())
                <h2>Series</h2>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Book Id</th>
                            <th>Series Title</th>
                            <th>Part</th>
                            <th>Story</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stories as $story)
                        <tr>
                            <td>{{ $story->id }}</td>
                            <td>{{ $story->book_id }}</td>
                            <td>{{ $story->book->title }}</td>
                            <td>{{ $story->part }}</td>
                            <td>{{ Str::limit($story->story, 100) }}</td>
                            <td>
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
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
            </section>

            {{-- Analytics --}}
            <section id="analytics" class="section">
                <h1>Analytics</h1>
                <h2>📚 Top Subscribed Books</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Number of Subscriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSubscribedBooks as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->subscription_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </section>

            {{-- Pending Author & Subscriptions --}}
            <section id="books" class="section">
                <h1>Book Management</h1>
                <a href="{{ route('books.create') }}" class="create-button">+ Create Series</a>
            
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->genre1 }}, {{ $book->genre2 }}</td>
                            <td>{{ $book->status }}</td>
                            <td>
                                <div class="group-button">
                                    <button class="btn-destroy"><a href="{{route('books.destroy',$book->id)}}">Delate</a></button>
                                    <button class="btn-edit"><a href="{{route('books.edit',$book->id)}}"> Edit </a></button>
                                    <button class="btn-create"><a href="{{route('stories.create',$book->id)}}"> + Add </a></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            
                @if ($stories->isNotEmpty())
                <h2>Series</h2>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Book Id</th>
                            <th>Series Title</th>
                            <th>Part</th>
                            <th>Story</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stories as $story)
                        <tr>
                            <td>{{ $story->id }}</td>
                            <td>{{ $story->book_id }}</td>
                            <td>{{ $story->book->title }}</td>
                            <td>{{ $story->part }}</td>
                            <td>{{ Str::limit($story->story, 100) }}</td>
                            <td>
                                <a href="{{ route('stories.create', [$book->id, $story->id]) }}" class="Add-Epersode">
                                    add episode
                                </a>
                                <a href="{{ route('stories.edit', [$book->id, $story->id]) }}" class="Edit-Eperode">
                                    Edit
                                </a>
                                <a href="{{ route('stories.destroy', [$book->id, $story->id]) }}" class="Delet-Epersode"
                                onclick="return confirm('Are you sure you want to delete this episode?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </section>
            
            <section id="subscriptions" class="section">
                <h1>Pending Authors</h1>
                <form method="POST" action="{{ route('admin.toggleApprovalMode', 'auto') }}">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Auto Approval</button>
                </form>
                <form method="POST" action="{{ route('admin.toggleApprovalMode', 'manual') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Manual Approval</button>
                </form>
                <p>Current Mode: <strong>{{ ucfirst($mode) }}</strong></p>
            
                @foreach($authors as $author)
                <div class="p-4 border rounded shadow my-2">
                    <p><strong>{{ $author->name }}</strong> - {{ $author->email }}</p>
                    @if($mode === 'manual')
                    <form method="POST" action="{{ route('admin.approveAuthor', $author->id) }}">
                        @csrf
                        <button class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.autoApproveAuthor', $author->id) }}">
                        @csrf
                        <button class="bg-blue-500 text-white px-3 py-1 rounded">Auto Approve</button>
                    </form>
                    @endif
                </div>
                @endforeach
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">#</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">Role</th>
                                {{-- <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">Approved</th>
                                <th class="px-4 py-2 text-left text-gray-600 font-semibold uppercase">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </section>
            

            {{-- Feedback --}}
            <section id="feedback" class="section mt-5">
                <h2>Feedback / Reports</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->name }}</td>
                                <td>{{ $feedback->email_address }}</td>
                                <td>{{ $feedback->message }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No feedback submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
            
        </main>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const booksPerDayLabels = {!! json_encode($booksPerDay->keys()) !!};
        const booksPerDayData = {!! json_encode($booksPerDay->values()) !!};

        const subscriptionLabels = {!! json_encode($subscriptionTrends->keys()) !!};
        const subscriptionData = {!! json_encode($subscriptionTrends->values()) !!};

        // Book Uploads Per Day Graph
        new Chart(document.getElementById('booksPerDayChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: booksPerDayLabels,
                datasets: [{
                    label: 'Books Uploaded',
                    data: booksPerDayData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        // Subscription Trends Graph
        new Chart(document.getElementById('subscriptionTrendsChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: subscriptionLabels,
                datasets: [{
                    label: 'Subscriptions',
                    data: subscriptionData,
                    backgroundColor: ['#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderColor: ['#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                responsive: true
            }
        });
    });
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }

        function logout() {
            alert("Logging out...");
            // Implement logout functionality
        }

        // User Management Functions
        function addUser() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;

            if (username && email) {
                const existingUserIndex = users.findIndex(user => user.email === email);
                if (existingUserIndex !== -1) {
                    // Update existing user
                    users[existingUserIndex].username = username;
                } else {
                    // Create new user
                    const newUser = {
                        id: userIdCounter++,
                        username: username,
                        email: email,
                        subscriptions: Math.floor(Math.random() * 3) // Random subscriptions (0, 1, or 2)
                    };
                    users.push(newUser);
                }
                document.getElementById('username').value = '';
                document.getElementById('email').value = '';
                updateUserList();
                document.getElementById('submit-button').innerText = "Add User"; // Reset button text
            } else {
                alert("Please fill in all fields.");
            }
        }

        function updateUserList() {
            const userList = document.getElementById('user-list');
            userList.innerHTML = '';
            users.forEach(user => {
                const row = `<tr>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.subscriptions}</td>
                    <td>
                        <button onclick="editUser(${user.id})">Edit</button>
                        <button onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                </tr>`;
                userList.innerHTML += row;
            });
            document.getElementById('total-users').innerText = users.length;
        }

        function searchUser() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const filteredUsers = users.filter(user => user.username.toLowerCase().includes(searchValue));
            const userList = document.getElementById('user-list');
            userList.innerHTML = filteredUsers.map(user => `
                <tr>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.subscriptions}</td>
                    <td>
                        <button onclick="editUser(${user.id})">Edit</button>
                        <button onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        function editUser(userId) {
            const user = users.find(user => user.id === userId);
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('submit-button').innerText = "Update User"; // Change button text to indicate update
        }

        function deleteUser(userId) {
            users = users.filter(user => user.id !== userId);
            updateUserList();
        }

        // Book Management Functions
        function addNewBook() {
            const title = document.getElementById('book-title').value;
            const author = document.getElementById('book-author').value;
            const category = document.getElementById('book-category').value;

            if (title && author && category) {
                const existingBookIndex = books.findIndex(book => book.title === title && book.author === author);
                if (existingBookIndex !== -1) {
                    // Update existing book logic
                    alert('Book already exists!');
                } else {
                    // Creating new book
                    const newBook = {
                        id: bookIdCounter++,
                        title: title,
                        author: author,
                        category: category,
                        status: 'Published' // Example status
                    };
                    books.push(newBook);
                    document.getElementById('book-title').value = '';
                    document.getElementById('book-author').value = '';
                    document.getElementById('book-category').value = '';
                    updateBookList();
                }
            } else {
                alert("Please fill in all fields.");
            }
        }

        function updateBookList() {
            const bookList = document.getElementById('book-list');
            bookList.innerHTML = '';
            books.forEach(book => {
                const row = `<tr>
                    <td><a href="History.html">${book.title}</a></td>
                    <td>${book.author}</td>
                    <td>${book.category}</td>
                    <td>${book.status}</td>
                    <td>
                        <button onclick="deleteBook(${book.id})">Delete</button>
                    </td>
                </tr>`;
                bookList.innerHTML += row;
            });
            document.getElementById('total-books').innerText = books.length;
        }

        function deleteBook(bookId) {
            books = books.filter(book => book.id !== bookId);
            updateBookList();
        }

         function cancelSubscription(button) {
            const row = button.closest('tr');
            const email = row.getAttribute('data-email');
            const statusCell = row.querySelector('.status');

            if (statusCell.innerText === 'Active') {
                statusCell.innerText = 'Inactive';
                button.innerText = 'Activate';
                button.setAttribute('onclick', "activateSubscription(this)"); // Update button text to activate
                alert(`Subscription for ${email} has been canceled.`);
            } else {
                alert(`Subscription for ${email} is already inactive.`);
            }
        }

        function activateSubscription(button) {
            const row = button.closest('tr');
            const email = row.getAttribute('data-email');
            const statusCell = row.querySelector('.status');

            if (statusCell.innerText === 'Inactive') {
                statusCell.innerText = 'Active';
                button.innerText = 'Cancel';
                button.setAttribute('onclick', "cancelSubscription(this)"); // Change to cancel button
                alert(`Subscription for ${email} has been activated.`);
            } else {
                alert(`Subscription for ${email} is already active.`);
            }
        }

        function reviewFeedback(button) {
            const row = button.closest('tr');
            const user = row.getAttribute('data-user');
            const messageCell = row.children[1]; // The message cell
            const actionCell = row.children[2]; // The action cell

            // Example action: Mark feedback as reviewed
            messageCell.innerText += " (Reviewed)";
            actionCell.innerHTML = "Reviewed"; // Change action cell to "Reviewed"
            button.disabled = true; // Disable the button after reviewing
            alert(`Feedback from ${user} has been reviewed.`);
        }

        function manageSEO() {
            // Simulate Managing SEO Functionality
            alert("Manage SEO functionality is under development.");
            // Here you can add the functionality to manage site SEO
        }

        function saveChanges() {
            // Simulate Save Changes Functionality
            const siteName = document.getElementById('site-name').value;
            const footerInfo = document.getElementById('footer-info').value;

            if (siteName && footerInfo) {
                alert("Changes have been saved successfully!");
                // Implement the logic to save changes
            } else {
                alert("Please ensure all fields are filled out before saving.");
            }
        }

    </script>
    
</body>
@endsection
