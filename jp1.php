<?php
include 'connect.php';
// Fetch leaderboard data
$leaderboard_sql = "SELECT users.name, SUM(progress.rounds) as total_rounds 
                    FROM progress 
                    JOIN users ON progress.user_id = users.id 
                    GROUP BY progress.user_id 
                    ORDER BY total_rounds DESC";
$leaderboard_result = $conn->query($leaderboard_sql);
$leaderboard = $leaderboard_result->fetch_all(MYSQLI_ASSOC);

date_default_timezone_set("Asia/Kolkata");

// Fetch accomplished rounds till now
$accomplished_sql = "SELECT SUM(rounds) as accomplished_rounds FROM progress";
$accomplished_result = $conn->query($accomplished_sql);
$accomplished_rounds = $accomplished_result->fetch_assoc()['accomplished_rounds'];

// Calculate remaining rounds
$target_rounds = 25108;
$remaining_rounds = $target_rounds - $accomplished_rounds;

// Fetch today's total chanting
$today = date('Y-m-d');
$todays_sql = "SELECT SUM(rounds) as todays_rounds FROM progress WHERE date = '$today'";
$todays_result = $conn->query($todays_sql);
$todays_rounds = $todays_result->fetch_assoc()['todays_rounds'];

// Fetch daily progress
$daily_sql = "SELECT date, SUM(rounds) as rounds FROM progress GROUP BY date ORDER BY date DESC";
$daily_result = $conn->query($daily_sql);
$daily_progress = $daily_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Japathon Tracker</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.rawgit.com/objectivehtml/FlipClock/master/compiled/flipclock.css">
    <style>
        .flip-clock-wrapper .flip-clock-meridium a,
        .flip-clock-wrapper .flip-clock-meridium div,
        .flip-clock-wrapper .flip-clock-am-pm {
            font-size: 30px !important;
            font-weight: bold !important;
        }
        
        .flip-clock-wrapper ul li a div div.inn,
        .flip-clock-wrapper ul li a div div.inn:before {
            font-size: 60px !important;
            font-weight: bold !important;
        }
        
        .flip-clock-wrapper .flip-clock-label {
            font-size: 30px !important;
            font-weight: bold !important;
        }

        /* Preloader Styles */
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background-color: black;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #preloader img {
            width: 80%;
            max-width: 400px;
        }

        #preloader h1 {
            font-size: 2rem;
            color: white;
            margin-top: 20px;
        }

        #loader {
            width: 100px;
            height: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 20px;
        }
                /* Styles for scrollable video section */
        .video-section {
            display: flex;
            overflow-x: auto;
            overflow-y: hidden;
            gap: 10px;
            padding: 10px;
            width: 100%;
            scroll-snap-type: x mandatory;
        }
        .video-section iframe {
            flex: 0 0 100%;
            scroll-snap-align: start;
        }

        #loader .bar {
            width: 0;
            height: 100%;
            background-color: #3498db;
            animation: load 2s infinite;
        }

        @keyframes load {
            0% { width: 0; }
            50% { width: 100%; }
            100% { width: 0; }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <img src="assets/folk logo.png" alt="FOLK LIFE VADODARA Logo">
        <h1>FOLK LIFE VADODARA</h1>
        <div id="loader" style="width:300px;">
            <div class="bar"></div>
        </div>
    </div>

    <div class="cont" style="display: flex; flex-direction: column; align-content: center; justify-content: center; align-items: center; height: 100%; ">
        <div class="container "  >
            <div class="headr" style="display:flex; flex-direction:column; justify-content:center; align-items:center;height:15%;">
                <h1 style="font-size:3rem; font-weight:700;">JAPATHON TRACKER</h1>
            </div>
            
            <div class="progress-section" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <h2 style="font-size:50px">Seva Target: 25,108 Rounds</h2>
                <h3>Seva Accomplished Till Now: <?php echo $accomplished_rounds; ?></h3>
                <h3>Balanced Target: <?php echo $remaining_rounds; ?></h3>
                <h3>Today's Total Chanting: <?php echo $todays_rounds; ?></h3>
            </div>

            <div class="video-section" style="margin-top: 40px; height:605px;">
                <iframe  src="https://www.youtube.com/embed/Kd7Cm0vkRVA" frameborder="10" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe  src="https://www.youtube.com/embed/4rWQGEtEV8w" frameborder="20" allow="accelerometer; autoplay; picture-in-picture" allowfullscreen></iframe>
            </div>
          
            <div class="flip-clock-container" style="display: flex; justify-content: center; align-items: center; margin-top: 40px;">
                <div class="clock" style="margin:2em;"></div>
            </div>
            <div  style="font-size:25px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.884);" class="update-section">
                <form id="loginForm" action="login.php" method="post">
                    <input style="font-size:20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.384);"type="email" name="email" placeholder="Email" required>
                    <input style="font-size:20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.384);" type="password" name="password" placeholder="Password" required>
                    <button style="font-size:25px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.384);" type="submit">Login</button>
                    <button style="font-size:25px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.384); text-style:none;" type="submit">
                <a style="font-weight:700; color:white; font-size:20px;text-style:none; margin-bottom:4px;" href="register.html">Don't have an account? Register</a></button>
                </form>
                
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/objectivehtml/FlipClock/master/compiled/flipclock.min.js"></script>
    <script type="text/javascript">
  $(document).ready(function() {
            // Hide preloader after 3 seconds
            setTimeout(function() {
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000); // 3 seconds

            var clock;

            // Set the date we're counting down to
            var targetDate = new Date('August 25, 2024 00:00:00').getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {
                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = targetDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                clock.setTime(distance / 1000);
                clock.setCountdown(true);

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
            }, 1000);

            clock = $('.clock').FlipClock({
                clockFace: 'DailyCounter',
                autoStart: false,
                callbacks: {
                    stop: function() {
                        $('.message').html('The clock has stopped!')
                    }
                }
            });

            clock.start();
        });
    </script>
</body>
</html>

