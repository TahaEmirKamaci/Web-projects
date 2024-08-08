<?php
session_start();
ob_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=kayıt;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Insert new record
if ($_POST && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST["name"]);
    $surname = htmlspecialchars($_POST["surname"]);
    $who = htmlspecialchars($_POST["who"]);
    $appointment = htmlspecialchars($_POST["appointment"]);
    $purpose = htmlspecialchars($_POST["purpose"]);
    $date = date('Y-m-d H:i:s');

    try {
        $stmt = $db->prepare("INSERT INTO kayıt (name, surname, who, appointment, purpose, Date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $surname, $who, $appointment, $purpose, $date]);

        echo "Kayıt başarılı.";
    } catch (PDOException $e) {
        echo "Kayıt sırasında bir hata oluştu: " . $e->getMessage();
    }
}

// Update checkout time
if ($_POST && isset($_POST['checkout'])) {
    if (isset($_POST['record_id'])) {
        $record_id = intval($_POST['record_id']);
        $checkout_date = date('Y-m-d H:i:s');

        try {
            $stmt = $db->prepare("UPDATE kayıt SET Date_exit = ? WHERE id = ?");
            $stmt->execute([$checkout_date, $record_id]);

        } catch (PDOException $e) {
            echo "Çıkış sırasında bir hata oluştu: " . $e->getMessage();
        }
    } else {
        echo "Kayıt seçilmedi.";
    }
}

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1); // Sayfanın 1'den küçük olmasını önleyin
$offset = ($page - 1) * $records_per_page;

$records = [];
$total_pages = 0;
$all_records = [];

try {
    // Fetch records for current page (excluding those with a checkout date)
    $sql = "SELECT * FROM kayıt WHERE Date_exit IS NULL ORDER BY Date ASC LIMIT :offset, :records_per_page";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch records for current page (including those with a checkout date)
    $sql = "SELECT * FROM kayıt ORDER BY Date ASC LIMIT $offset, $records_per_page";
    $stmt = $db->query($sql);
    $all_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total number of records
    $total_records_stmt = $db->query("SELECT COUNT(*) FROM kayıt");
    $total_records = $total_records_stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);
    
} catch (PDOException $e) {
    echo "Kayıtları getirirken bir hata oluştu: " . $e->getMessage();
}
?>