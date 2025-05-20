<?php

namespace GIS\ProductVariation\Livewire\Admin\ProductVariations;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Interfaces\ProductVariationInterface;
use GIS\ProductVariation\Models\ProductVariation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public ProductInterface $product;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public float $price = 0;
    public float|null $oldPrice = null;
    public bool $sale = false;
    public string $sku = "";
    public string $title = "";

    public int|null $variationId = null;

    public function rules(): array
    {
        $uniqueCondition = "unique:product_variations,sku";
        if ($this->variationId) $uniqueCondition .= ",{$this->variationId}";
        return [
            "price" => ["required", "numeric", "min:0"],
            "oldPrice" => ["nullable", "numeric", "min:0"],
            "sku" => ["nullable", "string", "max:150", $uniqueCondition],
            "title" => ["nullable", "string", "max:150"]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "price" => "Цена",
            "oldPrice" => "Цена без скидки",
            "sku" => "SKU",
            "title" => "Заголовок",
        ];
    }

    public function render(): View
    {
        $variations = $this->product->variations()
            ->orderBy("sku")
            ->get();
        return view("pv::livewire.admin.product-variations.list-wire", compact("variations"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
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

        $this->product->variations()->create([
            "price" => $this->price,
            "old_price" => $this->oldPrice,
            "sale" => $this->sale ? now() : null,
            "sku" => $this->sku,
            "title" => $this->title,
        ]);

        session()->flash("variation-success", "Вариация успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $variationId): void
    {
        $this->resetFields();
        $this->variationId = $variationId;
        $variation = $this->findModel();
        if (! $variation) { return; }
        if (! $this->checkAuth("update", $variation)) { return; }

        $this->price = $variation->price;
        $this->oldPrice = $variation->old_price;
        $this->sale = (bool) $variation->sale;
        $this->sku = $variation->sku;
        $this->title = $variation->title;

        $this->displayData = true;
    }

    public function update(): void
    {
        $variation = $this->findModel();
        if (! $variation) { return; }
        if (! $this->checkAuth("update", $variation)) { return; }
        $this->validate();

        $variation->update([
            "price" => $this->price,
            "old_price" => $this->oldPrice,
            "sale" => $this->sale ? now() : null,
            "sku" => $this->sku,
            "title" => $this->title,
        ]);

        session()->flash("variation-success", "Вариация успешно обновлена");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $variationId): void
    {
        $this->resetFields();
        $this->variationId = $variationId;
        $variation = $this->findModel();
        if (! $variation) { return; }
        if (! $this->checkAuth("delete", $variation)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $variation = $this->findModel();
        if (! $variation) { return; }
        if (! $this->checkAuth("delete", $variation)) { return; }

        try {
            $variation->delete();
            session()->flash("variation-success", "Вариация успешно удалена");
        } catch (\Exception $exception) {
            session()->flash("variation-error", "Ошибка при удалении вариации");
        }

        $this->closeDelete();
    }

    public function switchPublish(int $variationId): void
    {
        $this->resetFields();
        $this->variationId = $variationId;
        $variation = $this->findModel();
        if (! $variation) { return; }
        if (! $this->checkAuth("update", $variation)) { return; }

        $variation->update([
            "published_at" => $variation->published_at ? null : now(),
        ]);
    }

    protected function findModel(): ?ProductVariationInterface
    {
        $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
        $variation = $variationModelClass::find($this->variationId);
        if (! $variation) {
            session()->flash("variation-error", "Вариация не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $variation;
    }

    protected function resetFields(): void
    {
        $this->reset(["variationId", "price", "oldPrice", "sale", "sku", "title"]);
    }

    protected function checkAuth(string $action, ProductVariationInterface $variation = null): bool
    {
        try {
            $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
            $this->authorize($action, $variation ?? $variationModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("variation-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
