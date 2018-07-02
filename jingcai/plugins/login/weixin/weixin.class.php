<?php
use think\Model; 
use think\Request;
class weixin extends Model{

	//回调地址
	public $return_url;
	public $app_id;
	public $app_secret;
	public function __construct($config){

        $config['app_id']="wx58d706410bdec59a";
        $config['app_secret']='fbd746b4b05651f5a9a6103db2a1de51';
        $this->return_url = "http://".$_SERVER['HTTP_HOST']."/index.php/Home/LoginApi/callback/oauth/weixin";
		$this->app_id = $config['app_id'];
		$this->app_secret = $config['app_secret'];


	}
	//构造要请求的参数数组，无需改动
	public function login(){

		$_SESSION['state'] = md5(uniqid(rand(), TRUE));
		//拼接URL
        $dialog_url="https://open.weixin.qq.com/connect/qrconnect?appid=".$this->app_id."&response_type=code&scope=snsapi_login&redirect_uri=".urlencode($this->return_url)."&state=".$_SESSION['state']."&type=wechat";

		echo("<script> top.location.href='" . $dialog_url . "'</script>");
		exit;
	}
        /**
         *
         * @return boolean
         */
	public function respon(){
		if($_REQUEST['state'] == $_SESSION['state'])
		{
			$code = $_REQUEST["code"];
			//拼接URL
            $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->app_id.'&secret='.$this->app_secret.'&code='.$code.'&grant_type=authorization_code';

			$response = $this->get_contents($token_url);
			if (strpos($response, "callback") !== false)
			{
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);
				if (isset($msg->error))
				{
					echo "<h3>error:</h3>" . $msg->error;
					echo "<h3>msg  :</h3>" . $msg->error_description;
					exit;
				}
			}

			//Step3：使用Access Token来获取用户的OpenID
			$params = array();
			parse_str($response, $params);
$params=json_decode($response,true);

            $graph_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->app_id.'&grant_type=refresh_token&refresh_token='.$params['refresh_token'];
			$str  = $this->get_contents($graph_url);
			if (strpos($str, "callback") !== false)
			{
				$lpos = strpos($str, "(");
				$rpos = strrpos($str, ")");
				$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
			}
			$user = json_decode($str);
			if (isset($user->error))
			{
				echo "<h3>error:</h3>" . $user->error;
				echo "<h3>msg  :</h3>" . $user->error_description;
				exit;
			}
			//获取到openid
			$openid = $user->openid;
                        // Step5：使用Access Token以及OpenID来访问和修改用户数据

            $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$params['access_token'].'&openid='.$openid.'&lang=zh_CN';
                        $res  = $this->get_contents($user_info_url);
                        $res = json_decode($res,true);                                                 
			$_SESSION['state'] = null; // 验证SESSION
			
		
			return array(
				'openid'=>$openid,// weixin openid
				'oauth'=>'weixin',
				'nickname'=>$res['nickname'],
				'unionid'=>$res['unionid'],
				'sex'=>$res['sex'],
				'head_pic'=>$res['headimgurl']
			);
		}else{
			return false;
		}
	}


	public function get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$response =  curl_exec($ch);
		curl_close($ch);

		//-------请求为空
		if(empty($response)){
			exit("50001");
		}

		return $response;
	}

}


?>

