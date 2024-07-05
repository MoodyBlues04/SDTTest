# SDTTest

## Motivation

It's test task

## Requirements

- php>=7.4
- mysql
- mysqli

## Installation

- ```git clone git@github.com:MoodyBlues04/SDTTest.git```

## Usage

- run ```php public/migrate.php``` to set up db structure
- run ```php public/seed.php``` to set up test db data (customers & merchandise)
- run ```php public/upload.php test_data``` to upload rows from ```test_data.csv```. Invalid rows you can find in ```errors.csv```
- run ```php public/request.php [request_type]``` to send select request. request type may be a/b/c/d - by the number of task

## Indexes
Есть смысл использовать индексы для полей ```clients.name```, ```merchandise.name```, так как поля уникальны и по ним часто будут производиться запросы.
Также для foreign id в ```orders```, ```orders.order_date``` также имеет смысл проиндексировать из-за обилия запросов по нему, но если в 1 день много заказов, то order_date будет низко селективным,
а значит создание индекса не целесообразным.
В любом случае использование индексов в данном случае ситуативно