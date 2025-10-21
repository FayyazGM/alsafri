<?php 


namespace App\Helpers;

class WhatsappHelper
{
    public static function sendWhatsappTemplateMessage($to, $templateName, array $bodyParameters = [])
    {
        $from = '353899699245';
        $messageId = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 26);

        $url = "https://app.itelservices.net/whatsapp/v2/message/template";

        // Build parameter objects if provided
        $params = [];
        foreach ($bodyParameters as $param) {
            $params[] = [
                "type" => "text",
                "text" => $param
            ];
        }

        $payloadArray = [
            "messageId" => $messageId,
            "from" => $from,
            "to" => $to,
            "template" => [
                "name" => $templateName,
                "language" => ["code" => "EN"],
            ]
        ];

        // Only add 'components' if we have parameters
        if (!empty($params)) {
            $payloadArray["template"]["components"] = [[
                "type" => "body",
                "parameters" => $params
            ]];
        }

        $payload = json_encode($payloadArray);

        $headers = [
            "Content-Type: application/json",
            "Authorization: {" . env('WHATSAPP_API_KEY') . "}" // Store securely in .env
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return $err
            ? ['success' => false, 'message' => $err]
            : ['success' => true, 'response' => json_decode($response, true)];
    }
}

