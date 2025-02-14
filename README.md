<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

## Payment Gateway Integration with Laravel v10

This is a simple Laravel project demonstrating Different Payment Gateway integrations. It lets users enter payment details and process transactions securely using Stripe, PayPal, bKash, etc.


## Features

1. Stripe:
- Secure payment processing with Stripe API
- Customer creation and payment handling
- Frontend validation before submitting payment
- Laravel Session Flash Messages for success/error responses


## Installation

1. Clone the Repository

```bash
git clone https://github.com/your-username/stripe-laravel-demo.git
cd stripe-laravel-demo
```

2. Install Dependencies

```bash
composer install
npm install
```
3. Set Up Environment
  - Copy the .env.example file and update it:

```bash
cp .env.example .env
php artisan key:generate
```
  - Update .env File with Stripe API Keys

```bash
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

4. Serve the Application
<br/>
Now, open http://127.0.0.1:8000/stripe in your browser.


## Usage

- Enter your billing and card details.
- Click "Pay Now" to process the payment.
- If successful, you will see a success message.
- If there's an error, an alert will appear with the issue details.


## License

This project is open-source and available under the MIT License.
