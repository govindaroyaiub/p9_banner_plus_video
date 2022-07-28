<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Not Found</title>
    <link rel="shortcut icon" href="https://www.planetnine.com/wp-content/uploads/2020/06/cropped-favicon-32x32.png"
        type="image/x-icon">
    <style>
    @font-face {
        font-family: "PlanetNine Book";
        font-weight: 400;
        src: url(/fonts/PlanetNineBook.woff) format("woff");
    }
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0px;
            background: -webkit-gradient(linear, left top, right top, color-stop(23%, rgba(47, 54, 64, 1)), to(rgba(24, 27, 32, 1)));
            background: -o-linear-gradient(left, rgba(47, 54, 64, 1) 23%, rgba(24, 27, 32, 1) 100%);
            background: linear-gradient(90deg, rgba(47, 54, 64, 1) 23%, rgba(24, 27, 32, 1) 100%);
        }

        .moon {
            background: -webkit-gradient(linear, left top, right top, color-stop(48%, rgba(208, 208, 208, 1)), to(rgba(145, 145, 145, 1)));
            background: -o-linear-gradient(left, rgba(208, 208, 208, 1) 48%, rgba(145, 145, 145, 1) 100%);
            background: linear-gradient(90deg, rgba(208, 208, 208, 1) 48%, rgba(145, 145, 145, 1) 100%);
            position: absolute;
            top: -100px;
            left: -300px;
            width: 900px;
            height: 900px;
            content: '';
            border-radius: 100%;
            -webkit-box-shadow: 0px 0px 30px -4px rgba(0, 0, 0, 0.5);
                    box-shadow: 0px 0px 30px -4px rgba(0, 0, 0, 0.5);
        }

        .moon__crater {
            position: absolute;
            content: '';
            border-radius: 100%;
            background: -webkit-gradient(linear, left top, right top, color-stop(38%, rgba(122, 122, 122, 1)), to(rgba(195, 195, 195, 1)));
            background: -o-linear-gradient(left, rgba(122, 122, 122, 1) 38%, rgba(195, 195, 195, 1) 100%);
            background: linear-gradient(90deg, rgba(122, 122, 122, 1) 38%, rgba(195, 195, 195, 1) 100%);
            opacity: 0.6;
        }

        .moon__crater1 {
            top: 250px;
            left: 500px;
            width: 60px;
            height: 180px;
        }

        .moon__crater2 {
            top: 650px;
            left: 340px;
            width: 40px;
            height: 80px;
            -webkit-transform: rotate(55deg);
                -ms-transform: rotate(55deg);
                    transform: rotate(55deg);
        }

        .moon__crater3 {
            top: -20px;
            left: 40px;
            width: 65px;
            height: 120px;
            -webkit-transform: rotate(250deg);
                -ms-transform: rotate(250deg);
                    transform: rotate(250deg);
        }

        .star {
            background: grey;
            position: absolute;
            width: 5px;
            height: 5px;
            content: '';
            border-radius: 100%;
            -webkit-transform: rotate(250deg);
                -ms-transform: rotate(250deg);
                    transform: rotate(250deg);
            opacity: 0.4;
            -webkit-animation-name: shimmer;
                    animation-name: shimmer;
            -webkit-animation-duration: 1.5s;
                    animation-duration: 1.5s;
            -webkit-animation-iteration-count: infinite;
                    animation-iteration-count: infinite;
            -webkit-animation-direction: alternate;
                    animation-direction: alternate;
        }

        @-webkit-keyframes shimmer {
            from {
                opacity: 0;
            }

            to {
                opacity: 0.7;
            }
        }

        @keyframes shimmer {
            from {
                opacity: 0;
            }

            to {
                opacity: 0.7;
            }
        }

        .star1 {
            top: 40%;
            left: 50%;
            -webkit-animation-delay: 1s;
                    animation-delay: 1s;
        }

        .star2 {
            top: 60%;
            left: 90%;
            -webkit-animation-delay: 3s;
                    animation-delay: 3s;
        }

        .star3 {
            top: 10%;
            left: 70%;
            -webkit-animation-delay: 2s;
                    animation-delay: 2s;
        }

        .star4 {
            top: 90%;
            left: 40%;
        }

        .star5 {
            top: 20%;
            left: 30%;
            -webkit-animation-delay: 0.5s;
                    animation-delay: 0.5s;
        }

        .error {
            position: absolute;
            left: 100px;
            top: 400px;
            -webkit-transform: translateY(-60%);
                -ms-transform: translateY(-60%);
                    transform: translateY(-60%);
            font-family: "PlanetNine Book";
            color: #363e49;
        }

        .error__title {
            font-size: 10em;
            color: #4b4e6d;
        }

        .error__subtitle {
            font-size: 2em;
            color: #4b4e6d;
        }

        .error__description {
            opacity: 0.5;
            font-size: 1.2em;
        }

        .error__button {
            min-width: 7em;
            margin-top: 3em;
            margin-right: 0.5em;
            padding: 0.5em 2em;
            outline: none;
            border: 2px solid #2f3640;
            background-color: transparent;
            border-radius: 8em;
            color: #576375;
            cursor: pointer;
            -webkit-transition-duration: 0.2s;
                 -o-transition-duration: 0.2s;
                    transition-duration: 0.2s;
            font-size: 0.75em;
            font-family: "PlanetNine Book";
        }
        .astronaut {
            position: fixed;
            width: 185px;
            height: 300px;
            left: 70%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%) rotate(20deg) scale(1.2);
                -ms-transform: translate(-50%, -50%) rotate(20deg) scale(1.2);
                    transform: translate(-50%, -50%) rotate(20deg) scale(1.2);
        }

        .astronaut__head {
            background-color: white;
            position: absolute;
            top: 60px;
            left: 60px;
            width: 60px;
            height: 60px;
            content: '';
            border-radius: 2em;
        }

        .astronaut__head-visor-flare1 {
            background-color: #7f8fa6;
            position: absolute;
            top: 28px;
            left: 40px;
            width: 10px;
            height: 10px;
            content: '';
            border-radius: 2em;
            opacity: 0.5;
        }

        .astronaut__head-visor-flare2 {
            background-color: #718093;
            position: absolute;
            top: 40px;
            left: 38px;
            width: 5px;
            height: 5px;
            content: '';
            border-radius: 2em;
            opacity: 0.3;
        }

        .astronaut__backpack {
            background-color: #bfbfbf;
            position: absolute;
            top: 90px;
            left: 47px;
            width: 86px;
            height: 90px;
            content: '';
            border-radius: 8px;
        }

        .astronaut__body {
            background-color: #e6e6e6;
            position: absolute;
            top: 115px;
            left: 55px;
            width: 70px;
            height: 80px;
            content: '';
            border-radius: 8px;
        }

        .astronaut__body__chest {
            background-color: #d9d9d9;
            position: absolute;
            top: 140px;
            left: 68px;
            width: 45px;
            height: 25px;
            content: '';
            border-radius: 6px;
        }

        .astronaut__arm-left1 {
            background-color: #e6e6e6;
            position: absolute;
            top: 127px;
            left: 9px;
            width: 65px;
            height: 20px;
            content: '';
            border-radius: 8px;
            -webkit-transform: rotate(-30deg);
                -ms-transform: rotate(-30deg);
                    transform: rotate(-30deg);
        }

        .astronaut__arm-left2 {
            background-color: #e6e6e6;
            position: absolute;
            top: 102px;
            left: 7px;
            width: 20px;
            height: 45px;
            content: '';
            border-radius: 8px;
            -webkit-transform: rotate(-12deg);
                -ms-transform: rotate(-12deg);
                    transform: rotate(-12deg);
            border-top-left-radius: 8em;
            border-top-right-radius: 8em;
        }

        .astronaut__arm-right1 {
            background-color: #e6e6e6;
            position: absolute;
            top: 113px;
            left: 100px;
            width: 65px;
            height: 20px;
            content: '';
            border-radius: 8px;
            -webkit-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                    transform: rotate(-10deg);
        }

        .astronaut__arm-right2 {
            background-color: #e6e6e6;
            position: absolute;
            top: 78px;
            left: 141px;
            width: 20px;
            height: 45px;
            content: '';
            border-radius: 8px;
            -webkit-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                    transform: rotate(-10deg);
            border-top-left-radius: 8em;
            border-top-right-radius: 8em;
        }

        .astronaut__arm-thumb-left {
            background-color: #e6e6e6;
            position: absolute;
            top: 110px;
            left: 21px;
            width: 10px;
            height: 6px;
            content: '';
            border-radius: 8em;
            -webkit-transform: rotate(-35deg);
                -ms-transform: rotate(-35deg);
                    transform: rotate(-35deg);
        }

        .astronaut__arm-thumb-right {
            background-color: #e6e6e6;
            position: absolute;
            top: 90px;
            left: 133px;
            width: 10px;
            height: 6px;
            content: '';
            border-radius: 8em;
            -webkit-transform: rotate(20deg);
                -ms-transform: rotate(20deg);
                    transform: rotate(20deg);
        }

        .astronaut__wrist-left {
            background-color: #e67e22;
            position: absolute;
            top: 122px;
            left: 6.5px;
            width: 21px;
            height: 4px;
            content: '';
            border-radius: 8em;
            -webkit-transform: rotate(-15deg);
                -ms-transform: rotate(-15deg);
                    transform: rotate(-15deg);
        }

        .astronaut__wrist-right {
            background-color: #e67e22;
            position: absolute;
            top: 98px;
            left: 141px;
            width: 21px;
            height: 4px;
            content: '';
            border-radius: 8em;
            -webkit-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                    transform: rotate(-10deg);
        }

        .astronaut__leg-left {
            background-color: #e6e6e6;
            position: absolute;
            top: 188px;
            left: 50px;
            width: 23px;
            height: 75px;
            content: '';
            -webkit-transform: rotate(10deg);
                -ms-transform: rotate(10deg);
                    transform: rotate(10deg);
        }

        .astronaut__leg-right {
            background-color: #e6e6e6;
            position: absolute;
            top: 188px;
            left: 108px;
            width: 23px;
            height: 75px;
            content: '';
            -webkit-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                    transform: rotate(-10deg);
        }

        .astronaut__foot-left {
            background-color: white;
            position: absolute;
            top: 240px;
            left: 43px;
            width: 28px;
            height: 20px;
            content: '';
            -webkit-transform: rotate(10deg);
                -ms-transform: rotate(10deg);
                    transform: rotate(10deg);
            border-radius: 3px;
            border-top-left-radius: 8em;
            border-top-right-radius: 8em;
            border-bottom: 4px solid #e67e22;
        }

        .astronaut__foot-right {
            background-color: white;
            position: absolute;
            top: 240px;
            left: 111px;
            width: 28px;
            height: 20px;
            content: '';
            -webkit-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                    transform: rotate(-10deg);
            border-radius: 3px;
            border-top-left-radius: 8em;
            border-top-right-radius: 8em;
            border-bottom: 4px solid #e67e22;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #4c4f6d;
            color: white;
            text-align: center;
            font-family: "PlanetNine Book";
        }

    </style>
    <script src="https://s0.2mdn.net/ads/studio/cached_libs/gsap_3.5.1_min.js"></script>
</head>

<body class="font-body">

    <main class="main">
        <div class="moon"></div>
        <div class="moon__crater moon__crater1"></div>
        <div class="moon__crater moon__crater2"></div>
        <div class="moon__crater moon__crater3"></div>

        <div class="star star1"></div>
        <div class="star star2"></div>
        <div class="star star3"></div>
        <div class="star star4"></div>
        <div class="star star5"></div>

        <div class="error">
            <div class="error__title">404</div>
            <div class="error__subtitle">Hmmm...</div>
            <div class="error__description" style="font-weight: bold;">The Planet you are looking for is not found</div>
            <div class="error__description" style="font-weight: bold;">Make sure you are Planet Nine habitable.</div>
        </div>

        <div class="astronaut">
            <div class="astronaut__backpack"></div>
            <div class="astronaut__body"></div>
            <div class="astronaut__body__chest"></div>
            <div class="astronaut__arm-left1"></div>
            <div class="astronaut__arm-left2"></div>
            <div class="astronaut__arm-right1"></div>
            <div class="astronaut__arm-right2"></div>
            <div class="astronaut__arm-thumb-left"></div>
            <div class="astronaut__arm-thumb-right"></div>
            <div class="astronaut__leg-left"></div>
            <div class="astronaut__leg-right"></div>
            <div class="astronaut__foot-left"></div>
            <div class="astronaut__foot-right"></div>
            <div class="astronaut__wrist-left"></div>
            <div class="astronaut__wrist-right"></div>

            <div class="astronaut__cord">
                <canvas id="cord" height="500px" width="500px"></canvas>
            </div>

            <div class="astronaut__head">
                <canvas id="visor" width="60px" height="60px"></canvas>
                <div class="astronaut__head-visor-flare1"></div>
                <div class="astronaut__head-visor-flare2"></div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; All Right Reserved. 
                <a href="https://www.planetnine.com" target="_blank" style="color: white;">Planetnine</a> - <?= Date('Y') ?>
            </p>
        </div>
    </main>
    <script type="text/javascript">
        function drawVisor() {
            const canvas = document.getElementById('visor');
            const ctx = canvas.getContext('2d');

            ctx.beginPath();
            ctx.moveTo(5, 45);
            ctx.bezierCurveTo(15, 64, 45, 64, 55, 45);

            ctx.lineTo(55, 20);
            ctx.bezierCurveTo(55, 15, 50, 10, 45, 10);

            ctx.lineTo(15, 10);

            ctx.bezierCurveTo(15, 10, 5, 10, 5, 20);
            ctx.lineTo(5, 45);

            ctx.fillStyle = '#2f3640';
            ctx.strokeStyle = '#f5f6fa';
            ctx.fill();
            ctx.stroke();
        }

        const cordCanvas = document.getElementById('cord');
        const ctx = cordCanvas.getContext('2d');

        let y1 = 160;
        let y2 = 100;
        let y3 = 100;

        let y1Forward = true;
        let y2Forward = false;
        let y3Forward = true;

        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, innerWidth, innerHeight);

            ctx.beginPath();
            ctx.moveTo(130, 170);
            ctx.bezierCurveTo(250, y1, 345, y2, 400, y3);

            ctx.strokeStyle = 'white';
            ctx.lineWidth = 8;
            ctx.stroke();


            if (y1 === 100) {
                y1Forward = true;
            }

            if (y1 === 300) {
                y1Forward = false;
            }

            if (y2 === 100) {
                y2Forward = true;
            }

            if (y2 === 310) {
                y2Forward = false;
            }

            if (y3 === 100) {
                y3Forward = true;
            }

            if (y3 === 317) {
                y3Forward = false;
            }

            y1Forward ? y1 += 1 : y1 -= 1;
            y2Forward ? y2 += 1 : y2 -= 1;
            y3Forward ? y3 += 1 : y3 -= 1;
        }

        drawVisor();
        animate();

    </script>
    <script type="text/javascript">
       var t1 = gsap.timeline({repeat: -1, repeatDelay: 0});    
        t1
        .to('.astronaut', {duration: 2, y: '30%', ease: 'power2.out'}, '+=1')
            .to('.astronaut', {duration: 2, y: '0%', ease: 'power2.out'}, '+=1')
    </script>
</body>

</html>
