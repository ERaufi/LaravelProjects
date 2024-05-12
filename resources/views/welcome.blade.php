@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.css"
        integrity="sha512-4OzqLjfh1aJa7M33b5+h0CSx0Q3i9Qaxlrr1T/Z+Vz+9zs5A7GM3T3MFKXoreghi3iDOSbkPMXiMBhFO7UBW/g==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <h1>{{ __('Welcome') }}</h1>
            <p style="font-size: 1.2em;">🎉 Check out my latest YouTube video below! 🎥</p>
            <iframe width="1253" height="662" src="https://www.youtube.com/embed/s362UfaMKtg" title="Laravel Auto Complete Search" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <p>Don't forget to <span style="font-weight: bold;">subscribe</span> to my channel for more content! 🔔</p>
        </div>
    </div>
@endsection
@section('script')
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
