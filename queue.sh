#!/bin/bash

# Defaults to an app server
role=${CONTAINER_ROLE:-queue}

echo "Container role: $role"

if [ "$role" = "queue" ]; then
    # Run queue
    while [ true ]
    do
      if [ -d "./vendor" ]
      then
        php artisan queue:work --queue=listeners --verbose --tries=3 --timeout=90 --no-interaction
      else
        echo "composer command is running...."
        sleep 60
      fi
    done
fi