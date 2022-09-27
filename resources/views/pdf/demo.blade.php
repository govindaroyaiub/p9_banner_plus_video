<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title_doc}}</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
        }

        .bill {
            display: inline;
        }

        .logo1 {
            position: absolute;
            top: 0;
            right: 0;
        }

        .invoice {
            position: absolute;
            top: 60px;
            right: 0;
        }

        #invoice {
            position: relative;
            top: 0;
            right: 0px;
            font-size: 50px;
            color: #4b4e6d;
        }

        .date {
            position: relative;
            font-size: 24px;
            display: flex;
            flex-direction: row;
        }

        #date_value {
            position: absolute;
            right: 0px;
            top: 0;
        }

        .footer {
            position: absolute;
            display: flex;
            bottom: 10px;
        }

        #vertial_logo {
            height: 400px;
            width: auto;
        }

        .table {
            position: absolute;
            display: inline-flex;
            flex-direction: column;
            top: 200px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }

        table,
        th,
        td {
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
            border: 1px solid black;
            border-collapse: collapse;
            height: 30px;
            width: 100%;
        }

        .words {
            padding: 20px 0px 20px 0px;
        }

        .signature {
            margin-top: 100px;
        }

        .signature_line {
            width: 250px;
            height: 47px;
            border-bottom: 1px solid black;
            position: absolute;
            right: 0;
        }

        .footer_line1{
            width: 10px;
            height: 74px;
            border-left: 1px solid black;
            position: absolute;
            /* display: block; */
            bottom: 8px;
            left: 100px;
        }

        .footer_text1{
            position: absolute;
            /* display: block; */
            bottom: 10px;
            left: 130px;
            font-size: 10px;
            line-height: 2;
            color: rgb(77, 77, 79);
        }

        .footer_text2{
            position: absolute;
            bottom: 10px;
            left: 260px;
            font-size: 10px;
            line-height: 2;
            color: rgb(77, 77, 79);
        }

        .footer_line2{
            width: 10px;
            height: 74px;
            border-left: 1px solid black;
            position: absolute;
            /* display: block; */
            bottom: 10px;
            left: 395px;
        }

        .footer_text3{
            position: absolute;
            bottom: 10px;
            left: 430px;
            font-size: 10px;
            line-height: 2;
            color: rgb(77, 77, 79);
        }

    </style>
</head>

<body>
    <div class="bill">
        <div class="logo1">
            <img src="{{ public_path('logo_images/planetnine_logo.png') }}" alt="planetnine_black_logo">
        </div>
        <div class="invoice">
            <div id="invoice">
                INVOICE
            </div>
            <div class="date">
                <div id="date_value">
                    <span style="color:#4b4e6d;">Date: </span>{{ \Carbon\Carbon::parse($created_at)->format('d/m/Y') }}
                </div>
            </div>
        </div>
        <div class="table">
            <table class="center" style="align-items: center; text-align: center;">
                <tr style="color: #4b4e6d;">
                    <th style="width: 70%;">DESCRIPTION</th>
                    <th>AMOUNT</th>
                </tr>
                @foreach ($data as $row)
                <tr>
                    <td>{{ $row['title'] }}</td>
                    <td>{{ $row['amount'] }}</td>
                </tr>
                @endforeach

                <tr style="color: #4b4e6d;">
                    <td><b>TOTAL</b></td>
                    <td><b>{{ $total_amount }}/-</b></td>
                </tr>
            </table>
            <div class="words">
                <b>In Words: </b><span style="text-decoration: underline; line-height: 1.5;">{{ $in_words }} Only.</span>
            </div>

            <div class="signature">
                <div class="signature_line"></div>
                <span style="position: absolute; right: 0; padding-top: 60px;">Authorized Signature</span>
            </div>
        </div>

        <div class="footer">
            <img src="{{ public_path('logo_images/planetnine_logo_vertical.png') }}" alt="planetnine_logo_vertical"
                id="vertial_logo">
            
        </div>
        <div class="footer_line1"></div>
        <div class="footer_text1">
            Amsterdam Office<br>
            H. Figeeweg 3F<br>
            2031BJ, Haarlem<br>
            The Netherlands
        </div>
        <div class="footer_text2">
            Dhaka Office<br>
            Road 17, Rupsha Tower<br> 
            Banani, Dhaka<br>
            Bangladesh
        </div>
        <div class="footer_line2"></div>
        <div class="footer_text3">
            Contact<br>
            (+31) 6 14 7978 01<br>
            (+880) 186 991 6379<br>
            maarten@planetnine.com
        </div>
    </div>
</body>

</html>
