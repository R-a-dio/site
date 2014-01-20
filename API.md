#R/a/dio API Docs v1

## Pre-requisite vars

For every request, you'll need the following variables. You'll get them when you get them.


    key=<sha256 string>
    sender=<user_id int>

Also optional, but required for pagination, are `limit` and `offset`, both ints, both literally a `LIMIT :limit, :offset` clause in SQL. `limit` is 50 by default; `offset` is 0.

Any api call which has a CSRF header from r/a/dio is automatically allowed without an API key (but only on `GET` requests. POST/PUT/DELETE requests require an admin user session or an API key with POST/PUT/DELETE privileges).

When querying the API, you'll get the object you queried for in an object with the key `"result"`. Example:

    {
        "meta": {
             "sender": 17,
             "quota": 5000,
             "remaining": 4999,
             "cached": false,
             "routes": ["current", "tracks", "metadata", "song", "queue", "last", ...],
         }
         "main": {
             ...
         }
    }

Default quota is 5000 calls/day, reset at UTC midnight. Ask if you need more.
Also, any API call which is cached will not count towards your quota.


## Methods
Onto the API methods. This is not a comprehensive list.

Value types will be indicated using `<name:type>`.

`GET /current` - GETs the current R/a/dio status.

```json
"main": {
    "dj": { <dj:dj(see GET /djs/<id:int>)> },
    "metadata": <metadata:string>",
    "queue": { <queue:queue(see GET /tracks/queue/5)> },
    "last": { <last:last(see GET /tracks/last/5)> },
    "listeners": <listeners:int>,
    "stream": {
        "url": <url:string>,
        "m3u": <url:string>,
        "pls": <url:string>,
        "bitrate": <kbps:int>,
        "current": <timestamp:int>,
        "current_length": <timestamp:int>
    },
    "thread": <url:string|false>
}
```
