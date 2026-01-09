\# ShippingLogger – Magento 2 Module



\## Overview

ShippingLogger is a Magento 2 custom module that logs the selected shipping method, shipping amount, and currency for an order after checkout completion.  

The module is designed with production safety in mind and demonstrates real-world usage of Magento 2’s event–observer pattern.



This module is ideal for:

\- Checkout debugging

\- Shipping audits

\- Magento 2 learning

\- Interview preparation



---



\## Features

\- Logs shipping method code and title

\- Logs shipping amount with currency symbol

\- Supports multi-currency stores

\- Handles virtual orders safely

\- Production-safe (no checkout break)

\- Clean and extensible code structure



---



\## What Data Is Logged

\- Order Increment ID

\- Shipping Method Code (e.g. `flatrate\_flatrate`)

\- Shipping Method Title (e.g. `Flat Rate - Fixed`)

\- Shipping Amount

\- Order Currency Symbol



---



\## Event Used

\- checkout\_onepage\_controller\_success\_action

