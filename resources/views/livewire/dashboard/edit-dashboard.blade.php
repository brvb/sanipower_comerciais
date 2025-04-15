<section class="card mb-3">
    <div class="card-body">
        <h3 style="color:black">Personalize sua Dashboard</h3>
        <form id="dashboardPreferencesForm" wire:submit.prevent="savePreferences">
            <div class="form-group">
                <label for="show90dias">Mostrar - 90 Dias</label>
                <input type="checkbox" id="show90dias" class="toggle-checkbox" wire:model="show90dias">
            </div>

            <div class="form-group">
                <label for="showObjFat">Mostrar - Objetivo de Faturamento</label>
                <input type="checkbox" id="showObjFat" class="toggle-checkbox" wire:model="showObjFat">
            </div>

            <div class="form-group">
                <label for="showTop500">Mostrar - Top 500</label>
                <input type="checkbox" id="showTop500" class="toggle-checkbox" wire:model="showTop500">
            </div>

            <div class="form-group">
                <label for="showObjMargin">Mostrar - Objetivo Margem</label>
                <input type="checkbox" id="showObjMargin" class="toggle-checkbox" wire:model="showObjMargin" {{ $this->showObjMargin ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="showTop1000">Mostrar - Top 1000</label>
                <input type="checkbox" id="showTop1000" class="toggle-checkbox" wire:model="showTop1000">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Preferências</button>
        </form>
    </div>
</section>
