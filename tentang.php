<?php
    include 'navbar/tentangnav.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .about-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .about-header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .about-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }
        .about-text {
            flex: 1 1 60%;
            text-align: justify;
        }
        .about-image {
            flex: 1 1 30%;
        }
        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .team-section {
            margin-top: 50px;
        }
        .team-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }
        .team-image {
            flex: 1 1 35%;
        }
        .team-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .team-text {
            flex: 1 1 60%;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="about-header">
            <h1>Tentang Kami</h1>
            <p>Selamat datang di YourPC.id!</p>
        </div>

        <div class="about-content">
            <div class="about-text">
                <p>YourPC.id adalah platform yang dirancang untuk membantu pengguna merakit PC sesuai kebutuhan dan anggaran mereka. Di sini, Anda dapat menemukan berbagai komponen PC berkualitas, mulai dari prosesor, motherboard, hingga kartu grafis.</p>
                <p>Kami percaya bahwa setiap orang memiliki kebutuhan unik saat merakit PC, baik untuk gaming, pekerjaan profesional, maupun kebutuhan sehari-hari. Oleh karena itu, kami menyediakan berbagai opsi yang dapat disesuaikan dengan preferensi Anda.</p>
                <p>Dengan YourPC.id, Anda tidak hanya dapat membeli komponen, tetapi juga mendapatkan panduan untuk merakit PC rakitan impian Anda dengan mudah dan efisien.</p>
                <p>Terima kasih telah memilih YourPC.id sebagai solusi terpercaya untuk kebutuhan PC Anda. Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami.</p>
            </div>

            <div class="about-image">
                <img src="images/Yp (3).png" alt="Gambar tentang YourPC.id">
            </div>
        </div>

        <div class="team-section">
            <div class="team-content">
                <div class="team-image">
                    <img src="images/group2.jpg" alt="Foto Group 2">
                </div>
                <div class="team-text">
                    <p>Group 2 adalah tim yang bekerja sama untuk membangun YourPC.id. Dengan dedikasi dan keahlian di berbagai bidang, kami berhasil menciptakan platform yang dapat membantu pengguna menemukan dan merakit PC sesuai kebutuhan mereka.</p>
                    <p>Anggota Group 2 terdiri dari para profesional dengan latar belakang teknologi informasi, desain, dan pemasaran. Kami berkomitmen untuk terus meningkatkan layanan kami agar YourPC.id menjadi solusi terbaik untuk kebutuhan PC Anda.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
