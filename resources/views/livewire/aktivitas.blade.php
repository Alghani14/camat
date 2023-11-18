<div>
    <form wire:submit.prevent="save" method="post" novalidate>
        @include('partials.alerts')
        <div class="w-100">
            <div class="mb-3">
                <x-form-label id="aktivitas" label='Aktivitas' />
                <x-form-input id="aktivitas" name="aktivitas" wire:model.defer="kegiatan.aktivitas" />
                <x-form-error key="kegiatan.aktivitas" />
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
</div>