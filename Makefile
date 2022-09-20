#!/bin/sh

# When you run 'make' without specifying the target name it will try to execute the first target. #
# You can avoid this by setting the next special variable. #
.DEFAULT_GOAL := help
#.PHONY: install install-prod test info help
#.PHONY: *
.PHONY: $(filter-out vendor node_modules, $(MAKECMDGOALS))

install:
	composer install
	composer phpunit

install-prod:
	composer install-prod

test:
	@composer test

# To avoid outputting command, add '@' character in front of the target recipes. #
help:
	@echo Silence is golden

# Default 'Make' behavior is try remaking the targets files when prerequisite files are changed. #
# targets: prerequisites #
#		recipe	#
#		... 	#
vendor: composer.json $(wildcard composer.lock) ## Install PHP application
	@composer install

# Notice that 'vendor' target is not a phony target in this case. SO this will execute the recipe only when #
# the 'composer.json' or 'composer.lock' files are changed. #

node_modules: $(wildcard package.json) $(wildcard package.lock) ## Install Node modules
	@npm install

# Make is by default dedicated to generating executable files from their sources and all target names are files in the project folder. #
# Most common usage of Make are compiled languages such as C. #

# The built-in '.PHONY' target defines targets which should execute their recipes even if the file with the same name as target is present in the project. #
# When you're adding a 'Makefile' in your project you should define all custom targets as phony to avoid issues if file with same name is present in the project. #