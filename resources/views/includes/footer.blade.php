<style>
    .site-footer-v2 {
        background-color: #ffffff;
        color: #333;
        font-family: sans-serif;
        padding-top: 40px;
        border-top: 1px solid #e0e0e0;
    }

    .footer-container {
        max-width: 1140px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        gap: 40px;
        padding: 0 20px;
    }

    .footer-column {
        flex: 1;
    }

    .footer-column h3 {
        font-size: 1.2rem;
        margin-top: 0;
        margin-bottom: 20px;
        color: #111;
    }

    .map-container iframe {
        border: 0;
        border-radius: 8px;
        width: 100%;
        height: 250px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .contact-item i {
        font-size: 1.1rem;
        color: #007bff;
        margin-right: 15px;
        width: 20px;
        text-align: center;
    }

    .social-media-links {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .social-media-links a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        transition: color 0.3s;
    }
    .social-media-links a:hover {
        color: #007bff;
    }
    .social-media-links i {
        font-size: 1.2rem;
        margin-right: 10px;
    }
    .fa-facebook { color: #1877F2; }
    .fa-twitter-square { color: #1DA1F2; }
    .fa-instagram-square { color: #E4405F; }
    .fa-youtube { color: #FF0000; }

    .copyright-container {
        background-color: #343a40;
        padding: 15px 20px;
        margin-top: 30px;
    }

    .copyright-text {
        text-align: center;
        font-size: 0.9rem;
        color: #adb5bd;
        margin: 0;
    }

    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
        }
    }
</style>

<footer class="site-footer-v2">
    <div class="footer-container">
        <div class="footer-column">
            <h3>Temukan Kami</h3>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3498.9838897489108!2d115.38004527431862!3d-2.164074697816695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfab38183791207%3A0x5fccbd0ea8387377!2sDISKOMINFO%20TABALONG!5e1!3m2!1sid!2sid!4v1759288909786!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="footer-column">
            <h3>Kontak Kami</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>R9PM+92H, Jl. Cempaka, Tanjung, Kec. Tj., Kabupaten Tabalong, Kalimantan Selatan 71513</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>(0526) 2023169</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>diskominfo@tabalongkab.go.id</span>
                </div>
            </div>

            <h3 style="margin-top: 30px;">SOSIAL MEDIA</h3>
            <div class="social-media-links">
                <a href="https://facebook.com/mctabalong" target="_blank"><i class="fab fa-facebook"></i> FB Media Center</a>
                <a href="https://x.com/mc_tabalong" target="_blank"><i class="fab fa-twitter-square"></i> X Media Center</a>
                <a href="https://www.instagram.com/mc_tabalong?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><i class="fab fa-instagram-square"></i> IG Media Center</a>
                <a href="https://youtube.com/@diskominfo_tabalong?si=BM9C5dmNUxi8FZyu" target="_blank"><i class="fab fa-youtube"></i> YT Diskominfo Tabalong</a>
            </div>
        </div>
    </div>

    <div class="copyright-container">
        <p class="copyright-text">© 2025 DISKOMINFO TABALONG</p>
    </div>
</footer>
