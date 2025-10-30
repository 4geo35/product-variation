<?php

namespace GIS\ProductVariation\Livewire\Admin\MeasurementUnits;

use GIS\ProductVariation\Interfaces\MeasurementUnitInterface;
use GIS\ProductVariation\Models\MeasurementUnit;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public string $searchTitle = "";

    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $title = "";

    public int|null $unitId = null;

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
        ];
    }

    public function rules(): array
    {
        $uniqueTitleCondition = "unique:measurement_units,title";
        if ($this->unitId) $uniqueTitleCondition .= ",{$this->unitId}";

        return [
            "title" => ["required", "string", "max:50", $uniqueTitleCondition],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
        ];
    }

    public function render(): View
    {
        $modelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
        $query = $modelClass::query()
            ->with("variations:id");
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        $units = $query->orderBy("title")->get();
        return view("pv::livewire.admin.measurement-units.index-wire", compact("units"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
    }

    public function closeData(): void
    {
        $this->displayData = false;
        $this->resetFields();
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $unitModelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
        $unitModelClass::create([
            "title" => $this->title,
        ]);

        session()->flash("unit-success", "Единица измерения успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $unitId): void
    {
        $this->resetFields();
        $this->unitId = $unitId;
        $unit = $this->findModel();
        if (! $unit) return;
        if (! $this->checkAuth("update", $unit)) { return; }

        $this->displayData = true;

        $this->title = $unit->title;
    }

    public function update(): void
    {
        $unit = $this->findModel();
        if (! $unit) return;
        if (! $this->checkAuth("update", $unit)) { return; }
        $this->validate();

        $unit->update([
            "title" => $this->title,
        ]);

        session()->flash("unit-success", "Единица измерения успешно обновлена");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $unitId): void
    {
        $this->resetFields();
        $this->unitId = $unitId;
        $unit = $this->findModel();
        if (! $unit) return;
        if (! $this->checkAuth("delete", $unit)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $unit = $this->findModel();
        if (! $unit) return;
        if (! $this->checkAuth("delete", $unit)) { return; }

        if ($unit->variations->count()) {
            session()->flash("unit-error", "Есть вариации с этим измерением");
            $this->closeDelete();
            return;
        }

        $unit->delete();
        session()->flash("unit-success", "Единица измерения успешно удалена");
        $this->closeDelete();
    }

    protected function findModel(): ?MeasurementUnitInterface
    {
        $unitModelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
        $unit = $unitModelClass::find($this->unitId);
        if (! $unit) {
            session()->flash("unit-error", "Удиница измерения не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $unit;
    }

    protected function resetFields(): void
    {
        $this->reset(["title", "unitId"]);
    }

    protected function checkAuth(string $action, MeasurementUnitInterface $unit = null): bool
    {
        try {
            $unitModelClass = config("product-variation.customUnitModel") ?? MeasurementUnit::class;
            $this->authorize($action, $unit ?? $unitModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("unit-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
