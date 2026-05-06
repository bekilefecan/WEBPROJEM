<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adSoyad = htmlspecialchars($_POST["adSoyad"]);
    $email = htmlspecialchars($_POST["email"]);
    $mesaj = nl2br(htmlspecialchars($_POST["mesaj"]));

    // Verileri dosyaya kaydet
    $satir = "$adSoyad - $email - $mesaj\n";
    $dosya = fopen("mesajlar.txt", "a");
    fwrite($dosya, $satir);
    fclose($dosya);
} else {
    header("Location: iletisim.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Mesajınız Alındı</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="text-center">
      <div class="success-icon mb-3">✅</div>
      <h2 class="card-title">Mesajınız Alındı!</h2>
      <p>Teşekkürler <strong><?= $adSoyad ?></strong>, en kısa sürede size geri dönüş yapılacaktır.</p>
      <a href="index.html" class="btn btn-primary mt-3">Ana Sayfaya Dön</a>
    </div>
  </div>
</body>
</html>
