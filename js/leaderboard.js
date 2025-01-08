// Function to fetch and update the leaderboard asynchronously
function updateLeaderboard() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'users/config/leaderboard.php', true);  // The endpoint that provides leaderboard data
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response
            // Update the leaderboard on the page
            var leaderboardContainer = document.getElementById('leaderboard-data');
            leaderboardContainer.innerHTML = xhr.responseText;  // Clear the previous leaderboard
        }
    };
    xhr.send();
}

// Call the function to update the leaderboard when the page loads
window.onload = updateLeaderboard;
setInterval(updateLeaderboard, 3000);  // Updates every 5 seconds
