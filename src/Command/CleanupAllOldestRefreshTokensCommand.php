<?php

namespace App\Command;

use App\Repository\FcmTokenRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:Cleanup-all-oldest-refresh-tokens',
    description: 'This command removes the entire oldest refresh token for all users minus the newest one. ' .
    'ATTENTION ! For large quantities, query the database',
)]
class CleanupAllOldestRefreshTokensCommand extends Command
{
    public function __construct(
      private readonly FcmTokenRepository $fcmTokenRepository,
    ) {
        parent::__construct();

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->fcmTokenRepository->removeAllOldestToken();

        $io->success('Removing the oldest refresh tokens was successful');

        return Command::SUCCESS;
    }
}
