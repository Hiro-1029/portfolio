<?php

require_once('classes/crud.php');

$user = new CRUD;

$rowsForNew = $user->getItems('N');
$rowsForExist = $user->getItems('E');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kure Coffee</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    #login {
      display: block;
      position: relative;
      color: white;
      transition: 0.3s;
      font-size: 14px;
      font-family: "Open Sans", sans-serif;
    }
    #login input, #login a {
      border: 2px solid #cda45e;
      color: #fff;
      border-radius: 50px;
      padding: 8px 25px;
      text-transform: uppercase;
      font-size: 13px;
      font-weight: 500;
      letter-spacing: 1px;
      transition: 0.3s;
    }
    #login input:hover, #login a:hover {
      background: #cda45e;
      color: #fff;
    }
  </style>
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-phone"></i> +1 5589 55488 55
        <span class="d-none d-lg-inline-block"><i class="icofont-clock-time icofont-rotate-180"></i> Mon-Sat: 9:00 AM - 17:00 PM</span>
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="index.php">Kure Coffee</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a> -->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Lineup</a></li>
          <li><a href="#contact">Contact</a></li>
          <li class='book-a-table text-center'><a href='login.php'>Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative text-center text-lg-left" data-aos="zoom-in" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8">
          <h1>Welcome to <span>Kure Coffee</span></h1>
          <h2>Delivering great coffee for more than 50 years!</h2>

          <div class="btns">
            <a href="#menu" class="btn-menu animated fadeInUp scrollto">Our Lineup</a>
          </div>
        </div>
        <div class="col-lg-4 d-flex align-items-center justify-content-center" data-aos="zoom-in" data-aos-delay="200">
          <a href="https://www.youtube.com/watch?v=uv4d3qpbd80" class="venobox play-btn" data-vbtype="video" data-autoplay="true"></a>
        </div>

      </div>
    </div>
  </section>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
            <div class="about-img">
              <img src="assets/img/about.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>About Kure Coffee</h3>
            <p class="font-italic">
              advantages
            </p>
            <ul>
              <li><i class="icofont-check-circled"></i> Good taste.</li>
              <li><i class="icofont-check-circled"></i> Fast.</li>
              <li><i class="icofont-check-circled"></i> Good quality.</li>
            </ul>
            <p>
              Let's order.<br>
            </p>

          </div>
        </div>

      </div>
    </section>

    <!-- ======= Lineup Section ======= -->
    <section id="menu" class="menu section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Lineup</h2>
          <p>Check Our Authentic Coffee</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="menu-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-light">Light</li>
              <li data-filter=".filter-medium">Medium</li>
              <li data-filter=".filter-dark">Dark</li>
              <li data-filter=".filter-other">Other</li>
            </ul>
          </div>
        </div>

        <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">

          <!-- show items of new arrival -->
          <?php foreach ($rowsForNew as $row): ?>
            <?= "<div class='col-lg-6 menu-item filter-". $row['roast_level'] ."'>" ?>
              <img src="assets/img/menu/<?= $row['item_picture'] ?>" class="menu-img" alt="">
              <div class="menu-content">
                <a href="#"><?= $row['item_name'] ?></a><span><?= $row['item_price'] ?></span>
              </div>
              <div class="menu-ingredients">
                <?= $row['item_desc'] ?>
              </div>
            </div>
          <?php endforeach ?>

          <!-- show existing items  -->
          <?php foreach ($rowsForExist as $row): ?>
            <?= "<div class='col-lg-6 menu-item filter-". $row['roast_level'] ."'>" ?>
              <img src="assets/img/menu/<?= $row['item_picture'] ?>" class="menu-img" alt="">
              <div class="menu-content">
                <a href="#"><?= $row['item_name'] ?></a><span><?= $row['item_price'] ?></span>
              </div>
              <div class="menu-ingredients">
                <?= $row['item_desc'] ?>
              </div>
            </div>
          <?php endforeach ?>

        </div>
        
        <!-- button to move to Online Shopping -->
        <div id="login"class="text-center nav-menu my-3">
          <a href="onlineShopping.php" class="w-25 mx-auto my-5">Online Shopping</a>
        </div>
      </div>
    </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>
      </div>

      <div data-aos="fade-up">
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
      </div>

      <div class="container" data-aos="fade-up">

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Location:</h4>
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>

              <div class="open-hours">
                <i class="icofont-clock-time icofont-rotate-90"></i>
                <h4>Open Hours:</h4>
                <p>
                  Monday-Saturday:<br>
                  11:00 AM - 2300 PM
                </p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p>info@example.com</p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call:</h4>
                <p>+1 5589 55488 55s</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="8" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section>

  </main>

  
<?php

include('parts/footer.php');
