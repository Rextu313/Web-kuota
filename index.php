<?php
$products = [
    ["name" => "BIG V2", "price" => "60K", "stock" => true, "image" => "paket1.jpg", "detail" => ""],
    ["name" => "BIG", "price" => "68K", "stock" => true, "image" => "paket2.jpg", "detail" => ""],
    ["name" => "JUMBO", "price" => "85K", "stock" => true, "image" => "paket3.jpg", "detail" => "Paket Data Jumbo hingga 125GB\n*Rincian Kuota*\n- Kuota utama: 40GB\n- Bonus reward: up to 20GB\n- Area 1: 7.5GB\n- Area 2: 4.5GB\n- Area 3: 13GB\n- Area 4: 40GB"],
    ["name" => "SUPER MINI", "price" => "45K", "stock" => true, "image" => "paket4.jpg", "detail" => ""],
    ["name" => "MINI PLUS", "price" => "40K", "stock" => false, "image" => "paket5.jpg", "detail" => ""],
    ["name" => "JUMBO S", "price" => "66K", "stock" => false, "image" => "paket6.jpg", "detail" => ""],
    ["name" => "MEGA BIG", "price" => "90K", "stock" => false, "image" => "paket7.jpg", "detail" => ""],
    ["name" => "MINI", "price" => "55K", "stock" => false, "image" => "paket8.jpg", "detail" => ""],
    ["name" => "SUPER BIG", "price" => "60K", "stock" => false, "image" => "paket9.jpg", "detail" => ""]
];
?><!DOCTYPE html><html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paket Akrab Restu_</title>
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #007BFF, #00BFFF);
    margin: 0;
    padding: 0;
    transition: all 0.3s ease;
  }
  header {
    position: sticky;
    top: 0;
    background-color: rgba(0, 0, 0, 0.4);
    padding: 10px;
    text-align: center;
    color: white;
    font-size: 22px;
    font-weight: bold;
    backdrop-filter: blur(5px);
    z-index: 100;
    transition: top 0.3s ease;
  }
  .container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    padding: 20px;
  }
  .menu-card {
    position: relative;
    background-color: #f0f8ff;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
  }
  .menu-card:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  }
  .menu-card.out-of-stock {
    opacity: 0.5;
    pointer-events: none;
  }
  .menu-card img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 8px;
  }
  .menu-card h3 {
    margin: 5px 0;
  }
  .menu-card .no-stock {
    color: red;
    font-weight: bold;
  }
  .harga-note {
    font-size: 11px;
    color: #555;
    margin-top: 5px;
  }
  .popup-bg {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(5px);
    display: none;
    align-items: flex-end;
    justify-content: center;
    z-index: 999;
  }
  .popup-bg.show {
    display: flex;
  }
  .popup {
    background: #fff;
    color: black;
    text-align: center;
    padding: 20px;
    border-radius: 20px 20px 0 0;
    width: 100%;
    animation: slideUp 0.4s ease forwards;
  }
  @keyframes slideUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
  .popup button, .popup a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
  }
  .popup a:hover, .popup button:hover {
    background-color: #0056b3;
  }
  .popup .link-cek {
    display: block;
    margin-top: 10px;
    color: #ff6600;
    font-weight: bold;
    text-decoration: underline;
  }
  #music-toggle {
    position: fixed;
    top: 15px;
    right: 15px;
    background: rgba(0,0,0,0.3);
    border: none;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1000;
  }
  .selected-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 15px;
    height: 15px;
    background: green;
    border-radius: 50%;
    display: none;
  }
  .menu-card.selected .selected-indicator {
    display: block;
  }
  @media (max-width: 500px) {
    .container {
      grid-template-columns: 1fr;
    }
  }
</style>
<script>
  let isPlaying = true;
  function toggleMusic() {
    const audio = document.getElementById('bg-music');
    const toggleBtn = document.getElementById('music-toggle');
    if (isPlaying) {
      audio.pause();
      toggleBtn.textContent = '🔇';
    } else {
      audio.play();
      toggleBtn.textContent = '🔊';
    }
    isPlaying = !isPlaying;
  }
  let lastScrollTop = 0;
  window.addEventListener("scroll", () => {
    const header = document.querySelector("header");
    let st = window.pageYOffset || document.documentElement.scrollTop;
    header.style.top = (st > lastScrollTop) ? "-60px" : "0";
    lastScrollTop = st <= 0 ? 0 : st;
  });
  function order(productName, detail) {
    if (!detail.trim()) detail = 'Coming soon...';
    const linkArea = '<a class="link-cek" href="https://cekareaxl.vercel.app/" target="_blank">Cek Area Kuota XL</a>';
    document.getElementById('popup-text').innerHTML = `<strong>${productName}</strong><br><br>${detail.replace(/\n/g, '<br>')}<br>${linkArea}`;
    document.querySelector('.popup-bg').classList.add('show');
    document.getElementById('wa-link').onclick = function() {
      const msg = `Hai kak, aku mau pesan paket: ${productName}\nNo. HP yang mau diisi:\nCatatan tambahan (kalau ada):`;
      this.href = `https://wa.me/6282271177078?text=${encodeURIComponent(msg)}`;
    }
  }
  window.onclick = (e) => {
    if (e.target.classList.contains('popup-bg')) {
      document.querySelector('.popup-bg').classList.remove('show');
    }
  }
</script>
</head>
<body>
<header>Paket Akrab Restu_</header>
<button id="music-toggle" onclick="toggleMusic()">🔊</button>
<audio id="bg-music" autoplay loop>
  <source src="music.mp3" type="audio/mpeg">
</audio>
<div class="container">
  <?php foreach ($products as $product): ?>
    <div class="menu-card <?= !$product['stock'] ? 'out-of-stock' : '' ?>" onclick="order('<?= $product['name'] ?>', `<?= $product['detail'] ?>`)">
      <span class="selected-indicator"></span>
      <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
      <h3><?= $product['name'] ?></h3>
      <p><?= $product['price'] ?></p>
      <p class="harga-note">*Harga bisa berubah kapan saja</p>
      <?php if (!$product['stock']): ?>
        <span class="no-stock">Stok Habis</span>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<div class="popup-bg">
  <div class="popup">
    <div id="popup-text">Detail Produk</div>
    <a id="wa-link" target="_blank">Pesan Sekarang</a>
  </div>
</div>
</body>
</html>