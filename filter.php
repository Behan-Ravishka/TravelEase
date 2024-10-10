<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Filter Destinations</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Open Sans", sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      width: 100%;
      padding: 0 10px;
      background: url('Images/filterback.jpeg') center no-repeat;
      background-size: cover;
    }

    .wrapper {
      width: 600px;
      height: 515px;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      background-color: rgba(255, 255, 255, 0.1);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      margin-top: 80px ;
    }

    .wrapper:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 40px rgba(0, 0, 0, 0.2);
    }

    h2 {
      font-size: 2rem;
      margin-bottom: -5px;
      margin-top: -10px;
      color: #fff;
      text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .input-field {
      position: relative;
      border-bottom: 2px solid #ccc;
      margin: 15px 0;
    }

    .input-field label {
      position: absolute;
      top: 35%;
      left: 5%;
      transform: translateY(-50%);
      color: #fff;
      font-size: 16px;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .input-field input,
    .input-field select {
      width: 100%;
      height: 40px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 15px;
      color: #fff;
      transition: all 0.3s ease;
    }

    .input-field input:focus,
    .input-field select:focus {
      border-color: #fff;
      
    }

    .input-field input:focus~label,
    .input-field input:valid~label,
    .input-field select:focus~label,
    .input-field select:valid~label {
      font-size: 1rem;
      top: 5px;
      transform: translateY(-120%);
    }

    button {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-weight: 600;
      border: 2px solid rgba(255, 255, 255, 0.5);
      padding: 12px 20px;
      cursor: pointer;
      border-radius: 3px;
      font-size: 16px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
      background: rgba(255, 255, 255, 0.3);
      color: #000;
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .filter-container {
      display: flex;
      flex-direction: column;
    }

    .filter-container select,
    .filter-container input {
      margin-bottom: 20px;
      background-color: rgba(255, 255, 255, 0.15);
      padding: 10px;
      border-radius: 5px;
      color: #ffffff;
      transition: all 0.3s ease;
    }

    .filter-container input:focus,
    .filter-container select:focus {
      background-color: rgba(255, 255, 255, 0.25);
    }

    select {
  appearance: none;
}

select option {
  background-color: rgba(100, 100, 100, 0.8);
  color: white;
}

#main-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  padding: 1rem;
  background-color: rgb(0, 0, 0, 0, 0.6);
  z-index: 999;
  margin-bottom: 5px;
}
  </style>
</head>
<body>

<!-- Header Section -->
<header class="navbar-bg py-4 shadow-lg fixed w-full z-50" id="main-header">
    <div class="container mx-auto flex justify-between items-center px-6">
        <!-- Logo and Website Name -->
        <div class="flex items-center">
            <a href="index.php" class="hover:opacity-80 transition-opacity">
                <img src="Images/favicon-32x32.png" width="50px" height="50px" alt="Logo">
            </a>
            <div class="text-2xl font-bold text-white ml-2">
                <a href="index.php" class="hover:opacity-80 transition-opacity">TravelEase</a>
            </div>
        </div>
        <div class="space-x-4">
            <a href="index.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Home</a>
        </div>
    </div>
</header>

  <div class="wrapper" id="filter-wrapper">
    <h2>Filter Destinations</h2>
    <form method="post" action="filter results.php" class="filter-container">
        <div class="input-field">
            <input type="text" id="destination" name="destination" required>
            <label>Destination</label>
          </div>
      <div class="input-field">
        <input type="text" id="min_price" name="min_price" required>
        <label>Minimum Price</label>
      </div>
      <div class="input-field">
        <input type="text" id="max_price" name="max_price" required>
        <label>Maximum Price</label>
      </div>
      <div class="input-field">
        <select id="accommodation_type" name="accommodation_type" required>
          <option value="" disabled selected>Select Accommodation Type</option>
          <option value="Public">Public</option>
          <option value="Private">Private</option>
        </select>
        
      </div>
      <button type="submit">Apply Filters</button>
    </form>
  </div>

</body>
</html>
