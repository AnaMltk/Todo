# Contributing
## Installing the project

Clone the repository https://github.com/AnaMltk/Todo.git.
For the detailed installation instructions as well as requirements please refer to [README](./README.md). 

## Code style Guidelines

This project strives to follow PHP Standart Recommendations. 
Please visit https://www.php-fig.org/psr for more information on the subject.

To ensure that your code meets the standarts, we reccomend the usage of plugins for your IDE. 
We also strongly recommend performing analysis at Codacy every time you submit a pull request. 

The code should stick to the PHP Strandard Recommendations.
The code should also stick to Symfony coding standard.
To help you follow these rules Codacy is used to monitor the quality of the code when a pull request is submitted.

## Testing

We use PHPUnit to conduct automated tests, both unit and functional. We recomend to write tests for every new function that you develop.
A total test coverage should rest at minimum 70%. 

We have the following logic when conducting automated tests : 

- Entities should be tested with unit tests
- FormTypes should be tested with unit tests
- Controllers should be tested with functional tests
- Repositories should be tested with functional tests

To monitor code coverage we suggest the use of XDebug

We recomend running automated tests before each pull request.
