<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AWS;

class SMSController extends Controller
{
    protected function sendSMS($phone_number)
    {
        $phone_number = +821033599220;

        $sms = AWS::createClient('sns');

        $sms->publish([
            'Message' => '현재 구독중인 작가님의 さくら荘のペットな彼女(이)가 업데이트 되었습니다.           -중쇄를 찍자-',
            'PhoneNumber' => $phone_number,
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType'  => [
                    'DataType'    => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],
        ]);
    }
}
