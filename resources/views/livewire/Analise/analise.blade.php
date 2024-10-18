<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Salesman Name</th>
            <th>Document</th>
            <th>Document Number</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Reference</th>
            <th>Description</th>
            <th>Total</th>
            <th>Quantity</th>
            <th>Quantity Pending</th>
            <th>Sufficient Stock</th>
            <th>Total Stock</th>
            <th>Stock Ordered</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tabela as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->Salesman_name }}</td>
                <td>{{ $item->Document }}</td>
                <td>{{ $item->Document_number }}</td>
                <td>{{ $item->Date }}</td>
                <td>{{ $item->Customer }}</td>
                <td>{{ $item->Reference }}</td>
                <td>{{ $item->Description }}</td>
                <td>{{ $item->Total }}</td>
                <td>{{ $item->Quantity }}</td>
                <td>{{ $item->Quantity_pending }}</td>
                <td>{{ $item->Sufficient_stock }}</td>
                <td>{{ $item->Total_stock }}</td>
                <td>{{ $item->Stock_ordered }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


