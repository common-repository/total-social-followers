=== Total Social Followers ===
Contributors: element80
Donate link: http://element-80.com/portfolio/plugins/total-social-followers/
Tags: feedburner, twitter, facebook, social, count, subscribers, followers, total
Requires at least: 2.8.0
Tested up to: 3.0.1
Stable tag: 1.0

Displays a total count of all Facebook, Feedburner, and Twitter followers in text format.

== Description ==

It is best practice to display counts of current subscribers to your various social and distribution media, and while
all of the popular services offer proprietary counters, having a small army of buttons and counters on your site
looks unprofessional, cluttered, and detracts from your design.

This plugin solves that problem by drawing from Feedburner, Twitter, and Facebook to calculate a single total count
of all your subscribers across those services.  Of course, if you don't use all of them, you can simply call just the
subscribers of the service(s) you do use without breaking the result.  Whatever the total count, the output is a text
format number that you can include anywhere on your site with a shortcode.

== Installation ==

1. Upload the `/total-social-followers/` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the following shortcode wherever you would like to display the count:

     [total-social-followers facebook="your Facebook username/ID" feedburner="your Feedburner name" twitter="your Twitter username"]

   For example, if your Facebook page URL was http://www.facebook.com/MyWebSite, your Feedburner URL was
   http://feeds.feedburner.com/MyWebSiteFeed, and your Twitter URL was http://www.twitter.com/MyTwitter, your
   shortcode would look like this:

     [total-social-followers facebook="MyWebSite" feedburner="MyWebSiteFeed" twitter="MyTwitter"]

1. You can also include the count in your template files with the following PHP snippet containing the shortcode:

     `<?php echo do_shortcode('[total-social-followers facebook="[...]" feedburner="[...]" twitter="[..]"]'); ?>`

== Frequently Asked Questions ==

Please submit any questions you may have to wordpress@element-80.com

== Changelog ==

= 1.0 =
First stable version.