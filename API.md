# R/a/dio API Documentation
R/a/dio doesn't version its API, but could in future. The current base URL is **`https://r-a-d.io/api`**.
Prepend this to every method here.

# Response types
Every object returned by the API (with the exception of errors, see below) returns two objects: `main` and `meta`.
Meta is a short object returning information about the current request, and available routes (as well as our stream URL).
Responses will only detail the *main* object.


# PUT + DELETE Usage
PUT and DELETE are not available in most browsers, so Symfony2 will obey the `_method` POST parameter, set to either `PUT` or `DELETE` for this.


# Current Info [/]
The main object returns an absolute monster of a response. This is cached every 1 second as it is time-sensitive.
In general you should only really need this API response if you want to make a status display for R/a/dio.
Any keys not mentioned below is either obsolete or subject to change.

## Fetch Data [GET]
+ Response 200 (application/json)

        {
            "np":           string,          // currently playing song
            "listeners":    integer,         // current listeners
            "isafkstream":  0 or 1,          // boolean, is Hanyuu (the afk streamer) playing?
            "start_time":   long or null,    // timestamp for the start of the song. can be null. (64bit int)
            "end_time":     long or null,    // timestamp for the end of the song. (64bit int)
                                             // can be null if not known. Can also be inaccurate.
            "trackid":      integer or null, // if not null, the ID of the current track in the database
            "thread":       string or null,  // current 4chan thread, if any (url)
            "requesting":   0 or 1,          // boolean, is requesting allowed right now?
            "djname":       string,          // textual representation of a DJ's name exactly as written in IRC
            "current":      long,            // current server time (64bit int)

            "dj": {                          // current DJß
                "id":       integer,         // DJ's internal ID
                "djname":   string,          // DJ's name (use this instead of djname outside of the object)
                "visible":  0 or 1,          // is the DJ supposed to be visible on the staff page?
                "role":     string,          // string representation of a user's role in r/a/dio
                "theme_id": 2                // ID of the theme used by this DJ
            },
            "queue": [                       // current queue, only available for hanyuu
                {
                    "meta":      string,     // metadata for the given item
                    "time":      string,     // html timeago timestamp for use in javascript
                    "timestamp": long,       // timestamp representing when the song will play (64bit int)
                    "type":      integer     // 0: random song, 1 = request, 2+ = internal state, assume 1
                },
                ... // limit subject to change
            ],
            "lp": [                          // last played songs
                {
                    "time":      string,     // html timeago timestamp for use with javascript
                    "timestamp": long,       // timestamp representing when the song played (64bit int)
                    "meta":      string      // metadata for the given item
                },
                ... // limit subject to change
            ]
        }


# DJ Image [/dj-image/{id}]
The PUT, POST and DELETE methods are authenticated; you can only change an image if it belongs to the user making the call or if the user is a Developer.


## Fetch Image [GET]
This will return the image associated with a dj (or a default image). A 404 is returned if an ID did not match a DJ.

+ Response 200 (image/png)
+ Response 404 (text/html)

## Upload Image [POST]
Upload a file to this URL with the key `image`, and the current user's image will be added
(replaces the current entry in the database with the user's ID instead of just overwriting the file)

+ Parameters

    + image (required, image) ... The image to upload.

+ Response 200 (application/json)

        {
            "success": true or false,    // if true, error key should be present
            "error":   string (optional) // see above
        } 


# Last Played [/last-played{?limit}{?offset}]
Return as set as big as you like using the `limit` and `offset` GET parameters.
Keep in mind that data is constantly changing and if you fetch data in chunks it could result in either a missing or a duplicated entry.

## Fetch Data [GET]

+ Parameters

    + limit = `25` (optional, number) ... How many entries to return.
    + offset = `0` (optional, number) ... The offset from which results should be given, used in combination with *limit* for pagination.

+ Response 200 (application/json)

        [
            {
                "meta":      string,   // metadata for the song played
                "timestamp": long      // unix timestamp of when the song was played (64bit int)
            },
            ... // n = ?limit
        ]

# Queue [/queue]
Queue data is always returned as a variable-length array in its entirety, and isn't paginated.

## Fetch Data [GET]

+ Response 200 (application/json)

        [
            {
                "meta":      string,   // song metadata
                "timestamp": long,     // unix timestamp of when the song was played (64bit int)
                "type":      0 or 1,   // boolean flag for if the song is a request or not.
            },
            ... // n = ?limit
        ]

# All News [/news{?limit}{?offset}]

## View All News Posts [GET]

+ Parameters

    + limit = `20` (optional, number) ... How many news posts to return in the response.
    + offset = `0` (optional, number) ... The offset from which results should be given, used in combination with *limit* for pagination.

+ Response 200 (application/json)

        [
            {
                "id": integer, // ID for seach news post. Used to fetch further info.
            }
        ]

# News Posts [/news/{id}{?comments}]

View an individual news post. Note that this response can be extremely large if you allow comments.

## View Post [GET]

+ Parameters
    
    + comments = `0` (optional, boolean) ... Boolean switch for enabling comments

+ Response 200 (application/json)

        {
            "id": integer,
            "created_at": date,
            "updated_at": date,
            "header": string,
            "title": string,
            "body": {
                "markdown": string,         // post body (markdown)
                "html": string              // post body (html)
            }
            "author": {
                "name": string              // author's name
            },
            "comments": integer or array    // number of comments unless ?comments=1 (else array of comments)
                                            // see GET /comments/{id} for the objects in this array
        }