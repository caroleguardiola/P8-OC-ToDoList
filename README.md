# P8-OC-ToDoList

Improve an [existing Symfony application of ToDo&Co](https://github.com/saro0h/projet8-TodoList).
It is an application to manage daily tasks.

This project is the 8th done as part of my training (« Développeur d’applications-spécialité PHP/Symfony » OC).

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/350922d42cc2497d8ddc1fa4034f8f6e)](https://www.codacy.com/app/caroleguardiola/P8-OC-ToDoList?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=caroleguardiola/P8-OC-ToDoList&amp;utm_campaign=Badge_Grade) [![Codacy Badge](https://api.codacy.com/project/badge/Coverage/350922d42cc2497d8ddc1fa4034f8f6e)](https://www.codacy.com/app/caroleguardiola/P8-OC-ToDoList?utm_source=github.com&utm_medium=referral&utm_content=caroleguardiola/P8-OC-ToDoList&utm_campaign=Badge_Coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/caroleguardiola/P8-OC-ToDoList/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/caroleguardiola/P8-OC-ToDoList/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/caroleguardiola/P8-OC-ToDoList/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/caroleguardiola/P8-OC-ToDoList/?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/962611aa9686c749ef95/maintainability)](https://codeclimate.com/github/caroleguardiola/P8-OC-ToDoList/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/962611aa9686c749ef95/test_coverage)](https://codeclimate.com/github/caroleguardiola/P8-OC-ToDoList/test_coverage)
[![Build Status](https://travis-ci.org/caroleguardiola/P8-OC-ToDoList.svg?branch=master)](https://travis-ci.org/caroleguardiola/P8-OC-ToDoList)


## Instructions for this project:

The application is developed with Symfony.

The purpose is to improve the quality of the application by making those tasks:
* Implement new features
* Correct some anomalies
* Implement automated tests
* Make an analysis of the project to check the code quality and the performance of the application


There is 3 types of users which can access to the application:
* 	Anonymous: 
	* 	Can only access to the login page
* 	Authenticated user: 
	In addition to anonymous access can also:
	*	Consult the homepage
	* 	Consult the list of the tasks
	*   Create a task
	*   Edit tasks
	*   Mark tasks as done / not done
	*   Delete his own tasks
* 	Authenticated admin 
	In addition to user authenticated access can also:
	*	Delete Anonymous Tasks (created tasks when they were not linked to a user (user or admin))
	*	Consult the list of the users
	*	Create a user
	*	Edit users


## Dependencies:

This project was developed with Symfony 3.1 initially and installed with the dependencies by Composer. Then it was upgraded to Symfony 3.4.

Bundle installed by composer:
*  DoctrineFixturesBundle

PHPUnit is installed too.

This project uses also:
* Bootstrap 3.3.7
* Font Awesome 5.1.0
* Google Fonts
* jQuery 1.12.4
* Isotope
There are included with CDN.


## Installation:

1.	Clone or Download this repository on your local machine.

	Click on the **"clone and download"** button at the top right of the repository.
	Then click on the copy to clipboard icon, return to your terminal and run the git command:
	```
	git clone https://github.com/caroleguardiola/P8-OC-ToDoList.git
	```

	You can also download the ZIP with the button "Download ZIP".

	Here you're copying the contents of the "P8-OC-ToDoList" repository in GitHub to your local machine in a directory called like the repository: "P8-OC-ToDoList".

	The new directory "P8-OC-ToDoList" is created in the path where you are when you do the git clone.

	To go to this directory, run this command:
	```
	cd P8-OC-ToDoList/
	```

2.	Install composer: https://getcomposer.org/ if you don't have it yet

3.	In the project directory return to your terminal and execute command line: 

	```
	composer install
	```

4. 	Create the configuration in /app/config/parameters.yml:

	Copy /app/config/parameters.yml.dist and rename it in /app/config/parameters.yml and update with your parameters.

5. 	Create the database, the schema and load initial datas with 5 tasks ans 5 users linked to those tasks (P8-OC-ToDoList/src/AppBundle/DataFixtures/ORM/LoadFixtures.php): 

	```
	php bin/console todolist:loaddatas
	```
	
7. 	You can upgrade the version of Symfony and PHP if you want or any dependencies: 
	Update composer.json and execute command line:

	```
	composer update
	```


**NB:** 
*For this project a command has been created to attribute a role "ROLE_USER" to the users without role. Indeed, in the original project the attribute "role" to users didn't exist.*
*This command was ((P8-OC-ToDoList/src/AppBundle/Command/UpdateRoleUserCommand.php):*
```
php bin/console todolist:updateroleuser
```
*But now it is not necessary because the attribute not null "role" has been add in the entity "User".*


Everything is now ready to work !


## Quality Process

#### Code review
For this project we use those free code reviewers that automates code reviews and monitors code quality over time:
* [Codacy](https://www.codacy.com/) 
* [Scrutinizer](https://scrutinizer-ci.com/)
* [Code Climate](https://codeclimate.com/)

We've used too for one analysis [SensioLabsInsight](https://insight.sensiolabs.com/) that is specialized for Symfony.

#### Testing

For this project, we use **PHPUnit** for unit tests and functionals tests.
A code coverage has been done, you can find it in the directory **documentation/test-coverage**.

Continuous integration has been implemented with [Travis CI](https://travis-ci.org/).

### Performance
	
To check the performance impact of this project, we use [Blackfire](https://blackfire.io/).


## Contributing

To contribute to this project, read [ToDoList - How to contribute](https://github.com/caroleguardiola/P8-OC-ToDoList/blob/master/documentation/Contributing%20to%20the%20project.md)


## Documentation

In the folder "documentation", you can find some documentations:
* Authentication
* How to contribute
* Code and performance quality audit
* test/coverage

Thanks for reading !