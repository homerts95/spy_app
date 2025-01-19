#!/bin/bash
set -e

# Ensure that required environment variables are set
if [ -z "$DB_USERNAME" ] || [ -z "$DB_PASSWORD" ] || [ -z "$POSTGRES_PASSWORD" ] || [ -z "$DB_DATABASE" ]; then
  echo "Error: DB_USERNAME, DB_PASSWORD, POSTGRES_USER, and POSTGRES_DB must be set."
  exit 1
fi

# Prevent SQL injection
if [[ ! "$DB_USERNAME" =~ ^[a-zA-Z0-9_]+$ ]]; then
  echo "Error: Invalid DB_USERNAME. Use only alphanumeric characters and underscores."
  exit 1
fi

echo "Creating database..."
psql -U "postgres" -d "postgres" <<-EOSQL
  CREATE DATABASE $DB_DATABASE;
EOSQL

# Create user and grant necessary privileges for Laravel migrations
echo "Creating user with Laravel-required privileges..."
psql -U "postgres" -d "$DB_DATABASE" <<-EOSQL
  -- Create user with secure password
  CREATE USER $DB_USERNAME WITH ENCRYPTED PASSWORD '$(echo $DB_PASSWORD | sed -e "s/'/''/g")';

  -- Grant basic connection privileges
  GRANT CONNECT ON DATABASE $DB_DATABASE TO $DB_USERNAME;

  -- Grant all privileges on schema public (needed for migrations)
  GRANT ALL PRIVILEGES ON SCHEMA public TO $DB_USERNAME;

  -- Grant privileges on all tables and sequences
  GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO $DB_USERNAME;
  GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO $DB_USERNAME;

  -- Set default privileges for future objects
  ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT ALL ON TABLES TO $DB_USERNAME;

  ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT ALL ON SEQUENCES TO $DB_USERNAME;

  -- Make the user the owner of the public schema (needed for migrations)
  ALTER SCHEMA public OWNER TO $DB_USERNAME;
EOSQL

echo "Database user created"
