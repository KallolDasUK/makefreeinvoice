<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>

        .container {
            margin: 0 auto;
            padding: 20px;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            color: #0d71bb;
            background: white;
            border: 1px solid #0d71bb;
            padding: 5px 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bolder;
            text-align: center;
        }

        .btn {
            text-decoration: none;
        }
    </style>
</head>
<body class="bg-secondary">
<div class="container card ">
    <div class="card-body">

        <h4>Invoice : {{ $invoice->invoice_number }} </h4>
        <p> {!! $request_data->message??'' !!} </p>
        <p><a href="https://invoicepedia.com/app/invoices/share/{{ $invoice->secret }}" class="btn">View Invoice Online</a>
        </p>
        Mail was sent from <a href="https://invoicepedia.com">invoicepedia.com</a>.

    </div>

</div>
</body>
</html>
