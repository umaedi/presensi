<?php

namespace App\Jobs;

use App\Services\PresensiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdatepresensiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 2 * 60 * 60;
    protected $presensi;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($presensi, $data)
    {
        $this->presensi = $presensi;
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
            $presensiService->update($this->presensi, $this->data);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
