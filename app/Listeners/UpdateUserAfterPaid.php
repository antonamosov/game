<?php

namespace App\Listeners;

use App\Events\UserPaid;
use App\Models\Cart;
use App\Models\Pack;
use App\Models\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserAfterPaid
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserPaid  $event
     * @return void
     */
    public function handle(UserPaid $event)
    {
        $carts = $event->user->Carts()->notPaid()->get();
        foreach ($carts as $cart) {
            $items = json_decode($cart->data);
            foreach ($items as $item) {
                if ($item->type === 'pack') {
                    $event->user->Packs()->attach($item->id);
                }
                else {
                    $product = Product::find($item->id);
                    $event->user->addCoins($product->coins);
                }
            }
            $cart->update([
                'status' => Cart::STATUS_PAID
            ]);
        }
    }
}
