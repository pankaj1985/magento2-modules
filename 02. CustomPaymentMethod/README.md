\# Magento 2 Offline Payment Method Module



\## Overview

This Magento 2 module adds a \*\*custom offline payment method\*\* (like Cash on Delivery, Bank Transfer, or Custom Payment) to your store.  

It is a simple, configurable module to demonstrate \*\*payment method integration\*\* in Magento 2.



---



\## Features

\- Custom offline payment method

\- Configurable \*\*title\*\* in Admin

\- Displayed on \*\*checkout page\*\* as a payment option

\- Compatible with Magento 2.4+

\- Extensible for future custom logic



---



\## Use Case

\- Stores that accept \*\*manual payment methods\*\*

\- Offline bank transfers, cash on delivery, or check payments

\- Demonstrates \*\*Magento payment method integration\*\* in a real project



---



\## Installation



1\. Place the module in `app/code/Pankaj/CustomPayment/`

2\. Run Magento commands:



```bash

php bin/magento module:enable Vendor\_OfflinePayment

php bin/magento setup:upgrade

php bin/magento cache:flush



