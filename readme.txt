Ultra LightWeight

created by Joseph Bergen < www.josephbergen.com >

-overview
A WordPress theme intended to be used as the starting point for people wanting create WP portfolio sites. It has some key functions included that should assist in speeding up development and working with sets of images for something like a portfolio site.

-images in uLW
The worst part of making an online portfolio is getting all your images together and ready for the web. If you're like me they're all too big to do anything about. I've decided to tightly integrate timthumb <http://www.binarymoon.co.uk/projects/timthumb/> into my core function so you can upload images of almost any size and the function makes it really easy to intelligently scale them down to exactly the size you want and avoid making people download images that are too large. It also has the huge benefit of being extremely flexible when working with images. If you decide later that you want to show larger images, you don't have to go back and re-upload larger versions, just change the dimensions inside your theme and you're done! The new images should be served up in real time and at true size.

-using uLW
While this theme can be used 'as is', it's really meant for you to dig in and change it. Make it your own!

-installation
--upload the uLW folder into your WordPress's theme folder
--create folder <yoursite>/wp-content/timthumb/
--create folder <yoursite>/wp-content/timthumb/cache/  (set permissions to at least 755 for read/write)
--copy timthumb file from: http://code.google.com/p/timthumb/ into folder: <yoursite>/wp-content/timthumb/

--(recommended) install http://wordpress.org/extend/plugins/wp-jquery-lightbox/ (don't forget to activate it!)
--(recommended) go to Dashboard>Settings>Reading and set "Blog pages show at most" to something arbitrarily high (1000) so your grid is not limited to only 10 posts!
--(recommended) go to Dashboard>Settings>Permalinks and set to "custom" : /%postname%/ , or something to your liking.