ExtJS Library
=============

These instructions cover how to include ExtJS as part of a plugin.

Homepage: [http://www.sencha.com/products/js/](http://www.sencha.com/products/js/)

Release: 3.3.1


Install
=======

package.json
------------

    {
        "mappings": {
            "jquery": {
                "catalog": "http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json",
                "name": "extjs",
                "revision": "master"
            }
        }
    }


Use
===

module.js
---------

    // require library at top of module
    require('extjs/adapter/ext/ext-base');
    require('extjs/ext-all');

    // use library within module


Documentation
-------------

See: [http://dev.sencha.com/deploy/dev/docs/](http://dev.sencha.com/deploy/dev/docs/)


License
=======

Ext JS - JavaScript Library
Copyright (c) 2006-2010, Sencha Inc.
All rights reserved.
licensing@sencha.com

http://www.sencha.com/license

Open Source License
------------------------------------------------------------------------------------------
Ext JS is licensed under the terms of the Open Source GPL 3.0 license. 

http://www.gnu.org/licenses/gpl.html

There are several FLOSS exceptions available for use with this release for
open source applications that are distributed under a license other than the GPL.

* Open Source License Exception for Applications

  http://www.sencha.com/products/floss-exception.php

* Open Source License Exception for Development

  http://www.sencha.com/products/ux-exception.php


Commercial License
------------------------------------------------------------------------------------------
This is the appropriate option if you are creating proprietary applications and you are 
not prepared to distribute and share the source code of your application under the 
GPL v3 license. Please visit http://www.sencha.com/license for more details.


OEM / Reseller License
------------------------------------------------------------------------------------------
For more details, please visit: http://www.sencha.com/license.

--

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT OF THIRD-PARTY INTELLECTUAL PROPERTY RIGHTS.  See the GNU
General Public License for more details.
