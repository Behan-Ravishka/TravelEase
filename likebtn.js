document.addEventListener("DOMContentLoaded", function() {
    // Get all the like buttons
    const likeButtons = document.querySelectorAll('.like-btn');
    const likeSound = document.getElementById('like-sound'); // Reference to the sound element

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const heartIcon = button.querySelector('.heart-icon');

            // Play the pop sound on click
            if (likeSound) {
                likeSound.currentTime = 0;  // Reset sound to the start
                likeSound.play().catch(error => {
                    console.log('Error playing sound:', error);
                });
            }

            // Toggle the "liked" state
            if (heartIcon.getAttribute('name') === 'heart') {
                heartIcon.setAttribute('name', 'heart-outline'); // Change to unfilled heart
                button.style.color = 'black'; // Reset heart color to black
            } else {
                heartIcon.setAttribute('name', 'heart'); // Change to filled heart
                button.style.color = 'red'; // Change heart color to red when liked
            }
        });
    });
});
