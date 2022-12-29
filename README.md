# Advanced Stream Stats

## Features

* Basic user auth functionality

* Annual and monthly subscrption plans

* Metrics dashboard with placeholder data

* Canceling a subscription throught the user account

* Subscription payment with rebilling needs to be implemented with Braintree. Needs to support CC and PayPal payments.

* The UX needs to be built as a SPA

## Quick Start

[Click here](https://cgivr5765bjarthvzdes4le6iq0pdykp.lambda-url.us-east-1.on.aws/) to preview the application
running on Vapor.

## Deployment

```php
vapor login
vapor deploy production
```

### Setting up the Subscription Plans in Braintree

After you deploy the application, make sure that there are Subscription Plans set up in your Braintree account with subscription ids matching the Subscription Plan ids from the application.

## Testing