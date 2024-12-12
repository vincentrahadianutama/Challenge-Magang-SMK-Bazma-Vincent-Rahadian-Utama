<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body, html {
            height: 100%;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
        .navbar-purple {
            background-color: #6a1b9a; /* Warna ungu */
        }
        .footer-purple {
            background-color: #6a1b9a; /* Warna ungu */
        }
        .footer-purple a {
            color: #f3e5f5; /* Warna teks link lebih terang */
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <!-- Navigasi -->
        <nav class="navbar navbar-expand-lg navbar-purple navbar-dark">
            <a class="navbar-brand" href="#">Book Management</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('book_categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.index') }}">Books</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Konten -->
        <div class="content container mt-4">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer-purple text-white text-center py-3">
            <p class="mb-0">© 2024 Book Management System Created by Vincent Rahadian Utama.</p>
            <p class="mb-0">
                <a href="https://www.linkedin.com/in/vincent-rahadian-utama-a928312a4/" target="_blank">LinkedIn</a> | 
                <a href="https://www.instagram.com/vncnt_ru/" target="_blank">Instagram</a>
            </p>
        </footer>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
        @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
        @endif
    </script>
</body>

</html>
