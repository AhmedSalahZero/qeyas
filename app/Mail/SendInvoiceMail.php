<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name ;
    protected $email ;
    protected $token ;
    protected $order ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name , $email , $token , $order = null)
    {
        $this->name= $name ;
        $this->email= $email ;
        $this->token= $token ;
        // $this->course = $course ;
        $this->order = $order ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@stc-eg.com')->subject('Course Invoice Link')->view('emails.sendInvoice')
            ->with([
                'name'=>$this->name  ,
                'email'=>$this->email ,
                'order'=>$this->order,
                'token'=>$this->token
            ]);



    }
}
