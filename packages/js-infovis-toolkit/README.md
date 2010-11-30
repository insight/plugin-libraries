JavaScript InfoVis Toolkit Library
==================================

This package contains the JavaScript InfoVis Toolkit library as a [CommonJS](http://www.commonjs.org/) package.

Homepage: [http://thejit.org/](http://thejit.org/)

Release: [http://thejit.org/downloads/Jit-2.0.0b.zip](http://thejit.org/downloads/Jit-2.0.0b.zip)


Install
=======

package.json
------------

    {
        "mappings": {
            "js-infovis-toolkit": {
                "catalog": "http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json",
                "name": "js-infovis-toolkit",
                "revision": "master"
            }
        }
    }


Use
===

module.js
---------

    // require library at top of module
    var JIT = require('js-infovis-toolkit/jit');

    // use library within module
    JIT.*

Notes
-----

For the library to correctly set the dimensions of the canvas area for the visualization the DOM must have rendered before
the JIT methods are called. This is because the canvas dimensions are based on the containing element dimensions which are not available until after
the DOM has rendered.

It is thus recommended to use this library together with the [jQuery](http://github.com/insight/plugin-libraries/blob/master/packages/jquery/) library.
    
    var JQUERY = require('jquery/jquery').jQuery;
    var JIT = require('js-infovis-toolkit/jit');
    
    exports.main = function() {
    
        // "content" is the root HTML element (body) to put markup into
        JQUERY("#content").html('<div id="infovis"></div>');
    
        // wait for the DOM
        JQUERY(function() {
        
            //init BarChart
            barChart = new JIT.BarChart({
              //id of the visualization container
              injectInto: 'infovis',
              ...
            });
            
            ...
        });    
    }


Documentation
-------------

See: [http://thejit.org/docs/](http://thejit.org/docs/)


License
=======

    /*
      Copyright (c) 2010, Nicolas Garcia Belmonte
      All rights reserved
    
      > Redistribution and use in source and binary forms, with or without
      > modification, are permitted provided that the following conditions are met:
      >      * Redistributions of source code must retain the above copyright
      >        notice, this list of conditions and the following disclaimer.
      >      * Redistributions in binary form must reproduce the above copyright
      >        notice, this list of conditions and the following disclaimer in the
      >        documentation and/or other materials provided with the distribution.
      >      * Neither the name of the organization nor the
      >        names of its contributors may be used to endorse or promote products
      >        derived from this software without specific prior written permission.
      >
      >  THIS SOFTWARE IS PROVIDED BY NICOLAS GARCIA BELMONTE ``AS IS'' AND ANY
      >  EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
      >  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
      >  DISCLAIMED. IN NO EVENT SHALL NICOLAS GARCIA BELMONTE BE LIABLE FOR ANY
      >  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
      >  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
      >  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
      >  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
      >  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
      >  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */
