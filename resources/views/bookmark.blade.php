<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <title>
        push new content • elastifeed
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="bookmark-wrapper">
        <div class="bookmark-wrapper__content">
            <h1 class="h3">
                <strong>Drag this button</strong><br />
                to you Bookmarks Bar.
            </h1>
            <p>
                When you are viewing a page or RSS-feed that you'd like to store to elastifeed, simply click the bookmarklet in your Bookmarks/Favorites to store it to your account.
            </p>
            <a href="javascript:(function(){ {{$bookmarklet}} })();" class="bookmark">
                Store this page
            </a>
            <p>
                <small>
                    Bookmarklets are currently not supported in Microsoft Edge.
                </small>
            </p>
        </div>
    </div>
</body>
</html>