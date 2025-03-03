<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14pt;
        margin: 20px;
    }
    h1 {
        color: #8f1512;
        font-size: 16pt;
    }
    .preco, h3 {
        color: #3E4E68;
        font-size: 12pt;
        margin: 0px;
        padding: 0px;
    }
    h4 {
        color: #000;
        font-size: 14pt;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    td, th {
        font-size: 8pt;
        padding: 8px;
        border-bottom: 1px solid #000;
        text-align: center;
    }
    .titulo {
        font-weight: bold;
    }
    .titulo2 {
        font-weight: bold;
        border-bottom: 2px solid #000;
    }
    .centro {
        text-align: center;
    }
    .direita {
        text-align: right;
    }
</style>
<table>
    <tr>
        <td colspan="2" class="titulo" valign="top">Mapa de dívidas de clientes, em Euros<br>&nbsp;</td>
    </tr>
</table>
<table>
    <tr>
        <th>Data</th>
        <th>Idade</th>
        <th>Vencimento</th>
        <th>Idade</th>
        <th>Documento</th>
        <th>Não regularizado</th>
    </tr>
</table>
@php
    $total_geral = 0;
    $total_vencido = 0;
    $conta_clientes = 0;
@endphp
@foreach ($financeiroAgrupado as $cliente => $lancamentos)
    @php
        $total_cliente = 0;
        $conta_clientes++;
    @endphp
    <table>
        <tr>
            <td colspan="6"><b>{{ $cliente }}</b></td>
        </tr>
        @foreach ($lancamentos as $lancamento)
            @php
                $documento_data = \Carbon\Carbon::parse($lancamento->date_issue)->format('d/m/Y');
                $documento_vencimento = \Carbon\Carbon::parse($lancamento->due_date)->format('d/m/Y');
                $dias_atraso = now()->diffInDays(\Carbon\Carbon::parse($lancamento->date_issue), false);
                $dias_vencido = now()->diffInDays(\Carbon\Carbon::parse($lancamento->due_date), false);
                $valor = number_format($lancamento->not_regularized, 2, ',', '.');
                $total_cliente += $lancamento->not_regularized;
                $total_geral += $lancamento->not_regularized;
                if ($dias_vencido > 0) {
                    $total_vencido += $lancamento->not_regularized;
                }
            @endphp
            <tr>
                <td>{{ $documento_data }}</td>
                <td>{{ $dias_atraso < 0 ? '-' . abs($dias_atraso) : $dias_atraso }}</td>
                <td>{{ $documento_vencimento }}</td>
                <td>{{ $dias_vencido < 0 ? '-' . abs($dias_vencido) : $dias_vencido }}</td>
                <td>{{ $lancamento->document }} n.º {{ $lancamento->document_number }}</td>
                <td class="direita">{{ $valor }} EUR</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="direita"><b>Total:</b></td>
            <td class="direita"><b>{{ number_format($total_cliente, 2, ',', '.') }} EUR</b></td>
        </tr>
    </table>
@endforeach
<table>
    <tr>
        <td class="titulo2">Total Geral: {{ number_format($total_geral, 2, ',', '.') }} EUR</td>
        <td class="titulo2">Total Vencido: {{ number_format($total_vencido, 2, ',', '.') }} EUR</td>
        <td class="titulo2">N.º Clientes: {{ $conta_clientes }}</td>
        <td class="titulo2">N.º Movimentos: {{ $financeiroAgrupado->flatten()->count() }}</td>
    </tr>
</table>
