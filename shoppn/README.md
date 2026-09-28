# Shoppn — Tasks 1-4

## Setup
1. Import the database:
   mysql -u root -p < database/shoppn.sql
2. Edit core/db_cred.php with your local MySQL credentials.
3. Point your web server (Apache/XAMPP/MAMP) at this folder, e.g. so it's
   reachable at http://localhost/shoppn/
4. Visit http://localhost/shoppn/index.php — the home page should load
   with no PHP errors, and the nav/header/footer should render.

## What's built
- Task 1: database/shoppn.sql — customer, brands, categories, products, cart, orders
- Task 2: core/db_class.php, core/core.php, index.php, views/layout/*, logout.php
- Task 3: classes/CustomerClass.php (emailExists, addCustomer),
  controllers/CustomerController.php (register), actions/register_action.php,
  views/register.php, js/validate.js
- Task 4: CustomerClass (getCustomerByEmail, login), CustomerController (login),
  actions/login_action.php, views/login.php, access control in core/core.php
  (is_logged_in, is_admin, require_login, require_admin), header.php nav states

## Left for later tasks (structure already in place)
- classes/ProductClass.php / controllers/ProductController.php: full product
  CRUD, search, admin views (views/admin/*.php)
- classes/CartClass.php / controllers/CartController.php: add/remove/update
  cart items, cart totals
- actions/add_brand_action.php, add_category_action.php, add_product_action.php,
  update_*_action.php, add_to_cart_action.php, remove_from_cart_action.php,
  update_qty_action.php, process_payment_action.php
- views/all_products.php, single_product.php, search_results.php, cart.php,
  checkout.php, payment.php, payment_success.php, payment_failed.php,
  account/edit_account.php, account/change_pass.php, account/delete_account.php

## Try it
- Register at /views/register.php → you're logged in and redirected to
  /views/account/my_account.php
- Log out, then log back in at /views/login.php
- To make an account an admin: register normally, then run
  UPDATE customer SET user_role = 1 WHERE customer_email = 'you@example.com';
  in your database — the header will then show an "Admin" link.
