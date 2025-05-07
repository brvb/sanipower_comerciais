<div>
<div class="col-12" style="padding-left: 0;">
    <div class="card mb-3">
        <div class="card-header uppercase">
            <div class="caption">
                <i class="ti-filter"></i> Filtros
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="mt-2">Nome do Utilizador</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nome do Utilizador" wire:model.debounce.300ms="filterNome">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="mt-2">Email do Utilizador</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-ticket"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Email do Utilizador" wire:model.debounce.300ms="filterEmail">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="mt-2">Telemóvel</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-microphone-alt"></i></span>
                            </div>
                            <input type="tel" name="fone" class="form-control" placeholder="Telemóvel" wire:model.debounce.300ms="filterTelemovel">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12" style="padding-left: 0;">
    <div class="card mb-3">
        <div>
            <div>
                <a data-bs-toggle="collapse" href="#gruposEmail" role="button" aria-expanded="false" aria-controls="gruposEmail">
                    <div class="card-header d-block">
                        <div class="row">
                            <div class="col">
                                <div class="caption uppercase">
                                    <i class="ti-user"></i> Grupos de email
                                </div>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCriaGrupo">
                                    <i class="ti-plus"></i> Criar Grupos
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="collapse card-body" id="gruposEmail">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover init-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Emails</th>
                                    <th style="width: 15%;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grupos as $grupo)
                                    <tr>
                                        <td>{{ $grupo->titulo }}</td>
                                        <td>{{ $grupo->descricao }}</td>
                                        <td>{{ $grupo->emails }}</td>
                                        <td>
                                            <!-- Botão para editar -->
                                            <button class="btn btn-primary btn-sm" wire:click="edit({{ $grupo->id }})">
                                                Editar
                                            </button>
                                            <!-- Botão para excluir -->
                                            <button class="btn btn-danger btn-sm" wire:click="delete({{ $grupo->id }})" onclick="return confirm('Tem certeza que deseja excluir este grupo?')">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhum grupo de email encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tag {
        background-color: #1791ba;
        color: #fff;
        border-radius: 50px;
        padding: 10px 20px;
        margin: 0 5px 10px 0;
        font-size: 14px;
        display: inline-block;
        }

    .tag.highlight {
        background-color: #273c75;
    }
</style>

<!-- Modal de Criação/Edição de Grupo -->
<div class="modal fade" id="modalCriaGrupo" tabindex="-1" aria-labelledby="modalCriaGrupoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCriaGrupoLabel">{{ $grupoId ? 'Editar Grupo de Email' : 'Adicionar Novo Grupo de Email' }}</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="salvarGrupo" id="formCriaGrupo">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" id="titulo" class="form-control" wire:model.defer="titulo">
                        @error('titulo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea id="descricao" class="form-control" wire:model.defer="descricao" rows="3"></textarea>
                        @error('descricao') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="emails" class="form-label">Emails</label>
                        <textarea id="emails" class="form-control" wire:model.defer="emails" rows="3" placeholder="Digite os emails separados por vírgula"></textarea>
                        @error('emails') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div id="tags"></div>
                    <div class="mb-3">
                        <label for="local_funcionamento" class="form-label">Local de Funcionamento</label>
                        <select id="local_funcionamento" class="form-control" wire:model.defer="local_funcionamento">
                            <option value="">Selecione o local</option>
                            <option value="comentarios_propostas">Comentários Propostas</option>
                            <option value="nova_encomenda">Nova Encomenda</option>
                            <option value="nova_propostas">Nova Proposta</option>
                            <option value="aprov_propostas">Aprovação da Proposta</option>
                            <option value="RelatorioVisita">Finalizar Visita</option>
                            <option value="VisitFinanceiro">Finalizar Visita - Financeiro</option>
                            <option value="nova_ocorrencia">Novas Ocorrências</option>
                        </select>
                        @error('local_funcionamento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Grupo</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    const tagsEl = document.getElementById('tags')
    const textarea = document.getElementById('emails')

    textarea.focus()

    textarea.addEventListener('keyup', (e) => {
        createTags(e.target.value)

        if(e.key === 'Enter') {
            setTimeout(() => {
                e.target.value = ''
            }, 10)

            randomSelect()
        }
    })

    function createTags(input) {
        const tags = input.split(',').filter(tag => tag.trim() !== '').map(tag => tag.trim())
        
        tagsEl.innerHTML = ''

        tags.forEach(tag => {
            const tagEl = document.createElement('span')
            tagEl.classList.add('tag')
            tagEl.innerText = tag
            tagsEl.appendChild(tagEl)
        })
    }

    function randomSelect() {
        const times = 30

        const interval = setInterval(() => {
            const randomTag = pickRandomTag()
        
        if (randomTag !== undefined) {
            highlightTag(randomTag)

            setTimeout(() => {
                unHighlightTag(randomTag)
            }, 100)
        }
        }, 100);

        setTimeout(() => {
            clearInterval(interval)

            setTimeout(() => {
                const randomTag = pickRandomTag()

                highlightTag(randomTag)
            }, 100)

        }, times * 100)
    }

    function pickRandomTag() {
        const tags = document.querySelectorAll('.tag')
        return tags[Math.floor(Math.random() * tags.length)]
    }

    function highlightTag(tag) {
        tag.classList.add('highlight')
    }

    function unHighlightTag(tag) {
        tag.classList.remove('highlight')
    }
</script>

{{-- utilizadores --}}
<div class="col-12" style="padding-left: 0;">
    <div class="card mb-3">
        <div>
            <div>
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="caption uppercase">
                                <i class="ti-user"></i> Utilizadores
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <button class="btn btn-primary" id="abrirModalCriaUser"><i class="ti-plus"></i> Criar Utilizador</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dataTables_wrapper" class="dataTables_wrapper container" style="margin-left:0px;padding-left:0px;margin-bottom:10px;">
                        <div class="left">
                            <label>Mostrar
                                <select name="perPage" wire:model="perPage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                registos</label>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover init-datatable" id="tabela-cliente">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nome do Utilizador</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Nível de Acesso</th>
                                    <th>ID Vendedor PHC</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr data-href="#">
                                    <td>
                                        <div style="display: flex;align-items: center;">
                                            @if ($user->imagem == null || $user->imagem == '')
                                                <div class="img-temporary-navbar" style="width: 42px;height: 42px;margin-right: 10px;">{{ ucfirst(substr($user->name, 0, 1)) }}</div>
                                            @else
                                                <img class="img-navbar" style="width: 42px;height: 42px;margin-right: 10px;" src="{{ asset('storage/profile/' . $user->imagem) }}" alt=""/>
                                            @endif
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->telefone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nivel }}</td>
                                    <td>{{ $user->id_phc }}</td>
                                    <td>
                                        @if($user->status == "Inativo")
                                            <button class="btn btn-sm btn-chili btn-round" disabled>{{ $user->status }}</button>
                                        @else
                                            <button class="btn btn-sm btn-jade btn-round" disabled>{{ $user->status }}</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarUser{{$user->id}}">
                                            <i class="fas fa-user-cog"></i>
                                        </a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modalEditarUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modalEditarUserLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditarUserLabel">Editar Utilizador</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @livewire('profile.edit-profile', ['userId' => $user->id], key($user->id))
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="crossorigin="anonymous"></script>

<script>
    window.addEventListener('close-modal', event => {
        jQuery('#modalCriaGrupo').modal('hide');
    });

    window.addEventListener('open-edit-modal', event => {
        jQuery('#modalCriaGrupo').modal('show');
    });

     window.addEventListener('checkToaster', function(e) {
        if (e.detail.status == "success") {
            jQuery('#modalCriaGrupo').modal('hide');
            toastr.success(e.detail.message);
        }
        if(e.detail.status == "error"){
            jQuery('#modalCriaGrupo').modal('hide');
            toastr.warning(e.detail.message);
        }
    });
</script>

<div class="modal fade" id="modalAdicionarUser" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdicionarUserLabel">Adicionar utilizador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @livewire('profile.create-profile')
        </div>
    </div>
</div>
</div>