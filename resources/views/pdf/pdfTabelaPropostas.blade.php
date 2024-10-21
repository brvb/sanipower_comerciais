<!DOCTYPE html>
<html>
<head>
    <title>Proposta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .details, .items, .totals {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .details th, .details td,
        .items th, .items td,
        .totals th, .totals td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details th, .items th, .totals th {
            background-color: #f2f2f2;
        }
        .details th {
            width: 20%;
        }
        .totals th {
            width: 50%;
        }
        .totals {
            margin-top: 40px;
        }
        .totals td {
            text-align: right;
        }
    </style>
</head>
<body>
     @php
        $propostaData = json_decode($proposta, true);
    @endphp
    <div class="container">
        <div class="header">
            <img src="{{asset('logo/sanipower.png')}}" alt="Logo da Empresa">
            <h1>Proposta</h1>
            <p>Empresa Sanipower, S.A.</p>
            <p>Endereço:  R. de Nossa Sra. de Fátima 351, 4495-364 Beiriz</p>
            <p>Telefone: (+351) 252 249 460</p>
            <p>Email: geral@sanipower.pt</p>
        </div>
        <table class="details">
            <tr>
                <th>ID da Proposta</th>
                <td>{{ $propostaData['id'] }}</td>
                <th>Data</th>
                <td>{{ date('d/m/Y', strtotime($propostaData['date'])) }}</td>
            </tr>
            <tr>
                <th>Nome do Cliente</th>
                <td>{{ $propostaData['name'] }}</td>
                <th>NIF</th>
                <td>{{ $propostaData['nif'] }}</td>
            </tr>
            <tr>
                <th>Morada</th>
                <td>{{ $propostaData['address'] }}</td>
                <th>Cidade</th>
                <td>{{ $propostaData['city'] }}</td>
            </tr>
            <tr>
                <th>Localidade</th>
                <td>{{ $propostaData['zipcode'] }}</td>
                <th>Zona</th>
                <td>{{ $propostaData['zone'] }}</td>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    {{-- <th>Img</th> --}}
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Desconto</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($propostaData['lines'] as $line)
                    <tr>
                        {{-- <td>
                            @if($line['product_number'] != "")
                             @if(isset($line['image_ref']))
                                <img style="width:45px;" src="{{ $line['image_ref'] }}" >
                             @endif
                            @endif    
                        </td> --}}
                        <td >{{ $line['id'] }}</td>
                        <td>{{ $line['description'] }}</td>
                        <td>{{ $line['quantity'] }}</td>
                        <td>{{ number_format($line['price'], 2, ',', '.') }}</td>
                        <td>{{ number_format($line['discount'], 2, ',', '.') }}%</td>
                        <td>{{ number_format($line['total'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="totals">
            <tr>
                <th>Preço da proposta</th>
                <td>{{ number_format($propostaData['total'], 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
