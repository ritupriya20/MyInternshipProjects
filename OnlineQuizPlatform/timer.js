    let timeLeft = 300; 
    let startTime = Date.now();
    const timerElement = document.getElementById('timer');
    submitButtonClicked=false;

    function startTimer() {
        const timerInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerElement.textContent = 'Time\'s up!';
                if (!submitButtonClicked) { 
                    document.getElementById('submit-btn').click();
                }
            } else {
                timerElement.innerHTML= `Time left: <span style="color:red;">${timeLeft}</span> seconds`;
                timeLeft--;
            }
        }, 1000); 
    }
    
    startTimer(); 
    window.getCompletionTime = function() {
        const endTime = Date.now(); 
        return ((endTime - startTime) / 1000)-1; 
    }



