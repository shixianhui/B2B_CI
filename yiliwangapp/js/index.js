var base_url = 'https://www.chinaeli.com/index.php/';
/*var base_url = 'https://www.modoge.com/yiliwang_xcx/index.php/';*/
var network = true;
if(window.plus) {
	if(window.plus.isReady) {
		console.log('plus');
		if(plus.networkinfo.getCurrentType() == plus.networkinfo.CONNECTION_NONE) {
			network = false;
		}
	} else {
		console.log('noplus');
		mui.plusReady(function() {
			if(plus.networkinfo.getCurrentType() == plus.networkinfo.CONNECTION_NONE) {
				network = false;
			}
		});
	}
}

function is_network(is_alert) {
	if(window.plus && window.plus.isReady) {
		if(plus.networkinfo.getCurrentType() == plus.networkinfo.CONNECTION_NONE) {
			network = false;
		} else {
			network = true;
		}
		if(is_alert) {
			if(!network) {
				mui.confirm('世界最遥远的距离莫过于断网，请检查网络设置', '温馨提示', ['设置', '取消'], function(e) {
					if(e.index == 0) {
						if(mui.os.ios) {
							plus.runtime.launchApplication({
								action: 'App-Prefs:root=WIFI'
							}, function(e) {}); //WIFI
						} else {
							var main = plus.android.runtimeMainActivity();
							var Intent = plus.android.importClass("android.content.Intent");
							var mIntent = new Intent('android.settings.WIFI_SETTINGS');
							main.startActivity(mIntent);
						}
					}
				});
				return false;
			}
		}
	} else {
		mui.plusReady(function() {
			if(plus.networkinfo.getCurrentType() == plus.networkinfo.CONNECTION_NONE) {
				network = false;
			} else {
				network = true;
			}
			if(is_alert) {
				if(!network) {
					mui.confirm('世界最遥远的距离莫过于断网，请检查网络设置', '温馨提示', ['设置', '取消'], function(e) {
						if(e.index == 0) {
							if(mui.os.ios) {
								plus.runtime.launchApplication({
									action: 'App-Prefs:root=WIFI'
								}, function(e) {}); //WIFI
							} else {
								var main = plus.android.runtimeMainActivity();
								var Intent = plus.android.importClass("android.content.Intent");
								var mIntent = new Intent('android.settings.WIFI_SETTINGS');
								main.startActivity(mIntent);
							}
						}
					});
					return false;
				}
			}
		});
	}
	
	return true;
}

function hint_network() {
	mui.confirm('世界最遥远的距离莫过于断网，请检查网络设置', '温馨提示', ['设置', '取消'], function(e) {
		if(e.index == 0) {
			if(mui.os.ios) {
				plus.runtime.launchApplication({
					action: 'App-Prefs:root=WIFI'
				}, function(e) {}); //WIFI
			} else {
				var main = plus.android.runtimeMainActivity();
				var Intent = plus.android.importClass("android.content.Intent");
				var mIntent = new Intent('android.settings.WIFI_SETTINGS');
				main.startActivity(mIntent);
			}
		}
	});
}

var error = function(xhr, type, errorThrown) {
	if(type == 'timeout') {
		mui.toast('请求网络超时，请再次尝试');
	} else if(type == 'parsererror') {
		mui.toast('服务器返回数据格式错误');
	} else {
		if (network == true) {
			mui.toast('网络不给力，请检查网络');
		}
	}
	if(window.plus) {
		mui.toast('网络不给力，请检查网络');
		if(window.plus.isReady) {
			plus.nativeUI.closeWaiting();
		} else {
			mui.plusReady(function() {
				plus.nativeUI.closeWaiting();
			});
		}
	}
};
var aniShow = "pop-in";
//只有ios支持的功能需要在Android平台隐藏；
if(mui.os.android) {
	var list = document.querySelectorAll('.ios-only');
	if(list) {
		for(var i = 0; i < list.length; i++) {
			list[i].style.display = 'none';
		}
	}
	//Android平台暂时使用slide-in-right动画
	if(parseFloat(mui.os.version) < 4.4) {
		aniShow = "slide-in-right";
	}
}
//星级选定
function set_star(ele_id, val) {
	mui("#" + ele_id).each(function(i, n) {
		var is_select = this.getAttribute('mui-icon mui-icon-star-filled');
		if(i < val) {
			if(!is_select) {
				$(this).attr('class', 'mui-icon mui-icon-star-filled');
			}
		} else {
			if(!is_select) {
				$(this).attr('class', 'mui-icon mui-icon-star');
			}
		}
	});
}

function get_file_name(url) {
	var start_len = url.lastIndexOf("/");
	var end_len = url.indexOf('?');
	if (end_len < 0) {
		return url.substring(start_len+1);
	} else {
		return url.substr(start_len + 1, end_len - start_len-1);
	}
}

function go_to_login() {
	if (mui.os.plus) {
		var top_url = plus.webview.getTopWebview().getURL();
		if (get_file_name(top_url) != 'login.html') {
			go_to_active('login.html');
		}
	} else {
		go_to_active('login.html');
	}
}
