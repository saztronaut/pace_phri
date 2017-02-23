# pace_phri
working files for the pace web app

Files are written in php, html and javascript. Currently they run in WAMP with a MySQL database. (Add SQL for files)

## Basic functionality
### sessions.php, database.php
Need these files when connecting to the database. Always include sessions as this is for security
Change connecting password when transferring from wamp (PUBLIC FILES HERE)

Nav bar and basic content static throughout, only the central document changes
### main_index.php
Main shell of the pages. Shows navbar and main content and footer

### nav.php, loggedon.php, footer.php
Navigation bar incorporated loggedon.php which determines whether the user is logged in or not. If not logged in shows "Sign up / Sign in" options if logged in shows "Hello User/ Log out" and "Admin" if user role permits. Footer shows all the logos
[For action

### login.js, signin.php, logout.js
Users must be able to sign up, log in and log out. 
**[FOR ACTION - all pages using passwords should be hashed before parsing to server. Passwords should have some validation i.e. be at least 8 chars long]**

## Registration
### register_form.php, register.php, register.js, method.php,
New users choose a username, email address, password, method of data collection (method.php) and enter the registration code [FOR ACTION - registration code generate form created but code parsing not currently not in use]
Username and email checked for uniqueness, non unique usernames are reported as errors on form
Non matching passwords error on form
Non valid email addresses error on form

## Entering, editing, viewing steps, receiving feedback, etc
### steps.php, getWeek.php, drawTable.php, viewSteps.php
1. ascertain where the user is, regarding their steps (defined in "week"s) (getWeek.php)
2. If necessary, update the target (function drawn in getWeek.php)
3. display relevant motivational content and guidance for that week
4. display relevant step entry table (drawTable.php)

####Baseline: 
Users must be able to enter their steps before being given a target.
Users must complete a minimum of 3 days within a 7 day epoch. The beginning of that qualifying 7 day epoch becomes the date of baseline. 
Users who do not enter sufficient step information continue at this level until sufficient data are supplied. 
When the date of baseline is established, the user is prompted to set a date to begin their step increase. This must be 7 days from baseline and can be up to 7 dates after the current date. 
[NOT DONE] Establishment of week 1 should expire (after a month?). This requires wiping of data or some kind of system override

####Odd weeks
Targets are given for 2 weeks, the odd weeks are the first. Feedback should be given on progress akin to that in the booklet

####Even weeks
* If a participant achieves their target on an even week, they are given their next target
* If a participant does not achieve their target on the even week, they are not given a new target. If they achieve their target in a subsequent week, they then progress to the next target
* [DONE] If a participant does not achieve their target on the even week, they should be asked if they would like to move on to the next week's worth of targets anyway.  

####General functionality of the steps table
* Participants can enter the number of steps, the method used to collect the step count, and whether they added a walk or not into their day. 
* Participants can edit the step entries they have already entered.
* Participants cannot add step counts for the future
* Once a target is set, participants recieve feedback on whether they have achieved their goal or not
* [DONE] Participants can view historical data, looking back over the weeks. 
* [DONE] Participants can add/edit data in a previous week

### progress report
*Extension* Produce graphs to show the users progress over time

## Administrative functions
### admin.php
[DONE] Allow a super user to access download data, add practice, create registration code 
[NOT DONE] Allow a super user to allocate a role to another user, for example Researcher, Nurse or Superuser 

### Create registration code getCodes.php, get_reg_codes.php, WEB ONLY NOT APP
* getCodes.php - HTML JS basic form to complete to get the registration codes
* get_reg_codes.php - PHP create new registration codes

For Research Assistant. Should be able to generate and download lists of registration code, specifying practice beforehand
getCodes.php is the data entry form and get_reg_codes.php processes the data. 
AT THE MOMENT THE DATA WON'T DOWNLOAD! BUG NEEDS FIXING

### download data downloadData.php
Research Assistant should be able to download all of the data in the database
As SKB can't get the download function to work, first write up the code to generate the csv in text form and then worry about the download function later

### reset password createPasswordToken.php, forgotpass.php, process_pwd_reset.php, reset_password.php, resetpwd.php
* reset_password.php - HTML JS data entry for to create the password token
* createPasswordToken.php - PHP creates the token to be used to reset the password. Hashed token is stored in dB
* forgotpass.php - PHP when the user follows the link in the email they land on this page. This page reads the token,  determines whether it is valid or not. If it is it sends user to resetpwd.php
* resetpwd.php - HTML JS Asks for the users email address and new password (x2) - send to process_pwd_reset.php
* process_pwd_reset.php - PHP Checks the user for the token against the user for the email provided, updates the password, deletes the tokens for that user, nukes the session.

### view users
allow a super user to view another users data

### add-practice.php addPractice.php
* addPractice - HTML JS code to add a new practice
* add-practice - PHP code to add that practice to the DB
[DONE] Allow a super user to add new practice to database. Ensures new practice ID is 3 char long and not already in use.

## Explaining the study and extra info
### Targets
Show architecture of 12 weeks, explain how steps work (explanation only, can get data from database as extension)

### links page
[DONE] Show the links from the booklet. Should be able to view even if not logged in [checked]

### Documents
Allow users to download documentation for PACE

## Old files to be deleted
* firstSteps.php - this became redirect.php
* index.php - this became redirect.php
* updateTargets2.php - this became redirect.php
* steps_process.php - this became getWeek.php and drawTable.php
