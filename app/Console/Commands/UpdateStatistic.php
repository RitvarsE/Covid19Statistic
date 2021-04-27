<?php

namespace App\Console\Commands;

use App\Services\StatisticService;
use Illuminate\Console\Command;

class UpdateStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating covid19 statistic';
    /**
     * @var StatisticService
     */
    private $statisticService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StatisticService $statisticService)
    {
        parent::__construct();
        $this->statisticService = $statisticService;
    }


    public function handle()
    {
         $this->statisticService->update();
    }
}
