<?php
// Start the session
session_start();

// Check if the user clicked the confirmation button
if (isset($_GET['confirm'])) {
    // Destroy all session data
    session_destroy();

    // Redirect to the login page (or any other page)
    header("Location: login.php");
    exit;
} else {
    // Show the confirmation message
    echo "<script>
            if (confirm('Apakah Anda mau keluar dari halaman ini?')) {
                window.location.href = 'logout.php?confirm=true'; // Proceed with logout
            } else {
                window.location.href = 'dashboard.php'; // Cancel logout and redirect back to dashboard
            }
          </script>";
}
?>
