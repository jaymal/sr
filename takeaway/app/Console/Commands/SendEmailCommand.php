<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SendmailService;


class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {payload*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send transactional emails from CLI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command with arguments in the following order
     * to => arg 1,email=>arg2 ,subject =>arg3,
     * message_text=>arg4,token=>arg 5, mailable=>arg6(mailable file name)
     *
     * @return mixed
     */
    public function handle(SendmailService $sendMailService)
    {
        $this->info('....Sending');
        $input = $this->arguments()['payload'];
        

        $data['to'] = $input[0];
        $data['email'] = $input[1];
        $data['subject'] = $input[2];
        $data['message_text'] = $input[3];
        $data['token'] = $input[4];
        $data['mailable'] = $input[5];

        $result = $sendMailService->sendMail( $data );

        $this->info('Message Sent Successfully!');
    }
}
