APF Library
===========

These instructions cover how to include APF (ajax.org) as part of a plugin.

Homepage: [https://github.com/ajaxorg/apf](https://github.com/ajaxorg/apf)

Release: [https://github.com/ajaxorg/apf/tree/master](https://github.com/ajaxorg/apf/tree/master)

**STATUS: APF layout and other stuff not working properly. Seemingly too much focus on Cloud9 IDE and not enough on framework itself.
Will wait until new APF release is available with updated docs.**


Requirements
------------

  * UNIX
  * Command-line PHP
  * wget & unzip
  * git
  * [nodejs](http://nodejs.org/)

These requirements are for the APF build process and automatic build warpping script.


Install
=======

package.json
------------

    {
        "mappings": {
            "apf": {
                "catalog": "http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json",
                "name": "apf",
                "revision": "master"
            }
        }
    }


Use
===

By default no APF functionality is available. To include modules you need to build APF (see below).

Documentation
-------------

Demos: [http://ui.ajax.org/#demos](http://ui.ajax.org/#demos)
Docs: [http://ui.ajax.org/#docs](http://ui.ajax.org/#docs)


Building APF
============

To use APF and it's modules you need to build it for your purposes.
    
    php scripts/build.php <PATH_TO_PLUGIN_PACKAGE>

**TODO**


License
=======

GNU LESSER GENERAL PUBLIC LICENSE

