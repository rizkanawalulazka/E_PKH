<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-PKH | Beranda</title>
  <meta name="description" content="Landing page Program Keluarga Harapan (PKH)">
  <meta name="keywords" content="PKH, bantuan sosial, keluarga harapan">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0A1128 0%, #1B263B 100%);
      color: #0A1128;
    }
    .header {
      background:rgba(10, 17, 40, 0.62);
      color: #fff;
      position: sticky;
      top: 0;
      z-index: 99;
      box-shadow: 0 2px 8px rgba(10,17,40,0.08);
    }
    .header .container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      padding: 14px 24px;
    }
    .logo-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .logo-img {
      height: 38px;
      width: 38px;
      border-radius: 50%;
      object-fit: cover;
      background: #fff;
      border: 2px solid #0A1128;
    }
    .logo-text {
      font-size: 1.7rem;
      font-weight: bold;
      letter-spacing: 2px;
      color: #fff;
      text-decoration: none;
    }
    nav {
      flex: 1;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 24px;
      margin: 0;
      padding: 0;
      align-items: center;
    }
    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }
    nav ul li a:hover, nav ul li a.active {
      color: #0A1128;
    }
    .btn-getstarted {
      background: #0A1128;
      color: #fff;
      border: none;
      border-radius: 24px;
      padding: 8px 28px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none;
      margin-left: 16px;
    }
    .btn-getstarted:hover {
      background: #1B263B;
    }
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 16px;
    }
    /* Hero Section */
    .hero {
      min-height: 85vh;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      background: linear-gradient(rgba(10,17,40,0.7),rgba(27,38,59,0.6)),
      url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
      border-radius: 0 0 32px 32px;
      margin-bottom: 32px;
      width: 100vw;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
      position: relative;
    }
    .hero-content {
      text-align: left;
      color: #fff;
      max-width: 600px;
      padding: 64px 32px 64px 32px;
      z-index: 2;
    }
    .hero-content h1 {
      font-size: 2.7rem;
      font-weight: bold;
      margin-bottom: 18px;
      color: #fff;
      text-shadow: 0 2px 8px rgba(10,17,40,0.2);
    }
    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 28px;
      color: #CFD8DC;
      text-shadow: 0 2px 8px rgba(10,17,40,0.15);
    }
    .hero-content .btn-getstarted {
      font-size: 1.1rem;
      padding: 10px 36px;
    }
    /* Section Title */
    .section-title {
      text-align: center;
      margin: 48px 0 24px 0;
    }
    .section-title h2 {
      color: #fff;
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 2rem;
    }
    .section-title p {
      color: #fff;
      font-size: 1.1rem;
    }
    #manfaat .section-title h2,
    #manfaat .section-title p {
      color: #0A1128;
    }
    /* About */
    .about-row {
      display: flex;
      flex-wrap: wrap;
      gap: 32px;
      align-items: center;
      justify-content: center;
      margin-bottom: 32px;
    }
    .about-img {
      flex: 1 1 320px;
      min-width: 260px;
      text-align: center;
    }
    .about-img img {
      max-width: 320px;
      width: 90%;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(10,17,40,0.12);
    }
    .about-list {
      flex: 1 1 320px;
      min-width: 260px;
      font-size: 1.1rem;
      color: #fff;
    }
    .about-list ul {
      padding-left: 0;
      list-style: none;
    }
    .about-list li {
      margin-bottom: 16px;
      padding-left: 28px;
      position: relative;
    }
    .about-list li:before {
      content: "✔";
      color:rgba(27, 38, 59, 0.69);
      font-weight: bold;
      position: absolute;
      left: 0;
      top: 0;
    }
    /* Services */
    .services {
      background: #F2F4F8;
      border-radius: 18px;
      padding: 32px 0 24px 0;
      margin-bottom: 32px;
    }
    .services-row {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      justify-content: center;
    }
    .service-item {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(10,17,40,0.08);
      padding: 32px 24px;
      text-align: center;
      flex: 1 1 260px;
      max-width: 320px;
      min-width: 220px;
      transition: box-shadow 0.3s;
    }
    .service-item:hover {
      box-shadow: 0 8px 32px rgba(10,17,40,0.15);
    }
    .service-item .icon {
      font-size: 2.5rem;
      color: #0A1128;
      margin-bottom: 16px;
      display: block;
    }
    .service-item h3 {
      color: #0A1128;
      font-size: 1.2rem;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .service-item p {
      color: #4A5568;
      font-size: 1rem;
    }

    /* Contact */
    .contact-row {
      display: flex;
      flex-wrap: wrap;
      gap: 32px;
      justify-content: center;
      margin-bottom: 32px;
    }
    .contact-info {
      flex: 1 1 260px;
      min-width: 220px;
      color: #0A1128;
    }
    .contact-info h4 {
      color: #0A1128;
      margin-bottom: 6px;
      font-size: 1.1rem;
    }
    .contact-info p {
      margin-bottom: 16px;
      color: #fff;
    }
    .contact-map {
      flex: 1 1 320px;
      min-width: 220px;
      text-align: center;
    }
    .contact-map iframe {
      width: 100%;
      max-width: 350px;
      height: 200px;
      border: 0;
      border-radius: 12px;
    }
    /* Footer */
    .footer {
      background: #0A1128;
      color: #fff;
      text-align: center;
      padding: 18px 0 10px 0;
      border-radius: 18px 18px 0 0;
      margin-top: 32px;
      font-size: 1rem;
    }
    @media (max-width: 900px) {
      .hero-content {
        padding: 32px 12px;
      }
      .hero {
        border-radius: 0 0 18px 18px;
      }
      .header .container {
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
      }
      nav ul {
        gap: 12px;
      }
      nav {
        justify-content: flex-start;
      }
    }
    @media (max-width: 600px) {
      .hero-content h1 {
        font-size: 2rem;
      }
      .section-title h2 {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="logo-group">
        <img class="logo-img" src="image\logo dinsos.png" alt="Logo PKH">
        <span class="logo-text">E-PKH</span>
      </div>
      <nav>
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#tentang">Tentang PKH</a></li>
          <li><a href="#manfaat">Manfaat</a></li>
          <li><a href="#kontak">Kontak</a></li>
          <li><a class="btn-getstarted" href="{{ url('login') }}">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section id="hero" class="hero">
      <div class="hero-content">
        <h1>Program Keluarga Harapan (PKH)</h1>
        <p>Memberikan harapan dan dukungan bagi keluarga Indonesia untuk masa depan yang lebih baik.</p>
        <a href="{{ route('pendaftaran.pkh.create') }}" class="btn-getstarted">Daftar PKH</a>
      </div>
    </section>

    <!-- Tentang PKH -->
    <section id="tentang">
      <div class="section-title">
        <h2>Tentang PKH</h2>
        <p>PKH adalah program bantuan sosial bersyarat dari pemerintah Indonesia untuk keluarga kurang mampu, bertujuan meningkatkan taraf hidup melalui akses pendidikan, kesehatan, dan kesejahteraan.</p>
      </div>
      <div class="about-row">
        <div class="about-img">
          <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80" alt="Tentang PKH">
        </div>
        <div class="about-list">
          <ul>
            <li>Bantuan tunai untuk keluarga kurang mampu</li>
            <li>Dukungan pendidikan dan kesehatan anak</li>
            <li>Meningkatkan kesejahteraan keluarga</li>
            <li>Mendorong kemandirian ekonomi keluarga</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Manfaat PKH -->
    <section id="manfaat" class="services">
      <div class="section-title">
        <h2>Manfaat PKH</h2>
        <p>Berikut beberapa manfaat utama dari Program Keluarga Harapan:</p>
      </div>
      <div class="services-row">
        <div class="service-item">
          <span class="icon">💸</span>
          <h3>Bantuan Keuangan</h3>
          <p>Membantu kebutuhan dasar keluarga penerima manfaat agar dapat hidup lebih layak.</p>
        </div>
        <div class="service-item">
          <span class="icon">🎓</span>
          <h3>Dukungan Pendidikan</h3>
          <p>Memastikan anak-anak tetap bersekolah dan mendapatkan pendidikan yang layak.</p>
        </div>
        <div class="service-item">
          <span class="icon">❤️</span>
          <h3>Kesehatan Keluarga</h3>
          <p>Meningkatkan akses layanan kesehatan ibu, anak, dan lansia dalam keluarga.</p>
        </div>
      </div>
    </section>

    <!-- Kontak -->
    <section id="kontak">
      <div class="section-title">
        <h2>Kontak</h2>
        <p>Hubungi kami untuk informasi lebih lanjut tentang PKH.</p>
      </div>
      <div class="contact-row">
        <div class="contact-info">
          <h4>Alamat</h4>
          <p>Jl. Contoh No. 123, Banda Aceh</p>
          <h4>Telepon</h4>
          <p>+62 812 3456 7890</p>
          <h4>Email</h4>
          <p>info@pkh.go.id</p>
        </div>
        <div class="contact-map">
          <iframe src="https://maps.google.com/maps?q=jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed" allowfullscreen></iframe>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <p>© {{ date('Y') }} E-PKH. Seluruh hak cipta dilindungi.</p>
  </footer>
</body>
</html>