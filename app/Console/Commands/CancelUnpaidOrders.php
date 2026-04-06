<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CancelUnpaidOrders extends Command
{
    protected $signature = 'orders:cancel-unpaid';
    protected $description = 'Cancel orders that are unpaid for more than 24 hours';

    public function handle()
    {
        $orders = Order::where('status', 'pending')
            ->where('payment_status', 'pending')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->get();

        foreach ($orders as $order) {
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            // Kembalikan stok
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $this->info("Order {$order->order_number} has been cancelled.");
        }
    }
}