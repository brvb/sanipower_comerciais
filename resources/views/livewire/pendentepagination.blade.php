<div id="pagination_wrapper" class="dataTables_wrapper">
    <div id="dataTables_pagination_info" class="dataTables_info" role="status">
        @if ($this->totalRecordsPendente == 0)
            <p>Não foram encontrados registos para exibir.</p>
        @else
            @php
                $numero_registos = $this->totalRecordsPendente;

                $primeiro_numero = $this->pageChosenPendente * $this->perPagePendente ;
                $ultimo_numero = ($this->pageChosenPendente + 1) * $this->perPagePendente - 1; 
                
                $primeiro_numero = $primeiro_numero - ($this->perPagePendente - 1);
                $ultimo_numero = $ultimo_numero - ($this->perPagePendente - 1);

                if($ultimo_numero > $numero_registos)
                {
                    $ultimo_numero = $numero_registos;
                }
            @endphp

            <p>Mostrar de {{ $primeiro_numero }} até {{ $ultimo_numero }} de {{ $this->totalRecordsPendente }} registos</p>
        @endif
    </div>

    <div class="dataTables_paginate paging_simple_numbers" id="dataTables_page_numbers">
        @if($this->pageChosenPendente != 1)
            <a wire:click="previousPagePendente" dusk="previousPage.before" class="paginate_button previous btn btn-primary text-white">Anterior</a>
        @endif
        {{-- @dd($paginator); --}}
        @if ($paginator->total() > 0)
            @foreach ($this->getPageRangePendente() as $page)
                @if($page != 0)
                    <span>
                        <a class="paginate_button text-white btn {{ $this->isCurrentPagePendente($page) ? 'btn-primary current' : 'btn-secondary' }}" id="page-{{ $page }}" data-dt-idx="{{ $page }}" tabindex="0" wire:click.prevent="gotoPagePendente({{ $page }})">{{ $page }}</a>
                    </span>
                @endif
            @endforeach
        @endif
    
        @if ($this->pageChosenPendente < $this->numberMaxPagesPendente)
            <a wire:click="nextPagePendente" dusk="nextPage.after" class="paginate_button next btn btn-primary text-white" data-dt-idx="{{ $paginator->currentPage() + 1 }}" tabindex="{{ $paginator->currentPage() + 1 }}">Próxima</a>
        @endif
    </div>

</div>



