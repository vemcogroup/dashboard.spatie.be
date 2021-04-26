<?php

namespace App\Tiles\IssueTracking;

use Spatie\Dashboard\Models\Tile;

class IssueTrackingStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName('issue_tracking');
    }

    public function setPackagistTotals(array $totals): self
    {
        $this->tile->putData('packagistTotals', $totals);

        return $this;
    }

    public function packagistTotals(): array
    {
        return $this->tile->getData('packagistTotals') ?? [];
    }

    public function packagistMonthly(): int
    {
        return $this->packagistTotals()['monthly'] ?? 0;
    }

    public function packagistTotal(): int
    {
        return $this->packagistTotals()['total'] ?? 0;
    }
}
