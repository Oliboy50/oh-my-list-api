<?php

namespace App\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppGetTokenCommand extends Command
{
    protected static $defaultName = 'app:get-token';

    private $userProvider;
    private $tokenManager;

    public function __construct(
        UserProviderInterface $userProvider,
        JWTTokenManagerInterface $tokenManager
    )
    {
        $this->userProvider = $userProvider;
        $this->tokenManager = $tokenManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $user = $this->userProvider->loadUserByUsername($input->getArgument('email'));

        $token = $this->tokenManager->create($user);

        echo $token . PHP_EOL;
    }
}
