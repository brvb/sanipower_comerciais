<html>
    <style>
        @media (max-width: 540px) {
            .container-buttons{
                padding-left: 0.9rem;
                padding-right: 0.9rem;
            }
            .container-buttons .btn-primary{
                font-size: 0.75125rem;
            }
            .title-description{
                font-size: 10px;
            }
        }
    </style>
    <center>
    <div class="col-md-9">
        <div class="row">
         @if($products->count())
         @foreach ($products as $prodt)
             <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-3">
                 <div class="card card-decoration card-outline-primary border border-2">
                     {{-- <a href="javascript:void(0)"
                     wire:click="openDetailProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})"
                     style="pointer-events: auto"> --}}
                         <div class="mb-1">
                             <img src="https://storage.sanipower.pt/storage/{{ $prodt->capa }}"
                                 class="card-img-top" alt="...">
                             <div class="body-decoration">
                                 <h5 class="title-description">{{ $prodt->titulo }}</h5>
                             </div>
                         </div>
                     </a>
                     <div class="card-body container-buttons" style="z-index:10;">
                        <a href="https://storage.sanipower.pt/storage/{{ $prodt->ficheiro }}" target="_blank">
                         <button class="btn btn-sm btn-primary">
                                 {{-- wire:click="adicionarProduto({{ json_encode($prodt->category_number) }},{{ json_encode($prodt->family_number) }},{{ json_encode($prodt->subfamily_number) }},{{ json_encode($prodt->product_number) }},{{ json_encode($detalhesCliente->customers[0]->no) }},{{ json_encode($prodt->product_name) }})">  --}}
                             <i class="ti-shopping-cart"></i><span> Download PDF </span>
                         </button></a>
                     </div>
                 </div>
             </div>
         @endforeach
            </div>
        </div></center>
     <!-- Links de paginação -->
     {{-- <div class="d-flex justify-content-center">
         {{ $products->links('vendor.pagination.livewire-bootstrap') }}
     </div> --}}
 @else
     <p>Sem Campanhas para exibir.</p>
 @endif 
 </div>

</html>