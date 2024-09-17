<!DOCTYPE html>
<html>

<head>
    <title>Detalle doctor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 40px;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }

        .card-title {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .card-body hr {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .card-body h2 {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .card-body h3 {
            font-size: 20px;
            font-weight: bold;
            color: #ffc107;
        }

        .card-body p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title text-center">Detalle doctor</h1>
            </div>
            <div class="card-body">
                <h2>Nombre del Doctor: {{ $doctor->name }}</h2>
                <hr>
                <h2>DUI: {{ $doctor->dui }}</h2>
                <hr>
                <h2>CARNET: {{ $doctor->carnet }}</h2>
                <hr>
                <h2>Direccion: {{ $doctor->department }}, {{ $doctor->municipality }}</h2>
                <hr>
                <h2>Fecha de Nacimiento: {{ $doctor->date_of_birth }}</h2>
                <hr>
            </div>
        </div>
    </div>
</body>

</html>
