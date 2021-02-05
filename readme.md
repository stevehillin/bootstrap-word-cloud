## Simple Bootstrap Word Cloud ##

You can use this in any way you see fit, from listing your competancies for hiring processes (my initial motivation) to whatever your heart desires.  Have at it!

Easy to deploy, uses Bootstrap CDN with a minimal CSS file.

Sample [here](https://steve.hillin.com/).

### Usage ###

`keywords.json` houses the button details that get ingested by index.php upon page load.  Map your labels to Bootstrap's pre-defined button styles (see https://getbootstrap.com/docs/4.0/components/buttons/)

`config.json` lets you make changes to the buttons' labels and alter functionality without editing index.php (unless you want to!)

### Config Options ###

`do_geo` set to 'true' will do a Geo lookup on the IP making the request to the page.

`do_sort` set to 'true' will sort your keywords alphabetically, making keywords.json easier to update.

`send_email` set to 'true' will email you the basic info on the page load, i.e. requesting IP, Geo info (if enabled) of the requestor, and the referrer site, if there was one, via php's mail() function.  Of course, you can 'step it up' and disable this and drop your analytics code into index.php.

`p_tag` will display above the button legend

`links` will become buttons in the footer to the different page(s) you'd like to reference here.

`buttons` will map the Bootstrap built-in buttons to a label that you select.  The example is for a skills-based button array.
