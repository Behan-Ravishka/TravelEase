<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TravelEase</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="likebtn.css">
  <!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>


  <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
</head>
<body class="bg-gray-900 text-white">

  <div id="progress-bar"></div>

  <?php
// Start session
session_start();

// Check if the user is logged in (adjust this condition based on your login logic)
$isLoggedIn = isset($_SESSION['user_id']); // assuming 'user_id' is set when logged in
?>

<header class="navbar-bg py-4 shadow-lg fixed w-full z-50" class="w-full flex justify-end p-5">
    <div class="container mx-auto flex justify-between items-center px-6">

        <div class="flex items-center">
            <a href="#home" class="hover:opacity-80 transition-opacity"><img src="Images/favicon-32x32.png" width="50px" height="50px" alt="Logo"></a>
            <div class="text-2xl font-bold text-white ml-2">
                <a href="#home" class="hover:opacity-80 transition-opacity">TravelEase</a>
            </div>
        </div>

        <nav>
            <ul class="flex items-center space-x-6">
                <li><a href="#home" class="hover:text-gray-400 transition-colors">Home</a></li>
                <li><a href="#search" class="hover:text-gray-400 transition-colors">Search</a></li>
                <li><a href="#destinations" class="hover:text-gray-400 transition-colors">Destinations</a></li>
                <li><a href="#deals" class="hover:text-gray-400 transition-colors">Deals</a></li>
                <li><a href="#contact" class="hover:text-gray-400 transition-colors">Contact</a></li>
            </ul>
        </nav>

        <main >
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="bg-green-500 text-white p-4 rounded shadow-md">
                You have logged out successfully!
            </div>
        <?php endif; ?>
        <!-- Other content of your index.php -->
        </main>

        <div class="space-x-4">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // Show "My Account" and "Logout" buttons
                echo '<a href="account.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">My Account</a>';
                echo '<a href="logout.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Logout</a>';
            } else {
                // Show "Login" and "Signup" buttons
                echo '<a href="login.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Login</a>';
                echo '<a href="signup.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Sign Up</a>';
            }
            ?>
            
            </div>  
        </div>
    </div>
</header>
<!-- scroll to top button -->
<button id="topButton" 
    class="fixed bottom-20 right-10 z-50 hidden rounded-full w-16 h-16 justify-center items-center 
    shadow-md backdrop-blur-lg bg-white bg-opacity-10 border border-white/30 hover:bg-opacity-20 
    animate-bounce transition ease-in-out duration-300" 
    onclick="scrollToTop()">
    <i class="fas fa-arrow-up text-3xl text-white"></i>
</button>
  
  <!-- Hero Section -->
<section id="home" class="hero-bg h-screen flex items-center justify-center text-center px-4 sm:px-6 lg:px-8">

<div class="overlay"></div>

<div class="hero-text max-w-3xl mx-auto px-4 transition-transform duration-700 ease-in-out transform hover:scale-105">
  <!-- Main Heading -->
  <h1 class="text-5xl md:text-6xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500">
    Explore the World with Ease
  </h1>
  
  <!-- Subheading -->
  <p class="mt-6 text-xl md:text-2xl text-gray-300 opacity-90 transition-opacity duration-700 ease-in-out hover:opacity-100">
    Find the best deals for flights, hotels, and travel adventures.
  </p>
  
  <!-- Call-to-Action Buttons -->
  <div class="mt-10 flex justify-center space-x-4">
    <a href="#search" class="hover-btn px-6 py-3 rounded-full text-lg font-semibold bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center space-x-2 transition-all duration-300 ease-in-out transform hover:scale-105">
      <span>Book Now</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    </a>
    <a href="#destinations" class="hover-btn px-6 py-3 rounded-full text-lg font-semibold bg-gradient-to-r from-pink-500 to-purple-500 flex items-center space-x-2 transition-all duration-300 ease-in-out transform hover:scale-105">
      <span>Explore Destinations</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
      </svg>
    </a>
  </div>
</div>
</section>

<!--widget-->
<div class="filter-widget">
  <button class="filter-button" onclick="redirectToFilter()">
    <i class="fas fa-filter"></i>
    <span>Filter</span>
  </button>
  <div class="filter-options" style="display: none;">
    </div>
</div>

<!-- Search Bar Section -->
<section id="search" class="pt-24 h-screen flex items-center justify-center">
  <div class="search-bar-overlay"></div>
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12 text-white">Find Your Favourite Place</h2>
    <div class="search-bar max-w-4xl mx-auto">
      <form method="POST" action="search results.php" id="searchForm" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-2">
        <!-- Destination Input -->
        <input type="text" name="destination" id="destination" class="search-input w-full" placeholder="Destination" aria-label="Destination" required>
        
        <!-- Check-in Date Input -->
        <input type="date" name="check_in" id="checkIn" class="search-input w-full" aria-label="Check-in Date" required>
        
        <!-- Check-out Date Input -->
        <input type="date" name="check_out" id="checkOut" class="search-input w-full" aria-label="Check-out Date" required>
        
        <!-- Guests Input -->
        <input type="number" name="guests" id="guests" class="search-input w-full" placeholder="Guests" aria-label="Number of Guests" min="1" required>
        
        <!-- Search Button -->
        <button type="submit" class="search-btn w-full md:w-auto flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-2m-2-10l5 5m0 0l-5 5m5-5H10" />
          </svg>
          Search
        </button>
      </form>
    </div>
  </div>
</section>

<section class="bg-white bg-opacity-30 backdrop-blur-md rounded-lg shadow-lg p-6 my-8 max-w-7xl mx-auto">
<div class="container mx-auto px-6">
    <h2 class="text-2xl font-bold text-white mb-4">Recommended for You</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-6">
        <!-- Destination Card -->
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Ikaria, Greece.jpg" alt="Destination 1" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Ikaria, Greece</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee £3, evening meal £15, beer £4</p><br><br>
            <a href="https://www.google.com/search?q=Ikaria%2C+Greece&oq=Ikaria%2C+Greece&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIHCAEQLhiABDIHCAIQABiABDIHCAMQABiABDIHCAQQABiABDIHCAUQABiABDIHCAYQABiABDIHCAcQABiABDIHCAgQABiABNIBCDQzNzNqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Penang, Malaysia.jpg" alt="Destination 2" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Penang, Malaysia</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee £2, evening meal £6, beer £3</p><br>
            <a href="https://www.google.com/search?q=Penang%2C+Malaysia&oq=Penang%2C+Malaysia&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIHCAEQABiABDIHCAIQABiABDIHCAMQABiABDIMCAQQABgUGIcCGIAEMgcIBRAAGIAEMgcIBhAAGIAEMgcIBxAAGIAEMgcICBAAGIAEMgcICRAAGIAE0gEIMTc4NmowajGoAgCwAgA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Czech Republic.jpg" alt="Destination 3" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Czech Republic</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee £2, evening meal £10, beer £1.50</p><br><br>
            <a href="https://www.google.com/search?q=czech+republic&oq=Czech+Republic&gs_lcrp=EgZjaHJvbWUqEggAEAAYQxjjAhixAxiABBiKBTISCAAQABhDGOMCGLEDGIAEGIoFMg8IARAuGEMYsQMYgAQYigUyDAgCEAAYQxiABBiKBTIMCAMQLhhDGIAEGIoFMgcIBBAAGIAEMg0IBRAuGK8BGMcBGIAEMgYIBhBFGD0yBggHEEUYPdIBBzk1MWowajmoAgCwAgA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Tokyo, Japan card.jpg" alt="Destination 4" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Tokyo, Japan</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee £1.80, evening meal £5.50, beer £3</p><br><br>
            <a href="https://www.google.com/search?q=Tokyo%2C+Japan&oq=Tokyo%2C+Japan&gs_lcrp=EgZjaHJvbWUqBggAEEUYOzIGCAAQRRg7MgwIARAAGBQYhwIYgAQyBwgCEAAYgAQyBwgDEAAYgAQyBggEEEUYQDIHCAUQABiABDIHCAYQABiABDIHCAcQABiABNIBBzU1OGowajmoAgCwAgA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Jerez de la Frontera, Spain.jpg" alt="Destination 5" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Jerez de la Frontera, Spain</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee 90p, evening meal £12, beer £1.70</p><br>
            <a href="https://www.google.com/search?q=Jerez+de+la+Frontera%2C+Spain&oq=Jerez+de+la+Frontera%2C+Spain&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIHCAEQLhiABDIHCAIQABiABDIHCAMQABiABDIHCAQQABiABDIICAUQABgWGB4yCggGEAAYDxgWGB4yCAgHEAAYFhgeMggICBAAGBYYHtIBBzcwM2owajmoAgCwAgA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
        <div class="card p-4 rounded-xl shadow-md transition hover:scale-105 transform">
            <img src="Images/Turkey.jpg" alt="Destination 6" class="rounded-lg mb-3 w-full h-48 object-cover">
            <h3 class="text-lg font-semibold text-white">Turkey</h3>
            <p class="text-white font-semibold text-sm">Average prices:</P> <p class="text-white text-sm">Coffee £2, evening meal £6.50, beer £2.50</p><br></br>
            <a href="https://www.google.com/search?q=turkey&oq=Turkey&gs_lcrp=EgZjaHJvbWUqFQgAEAAYQxiDARjjAhixAxiABBiKBTIVCAAQABhDGIMBGOMCGLEDGIAEGIoFMhIIARAuGEMYgwEYsQMYgAQYigUyDAgCEC4YQxiABBiKBTIMCAMQLhhDGIAEGIoFMg0IBBAAGIMBGLEDGIAEMgcIBRAAGIAEMgoIBhAAGLEDGIAEMgcIBxAAGIAEMgcICBAAGIAEMgcICRAAGIAE0gEIMTA3MWowajGoAgCwAgA&sourceid=chrome&ie=UTF-8" class="explore-btn" target="_blank">Explore Now</a>
        </div>
    </div>
</section>
 
  <!-- Popular Destinations Section -->
  <section id="destinations" class="py-20">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-center mb-12 text-white">Discover Popular Destinations</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Card 1 -->
        <div class="card">
          <img src="Images/Paris,France.jpg" alt="Paris" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">Paris, France</h3>
            <p class="card-description">Explore the city of love, famous for its art, culture, and Eiffel Tower.</p>
            <a href="https://en.wikipedia.org/wiki/Paris" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>
        
        <!-- Card 2 -->
        <div class="card">
          <img src="Images/Tokyo, Japan.jpg" alt="Tokyo" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">Tokyo, Japan</h3>
            <p class="card-description">Discover the vibrant city with a blend of traditional and modern culture.</p>
            <a href="https://en.wikipedia.org/wiki/Tokyo" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
          <img src="Images/New York, USA.jpg" alt="New York" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">New York, USA</h3>
            <p class="card-description">Experience the energy of the Big Apple with iconic landmarks.</p>
            <a href="https://en.wikipedia.org/wiki/New_York" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="card">
          <img src="Images/Sydney, Australia.jpeg" alt="Sydney" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">Sydney, Australia</h3>
            <p class="card-description">Visit the stunning harbor city known for its opera house and beaches.</p>
            <a href="https://en.wikipedia.org/wiki/Sydney" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="card">
          <img src="Images/Cape Town, South Africa.jpg" alt="Cape Town" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">Cape Town, South Africa</h3>
            <p class="card-description">Discover breathtaking landscapes and rich cultural history.</p>
            <a href="https://en.wikipedia.org/wiki/Cape_Town" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="card">
          <img src="Images/Dubai, UAE.jpg" alt="Dubai" class="card-image">
          <button class="like-btn relative hover:scale-110 transition-transform duration-300 ease-in-out">
          <ion-icon name="heart-outline" class="heart-icon text-3xl"></ion-icon>
          </button>
          <div class="card-content">
            <h3 class="card-title">Dubai, UAE</h3>
            <p class="card-description">Enjoy the luxury and futuristic architecture of this desert metropolis.</p>
            <a href="https://en.wikipedia.org/wiki/Dubai" target="_blank" class="explore-btn">Explore</a>
          </div>
        </div>
        
      </div>
    </div>
  </section>
  <audio id="like-sound" src="sound/likesound.mp3" preload="auto"></audio>
  
  <!-- Why Choose Us Section -->
  <section class="py-20">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-center mb-12 text-white">Why Choose Us</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <!-- Feature 1 -->
        <div class="feature-card">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2 4 4M7 10l2-2 4 4m0 4h8v6a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v16a1 1 0 001 1h8v-6z" />
            </svg>
          </div>
          <h3 class="feature-title">Best Prices</h3>
          <p class="feature-description">We guarantee the best travel prices for your dream destination.</p>
          <a href="#" class="learn-more-btn">Learn More</a>
        </div>

        <!-- Feature 2 -->
        <div class="feature-card">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.88 3.549A6.97 6.97 0 0112 5c-1.64 0-3.16.53-4.36 1.439m12.02 12.02A6.96 6.96 0 0112 19c-1.64 0-3.16-.53-4.36-1.439M1 12h2m19 0h2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12a10 10 0 1020 0 10 10 0 00-20 0z" />
            </svg>
          </div>
          <h3 class="feature-title">Global Destinations</h3>
          <p class="feature-description">Travel to top destinations around the world with ease.</p>
          <a href="#" class="learn-more-btn">Learn More</a>
        </div>

        <!-- Feature 3 -->
        <div class="feature-card">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2zM12 11c0-1.104.896-2 2-2s2 .896 2 2-.896 2-2 2-2-.896-2-2zm6-8h-2.618l-.49-1.837A1.99 1.99 0 0012 0H8a1.99 1.99 0 00-1.892 1.163L5.618 3H3c-1.104 0-2 .896-2 2v17c0 1.104.896 2 2 2h18c1.104 0 2-.896 2-2V5c0-1.104-.896-2-2-2zM12 13c2.209 0 4 1.791 4 4v1H8v-1c0-2.209 1.791-4 4-4z" />
            </svg>
          </div>
          <h3 class="feature-title">24/7 Support</h3>
          <p class="feature-description">Our dedicated team is here to assist you at any time, day or night.</p>
          <a href="#" class="learn-more-btn">Learn More</a>
        </div>

      </div>
    </div>
  </section>
  
  
  <!-- Exclusive Deals Promotional Banner Section -->
  <section id="deals" class="py-20">
    <div class="container mx-auto px-6">
	<h2 class="text-4xl font-bold text-center mb-12 text-white">Check Our Best Deals</h2>
      <div class="exclusive-banner">
        <div class="exclusive-overlay"></div>
        <div class="exclusive-content">
          <h2 class="exclusive-title">Exclusive Travel Deals</h2>
          <p class="exclusive-subtitle">Unlock the best discounts on destinations worldwide. Book now and save big!</p>
          <a href="https://go.travelandleisure.com/" target="_blank" class="explore-deals-btn">Explore Deals</a>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Customer Reviews Carousel Section -->
  <section id="customer-reviews" class="py-20">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-center mb-12">What Our Customers Say</h2>
      <div class="carousel-container">
        <div class="carousel-wrapper" id="carousel-wrapper">
          <div class="testimonial">
            <p>"The trip was fantastic! Everything was organized perfectly and the service was top-notch!"</p>
            <div class="customer-name">— John Doe</div>
          </div>
          <div class="testimonial">
            <p>"I had an amazing experience booking my vacation. Highly recommend this service!"</p>
            <div class="customer-name">— Jane Smith</div>
          </div>
          <div class="testimonial">
            <p>"The best travel experience I've ever had! Thank you for making it so easy."</p>
            <div class="customer-name">— Alice Johnson</div>
          </div>
        </div>
        <button class="nav-button prev-button" onclick="prevSlide()">❮</button>
        <button class="nav-button next-button" onclick="nextSlide()">❯</button>
      </div>
    </div>
  </section>

  <section id="blog-card-section" class="py-20">
    <h1 class="text-4xl font-bold text-center mb-12">Latest News & Articles</h1>
    <div class="blog-card-container">
      <div class="blog-card">
        <img src="Images/7.png" class="blog-card-image">
        <div class="blog-card-content">
            
            <p class="blog-card-text">Ten Solo Travel Tips! See here ten opinions and inspirations for you:</p>
            <a href="https://letmeinspireyou.nl/ten-solo-travel-tips/" target="_blank" class="blog-read-more">Read More</a>
        </div>
    </div>
        <div class="blog-card">
            <img src="Images/5.jpg" class="blog-card-image">
            <div class="blog-card-content">
                
                <p class="blog-card-text">How To Protect Yourself From Online Travel Booking Scams</p>
                <a href="https://www.sc.com/sg/stories/how-to-protect-yourself-from-online-travel-booking-scams/" target="_blank" class="blog-read-more">Read More</a>
            </div>
        </div>
        <div class="blog-card">
            <img src="Images/4.jpg" class="blog-card-image">
            <div class="blog-card-content">
               
                <p class="blog-card-text">UNIQUE TRAVEL Tips (You Haven't Heard a Million Times)</p>
                <a href="https://www.timandfintravel.com/blog/travel-tips" target="_blank" class="blog-read-more">Read More</a>
            </div>
        </div>
        <div class="blog-card">
            <img src="Images/6.jpg" class="blog-card-image">
            <div class="blog-card-content">
                
                <p class="blog-card-text">10 travel tips <br> for safety!!!</p>
                <a href="https://www.vita4you.gr/blog-vita4you/en/item/10-travel-tips-for-safety.html" target="_blank" class="blog-read-more">Read More</a>
            </div>
        </div>
        
    </div>
</section>

  <!-- Gallery Section -->
<section class="photo-gallery">
    <div class="container mx-auto px-6"></div>
    <h1 class="text-2xl font-bold mb-4">PHOTOS FROM TRAVELLERS</h1>
    <p class="subtitle">"Embark on a journey beyond destinations. Discover, explore, and create unforgettable memories around the world."</p>
    
    <div class="gallery">
        <!-- Each photo has a text overlay that will appear on hover -->
        <div class="photo relative group">
            <img src="Images/8.jpg" alt="Photo 1">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Beautiful Destination</h2>
                <p class="text-sm">A place to explore.</p>
            </div>
        </div>
        
        <div class="photo relative group">
            <img src="Images/9.jpg" alt="Photo 2">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Amazing Views</h2>
                <p class="text-sm">Capture the moment.</p>
            </div>
        </div>
        
        <div class="photo relative group">
            <img src="Images/10.jpg" alt="Photo 3">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Adventure Awaits</h2>
                <p class="text-sm">Discover new places.</p>
            </div>
        </div>
        
        <div class="photo relative group">
            <img src="Images/12.jpg" alt="Photo 4">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Magical Sunsets</h2>
                <p class="text-sm">Find your peace.</p>
            </div>
        </div>
        
        <div class="photo relative group">
            <img src="Images/11.jpg" alt="Photo 5">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Exotic Locations</h2>
                <p class="text-sm">Travel far and wide.</p>
            </div>
        </div>
        
        <div class="photo relative group">
            <img src="Images/13.jpg" alt="Photo 6">
            <div class="overlay-text absolute inset-0 bg-black bg-opacity-50 text-white flex flex-col justify-center items-center opacity-0 transition-opacity duration-500 ease-in-out group-hover:opacity-100">
                <h2 class="text-lg font-bold">Serene Beauty</h2>
                <p class="text-sm">Witness the magic.</p>
            </div>
        </div>
    </div>
</section>

<!-- Meet Our Team Section -->
<section id="team" class="py-12 bg-gray-900 text-white">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold mb-8">Meet the <span class="text-blue-500">Team</span></h2>
    
    <div class="flex justify-center space-x-8">
      <!-- Team Member 1 -->
      <div class="max-w-xs glass p-6 rounded-lg shadow-lg">
        <img src="Images/sadeep.jpg" alt="sadeep" class="rounded-full w-24 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2">Sadeep</h3>
        <p class="text-blue-400">Web Designer</p>
        <div class="flex justify-center space-x-4 mt-4">
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
      </div>

      <!-- Team Member 2 -->
      <div class="max-w-xs glass p-6 rounded-lg shadow-lg">
        <img src="Images/behan.jpg" alt="behan" class="rounded-full w-24 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2">Behan</h3>
        <p class="text-blue-400">Web Designer</p>
        <div class="flex justify-center space-x-4 mt-4">
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
      </div>

      <!-- Team Member 3 -->
      <div class="max-w-xs glass p-6 rounded-lg shadow-lg">
        <img src="Images/venuri.jpg" alt="venuri" class="rounded-full w-24 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2">Venuri</h3>
        <p class="text-blue-400">Web Designer</p>
        <div class="flex justify-center space-x-4 mt-4">
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-instagram"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-dribbble"></ion-icon></a>
        </div>
      </div>

      <!-- Team Member 4 -->
      <div class="max-w-xs glass p-6 rounded-lg shadow-lg">
        <img src="Images/sanuvi.jpg" alt="sanuvi" class="rounded-full w-24 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2">Sanuvi</h3>
        <p class="text-blue-400">Web Designer</p>
        <div class="flex justify-center space-x-4 mt-4">
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
      </div>

      <!-- Team Member 5 -->
      <div class="max-w-xs glass p-6 rounded-lg shadow-lg">
        <img src="Images/oshala.jpg" alt="sanuvi" class="rounded-full w-24 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2">Oshala</h3>
        <p class="text-blue-400">Web Designer</p>
        <div class="flex justify-center space-x-4 mt-4">
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-facebook"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-twitter"></ion-icon></a>
          <a href="#" class="text-blue-500 hover:text-blue-600"><ion-icon name="logo-linkedin"></ion-icon></a>
        </div>
      </div>

    </div>
  </div>
</section>


  <!-- Footer Section -->
<footer id="contact" class="footer text-center bg-gray-900 text-white py-8">
  <div class="container mx-auto px-6">
    <h3 class="text-2xl font-bold mb-4">Get in Touch with Us</h3>
    <p class="mb-4">Sign up for our newsletter to receive the latest travel deals and updates.</p>
    
    <!-- Subscription Form -->
    <form id="subscribeForm" action="#" method="POST" class="mb-4 flex justify-center items-center">
      <input type="email" id="footer-subscribe" name="email" placeholder="Enter your email" class="p-2 rounded-l-md border border-gray-700 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      <button type="submit" class="p-2 bg-blue-500 rounded-r-md hover:bg-blue-600 transition duration-200">Subscribe</button>
    </form>
    
    <!-- Social Media Icons -->
    <ul id="icon" class="flex justify-center mb-4 space-x-4">
      <li><a href="#" class="hover:text-blue-400"><ion-icon name="logo-facebook"></ion-icon></a></li>
      <li><a href="#" class="hover:text-blue-400"><ion-icon name="logo-twitter"></ion-icon></a></li>
      <li><a href="#" class="hover:text-blue-400"><ion-icon name="logo-instagram"></ion-icon></a></li>
      <li><a href="#" class="hover:text-blue-400"><ion-icon name="logo-whatsapp"></ion-icon></a></li>
      <li><a href="#" class="hover:text-blue-400"><ion-icon name="logo-youtube"></ion-icon></a></li>
    </ul>

    <div class="mt-4">
      <a href="#" class="mr-4 hover:text-blue-400">Privacy Policy</a>
      <a href="#" class="hover:text-blue-400">Terms of Service</a>
    </div>

    <p class="mt-4">© 2024 TravelEase. All rights reserved.</p>
  </div>
  
  <!-- Global Subscribe Button -->
  <button class="global-button bg-blue-500 text-white p-2 rounded mt-4 hover:bg-blue-600 transition duration-200" type="button" onclick="scrollToEmail()">
    <span class="btn-text">Subscribe</span>
    <svg class="btn-icon inline-block ml-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M21.75 1.5H2.25c-.828 0-1.5.672-1.5 1.5v12c0 .828.672 1.5 1.5 1.5h19.5c.828 0 1.5-.672 1.5-1.5V3c0-.828-.672-1.5-1.5-1.5zM15.687 6.975L19.5 10.5M8.313 6.975L4.5 10.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
      <path d="M22.88 2.014l-9.513 6.56C12.965 8.851 12.488 9 12 9s-.965-.149-1.367-.426L1.12 2.014" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </button>
</footer>

  <script src="main.js" defer></script>
  <script src="likebtn.js" defer></script>
  <script src="topbtn.js" defer></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</body>
</html>


