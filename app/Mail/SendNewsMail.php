<?php

namespace App\Mail;

use App\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	protected $news ;
    public function __construct(News $news)
    {
        $this->news = $news; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.news',[
			'new'=>$this->news 
		])
		->subject($this->news->getTitle())
		->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
		// ->to('asalahdev5@gmail.com');		
    }
}
