<?php
// Include database connection script
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $movie = $_POST['movie'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $oldPrice = $_POST['old_price'];
    $newPrice = $_POST['price'];
    $isActive = 1;  // Set is_active to 1 by default
    $imagePath = "";
    // Check if file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

        // Verify MIME type of the file
        if (in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
            if (file_exists("../assets/images/" . $filename)) {
                echo $filename . " already exists.";
            } else {
                move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/images/" . $filename);
                echo "Your file was uploaded successfully.";
                $imagePath = "../assets/images/" . $filename;
            }
        } else {
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO tbl_movies (movie, description, is_active, image_path, posted_on, old_price, price, genre) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)");
    $stmt->bind_param("ssisdds", $movie, $description, $isActive, $imagePath, $oldPrice, $newPrice, $genre);
    $stmt->execute();
}

// Fetch posts from the database
$stmt = $conn->prepare("SELECT * FROM tbl_movies ORDER BY posted_on DESC");
$stmt->execute();
$result = $stmt->get_result();


session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}



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
                            <img src="../assets/images/logo.png" alt="" style="width: 158px;">
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
                </div>

                <!-- Add more posts here -->
            </div>
            <script src="script.js"></script>


            <!-- Popup Container -->
            <button id="addPostButton">Add Movie</button>

            <div id="addPostPopup">
                <div>
                    <h2>New Post</h2>
                    <form id="newPostForm" method="post" action="" enctype="multipart/form-data">
                        <input type="text" name="movie" placeholder="Title" required><br>
                        <textarea name="description" placeholder="Content" required></textarea><br>
                        <input type="file" name="image" required><br>
                        <input type="text" name="genre" placeholder="Genre" required><br>
                        <input type="number" name="old_price" placeholder="Old Price" required><br>
                        <input type="number" name="price" placeholder="New Price" required><br>
                        <input type="submit" value="Submit">
                    </form>
                    <button id="closePopupButton">Close</button>
                </div>
            </div>
            <style>
                #addPostPopup {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgba(0, 0, 0, 0.4);
                    /* Overlay */
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                #addPostPopup>div {
                    background-color: #fefefe;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 40%;
                    /* Smaller width */
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    border-radius: 10px;
                }

                #newPostForm {
                    display: flex;
                    flex-direction: column;
                    font-size: 14px;
                    /* Smaller font size */
                }

                #newPostForm input[type="text"],
                #newPostForm input[type="number"],
                #newPostForm textarea,
                #newPostForm input[type="file"] {
                    padding: 8px;
                    /* Smaller padding */
                    margin-bottom: 8px;
                    /* Smaller margin */
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }

                #newPostForm input[type="submit"],
                #closePopupButton {
                    background-color: #4CAF50;
                    /* Green for submit, red for close can be set below */
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    /* Smaller padding */
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 14px;
                    margin: 4px auto;
                    cursor: pointer;
                    border-radius: 5px;
                    width: 100%;

                }

                #closePopupButton {
                    background-color: #f44336;
                    /* Red color for the close button */
                    margin-top: 10px;
                }

                #newPostForm h2 {
                    text-align: center;
                    color: #333;
                }
            </style>




</body>

<script>
    document.getElementById('addPostButton').addEventListener('click', function() {
        document.getElementById('addPostPopup').style.display = 'block';
    });

    document.getElementById('closePopupButton').addEventListener('click', function() {
        document.getElementById('addPostPopup').style.display = 'none';
    });

    // Close the popup when clicking outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById('addPostPopup')) {
            document.getElementById('addPostPopup').style.display = 'none';
        }
    }



    document.getElementById('logout_button').addEventListener('click', function() {
        window.location.href = 'logout.php';
    });
</script>
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