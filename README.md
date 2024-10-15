# COMP 3512 - F1 Dashboard Project 

## Overview
This repostiory holds the code for Assignment #1 for COMP 3512 at Mount Royal University. The aim of this project is to build a data-driven PHP-based web application using data from Formula 1 races. The project focuses on the 2022 season, allowing users to explore race results, driver performances, and constructor standings. It includes a series of web APIs and web pages that showcase the functionality of these APIs, leveraging a SQLite database for data storage and retrieval.

## Features 
- Browse Race Results: Explore all the races from the 2022 season and their results, including race times, fastest laps, and finish positions.
- Driver Information: View detailed information about each driver, including their results for the 2022 season.
- Constructor Information: Explore the constructors' performance for the season.
- API Access: A set of RESTful APIs allows you to query circuits, drivers, constructors, race results, and more.

## Technologies Used
- HTML, CSS, PHP, MySQL, Semantic UI

## Main Project Files
- index.php - Home page of the F1 Dashboard project, introducing the 2022 season.
- browse.php - Page to browse through all races of the 2022 season, including their details and results.
- drivers.php - Displays information on drivers and their race results for the season.
- constructors.php - Shows constructors' details and results for the 2022 season.
- api-tester.php - Contains all API routes for retrieving data in JSON format.
  
## API Routes
- /api/circuits.php: Returns all circuits for the 2022 season.
- /api/circuits.php?ref=monaco: Returns details of the specified circuit (e.g., Monaco).
- /api/constructors.php: Returns all constructors for the 2022 season.
- /api/constructors.php?ref=mclaren: Returns details of the specified constructor.
- /api/drivers.php: Returns all drivers for the 2022 season.
- /api/drivers.php?ref=hamilton: Returns details of the specified driver.
- /api/races.php: Returns all races for the 2022 season.
- /api/results.php?ref=1106: Returns race results for the specified race.

