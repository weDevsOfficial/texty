=== Texty - SMS Notification for WordPress, WooCommerce, Dokan and more ===
Contributors: tareq1988, wedevs, nizamuddinbabu
Donate link: https://tareq.co/donate/
Tags: sms, text, notification, twilio, nexmo, vonage
Requires at least: 4.0
Tested up to: 5.6
Stable tag: 0.2
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
- [Plivo](https://www.plivo.com/)

### Supported Events

#### WordPress Core

- **New User** - Send an alert when someone registers on your website.
- **New Comment** - Get an alert when anyone lefts a comment.

#### WooCommerce

- **Admin - When Order Status is Processing** - Get an alert when a new order is received in *Processing* status.
- **Admin - When Order Status is Complete** - Get an alert when a new order is *Complete*.
- **Customer - When Order Status is On Hold** - Send an alert to the customer when a new order received, but is in *On Hold* status.
- **Customer - When Order Status is Processing** - Send an alert to the customer when a new order changes to *Processing* status.
- **Customer - When Order Status is Complete** - Send an alert to the customer when a order changes to *Complete* status.

#### Disclaimer 

As Texty doesn't have any capability to send a text by itself, it integrates with 3rd party providers to do so. You should check the individual provider's terms of service and privacy policies before using them.

- Twilio - [Terms of Service](https://www.twilio.com/legal/tos) and [Privacy Policy](https://www.twilio.com/legal/privacy)
- Vonage - [Legal](https://www.vonage.com/legal/) and [Privacy Policy](https://www.vonage.com/legal/privacy-policy/)
- Plivo - [Terms of Service](https://www.plivo.com/legal/tos/) and [Privacy Policy](https://www.plivo.com/legal/privacy/)

#### Privacy Policy 
Texty uses [Appsero](https://appsero.com) SDK to collect some telemetry data upon user's confirmation. This helps us to troubleshoot problems faster & make product improvements.

Appsero SDK **does not gather any data by default.** The SDK only starts gathering basic telemetry data **when a user allows it via the admin notice**. We collect the data to ensure a great user experience for all our users. 

Learn more about how [Appsero collects and uses this data](https://appsero.com/privacy-policy/).

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= Which gateways does Texty support? =

Currently, it supports Twilio, Vonage (Nexmo), Plivo. More gateway support is coming soon.

= Does it support WooCommerce? =

Yes, it does. We are continiously adding more events from WooCommerce.

= Does it support Dokan? =

No, it doesn't. But soon it'll support Dokan.

= Can I do X? =

Well, it depends. Let us know what you want, we might consider adding that feature.


== Screenshots ==

1. Gateway settings page
1. All supported notifications panel
1. Tools page for quick testing
1. WooCommerce admin notification
1. WooCommerce customer notification

== Changelog ==

= v0.2 (18 Jan, 2021) = 

- Initial Release

== Upgrade Notice ==

Nothing here right now
