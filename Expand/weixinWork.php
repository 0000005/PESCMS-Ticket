<?php

namespace Expand;

/**
 * 企业微信接口
 */
class weixinWork {

    public $access_token = '';
    private $corpid, $AgentId, $Secret, $error;

    public function __construct() {
        $weixinWork_api = json_decode(\Core\Func\CoreFunc::$param['system']['weixinWork_api'], true);
        if(empty($weixinWork_api['corpid']) || empty($weixinWork_api['AgentId'])){
            $this->error = '未配置企业微信接口信息';
            return false;
        }
        //企业ID
        $this->corpid = $weixinWork_api['corpid'];
        //应用序号
        $this->AgentId = $weixinWork_api['AgentId'];
        //应用Secret
        $this->Secret = $weixinWork_api['Secret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('weixinWork_access_token');
        if(empty($result)){
            $result = (new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->corpid}&corpsecret=$this->Secret");

            if(empty($result)){
                $this->error = '获取企业微信access_token失败';
                return false;
            }
            $FileCache->creatCache('weixinWork_access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            $this->error = '解析企业微信access_token失败';
            return false;
        }
    }

    /**
     * 通知对应的微信号
     * @param $param 发送内容
     */
    public function send_notice($param) {
        if(!empty($this->error)){
            \Model\Extra::errorSendResult($param['send_id'], $this->error);
            return false;
        }

        $result = json_decode((new cURL())->init("https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$this->access_token}", json_encode([
            "touser" => $param['send_account'],
            "msgtype" => "text",
            "agentid" => $this->AgentId,
            "text" => [
                "content" => $param['send_content']
            ]
        ])), true);

        //发送成功，删除消息
        if($result['errmsg'] == 'ok'){
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->delete([
                'send_id' => $param['send_id']
            ]);
        }else{
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
                'noset' => [
                    'send_id' => $param['send_id']
                ],
                'send_result' => $result['errmsg']
            ]);
        }
    }

    /**
     * 企业微信用户登录授权页面
     * @deprecated 废弃
     */
    public function agree($redirect_uri, $scope = 'snsapi_base'){
        $url = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->corpid}&redirect_uri={$url}&response_type=code&scope=SCOPE&agentid={$this->AgentId}&state=STATE#wechat_redirect";
    }

}