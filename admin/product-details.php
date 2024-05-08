<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("location: login.php");
  exit();
}


?>
<?php
$conn = new mysqli("localhost", "root", "", "gtmovies");
$product_id = $_GET['id'] ?? '1';
$sql = "SELECT movie, description, image_path, old_price, price, is_active FROM tbl_movies WHERE id = " . $product_id;
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Toggle active status
if (isset($_GET['action']) && ($_GET['action'] == 'deactivate' || $_GET['action'] == 'activate')) {
  $newStatus = $_GET['action'] == 'deactivate' ? 0 : 1;
  $updateSql = "UPDATE tbl_movies SET is_active = $newStatus WHERE id = " . $product_id;
  $conn->query($updateSql);
  header("Location: product-details.php?id=$product_id"); // Redirect to avoid resubmission
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Lugx Gaming - Product Detail</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-lugx-gaming.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <!--

TemplateMo 589 lugx gaming

https://templatemo.com/tm-589-lugx-gaming

-->
</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.php" class="logo">
              <img src="../assets/images/logo.png" alt="" style="width: 158px;">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="index.php" class="active">Home</a></li>
              <li><a href="shop.php">Our Shop</a></li>
              <li><a href="product-details.php">Product Details</a></li>
              <li><a href="createpost.php">Add Movie</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li><a href="signup.php">New User</a></li>
              <li><a href="logout.php">Log Out</a></li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="page-heading header-text">
    <p>Welcome <?php echo $_SESSION['user']; ?>!
    <p>
      <style>
        p {
          width: 100%;
          text-align: center;
          font-size: 15px;
          font-weight: bold;
        }
      </style>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3><?= $product['movie']; ?></h3>
          <span class="breadcrumb"><a href="#">Home</a> > <a href="#">Shop</a> > <?= $product['movie']; ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="single-product section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="left-image">
            <img src="<?= $product['image_path']; ?>" alt="">
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <h4><?= $product['movie']; ?></h4>
          <span class="price"><em>$<?= $product['old_price']; ?></em> $<?= $product['price']; ?></span>
          <p><?= $product['description']; ?></p>
          <!-- Your existing form and other content -->
          <button onclick="location.href='product-details.php?id=<?= $product_id ?>&action=<?= $product['is_active'] ? 'deactivate' : 'activate' ?>'">
            <?= $product['is_active'] ? 'Deactivate' : 'Activate' ?>
          </button>

        </div>

      </div>
    </div>
  </div>



  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2048 GTMovies Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/js/isotope.min.js"></script>
  <script src="../assets/js/owl-carousel.js"></script>
  <script src="../assets/js/counter.js"></script>
  <script src="../assets/js/custom.js"></script>

</body>

</html>