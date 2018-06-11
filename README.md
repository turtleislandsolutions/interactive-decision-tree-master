## Introduction

This is a fork of [HungryMedia's Interactive-Decision-Tree](https://github.com/hungrymedia/interactive-decision-tree)
which is a great tool for quickly implementing web-based decision trees.  Decision trees are a userful way for law-related sites to
help users evaluate potential claims. More information about this project is available on the [LoyolaLawTech site](http://loyolalawtech.org/github-forking-and-access-to-justice/).

A demo decision tree which helps users with criminal records expungements is [available here](http://loyolalawtech.org/idt/index.php?1374682207).

A demo of the admin backend can be found [here](http://loyolalawtech.org/idt/private/login.php) [user:admin, pass: admin].

A PhoneGap-ready implimentation of the frontend for mobile can be found at [https://github.com/judsonmitchell/idt-mobile](https://github.com/judsonmitchell/idt-mobile);

## Requirements

* PHP, with cURL installed
* MySQL

## Features

* Authenticated users can create or edit decision trees using a simple web-based tool.  Just log in to the admin backend and select "Create a New Decision Tree."
* A disclaimer can be added which the user must accept before proceeding to the tree.
* Includes a database to store potential referrals (lawyers, free legal service providers, etc).  Users can be prompted to see a list of referrals 
in their area by adding the prompt text anywhere in the decision tree, enclosed in double curly braces (e.g, "{{ Get a referral }}").
* User clicks on referral sources can be tracked in the included database.
* Admins can run reports on user clicks on referral sources.
* Trees can be themed using themes from [Bootswatch](http://bootswatch.com/);

## Install
    git clone https://github.com/judsonmitchell/interactive-decision-tree.git

* Add the schema in schema.sql to your database.  
* Put your db credentials in _CONFIG.php.
* Navigate to http://[YOUR SERVER NAME]/interactive-decision-tree/private/editTree.php in your browser.
* Login using the default username and password (admin/admin) [Note that there is no UI for adding new administrators; 
you must add new ones in the db manually; code expects for the password to be sha1 hashed; please delete the default account
once you have set up].
* Begin creating your decision tree.

## Mobile

A port of this project optimized for mobile apps using [PhoneGap Build](https://build.phonegap.corm) can be found [here](https://github.com/judsonmitchell/idt-mobile). 

##License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
