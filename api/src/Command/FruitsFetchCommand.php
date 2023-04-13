<?php

namespace App\Command;

use App\Entity\Fruit;
use App\Entity\FruitNutrition;
use App\Service\EmailService;
use App\Service\FruitNutritionService;
use App\Service\FruitService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'Fetch Fruits',
)]
class FruitsFetchCommand extends Command
{

    private SymfonyStyle $io;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly FruitService $fruitService,
        private readonly FruitNutritionService $fruitNutritionService,
        private readonly EmailService $emailService,
        private readonly ParameterBagInterface $parameterBag,
        string  $name = null
    )
    {
        parent::__construct($name);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $fruits = $this->fetchFruitsFromAPI();

        $this->importFruitsIntoDatabase($fruits);

        $this->sendEmailToAdmin();

        return Command::SUCCESS;
    }

    private function fetchFruitsFromAPI(): array
    {
        $response = $this->client->request('GET', $this->parameterBag->get('fruity_get_all_api'));
        return json_decode($response->getContent(false), true);
    }

    private function importFruitsIntoDatabase(array $fruits): void
    {
        $importedCount = 0;
        foreach ($fruits as $fruit) {
            $id = $fruit['id'] ?? null;
            $fruitEntity = $this->fruitService->find($id);

            if (is_null($fruitEntity)) {
                $name = $fruit['name'] ?? '';

                $fruitEntity = new Fruit();
                $fruitEntity->setId($id);
                $fruitEntity->setName($name);
                $fruitEntity->setFamily($fruit['family'] ?? null);
                $fruitEntity->setOrder($fruit['order'] ?? null);
                $fruitEntity->setGenus($fruit['genus'] ?? null);
                $this->fruitService->save($fruitEntity, true);

                $fruitNutritionEntity = new FruitNutrition();
                $fruitNutritionEntity->setCalories($fruit['nutritions']['calories'] ?? null);
                $fruitNutritionEntity->setFat($fruit['nutritions']['fat'] ?? null);
                $fruitNutritionEntity->setSugar($fruit['nutritions']['sugar'] ?? null);
                $fruitNutritionEntity->setCarbohydrates($fruit['nutritions']['carbohydrates'] ?? null);
                $fruitNutritionEntity->setProtein($fruit['nutritions']['protein'] ?? null);
                $fruitNutritionEntity->setFruit($fruitEntity);
                $this->fruitNutritionService->save($fruitNutritionEntity, true);

                $importedCount++;
                $this->io->writeln("Fruit {$name} #{$id} imported.");
            } else {
                $this->io->writeln("Fruit {$id} already existed.");
            }
        }

        if ($importedCount > 0) {
            $this->io->success($importedCount . ' fruit(s) imported successfully.');
        } else {
            $this->io->warning('No fruit imported.');
        }
    }

    private function sendEmailToAdmin(): void
    {
        $subject = 'Fruits Fetched Successfully';
        $from = $this->parameterBag->get('email')['from'];
        $to = $this->parameterBag->get('email')['to'];

        $this->emailService->sendEmail($from, $to, $subject, $subject);
    }
}
