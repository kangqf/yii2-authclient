<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\authclient\clients;

use yii\authclient\OAuth2;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * Tencent allows authentication via Tencent OAuth.
 * 腾讯互联的第三方登陆模块
 *
 * In order to use Tencent OAuth you must register your application at <http://connect.qq.com>.
 * 为了使用这个模块你应该在腾讯互联注册你的应用
 *
 * Example application configuration:
 * 下面是配置你的应用的一个例子，其中clientId是你在注册你的应用获得的appid，
 * clientSecret是你获得的密钥
 * ~~~
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'tencent' => [
 *                 'class' => 'yii\authclient\clients\Tencent',
 *                 'clientId' => 'github_client_id',
 *                 'clientSecret' => 'github_client_secret',
 *             ],
 *         ],
 *     ]
 *     ...
 * ]
 * ~~~
 *
 * @see http://wiki.connect.qq.com/
 * @see http://connect.qq.com/manage/index?apptype=web
 *
 * @author kangqingfei <kangqingfei@gmail.com> http://weibo.com/u/3227269845
 * @since 1.0
 */

class Tencent extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://graph.qq.com';


    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $openid =  $this->api('oauth2.0/me', 'GET');
        $userAttributes = $this->api("user/get_user_info", 'GET', ['oauth_consumer_key'=>$openid['client_id'], 'openid'=>$openid['openid']]);
        $userAttributes['openid']=$openid['openid'];
        return $userAttributes;
    }
	/**
     * @inheritdoc
     */
    protected function processResponse($rawResponse, $contentType = self::CONTENT_TYPE_AUTO) {
        if ($contentType == self::CONTENT_TYPE_AUTO) {
            if (strpos($rawResponse, "callback") === 0) {
                $lpos = strpos($rawResponse, "(");
                $rpos = strrpos($rawResponse, ")");
                $rawResponse = substr($rawResponse, $lpos + 1, $rpos - $lpos - 1);
                $rawResponse = trim($rawResponse);
                $contentType = self::CONTENT_TYPE_JSON;
            }
        }
        return parent::processResponse($rawResponse, $contentType);
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'tencent';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return '腾讯互联';
    }
}
