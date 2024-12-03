<?php
session_start();

// Check if this is an AJAX request to update the session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_session'])) {
    $_SESSION['last_activity'] = time(); // Update last activity timestamp
    exit; // End the script here to avoid loading the rest of the page
}

// Session timeout logic
$timeout_duration = 1800; // 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Destroy the session and redirect to timeout page
    session_unset();
    session_destroy();
    header("Location: /timeout.php");
    exit;
}

// Update session activity for standard page load
$_SESSION['last_activity'] = time();
?>

<script>
// Function to notify server of user activity
function updateSessionActivity() {
    $.ajax({
        type: "POST",
        url: window.location.href, // Send the request to the same page
        data: { update_session: true }, // Send a flag to indicate session update
        success: function(response) {
            console.log("Session updated successfully.");
        },
        error: function(xhr, status, error) {
            console.error("Failed to update session:", error);
        }
    });
}

// Notify server and tabs of activity
function notifyActivity() {
    localStorage.setItem("last_activity", Date.now()); // Sync across tabs
    updateSessionActivity(); // Update session on the server
}

// Listen for user activity
["mousemove", "keydown", "click", "scroll"].forEach(event => {
    window.addEventListener(event, notifyActivity);
});

// Listen for updates in `localStorage` from other tabs
window.addEventListener("storage", (event) => {
    if (event.key === "last_activity") {
        const now = Date.now();
        const lastActivity = parseInt(event.newValue, 10);

        // Only update the session if activity is within timeout duration
        if (now - lastActivity < 30 * 60 * 1000) { // 30 minutes
            updateSessionActivity();
        }
    }
});
</script>