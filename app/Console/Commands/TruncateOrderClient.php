<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\ShopOrderProductExtra;
use Illuminate\Console\Command;

class TruncateOrderClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:truncate-order-client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::truncate();
        OrderProduct::truncate();
        ShopOrderProductExtra::truncate();
        OrderStatusHistory::truncate();
        Order::truncate();


    }
}
