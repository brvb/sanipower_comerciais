<div class="sidebar-content sidebar-responsive">
    <!-- sidebar-menu  -->
    <div class="sidebar-menu">

        <ul class="sidebar-responsive">
            <li>
                <a href="{{route('dashboard')}}" >
                    <img src="{{asset('logo/sanipower.png')}}" class="logo-sanipower-sidbar">
                </a>
            </li>

            <li class="header-menu">
                Menu
            </li>

            <li class="li-hover">
                <a href="{{route('dashboard')}}" class="{{ request()->routeIs('dashboard') ? 'text-info' : '' }}">
                    <i class="ti-dashboard"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            {{-- <li class="maincat li-hover">
                <a href="#">
                    <i class="ti-layers-alt"></i>
                    <span class="menu-text">Multi-Levels Menu</span>
                </a>
                <div class="subcat">
                    <ul>
                        <li class="tier1">
                            <a href="javascript:;">Tier 1</a>
                            <div class="subcat subcatInter" style="background-color: #ffffff00">
                                <ul>
                                    <li><a href="javascript:;">Level 2</a></li>
                                    <li><a href="javascript:;">Level 2</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;">Onion</a>
                        </li>
                        <li>
                            <a href="javascript:;">Router</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="li-hover">
                <a href="{{route('clientes')}}" class="{{ Str::contains(request()->route()->getName(), 'clientes') ? 'text-info' : '' }}">
                    <i class="ti-user"></i>
                    <span>Clientes</span>
                </a>
            </li>
            <li class="li-hover">
                <a href="{{route('visitas')}}" class="{{ Str::contains(request()->route()->getName(), 'visitas') ? 'text-info' : '' }}">
                    <i class="ti-calendar"></i>
                    <span>Visitas</span>
                </a>
            </li class="li-hover">

            <li class="li-hover">
                <a href="{{route('encomendas')}}" class="{{ Str::contains(request()->route()->getName(), 'encomendas') ? 'text-info' : '' }}">
                    <i class="ti-agenda"></i>
                    <span>Encomendas</span>
                </a>
            </li>

            <li class="li-hover">
                <a href="{{route('propostas')}}" class="{{ Str::contains(request()->route()->getName(), 'propostas') ? 'text-info' : '' }}">
                    <i class="ti-wallet"></i>
                    <span>Propostas</span>
                </a>
            </li>

            <li class="li-hover">
                <a href="{{route('ocorrencias')}}" class="{{ Str::contains(request()->route()->getName(), 'ocorrencias') ? 'text-info' : '' }}">
                    <i class="ti-eye"></i>
                    <span>Ocorrências</span>
                </a>
            </li>

            <li class="li-hover">
                <a href="{{route('financeiro')}}" class="{{ Str::contains(request()->route()->getName(), 'financeiro') ? 'text-info' : '' }}">
                    <i class="ti-receipt"></i>
                    <span>Financeiro</span>
                </a>
            </li>
            
            <li class="li-hover">
                <a href="{{route('campanhas')}}" class="{{ Str::contains(request()->route()->getName(), 'campanhas') ? 'text-info' : '' }}">
                    <i class="fa fa-tag"></i>
                    <span>Campanhas</span>
                </a>
            </li>

            {{-- <li class="li-hover">
                <a href="{{route('Analise')}}" class="{{ Str::contains(request()->route()->getName(), 'Analise') ? 'text-info' : '' }}">
                    <i class="fa fa-chart-bar"></i>
                    <span>Análise</span>
                </a>
            </li> --}}
             
            @if (Auth::user()->nivel == '1')
            <li class="li-hover">
                <a href="{{route('profile.create')}}" class="{{ Str::contains(request()->route()->getName(), 'profile.create') ? 'text-info' : '' }}">
                    <i class="fa fa-gear"></i>
                    <span>Configurações</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <!-- sidebar-menu  -->
</div>
