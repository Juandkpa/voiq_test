@extends('app')
<html>
<head>
    <title>Laravel</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 40%;
            color: #B0BEC5;
            display: table;
            font-weight: 50;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
            margin-top: 2%;
            margin-left: 30%;
            height: 500px;
            overflow: auto;
        }

        .title {
            font-size: 60px;
            margin-bottom: 40px;

        }
    </style>
</head>
<body>
<div class="container">
        <div class="title">Matcher</div>
        <form id="frmMatch" class="form-inline" data-url="{{ url('match')}}"> <!-- action="{{ url('match')}}-->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="exampleInputName2">Agent 1 : </label>
                <input type="text" name="Agent_1" class="form-control" id="exampleInputName2" placeholder="Zipcode" pattern="(\d{5}([\-]\d{4})?)" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail2">Agent 2:</label>
                <input type="text" name="Agent_2" class="form-control" id="exampleInputEmail2" placeholder="Zipcode"  pattern="(\d{5}([\-]\d{4})?)" required>
            </div>
            <button id="btnMatch" type="submit" class="btn btn-info">Match</button> 
            <img id="loadingImg" src="{{ asset('/img/loader.gif') }}">
        </form>
    <div class="col-md-5 content" class="content" id="matching"></div>
</div>

</body>
</html>
