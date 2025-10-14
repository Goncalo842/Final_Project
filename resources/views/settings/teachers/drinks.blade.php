@extends('layout.fe_settings')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            overflow-x: hidden;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>

    <canvas id="particles"></canvas>

@endsection