<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yourpc.id</title>
    <!-- Bootstrap CSS -->
    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="icon" href="images/yplogo.png"> 
</head>
<body>
    <?php include 'navbar/homenavbar.php';
    ?>

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
                <a href="category/pre-build.html">
                    <img src="images/prepcicon.svg" alt="Pre-built">
                    <p>Pre-built</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/vga.html">
                    <img src="images/vgaicon.svg" alt="VGA">
                    <p>VGA</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="cpu.php">
                    <img src="images/cpuicon.svg" alt="Processor">
                    <p>Processor</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/motherboard.html">
                    <img src="images/mbicon.svg" alt="Motherboard">
                    <p>Motherboard</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/hdd.html">
                    <img src="images/hddicon.svg" alt="HDD">
                    <p>HDD</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/ssd.html">
                    <img src="images/ssdicon.svg" alt="SSD">
                    <p>SSD</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/ram.html">
                    <img src="images/ramicon.svg" alt="RAM">
                    <p>RAM</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/psu.html">
                    <img src="images/psuicon.svg" alt="PSU">
                    <p>PSU</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/casing.html">
                    <img src="images/caseicon.svg" alt="Casing">
                    <p>Casing</p>
                </a>
            </div>
            <div class="icon-item">
                <a href="category/monitor.html">
                    <img src="images/monitoricon.svg" alt="Monitor">
                    <p>Monitor</p>
                </a>
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

            <!-- Media Sosial Column -->
            <div class="col-6 col-md-3 mb-3">
                <h5 class="footer-title">Media Sosial</h5>
                <div class="d-flex mt-4">
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

        <!-- Bottom Row: Hak Cipta -->
        <div class="row mt-3">
            <div class="col text-center">
                <p class="mt-2">&copy; Developed by Group 2<a href="#"></a></p>
            </div>
        </div>
    </div>
</footer>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
