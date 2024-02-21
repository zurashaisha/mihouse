    // Set the countdown duration in seconds
    var countdownDuration = 120;
    var countdownDuration = countdown;
    var timer;
    
    // Function to start the countdown
    function startCountdown() {
        var display = document.getElementById('countdownInput');
    
        timer = setInterval(function() {
            // Calculate minutes and seconds
            var minutes = Math.floor(countdownDuration / 60);
            var seconds = countdownDuration % 60;
    
            // Display the countdown
            display.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
    
            // Decrease the countdown duration
            countdownDuration--;
    
            // Check if the countdown has finished
            if (countdownDuration < 0) {
                clearInterval(timer);
                alert("time is up");
            }
        }, 1000); // Update every second
    }
    
    // Function to show remaining time when input is clicked
    function showRemainingTime() {
        if (countdownDuration >= 0) {
            var minutes = Math.floor(countdownDuration / 60);
            var seconds = countdownDuration % 60;
            alert((minutes*60)+seconds);
        } else {
            alert("Time's up!");
        }
    }
    
    // Start the countdown when the page loads
    window.onload = function() {
        startCountdown();
    };