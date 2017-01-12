# Maple
A Web Interface to Maplesoft Maple

## About
* PHP interfaces between the script entered and cmaple, a command line interface for Maple.
* Additionally the script and its output are parsed and merged together to show the direct effects of each entered command.
* Example Maple scripts based on my Calculus 3 curriculum are included to show some of Maple's basic and sophisticated tools.
* [See it in action](https://pavandayal.com/maple/)

## Notice
* The server hosting this website must have maple installed and the path to cmaple must be included in the PATH. Also if the server is running Windows, then the php code that executes the shell script and the shell script itself will need to be modified to Windows Batch.
* In order for exporting plots to work, make a folder called 'plots' and make sure that the webserver has permission to write to that folder.
