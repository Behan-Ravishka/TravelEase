// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
      });
  });
});

// Update progress bar on scroll
window.onscroll = function() {
  updateProgressBar();
};

function updateProgressBar() {
  const documentHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  const scrollTop = window.scrollY;
  const progress = (scrollTop / documentHeight) * 100;
  const progressBar = document.getElementById('progress-bar');
  progressBar.style.width = progress + "%";
}

// Placeholder for JavaScript functionality
console.log("Why Choose Us section loaded.");
console.log("Exclusive Deals banner loaded.");

// Testimonial carousel functionality
let currentSlide = 0;

function showSlide(index) {
  const slides = document.querySelectorAll('.testimonial');
  const totalSlides = slides.length;

  if (index >= totalSlides) {
      currentSlide = 0;
  } else if (index < 0) {
      currentSlide = totalSlides - 1;
  } else {
      currentSlide = index;
  }

  const carouselWrapper = document.getElementById('carousel-wrapper');
  carouselWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function nextSlide() {
  showSlide(currentSlide + 1);
}

function prevSlide() {
  showSlide(currentSlide - 1);
}

// Automatic sliding every 5 seconds
setInterval(nextSlide, 5000);

// Social media buttons generation
const socialMediaData = [
  { name: "Facebook", icon: "fab fa-facebook-f" },
  { name: "Twitter", icon: "fab fa-twitter" },
  // Add more data objects as needed
];

const socialMediaButtonsContainer = document.querySelector('.social-media-buttons');
socialMediaData.forEach(social => {
  const button = document.createElement('div');
  button.classList.add('button');
  button.setAttribute('data-social', social.name.toLowerCase());

  const icon = document.createElement('div');
  icon.classList.add('icon');
  icon.innerHTML = `<i class="${social.icon}"></i>`;
  button.appendChild(icon);

  const text = document.createElement('span');
  text.textContent = social.name;
  button.appendChild(text);

  socialMediaButtonsContainer.appendChild(button);
});

// Inside the searchDestinations function:
var resultsDiv = document.getElementById("results");
resultsDiv.innerHTML = "";

results.forEach(function(result) {
    var accommodationDiv = document.createElement("div");
    accommodationDiv.innerHTML = "<h2>" + result.name + "</h2><p>" + result.price + "</p>";
    resultsDiv.appendChild(accommodationDiv);
});

function redirectToFilter() {
  window.location.href = "filter.php";
}

function confirmLogout() {
  // Show a confirmation dialog
  if (confirm("Are you sure you want to log out?")) {
      // If the user clicks OK, redirect to the logout.php page
      window.location.href = 'logout.php';
  }
}

// Inside the searchDestinations function:
var resultsDiv = document.getElementById("results");
resultsDiv.innerHTML = "";

results.forEach(function(result) {
    var accommodationDiv = document.createElement("div");
    accommodationDiv.innerHTML = "<h2>" + result.name + "</h2><p>" + result.price + "</p>";
    resultsDiv.appendChild(accommodationDiv);
});

function redirectToFilter() {
  window.location.href = "filter.php";
}

function confirmLogout() {
  // Show a confirmation dialog
  if (confirm("Are you sure you want to log out?")) {
      // If the user clicks OK, redirect to the logout.php page
      window.location.href = 'logout.php';
  }
}

// Smooth scrolling to email field
function scrollToEmail() {
  const emailField = document.getElementById('footer-subscribe');
  if (emailField) {
      emailField.scrollIntoView({ behavior: 'smooth' });
      emailField.focus();
  }
}

// Search functionality
document.getElementById('searchForm').addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent the default form submission

  // Get form data
  const formData = new FormData(this);

  // Show loading message
  const resultsContainer = document.getElementById('results-container');
  resultsContainer.innerHTML = '<p>Searching for available options...</p>';
  document.getElementById('search-results-popup').classList.remove('hidden');

  // Make the AJAX request
  fetch('search.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      resultsContainer.innerHTML = ''; // Clear previous results

      if (data.length === 0) {
          resultsContainer.innerHTML = '<p>No results found for your search.</p>';
      } else {
          data.forEach(item => {
              const resultItem = `
              <div class="bg-white/20 p-4 rounded-lg">
                <img src="${item.image_url}" alt="${item.destination_name}" class="w-full rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">${item.destination_name}</h3>
                <p>${item.description}</p>
                <p>Price: $${item.price}</p>
                <p>Max Guests: ${item.max_guests}</p>
                <p>Availability: From ${item.available_from} to ${item.available_to}</p>
                <p>Rating: ${item.rating} / 5</p>
                <p>Reviews: ${item.reviews}</p>
              </div>
              `;
              resultsContainer.insertAdjacentHTML('beforeend', resultItem);
          });
      }
  })
  .catch(error => {
      resultsContainer.innerHTML = '<p>Error retrieving search results. Please try again later.</p>';
  });
});

// Close the popup
document.getElementById('close-popup').addEventListener('click', function() {
  document.getElementById('search-results-popup').classList.add('hidden');
});


document.addEventListener("DOMContentLoaded", function () {
  const subscribeForm = document.getElementById('subscribe-form');
  const notificationBox = document.getElementById('global-notification');
  const notificationMessage = document.getElementById('notification-message');
  const closeNotification = document.getElementById('close-notification');
  
  let isLoggedIn = false; // Simulate login status. Set to true if logged in.

  // Mock login/logout buttons for demo
  const loginBtn = document.getElementById('login-btn');
  const logoutBtn = document.getElementById('logout-btn');

  // Subscribe form submission
  subscribeForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const emailInput = document.getElementById('footer-subscribe').value;

      if (!isLoggedIn) {
          showNotification('Please log in to subscribe to the newsletter.');
      } else {
          checkEmailSubscription(emailInput);
      }
  });

  // Login button click 
  loginBtn.addEventListener('click', function () {
      isLoggedIn = true;  
      loginBtn.classList.add('hidden');
      logoutBtn.classList.remove('hidden');
      showNotification('You are logged in successfully!');
  });

  // Logout button click 
  logoutBtn.addEventListener('click', function () {
      isLoggedIn = false;  
      loginBtn.classList.remove('hidden');
      logoutBtn.classList.add('hidden');
      showNotification('You are logged out successfully!');
  });

  closeNotification.addEventListener('click', function () {
      notificationBox.classList.add('hidden');
  });

  function checkEmailSubscription(email) {
      const existingEmail = "example@email.com"; 
      
      if (email === existingEmail) {
          showNotification('Check your email.');
      } else {
          showNotification("You're subscribed successfully!");
      }
  }

  // Global notification function
  function showNotification(message) {
      notificationMessage.textContent = message;
      notificationBox.classList.remove('hidden');

      // Auto-hide notification after 5 seconds
      setTimeout(function () {
          notificationBox.classList.add('hidden');
      }, 5000);
  }
});

document.addEventListener("DOMContentLoaded", function() {
  // Get all the like buttons
  const likeButtons = document.querySelectorAll('.like-btn');
  const likeSound = document.getElementById('like-sound');

  likeButtons.forEach(button => {
      button.addEventListener('click', function() {
          const heartIcon = button.querySelector('.heart-icon');

          // Play the pop sound on click
          if (likeSound) {
              likeSound.currentTime = 0;  
              likeSound.play().catch(error => {
                  console.log('Error playing sound:', error);
              });
          }

          // Toggle the "liked" state
          if (heartIcon.classList.contains('liked')) {
              heartIcon.setAttribute('name', 'heart-outline'); 
              heartIcon.classList.remove('liked');
              button.style.backgroundColor = 'rgba(255, 255, 255, 0.2)'; 
          } else {
              heartIcon.setAttribute('name', 'heart'); 
              heartIcon.classList.add('liked');
              button.style.backgroundColor = '#ff0000'; 
          }
      });
  });
});


