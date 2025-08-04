<?php

namespace App\Command;

use App\Repository\CharacterRepository;
use App\Repository\NemesisRepository;
use App\Repository\SecretRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-entities',
    description: 'A temporary command to test if Doctrine entities are mapped correctly.',
)]
class TestEntitiesCommand extends Command
{
    public function __construct(
        private readonly CharacterRepository $characterRepository,
        private readonly NemesisRepository $nemesisRepository,
        private readonly SecretRepository $secretRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // --- TEST 1: Fetch a single, simple entity ---
        $io->section('Test 1: Fetching a single Character');
        $character = $this->characterRepository->findOneBy([]);

        if (!$character) {
            $io->error('FAILED: Could not find any Character in the database.');
            return Command::FAILURE;
        }

        $io->writeln('Found Character: ' . $character->getName());
        $io->writeln('  - Ability: ' . $character->getAbility());
        $io->writeln('  - Born on: ' . $character->getBorn()->format('Y-m-d'));
        $io->success('SUCCESS: Basic character fetching and data type mapping works.');


        // --- TEST 2: Test the One-to-Many relationship (Character -> Nemesis) ---
        $io->section('Test 2: Testing Character to Nemesis relationship (OneToMany)');
        $nemesises = $character->getNemeses();

        if ($nemesises->isEmpty()) {
            $io->warning(sprintf('NOTE: Character "%s" does not have any Nemesises. The relationship mapping might still be correct.', $character->getName()));
        } else {
            $io->writeln(sprintf('Character "%s" has %d Nemesises:', $character->getName(), count($nemesises)));
            foreach ($nemesises as $nemesis) {
                $io->writeln(sprintf('  - Nemesis ID: %d, Is Alive: %s', $nemesis->getId(), $nemesis->isIsAlive() ? 'Yes' : 'No'));
            }
            $io->success('SUCCESS: OneToMany relationship from Character to Nemesis works.');
        }


        // --- TEST 3: Test the Many-to-One relationship (Secret -> Nemesis) ---
        $io->section('Test 3: Testing Secret to Nemesis relationship (ManyToOne)');
        $secret = $this->secretRepository->findOneBy([]);

        if (!$secret) {
            $io->error('FAILED: Could not find any Secret in the database.');
            return Command::FAILURE;
        }

        $nemesisFromSecret = $secret->getNemesis();

        if (!$nemesisFromSecret) {
            $io->error(sprintf('FAILED: Secret ID %d has a NULL Nemesis, but the column is NOT NULL. Check mapping!', $secret->getId()));
            return Command::FAILURE;
        }

        $io->writeln(sprintf('Secret with code "%s" belongs to Nemesis ID %d.', $secret->getSecretCode(), $nemesisFromSecret->getId()));
        $io->success('SUCCESS: ManyToOne relationship from Secret to Nemesis works.');


        // --- TEST 4: Test the full chain ---
        $io->section('Test 4: Testing the full relationship chain (Secret -> Nemesis -> Character)');
        $characterFromSecret = $nemesisFromSecret->getCharacter();

        if (!$characterFromSecret) {
             $io->error(sprintf('FAILED: Nemesis ID %d has a NULL Character. Check mapping or data!', $nemesisFromSecret->getId()));
            return Command::FAILURE;
        }

        $io->writeln(sprintf('The Nemesis (ID %d) of this secret belongs to Character: %s', $nemesisFromSecret->getId(), $characterFromSecret->getName()));
        $io->success('ALL TESTS PASSED! Your entity mapping appears to be correct.');

        return Command::SUCCESS;
    }
}
