# Advanced Stream Stats

## Features

* ✅ Basic user auth functionality

* ✅ Annual and monthly subscrption plans

* ✅ Metrics dashboard with placeholder data

* ✅ Canceling a subscription throught the user account

* ✅ Subscription payment with rebilling needs to be implemented with Braintree. Needs to support CC and PayPal payments.

* ✅ The UX needs to be built as a SPA

## About

This project is using Laravel 9 with Vue.js through Inertia. The production application is deployed to Laravel Vapor. Majority of this tech stack was new to me at the time of starting the project. It has been a while since I worked with Laravel 8, I never worked with Vue although I did work with React a lot. Inertia was completely new to me. This project took an estimated 10 hours with development environment setup and spending time on educating myself on the details of the asset pipeline, Vapor deployment tools and how Vue and Inertia work together. The time I spent on building the actual backend came up to about 3 hours

## Demo

[Here](https://www.loom.com/share/3909720a4eb242e5bf9c00c7cbe0e3f2) is a demo screen share presenting the application features on a demo environment.

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

* Improve how error-proof the payment processing is as mentioned in the end of the demo video.

* Payment model to record transaction history in the app. Payments should be associated with the matching Braintree transactions.

* Store Braintree customer id in the User model.

* Braintree callbacks to sync subscription status when it renews or fails to renew.

* E2E test suite.