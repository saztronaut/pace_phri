# pace_phri
working files for the pace web app

Files are written in php, html and javascript. Currently they run in WAMP with a MySQL database. (Add SQL for files)

# sessions.php, database.php
Need these files when connecting to the database. Always include sessions as this is for security
Change connecting password when transferring from wamp (PUBLIC FILES HERE)

Nav bar and basic content static throughout, only the central document changes
# main_index.php
Main shell of the pages. Shows navbar and main content and footer

# nav.php
Navigation bar

# login.js, signin.php, logout.js
Users must be able to sign up, log in and log out. 
[FOR ACTION - all pages using passwords should be hashed before parsing to server]

# register_form.php, register.php, register.js
New users choose a username, email address, password, method of data collection and enter the registration code [FOR ACTION - registration code currently not in use]
Username and email checked for uniqueness, non unique usernames are reported as errors on form
Non matching passwords error on form
Non valid email addresses error on form


# steps.php, getWeek.php
1. ascertain where the user is, regarding their steps (defined in "week"s) (getWeek.php)
2. display relevant motivational content and guidance for that week
3. display relevant step entry table

Baseline: 
Users must be able to enter their steps before being given a target.
Users must complete a minimum of 3 days within a 7 day epoch. The beginning of that qualifying 7 day epoch becomes the date of baseline. 
Users who do not enter sufficient step information continue at this level until sufficient data are supplied. 
When the date of baseline is established, the user is prompted to set a date to begin their step increase. This must be 7 days from baseline and can be up to 7 dates after the current date. 
[NOT DONE] Establishment of week 1 should expire (after a month?). This requires wiping of data or some kind of system override

Odd weeks
Targets are given for 2 weeks, the odd weeks are the first. Feedback should be given on progress akin to that in the booklet

Even weeks
If a participant achieves their target on an even week, they are given their next target
[NOT DONE] If a participant does not achieve their target on the even week, they should be asked if they would like to move on to the next week's worth of targets anyway. 
At the moment, if the target is not achieved the table simply keeps continuing. 

General functionality of the steps table
Participants can enter the number of steps, the method used to collect the step count, and whether they added a walk or not into their day. 
Participants can edit the step entries they have already entered.
Participants cannot add step counts for the future
Once a target is set, participants recieve feedback on whether they have achieved their goal or not
[NOT DONE] Participants can view historical data, looking back over the weeks
[NOT DONE] Participants can add/edit data in a previous week

# Targets
Show targets over the course of the program, weekly target achieved feedback

# Create registration code
For Research Assistant. Should be able to generate and download lists of registration code, specifying practice beforehand

# download data
Research Assistant should be able to download all of the data in the database

# reset password
Allows users to request an email to reset their password

# view users
Allow a super user to imitate a user and view the database as if they were that user.

# progress report
*Extension* Produce graphs to show the users progress over time

# Documents
Allow users to download documentation for PACE
