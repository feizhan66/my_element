/**
 * Created by 小猴子 on 2018/2/1.
 */


// 这个是当前的网址
var url = encodeURIComponent(window.location.href);

$.ajax({
    type : "get",
    url : "http://jiafa.feizhan.me/wechat_share/weChatShare.php?url="+url,//替换网址，xxx根据自己jssdk文件位置修改
    dataType : "jsonp",
    jsonp: "callback",
    jsonpCallback:"success_jsonpCallback",
    success : function(data){
        wx.config({
            debug: true,
            appId: data.appId,
            timestamp: data.timestamp,
            nonceStr: data.nonceStr,
            signature: data.signature,
            jsApiList: [
                "onMenuShareTimeline", //分享给好友
                "onMenuShareAppMessage", //分享到朋友圈
                "onMenuShareQQ", //分享到QQ
                "onMenuShareWeibo" //分享到微博
            ]
        });
    },
    error:function(data){
        // var dd = JSON.stringify(data);
        alert('微信签名失败');
    }
});


wx.ready(function (){
    var shareData = {
        title: wechat_share_title,
        desc: wechat_share_desc,//这里请特别注意是要去除html
        link: wechat_share_link,
        imgUrl: wechat_share_imgUrl
    };
    wx.onMenuShareAppMessage(shareData);
    wx.onMenuShareTimeline(shareData);
    wx.onMenuShareQQ(shareData);
    wx.onMenuShareWeibo(shareData);
});