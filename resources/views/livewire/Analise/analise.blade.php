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
                <td>{{ $item->Document }}</td>
                <td>{{ $item->Document_number }}</td>
                <td>{{ $item->Date }}</td>
                <td>{{ $item->Customer }}</td>
                <td>{{ $item->Reference }}</td>
                <td>{{ $item->Description }}</td>
                <td>{{ $item->Total }}€</td>
                <td>{{ $item->Quantity }}</td>
                <td>{{ $item->Quantity_pending }}</td>
                <td>{{ $item->Sufficient_stock }}</td>
                <td>{{ $item->Total_stock }}</td>
                <td>{{ $item->Stock_ordered }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


