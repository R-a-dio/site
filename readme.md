R/a/dio - https://r-a-d.io
==========================

R/a/dio's site, open-sourced. This is a heavy work in progress.

[![Build Status](https://travis-ci.org/R-a-dio/radio.site.png?branch=develop)](https://travis-ci.org/R-a-dio/radio.site)


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

The staging area (beta) for changes due for live is at https://r-a-d.io/beta/

The development area (unstable, will often be a 500 error) is at https://r-a-d.io/dev/public/


Issues
------

Create an issue here if you experience problems with the site when it has launched (until then, keep them to critical-looking bugs in the beta site).

To contact the dev(s), ping Hiroto on IRC (#R/a/dio @ irc.rizon.net) or on Twitter [@hirotothefish](https://twitter.com/hirotothefish)

Installing
----------

If you want to work on this, you'll need `php5`, a webserver and `php5-mcrypt`.

R/a/dio uses php5-fpm and nginx. Here's one of our `server {}` blocks:

```
# Beta Server.
server {
	listen 5672;
	root /radio/www/r-a-d.io/beta/public;
	index index.php index.html;

	error_log /radio/www/logs/r-a-d.io/beta/error.log;
	access_log /radio/www/logs/r-a-d.io/beta/access.log;

	location / {
		try_files $uri $uri/ /index.php?$request_uri =404;
	}

	# php5-fpm fastcgi pass.
	location ~ \.php$ {
		fastcgi_split_path_info ^((?U).+\.php)(/?.+)$;
		fastcgi_pass unix:/var/run/php5-fpm.sock;
		fastcgi_intercept_errors off;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include fastcgi_params;
	}

}


```


You will also need [Composer](http://getcomposer.org/). Clone the repo, enter the directory, and run:

```php
    curl -sS https://getcomposer.org/installer | php
```

This will install a `composer.phar` file to the current directory:

    ./composer.phar install

Note: if you get errors about disabled functions, enable them. For any other errors, make sure the branch you are on passes the travis-ci tests.






Credits
-------

The original creators of the r/a/dio site are [@Bevinsky](https://github.com/Bevinsky) and [@Wessie](https://github.com/Wessie).

Occasional theme-hacker and freedom-hater is [@9001](https://github.com/9001) (aka Tripflag, ed)



## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
