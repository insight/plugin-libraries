
var PLUGIN = require('plugin/plugin');

exports.init = function(options) {
    
    options = options || {};

    // TODO: Load requested adapter and theme based on options
    
    PLUGIN.addCss({
        "package": module["package"],
        "path": "css/ext-all.css"
    });

    require('./adapter/ext/ext-base');
    require('./ext-all');

}


