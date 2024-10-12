<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details from the database
include 'connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission to update profile details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated details from form
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $country = isset($_POST['country']) ? trim($_POST['country']) : null;
    $age = isset($_POST['age']) ? (int)$_POST['age'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;

    // Ensure required fields are not empty
    if ($name !== null && $email !== null && $address !== null && $country !== null && $age !== null && $gender !== null && $description !== null) {
        // Update user details in DB
        $query = "UPDATE users SET name = ?, email = ?, address = ?, country = ?, age = ?, gender = ?, description = ?, rating = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssisii", $name, $email, $address, $country, $age, $gender, $description, $rating, $user_id);
        $stmt->execute();

        // Notification for profile update
        echo "<script>alert('Profile updated successfully! If you changed your account username or password, Please give the updated credentials to Login next time!');</script>";
    }

    // Handle profile picture update
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = $_FILES['profile_pic']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_pic);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);

        // Update user profile picture in DB
        $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $target_file, $user_id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
    <style>
        body {
            background: url('Images/accountpageback.png') center no-repeat; 
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 10px 10px;
            background-size: cover;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 50px auto; /* Adjust margin to center */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 600px; /* Set a max-width for better display */
        }

        .glassmorphism:hover {
            transform: scale(1.03);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
        }

        .rating-star {
            color: gold;
            cursor: pointer;
            font-size: 2rem;
        }

        .rating-star:hover,
        .rating-star.active {
            color: darkorange;
        }

        .profile-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .profile-pic-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #3490dc;
            color: white;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #38b2ac;
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #319795;
        }

        #main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }

        .profile-details {
            text-align: center; /* Center-align the profile details */
            color: #fff;
            margin-top: 20px;
        }

        .profile-details h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .profile-details p {
            margin: 5px 0;
            font-size: 1rem;
        }
    </style>
    <script>
        // Rating Stars
        function setRating(star) {
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((item, idx) => {
                item.classList.remove('active');
                if (idx <= star) {
                    item.classList.add('active');
                }
            });
            document.querySelector('#rating').value = star + 1; // Set rating value
        }
    </script>
</head>
<body>
<header class="navbar-bg py-4 shadow-lg fixed w-full z-50" id="main-header">
    <div class="container mx-auto flex justify-between items-center px-6">
        <div class="flex items-center">
            <a href="index.php" class="hover:opacity-80 transition-opacity"><img src="Images/favicon-32x32.png" width="50px" height="50px" alt="Logo"></a>
            <div class="text-2xl font-bold text-white ml-2">
                <a href="index.php" class="hover:opacity-80 transition-opacity">TravelEase</a>
            </div>
        </div>

        <div class="space-x-4">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // Show "Home", "View Bookings", and "Logout" buttons
                echo '<a href="index.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Home</a>';
                echo '<a href="logout.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Logout</a>';
                echo '<a href="view bookings.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-green-500 to-teal-400">View Bookings</a>';
            } else {
                // Show "Login" and "Signup" buttons
                echo '<a href="login.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Login</a>';
                echo '<a href="signup.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Sign Up</a>';
            }
            ?>
        </div>
    </div>
</header>


    <!-- Profile Section -->
    <section class="mt-20">
        <div class="container mx-auto">
            <div class="glassmorphism mx-auto p-10">
                <h2 class="text-4xl text-white mb-6">My Profile</h2>

                <!-- Profile Picture -->
        <div class="profile-container">
                <div class="profile-pic-container">
                    <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-avatar.png'; ?>" alt="Profile Picture">
                <label for="profile_pic" class="upload-btn">
                    <i class="fas fa-camera" style="font-size: 1.5rem;"></i> <!-- Camera icon -->
                </label>
            </div>

            <div class="profile-details">
                <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>


                <!-- Form to Edit Profile -->
                <form action="account.php" method="post" enctype="multipart/form-data" class="w-full">
                    <input type="file" name="profile_pic" id="profile_pic" class="hidden">
                    <div class="mb-4">
                        <label for="name" class="block text-white">Username:</label>
                        <input type="text" name="name" id="name" class="w-full p-2 rounded" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>

                <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-white">Email:</label>
                        <input type="email" name="email" id="email" class="w-full p-2 rounded" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-white">Address:</label>
                        <input type="text" name="address" id="address" class="w-full p-2 rounded" value="<?php echo htmlspecialchars($user['address']); ?>" >
                    </div>
                    <div class="mb-4">
                        <label for="country" class="block text-white">Country:</label>
                        <input type="text" name="country" id="country" class="w-full p-2 rounded" value="<?php echo htmlspecialchars($user['country']); ?>" >
                    </div>
                    <div class="mb-4">
                        <label for="age" class="block text-white">Age:</label>
                        <input type="number" name="age" id="age" class="w-full p-2 rounded" value="<?php echo htmlspecialchars($user['age']); ?>" >
                    </div>
                    <div class="mb-4">
                        <label class="block text-white">Gender:</label>
                        <select name="gender" id="gender" class="w-full p-2 rounded">
                            <option value="Male" <?php echo ($user['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($user['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($user['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-white">Description:</label>
                        <textarea name="description" id="description" class="w-full p-2 rounded"><?php echo htmlspecialchars($user['description']); ?></textarea>
                    </div>


                    <div class="mb-4">
                        <label class="block text-white">Rating:</label>
                        <div>
                            <span class="rating-star" onclick="setRating(0)">★</span>
                            <span class="rating-star" onclick="setRating(1)">★</span>
                            <span class="rating-star" onclick="setRating(2)">★</span>
                            <span class="rating-star" onclick="setRating(3)">★</span>
                            <span class="rating-star" onclick="setRating(4)">★</span>
                            <input type="hidden" id="rating" name="rating" value="<?php echo htmlspecialchars($user['rating']); ?>">
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Update Profile</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
