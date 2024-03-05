<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use App\Services\PresensiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PresensiupdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 2 * 60 * 60;
    protected $presensiUpdate;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($presensiUpdate, $data)
    {
        $this->presensiUpdate = $presensiUpdate;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PresensiService $presensiService)
    {
        try {
            $presensiService->update($this->presensiUpdate, $this->data);
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
