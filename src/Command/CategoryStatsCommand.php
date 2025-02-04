<?php
namespace App\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CategoryStatsCommand extends Command
{
   protected function configure(): void
   {
       $this
           ->setName('doittogether:stats:category')
           ->setDescription('Affiche les statistiques des catégories');
   }

   public function __construct(private EntityManagerInterface $entityManager)
   {
       parent::__construct();
   }

   protected function execute(InputInterface $input, OutputInterface $output): int
   {
       $io = new SymfonyStyle($input, $output);
       $categories = $this->entityManager->getRepository(Category::class)->findAll();

       $totalOffers = 0;
       $totalTasks = 0;
       $statsPerCategory = [];

       foreach ($categories as $category) {
           $offers = $category->getOffers()->count();
           $tasks = $category->getTasks()->count();
           
           $totalOffers += $offers;
           $totalTasks += $tasks;

           $statsPerCategory[] = [
               'name' => $category->getName(),
               'offers' => $offers,
               'tasks' => $tasks
           ];
       }

       $io->title('Statistiques DoItTogether');
       $io->section('Résumé global');
       $io->table(
           ['Métrique', 'Valeur'],
           [
               ['Nombre de catégories', count($categories)],
               ['Total des offres', $totalOffers],
               ['Total des tâches', $totalTasks],
               ['Moyenne offres/catégorie', round($totalOffers / count($categories), 2)],
               ['Moyenne tâches/catégorie', round($totalTasks / count($categories), 2)]
           ]
       );

       $io->section('Détails par catégorie');
       $io->table(
           ['Catégorie', 'Offres', 'Tâches'],
           array_map(fn($stat) => [$stat['name'], $stat['offers'], $stat['tasks']], $statsPerCategory)
       );

       return Command::SUCCESS;
   }
}