<?php

namespace App\Console\Commands;

use App\Models\Contacts\BaseRecordStatus;
use App\Models\Payments\LeadsPayment;
use App\Models\Projects\Project;
use App\Models\User;
use Illuminate\Console\Command;

class ConfirmLeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirms leads older then 48 hours';

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
        BaseRecordStatus::where('status', BaseRecordStatus::STATUS_LEAD)
            ->where('freezed', false)
            ->where('confirmed', false)
            ->where('created_at', '<=', now()->subDays(2))
            ->chunk(1000, function ($leads) {
                /** @var BaseRecordStatus $lead */
                foreach ($leads as $lead) {
                    $lead->payForLead();
                }
            });
    }
}
