<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <div class="container height-100 d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div class="card p-2 text-center">
                <h6>Please enter the one time password <br> to verify your registration</h6>
                <div> <span>A code has been sent to</span>
                    <small>{{ substr($mobile, 0, 3) }}XXX{{ substr($mobile, 6, 9) }}</small>
                </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> <input
                        class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" /> <input
                        class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" /> <input
                        class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" /> <input
                        class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" /> <input
                        class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" /> <input
                        class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" /> </div>
                <div class="mt-4"> <button class="btn btn-danger px-4 validate">Validate</button> </div>
            </div>
            <div class="card-2">
                <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span>
                    <a href="#" class="text-decoration-none ms-3">Resend</a>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <span>This OTP will automatically expire in </span>
                    <a id="timer" class="text-decoration-none ms-3" style="color: red;">5:00</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</body>

<!-- Add the JavaScript code at the end of your HTML file -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the validate button and add a click event listener
    const validateButton = document.querySelector('.validate');
    validateButton.addEventListener('click', function() {
        // Get the entered OTP
        const otp = document.getElementById('first').value +
            document.getElementById('second').value +
            document.getElementById('third').value +
            document.getElementById('fourth').value +
            document.getElementById('fifth').value +
            document.getElementById('sixth').value;
        const mobile = "{{ $mobile }}";

        // Make an AJAX request to the server to send the entered OTP
        // Replace 'url' with the actual route URL for OTP validation
        fetch('/validateOTP', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    otp: otp,
                    mobile: mobile
                })
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server
                // For example, show a success message or an error message to the user
                alert(data.message);
                window.location.href = "/";
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle any error that occurred during the request
            });
    });
});
</script>


<script>
// Get the timer element
const timerElement = document.getElementById('timer');
// Function to start the countdown timer
function startTimer(duration, display) {
    let timer = duration,
        minutes, seconds;
    // Interval to update the timer every second
    const countdownInterval = setInterval(function() {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = minutes + ":" + seconds;
        if (--timer < 0) {
            clearInterval(countdownInterval);
            display.textContent = "Time's up!";
        }
    }, 1000);
}
// Start the timer when the page loads
document.addEventListener('DOMContentLoaded', function() {
    const timerDuration = 5 * 60; // 5 minutes in seconds
    startTimer(timerDuration, timerElement);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function(event) {
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    inputs[i].value = '';
                    if (i !== 0) inputs[i - 1].focus();
                } else {
                    if (i === inputs.length - 1 && inputs[i].value !== '') {
                        return true;
                    } else if (event.keyCode > 47 && event.keyCode < 58) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    } else if (event.keyCode > 64 && event.keyCode < 91) {
                        inputs[i].value = String.fromCharCode(event.keyCode);
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                    }
                }
            });
        }
    }
    OTPInput();
});
</script>

</html>