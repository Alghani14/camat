    <div>
        <form wire:submit.prevent="saveAktivitas" method="post" novalidate>

            @include('partials.alerts')

            @foreach ($aktivitass as $i => $aktivitas)

            <div class="mb-3">
            <x-form-label id="user_id{{ $i }}" label='Nama' /> <br>
            <input type="text" id="user_id{{ $i }}" name="user_id{{ $i }}" value="{{ auth()->user()->name }}" disabled />
            <x-form-error key="aktivitass.{{ $i }}.user_id" />
                </div>


                

                <div class="mb-3">
                    <x-form-label id="tanggal{{ $i }}" label='Tanggal {{ $i + 1 }}' />
                    <div class="d-flex align-items-center">
                        <x-form-input type="date" id="tanggal{{ $i }}" name="tanggal{{ $i }}" wire:model.defer="aktivitass.{{ $i }}.tanggal" />
                        @if ($i > 0)
                            <button class="btn btn-danger ms-2" wire:click="removeAktivitasInput({{ $i }})"
                                wire:target="removeAktivitasInput({{ $i }})" type="button"
                                wire:loading.attr="disabled">Hapus</button>
                        @endif
                    </div>
                    <x-form-error key="aktivitass.{{ $i }}.tanggal" />
                </div>

                <div class="mb-3">
                    <x-form-label id="kegiatan_id{{ $i }}" label='Pilih Kegiatan' /> <br>
                    <select wire:model="aktivitass.{{ $i }}.kegiatan_id">
                        <option value="">Kegiatan</option>
                        @foreach ($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}">{{ $kegiatan->aktivitas }}</option>
                        @endforeach
                    </select>
                    <x-form-error key="aktivitass.{{ $i }}.kegiatan_id" />
                </div>
            @endforeach

            <div class="d-flex justify-content-between align-items-center mb-5">
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
