jQuery Library
==============

This package contains the jQuery library as a [CommonJS](http://www.commonjs.org/) package.

Homepage: http://jquery.com/

Release: v1.4.4


Install
=======

package.json
------------

    {
        "mappings": {
            "jquery": {
                "catalog": "http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json",
                "name": "jquery",
                "revision": "master"
            }
        }
    }


Use
===

module.js
---------

    // require library at top of module
    var JQUERY = require('jquery/jquery').jQuery;

    // use library within module
    JQUERY("#content").html("Hello World");

Documentation
-------------

See: http://docs.jquery.com/


License
=======

    /*!
     * jQuery JavaScript Library v1.4.4
     * http://jquery.com/
     *
     * Copyright 2010, John Resig
     * Dual licensed under the MIT or GPL Version 2 licenses.
     * http://jquery.org/license
     *
     * Includes Sizzle.js
     * http://sizzlejs.com/
     * Copyright 2010, The Dojo Foundation
     * Released under the MIT, BSD, and GPL Licenses.
     *
     * Date: Thu Nov 11 19:04:53 2010 -0500
     */
