<?php
require("methods.php");
$onload = "";
$db = connect();
if ($_GET["playlistName"]){
	$pName = $_GET["playlistName"];
}else{
	$pName = "default";
}

$songs = getSongs($db, $_GET["playlistName"]);
if ($songs){
	foreach ($songs as &$s){
		$title = $s[1];
		$onload .= "addNewSong(\"$title\"); ";
	}
}

$db->close();

$body = <<<BODY
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">

		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script>
			$(function() {
				$( "#sortable-1" ).sortable();
				$( "#addNew" ).sortable();
			});
		</script>
		<script>
			window.onload = function() {
				$onload
		}
		</script>
		<script>
			var songCount = 0;

			function addNewSong(songName) {
				songCount = songCount + 1;
				var currCount = songCount;
				var icon = document.createElement('i');
				icon.className ="fa fa-reorder";
				icon.style = "color:white; font-size: 18px; padding-right:5px";
				icon.id = "icon" + currCount;

				var box = document.createElement('div');
				var listItem = document.createElement('li');

				box.className = "regbox";
				var node = document.createTextNode(songName);
				box.appendChild(node);
				listItem.id = "song" + currCount
				var close = document.createElement('i');
				close.className = "fa fa-close";
				close.style="font-size: 15px;float: right;";
				close.id = "delete";
				close.onclick = function() {removeSong(currCount)};

				box.appendChild(close);
				listItem.appendChild(icon);
				listItem.appendChild(box);
				var element = document.getElementById("addNew");
				element.appendChild(listItem);
			}

			function removeSong(songCount) {
				var parent = document.getElementById("addNew");

				var child = document.getElementById("song"+ songCount);
				var iconChild = document.getElementById("icon"+ songCount);

				parent.removeChild(child);
				parent.removeChild(iconChild);
			}

			function removePlaylist() {
				if (confirm("Are you sure you want to delete this playlist?")) {
					window.location.href = "Playlists.php"
					//will also later remove all instances of playlist
				}
			}
		</script>
	</head>

	<body>
		<section class="container header">
			<h1>$pName</h1>
			<h2>Edit Playlist</h2>
		</section>

		<center style="font-family: arial;color: white;font-size=20px;">Name:
			<div class="regbox" style="line-height: 50px; width:38%;">
				<form action="/action_page.php">
					<input type="text" style="width: 98%;" value="Enter Song Title" id='title'>
				</form>
			</div>
			<!-- Update onclick function -->
			<a href="#"><i class="fa fa-trash-o" onclick=removePlaylist() style="font-size: 35px; vertical-align: middle;"></i></a>
		</center>

		<center style="font-family: arial;color: white;font-size=20px;">URL:
			<div class="regbox" style="line-height: 50px;width:40%;">
				<form action="/action_page.php">
					<input type="text" style="width: 98%;" value="Enter YouTube Link">
				</form>
			</div>
			<a href="#"><i class="fa fa-plus-square-o" onclick="addNewSong('Song D')" style="font-size: 35px; vertical-align: middle;"></i></a>
		</center>

		<center class="center-container" style="padding-top: 10px; padding-bottom: 10px;">
			<ul id="addNew">
			</ul>
		</center>

		<section class="container nav">
			<center style="background-color: #141f1f; padding-bottom: 10px; padding-top: 10px;">
				<a href="Playlists.php"><i class="fa fa-check-circle-o" style="font-size: 40px; "></i></a>
				<a href="Playlists.php"><i class="fa fa-times-circle-o" style="font-size: 40px; padding-left:20px"></i></a>
			</center>

			<center>
				<a class="a icon" href="Home.html"><i class="fa fa-home" style="font-size: 50px; padding: 15px;"></i></a>
				<a class="a icon" href="Playlists.php"><i class="fa fa-music" style="font-size: 50px; padding: 15px;"></i></a>
				<a class="a icon" href="CurrentlyPlaying.php"><i class="fa fa-volume-up" style="font-size: 50px; padding: 15px;"></i></a>
			</center>
		</section>
	</body>
</html>
BODY;

echo $body;
?>
