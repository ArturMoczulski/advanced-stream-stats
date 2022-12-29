# Advanced Stream Stats

## Features

* ✅ Basic user auth functionality

* ✅ Annual and monthly subscrption plans

* ✅ Metrics dashboard with placeholder data

* ✅ Canceling a subscription throught the user account

* ✅ Subscription payment with rebilling needs to be implemented with Braintree. Needs to support CC and PayPal payments.

* ✅ The UX needs to be built as a SPA

## Demo



## Quick Start

[Click here](https://cgivr5765bjarthvzdes4le6iq0pdykp.lambda-url.us-east-1.on.aws/) to preview the application
running on Vapor.

## Prerequisites

* Braintree account

* PayPal account connected to Braintree

## Deployment

```sh
composer global require laravel/vapor-cli --update-with-dependencies
vapor login
vapor deploy production
vapor env:pull production
```

Update Braintree access credentials in .env.production

```sh
vapor env:push production
```

### Setting up the Subscription Plans in Braintree

After you deploy the application, make sure that there are Subscription Plans set up in your Braintree account with subscription ids matching the Subscription Plan ids from the application.

## To Do

* Payment model to record transaction history in the app. Payments should be associated with the matching Braintree transactions.

* Store Braintree customer id in the User model.

* Braintree callbacks to sync subscription status when it renews or fails to renew.

* E2E test suite.