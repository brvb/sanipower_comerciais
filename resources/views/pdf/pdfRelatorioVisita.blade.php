@php
     $visita = json_decode($visita, true);
    //  dd($visita);
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>visita</title>
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
            margin-top: 20px;
            margin-right: 10px;
        }
        .proposal-info {
            text-align: left;
        }
        .client-info {
            text-align: left;
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
        }
        .table-products th {
            /* background-color: #f2f2f2; */
            font-weight: bold;
        }
        .table-products tfoot td {
            font-weight: bold;
            padding-top: 10px;
            text-align: left;
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
        
        <h2 style = "color:rgb(151, 23, 23);"> Relatório de Visista Nº.<?php echo $visita['id']; ?></h2>
            <table class="proposal-info">
                <tr>
                    <td><strong>Data da Visita:</strong> <?php echo $visita['data_final']; ?></td>
                </tr>
                <tr>
                    <td><strong>Tipo de visita:</strong> <?php if ($visita['id_tipo_visita'] == 1) { echo 'Comercial'; } elseif ($visita['id_tipo_visita'] == 2) { echo 'Email'; } else { echo 'Telefone'; } ?></td>
                </tr>
            </table>
            <hr style = "width:100%;">
            <table class="client-info" style = "align-items: left;">
                <tr><strong>Dados do Cliente</strong></td>
                    <td colspan = 2></td><td><strong>Cliente:</strong> <?php echo $visita['cliente']; ?></td></tr>
                <tr><td></td><td colspan = 2></td><td><strong>Morada:</strong> <?php echo $visita['cliente']; ?><br><?php echo $visita['cliente']; ?></td></tr>
                <tr><td></td><td colspan = 2></td><td><strong>NIF:</strong> <?php echo $visita['cliente']; ?></td></tr>
            </table>
        </div>
        <br>
        <br>
        <!-- Product Table -->
        <table class="table-products">
            <tr style = "border-top: 1px solid black;">
                <td style="text-align:left;"><strong>Relatório Final da Visita</strong></td>
                <td colspan="6" style="text-align:left; padding-left:0px !important;"><?php echo $visita['assunto_text']; ?></td>
            </tr>
            <tfoot>
                <tr style = "border-top: 1px solid black; border-bottom: 1px solid black;">
                    <td colspan="7" style="text-align: right;"><h3>Ricardo Couto</h3></td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer-logo">
            <img src="https://sanipower.pt/img/rodape.png" alt="Sanipower Logo">
        </div>

    </main>

</body>
</html>
    