<?php

namespace App\Console\Commands;

use App\Jobs\SendVaccinationReminder;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\File;
use App\Modules\V1\Models\VaccinationCycle;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thiss command is a testing';

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
     *
     * @return int
     */
    public function handle()
    {
        ActiveStatus::create(['name' => mt_rand(100, 1000)]);
    }
}
