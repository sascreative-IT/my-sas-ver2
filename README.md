
# Start dev env
sail up -d

# Shutdown dev env 
sail down 

# Run migration
sail artisan migrate

# Run migration with seeding 
sail artisan migrate:fresh --seed



## Credentials 
email: test@example.com
password: test
