document.addEventListener("plusready",  function()
{
    var B = window.plus.bridge;
    var yim = 
    {
        "openLive":function(live_id,successCallback, errorCallback){
        	if (mui.os.ios) {
                var success = typeof successCallback !== 'function' ? null : function(args) {
                    successCallback(args);     
                },

                fail = typeof errorCallback !== 'function' ? null : function(code) {
                    errorCallback(code);
                };

                callbackID = B.callbackId(success, fail);
                return B.exec('yim', "openLive", [callbackID, live_id]);
                          
        	} else if (mui.os.android) {
        	    return B.exec("yim", "openLive", [live_id]);	
        	}            
        }
    };
    window.plus.yim = yim;
}, true);