<?php

namespace App\Console\Commands;

use App\Services\Cart\CartService;
use Illuminate\Console\Command;

class ClearExpiredCarts extends Command
{
    protected $signature = 'carts:clear-expired';
    protected $description = 'Clear carts that have expired';

    protected CartService $cartService;

    /**
     * Create a new command instance.
     *
     * @param CartService $cartService
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        parent::__construct();
        $this->cartService = $cartService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->cartService->clearExpiredCarts();
        $this->info('Expired carts cleared successfully.');

        return 0;
    }
}
