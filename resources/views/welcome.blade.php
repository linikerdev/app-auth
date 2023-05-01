<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    <style>

        .box{
            display: flex;
            flex-direction: column;
        }
        .itens{
            margin-top: 10px;
            background: #ddd;
            padding: 10px;
        }
    </style>
    </head>
    <body class="antialiased">
        <h2> Projeto para listar os usuários</h2>
<div class="box">

        @if($loading)
        <h2>
            Carregando...
        </h2>
        @endif

        @foreach($users as $user)
            <div class="itens">{{$user['username']}} - {{$user['email']}} </div>
        @endforeach
</div>
    </body>
</html>



