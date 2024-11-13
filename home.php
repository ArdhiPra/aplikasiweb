<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yourpc.id</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="icon" href="images/yplogo.png">
</head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid p-0">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="images/Logo sma 3.svg" alt="Bootstrap" width="66" height="60"
                        class="d-inline-block align-text-top">
                    <div class="ms-3 d-flex flex-column">
                        <span class="SMA"> </span>
                        <span class="slogan"></span>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-md-flex flex-md-row-reverse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.html">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="galeri.html">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kontak.html">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div id="carouselExample" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <?php
            // Array gambar atau item carousel
            $images = ["iklan1.png", "iklan4.png", "iklan3.png"];
            
            // Loop u  
            foreach ($images as $index => $image) {
                $activeClass = $index === 0 ? 'active' : '';
                echo '<div class="carousel-item ' . $activeClass . '">';
                echo '<img src="images/' . $image . '" class="d-block w-100" alt="Slide ' . ($index + 1) . '">';
                echo '</div>';
            }
            ?>
        </div>

    <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mb-5">
        <div class="category-section">
        <div class="category-title">Category</div>
            <div class="icon-container">
                <div class="icon-item">
                    <img src="images/prepcicon.svg" alt="Pre-built">
                    <p>Pre-built</p>
                </div>
            <div class="icon-item">
                <img src="images/vgaicon.svg" alt="VGA">
                <p>VGA</p>
            </div>
            <div class="icon-item">
                <img src="images/cpuicon.svg" alt="Processor">
                <p>Processor</p>
            </div>
            <div class="icon-item">
                <img src="images/mbicon.svg" alt="Motherboard">
                <p>Motherboard</p>
            </div>
            <div class="icon-item">
                <img src="images/hddicon.svg" alt="HDD">
                <p>HDD</p>
            </div>
            <div class="icon-item">
                <img src="images/ssdicon.svg" alt="SSD">
                <p>SSD</p>
            </div>
            <div class="icon-item">
                <img src="images/ramicon.svg" alt="RAM">
                <p>RAM</p>
            </div>
            <div class="icon-item">
                <img src="images/psuicon.svg" alt="PSU">
                <p>PSU</p>
            </div>
            <div class="icon-item">
                <img src="images/caseicon.svg" alt="Casing">
                <p>Casing</p>
            </div>
            <div class="icon-item">
                <img src="images/monitoricon.svg" alt="Monitor">
                <p>Monitor</p>
            </div>
        </div>
    </div>
    </div>

    <footer class="footer py-5">
        <div class="container">
                <div class="row">
                    <!-- Tentang Kami Column -->
                    <div class="col-6 col-md-3 mb-3">
                        <h5 class="footer-title">Tentang Kami</h5>
                        <ul class="list-unstyled">
                        <li><a href="kontak.html">Tentang Kami</a></li>
                        <li><a href="#tentang">Kebijakan Privasi</a></li>
                        <li><a href="galeri.html">Syarat dan Ketentuan</a></li>
                        </ul>
                </div>
                
                <!-- Metode Pembayaran Column -->
                <div class="col-6 col-md-3 mb-3">
                    <h5 class="footer-title">Metode Pembayaran</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#pembayaran">
                                <img src="images/pembayaran.svg" alt="Pembayaran Icon" class="footer-icon">
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Connect (Social Media) Column -->
                <div class="col-6 col-md-3 mb-3">
                    <h5 class="footer-title">Media Sosial</h5>
                    <div class="d-flex">
                        <a href="https://www.instagram.com/dh_oh_eb/?utm_source=ig_web_button_share_sheet" target="_blank" class="me-2">
                            <img src="images/iglogo.png" alt="Instagram" class="social-icon">
                        </a>
                        <a href="https://www.tiktok.com/@yourprofile" target="_blank" class="me-2">
                            <img src="images/tiktoklogo.png" alt="TikTok" class="social-icon">
                        </a>
                        <a href="https://twitter.com/yourprofile" target="_blank">
                            <img src="images/xlogo.png" alt="X" class="social-icon">
                        </a>
                    </div>
                </div>
                
                <!-- Metode Pengiriman Column -->
                <div class="col-6 col-md-3 mb-3">
                    <h5 class="footer-title">Metode Pengiriman</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#pengiriman">
                                <img src="images/pengiriman.svg" alt="Pengiriman Icon" class="footer-icon-pengiriman">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Middle Row: Download Buttons -->
            <div class="row mt-4">
                <div class="col text-center">
                    <a href="#"><img src="images/appstore.png" alt="App Store" class="download-icon me-2"></a>
                    <a href="#"><img src="images/microsoft.png" alt="Microsoft" class="download-icon me-2"></a>
                    <a href="#"><img src="images/macappstore.png" alt="Mac App Store" class="download-icon me-2"></a>
                    <a href="#"><img src="images/googleplay.png" alt="Google Play" class="download-icon"></a>
                </div>
            </div>

            <!-- Bottom Row: Terms Links -->
            <div class="row mt-3">
                <div class="col text-center">
                    <p class="mb-0"><a href="#">Security</a> | <a href="#">Privacy</a> | <a href="#">Terms</a> | <a href="#">Settings</a></p>
                    <p class="mt-2">&copy; 2024 SMAN 3 Denpasar. Developed by <a href="#">Ardhi Pra</a></p>
                </div>
            </div>
        </div>
    </footer>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
