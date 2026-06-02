<?php

namespace App\Jobs;

use App\Models\Event;
use App\Services\IdCardGeneratorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateIdCardPdf implements ShouldQueue
{
    use Queueable;

    public $event;

    /**
     * Buat instance job baru.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Jalankan job.
     */
    public function handle(): void
    {
        $service = new IdCardGeneratorService();
        $pdf = $service->generate($this->event);
        
        $filename = "id-cards-" . $this->event->id . "-" . time() . ".pdf";
        Storage::disk('public')->put("pe/pdf/{$filename}", $pdf->output());
        
        // TODO: Perbarui sistem notifikasi nanti untuk memberi tahu user bahwa PDF siap diunduh.
    }
}
