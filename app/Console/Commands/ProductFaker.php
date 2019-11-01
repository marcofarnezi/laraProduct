<?php

namespace App\Console\Commands;

use App\Jobs\ProductFakerJob;
use Illuminate\Console\Command;

class ProductFaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:products {times : integer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new faker product 1000 per time- Parameter{times : integer}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $times = $this->argument('times');
        for ($i = 0; $i < $times; $i++) {
            dispatch(new ProductFakerJob());
        }
    }
}
