Dojo Library
============

These instructions cover how to include dojo as part of a plugin.

Homepage: [http://dojotoolkit.org/](http://dojotoolkit.org/)

Release: [http://download.dojotoolkit.org/release-1.5.0/](http://download.dojotoolkit.org/release-1.5.0/)

Requirements
------------

  * UNIX
  * Command-line PHP
  * wget & unzip

These requirements are for the automatic dojo build wrapping script and can be relaxed if the script is patched accordingly.


Install
=======

package.json
------------

    {
        "mappings": {
            "dojo": {
                "catalog": "http://registry.pinf.org/cadorn.org/github/catalog.json",
                "name": "dojo",
                "revision": "master"
            }
        }
    }


Use
===

By default only the dojo base library is available. To include other dojo, dijit or dojox modules see below.

module.js
---------

    // require library at top of module
    var DOJO = require("dojo/dojo");

    // use library within module
    DOJO.init({
        afterOnLoad: true,
        parseOnLoad: false,
        isDebug: false,
        locale: "en-us"
    });
    // the "dojo" free variable is now available
    dojo.query("#content");


Documentation
-------------

See: [http://dojotoolkit.org/documentation](http://dojotoolkit.org/documentation)


Adding Dojo Modules
===================

Additional dojo, dijit or dojox modules are added by using a custom build layer.

Place the following into a file at _scripts/dojo.layers.profile.js_ in a plugin package.

    dependencies = {
        "layers": [
            {
                name: "../insight-plugin.js",
                resourceName: "insight-plugin",
                discard: false,
                dependencies: [
                    "dijit.form.Button"
                ]
            }
        ]
    }

Add all modules you require to the _dependencies_ property. For more information about the dojo build system see
[here](http://dojotoolkit.org/reference-guide/build/index.html#build-index).

A PHP script is provided as part of this package to build the _layer_:

    php scripts/build.php \<PATH_TO_PLUGIN_PACKAGE\>

The script will download dojo and call the build system appropriately. You must have an environment variable called
_PINF\_HOME_ set to _/pinf_ or some other directory. The dojo distribution will be saved to _PINF\_HOME/downloads/download.dojotoolkit.org/..._.

**NOTE:** The build script currently only works on UNIX and the _wget_ and _unzip_ commands must be available.

The build process generates files at _resources/dojo/insight-plugin/_ within the plugin package.

To load the optimized modules file use the following in a plugin module:

    var PLUGIN = require('insight-plugin-api/plugin');
    PLUGIN.loadResourceScript("dojo/insight-plugin/insight-plugin.js", function() {
        // setup dojo-based plugin
    });

Dojo contains a lot of files most of which are not needed in most cases. To avoid sending all these files to the client
a configuration setting can be used in the plugin's _package.json_ file.

    {
        "implements": {
            "cadorn.org/insight/@meta/plugin/0": {
                "resources": {
                    "paths": {
                        "/": "include",
                        "/dojo/": "lazy",
                        "/dojo/insight-plugin/insight-plugin.js": "include",
                        "/dojo/insight-plugin/insight-plugin.js.uncompressed.js": "exclude"
                    }
                }
            }
        }
    }

This will tell the plugin system to load all files in _/dojo/_ on demand except for the _/dojo/insight-plugin/insight-plugin.js_ file
which will be bundled with the plugin.

You can find an example plugin here: [https://github.com/firephp/ui-plugins/tree/master/packages/example-dojo/packages/page-top/](https://github.com/firephp/ui-plugins/tree/master/packages/example-dojo/packages/page-top/)


License
=======

Copyright (c) 2005-2010, The Dojo Foundation
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

  * Redistributions of source code must retain the above copyright notice, this
    list of conditions and the following disclaimer.
  * Redistributions in binary form must reproduce the above copyright notice,
    this list of conditions and the following disclaimer in the documentation
    and/or other materials provided with the distribution.
  * Neither the name of the Dojo Foundation nor the names of its contributors
    may be used to endorse or promote products derived from this software
    without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED.  IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
