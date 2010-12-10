Observable Library
==================

These instructions cover how to include the observable library.

Homepage: [https://github.com/cadorn/observable-js](https://github.com/cadorn/observable-js)


Install
=======

package.json
------------

    {
        "mappings": {
            "observable": {
                "catalog": "http://registry.pinf.org/cadorn.org/github/catalog.json",
                "name": "observable",
                "revision": "master"
            }
        }
    }


Use
===

module.js
---------

    // require library at top of module
    var OBSERVABLE = require("observable/observable");

    // use library within module
    var Store = function() {
        OBSERVABLE.mixin(this);
    }
    Store.prototype.save = function() {
        this.publish("saved", arg1, arg2);
    }
    var store = new Store();
    store.subscribeTo("saved", function(arg1, arg2) {
    });
    

Documentation
-------------

See: [https://github.com/cadorn/observable-js](https://github.com/cadorn/observable-js)


License
=======

Copyright (c) 2009 Nathan Stott <[nathan.whiteboard-it.com](http://nathan.whiteboard-it.com/)\>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to
deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
sell copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
