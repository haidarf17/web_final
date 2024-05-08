<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("location: login.php");
  exit();
}


?>
<?php
include 'dbconnect.php';

$genreFilter = isset($_GET['genre']) ? $_GET['genre'] : '';
$sql = "SELECT id, movie, description, image_path, old_price, price, genre FROM tbl_movies";
if (!empty($genreFilter)) {
  $sql .= " WHERE genre LIKE '%" . $conn->real_escape_string($genreFilter) . "%'";
}
$result = $conn->query($sql);

$movies = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
  }
} else {
  echo "0 results";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Lugx Gaming - Shop Page</title>

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
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3>Our Shop</h3>
          <span class="breadcrumb"><a href="#">Home</a> > Our Shop</span>
        </div>
      </div>
    </div>
  </div>

  <div class="section trending">
    <div class="container">
      <div class="search-bar">
        <form action="shop.php" method="GET">
          <input type="text" name="genre" placeholder="Search by genre..." value="<?= isset($_GET['genre']) ? htmlspecialchars($_GET['genre']) : '' ?>" required>
          <button type="submit">Search</button>
        </form>
      </div>
      <div class="row trending-box">
        <?php foreach ($movies as $movie) : ?>
          <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items">
            <div class="item">
              <div class="thumb">
                <a href="product-details.php?id=<?= $movie['id']; ?>">
                  <img src="<?= $movie['image_path']; ?>" alt="">
                </a>
                <span class="price"><em>$
                    <?= $movie['old_price']; ?>
                  </em>$
                  <?= $movie['price']; ?>
                </span>
              </div>
              <div class="down-content">
                <h4>
                  <?= $movie['movie']; ?>
                </h4>
                <a href="product-details.php?id=<?= $movie['id']; ?>"><i class="fa fa-shopping-bag"></i></a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  </div>
  </div>

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2048 GT Movies Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
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