@extends('layouts.app')

@section('head')
    <title>Weather Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        h1 {
            font-size: 2rem;
            color: #007BFF;
            text-align: center;
            margin: 20px 0;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin: 0 auto;
        }

        .weather-info {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }

        .weather-info .label {
            font-weight: 500;
            color: #666;
            margin-right: 10px;
        }

        .weather-info .value {
            font-weight: 600;
            color: #333;
        }

        .weather-icon {
            font-size: 2rem;
            color: #007BFF;
        }

        .select-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Weather Information</h1>
        <div class="weather-info">
            <div class="label">Description:</div>
            <div class="value" id="description"></div>
        </div>
        <div class="weather-info">
            <div class="label">Temperature:</div>
            <div class="value">
                <i class="fas fa-thermometer-half weather-icon temperature-icon"></i>
                <span id="temperature"></span>
            </div>
        </div>
        <div class="weather-info">
            <div class="label">Feels Like:</div>
            <div class="value">
                <i class="fas fa-temperature-low weather-icon feels-like-icon"></i>
                <span id="feels-like"></span>
            </div>
        </div>
        <div class="weather-info">
            <div class="label">Pressure:</div>
            <div class="value">
                <i class="fas fa-tachometer-alt weather-icon pressure-icon"></i>
                <span id="pressure"></span>
            </div>
        </div>
        <div class="weather-info">
            <div class="label">Humidity:</div>
            <div class="value">
                <i class="fas fa-tint weather-icon humidity-icon"></i>
                <span id="humidity"></span>
            </div>
        </div>
        <div class="weather-info">
            <div class="label">Wind Speed:</div>
            <div class="value">
                <i class="fas fa-wind weather-icon wind-speed-icon"></i>
                <span id="wind-speed"></span>
            </div>
        </div>
        <div class="select-container">
            <label for="city-select">Select City: </label>
            <select id="city-select">
                <option value="London">London</option>
                <option value="New York">New York</option>
                <option value="Tokyo">Tokyo</option>
            </select>
            <label for="unit-select">Select Unit: </label>
            <select id="unit-select">
                <option value="metric">Celsius</option>
                <option value="imperial">Fahrenheit</option>
            </select>
            <button id="update-weather-btn">Update Weather</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $('#update-weather-btn').on('click', function() {
                const city = $('#city-select').val();
                const unit = $('#unit-select').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ URL('get-weather') }}',
                    data: {
                        'city': city,
                        'unit': unit
                    },
                    success: function(data) {
                        $('#description').text(data.weather[0].description);
                        $('#temperature').text(data.main.temp + ' °' + (unit === 'imperial' ? 'F' : 'C'));
                        $('#feels-like').text(data.main.feels_like + ' °' + (unit === 'imperial' ? 'F' : 'C'));
                        $('#pressure').text(data.main.pressure + ' hPa');
                        $('#humidity').text(data.main.humidity + '%');
                        $('#wind-speed').text(data.wind.speed + ' m/s');
                    }
                });
            });
        });
    </script>
@endsection
