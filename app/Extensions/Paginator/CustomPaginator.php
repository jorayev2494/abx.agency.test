<?php

declare(strict_types=1);

namespace App\Extensions\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
    private string $dataKey = 'data';

    public function setDataKey(string $dataKey): self
    {
        $this->dataKey = $dataKey;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'page' => $this->currentPage(),
            'total_pages' => $this->lastPage(),
            "total_$this->dataKey" => $this->total(),
            'count' => $this->perPage(),
            'links' => [
                'prev_url' => $this->linkCollection()->first()['url'] ?? null,
                'next_url' => $this->linkCollection()->last()['url'] ?? null,
            ],
            $this->dataKey => $this->items->toArray(),
        ];
    }
}