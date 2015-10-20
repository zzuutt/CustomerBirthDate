# CustomerBirthDate

Add a date of birth input in customers' forms

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is CustomerBirthDate.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/customer-birth-date-module:~1.1
```

## Usage

Once activated, inputs asking for customer's birth date appear:
- in the customer register page
- in the customer update account page
- in the admin 'create customer' form
- in the admin 'customer' page

## Loop

customerbirthdate

### Input arguments

|Argument |Description |
|---      |---         |
|**id**   | The customer id you want to diplay the date of birth |

### Output arguments

|Variable       |Description |
|---            |---         |
|$CUSTOMER_ID   | The ID of the customer |
|$BIRTHDATE     | The date of birth of the customer. Format: *yyyy-mm-dd* |

### Exemple

{loop type="customerbirthdate" name="birth_date"}
    <p>Customer ID: {$CUSTOMER_ID} | Date of birth : {$BIRTHDATE}</p>
{/loop}
