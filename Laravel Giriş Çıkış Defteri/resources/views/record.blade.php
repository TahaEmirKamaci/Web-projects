<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Kayıt Formu</title>

    <style>
        .responsive {
            text-align: center;
            justify-content: center;
            border-radius: 43%;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        @media (max-width: 992px) {
            .responsive {
                text-align: center;
                justify-content: center;
                border-radius: 43%;
                width: 65px;
                height: 65px;
                object-fit: cover;
            }
        }
    </style>
</head>

<?php
dd($record);
exit();
?>

<body class="bg-black">
    <h1 class="justify-content-center text-center text-white"><strong>Kayıt Formu</strong></h1>
    <div class="container mt-5 bg-light rounded-4">
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="name" class="form-label">Ad</label>
                <input type="text" name="name" class="form-control" placeholder="Adınızı Giriniz" required>
            </div>
            <div class="col-md-6">
                <label for="surname" class="form-label">Soyad</label>
                <input type="text" name="surname" class="form-control" placeholder="Soyadınızı Giriniz" required>
            </div>
            <div class="col-12">
                <label for="appointment" class="form-label">Randevunuz Var Mı ?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="appointment" id="gridRadios1" value="Evet"
                        checked>
                    <label class="form-check-label" for="gridRadios1">Evet</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="appointment" id="gridRadios2" value="Hayır">
                    <label class="form-check-label" for="gridRadios2">Hayır</label>
                </div>
            </div>
            <div class="col-12">
                <label for="purpose" class="form-label">Ne İçin Geldiniz ?</label>
                <input type="text" name="purpose" class="form-control" placeholder="Ne için geldiniz" required>
            </div>
            <div class="col-12">
                <label for="who" class="form-label">Kim İle Görüşeceksiniz ?</label>
                <input type="text" name="who" class="form-control" placeholder="Kişinin ismi" required>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="formFile" class="form-label">Giriş Yapan Kişinin Fotoğrafını Ekleyiniz .</label>
                    <input class="form-control" name="image" type="file" id="formFile" accept="image/*">
                </div>
            </div>
            <div class="col-12 justify-content-center" style="text-align: center">
                <button type="submit" name="submit" class="btn btn-success">Kayıt Ekle</button>
                <button type="reset" name="clear" class="btn btn-danger">Resetle</button>
                <button type="back" name="back" class="btn btn-info"> <a style=" text-decoration: none"
                        href="{{ route('welcome') }}" class="text-white">Geri Dön</a></button>
            </div>


        </form>

        <!-- List of records to check out -->
        <h2 class="mt-5 justify-center" style="text-align: center">Çıkış Yap</h2>
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div style ="text-align:center;">
                <label for="record_id" class=" justify-content-center " style="text-align: center ">Kayıt Seçin</label>

                <select name="record_id" class="custom-select custom-select-sm">
                    @foreach ($records as $record)
                        <option value="{{ $record->id }}">
                            {{ htmlspecialchars($record->name . ' ' . $record->surname) }}
                        </option>
                    @endforeach
                </select>
                <br><br>
            </div>
            <div class="col-12 justify-content-center" style="text-align: center">
                <button type="submit" name="checkout" class="btn btn-warning">Çıkış Yap</button>
            </div>
            @if ($errors->any())
                <div class=" alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </form>

        <!-- Display all records with entry and exit times -->
        <h2 class="mt-5">Tüm Kayıtlar</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Ne için Geldi</th>
                    <th>Giriş Zamanı</th>
                    <th>Çıkış Zamanı</th>
                    <th>Resim</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($all_records as $record)
                    <tr>
                        <td>{{ htmlspecialchars($record->name) }}</td>
                        <td>{{ htmlspecialchars($record->surname) }}</td>
                        <td>{{ htmlspecialchars($record->purpose) }}</td>
                        <td>{{ htmlspecialchars($record->Date) }}</td>
                        <td>{{ $record->Date_exit ? htmlspecialchars($record->Date_exit) : 'Hala İçeride' }}</td>
                        <td><img src="{{ asset('storage/uploads/' . $records->image) }}"
                                class = "responsive"alt="Kayıt Resmi"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($page > 1)
                    <li class="page-item">
                        <a class="page-link" href="?page={{ $page - 1 }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif
                @for ($i = 1; $i <= $total_pages; $i++)
                    <li class="page-item {{ $i == $page ? 'active' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                @endfor
                @if ($page < $total_pages)
                    <li class="page-item">
                        <a class="page-link" href="?page={{ $page + 1 }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
