<!DOCTYPE html>
<html>
<head>
        <title>Lyrics to Song Searching App</title> 
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
                        background-color:beige;
                        border-radius:10px;
                        padding: 30px;
                }
                h1{
                        text-align: center;
                }
                img{
                        max-width: 100%;
                        height: auto;
                }
        </style>
</head>
<body>
        <h1>Welcome to Lyrics to Song Searching App!</h1>
        <div id = "search-wrapper">
                <div id = "search-general">
                        <h2>Enter your line of lyrics here:</h2>
                
                        <form method="post" action="">
                                <textarea id ="lyrics" name="lyrics" rows = "5" cols = "90"></textarea>
                                <input type="submit" value = "Search!">
                        </form>
        </div>
        <img src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFwAAABcCAMAAADUMSJqAAAAb1BMVEUe12D///8A1VQW110A1lgA1FAA0lZQ3H2d6bDV9d3S9dzz+/Zn3Y051m052W4Q11sA0UUA0kHc9uOr6b7C8NCi5bbK8tTD8c2K5aNC2nOU5ayW5bFh24bo+O2j6rYv2Wla3IJy35Wy6cSA5JyJ4qa1TVpHAAACSElEQVRoge2VDY/iIBCGmSlTzkKhC7Ufri398P//xgOrMXsXu95lN7lLeGKsjvIyvDMAY4lEIpFIJBKJRCLxn5Jx5OGVfYc0ih/N4dB2PX65PIoCbtSaf602neCBVF+qTu/wgc/VX7fOnD9qgyyvg0OJze8qWQydc8YJzQviOADYdrx03djazXeMYTG6zv+6iExrRgWseBnk9ELiM4CgagPZHEvbB5X5Os8cmtOY20pCqpWVxE+D8DDUUwzvO0Q1QKeOjR1sM66souDShTOSoNlsmVB8Dg0a/ne+zJz3A6ipVOwCy3T2LCvn3vsd8WEz2trrh2JiMvqCEvqKEGuI4ROy6Jj0TXi3I2xlOsWf1fv5uXguwyBBb4GKrVu/F5zhMYRdSS1YLSSUNYysA8sGENqBmGERckAvLVPiuTVRfNCnpSjqo8I3X2zijFTMUtUgDHZwkpYyWsAPkFMQF3CsHEwrrHzvyLjZct+gXt3axSBVCg4OyozPcJQFxtWUD3HqwTVyx/BbQWHsOVXk53qbIhQ0t47lJTQOFmIHmCwo1FKGVHK+iSMPS1twVzy2IrgxdMuhXTHoxFbMmA4FDIZNy/VR4yRjZecqTG+Pm7gJi5w+2UkffBmj5W1Mh5RrnAhiZ9d0nBk9Fk5w5sdaKddrp4zX0ub72ix7tv2RMMMGeiJ+/xqeSMZglqHR1z32ifjuwWVWp58M8xc3v3C84M6Ra553Gn/p6GL0uCxa/9KIP8Hcr7lyv7X+km+8oBOJRCKRSCQSiUTiH+EnlWMhai1NpbkAAAAASUVORK5CYII=">
</body>
</html>
<?php
require_once 'C:\Users\wendy\php\spotify-web-api-php-main/src/Request.php';
require_once 'C:\Users\wendy\php\spotify-web-api-php-main/src/Session.php';
require_once 'C:\Users\wendy\php\spotify-web-api-php-main/src/SpotifyWebAPI.php';
require_once 'C:\Users\wendy\php\spotify-web-api-php-main/src/SpotifyWebAPIException.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $lyrics = $_POST['lyrics'];
        $j_songs = file_get_contents('songs.json'); //get all the content from the json file that stores the title, artist, and lyrics information
        $contents = json_decode($j_songs, true); //store contents into arrays
        if($contents === null){
                echo"Cannot decode json data";
                exit;
        }
        $results = array_filter($contents, function($song) use ($lyrics){  
                return str_contains($song['lyrics'], $lyrics) ===true; //get all the results where the lyrics in contents contains the user's input lyrics
        });
        $count = 1;
        foreach($results as $result){ //print all the songs that has that lyrics
                echo"<p> ". $count . ". The Song title is: " . $result['title'] . "</p>";
                echo"<p> ". $count . ". The Song's Artist is: " . $result['Artist'] . "</p>";
                $count++;
        }
}
?>
