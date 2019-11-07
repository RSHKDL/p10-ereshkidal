<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ArticleStatsCommand
 * @author ereshkidal
 */
class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';

    protected function configure(): void
    {
        $this
            ->setDescription('Returns some article stats!')
            ->addArgument('slug', InputArgument::REQUIRED, "The article's slug")
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'text')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');
        $data = [
            'slug' => $slug,
            'hearts' => random_int(10, 100),
        ];

        switch ($input->getOption('format')) {
            case 'text':
                $rows = [];
                foreach ($data as $key => $val) {
                    $rows[] = [$key, $val];
                }
                $io->table(['Key', 'Value'], $rows);
                break;
            case 'json':
                $io->text(\json_encode($data));
                break;
            default:
                throw new \Exception('Valid formats are text or json.');
        }

        return 0;
    }
}
