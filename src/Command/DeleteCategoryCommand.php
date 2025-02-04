<?php
namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteCategoryCommand extends Command
{
   protected function configure(): void
   {
       $this
           ->setName('doittogether:delete:category')
           ->setDescription('Supprime une catégorie');
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
     array_walk($categories, fn($category) => $io->writeln($category->getName()));

     $categoryName = $io->ask('Nom de la catégorie à supprimer : ');
     $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);

     if (!$category) {
          $io->error('Catégorie non trouvée');
          return Command::FAILURE;
     }

     $this->entityManager->remove($category);
     $this->entityManager->flush();

     $io->success("Catégorie supprimée avec succès !");
     return Command::SUCCESS;
}
}