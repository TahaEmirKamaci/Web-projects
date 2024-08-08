<?php
    @include('1.php');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Kayıt Formu</title>
</head>
<body class="bg-black">
<h1 class="justify-content-center text-center text-white"><strong>Kayıt Formu</strong></h1>
<div class="container mt-5 bg-light rounded-4">

    <form action="" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Ad</label>
            <input type="text" name="name" class="form-control" placeholder="Adınızı Giriniz" required>
        </div>
        <div class="col-md-6">
            <label for="surname" class="form-label">Soyad</label>
            <input type="text" name="surname" class="form-control" placeholder="Soyadınızı Giriniz" required>
        </div>
        <div class="col-12">
            <label for="appointment" class="form-label">Randevunuz Var Mı?</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="appointment" id="gridRadios1" value="Evet" checked>
                <label class="form-check-label" for="gridRadios1">Evet</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="appointment" id="gridRadios2" value="Hayır">
                <label class="form-check-label" for="gridRadios2">Hayır</label>
            </div>
        </div>
        <div class="col-12">
            <label for="purpose" class="form-label">Ne İçin Geldiniz</label>
            <input type="text" name="purpose" class="form-control" placeholder="Ne için geldiniz" required>
        </div>
        <div class="col-12">
            <label for="who" class="form-label">Kim İle Görüşeceksiniz ?</label>
            <input type="text" name="who" class="form-control" placeholder="Kişinin ismi" required>
        </div>
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-success">Kayıt Ekle</button>
            <button type="reset" name="clear" class="btn btn-danger">Resetle</button>
        </div>
    </form>

    <!-- List of records to check out -->
    <h2 class="mt-5">Çıkış Yap</h2>
    <form action="" method="POST">
        <label for="record_id">Kayıt Seçin</label>
        <select name="record_id" class="custom-select custom-select-sm">
            <?php foreach ($records as $record): ?>
                <option value="<?php echo $record['id']; ?>">
                    <?php echo htmlspecialchars($record['name'] . " " . $record['surname']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit" name="checkout" class="btn btn-warning">Çıkış Yap</button>
    </form>

    <!-- Display all records with entry and exit times -->
    <h2 class="mt-5">Tüm Kayıtlar</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Giriş Zamanı</th>
                <th>Çıkış Zamanı</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_records as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['name']); ?></td>
                    <td><?php echo htmlspecialchars($record['surname']); ?></td>
                    <td><?php echo htmlspecialchars($record['Date']); ?></td>
                    <td><?php echo $record['Date_exit'] ? htmlspecialchars($record['Date_exit']) : 'Hala İçeride'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
