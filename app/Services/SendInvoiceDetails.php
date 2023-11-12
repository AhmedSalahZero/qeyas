<?php
namespace App\Services;

use App\Mail\SendInvoiceMail;
use App\Order;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Catch_;

class SendInvoiceService
{
    private $userName  , $payment_token , $userEmail  , $order;

    public function __construct($userName , $userEmail  , $payment_token , Order $order)
    {
        $this->userName = $userName ;
        $this->payment_token= $payment_token ;
        $this->userEmail= $userEmail ;
        $this->order = $order ;
    }
    public function execute()
    {
        try{
            Mail::to($this->userEmail)->send(new SendInvoiceMail($this->userName , $this->userEmail , $this->payment_token
        ,$this->order

        ));
        }
        catch(\Exception $e){}

    }
}
