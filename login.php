<?php

		function is_weixin()
		{
		    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
		        return true;
		    }
		    return false;
		}
		
    try {
        $type = $_GET['type'];
        $id = $_GET['id'];
        $rd = $_GET['rd'];
        if(is_weixin()){
        	 $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx368c3a7ffbf69d33&redirect_uri=http://sxwl.qilin.cfovip.org/redirect.php?type='.$type.'%26id='.$id.'%26rd='.$rd.'&response_type=code&scope=snsapi_userinfo';
        	echo "<SCRIPT LANGUAGE=\"JavaScript\">location.href='$url'</SCRIPT>";
        }else{
        	$url = 'http://139.9.227.101:12222/auth/domain';
		    $header = [
		        'X-Domain:2653165'
		    ];
		    $ch = curl_init ();
		
		    curl_setopt ( $ch, CURLOPT_URL, $url );
		
		    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
		
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		    $file_contents = curl_exec ( $ch );
		
		    curl_close ( $ch );
		
		    $s=str_replace('"', '', $file_contents);
    
        	$url = $s.'/contact.php?type='.$type.'&id='.$id;
            echo "<SCRIPT LANGUAGE=\"JavaScript\">location.href='$url'</SCRIPT>";
        }
       
    } catch (Exception $e) {
        echo $e->getMessage();
        // die(); // 终止异常
    }
