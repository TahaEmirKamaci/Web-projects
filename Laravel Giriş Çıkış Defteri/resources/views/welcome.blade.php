<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <style>
        .bg-custom {
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg/1280px-Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg');
            width: 100%;
            height: 100vh;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .wrapper {
            background: transparent;
            border: 2px solid #ffffff;
            backdrop-filter: blur(5px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 2);
            color: #ffff;
            border-radius: 20px;
            padding: 20px 30px;
        }
        h1 {
            position: static;
            top: 50%;
            left: 50%;
            transform: translate(105%, 0);
            text-align: center;
            width: max-content;
            font-size: 4rem; /* Default font size */
            font-family: 'Montserrat', sans-serif;
            background: -webkit-linear-gradient(0deg,rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.25));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            backdrop-filter: blur(10px);
        }
        @media (max-width: 1300px) {
            h1 {
                transform: translate(60%, 0);
                font-size: 3rem;
            }
        }
        @media (max-width: 1200px) {
            h1 {
                transform: translate(55%, 0);
                font-size: 3rem;
            }
        }
        @media (max-width: 992px) {
            h1 {
                transform: translate(45%, 0);
                font-size: 2.5rem;
            }
        }
        @media (max-width: 768px) {
            h1 {
                transform: translate(30%, 0);
                font-size: 2rem;
            }
        }
        @media (max-width: 576px) {
            h1 {
                transform: translate(15%, 0);
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-custom">
        <h1 class="justify-content-center text-center text-white">Giriş Sayfasına Hoş Geldiniz</h1>
        <div class="container">
            <div class="wrapper">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Tab navigation -->
                        <ul class="nav nav-tabs" id="authTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Giriş Yap</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Kayıt Ol</button>
                            </li>
                            <li class="nav-item nav" role="button">
                                <button class="nav-link" id="record-tab" data-bs-toggle="tab" data-bs-target="#record" type="button" role="tab" aria-controls="record" aria-selected="false">
                                    <a href="{{ route('record') }}" class="text-black" style="text-decoration: none">Giriş Kaydı Oluştur</a>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-4" id="authTabContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <form id="loginForm" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="loginEmail" class="form-label">Email adresi</label>
                                        <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Emailinizi girin" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label">Şifre</label>
                                        <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Şifrenizi girin" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form method="POST" action="{{ route('RegistrationForm') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="registerEmail" class="form-label">Email adresi</label>
                                        <input type="email" name="email" class="form-control" id="registerEmail" placeholder="Emailinizi girin" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPassword" class="form-label">Şifre</label>
                                        <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Şifrenizi girin" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="registerPasswordConfirm" class="form-label">Şifreyi Onayla</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="registerPasswordConfirm" placeholder="Şifrenizi tekrar girin" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Kayıt Ol</button>
                                </form>
                                @if ($errors->any())
                                <div class="alert alert-danger mt-2">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if (session('success'))
                                <div class="alert alert-success mt-2">
                                    {{ session('success') }}
                                </div>
                                @endif
                            </div>

                            <!-- Record Form -->
                            <div class="tab-pane fade" id="record" role="tabpanel" aria-labelledby="record-tab">
                                <!-- Record form content here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Formun varsayılan gönderim işlemini durdur

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    alert(data.message || "Yanlış email veya şifre girdiniz!");
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert("Bir hata oluştu, lütfen tekrar deneyin.");
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</body>
</html>
