# ToDoList - How to contribute

Improve an existing Symfony application of ToDo&Co.
It is an application to manage daily tasks.

To contribute to this project, follow the steps below.

#### *Before follow those steps, you must install [git](https://git-scm.com/) and [composer](https://getcomposer.org/) on your local machine and create an Github account.*


## Step 1 - Get the repository

#### 1. 	Firstly you need a local fork of the project.

So fork the "P8-OC-ToDoList" repo by clicking on the "fork" button on the top of this page.
This will create a copy of this repository in your own Github account and you’ll see a note that it’s been forked underneath the project name: "forked from caroleguardiola/P8-OC-ToDoList".

#### 2. 	Now you need a copy locally. So clone your copy from GitHub on your local machine.

Click on the "clone and download" button at the top right of the repository.
Then click on the copy to clipboard icon, return to your terminal and run the git command:
```
git clone https://github.com/YOUR-GITHUB-USERNAME/P8-OC-ToDoList.git
```
where `YOUR-GITHUB-USERNAME` is your Github username.

You can also download the ZIP with the button "Download ZIP".

Here you're copying the contents of the "P8-OC-ToDoList" repository in GitHub to your local machine in a directory called like the repository: "P8-OC-ToDoList".

The new directory "P8-OC-ToDoList" is created in the path where you are when you do the git clone.

To go to this directory, run this command:
```
cd P8-OC-ToDoList/
```

#### 3. 	Add the original P8-OC-ToDoList repository as a "Git remote" called `upstream`.

Your remote repo on Github is called `origin`.

In this stage, if you want to keep your fork synced with the original P8-OC-ToDoList repository, you need to set up a new remote that points to the original project so that you can grab any changes and bring them into your local copy. 

Firstly click on the link to the original repository – it’s labeled “Forked from” at the top of the GitHub page. This takes you back to the main project's GitHub page, so you can find the “SSH clone URL” and use it to create the new remote, which we’ll call `upstream`.

Add the original P8-OC-ToDoList repository as a "Git remote" executing this command:
```
cd P8-OC-ToDoList/
git remote add upstream https://github.com/caroleguardiola/P8-OC-ToDoList.git
```

Verify the new upstream repository you've specified for your fork:
```
git remote -v
origin    https://github.com/YOUR-GITHUB-USERNAME/P8-OC-ToDoList.git (fetch)
origin    https://github.com/YOUR-GITHUB-USERNAME/P8-OC-ToDoList.git (push)
upstream  https://github.com/caroleguardiola/P8-OC-ToDoList.git (fetch)
upstream  https://github.com/caroleguardiola/P8-OC-ToDoList.git (push)
```

You now have two remotes for this project on disk:

1. 	`origin` which points to your GitHub fork of the project. You can read and write to this remote.
2. 	`upstream` which points to the main project’s GitHub repository. You can only read from this remote.

Fetch all the commits of the upstream branches by executing this command:
```
git fetch upstream
```

The purpose of this step is to allow you work simultaneously on the official P8-OC-ToDoList repository and on your own fork.



## Step 2 - Work on the project

1. 	Install the project by referring to README.md, part [Installation](https://github.com/caroleguardiola/P8-OC-ToDoList/blob/master/README.md#L62) step 2.

2. 	Change to the repository directory on your computer (if you are not already there):
	```
	cd P8-OC-ToDoList/
 	```

3. 	Create a dedicated **new branch** for your changes. 

	Use a short and memorable name for the new branch (if you are fixing a reported issue, use fix_XXX as the branch name, where XXX is the number of the issue):
	```
	git checkout -b my-new-feature upstream/features
	```

	In this example, the name of the branch is `my-new-feature` and the `upstream/features` value tells Git to create this branch based on the features branch of the upstream remote, which is the original P8-OC-ToDoList repository.

	Fixes should always be based on the **oldest maintained branch** which contains the error. 
	If you are instead documenting a new feature, switch to the upstream/features branch.
	If you are not sure, use the upstream/master branch.

3. 	Make your changes.

	#### *Before making your changes, read the [best practices](#making-your-code-follow-the-coding-standards-and-quality-process) below.*


4. 	Commit your changes:

	If the modified content existed before:
	```
	git commit -am 'Add some feature'
	```

	If the modified content not existed before:
	```
	git add Feature.php
	git commit -m 'Add some feature'
	```

	**Make sure to write clear commit messages.**

5. 	Push the changes to your forked repository:
	```
	git push origin my-new-feature
	```
	
	The `origin` value is the name of the Git remote that corresponds to your forked repository and `my-new-feature` is the name of the branch you created previously.
	This will create this branch on your GitHub project.


## Step 3 - Propose your changes to the project

#### 1. 	Create a Pull Request

Everything is now ready to initiate a **pull request**. 
Go to your forked repository at `https://github.com/YOUR-GITHUB-USERNAME/P8-OC-ToDoList` and you'll see that your new branch is listed at the top with a handy “Compare & pull request” button. Then click on that button.

On this page, ensure that the **base fork** points to the correct repository and branch. 
In this example, the **base fork** should be `caroleguardiola/P8-OC-ToDoList` and the **base branch** should be the `features`, which is the branch that you selected to base your changes on. 
The **head fork** should be `YOUR-GITHUB-USERNAME/P8-OC-ToDoList` (your forked copy of P8-OC-ToDoList) and the compare branch should be `my-new-feature`, which is the name of the branch you created and where you made your changes.

Then ensure that you provide a good, succinct title for your pull request and explain why you have created it in the description box. 
Add any relevant issue numbers if you have them.

#### 2. 	Submit the Pull Request

Now you must submit the Pull Request to the original P8-OC-ToDoList repository.
In order to do this, press the **“Create pull request”** button and you’re done.

#### 3. 	Review by the maintainers.

For your work to be integrated into the project, the maintainers will review your work and they will let you know about any required change or merge it.

In case you are asked to add or modify something, don't create a new pull request. Instead, make sure that you are on the correct branch, make your changes and push the new changes:
```
cd P8-OC-ToDoList
git checkout my-new-feature
```

Do your changes and:
```
git push
```

#### 4. 	Sync your fork with the original repository after changes

The master branch of your fork won’t have the changes. In order to keep your fork synchronized with the original P8-OC-ToDoList repository, follow the steps below:

Once the changes are merged in the original P8-OC-ToDoList repository, pull its new version:
```
git pull upstream master
```

For your fork to have the changes:
```
git push origin master
```
Notice here you’re pushing to the remote named origin.



## Making your Code Follow the Coding Standards and Quality Process

#### 1. 	Coding Standards

To make every piece of code look and feel familiar, Symfony defines some coding standards that all contributions must follow.

So make sure your code respects:

* [Symfony Coding Standards](https://symfony.com/doc/3.4/contributing/code/standards.html)
* [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
	* [PSR-1](https://www.php-fig.org/psr/psr-1/)
	* [PSR-2](https://www.php-fig.org/psr/psr-2/)
	* [PSR-4](https://www.php-fig.org/psr/psr-4/)
* [Symfony Best Practices](https://symfony.com/doc/3.4/best_practices/index.html)
* [Symfony Conventions](https://symfony.com/doc/3.4/contributing/code/conventions.html)

Please follow this recommendations too:

* Have a readable code, use understandable variable names, extract functions if needed, avoid too complex code
* In your comments explain why you did that

Install the [PHP CS Fixer](https://cs.sensiolabs.org/) tool and then, run this command to fix any problem of code syntax: 
```
cd your-project/
php php-cs-fixer.phar fix -v
```

For Windows, you must run this command:
```
php-cs-fixer fix your-project
```

Read more about [PHP CS Fixer](https://cs.sensiolabs.org/) if you need.

#### 2. 	Quality Process

#### Code review

For this project we use those free code reviewers that automates code reviews and monitors code quality over time:
* [Codacy](https://www.codacy.com/) 
* [Scrutinizer](https://scrutinizer-ci.com/)
* [Code Climate](https://codeclimate.com/)

We've used too for one analysis [SensioLabsInsight](https://insight.sensiolabs.com/) that is specialized for Symfony.

You can use them to check your code or you can also use an other automated code review tool.

### Testing

For this project, we use **PHPUnit** for unit tests and functionals tests and we have made a code coverage that you can find in the directory *documentation/test-coverage*.

So follow this steps:
* Run regularly PHPUnit in order to check the code
* Implement your own tests but ensure that not decrease the code coverage
* Ensure you don't change existing tests

Continuous integration has been implemented with Travis CI.

If you need, read more about [PHPUnit](https://phpunit.de/), [Symfony Testing](https://symfony.com/doc/3.4/testing.html), [Travis CI](https://travis-ci.org/).

### Performance
	
To check the performance impact of this project, we use [Blackfire](https://blackfire.io/), so use it too.


Thanks for contributing !
