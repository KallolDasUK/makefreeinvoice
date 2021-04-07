<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

    <style>
        @font-face {
            font-family: 'Bangla';
            font-style: normal;
            font-weight: normal;
            src: url('fonts/bn.ttf') format('truetype');
        }
        *{
            font-family:  Arial, Helvetica, sans-serif;
        }


        table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            font-size: 14px;
        }

        table td, table th {
            border: 0px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 0px;
            padding-bottom: 0px;
            text-align: left;
            background-color: #d9d8d9;
            color: black;
        }

        .footer {
            margin-top: 200px;

        }

        .box {
            display: flex;
            flex-wrap: nowrap;

        }

        .box-item {
            background-color: #f1f1f1;
            width: 100px;
            text-align: center;
            font-size: 30px;
        }

        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
    @yield('css')
</head>
<body>


@include ('acc::partials.printable-header')

<div >


    @yield('content')
</div>

@yield('js')


</body>

</html>
