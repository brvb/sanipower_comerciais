@php
     $proposta = json_decode($proposta, true);
    //  dd($proposta);
    $total = $proposta['total'];
    $total_iva = $total * 1.23;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Proposta Digital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: black;
            margin: 0;
            padding: 0;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            text-align: left;
            padding: 20px;
            background-color: white;
        }
        .header img {
            height: 50px;
        }
        .container {
            width: 100%;
            margin: auto;
            padding-top: 100px; /* Espaço para o header */
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-right: 10px;
        }
        .proposal-info {
            text-align: left;
        }
        .client-info {
            text-align: right;
            margin-left: auto;
            margin-bottom: 10px;
        }
        .client-info td, .proposal-info td {
            padding: 2px 5px;
        }
        .table-products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .table-products th, .table-products td {
            /* border-bottom: 1px solid black; */
            padding: 8px;
            text-align: center;
        }
        .table-products th {
            /* background-color: #f2f2f2; */
            font-weight: bold;
        }
        .table-products tfoot td {
            font-weight: bold;
            padding-top: 10px;
            text-align: right;
        }
        .table-products tfoot td:last-child {
            padding-right: 20px;
        }
        .details-section {
            width: 100%;
            margin-top: 20px;
            font-size: 10px;
        }
        .details-section td {
            padding: 5px 0;
            vertical-align: top;
            width: 25%;
        }
        .details-section td:first-child {
            font-weight: bold;
        }
        .footer-logo {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: left;
            margin-left: 20px;
            margin-top: 20px;
        }
        .footer-logo img {
            height: 50px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <img src="https://sanipower.pt/img/sanidigital.png" alt="Sanipower Logo">
    </header>

    <!-- Main Content -->
    <main class="container">
        
        <!-- Client and Proposal Info -->
        <div class="info-section">

            <table class="client-info">
                <tr><td><strong>Cliente:</strong> <?php echo $proposta['name']; ?></td></tr>
                <tr><td><strong>Morada:</strong> <?php echo $proposta['address']; ?><br><?php echo $proposta['zipcode']; ?></td></tr>
                <tr><td><strong>NIF:</strong> <?php echo $proposta['nif']; ?></td></tr>
            </table>

            <table class="proposal-info">
                <tr>
                    <td><strong>Proposta:</strong> <?php echo $proposta['budget']; ?></td>
                    <td><strong>Data:</strong> <?php echo $proposta['date']; ?></td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <!-- Product Table -->
        <table class="table-products">
            <thead>
                <tr style = "border-bottom: 1px solid black;">
                    <th>Referência</th>
                    <th>Produto</th>
                    <th>QTT</th>
                    <th>PVP</th>
                    <th>DESC</th>
                    <th>Preço</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposta['lines'] as $line)
                @php
					$pvp = floatval($line['pvp']);
					$pvp_formatado = number_format($pvp, 3, '.', '');
				@endphp
                <tr style = "border-bottom: none !important; border-top: none !important;">
                    <td>{{ $line['reference'] }}</td>
                    <td>{{ $line['description'] }}</td>
                    <td>{{ trim(number_format(floatval($line['quantity']), 0)) }}</td>
                    <td>{{ floatval($pvp_formatado) }}€</td>
                    <td>
                    {{ number_format($line['discount'], 0) }}%
                    @if($line['discount2'] > 0)
                    +{{ number_format($line['discount2'], 0) }}%
                    @endif</td>
                    <?php
					$line['price'] = number_format($line['price'], 3, '.', '');			
					?>
                    <td>{{ $line['price'] }}€</td>
                    <td>{{ $line['total'] }}€</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style = "border-top: 1px solid black; border-bottom: none !important;">
                    <td colspan="6" style="text-align: right;">Total s/IVA</td>
                    <td style="padding-right: 20px;">{{ $total }}€<</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right;">Total c/IVA</td>
                    <td style="padding-right: 20px;">{{ $total_iva }}€</td>
                </tr>
            </tfoot>
        </table>

        <!-- Details Section -->
        <table class="details-section">
            <tr>
                <td>Validade da Proposta:</td>
                <td>{{ $proposta['validity'] }}</td>
            </tr>
            <tr>
                <td>Tipo de pagamento:</td>
                <td>{{ $proposta['payment_conditions'] }}</td>
            </tr>
            <tr>
                <td>Observações:</td>
                <td>{{ $proposta['obs_pdf'] }}</td>
            </tr>
            <tr>
                <td>Comercial:</td>
                <td>{{ $proposta['email'] }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer-logo">
            <img src="https://sanipower.pt/img/rodape.png" alt="Sanipower Logo">
        </div>

    </main>

</body>
</html>
    