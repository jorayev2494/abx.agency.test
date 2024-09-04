<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Repositories\Contracts\PositionRepositoryInterface;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    private const POSITIONS = [
        'Lawyer',
        'Content manager',
        'Security',
        'Designer',
    ];

    public function __construct(
        private PositionRepositoryInterface $repository
    ) { }

    public function run(): void
    {
        foreach (self::POSITIONS as $position) {
            $this->repository->save(
                Position::factory()->make(['name' => $position])
            );
        }
    }
}
