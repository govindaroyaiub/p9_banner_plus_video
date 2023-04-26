<!DOCTYPE HTML>
<html>
<head>
    <title>Radio 10</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('talpa_assets/css/style.css')}}">
    <script src="https://s0.2mdn.net/ads/studio/cached_libs/gsap_3.5.1_min.js"></script>
</head>

<body onload="myFunction()">
    <div id="banner">
        <img src="{{asset('talpa_assets/assets/bg.png')}}" alt="bg" id="bg">
        <img src="{{asset('talpa_assets/assets/text1.png')}}" alt="text1" id="text1" class="texts">
        <img src="{{asset('talpa_assets/assets/text2.png')}}" alt="text1" id="text2" class="texts">
        <img src="{{asset('talpa_assets/assets/text3.png')}}" alt="text1" id="text3" class="texts">

        <div id="price_div" class="texts">
            <p>&#x20AC;</p>
            <p id="price"></p>
        </div>
    </div>

    <script>
        function myFunction() {
            apiLoad();
            var tl = new TimelineMax({ repeat: -1, repeatDelay: 2 });
                //    var tl = new TimelineMax({});

            tl
                .to('img', { duration: 0, display: 'block' })
                
                // .to('.texts', {duration: 1, x: 0, y: 0, opacity: 1, stagger: 0.25, ease: 'power1.out'})
                .to('#price_div', {duration: 0.25, yoyo: true, repeat: 3, scale: 1.1, ease: 'back.inout'}, "+=1")
                

            function apiLoad() {
                fetch('https://data.radio10.nl/lachvan10/amount.json')
                    .then(res => res.json())
                    .then((out) => {
                        var money = out.amount;
                        // var money = 500000;
                        if (money.toString().length < 4) {
                            console.log('less than 4');
                            document.getElementById('price_div').style.fontSize = '600px';
                            document.getElementById('price_div').style.top = '690px';
                        } else if (money.toString().length == 4) {
                            console.log('equal to 4');
                            document.getElementById('price_div').style.fontSize = '600px';
                            document.getElementById('price_div').style.top = '690px';
                        } else if (money.toString().length == 5) {
                            console.log('equal to 5');
                            document.getElementById('price_div').style.fontSize = '600px';
                            document.getElementById('price_div').style.top = '690px';

                        } else if (money.toString().length > 5) {
                            console.log('greater than 5');
                            document.getElementById('price_div').style.fontSize = '500px';
                            document.getElementById('price_div').style.top = '850px';
                        }
                        var money_currency = money.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                        var money = money_currency;
                        var aa = document.getElementById('price');
                        aa.innerHTML = money;
                    })
                    .catch(err =>
                        console.error(err));
            }
            setInterval(function () {
                apiLoad();
            }, 30000)
        }
    </script>
</body>
</html>