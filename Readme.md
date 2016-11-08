# Squirrel Release Server

![logo](https://arcath.net/wp-content/uploads/2016/11/squirrel-release-server.png)

Squirrel Release Server is a low featured update server for squirrel on windows.

It supports:

 - Squirrel.Windows
 - Delta updates

# Install

Clone this repository to your web server. It can be servered from a subfolder if you like.

Run `composer install` to install the dependecies.

Create a `releases` folder with a `win32` and `win64` subfolder.

Configure your squirrel server to update from `http://yoursite.com/path/releases/win64` (or 32).

## Releasing an update

Place the nupkg for your update in the correct releases folder (64 bit in `releases/win64`) and thats it! you can put the `-full` and `-delta` packages in here and squirrel will chose the lowest file size path to the latest version.

# Contributing

This release server does everything I need it to but I welcome any improvements people have to offer.
