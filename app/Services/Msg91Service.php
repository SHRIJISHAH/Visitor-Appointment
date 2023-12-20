<?php

namespace App\Services;

use GuzzleHttp\Client;

class Msg91Service
{
    protected $authKey;
    protected $senderId;
    protected $apiUrl = 'http://api.msg91.com/api/sendotp.php';

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        $this->senderId = config('services.msg91.sender_id');
    }

    public function sendOtp($mobileNumber, $otp)
    {
        $client = new Client();

        try {
            $message = sprintf('Your OTP code is: %s. Please use this OTP to proceed.', $otp);

            $response = $client->get($this->apiUrl, [
                'query' => [
                    'authkey' => $this->authKey,
                    'mobile' => $mobileNumber,
                    'message' => $message,
                    'sender' => $this->senderId,
                    'otp_length' => '6',
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            \Log::info('Msg91 API Response: ' . json_encode($body));

            if ($body['type'] === 'success') {
                return true;
            } else {
                \Log::error('Error sending OTP: ' . $body['message']);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Exception occurred while sending OTP: ' . $e->getMessage());
            return false;
        }
    }
}
