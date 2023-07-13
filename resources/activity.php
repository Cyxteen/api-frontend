<script>
// Check for user inactivity every minute
setInterval(checkInactivity, 1800000);

// Function to check for user inactivity
function checkInactivity() {
    var currentTime = new Date().getTime();
    var lastActivityTime = <?php echo $_SESSION['login_time']; ?>; // Get the stored timestamp from the session or cookie

    var elapsedMinutes = (currentTime - lastActivityTime) / (1000 * 60);

    // If the elapsed time exceeds 30 minutes, perform logout actions
    if (elapsedMinutes >= 30) {
        // alert(lastActivityTime)
        window.location.href = '../auth/logout.php?elapsedMinutes';
    }
}
</script>