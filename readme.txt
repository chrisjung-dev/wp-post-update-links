=== WordPress Post Update Links ===
Contributors: campino2k
Donate link: http://wiki.campino2k.de/donate
Tags: post,update,links
Requires at least: 3.2
Tested up to: 3.3
Stable tag: 0.4.0
License: GPLv2

WordPress Post Update Links will place some links at the beginning to Update-Sections in a Post or Page.

== Description ==

Who doesn't know this: You published a post, you add an Update and then you need some time to perhaps link the updates at the beginning of the post.

This will solve your problem: just update, put the shortcode around your update and leave the rest up to the plugin.

= Usage =

Put the Shortcode [update] around some Update-Section. You're done.

= Examples = 

Auto generated title:

> [update]
> This is an Update
> [/update]

Self defined Text:  

> [update title="My custom Update title"]
> This is an Update
> [/update]

Self defined title not shown in post

> [update title="My custom update link text" notitle="true"]
> This is an Update with a custom link text in the beginning, but not showing inside the post
> [/update]

Auto generated title not shown in post

> [update title="false"]
> This is an Update with a default link text in the beginning, but not showing inside the post
> [/update]


== Installation ==

Install Plugin via WordPress Install or upload the .zip file

== Frequently Asked Questions ==

= Is there any database usage with this plugin? =

nope.

== Screenshots ==

1. What the links look like in TwentyEleven default theme if you don't override the styles


== Changelog ==

= 0.4.0 = 

 * Add Localization for french Language thanks to [Jean-Michel MEYER (dit Li-An)](http://www.li-an.fr/blog)
 * Fix Header display problem in articles

= 0.3.0 = 

 * add Flattr link in Plugin overview
 * add custom headlines in post text
 * shortcode contents are now placed in P tags
 * used some code from 
 * resolve possible incompatibility with WordPress 3.3 by changing CSS to hook `wp_enqueue_scripts` like mentionied in [WordPress Development Updates](http://wpdevel.wordpress.com/2011/12/12/use-wp_enqueue_scripts-not-wp_print_styles-to-enqueue-scripts-and-styles-for-the-frontend/)

= 0.2.3 =

* After feedback from php developer, simplified the code, removing the singleton-stuff

= 0.2.2 =

* update to remove version inconsistency

= 0.2.1 =

* Correct readme

= 0.2 =

* Refactor to OOP model

= 0.1 =

* First draft, complete with i8ln preparings

== Upgrade Notice ==

= 0.3.0 =

 * Wordpress 3.3 should upgrade immediately	due to the changed CSS-Hook API

= 0.1 =
* none so far

