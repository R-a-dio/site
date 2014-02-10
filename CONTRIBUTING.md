# Contribution Guidelines

Bug reports go into issues. Be as detailed as possible.

Discussion should ideally be first on IRC (#r/a/dio@irc.rizon.net) and then in a github issue if the discussion has any merit.

Pull request to your heart's content if you fancy doing something that's lacking.

# Translations

All translations are made using the system that Laravel 4 uses: http://laravel.com/docs/localization

Files for localizing are arrays, located in `app/lang/:locale/:file.php`.

These are PHP files, meaning you can put executable code in them, but be warned that this means your pull request will be flat-out rejected in that case.

Rules for translations:

1. Translations must not be filled with shitposting
2. No HTML is allowed inside of translations
3. You must not use code to pluralize sentences. Use the format `"singular|plural"` instead.
4. All translations must be sent via pull request on github and signed off.
5. There must be no executable code in the language files

To see where all of the translations are physically on a page, set `"locale" => "<YOUR_LOCALE_CODE_HERE>"` in `app/config/app.php` before you do any work. This will result in a bunch of strings (e.g. "search.placeholder", "search.button") appearing everywhere. These are the locale placeholders, which you then replace in the relevant files (i.e. `search.placeholder` would be `"placeholder" => "Search"` in `app/lang/en/search.php`).
