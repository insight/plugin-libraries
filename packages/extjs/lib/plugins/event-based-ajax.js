
var EVENTS = require("plugin/events");

Ext.lib.Ajax = function(){
    var createComplete = function(cb){
         return function(xhr, status){
            if((status == 'error' || status == 'timeout') && cb.failure){
                cb.failure.call(cb.scope||window, createResponse(cb, xhr));
            }else if(cb.success){
                cb.success.call(cb.scope||window, createResponse(cb, xhr));
            }
         };
    };

    var createResponse = function(cb, xhr){
        var headerObj = {},
            headerStr,
            t,
            s;

        try {
            headerStr = xhr.getAllResponseHeaders();
            Ext.each(headerStr.replace(/\r\n/g, '\n').split('\n'), function(v){
                t = v.indexOf(':');
                if(t >= 0){
                    s = v.substr(0, t).toLowerCase();
                    if(v.charAt(t + 1) == ' '){
                        ++t;
                    }
                    headerObj[s] = v.substr(t + 1);
                }
            });
        } catch(e) {}

        return {
            responseText: xhr.responseText,
            responseXML : xhr.responseXML,
            argument: cb.argument,
            status: xhr.status,
            statusText: xhr.statusText,
            getResponseHeader : function(header){
                return headerObj[header.toLowerCase()];
            },
            getAllResponseHeaders : function(){
                return headerStr;
            }
        };
    };
    return {
        request : function(method, uri, cb, data, options){
            var o = {
                type: method,
                url: uri,
                data: data,
                timeout: cb.timeout,
                complete: createComplete(cb)
            };

            if(options){
                var hs = options.headers;
                if(options.xmlData){
                    o.data = options.xmlData;
                    o.processData = false;
                    o.type = (method ? method : (options.method ? options.method : 'POST'));
                    if (!hs || !hs['Content-Type']){
                        o.contentType = 'text/xml';
                    }
                }else if(options.jsonData){
                    o.data = typeof options.jsonData == 'object' ? Ext.encode(options.jsonData) : options.jsonData;
                    o.processData = false;
                    o.type = (method ? method : (options.method ? options.method : 'POST'));
                    if (!hs || !hs['Content-Type']){
                        o.contentType = 'application/json';
                    }
                }
                if(hs){
                    o.beforeSend = function(xhr){
                        for (var h in hs) {
                            if (hs.hasOwnProperty(h)) {
                                xhr.setRequestHeader(h, hs[h]);
                            }
                        }
                    };
                }
            }
            ajax(o);
        },

        formRequest : function(form, uri, cb, data, isUpload, sslUri){
            ajax({
                type: Ext.getDom(form).method ||'POST',
                url: uri,
                data: jQuery(form).serialize()+(data?'&'+data:''),
                timeout: cb.timeout,
                complete: createComplete(cb)
            });
        },

        isCallInProgress : function(trans){
            return false;
        },

        abort : function(trans){
            return false;
        },

        serializeForm : function(form){
            return jQuery(form.dom||form).serialize();
        }
    };
}();


function ajax(options) {

    // TODO: Monitor timeout

    EVENTS.dispatchHostEvent("ajax", {
        "type": options.type,
        "url": options.url,
        "data": options.data
    }, function(response) {

        // TODO: Fail by calling error callback

        options.complete({
            "getAllResponseHeaders": function() { return ""; },
            "status": response.status,
            "statusText": response.status,
            "responseText": response.body.join(""),
            "responseXML": ""
        });
    });
}
