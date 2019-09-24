<?php
namespace common\components\module;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Description of APIClient
 *
 */
class APIClient extends \yii\httpclient\Client {
    
    /**
     * API current token
     * @var string
     */
    protected $access_token;
    
    /**
     * API yandex url
     */
    const API_YANDEX_URL = 'https://api-audience.yandex.ru/v1/management';
    
    /**
     * API mail url
     */
    const API_MAIL_URL = 'https://target.my.com/api/v2/remarketing';
    
    /**
     * API yandex audience token
     */
    const YANDEX_TOKEN = 'AQAAAAAHsj9ZAAUZ0p91mC8XYkGbmywDRudMl88';
    
    /**
     * API mail target client id
     */
    const MAIL_CLIENT_ID = 'LJRu00ZCkJeRfZSa';
    
    /**
     * API mail target client secret key
     */
    const MAIL_CLIENT_SECRET= 'yfWX8CuwxHF48JyW9mkKNGj4ResBrzXr08ipKRUvdOtU04e0Fw5PMnTJA9ygVL0yuKPmrziQiGTU5D7OSG8v0niaXdXAMsEAwHIgcKEPlkbUKZJN85GD7HCerCPhbW4aLYDrGunk9kHG6oIiuvpIEyGTjdk6FtTD3TgaWsjjXsmzqUqliwR4sFpl3pQMclDtJngkvTNeWGd9kDiT';
    
    /**
     * API mail target refresh token
     */
    const MAIL_REFRESH_TOKEN= 'fP4ZUKHxAtJmu0NKkKyEhz1WfT5I6MXTLftojLtubCwuQoWvBSGVxRfC5UBFI9EWa89AdjPEEs37WFRXRBeVoEyP7bVlFD32loOR5SGIGgryAaxy1z0NmyRabDMrIhDfdsgucHYKJ1tqlpdTizs4dYD9OfPrRJX99qwYfVdkUCJ2a20Lm1jPU8z2HFnPdpQCCIn4eZub4naDCLq4Dm7woCXGiAbd845wn4qogbZTvG9S5e8qfDe0UVfRoslc3';
    
    /**
     * @param string $token access token
     */
    public function __construct(string $token = '', string $base_url = '')
    {
        $this->setAccessToken($token);
        $this->setBaseUrl($base_url);
    }
    
    /**
     * @param string $access_token
     *
     * @return self
     */
    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }
    
    /**
     * @param string $base_url
     *
     * @return self
     */
    public function setBaseUrl(string $base_url)
    {
        $this->baseUrl = $base_url;
        return $this;
    }
    
    
    /**
     * Get all segments
     *
     * @return 
     */
    public function getSegments()
    {
        $response = $this->get('segments', null, [
            'Authorization' => 'Bearer '.$this->access_token
        ])->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * Get current segment
     *
     * @return 
     */
    public function getSegment(int $id = null, string $name = '')
    {
        $request = $this->createRequest()->setMethod('PUT')->setUrl('segment/'.$id);
        $request->setFormat(self::FORMAT_JSON);
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $request->setData(['segment' => ['name' => $name]]);
        $response = $request->send();
        return ArrayHelper::getValue(Json::decode($response->content, false), 'segment');
    }
    
    /**
     * 
     *
     * @return 
     */
    public function sendSegmentFile(string $title = '', string $filename = '')
    {
        $request = $this->createRequest()
                ->setMethod('POST')
                ->setUrl('segments/upload_csv_file')
                ->addFile('file', $filename);
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $request->setData(['name' => $title,]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * 
     *
     * @return 
     */
    public function segmentConfirm(int $id = null, string $name = '')
    {
        $request = $this->createRequest()->setMethod('POST')->setUrl('segment/'.$id.'/confirm');
        $request->setFormat(self::FORMAT_JSON);
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $request->setData([
            'segment' => [
                'name' => $name,
                'hashed' => 0,
                'content_type' => 'mac'
            ]
        ]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * 
     *
     * @return 
     */
    public function deleteSegment(int $id = null)
    {
        $request = $this->createRequest()->setMethod('DELETE')->setUrl('segment/'.$id);
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * Get current user list
     *
     * @return 
     */
    public function getUserList(int $id = null)
    {
        $request = $this->createRequest()->setUrl('users_lists/'.$id.'.json');
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * 
     *
     * @return 
     */
    public function sendUserListFile(string $title = '', string $filename = '')
    {
        $request = $this->createRequest()->setFormat(self::FORMAT_JSON)
                ->setMethod('POST')
                ->setUrl('users_lists.json')
                ->addFile('file', $filename);
       
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $request->setData(['data' => Json::encode(['name' => $title, 'type' => 'mac'])]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }
    
    /**
     * 
     *
     * @return 
     */
    public function deleteUserList(int $id = null)
    {
        $request = $this->createRequest()->setMethod('DELETE')->setUrl('users_lists/'.$id.'.json');
        $request->setHeaders(['Authorization' => 'Bearer '.$this->access_token]);
        $response = $request->send();
        return Json::decode($response->content, false);
    }    
}
