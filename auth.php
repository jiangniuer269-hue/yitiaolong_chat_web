<?php

		function is_weixin()
		{
		    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
		        return true;
		    }
		    return false;
		}
		
    try {
        $authcode = $_GET['authcode'];
        $id = $_GET['id'];
        if(is_weixin()){//yingyi.chat.xuechengyuan.org   wx91a64d9fcd78fd79
        	 $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1a5441ac3f4385ac&redirect_uri=http://qunchen.xuechengyuan.org/authredirect.php?authcode='.$authcode.'%26id='.$id.'&response_type=code&scope=snsapi_userinfo';
        	echo "<SCRIPT LANGUAGE=\"JavaScript\">location.href='$url'</SCRIPT>";
        }else{
            echo "请使用微信扫码";
        }
       
    } catch (Exception $e) {
        echo $e->getMessage();
        // die(); // 终止异常
    }
