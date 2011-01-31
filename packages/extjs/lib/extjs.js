
var PLUGIN = require('plugin/plugin');

exports.init = function(options) {
    
    options = options || {};

    // TODO: Load requested adapter and theme based on options
    
    PLUGIN.addCss({
        "package": module["package"],
        "path": "css/ext-all.css"
    });

    // NOTE: This file is patched!
    require('./adapter/ext/ext-base-debug');

    require('./plugins/event-based-ajax');
    require('./ext-all-debug');
    require('./plugins/dom-observer');

}

exports.loadPlugins = function(names, callback) {
    for( var i in names ) {
        if(names[i]=="file-upload-field") {
            PLUGIN.addCss({
                "package": module["package"],
                "path": "css/plugins/" + names[i] + ".css"
            });
        }
        names[i] = "./plugins/" + names[i];
    }
    require(names, function() {
        callback();
    });
}
