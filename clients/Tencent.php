<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\authclient\clients;

use yii\authclient\OAuth2;
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

    public $format = 'json';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('user/get_user_info.' . $this->format, 'GET');
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'qq';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return '腾讯QQ';
    }
}
