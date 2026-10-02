<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Library Management System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    @vite([
        'resources/css/app.css',
        'resources/css/library.css'
    ])

</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">

        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand text-primary fw-bold" href="/">
                📚 Library Management
            </a>


            <!-- Mobile Menu Button -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            Home
                        </a>
                    </li>


                    <!-- Features -->
                    <li class="nav-item">
                        <a class="nav-link" href="#features">
                            Features
                        </a>
                    </li>


                    <!-- Login -->
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-outline-primary navbar-btn"
                        >
                            Login
                        </a>

                    </li>


                    <!-- Register -->
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">

                        <a
                            href="{{ route('register') }}"
                            class="btn btn-primary navbar-btn"
                        >
                            Register
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>


    <!-- ================= HERO ================= -->

    <section class="hero">

        <div class="container">

            <div class="row align-items-center">

                <!-- Left Content -->
                <div class="col-12 col-lg-7">

                    <h1>
                        Manage Your Library
                        <br>
                        Smarter & Easier
                    </h1>

                    <p class="mt-4">

                        A simple and powerful library management
                        system for managing books, students,
                        physical copies, borrowing and returns
                        in one place.

                    </p>


                    <div class="hero-buttons mt-4">

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-main"
                        >
                            Login to System
                        </a>


                        <a
                            href="#features"
                            class="btn btn-outline-light"
                        >
                            Explore Features
                        </a>

                    </div>

                </div>


                <!-- Right Content -->
                <div class="col-12 col-lg-5 text-center mt-5 mt-lg-0">

                    <div class="library-icon">
                        📚
                    </div>

                    <h4 class="mt-3">
                        Your Digital Library
                    </h4>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= FEATURES ================= -->

    <section id="features" class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="section-title">
                    Everything You Need
                </h2>

                <p class="text-muted">
                    Manage your library operations from one place.
                </p>

            </div>


            <div class="row g-4">

                <!-- Book Management -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="feature-card bg-white">

                        <div class="feature-icon">
                            📖
                        </div>

                        <h4>
                            Book Management
                        </h4>

                        <p class="text-muted">

                            Manage books, categories and physical
                            copies with unique accession numbers.

                        </p>

                    </div>

                </div>


                <!-- Student Management -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="feature-card bg-white">

                        <div class="feature-icon">
                            👨‍🎓
                        </div>

                        <h4>
                            Student Management
                        </h4>

                        <p class="text-muted">

                            Maintain student records and track
                            their complete borrowing history.

                        </p>

                    </div>

                </div>


                <!-- Issue Return -->
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="feature-card bg-white">

                        <div class="feature-icon">
                            🔄
                        </div>

                        <h4>
                            Issue & Return
                        </h4>

                        <p class="text-muted">

                            Issue available copies and process
                            returns while preserving borrowing history.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= STATISTICS ================= -->

    <section class="stat-section py-5">

        <div class="container">

            <div class="row text-center g-4">

                <div class="col-6 col-lg-3">

                    <div class="stat-number">
                        500+
                    </div>

                    <div>
                        Books
                    </div>

                </div>


                <div class="col-6 col-lg-3">

                    <div class="stat-number">
                        1000+
                    </div>

                    <div>
                        Students
                    </div>

                </div>


                <div class="col-6 col-lg-3">

                    <div class="stat-number">
                        1500+
                    </div>

                    <div>
                        Book Copies
                    </div>

                </div>


                <div class="col-6 col-lg-3">

                    <div class="stat-number">
                        24/7
                    </div>

                    <div>
                        Easy Access
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= FOOTER ================= -->

    <footer class="py-4">

        <div class="container text-center">

            <p class="mb-1">
                📚 Library Management System
            </p>

            <small>
                Manage books. Manage students. Manage borrowing.
            </small>

        </div>

    </footer>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>