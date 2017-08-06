Opencart product update microservice
=======================================

# Installation

## Prerequisites

- PHP version 7.0 or higher

## Example

```bash
php api <worker_name>
```

Use with Supervisor
```
[program:<worker_name>]
command=php api <worker_name>
directory=/var/www/api_client
autostart=true
autorestart=true
startretries=3
stderr_logfile=/var/log/supervisor/<worker_name>.log
stdout_logfile=/var/log/supervisor/<worker_name>.log
user=www-data
```