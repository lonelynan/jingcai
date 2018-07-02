<?php
// 名称 Wechat第三方开发者
namespace app\home\Controller;
use think\Controller;

class Wechat1 extends Controller {
	
	protected $AppID 		= ''; 	// AppID(应用ID)	
	protected $AppSecret 	= ''; 	// AppSecret
    protected $Token 		= ''; 	// 微信后台填写的TOKEN
    protected $Crypt 		= '';   // 消息加密KEY（EncodingAESKey）
	/*
	 微信第三方开发者模式 使用方法
	 服务器地址	： http://你的域名/index.php/Wx/wechat.html
	 Token		： 自己定义
	 AppID		： 微信公众账户后台的AppID
	 AppSecret	： 微信公众账户后台的AppSecret
	 Crypt		： 微信公众账户后台的EncodingAESKey
	 */
	public function wechat(){
		// 第三方发送消息给公众平台
		$options = array(
				'token'				=> $this->Token, 		// 填写你设定的key
				'encodingaeskey'	=> $this->Crypt,
				'appid'				=> $this->AppID,
				'appsecret'			=> $this->AppSecret,
				'debug'				=> false,
				'logcallback'		=> false,
			);
		import("@.Library.wechat");
		$weObj = new \Wechat($options);
		$weObj->valid();
		$type = $weObj->getRev()->getRevType();
		//设置菜单
		$newmenu =  array(
			"button"=>
				array(
					array('type'=>'view','name'=>'客户案例','url'=>'http://www.vmonsion.com'),
					array('name'=>'我的','sub_button'=>array(
							array('type'=>'view','name'=>'我的网站','url'=>'http://www.vmonsion.com'),
							array('type'=>'view','name'=>'个人资料','url'=>'http://www.vmonsion.com'),
						)
					),
					array('type'=>'view','name'=>'关于我们','url'=>'http://www.vmonsion.com/index.php'),
					)
			);
		// 公众号菜单更新
		//$weObj->getMenu($newmenu);
		$weObj->createMenu($newmenu);
		//$weObj->deleteMenu($newmenu);

		//分解数据获得常用字段
        //$this->openid 	= $weObj->getRev()->getRevFrom();
        $this->type 	= $weObj->getRev()->getRevType();
        $this->data 	= $weObj->getRev()->getRevData();
		$content = '[捂脸]'.$weObj->getRev()->getRevContent();

		switch($type) {
			// 文本消息
			case \Wechat::MSGTYPE_TEXT:
					file_put_contents('test.txt','TextMessage',FILE_APPEND);
					$weObj->text($content)->reply();
					exit;
					break;
			// 图片消息
			case \Wechat::MSGTYPE_IMAGE:
					$weObj->text('This is a Picture?')->reply();
					break;
			// 位置消息
			case \Wechat::MSGTYPE_LOCATION:
					$weObj->text('what?GPS?')->reply();
					exit;
					break;
			// 连接消息
			case \Wechat::MSGTYPE_LINK:
					break;
			// 音乐消息
			case \Wechat::MSGTYPE_MUSIC:
					break;
			// 图文消息（推送过来的应该不存在这种类型，但是可以给用户回复该类型消息）
			case \Wechat::MSGTYPE_NEWS:
					break;
			// 音频消息
			case \Wechat::MSGTYPE_VOICE:
					break;
			// 视频消息
			case \Wechat::MSGTYPE_VIDEO:
					break;
			// 短视频
			case \Wechat::MSGTYPE_SHORTVIDEO:
					break;
			//事件消息:五种
			case \Wechat::MSGTYPE_EVENT:
					$event = $weObj->getRev()->getRevEvent();
					$reply = $this->messageEvent($event);
					break;
			default:
					$weObj->text("你好,我是微信小助手,很高兴为您服务~")->reply();
		}
	}
	// Wechat事件处理
	public function messageEvent($event){
		switch($event) {	
			// 订阅		
			case \Wechat::EVENT_SUBSCRIBE:
				break; 
			// 取消订阅	
			case \Wechat::EVENT_UNSUBSCRIBE:
				break;
			// 扫描带参数二维码		
			case \Wechat::EVENT_SCAN:
				break;  
			// 上报地理位置     	
			case \Wechat::EVENT_LOCATION:
				break;
			// 菜单 - 点击菜单跳转链接 	
			case \Wechat::EVENT_MENU_VIEW:
				break;
			// 菜单 - 点击菜单拉取消息
			case \Wechat::EVENT_MENU_CLICK:
				break;
			// 菜单 - 扫码推事件(客户端跳URL)	
			case \Wechat::EVENT_MENU_SCAN_PUSH:
				break;
			// 菜单 - 扫码推事件(客户端不跳URL)
			case \Wechat::EVENT_MENU_SCAN_WAITMSG:
				break;
			// 菜单 - 弹出系统拍照发图
			case \Wechat::EVENT_MENU_PIC_SYS:
				break;
			// 菜单 - 弹出拍照或者相册发图
			case \Wechat::EVENT_MENU_PIC_PHOTO:
				break;
			// 菜单 - 弹出微信相册发图器
			case \Wechat::EVENT_MENU_PIC_WEIXIN:
				break;
			// 菜单 - 弹出地理位置选择器
			case \Wechat::EVENT_MENU_LOCATION:
				break;
			default:
					break;
		}
	}
	
	/* 微信登录验证，可以选择方法一（静默授权）或者方法二（用户手动授权）
	   1、设置微信公众号的菜单，访问 http://你的域名/index.php/Wx/checkLogin.html 
	   2、返回redirect_uri的授权域名，获取$_GET['code']
	   3、通过code换取网页授权access_token和openID
	   4、function loginWx() 就是最终获取数据的方法
	 */ 	
	public function checkLogin(){
		// 方法一 Scope为snsapi_base基本授权
		$result = $this->_baseAuth("http://www.kodjr.com/index.php/Wx/loginWx.html");
		
		// 方法二 Scope为snsapi_userinfo用户授权
		//$result = $this->_userInfoAuth("http://www.kodjr.com/index.php/Wap/loginWx.html");
	}
	
	// 验证是否邦定帐号了
	public function loginWx(){
		$code = $_GET['code'];
		// 方法一
		$tokenOpenID = $this->_baseToken($code);
		///dump($tokenOpenID);
		// 设置session
		if(!session('user_wechat_auth')){
			session('user_wechat_auth', $tokenOpenID);
		}else{
				
		}	
		// 方法二
		//$userData = $this->_userInfoToken($code);
		//$userInfo = $this->_getUserInfo($userData['access_token'],$userData['openid']);			
	}
	
	
	// 方法一：Scope为snsapi_base基本授权
	public function _baseAuth($redirect_url){  
		// 1.准备scope为snsapi_base网页授权页面  
		$baseurl = urlencode($redirect_url);  
		$snsapi_base_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->AppID.'&redirect_uri='.$baseurl.'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';  
		// 2.静默授权,获取code 
		$code = $_GET['code'];
		if( !isset($code) ){  
			header('Location:'.$snsapi_base_url);  
		}
	}
	public function _baseToken($code){
		// 3.通过code换取网页授权access_token和openID  
		$curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->AppID.'&secret='.$this->AppSecret.'&code='.$code.'&grant_type=authorization_code';  
		$content = $this->http_curl($curl);  
		$result = json_decode($content[1],true);  
		$result['state'] = $content[0];
		return $result;  	
	}
	
	// 方法二：Scope为snsapi_userinfo用户授权
	public function _userInfoAuth($redirect_url){  
		//1.准备scope为snsapi_userInfo网页授权页面  
		$redirecturl = urlencode($redirect_url);  
		$snsapi_userInfo_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->AppID.'&redirect_uri='.$redirecturl.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';  
		//2.用户手动同意授权,同意之后,获取code  
		$code = $_GET['code'];  
		if( !isset($code) ){  
			header('Location:'.$snsapi_userInfo_url);  
		}  
	}
	public function _userInfoToken($code){
		//3.通过code换取网页授权access_token  
		$curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->AppID.'&secret='.$this->AppSecret.'&code='.$code.'&grant_type=authorization_code';  
		$content 			= $this->http_curl($curl);  
		$result = json_decode($content[1],true);  
		$result['state'] = $content[0];
		//4.通过access_token和openid拉取用户信息  
		$webAccess_token 	= $result->access_token;  
		$openid 			= $result->openid;  
		$userInfourl 		= 'https://api.weixin.qq.com/sns/userinfo?access_token='.$webAccess_token.'&openid='.$openid.'&lang=zh_CN ';  
		$recontent 			= $this->http_curl($userInfourl); 
		$userInfo 			= json_decode($recontent,true);  
		return $userInfo;  
	}  

	public function http_curl($url, $method='POST', $postfields = null, $headers = array(), $debug = false)
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);

            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));

            echo '=====$response=====' . "\r\n";
            print_r($response);
        }
        curl_close($ci);
        return array($http_code, $response);
    }

}