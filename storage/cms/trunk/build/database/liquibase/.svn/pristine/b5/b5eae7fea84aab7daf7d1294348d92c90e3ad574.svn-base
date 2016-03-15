#!/bin/bash
#
# Fix database export
# By Kenneth Skertchly
# 2013/10/22
#
# Use this script to fix the changesets exported by liquibase.
# Should only be needed for the initial exports.
#
# Usage:
# fix_db_export.sh [filename]

# Add suffixes to database names
sed -i 's/`cccomus_reporting`/`cccomus_reporting${database.suffix}`/g' $1
sed -i 's/`cccomus`/`cccomus${database.suffix}`/g' $1
sed -i 's/`ccdata`/`ccdata${database.suffix}`/g' $1
sed -i 's/`cms`/`cms${database.suffix}`/g' $1
sed -i 's/`cardbank`/`cardbank${database.suffix}`/g' $1

# Fix liquibase bugs - https://liquibase.jira.com/browse/CORE-1260
sed -i 's/BIT(1)/TINYINT(1)/g' $1
sed -i 's/BIT/TINYINT(1)/g' $1
