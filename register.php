<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST["ad"]);
    $soyad = htmlspecialchars($_POST["soyad"]);
    $email = htmlspecialchars($_POST["email"]);
    $sifre = htmlspecialchars($_POST["sifre"]);

    // E-posta uzantısı kontrolü
    if (!preg_match("/@sakarya\.edu\.tr$/", $email)) {
        $mesaj = "<h2 class='text-danger'>❌ Geçersiz E-posta!</h2>
                  <p>Lütfen sadece <strong>@sakarya.edu.tr</strong> uzantılı bir e-posta adresi girin.</p>
                  <a href='register.html' class='btn btn-warning mt-3'>Geri Dön</a>";
    } else {
        $satir = "$ad $soyad - $email - $sifre\n";
        $dosya_yolu = "kullanicilar.txt";
        $kayit_var = false;

        // Önceden kayıtlı mı kontrol et
        if (file_exists($dosya_yolu)) {
            $satirlar = file($dosya_yolu, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($satirlar as $mevcut_satir) {
                if (strpos($mevcut_satir, "$ad $soyad") !== false || strpos($mevcut_satir, $email) !== false) {
                    $kayit_var = true;
                    break;
                }
            }
        }

        if ($kayit_var) {
            $mesaj = "<h2 class='text-danger'>❌ Kayıt Zaten Mevcut!</h2>
                      <p><strong>$ad $soyad</strong> ya da <strong>$email</strong> zaten kayıtlı.</p>
                      <a href='register.html' class='btn btn-warning mt-3'>Geri Dön</a>";
        } else {
            $dosya = fopen($dosya_yolu, "a");
            fwrite($dosya, $satir);
            fclose($dosya);

            $mesaj = "<h2 class='text-success'>✅ Kayıt Başarılı!</h2>
                      <p>Teşekkürler <strong>$ad $soyad</strong>, bilgileriniz başarıyla kaydedildi.</p>
                      <a href='index.html' class='btn btn-primary mt-3'>Ana Sayfaya Dön</a>";
        }
    }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Kayıt Durumu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f1f1f1;
      font-family: 'Segoe UI', sans-serif;
    }
    .kutucuk {
      margin-top: 100px;
      padding: 40px;
      border-radius: 12px;
      background: white;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center">
    <div class="kutucuk">
      <?= $mesaj ?>
    </div>
  </div>
</body>
</html>
<?php
} else {
    header("Location: register.html");
    exit();
}
?>
