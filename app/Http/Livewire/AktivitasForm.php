<?php

namespace App\Http\Livewire;

use App\Models\Aktivitas;
use App\Models\Kegiatan;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

final class AktivitasForm extends PowerGridComponent
{
    use ActionButton;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'bulkCheckedDelete',
                'bulkCheckedEdit',
            ]
        );
    }

    

    public function bulkCheckedDelete()
    {
        if (auth()->check()) {
            $ids = $this->checkedValues();

            if (!$ids) {
                return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => 'Pilih data yang ingin dihapus terlebih dahulu.']);
            }

            try {
                Kegiatan::whereIn('id', $ids)->delete();
                $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => 'Data jabatan berhasil dihapus.']);
            } catch (QueryException $ex) {
                $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.']);
            }
        }
    }

    public function bulkCheckedEdit()
    {
        if (auth()->check()) {
            $ids = $this->checkedValues();

            if (!$ids) {
                return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => 'Pilih data yang ingin diedit terlebih dahulu.']);
            }

            $ids = implode('-', $ids);
            return $this->dispatchBrowserEvent('redirect', ['url' => route('positions.edit', ['ids' => $ids])]);
        }
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Aktivitas::query()
            ->join('users', 'aktivitas.user_id', '=', 'users.id')
            ->join('kegiatans', 'aktivitas.kegiatan_id', '=', 'kegiatans.id')
            ->select('aktivitas.*', 'kegiatans.aktivitas as kegiatan_nama', 'users.name as user_nama')
            ->latest('aktivitas.created_at');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('user_name', fn (Aktivitas $model) => $model->user_nama)  
            ->addColumn('tanggal')
            ->addColumn('kegiatan_id', fn (Aktivitas $model) => $model->kegiatan_nama)
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Aktivitas $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Nama Pengguna', 'user_name') // Display the user's name instead of ID
                ->searchable()
                ->sortable(),

            Column::make('Tanggal', 'tanggal')
                ->searchable()
                ->makeInputDatePicker()
                ->sortable(),

            Column::make('Aktivitas', 'kegiatan_id') 
                ->searchable()
                ->makeInputMultiSelect(Kegiatan::all(), 'aktivitas', 'kegiatan_id')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->makeInputDatePicker()
                ->searchable(),
        ];
    }

    public function actions(): array
    {
        return [
            // Define your action buttons here
        ];
    }
}
