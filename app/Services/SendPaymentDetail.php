<?php
namespace App\Services;

use App\Mail\SendInvoiceMail;
use Illuminate\Support\Facades\Mail;

class SendPaymentDetail
{
    private $userName   , $userEmail , $course ;

    public function __construct($userName , $userEmail , $course  )
    {
        $this->userName = $userName ;
        $this->userEmail= $userEmail ;
        $this->course = $course ;
    }
    public function execute()
    {
        Mail::to($this->userEmail)->send(new SendInvoiceMail($this->userName , $this->userEmail , $this->payment_token ,
    $this->course

        ));

    }
}
