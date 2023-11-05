<div>
    <form wire:submit.prevent="save" method="post" novalidate>
        @include('partials.alerts')

        <div class="w-100">
            <div class="mb-3">
                <x-form-label id="judul" label='Alasan Utama Izin (Judul)' />
                <x-form-input id="judul" name="judul" wire:model.defer="permission.judul" />
                <x-form-error key="permission.judul" />
            </div>
            <div class="mb-3">
                <x-form-label id="deskripsi" label='Keterangan Izin (Alasan Lebih Lengkap)' />
                <textarea id="deskripsi" name="deskripsi" class="form-control" wire:model.defer="permission.deskripsi"></textarea>
                <x-form-error key="permission.deskripsi" />
            </div>
            
            <div class="mb-3">
                <x-form-label id="image" label='Gambar Izin' />
                <input type="file" id="image" name="image" wire:model.defer="permission.image" />
                <x-form-error key="permission.image" />
            </div>

            <div class="mb-3">
                <x-form-label id="start_date" label='Tanggal Awal Izin' />
                <input type="date" id="start_date" name="start_date" wire:model.defer="permission.start_date" />
                <x-form-error key="permission.start_date" />
            </div>

            <div class="mb-3">
                <x-form-label id="end_date" label='Tanggal Akhir Izin' />
                <input type="date" id="end_date" name="end_date" wire:model.defer="permission.end_date" />
                <x-form-error key="permission.end_date" />
            </div>

            <div class="mb-3">
                <x-form-label id="total_permission" label='Total Izin' />
                <x-form-input id="total_permission" name="total_izin" wire:model.defer="permission.total_izin" />
                <x-form-error key="permission.total_izin" />
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
</div>
