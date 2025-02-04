<?php
namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class EditCategoryCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('doittogether:edit:category')
            ->setDescription('Édite une catégorie existante');
    }

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $io->section('Catégories disponibles :');
        foreach ($categories as $category) {
            $io->writeln($category->getName());
        }

        $categoryName = $io->ask('Nom de la catégorie à modifier : ');
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);

        if (!$category) {
            $io->error('Catégorie non trouvée');
            return Command::FAILURE;
        }

        $newName = $io->ask('Nouveau nom (laisser vide pour garder l\'actuel) : ', $category->getName());
        $newDesc = $io->ask('Nouvelle description (laisser vide pour garder l\'actuelle) : ', $category->getDescription());

        $category->setName($newName)->setDescription($newDesc);

        $this->entityManager->flush();

        $io->success("Catégorie modifiée avec succès !");
        return Command::SUCCESS;
    }
}
