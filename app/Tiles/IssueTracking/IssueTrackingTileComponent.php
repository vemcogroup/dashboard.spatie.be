<?php

namespace App\Tiles\IssueTracking;

use Livewire\Component;

class IssueTrackingTileComponent extends Component
{
    public string $position;

    public function mount(string $position): void
    {
        $this->position = $position;
    }

    public function render()
    {
        $store = IssueTrackingStore::make();

        // TODO: put back
        //  "knplabs/github-api": "^2.4",
        return view('components.tiles.issue_tracking', [
            'packagistMonthly' => $store->packagistMonthly(),
            'packagistTotal' => $store->packagistTotal(),
        ]);
    }
}
