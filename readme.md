# Demo CSV Importer

This application is designed to be a companion to a series of articles on the Zaengle website illustrating one way to import csv data into a Laravel application.

You can read the articles here: 
- Part 1: [Uploading, Storing, and Mapping CSV Data](https://zaengle.com/blog/building-a-csv-importer-part-1)
- Part 2: [Processing and Distributing the Individual Rows](https://zaengle.com/blog/building-a-csv-importer-part-2)
- Part 3: [Error Handling and Status Updates](https://zaengle.com/blog/building-a-csv-importer-part-3)

It's not required that you install the demo application to go through the articles, but we've provided the instructions to do so if you desire. Otherwise you can use this repository as a reference since the articles only contain certain snippets of the code.

## Installation

1. Download this repository to your local machine and follow your environment-specific steps to get it running.
2. Rename `.env.example` to `.env` and update the values to match your system. (You probably only need to update the database configuration.)
3. Run `php artisan key:generate` to create your application key
4. Run `php composer install` to gather the required packages.
5. Run `php artisan migrate` to populate the necessary database tables.
6. Finally, run `yarn install` and `yarn dev` to generate the assets

At this point you should be able to visit the site using the domain you configured and adding `/csv-uploads`.