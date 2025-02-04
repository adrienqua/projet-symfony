<?php
namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportCategoriesCommand extends Command
{
   protected function configure(): void
   {
       $this
           ->setName('doittogether:export:categories')
           ->setDescription('Exporte les catégories en CSV');
   }

   public function __construct(private EntityManagerInterface $entityManager)
   {
       parent::__construct();
   }

   protected function execute(InputInterface $input, OutputInterface $output): int
   {
       $io = new SymfonyStyle($input, $output);
       
       $categories = $this->entityManager->getRepository(Category::class)->findAll();
       
       $csvContent = "ID,Nom,Description,Nombre d'offres,Nombre de tâches\n";
       
       foreach ($categories as $category) {
           $csvContent .= sprintf(
               "%d,%s,%s,%d,%d\n",
               $category->getId(),
               str_replace(',', ';', $category->getName()),
               str_replace(',', ';', $category->getDescription()),
               $category->getOffers()->count(),
               $category->getTasks()->count()
           );
       }

       $filename = 'categories_export_' . date('Y-m-d_His') . '.csv';
       file_put_contents($filename, $csvContent);

       $io->success("Export terminé : $filename");
       return Command::SUCCESS;
   }
}