<?php

namespace Database\Seeders;

use App\Driver\File\Contracts\FileSystemInterface;
use App\Models\Avatar;
use App\Models\Factories\FileType;
use App\Models\User;
use App\Repositories\Contracts\PositionRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Prompts\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;

class UserSeeder extends Seeder
{
    private const USER_COUNT = 45;

    private Collection $positions;

    private ProgressBar $progressBar;

    public function __construct(
        private PositionRepositoryInterface $positionRepository,
        private FileSystemInterface $fileSystem,
        private ConsoleOutput $output
    ) {
        $this->positions = $this->positionRepository->get();
        $this->progressBar = new ProgressBar($this->output);
    }

    public function run(): void
    {
        $this->createUsers();
    }

    private function createUsers(): void
    {
        $this->progressBar->start(self::USER_COUNT);

        for ($i = 0; $i < self::USER_COUNT; $i++) {
            $this->generateFakeAvatar(
                User::factory()->create([
                    'position_id' => $this->positions->random(1)->first()->id,
                ])
            );
            $this->progressBar->advance();
        }

        $this->progressBar->finish();
        $this->output->writeln(' Users generated');
    }

    private function generateFakeAvatar(User $user): void
    {
        $avatarRandomName = $this->getRandomImageName();
        $fakeAvatar = new UploadedFile(
            Storage::disk('fake')->path('/images') . '/' . $avatarRandomName,
            $avatarRandomName,
            'image/jpeg'
        );

        /** @var Avatar $uploadedAvatar */
        $uploadedAvatar = $this->fileSystem->uploadFile(FileType::AVATAR, $fakeAvatar);
        $user->avatar()->save($uploadedAvatar);
    }

    private function getRandomImageName(): string
    {
        return sprintf(
            'image-%s.jpg',
            random_int(1, 15)
        );
    }
}
