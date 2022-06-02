=== Texty - SMS Notification for WordPress, WooCommerce, Dokan and more ===
Contributors: tareq1988, wedevs, nizamuddinbabu
Donate link: https://tareq.co/donate/
Tags: sms, text, notification, twilio, nexmo, vonage, clickatell, plivo, dokan, woocommerce
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.1.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Texty is a lightweight SMS notification plugin for WordPress.

== Description ==

Texty is a lightweight SMS notification plugin for WordPress. 

With so many emails coming to your inbox, often it becomes overwhelming to get top of things that you feel most important. A text notification on your phone, WhatsApp, or Telegram may be more desired.

👉 [Docs](https://github.com/weDevsOfficial/texty/wiki)

### How does it work?

Texty integrates with 3rd party SMS providers to add support for text messaging.

If you need an SMS notification when a user registers your website, Texty can send a text alert to you when someone registers. Similarly, when a different event occurs in different plugins, Texty can send a text notification depending upon the event. 

Another example might be an order notification from WooCommerce. Upon receiving an order, you might decide to receive a text notification, as well as your customer may get a text notification when the order status changes.

### Supported Gateways

- [Twilio](https://twilio.com)
- [Vonage](https://vonage.com/communications-apis/) - Formerly Nexmo
- [Plivo](https://www.plivo.com/)
- [Clickatell](https://www.clickatell.com/)

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

#### Dokan

- **Vendor - When Order Status is Processing** - Send an alert to the vendor when a new order received in *Processing* status.
- **Vendor - When Order Status is Complete** - Send an alert to the vendor when a order changes to *Complete*.

#### Disclaimer 

As Texty doesn't have any capability to send a text by itself, it integrates with 3rd party providers to do so. You should check the individual provider's terms of service and privacy policies before using them.

- Twilio - [Terms of Service](https://www.twilio.com/legal/tos) and [Privacy Policy](https://www.twilio.com/legal/privacy)
- Vonage - [Legal](https://www.vonage.com/legal/) and [Privacy Policy](https://www.vonage.com/legal/privacy-policy/)
- Plivo - [Terms of Service](https://www.plivo.com/legal/tos/) and [Privacy Policy](https://www.plivo.com/legal/privacy/)
- Clickatell - [Terms of Service](https://www.clickatell.com/legal/master-terms/) and [Privacy Policy](https://www.clickatell.com/legal/general-terms-notices/privacy-notice/)

#### Privacy Policy 
Texty uses [Appsero](https://appsero.com) SDK to collect some telemetry data upon user's confirmation. This helps us to troubleshoot problems faster & make product improvements.

Appsero SDK **does not gather any data by default.** The SDK only starts gathering basic telemetry data **when a user allows it via the admin notice**. We collect the data to ensure a great user experience for all our users. 

Learn more about how [Appsero collects and uses this data](https://appsero.com/privacy-policy/).

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= Which gateways does Texty support? =

Currently, it supports Twilio, Vonage (Nexmo), Plivo, Clickatell. More gateway support is being added continiously.

= Does it support WooCommerce? =

Yes, it does. We are continiously adding more events for WooCommerce.

= Does it support Dokan? =

Yes, it supports Dokan.

= Can I do X? =

Well, it depends. Let us know what you want, we might consider adding that feature.


== Screenshots ==

1. Gateway settings page
1. All supported notifications panel
1. Tools page for quick testing
1. WooCommerce admin notification
1. WooCommerce customer notification

== Changelog ==

= v1.1.1 (2 June, 2022) =

 - **Fix:** WordPress 6.0 compatibility

= v1.1 (31 Aug, 2021) =

 - **Fix:** Responsive issue in the settings panel was fixed where the name of gateways were overflowing the total viewport.
 - **Fix:** Remove duplicate numbers while sending messages. If a message is being sent and somehow two person have the same numbers, it'll only send one message.
 - **New:** Syncing of vendor phone number from Dokan added while registration. When a vendor was registering, his phone number from Dokan wasn't syncing as a Texty number, which prevented him to receive messages.

= v1.0 (22 Jan, 2021) = 

- **New:** Added Plivo gateway.
- **New:** Added Clickatell gateway.
- **New:** Added Dokan integration. Now vendors will receive SMS notifications when they receive an order (processing and completed status).
- **New:** Added `{items}` shortcode for WooCommerce orders which displays the product with quantity.

= v0.2 (18 Jan, 2021) = 

- Initial Release

== Upgrade Notice ==

Nothing here right now
