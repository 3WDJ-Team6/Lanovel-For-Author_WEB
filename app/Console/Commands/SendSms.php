<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use AWS;

# aws를 이용하여 문자 보내기 
# handle부분을 글이 댓글이 달릴 때 호출 (sns 수신 여부)
# php artisan send:sms +82전화번호 할말 (띄워쓰기X)

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms {phonenum} {body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $phonenum = $this->argument('phonenum');
        $body = $this->argument('body');
        $sns = AWS::createClient('Sns');
        $sns->publish(['Message' => $body, 'PhoneNumber' => $phonenum]);
    }
}
