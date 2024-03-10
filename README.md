### Laravel API Example with Modules

- Invoice module with approve and reject system as a part of a bigger enterprise system. 
---

<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
  - Products
    - Name
    - Quantity
    - Unit Price
</td>

</tr>
</table>

### API
Simple Invoice module which is approving or rejecting single invoice using information from existing approval module which tells if the given resource is approvable / rejectable. Only 3 endpoints are required:
```
  - Show Invoice data, like in the list above
  GET: http://localhost:8000/api/invoice/{id}
  
  Response payload:
  {
    "data": {
        "id": "060c3867-5691-4efd-9d0d-467b93e435c9",
        "number": "4df73c9d-dd7e-358b-9c1a-480bd3150186",
        "date": "1975-05-09",
        "due_date": "1990-08-26",
        "status": "approved",
        "company": {
            "name": "Waelchi, Goldner and Deckow",
            "street": "224 Marilyne Union",
            "city": "South Avis",
            "zip": "35297",
            "phone": "+1-573-417-1340",
            "email": "gina.blanda@example.net"
        },
        "products": [
            {
                "name": "coca-cola",
                "price": 3751257,
                "currency": "usd",
                "item": {
                    "quantity": 30
                }
            },
            {
                "name": "backpack",
                "price": 2333816,
                "currency": "usd",
                "item": {
                    "quantity": 91
                }
            },
            {
                "name": "t-shirt",
                "price": 4693063,
                "currency": "usd",
                "item": {
                    "quantity": 73
                }
            }
        ]
    }
  }
```

```
  - Approve Invoice
  POST: http://127.0.0.1:8000/api/invoice/{id}/approve
  
  Response payload:
  {
    "data": {
        "id": "d93358af-3a10-4cdf-80e7-24856c866b2c",
        "number": "3fc7432c-b467-3694-97f7-66b5f975e0c7",
        "date": "1988-12-24",
        "due_date": "1987-02-03",
        "status": "approved"
    }
  }
  
  Error Response:
  {
    "error": "approval status is already assigned"
  }
```
```
  - Reject Invoice
  POST: POST: http://127.0.0.1:8000/api/invoice/{id}/reject
  
  Respons payload:
  {
    "data": {
        "id": "d93358af-3a10-4cdf-80e7-24856c866b2c",
        "number": "3fc7432c-b467-3694-97f7-66b5f975e0c7",
        "date": "1988-12-24",
        "due_date": "1987-02-03",
        "status": "rejected"
    }
  }  
  
  Error Response:
  {
    "error": "approval status is already assigned"
  }

```

#### Unit test

* app/Modules/Invoices/Tests

```
./vendor/bin/phpunit
```

* Docker is in docker catalog and you need only do 
  ```
  ./start.sh
  ``` 
  to make everything work

  docker container is in docker folder. To connect with it just:
  ```
  docker compose exec workspace bash
  ``` 
