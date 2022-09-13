<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .bill {
        display: inline;
    }

    .logo1 {
        padding-top: 50px;
        float: right;
    }

    .invoice {
        position: absolute;
        right: 10px;
    }

    #invoice {
        padding-top: 120px;
        font-size: 50px;
        padding-left: 44px;
    }

    .date {
        font-size: 30px;
        display: flex;
    }

    .footer {
        position: absolute;
        bottom: 0;
		display: flex;
    }

    #vertial_logo {
        height: 400px;
        width: auto;
    }

	.table{
		display: flex;
		flex-direction: column;
		position: absolute;
        top: 280px;
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 75%;
	}

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
		height: 30px;
    }

	.words{
		padding: 10px 0px 10px 0px;
	}

	.signature{
		margin-top: 100px;
	}

</style>

<body>
    <div class="bill">
        <div class="logo1">
            <img src="{{ asset('logo_images/planetnine_black_logo.png') }}" alt="planetnine_black_logo">
        </div>
        <div class="invoice">
            <div id="invoice">
                INVOICE
            </div>
            <div class="date">
                <div style="padding-right: 10px;">
                    Date:
                </div>
                <div id="date_value">
                    12/08/2022
                </div>
            </div>
        </div>
		<div class="table">
			<table class="center" style="align-items: center; text-align: center;">
				<tr>
					<th style="width: 70%;">DESCRIPTION</th>
					<th>AMOUNT</th>
				</tr>
				<tr>
					<td>Jill</td>
					<td>200</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>200</td>
				</tr>
				<tr>
					<td><span style="float: right;"><b>TOTAL</b></span></td>
					<td><b>200</b></td>
				</tr>
			</table>
			<div class="words">
				<b>In Words: </b><span style="text-decoration: underline;">Two Thousand Seven Only</span>
			</div>

			<div class="signature">
				<span style="position: relative; top: 0; right: -230px!important; width: 100%;">
					<hr size="2" width="30%" color="black">
				</span>
				<span style="position: absolute; right: 0;">Authorized Signature</span>
			</div>
		</div>
        
        <div class="footer">
            <img src="{{ asset('logo_images/planetnine_black_logo.png') }} alt="planetnine_logo_vertical" id="vertial_logo">
			<div class="footer_table">
				
			</div>
        </div>

    </div>
</body>

</html>
