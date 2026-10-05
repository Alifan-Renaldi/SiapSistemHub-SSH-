<?php
// development_notice.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Fitur Dalam Pengembangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .notice-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 450px;
        }
        .notice-box h1 {
            color: #ff6600;
            margin-bottom: 15px;
        }
        .notice-box p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        .notice-box button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }
        .notice-box button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="notice-box">
        <h1>🚧 Fitur Dalam Pengembangan</h1>
        <p>Mohon maaf, fitur ini sedang dalam tahap pengembangan.<br>
           Silakan akses kembali setelah tim pengembang memberikan informasi lebih lanjut.</p>
        <form action="<?= base_url('dashboard'); ?>" method="get">
            <button type="submit">Kembali ke Beranda</button>
        </form>
    </div>
</body>
</html>
