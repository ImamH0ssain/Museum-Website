Image Slider Maker README
=========================
ImageSliderMaker.com


Using in your website
---------------------

Please first make sure you have fully extracted the contents of the zip file.
In Windows, right-click on imageslidermaker.zip and select Extract All...

To get your slider working in your web page, you must add
my-slider.css, ism-2.2.min.js and the slide images to your project
directory and paste the markup (included below) into your HTML.

The directory structure of this package:

  imageslidermaker/
    README.txt
    example.html
    ism/
      css/
        my-slider.css
      js/
        ism-2.2.min.js
      image/
        slides/
          _u/1651517573420_396981.jpg
          _u/1651517592690_756787.png
          _u/1651517588094_929516.jpg
          _u/1651517582994_10748.jpg
          _u/1651517600861_264266.png

For a working example, open example.html in your web browser or
follow the instructions below to integrate the slider into your
project.


Step by step instructions
-------------------------

1. Paste the following into the head of your HTML file:

<link rel="stylesheet" href="ism/css/my-slider.css"/>
<script src="ism/js/ism-2.2.min.js"></script>


2. Paste this into the body of your HTML file (at the location where:
   you would like your slider to appear in the page):

<div class="ism-slider" data-transition_type="zoom" data-play_type="loop" data-interval="3000" data-radio_type="thumbnail" id="my-slider">
  <ol>
    <li>
      <img src="ism/image/slides/_u/1651517573420_396981.jpg">
      <div class="ism-caption ism-caption-0">Painting</div>
    </li>
    <li>
      <img src="ism/image/slides/_u/1651517592690_756787.png">
      <div class="ism-caption ism-caption-0">Misc</div>
    </li>
    <li>
      <img src="ism/image/slides/_u/1651517588094_929516.jpg">
      <div class="ism-caption ism-caption-0">Scalpture</div>
    </li>
    <li>
      <img src="ism/image/slides/_u/1651517582994_10748.jpg">
      <div class="ism-caption ism-caption-0">Pottery</div>
    </li>
    <li>
      <img src="ism/image/slides/_u/1651517600861_264266.png">
      <div class="ism-caption ism-caption-0">War Antique</div>
    </li>
  </ol>
</div>
<p class="ism-badge" id="my-slider-ism-badge"><a class="ism-link" href="http://imageslidermaker.com" rel="nofollow">generated with ISM</a></p>


3. Copy the ism/ directory into the root directory of your project.

   The css, js and image paths are relative, meaning the ism/
   directory should be in the same directory (path) as your HTML
   file containing the slider.


