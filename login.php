<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $sifre = trim($_POST["sifre"]);

    // E-posta ve şifre boş mu?
    if (empty($email) || empty($sifre)) {
        header("Location: login.html");
        exit();
    }

    // Geçerli e-posta mı?
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@sakarya\.edu\.tr$/', $email)) {
        echo "<h2 class='hata-mesaji'>❌ Geçersiz e-posta formatı!</h2>";
        echo "<a href='login.html'>Geri dön</a>";
        exit();
    }

    // kullanicilar.txt dosyasından doğrulama
    $dosya_yolu = __DIR__ . "/kullanicilar.txt";
    $giris_basarili = false;
    $kullaniciAdi = explode("@", $email)[0]; // Varsayılan değer

    if (file_exists($dosya_yolu)) {
        $satirlar = file($dosya_yolu, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($satirlar as $satir) {
            // register.php'deki kayıt formatı: "$ad $soyad - $email - $sifre"
            $bilgiler = explode(" - ", $satir);
            if (count($bilgiler) >= 3) {
                $kayitli_email = trim($bilgiler[1]);
                $kayitli_sifre = trim($bilgiler[2]);
                
                if ($kayitli_email === $email && $kayitli_sifre === $sifre) {
                    $giris_basarili = true;
                    $kullaniciAdi = trim($bilgiler[0]); // Dosyadaki Ad Soyad'ı al
                    break;
                }
            }
        }
    }

    if ($giris_basarili) {
        echo "
        <!DOCTYPE html>
        <html lang='tr'>
        <head>
          <meta charset='UTF-8'>
          <meta http-equiv='refresh' content='3;url=index.html'>
          <title>Giriş Başarılı</title>
          <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='bg-light'>
          <div class='container mt-5 text-center'>
            <h2 class='text-success'>✅ Giriş Başarılı</h2>
            <p>Hoş geldiniz <strong>$kullaniciAdi</strong></p>
            <p>3 saniye içinde ana sayfaya yönlendiriliyorsunuz...</p>
          </div>
        </body>
        </html>";
    } else {
        echo "
        <!DOCTYPE html>
        <html lang='tr'>
        <head>
          <meta charset='UTF-8'>
          <title>Giriş Başarısız</title>
          <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='bg-light'>
          <div class='container mt-5 text-center'>
            <h2 class='text-danger'>❌ Giriş Başarısız</h2>
            <p>Şifre hatalı veya kullanıcı adı eşleşmiyor.</p>
            <a href='login.html' class='btn btn-outline-danger mt-3'>Tekrar Dene</a>
          </div>
        </body>
        </html>";
    }
} else {
    // POST ile gelinmemişse login formuna yönlendir
    header("Location: login.html");
    exit();
}
?>
