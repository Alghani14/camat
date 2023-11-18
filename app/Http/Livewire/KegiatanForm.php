<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use App\Models\Position;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class KegiatanForm extends PowerGridComponent
{
    use ActionButton;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'bulkCheckedDelete',
                'bulkCheckedEdit'
            ]
        );
    }

    

    public function bulkCheckedDelete()
{
    if (auth()->check()) {
        $ids = $this->checkedValues();

        if (empty($ids)) {
            return $this->dispatchBrowserEvent('showToast', [
                'success' => false,
                'message' => 'Pilih data yang ingin dihapus terlebih dahulu.'
            ]);
        }

        try {
            Kegiatan::whereIn('id', $ids)->delete();
            $this->dispatchBrowserEvent('showToast', [
                'success' => true,
                'message' => 'Data kegiatan berhasil dihapus.'
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            $this->dispatchBrowserEvent('showToast', [
                'success' => false,
                'message' => 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.'
            ]);
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

            $ids = join('-', $ids);
            // return redirect(route('positions.edit', ['ids' => $ids])); // tidak berfungsi/menredirect
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
        return Kegiatan::query()
            ->join('positions', 'kegiatans.position_id', '=', 'positions.id')
            ->select('kegiatans.*', 'positions.name as position_name')
            ->latest('kegiatans.created_at');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('aktivitas')
            ->addColumn('position_id', fn (Kegiatan $model) => $model->position_name)
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Kegiatan $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }
    
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Nama Kegiatan', 'aktivitas')
                ->searchable()
                ->makeInputText('aktivitas')
                ->sortable(),
            Column::make('Jabatan', 'position_id')
                ->searchable()
                ->makeInputMultiSelect(Position::all(), 'name', 'position_id')
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
        return [];
    }
}
