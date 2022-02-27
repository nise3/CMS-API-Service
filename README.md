# NISE 3 CMS API Service 

## In order to release a version to the cluster through CI/CD pipeline
```shell
RELEASE = 'php artisan migrate:fresh --seed'
RELEASE = 'php artisan list'
```

## RabbitMQ consume command
```shell
php artisan queue:work --queue=cms.batch.calender.q
```
