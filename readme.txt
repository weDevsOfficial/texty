=== Texty - SMS Notification for WordPress ===
Contributors: tareq1988, wedevs, nizamuddinbabu
Donate link: https://tareq.co/donate/
Tags: sms, text, notification, twilio, nexmo, vonage
Requires at least: 4.0
Tested up to: 5.6
Stable tag: 0.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Texty is a lightweight SMS notification plugin for WordPress.

== Description ==

Texty is a lightweight SMS notification plugin for WordPress. 

With so many emails coming to your inbox, often it becomes overwhelming to get top of things that you feel most important. A text notification on your phone, WhatsApp, or Telegram may be more desired.

### How does it work?

Texty integrates with 3rd party SMS providers to add support for text messaging.

If you need an SMS notification when a user registers your website, Texty can send a text alert to you when someone registers. Similarly, when a different event occurs in different plugins, Texty can send a text notification depending upon the event. 

Another example might be an order notification from WooCommerce. Upon receiving an order, you might decide to receive a text notification, as well as your customer may get a text notification when the order status changes.

### Supported Gateways

- [Twilio](https://twilio.com)
- [Vonage](https://vonage.com/communications-apis/) - Formerly Nexmo

### Supported Events

#### WordPress Core

- **New User** - Send an alert when someone registers on your website.
- **New Comment** - Get an alert when anyone lefts a comment.

#### WooCommerce

- **New Order (Admin)** - Get an alert when a new order is received.

#### Disclaimer 

As Texty doesn't have any capability to send a text by itself, it integrates with 3rd party providers to do so. You should check the individual provider's terms of service and privacy policies before using them.

- Twilio - [Terms of Service](https://www.twilio.com/legal/tos) and [Privacy Policy](https://www.twilio.com/legal/privacy)
- Vonage - [Legal](https://www.vonage.com/legal/) and [Privacy Policy](https://www.vonage.com/legal/privacy-policy/)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= Which gateways does Texty support? =

Currently, it supports Twilio and Nexmo. More gateway support is coming soon.

= Does it support WooCommerce? =

Yes, it does. Currently admins can receive texts upon a new order. More events will be supported in near future.

= Does it support Dokan? =

No, it doesn't. But soon it'll support Dokan.

= Can I do X? =

Well, it depends. Let us know what you want, we might consider adding that feature.


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif).
2. This is the second screen shot

== Changelog ==

= v0.1 = 

- Initial Release

== Upgrade Notice ==

Nothing here right now
