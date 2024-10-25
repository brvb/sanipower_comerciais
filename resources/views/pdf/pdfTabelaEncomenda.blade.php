
<body>
     @php
        $encomendaData = json_decode($encomenda, true);
        // dd($encomendaData);
        $base_url = 'http://sanipower.pt'
    @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Encomenda</title>
	<style>
		 @font-face {
        font-family: "DejaVuSans";
        src: url("{{ asset('assets/fonts/DejaVuSans.ttf') }}") format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: "DejaVuSans-Bold";
        src: url("{{ asset('assets/fonts/DejaVuSans-Bold.ttf') }}") format('truetype');
        font-weight: bold;
        font-style: normal;
    }           
			body, html {
			font-family: DejaVuSans!important;
			font-size: 11px!important;
		}
		.tabela {
		width: 96%; /* Garante que a tabela ocupe toda a largura disponível */
		border-spacing: 0; /* Remove espaçamento entre as células da tabela */
		border-collapse: collapse; /* Assegura que as bordas colapsem para parecer mais estreito */
	}
		.tabela tr {
			border-bottom: solid 1px #000;
		}
	.tabela th, .tabela td {
		padding: 2px; /* Mantém o espaçamento entre o conteúdo e as bordas */
		}
		.fonte {
			font-family: "DejaVuSans-Bold"!important;
			font-size: 12px;
		}
		.header {
			text-align: center;
		}
		.right-align {
			text-align: right;
		}
		.bold {
			font-weight: bold;
		}
		footer{
			position: fixed; 
			bottom: 00px; 
			left: 0px; 
			right: 0px;
			height: 40px; 

			/** Extra personal styles **/
			color: white;
			text-align: center;
			line-height: 20px;
		}
	</style>    
	<link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/bootstrap.min.css')}}">
	{{-- @dd($encomendaData); --}}
	</head>
	<body>
		<table style="width: 100%;">
			<tr>
				<td style="width: 400px;">
					<img src="{{asset('logo/sanidigital.png')}}" alt="Logo">
				</td>
				<td class="header">
					<table>
						<tr>
							<td class="fonte"><b> {{ $encomendaData['order'] }}</b></td>
						</tr>
						<tr>
							<td>Data: {{ $encomendaData['date'] }}</td>
						</tr>
						<tr>
							<td>2.ª Via</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>&nbsp;<br>
		<table style="width: 19cm;">
			<tr>
				<td style="width: 150px;" class="fonte" valign="top"><b>Os seus dados</b></td>
				<td>
					{{ stripslashes($encomendaData['name']) }}<br>
					{{ stripslashes($encomendaData['address']) }}<br>
					{{ stripslashes($encomendaData['zipcode']) . ' ' . stripslashes($encomendaData['zone']) }}
				</td>
			</tr>
		</table>
		<br>
		<table style="width: 18.5cm;" class="tabela">
			<tr>
				<td style="width: 150px; border-bottom: solid 1px #000000;" class="fonte"><strong>Vossa referência<strong></td>
				<td style="border-bottom: solid 1px #000000;">{{ $encomendaData['id'] }}</td>
			</tr>
			<tr style="border-bottom: solid 1px #000000;">
				<td style="width: 150px; border-bottom: solid 1px #000000;" class="fonte"><strong>Observações</strong></td>
				<td style="border-bottom: solid 1px #000000;">{{ $encomendaData['obs'] }}</td>
			</tr>
			<tr>
				<td style="border-bottom: solid 1px #000000;" class="fonte"><strong>Entrega</strong></td>
				<td style="border-bottom: solid 1px #000000;">{{ $encomendaData['delivery'] }}</td>
			</tr>
			<tr>
				<td style="border-bottom: solid 1px #000000;" class="fonte"><strong>Pagamento</strong></td>
				<td style="border-bottom: solid 1px #000000;">{{ $encomendaData['payment_conditions'] }}</td>
			</tr>
		</table>
		<br>&nbsp;<br>
		<table class="tabela">
			<thead>
				<tr>
					<th class="fonte" style="width: 10%; padding: 2px 0px;">Referência</th> <!-- Definir proporção ou valor fixo -->
					<th class="fonte" style="width: 30%;">Produto</th>
					<th class="fonte" style="width: 10%; text-align: center;">QTD</th>
					<th class="fonte" style="width: 10%; text-align: center;">PVP</th>
					<th class="fonte" style="width: 10%; text-align: center;">Desc.</th>
					<th class="fonte" style="width: 15%; text-align: center;">Preço</th>
					<th class="fonte" style="width: 15%; text-align: center;">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total = 0;
					$total_iva = 0;
					$conta_linhas = 0;
					$discount = 0;
					$discount2 = 0;
					$total_SIVA = 0;
					$pr = 0;
				?>
				@foreach($encomendaData['lines'] as $line)
				@php
					$pvp = floatval($line['pvp']);
					$pvp_formatado = number_format($pvp, 3, '.', '');
				@endphp
				<tr style = "border-bottom:none !important; border-top:none; !important">
					<td valign="top">{{ $line['reference'] }}</td>
					<td style = "text-align: left;" valign="top">{{ $line['description'] }}</td>
					<td style = "text-align: center;" valign="top">{{ trim(number_format(floatval($line['quantity']), 0)) }}</td>
					<td style = "text-align: center;" valign="top">{{ floatval($pvp_formatado) }}€</td>
					<td style = "text-align: center;" valign="top">
						@if($line['discount'] > 0)  
							{{ number_format($line['discount'], 0) }}%
						@endif
						@if($line['discount2'] > 0)
						+{{ number_format($line['discount2'], 0) }}%
						@endif
					</td>
					<?php
					$line['price'] = number_format($line['price'], 3, '.', '');


					$discount = $line['discount'];

					$discount = $discount / 100;

					$discount = $discount * floatval($line['price']);

					$discount2 = $line['discount2'];

					$discount2 = $discount2 / 100;

					$discount2 = (floatval($line['price']) - $discount) * $discount2;

					$desconto = $discount + $discount2;

					$price = floatval($line['price']) - $desconto;

					$total = isset($total) ? $total : 0;
					$total = floatval($line['quantity']) * floatval($price);	
					$total = number_format($total, 3, '.', '');				
					?>
					<td style = "text-align: center;" valign="top">{{ $line['price'], }}€</td>
					<td style = "text-align: center;" valign="top">{{ $total }}€</td>
				</tr>
				<?php
					$total_SIVA += $total;
					$total_SIVA = number_format($total_SIVA, 3, '.', '');


					$tabela = $line['tax'];
					$taxa_iva = $tabela / 100 + 1;
					
					$total_iva = isset($total_iva) ? $total_iva : 0;
					$total_iva = floatval($total_SIVA) * $taxa_iva;
					$total_iva = number_format($total_iva, 3, '.', '');
					?>
				<tr style="border-bottom: solid 1px #000000; border-top:none !important;">
					<td style="border-bottom: solid 1px #000000; border-top:none !important;">&nbsp;</td>
					<td class = "fonte" style="border-bottom: solid 1px #000000; border-top:none !important;" colspan="6"><strong>Notas:</strong> {{ $line['origin'], }}</td>
				</tr>
				@endforeach
				
				<tr style="background:#fff;" style = "border-bottom:none;">
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td class="text-right fonte" colspan="2" style = "border-bottom:none;"><strong>Total s/IVA</strong></td>
					<td class="text-right fonte" ><strong>{{ $total_SIVA }}€</strong></td>
				</tr>
				<tr style="background:#fff;" style = "border-bottom:none; border-top:none;">
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>
					<td class="text-right fonte" colspan="2"><strong>Total c/IVA</strong></td>
					<td class="text-right fonte" style = "border-bottom:none;"><strong>{{ $total_iva }}€</strong></td>
				</tr>
			</tbody>
		</table>
	
		<footer>
			<table>
				<tr style = "border-bottom:none; border-top:none;">
					<td><img src="{{asset('logo/rodape.png')}}" height="50"></td>
				</tr>
			</table>
            Copyright &copy; <?php echo date("Y");?> 
        </footer>
	</body>
</html>
	<?php /**PATH /home/usr2019/app/Standard//Carrinho_email/Views/Carrinho_email_pdf_2via.blade.php ENDPATH**/ ?>
	