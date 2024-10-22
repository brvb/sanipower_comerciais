<table class="table table-striped">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Doc. Nº</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Referência</th>
            <th>Descrição</th>
            <th>Total</th>
            <th>Quant.</th>
            <th>Quant. pendente</th>
            <th>Stock suficiente</th>
            <th>Stock total</th>
            <th>Stock enc.</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tabela as $index => $item)

            <tr>
                <td>{{  isset($item->Document) ? $item->Document : null }}</td>
                <td>{{ $item->Document ?? null }}</td>
                <td>{{ $item->Document_number ?? null }}</td>
                <td>{{ $item->Date ?? null }}</td>
                <td>{{ $item->Customer ?? null }}</td>
                <td>{{ $item->Reference ?? null }}</td>
                <td>{{ $item->Description ?? null }}</td>
                <td>{{ $item->Total ?? null }}€</td>
                <td>{{ $item->Quantity ?? null }}</td>
                <td>{{ $item->Quantity_pending ?? null }}</td>
                <td>{{ $item->Sufficient_stock ?? null }}</td>
                <td>{{ $item->Total_stock ?? null }}</td>
                <td>{{ $item->Stock_ordered ?? null }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


