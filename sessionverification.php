<?php
session_start();

// Set session timeout duration (e.g., 30 minutes)
$timeout_duration = 30 * 60; // 30 minutes in seconds

// Handle AJAX request to update session due to user activity
if (isset($_POST['update_session']) && $_POST['update_session'] === 'true') {
    // The session is being updated due to user activity
    $_SESSION['last_activity'] = time(); // Update the last activity time
    echo "Session updated successfully."; // Optional: Send a response back to the client
    exit; // Exit to prevent further processing for AJAX request
}

// Check if session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    // Mark the session as expired
    $_SESSION['timed_out'] = true;
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    // Redirect to timeout page only if the user hasn't already been redirected
    if (basename($_SERVER['PHP_SELF']) !== 'timeout.php') {
        header("Location: timeout.php"); // Redirect to timeout page
        exit; // Ensure no further processing happens after the redirect
    }
} else {
    // Update last activity time (this will happen only when session is still valid)
    $_SESSION['last_activity'] = time();
}

// Function to check if session has timed out
function is_session_expired() {
    return isset($_SESSION['timed_out']) && $_SESSION['timed_out'];
}
?>
<script>
// Function to update the session on the server
function updateSessionActivity() {
    $.ajax({
        type: "POST",
        url: window.location.href, // Send request to the current page
        data: { update_session: true }, // Send a flag to indicate session update
        success: function(response) {
            console.log("Session updated successfully.");
        },
        error: function(xhr, status, error) {
            console.error("Failed to update session:", error);
        }
    });
}

// Notify server and synchronize activity across tabs
function notifyActivity() {
    localStorage.setItem("last_activity", Date.now()); // Update the activity timestamp in localStorage
    updateSessionActivity(); // Update the session on the server
}

// Listen for user activity (e.g., mouse movement, keyboard input, clicks, scrolling)
["mousemove", "keydown", "click", "scroll"].forEach(event => {
    window.addEventListener(event, notifyActivity); // Track user activity
});

// Listen for updates to `localStorage` from other tabs
window.addEventListener("storage", (event) => {
    if (event.key === "last_activity") {
        const now = Date.now();
        const lastActivity = parseInt(event.newValue, 10);

        // Only update the session if activity is within timeout duration (30 minutes)
        if (now - lastActivity < 30 * 60 * 1000) { // 30 minutes
            updateSessionActivity(); // Update session activity on the server
        }
    }
});

// Periodically check and update session activity to prevent timeout
setInterval(() => {
    updateSessionActivity(); // Send an AJAX request every minute
}, 60000); // Every 1 minute
</script>