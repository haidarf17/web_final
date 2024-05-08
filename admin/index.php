<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("location: login.php");
  exit();
}


?>
<?php
include 'dbconnect.php';
$sql = "SELECT id, movie, description, image_path, old_price, price FROM tbl_movies WHERE is_active = 1 LIMIT 4";
$result = $conn->query($sql);

$movies = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
  }
} else {
  echo "No active movies found.";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Lugx Gaming Shop HTML5 Template</title>

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

  <!-- ** Preloader Start ** -->
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
  <!-- ** Preloader End ** -->

  <!-- ** Header Area Start ** -->
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
            <!-- ** Logo Start ** -->
            <a href="index.php" class="logo">
              <img src="assets/images/logo.png" alt="" style="width: 158px;">
            </a>
            <!-- ** Logo End ** -->
            <!-- ** Menu Start ** -->
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
            <!-- ** Menu End ** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ** Header Area End ** -->

  <div class="main-banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="caption header-text">
            <h6>Welcome to GT Movies</h6>
            <h2>BEST MOVIE SITE EVER!</h2>
            <p>Welcome to GT Movies, your go-to platform for movie rentals and purchases. We offer an
              extensive
              collection of films across genres, bringing the magic of cinema to your home. With
              personalized
              recommendations, easy navigation, and secure transactions, GT Movies ensures a seamless
              entertainment
              experience. Join us today and start your movie adventure!</p>
            <div class="search-input">
              <form id="search" action="#">
                <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                <button role="button">Search Now</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-4 offset-lg-2">
          <div class="right-image">
            <img src="../assets/images/logo.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="section trending">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading">
            <h6>Trending</h6>
            <h2>Trending Movies</h2>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="main-button">
            <a href="shop.php">View All</a>
          </div>
        </div>
        <?php foreach ($movies as $movie) : ?>
          <div class="col-lg-3 col-md-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.php?id=<?= $movie['id']; ?>"><img src="<?= htmlspecialchars($movie['image_path']); ?>" alt=""></a>
                <span class="price"><em>$<?= $movie['old_price']; ?></em>$<?= $movie['price']; ?></span>
              </div>
              <div class="down-content">
                <h4><?= htmlspecialchars($movie['movie']); ?></h4>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>


  <div class="section most-played">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading">
            <h6>TOP MOVIES</h6>
            <h2>BEST SELLER</h2>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="main-button">
            <a href="shop.php">View All</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-01.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Romance/ Sports</span>
              <h4>Challengers</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/top-game-02.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Horror</span>
              <h4>US</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/top-game-03.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Thriller</span>
              <h4>Silence of The Lambs</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/top-game-04.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Horror</span>
              <h4>The First Omen</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-07.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Action</span>
              <h4>The Batman</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="item">
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-02.jpg" alt=""></a>
            </div>
            <div class="down-content">
              <span class="category">Action</span>
              <h4>Dune Part Two</h4>
              <a href="product-details.php">Explore</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section categories">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading">
            <h6>Categories</h6>
            <h2>Top Categories</h2>
          </div>
        </div>
        <div class="col-lg col-sm-6 col-xs-12">
          <div class="item">
            <h4>Horror</h4>
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-09.jpg" alt=""></a>
            </div>
          </div>
        </div>
        <div class="col-lg col-sm-6 col-xs-12">
          <div class="item">
            <h4>Action</h4>
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-02.jpg" alt=""></a>
            </div>
          </div>
        </div>
        <div class="col-lg col-sm-6 col-xs-12">
          <div class="item">
            <h4>Dystopian</h4>
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-06.jpg" alt=""></a>
            </div>
          </div>
        </div>
        <div class="col-lg col-sm-6 col-xs-12">
          <div class="item">
            <h4>Thriller</h4>
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-11.jpg" alt=""></a>
            </div>
          </div>
        </div>
        <div class="col-lg col-sm-6 col-xs-12">
          <div class="item">
            <h4>Super Hero</h4>
            <div class="thumb">
              <a href="product-details.php"><img src="../assets/images/trending-12.jpg" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section cta">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="shop">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <h6>Our Shop</h6>
                  <h2>Go Pre-Order Buy & Get Best <em>Prices</em> For You!</h2>
                </div>
                <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                <div class="main-button">
                  <a href="shop.php">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-2 align-self-end">
          <div class="subscribe">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <h6>NEWSLETTER</h6>
                  <h2>Get Up To $100 Off Just Buy <em>Subscribe</em> Newsletter!</h2>
                </div>
                <div class="search-input">
                  <form id="subscribe" action="#">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your email...">
                    <button type="submit">Subscribe Now</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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