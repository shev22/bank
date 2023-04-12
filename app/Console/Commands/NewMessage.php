<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Livewire\ChatRepository\ChatRepository;

class NewMessage extends Command
{

    private $chatRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check for new messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChatRepository  $chatRepository)
    {
        parent::__construct();
        $this->chatRepository = $chatRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('start');
        $this->chatRepository::setNotification(255);
        $this->info('success');
    }
}
