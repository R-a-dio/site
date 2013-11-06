R/a/dio - https://r-a-d.io
==========================

R/a/dio's site, open-sourced. This is a heavy work in progress.

[![Build Status](https://travis-ci.org/R-a-dio/site.png?branch=develop)](https://travis-ci.org/R-a-dio/site)


Why? I thought you were doing it in python?
------------------------------------------

We've been "doing it in python" for over a year now. The current implementation is pretty shockingly coded (but hey, it works), and a few decisions for the site were "interesting" (read: horribly insecure if the code was open-sourced), so we've never had it on github.

So [@hirotothefish](https://twitter.com/hirotothefish) (Hiroto) decided to completely redo the site from scratch.

Libraries
---------

The site backend is built on Laravel.

The HTML/CSS/JS side of things has a bunch of libraries:

- Bootstrap3
- History.js
- Ajaxify.js
- jQuery ScrollTo
- jQuery (of course)

tl;dr of these is that they make two very important things (music playing while browsing á la SoundCloud, and the actual design) really bloody easy.

Alpha + Beta
----

The staging area (beta) for changes due for live is at https://r-a-d.io/dev/

The development area (unstable, will often be a 500 error) is at http://radio.hiroto.eu/


Issues
------

Create an issue here if you experience problems with the site when it has launched (until then, keep them to critical-looking bugs in the beta site).

To contact the dev(s), ping Hiroto on IRC (#R/a/dio @ irc.rizon.net) or on Twitter [@hirotothefish](https://twitter.com/hirotothefish)

Installing
----------

1. Install [Vagrant][vagrant] and [VirtualBox][vbox]
2. clone this repository
3. `vagrant up` inside the repository
4. `vagrant ssh` into the VM
5. `cd /vagrant` and `bash install.sh`

R/a/dio is now running at http://localhost:8080


Credits
-------

The original creators of the r/a/dio site are [@Bevinsky](https://github.com/Bevinsky) and [@Wessie](https://github.com/Wessie).

Occasional theme-hacker and freedom-hater is [@9001](https://github.com/9001) (aka Tripflag, ed)


## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## License

R/a/dio is licensed under the [MIT License](http://opensource.org/licenses/MIT). Optionally you can use the [BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)



[vagrant]: https://www.vagrantup.com
[vbox]: https://virtualbox.org

