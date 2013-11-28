walart
======

WalArt Prototype For [AngelHack 2013 - Bangalore](http://angelhack.com/apphack#)

 - What if you could try the art you buy online by placing it on your wall ( virtually :) ).
 - In this tablet website , you can  choose the art , take a pic of your wall from the tablet and try the art by placing it on your wall.
 - We make the adjustments to make it look real ( adjust the change in lighting and adjust the quality (dpi) ).

**Warning:** Prototype - lot of ugly code

How to run
==========
clone/copy everything to www folder in wamp

Files
=====
1. Start @ gallery-layout.html - This is the mock of an online gallery, choose your art from here.
2. This goes to index.html - Take a pic of your wall and tell us how much height the pic is covering
3. This goes to drag-image-upload.php - This renders the page where you can try the art by placing it on wall. 
	 - Lighting is adjusted using a histogram equalisation like algo (idea thanks to [anandhavelu](https://github.com/anandhavelu) and ragupathy) - Find the average luminance of the wall pic and use the brightness filter to adjust art brightness
	 - The art image is downsampled to adjust for the difference in quality.
	
TODOs
=====
1. Remove hardcodings
2. Add CSS
3. Add few more features
4. Launch and sell :)





