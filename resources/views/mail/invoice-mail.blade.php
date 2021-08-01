<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            background-color: lightskyblue;
        }

        .container {
            margin: 0 auto;
            width: 80%;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }

        .btn {
            display: block;
            background-color: #0d71bb;
            color: white;
            padding: 10px 20px;
            width: 20%;
            margin: 0 auto;
            border-radius: 10px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bolder;
            text-align: center;
        }

        .btn:hover {
            background-color: white;
            color: #0d71bb;
            border: 1px solid #0d71bb;
        }
    </style>
</head>
<body class="bg-secondary">
<div class="container card ">
    <div class="card-body">

        <h2 style="text-align: center">Invoice : {{ $invoice->invoice_number }}</h2>
        <p> {!! $request_data->message??'' !!} </p>
        <a href="https://invoicepedia.com/invoices/share/{{ $invoice->secret }}" class="btn">View Invoice</a>

    </div>

</div>
</body>
</html>
