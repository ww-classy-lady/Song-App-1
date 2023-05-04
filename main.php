<!DOCTYPE html>
<html>
<head>
        <title>Song/Artist Searching App</title> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <style>
                #search-wrapper{
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        
                }
                #search-general{
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        background-color: #09D16D;
                        border-radius:10px;
                        padding: 30px;
                }
                h1{
                        text-align: center;
                }
                /*img{
                        max-width: 100%;
                        height: auto;
                }*/
        </style>
</head>
<body>
        <h1>Nothing is free but Song Searching here is FREE!</h1>
        <div id = "search-wrapper">
                <div id = "search-general">
                        <!--<h2>Enter your input here:</h2>
                        <h2>Number of songs to display:</h2> -->

                        <form method="post" action="">
                                <h2>Enter your input here:</h2>
                                <textarea id ="lyrics" name="lyrics" rows = "5" cols = "90"></textarea>
                                <h2>Number of songs to display:</h2>
                                <textarea id ="numSongs" name="numSongs" rows = "3" cols = "90"></textarea> 
                                <input type="submit" value = "Search!">

                        </form>
        </div>
        <img src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFwAAABcCAMAAADUMSJqAAAAb1BMVEUe12D///8A1VQW110A1lgA1FAA0lZQ3H2d6bDV9d3S9dzz+/Zn3Y051m052W4Q11sA0UUA0kHc9uOr6b7C8NCi5bbK8tTD8c2K5aNC2nOU5ayW5bFh24bo+O2j6rYv2Wla3IJy35Wy6cSA5JyJ4qa1TVpHAAACSElEQVRoge2VDY/iIBCGmSlTzkKhC7Ufri398P//xgOrMXsXu95lN7lLeGKsjvIyvDMAY4lEIpFIJBKJRCLxn5Jx5OGVfYc0ih/N4dB2PX65PIoCbtSaf602neCBVF+qTu/wgc/VX7fOnD9qgyyvg0OJze8qWQydc8YJzQviOADYdrx03djazXeMYTG6zv+6iExrRgWseBnk9ELiM4CgagPZHEvbB5X5Os8cmtOY20pCqpWVxE+D8DDUUwzvO0Q1QKeOjR1sM66souDShTOSoNlsmVB8Dg0a/ne+zJz3A6ipVOwCy3T2LCvn3vsd8WEz2trrh2JiMvqCEvqKEGuI4ROy6Jj0TXi3I2xlOsWf1fv5uXguwyBBb4GKrVu/F5zhMYRdSS1YLSSUNYysA8sGENqBmGERckAvLVPiuTVRfNCnpSjqo8I3X2zijFTMUtUgDHZwkpYyWsAPkFMQF3CsHEwrrHzvyLjZct+gXt3axSBVCg4OyozPcJQFxtWUD3HqwTVyx/BbQWHsOVXk53qbIhQ0t47lJTQOFmIHmCwo1FKGVHK+iSMPS1twVzy2IrgxdMuhXTHoxFbMmA4FDIZNy/VR4yRjZecqTG+Pm7gJi5w+2UkffBmj5W1Mh5RrnAhiZ9d0nBk9Fk5w5sdaKddrp4zX0ub72ix7tv2RMMMGeiJ+/xqeSMZglqHR1z32ifjuwWVWp58M8xc3v3C84M6Ra553Gn/p6GL0uCxa/9KIP8Hcr7lyv7X+km+8oBOJRCKRSCQSiUTiH+EnlWMhai1NpbkAAAAASUVORK5CYII=">
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php

//SPOTIFY API
//using client credentials flow (data won't be saved)
session_start(); 
//THE Spotify API One just returns a list of songs, with artist name and album name where 
//if user enter a search like "Hello" then it will return a list of song titles that contains Hello.
//User can search in multiple Languages
//The flaw: If i search "Hello its"
//if will return Hello It's Me
//And other results like Hello, I Love You. So it seems like the seach is just songs that have any word within that line.
//the API seems to take care of the Punctuation upper case lower case situation. But It doesn't return the whole list.
//Ok it partially does the job, it 
require 'vendor/autoload.php'; //must include these files to use the spotify web api in our php script
require 'vendor/jwilsson/spotify-web-api-php/src/Session.php';
use SpotifyWebAPI\Session; //import libraries
use SpotifyWebAPI\SpotifyWebAPI;

$session = new Session(
    // hidden client id
    // hidden secret
);
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();
$api = new SpotifyWebAPI();
$api->setAccessToken($accessToken);
//above code gets the accessToken so that we can use the Spotify Web API
$lyrics = $_POST['lyrics'];
$num = $_POST['numSongs'];
//$tracks = $api->getTracks([50]);
if(isset($lyrics)&&isset($num)) {
        echo '<ul>';
        echo "<strong> Here is a list of songs with song name, artist, album name, and an audio you can listen to: </strong>";

        $songs = $api->search($lyrics,'track',['limit' => $num]); //search in the api where the lyrics is in the song title ('track' of spotify web api) //liimit the result of search to display only 50 tracks
        //$songs = $api->search($lyrics, 'track');
        $songs = $songs->tracks->items;
        foreach ($songs as $track) {
                $songName = $track->name;
                $artist = $track->artists[0]->name;
                $songAlbum = $track->album->name;
                $albumCover= $track->album->images[0]->url;
                $previewUrl = $track->preview_url;
                // display the track information to the user
                //echo "<p> SONG - $songName BY - $artist ALBUM -  $songAlbum</p>";
                echo "<p> SONG - $songName BY - $artist ALBUM - $songAlbum </p>"; //display the song name, artist, and album of the song
                if($albumCover != null){
                        echo "<img src='$albumCover' alt='$songAlbum' style='width:50px;height:50px;'>"; // album cover as image
                }
                if ($previewUrl != null) {
                        echo '<a href="'.$previewUrl.'"> Listen to a Snippet of ' . $songName . ' by ' . $artist . '</a>'; //link to the audio link
                }
                }


}
else
{
        echo "Please Enter your line of search above";
} 


?>
