<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AppCreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $encoder;
    private $em;
    private $validator;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    )
    {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->validator = $validator;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // create user
        $user = (new User())->setEmail($email = $input->getArgument('email'));
        $user->setPassword($this->encoder->encodePassword($user, $input->getArgument('password')));

        // validate user
        if (count($errors = $this->validator->validate($user))) {
            $io->error((string) $errors);
            return;
        }

        // persist user
        $this->em->persist($user->setRoles(['ROLE_ADMIN']));
        $this->em->flush();

        $io->success(sprintf('User [%s] is now ready to get its first JWT token!', $email));
    }
}
