<?php
namespace common\components\helpers;

use yii\helpers\Json;
use common\components\module\APIClient;
use yii\httpclient\Client;
use Yii;
use yii\helpers\ArrayHelper;

class SegmentHelper {
    
    const STATUS_CREATING = 0;
    const STATUS_CREATED = 1;
    
    /**
     * Returns the name of status for current model
     * 
     * @property string $status
     * @return string $name
     */
    public static function getStatusType(int $status = null): string {
        switch ($status) {
            case static::STATUS_CREATED:
                $name = Yii::t('app', 'Created');
                break;
            default:
                $name = Yii::t('app', 'Creating');
                break;
        }
        return $name;
    }
    
    /**
     * Returns the number of records with status 0
     * 
     * @return integet $count
     */
    public static function getCountCreatingSegments(): int {
        $command = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `tv_segment` WHERE `status` = :status");
        $command->bindValue(':status', 0);
        $count = $command->queryScalar();
        return $count;
    }
    
    /**
     * Returns the valid mail target token
     * 
     * @return string $response
     */
    public static function getValidMailToken(): string {
        $client = new Client(['baseUrl' => 'https://target.my.com/api/v2/oauth2/token.json']);
        $request = $client->createRequest()->setMethod('POST');
        $request->setData([
            'client_id' => APIClient::MAIL_CLIENT_ID,
            'client_secret' => APIClient::MAIL_CLIENT_SECRET,
            'grant_type' => 'refresh_token',
            'refresh_token' => APIClient::MAIL_REFRESH_TOKEN
        ]);
        $response = $request->send();
        $token = Json::decode($response->content, false);
        return ArrayHelper::getValue($token, 'access_token');
    }
}