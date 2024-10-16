<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentário sobre a Proposta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        h1 {
            font-size: 20px;
            color: #2c3e50;
        }
        p {
            margin: 0 0 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
    {{-- @dd($propostas->budgets[0]); --}}
        <h1>Comentário sobre a @if(isset($propostas->orders)){{$propostas->orders[0]->order}}@else{{$propostas->budgets[0]->budget}}@endif</h1>
        
        <p>Gostaríamos de informar que um novo comentário foi adicionado a <strong>@if(isset( $propostas->orders)){{$propostas->orders[0]->order}}@else{{$propostas->budgets[0]->budget}}@endif</strong>:</p>
        
        <p><strong>Comentário:</strong> {{ $comentario }}</p>
        
        <p><strong>Detalhes do Cliente:</strong></p>
        <ul>
            <li><strong>Nome:</strong> @if(isset($propostas->orders )){{ $propostas->orders[0]->name }}@else{{ $propostas->budgets[0]->name }}@endif</li>
            <li><strong>Email:</strong> @if(isset($propostas->orders)){{ $propostas->orders[0]->email }}@else{{ $propostas->budgets[0]->email }}@endif</li>
        </ul>

        <p>Agradecemos pela sua atenção. Caso tenha dúvidas ou precise de mais informações, estamos à disposição para ajudar.</p>
    </div>
</body>
</html>
