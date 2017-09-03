<?php


namespace BRT\BlogBundle\Command;

use BRT\BlogBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminUserCommand extends ContainerAwareCommand {


    protected function configure()
    {

        $this->setName("brt:blogbundle:new-admin")
            ->setDescription("Crerate new admin user if not exists")
            ->setHelp("This command allow you create the first user in the blogbundle system.")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $container  = $this->getContainer();
        $em         = $container->get('doctrine')->getManager();

        $existsAdmin = $em->getRepository('BRTBlogBundle:User')->findBy(["username" => "admin"]);

        if($existsAdmin){
            $output->writeln(["El usuario admin ya existe en la base de datos"]);
            return;
        }

        $passwordText = "123456";
        $user = new User();

        $user->setName("Admin");
        $user->setUsername("admin");
        $user->setCreated(new \DateTime());
        $user->setPassword($container->get('security.password_encoder')->encodePassword($user,$passwordText));
        $user->setAdmin(1);
        $user->setEmail("admin@email.com");

        $output->writeln(["Usuario creado: admin@email.com ", "", "Password: $passwordText"]);


        $em->persist($user);
        $em->flush();


    }

}