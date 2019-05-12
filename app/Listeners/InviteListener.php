<?php

namespace App\Listeners;

use App\Events\InviteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteListener
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
     * @param  InviteEvent  $event
     * @return void
     */
    public function handle(InviteEvent $event)
    {
        //
    }
    /**
    * Handle a job failure.
    *
    * @param  \App\Events\OrderShipped  $event
    * @param  \Exception  $exception
    * @return void
    */
   public function failed(OrderShipped $event, $exception)
   {
       //
   }
}
