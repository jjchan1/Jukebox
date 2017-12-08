<?php
require("methods.php");
$db = connect();
$playlists = getPlaylists($db);

$db->close();

$top = <<<TOP
<body>
	<section class="container header">
		<h1>JUKEBOX</h1>
		<h2>Playlist</h2>	
	</section>

	<center>
TOP;

$bottom = <<<BOTTOM
</center>

<center>
	<a class="a hBox" href="Edit Playlist.html" style="margin-top:30px">Liked Songs<i class="fa fa-angle-right" style="font-size: 30px; float: right;"></i></a>
</center>

<section class="container nav">
		<center>
				<a class="a icon" href="Home.html"><i class="fa fa-home" style="font-size: 50px; padding: 15px;"></i></a>
				<a class="a icon" href="Playlists.php"><i class="fa fa-music" style="font-size: 50px; padding: 15px;"></i></a>
				<a class="a icon" href="CurrentlyPlaying.php"><i class="fa fa-volume-up" style="font-size: 50px; padding: 15px;"></i></a>
		</center>
</section>
</body>
BOTTOM;

echo genPage("Playlists", $top.$playlists.$bottom);

?>
