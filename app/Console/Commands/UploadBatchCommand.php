<?php

namespace App\Console\Commands;

use App\Services\RecordUpdateService;
use Illuminate\Console\Command;

class UploadBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload-batch-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Batch to the API service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new RecordUpdateService();

        $service->uploadService();
    }
}
