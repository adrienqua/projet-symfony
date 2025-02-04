<?php
namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateCategoryCommand extends Command
{
    protected static $defaultName = 'doittogether:make:category';

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('doittogether:make:category')
            ->setDescription('Crée une nouvelle catégorie');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $nameQuestion = new Question('Nom de la catégorie : ');
        $name = $io->askQuestion($nameQuestion);

        $descQuestion = new Question('Description de la catégorie : ');
        $description = $io->askQuestion($descQuestion);

        $category = new Category();
        $category->setName($name)
                ->setDescription($description);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $io->success("Catégorie '$name' créée avec succès !");

        return Command::SUCCESS;
    }
}