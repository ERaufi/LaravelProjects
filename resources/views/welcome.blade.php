@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.css"
        integrity="sha512-4OzqLjfh1aJa7M33b5+h0CSx0Q3i9Qaxlrr1T/Z+Vz+9zs5A7GM3T3MFKXoreghi3iDOSbkPMXiMBhFO7UBW/g==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ URL::asset('assets/apexcharts/apexcharts.css') }}" />
@endsection
@section('content')
    <div class="container">
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buySellModal">
            Buy/Sell
        </button>

        <div class="row mt-5">
            <!-- Total Users Card -->
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h4 style="color: white" id="totalUsers">500</h4>
                    </div>
                </div>
            </div>
            <!-- Total Products Card -->
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <h4 style="color: white" id="totalProducts">1000</h4>
                    </div>
                </div>
            </div>
            <!-- Total Countries Card -->
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Countries</h5>
                        <h4 style="color: white" id="totalCountries">50</h4>
                    </div>
                </div>
            </div>
            <!-- Fourth Card (Placeholder) -->
            <div class="col-md-3 mb-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Fourth Card</h5>
                        <h4 style="color: white">Content Here</h4>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="totalBuyingAndSellingChart">

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="topProductsBuyAndSellChart">

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="buySellModal" tabindex="-1" aria-labelledby="buySellModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buySellModalLabel">Buy/Sell Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form id="buySellForm">
                        @csrf
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product</label>
                            <select class="form-select" id="product_id" name="product_id">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_type" class="form-label">Transaction Type</label>
                            <select class="form-select" id="transaction_type" name="transaction_type">
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL('assets/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        // Start SEE Connection=================================================
        var sseSource = new EventSource("{{ URL('/dashboard-sse') }}");
        var randomNumber = 0;

        // Function to establish SSE connection
        function establishSSEConnection() {
            sseSource = new EventSource("{{ URL('/dashboard-sse') }}");

            sseSource.onmessage = function(event) {
                let eventData = JSON.parse(event.data);
                if (eventData.randomNumber != randomNumber) {
                    randomNumber = eventData.randomNumber;
                    $("#totalUsers").text(eventData.totalUsers);
                    $("#totalProducts").text(eventData.totalProducts);
                    $("#totalCountries").text(eventData.totalCountries);
                    totalBuyingAndSellingChart(eventData.perMonth);
                    topProductsBuyAndSellChart(eventData.totalBuyingAndSelling);
                }
            };

            // Handle SSE connection errors
            sseSource.onerror = function(event) {
                if (sseSource.readyState === EventSource.CLOSED) {
                    // Connection was closed, attempt to reconnect
                    console.log("Attempting to reconnect...");
                    establishSSEConnection();
                }
            };
        }

        establishSSEConnection(); // Initial connection establishment

        // End SEE Connection=================================================

        $('#buySellForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{ URL('product-transaction-add') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#buySellModal').modal('hide');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });


        function totalBuyingAndSellingChart(data) {

            // Extracting buying and selling data
            var buyingData = data.map(item => parseInt(item.total_buying));
            var sellingData = data.map(item => parseInt(item.total_selling));
            var months = data.map(item => item.monthName);

            var totalBuyingAndSellingChartOptions = {
                series: [{
                        name: "Buying",
                        data: buyingData
                    },
                    {
                        name: "Selling",
                        data: sellingData
                    }
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#77B6EA', '#545454'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: 'Total Buying & Selling of Products',
                    align: 'left'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: months,
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Price'
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                }
            };

            // Initialize ApexCharts with updated options
            var totalBuyingAndSellingChart = new ApexCharts(document.querySelector("#totalBuyingAndSellingChart"), totalBuyingAndSellingChartOptions);
            totalBuyingAndSellingChart.render();
        }

        function topProductsBuyAndSellChart(data) {
            // Extracting product IDs, buying data, and selling data
            var productNames = data.map(item => item.products.name);
            var buyingData = data.map(item => parseInt(item.total_buying));
            var sellingData = data.map(item => parseInt(item.total_selling));

            // Updating ApexCharts options with extracted data
            var topProductsBuyAndSellChartOptions = {
                series: [{
                        name: 'Buying',
                        data: buyingData
                    },
                    {
                        name: 'Selling',
                        data: sellingData
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    // stackType: '100%'
                },
                xaxis: {
                    categories: productNames,
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'right',
                    offsetX: 0,
                    offsetY: 50
                },
            };

            // Initialize ApexCharts with updated options
            var topProductsBuyAndSellChart = new ApexCharts(document.querySelector("#topProductsBuyAndSellChart"), topProductsBuyAndSellChartOptions);
            topProductsBuyAndSellChart.render();
        }
    </script>



























    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.js"
        integrity="sha512-f26fxKZJiF0AjutUaQHNJ5KnXSisqyUQ3oyfaoen2apB1wLa5ccW3lmtaRe2jdP5kh4LF2gAHP9xQbx7wYhU5w==" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            introJs().setOptions({
                steps: [{
                        title: 'Welcome',
                        intro: 'Hello World! 👋'
                    },
                    {
                        title: 'Select Language',
                        element: document.getElementById('lang'),
                        intro: 'You can change the app language from here'
                    },
                    {
                        title: "Source Code",
                        element: document.getElementById('githubLink'),
                        intro: `
                                <p>You have access to all the codes of this application.</p>
                                <p>If you like any of them, don't forget to give a star.</p>
                                <p><span class="star-icon">⭐</span></p>
                                `,
                    },
                    {
                        title: 'Youtube Tutorials',
                        element: document.getElementById('youtubeLink'),
                        intro: `<p>You Can watch all the Video Tutorials on My Youtube channel</p>
                            <p>Don't Forget To Subscribe, Share and Like  &#128516;</p>
                        `
                    },


                ],

            }).setOption("dontShowAgain", true).start();
        });
    </script>
@endsection
