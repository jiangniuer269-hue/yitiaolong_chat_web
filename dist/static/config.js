
//仅在打包前配置生效，打包后修改地址请在dist/static/js/app.xxx.js内修改
'use strict'
this.BASE_API = "http://"+window.location.hostname+":2006";
this.WEBSOCKET_URL = "ws://imws.eixsuk.cn";
this.NODE_ENV = "pro";
this.HOST = "http://imp.eixsuk.cn";
this.gconfig = {
  BASE_API: BASE_API,
  WEBSOCKET_URL: WEBSOCKET_URL,
  NODE_ENV: NODE_ENV,
  HOST: HOST,//微信授权域名
  GUIDE:{
    text:"",
    link:" "
  }
}
