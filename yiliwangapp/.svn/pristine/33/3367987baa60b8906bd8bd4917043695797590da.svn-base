function update() {
	plus.runtime.getProperty(plus.runtime.appid,function(inf){
		var wget_version = inf.version;
		var version = plus.runtime.version;
		var url = base_url + 'napi/update';
		mui.ajax(url, {
			data: {
				"platform": mui.os.ios ? 'ios' : 'android',
				"version": version,
				"wget_version": wget_version
			},
			dataType: "json",
			type: "post",
			timeout: 10000, //超时时间设置为10秒；
			success: function(res) {
				if(res.success) {
					if(res.data.is_update == 1) {
						plus.nativeUI.confirm('检查到新的版本，请升级更新，以免导致应用不可用', function(event) {
							if(0 == event.index) {
								plus.runtime.openURL(res.data.update_url);
							}
						}, '软件升级更新', ["立即更新"]);
					} else if(res.data.is_update == 2) {
						downWgt(res.data.update_url);
					}
				}
			},
			error: error
		});
	});
}

function downWgt(wgtUrl){
	plus.nativeUI.showWaiting("正在更新资源包,请稍候");
	plus.downloader.createDownload( wgtUrl, {filename:"_doc/update/"}, function(d,status){
		if ( status == 200 ) {
			plus.runtime.install(d.filename,{},function(){
				var msg = '资源包更新完成';
				if (mui.os.ios) {
					msg = '资源包更新完成，点击确定退出应用，再手动重启LG Hausys';
				}
			plus.nativeUI.alert(msg,function(){
				    plus.nativeUI.closeWaiting();
				    if (mui.os.ios) {
				    	plus.runtime.quit();
				    } else if (mui.os.android) {
				    	plus.runtime.restart();
				    }
				});
			},function(e){
				plus.nativeUI.closeWaiting();
				plus.nativeUI.alert("资源包安装失败！["+e.code+"]："+e.message);
			});
		} else {
			plus.nativeUI.alert("下载资源包失败！");
		}
		plus.nativeUI.closeWaiting();
	}).start();
}

if(mui.os.plus) {
	mui.plusReady(update);
}