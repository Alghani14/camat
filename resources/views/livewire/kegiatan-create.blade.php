<div>
    <form wire:submit.prevent="saveKegiatan" method="post">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @foreach ($kegiatans as $i => $kegiatan)
        <div class="mb-3 position-relative">
            <x-form-label id="kegiatan{{ $i }}" label='Nama Kegiatan {{ $i + 1 }}' />
            <div class="d-flex align-items-center">
                <!-- Adjusted wire:model from 'nama' to 'aktivitas' -->
                <x-form-input id="kegiatan{{ $i }}" name="kegiatan{{ $i }}" wire:model.defer="kegiatans.{{ $i }}.aktivitas" />
                @if ($i > 0)
                <button class="btn btn-danger ms-2" wire:click="removeKegiatanInput({{ $i }})"
                    wire:target="removeKegiatanInput({{ $i }})" type="button"
                    wire:loading.attr="disabled">Hapus</button>
                @endif
            </div>
        </div>
        @endforeach
<!-- Blade view -->
@foreach ($kegiatans as $i => $kegiatan)
    <input wire:model="kegiatans.{{ $i }}.aktivitas" type="text">
    <select wire:model="kegiatans.{{ $i }}.position_id">
        <option value="">Select Position</option>
        @foreach ($positions as $position)
            <option value="{{ $position->id }}">{{ $position->name }}</option>
        @endforeach
    </select>
    @error("kegiatans.$i.position_id") <span class="error">{{ $message }}</span> @enderror
@endforeach
<div>   <br></div>
        

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">
                Simpan
            </button>
            <button class="btn btn-light" type="button" wire:click="addKegiatanInput" wire:loading.attr="disabled">
                Tambah Input
            </button>
        </div>
    </form>
</div>
