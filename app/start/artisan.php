<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

// song indexing
Artisan::add(new ReindexCommand);
Artisan::add(new IndexCommand);
Artisan::add(new DatabaseRescueCommand);
Artisan::add(new DatabaseCleanupCommand);
Artisan::add(new SiteDeployCommand);
