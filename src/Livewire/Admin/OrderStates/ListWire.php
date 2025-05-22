<?php

namespace GIS\ProductVariation\Livewire\Admin\OrderStates;

use GIS\ProductVariation\Interfaces\OrderStateInterface;
use GIS\ProductVariation\Models\OrderState;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public string $searchTitle = "";

    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $title = "";
    public string $key = "";
    public string $slug = "";

    public int|null $stateId = null;

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
        ];
    }

    public function rules(): array
    {
        $uniqueSlugCondition = "unique:order_states,slug";
        if ($this->stateId) $uniqueSlugCondition .= ",{$this->stateId}";

        $uniqueKeyCondition = "unique:order_states,key";
        if ($this->stateId) $uniqueKeyCondition .= ",{$this->stateId}";

        $uniqueTitleCondition = "unique:order_states,title";
        if ($this->stateId) $uniqueTitleCondition .= ",{$this->stateId}";

        return [
            "title" => ["required", "string", "max:150", $uniqueTitleCondition],
            "slug" => ["nullable", "string", "max:150", $uniqueSlugCondition],
            "key" => ["nullable", "string", "max:150", $uniqueKeyCondition],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "key" => "Ключ",
        ];
    }

    public function render(): View
    {
        $orderStateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $query = $orderStateModelClass::query()
            ->with("orders:id,state_id");
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        $states = $query
            ->orderBy("title")
            ->get();
        return view("pv::livewire.admin.order-states.list-wire", compact("states"));
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

        $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $stateModelClass::create([
            "title" => $this->title,
            "key" => $this->key,
            "slug" => $this->slug,
        ]);

        session()->flash("state-success", "Статус успешно добавлен");
        $this->closeData();
    }

    public function showEdit(int $stateId): void
    {
        $this->resetFields();
        $this->stateId = $stateId;
        $state = $this->findModel();
        if (! $state) return;
        if (! $this->checkAuth("update", $state)) { return; }

        $this->displayData = true;

        $this->title = $state->title;
        $this->key = $state->key;
        $this->slug = $state->slug;
    }

    public function update(): void
    {
        $state = $this->findModel();
        if (! $state) return;
        if (! $this->checkAuth("update", $state)) { return; }
        $this->validate();

        $state->update([
            "title" => $this->title,
            "key" => $this->key,
            "slug" => $this->slug,
        ]);

        session()->flash("state-success", "Статус успешно обновлен");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $stateId): void
    {
        $this->resetFields();
        $this->stateId = $stateId;
        $state = $this->findModel();
        if (! $state) return;
        if (! $this->checkAuth("delete", $state)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $state = $this->findModel();
        if (! $state) return;
        if (! $this->checkAuth("delete", $state)) { return; }

        if ($state->orders->count()) {
            session()->flash("state-error", "Есть заказы в этом статусе");
            $this->closeDelete();
            return;
        }

        $state->delete();
        session()->flash("state-success", "Статус успешно удален");
        $this->closeDelete();
    }

    protected function findModel(): ?OrderStateInterface
    {
        $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
        $state = $stateModelClass::find($this->stateId);
        if (! $state) {
            session()->flash("state-error", "Статус не найден");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $state;
    }

    protected function resetFields(): void
    {
        $this->reset(["stateId", "title", "slug", "key"]);
    }

    protected function checkAuth(string $action, OrderStateInterface $state = null): bool
    {
        try {
            $stateModelClass = config("product-variation.customOrderStateModel") ?? OrderState::class;
            $this->authorize($action, $state ?? $stateModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("state-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
