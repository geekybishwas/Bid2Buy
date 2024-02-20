<?php
//connection to DB--Database configuration
$host = 'localhost'; // usually 'localhost'
$username = 'sudip';
$password = 'Paudelzone22@#!';
$database = 'bid2buy';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
        $sql = "SELECT * FROM product";
        $products = $conn->query($sql);
        $sql = "SELECT * FROM auction";
        $auctions=$conn->query($sql);
        $sql = "SELECT * FROM bid";
        $bids=$conn->query($sql);
?>


<?php
// makingg product box using function
function generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath) {
    $html = '<a href="./html/signin_first.html">
                <div class="product_box">
                  <div class="product_img-box">
                    <img src="' . $imagePath . '" alt="" />
                    <span>' . $highlightText . '</span>
                  </div>
                  <div class="product_detail-box">
                    <div>Current Bid : <span class="current_bid_price">$' . number_format($currentBidPrice, 2) . '</span></div>
                    <span class="no_of_bids">' . $noOfBids . ' Bids </span>
                    <span>' . $timeLeft . '</span>
                    <p>' . $productName . '</p>
                  </div>
                </div>
              </a>';

    return $html;
}
?>
<?php
function findTimeLeft($deadlineTimestamp) {
  // Calculate the time left for bidding
  $currentTime = time();
  $timeLeftSeconds = max(0, $deadlineTimestamp - $currentTime);

  // Convert time left to hours, minutes, and seconds
  $hours = floor($timeLeftSeconds / 3600);
  $minutes = floor(($timeLeftSeconds % 3600) / 60);
  $seconds = $timeLeftSeconds % 60;

  // Return appropriate value based on time left
  if ($timeLeftSeconds <= 0) {
      return 'Times up';
  } elseif ($hours >= 24) {
      // More than 24 hours left
      $days = floor($hours / 24);
      return $days . ' days';
  } elseif ($hours > 0) {
      // Between 1 and 24 hours left
      return $hours . ' hours';
  } elseif ($minutes > 0) {
      // Less than 1 hour, but some minutes left
      return $minutes . ' minutes';
  } else {
      // Less than 1 minute left
      return 'Less than 1 minute';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bid2Buy: Online Auction Place</title>
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/homepage.css" />
    <link rel="stylesheet" href="./css/footer_only.css" />
    <link rel="stylesheet" href="./css/header_only.css" />
    <link rel="stylesheet" href="./css/scrollable.css" />
    <!-- font aesome icon  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <!-- google icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="./js/scroll_to_top.js"></script>
    <script src="./js/slide_banner_images.js"></script>
  </head>
  <body>
    <header>
      <nav class="first_nav">
        <div class="left_part">
          <a href="./index.html">
            <div class="logo">
              <!-- <img src="./assets/logo_main.png" alt="B2B" /> -->
              <h1>Bid2Buy</h1>
            </div>
          </a>
          <ul class="nav_btns">
            <li>
              <a class="text_as_btn" href="./html/signin_first.html"
                >Categories</a>
            </li>
            <li>
              <a class="text_as_btn" href="./html/signin_first.html"
                >Secondhand Picks</a>
            </li>
            <li>
              <a class="text_as_btn" href="./html/signin_first.html"
                >Sell Product</a>
            </li>
            <li>
              <a class="text_as_btn" href="./html/signin_first.html"
                >Watchlist</a>
            </li>
            <li>
              <a class="text_as_btn" href="./html/help_n_contact.html"
                >Help & Contact</a>
            </li>
            </li>
          </ul>
        </div>
        <div class="authentication">

      <div><a class="authentication_btn registerButton" href="./html/register.html">Register</a></div>

      <div><a class="authentication_btn signInButton" href="./html/signin.html">SignIn</a></div>
      </div>
      </nav>
    </header>
    <!-- //for making custom scroll bar -->
    <div class="scrollable">
      <main>
        <!--product highlight slide show-->
        <section class="slideshow_container">
          <div class="slide">
            <a href="./html/signin_first.html"><img src="./assets/Banner-1.jpg" alt="Highlight 1" /></a>
          </div>
          <div class="slide">
            <a href="./html/signin_first.html"><img src="./assets/Banner-2.gif" alt="Highlight 2" /></a>
          </div>
          <div class="slide">
            <a href="./html/signin_first.html"><img src="./assets/Banner-3.png" alt="Highlight 3" /></a>
          </div>
          <div class="slide">
            <a href="./html/signin_first.html"><img src="./assets/Banner-4.png" alt="Highlight 4" /></a>
          </div>
          <a class="prev">&#10094;</a>
          <a class="next">&#10095;</a>
          <div style="text-align: center">
            <span id="dot-1" class="dot"></span>
            <span id="dot-2" class="dot"></span>
            <span id="dot-3" class="dot"></span>
            <span id="dot-4" class="dot"></span>
          </div>
        </section>
        <!-- reccomended products section -->
        <section class="products_section">
          <div class="heading_container">
             <h2>Just For You</h2>
             <p>Reccomends Products for you</p>
          </div>
          <div class="container">
            <div class="product_container"> 
            <?php
        
        if ($products->num_rows > 0) {
        // Output data of each row
        while ($row = $products->fetch_assoc()) {
            $productName = $row['name'];
            $highlightText = $row['highlight'];
            $imagePath = './assets/p1.png';
            $timeLeft=findTimeLeft(strtotime($row['closing_datetime']));
            while($auct=$auctions->fetch_assoc()){
              if($auct['product_id']===$row['product_id']){
                $noOfBids=$auct['total_bids'];
                while($bid=$bids->fetch_assoc()){
                  if($bid['auction_id']===$auct['auction_id']){
                    $currentBidPrice = $bid['bid_price'];
                  }
                }
              }
            }

            // Corrected: Pass the variables as parameters
            echo generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath);
        }
    } else {
        echo "0 results";
    }
?>


            </div>
            <a href="./html/signin_first.html"><button class="view_all">View All</button></a>
          </div>
        </section>
        <!-- high bids product -->
        <section class="products_section">
          <div class="heading_container">
            <h2>High Bids Products</h2>
            <p>Products with high Bids on Auction</p>
          </div>
          <div class="container">
            <div class="product_container"> 
<?php
        
        if ($products->num_rows > 0) {
        // Output data of each row
        while ($row = $products->fetch_assoc()) {
            $productName = $row['name'];
            $highlightText = $row['highlight'];
            $currentBidPrice = $row['base_price'];
            $noOfBids = $row['base_price'];
            $timeLeft = $row['closing_datetime'];
            $imagePath = './assets/p1.png';

            // Corrected: Pass the variables as parameters
            echo generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath);
        }
    } else {
        echo "0 results";
    }
?>

             <!-- items to be extracted accessing db -->

            </div>
            <a href="./html/signin_first.html"><button class="view_all">View All</button></a>
          </div>
        </section>
        <!-- high price product -->
        <section class="products_section">
          <div class="heading_container">
            <h2>High Price Products</h2>
            <p>Products with high price on Auction</p>
          </div>
          <div class="container">
            <div class="product_container"> 
            <?php
        
        if ($products->num_rows > 0) {
        // Output data of each row
        while ($row = $products->fetch_assoc()) {
            $productName = $row['name'];
            $highlightText = $row['highlight'];
            $currentBidPrice = $row['base_price'];
            $noOfBids = $row['base_price'];
            $timeLeft = $row['closing_datetime'];
            $imagePath = './assets/p1.png';

            // Corrected: Pass the variables as parameters
            echo generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath);
        }
    } else {
        echo "0 results";
    }
?>


            </div>
            <a href="./html/signin_first.html"><button class="view_all">View All</button></a>
          </div>
        </section>
        <!-- popular categories -->
        <section class="products_section">
          <div class="heading_container">
            <h2>Explore Popular Categories</h2>
          </div>
          <div class="container">
            <div class="product_container"> 
                <?php
                echo generateProductHTML( 'Product 1', 'Highlight text 1', 150.00, 5, '20hrs left', './assets/p1.png');
                echo generateProductHTML( 'Product 2', 'Highlight text 2', 200.00, 8, '15hrs left', './assets/p2.png');
                echo generateProductHTML( 'Product 3', 'Highlight text 3', 300.00, 4, '11hrs left', './assets/p3.png');
                ?>
             <!-- items to be extracted accessing db -->

            </div>
            <a href="./html/signin_first.html"><button class="view_all">View All</button></a>
          </div>
        </section>
  
        <!--clossing soon  products auction section -->
        <section class="products_section">
          <div class="heading_container">
            <h2>Limited Time products</h2>
            <p>Auction Ending Soon</p>
          </div>
          <div class="container">
            <div class="product_container"> 
            <?php
        
        if ($products->num_rows > 0) {
        // Output data of each row
        while ($row = $products->fetch_assoc()) {
            $productName = $row['name'];
            $highlightText = $row['highlight'];
            $currentBidPrice = $row['base_price'];
            $noOfBids = $row['base_price'];
            $timeLeft = $row['closing_datetime'];
            $imagePath = './assets/p1.png';

            // Corrected: Pass the variables as parameters
            echo generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath);
        }
    } else {
        echo "0 results";
    }
?>


            </div>
            <a href="./html/signin_first.html"
            ><button class="view_all">View All</button></a>
          </div>
        </section>
        <!--Second Hand Products section -->
        <section class="products_section">
          <div class="heading_container">
            <h2>Second Hand Zone</h2>
            <p>Used Products on Auction</p>
          </div>
          <div class="container">
            <div class="product_container"> 
            <?php
        
        if ($products->num_rows > 0) {
        // Output data of each row
        while ($row = $products->fetch_assoc()) {
            $productName = $row['name'];
            $highlightText = $row['highlight'];
            $currentBidPrice = $row['base_price'];
            $noOfBids = $row['base_price'];
            $timeLeft = $row['closing_datetime'];
            $imagePath = './assets/p1.png';

            // Corrected: Pass the variables as parameters
            if($row['product_condition']==='Used'){
            echo generateProductHTML($productName, $highlightText, $currentBidPrice, $noOfBids, $timeLeft, $imagePath);
            }
        }
    } else {
        echo "0 results";
    }
?>


            </div>
            <a href="./html/signin_first.html"
            ><button class="view_all">View All</button></a>
          </div>
        </section>
      </main>
      <footer>
        <div class="auction_logo">
          <!-- <img
            class="Bid2Buy-Logo"
            src="./assets/logo_main.png"
            alt="Auction Logo"
          /> -->
          <!-- <div class="logo"> -->
            <!-- <img src="./assets/logo_main.png" alt="B2B" /> -->
            <h1>Bid2Buy Corp.</h1>
          <!-- </div> -->
        </div>
        <p class="footer_text black_text">
          Explore the world of possibilities with us! Reach out, connect, and engage by following us on our vibrant social networks. Your thoughts matter, and we're eager to hear from you. Whether you have questions, feedback, or just want to say hello, our team is here and ready to make your experience extraordinary. Don't miss out—join our community and let's create something amazing together!
        </p>
        <div class="social-icons">
          <a href="#" class="icon"><i class="fa fa-facebook"></i></a>
          <a href="#" class="icon"><i class="fa fa-twitter"></i></a>
          <a href="#" class="icon"><i class="fa fa-instagram"></i></a>
          <a href="mailto:you@example.com" class="icon"
            ><i class="fa fa-envelope"></i
          ></a>
          <a href="#" class="icon"><i class="fa fa-snapchat"></i></a>
        </div>
        <div class="bid-container">
  
          <h2>About Us</h2>
          <p><span class="highlight">Bid2Buy</span> is a dynamic multi-vendor auction site catering to both buyers and sellers. As a buyer, you have the exciting opportunity to engage in the auction process, placing bids and securing items upon winning. On the flip side, sellers can easily register their products for auction, making Bid2Buy the ideal platform for both buyers and sellers to connect and transact. It's not just a marketplace; it's a vibrant auction space where every bid and product tells a unique story. Join Bid2Buy and experience the best of online auctions!</p>
  
          <h3>Why Choose Bid2Buy?</h3>
          <div class="feature-list">
              <ul>
                  <li><span class="highlight">Diverse Selection:</span> Explore a curated range of products, from rare collectibles to expensive collections.</li>
                  <li><span class="highlight">Real-Time Bidding:</span> Stay in the loop with our user-friendly real-time bidding system.</li>
                  <li><span class="highlight">Second-hand Marketplace:</span> Bid confidently on our second-hand marketplace.</li>
                  <li><span class="highlight">Interactive Auctions:</span> Participate in lively auctions that make the bidding process an experience to remember.</li>
              </ul>
          </div>
  
          <h3>How It Works:</h3>
          <ol class="feature-list">
              <li><span class="highlight">Browse:</span> Discover a curated selection of items up for bid.</li>
              <li><span class="highlight">Bid:</span> Place your bids confidently with our user-friendly bidding system.</li>
              <li><span class="highlight">Win:</span> The highest bidder at the end of the auction secures the item. Congratulations, it's yours!</li>
          </ol>
  
          <div class="call-to-action">
              <a href="../html/help_n_contact.html" class="btn">Contact Us</a>
          </div>
      </div>
        <div class="copyright_text">
          Copyright <span class="copyright_c">©</span> 2023-2024 Bid2Buy Corp. All Rights Reserved.
        </div>
        <span class="move_up_icon"><i class="fa fa-angle-up"></i></span>
      </footer>
    </div>
  </body>
</html>
<?php

// Close the database connection
$conn->close();
?>