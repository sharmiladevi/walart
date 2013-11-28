<?php
if ($_FILES["camera_file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["camera_file"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["camera_file"]["name"] . "<br>";
  echo "Type: " . $_FILES["camera_file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["camera_file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["camera_file"]["tmp_name"];
  move_uploaded_file($_FILES["camera_file"]["tmp_name"],
      "upload/" . $_FILES["camera_file"]["name"]);
  echo "<img src=\"upload/" .  $_FILES["camera_file"]["name"] ."\"/>";
  }
?>