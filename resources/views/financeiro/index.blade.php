@extends('main')
@section('body')


    <div class="row navigationLinks">
        <div class="col">
            <ol class="breadcrumb" style="padding-left: 25px;">
                <li class="breadcrumb-item"><a href="{{route('financeiro')}}"><i class="ti-wallet"></i> Financeiro</a></li>
                <li class="breadcrumb-item active">Listagem</li>
            </ol>
        </div>
    </div>

    <h4>Financeiro</h4>
    
    @livewire('financeiro.financeiro')

@endsection

@push('scripts_footer')

    @if (session('status') && session('message'))
        <script>
            window.onload = function() {
                let status = '{{ session('status') }}';
                let message = '{{ session('message') }}';

                if (status === 'success') {
                    toastr.success(message);
                } else if (status === 'error') {
                    toastr.error(message);
                }
            };
        </script>
    @endif
<script>
     document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                document.getElementById('loader').style.display = 'block';
            });

            Livewire.hook('message.processed', () => {
                document.getElementById('loader').style.display = 'none';
            });
        });

        window.addEventListener('beforeunload', function () {
            document.getElementById('loader').style.display = 'block';
        });
</script>

@endpush
