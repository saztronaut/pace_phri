# pace_phri
working files for the pace web app

Files are written in php, html and javascript. Currently they run in WAMP with a MySQL database. (Add SQL for files)

## Branding
* PACE-UP spelled with capitals
* From logo - Purple is hex #723F97, Green is hex #72C049
* Limit references to trial (confusing)
* Supported by SGUL logo, "Supported by NHS Natioanl Institute for Health research" Do Not Use NIHR logo.
* Text: The research is supported by the National Insitute for Health research (NIHR) Collaboration for Leadership in Applied health * Research and Care (CLARHRC) South London at King's College Hospital NHS Foundation Trust. The research is funded by St George's, University of London Strategic Investment Fund.  

## Privacy and Cookies
Cookies and Privacy Policy stored under cookies.php and privacy.php
On registration, users consent to privacy and cookies.

## Basic functionality
### Starting sessions
sessions.php, database.php
Need these files when connecting to the database. Always include sessions as this is for security
Change connecting password when transferring from wamp (PUBLIC FILES HERE)

Nav bar and basic content static throughout, only the central document changes

### Template
* main_index.php
Main shell of the pages. Shows navbar and main content and footer

* nav.php - Navigation bar incorporated loggedon.php which determines whether the user is logged in or not.
* loggedon.php -  If not logged in shows "Sign up / Sign in" options if logged in shows "Hello User/ Log out" and "Admin" if user role permits.
* footer.php-  Footer shows all the logos

## Users must be able to sign up, log in and log out.
### logging in and logging out
* signin.php -html input form for logging in
* login.js  -javascript to send datafrom signin to login.php
* login.php  -php to log user in and begin session
* logout.js - end session
**[FOR ACTION - all pages using passwords should be hashed before parsing to server. Passwords should have some validation i.e. be at least 8 chars long]**

### Registration
* register_form.php -html form int which to enter registration data
* register.js - validates the registration data and sends to register.php
  * call drawMethodsSelect to draw method ddl
  * New users choose a username, email address, password, method of data collection (method.php) and enter the registration code
  * call *registerNewUser()* >> call validateRegistration()
  * *validateRegistration* calls: validateUser, validateEmail, validateCopy
  * *validateUser* - username - must be letters, numbers or underscores. first and last names allow spaces but no numbers
  * *validateEmail*- checks has email format
  * *validateCopy* - password must be 8 digits long (at least) and contain at least one letter and at least one number. Copy must match original
  * *giveFeedback* - if any of the validations fail, this function is used to inform the user
  * *getConsent* - if passes all validation - check registration, extract consent information and show consent modal. If the individual has sent back their postal consent, we only need to have consent for privacy and cookies. I have added in "I consent to take part in the study" as well. We do really want the postal consent forms, but in the interim we will get digital consent and then chase them. 
  * *continueConsent* - activated by a button in *getConsent*. This checks that the necessary consent has been given and then uses *makeRequest* to send the data to **register.php** which should create a new user. New users are then sent to "intro.php".
  
  * Username and email checked for uniqueness, non unique usernames are reported as errors on form
  * Non matching passwords error on form
  * Non valid email addresses error on form
* register.php -validates the registration data
* method.php - retrieve list of methods from the methods table
* drawMethodsSelect - uses the list of methods and creates a select control from which the user can select their preferred method of step collection


## Entering, editing, viewing steps, receiving feedback, etc
### steps2.php, getWeek.php, drawTable2.php,
### drawStepsTable.js, drawHeader.js, drawMethodsSelect.js

1. ascertain where the user is, regarding their steps (defined in "week"s) -on load, call "showWeek"
2. If necessary, update the target (function drawn in getWeek.php)
3. display relevant motivational content and guidance for that week
4. display relevant step entry table (drawTable.php)

*showWeek* 
- retrieve methods list from getMethods.php. var - methods
- uses session cookie "username" (+true/false argument and optional parameter "weekno") to retrieve data from getWeek.php. The data are stored as "weekdata" and the values are: week (a text description of the week), weekno (numeric descriptor), refresh (after event -see below- . if this is yes, the page should be refreshed), steps (target daily steps), days (target days to achieve), latest_t (date of latest target set), comment(text data to accompany that week), baseline (the baseline number of steps), maxweekno (this is relevant when viewing the past - maxweekno is the week that the participant is currently on, not the week they are viewing). 
- getWeek.php checks the targets are up to date and corrects this if necessary
- showWeek then uses *week*, *weekno* and *comment* as parameters in drawHeader2 to fill out the text surrounding the steps table.
- show week calls drawTable, sending "weekdata", methods and past (i.e. viewing past true/false)

*drawTable*
- sends weekdata to drawTable2 and retrieves tabledata. this comprises: 
   * n_show - the number of weeks to show [ if a participant does not hit a target, then they stay on the even week unless they choose otherwise], 
   * bump - 0/1 show button to increase target, 
   * newweek (if bump, this is the date the new target starts), 
   * tableResults - for each week to show 
      - {for each week: ispast (is this particular week table in the past or the current week), 
        targetsteps (target number of steps), 
        targetdays (target number of days), 
        totalsteps (total step count) 
        showrow (for each date in week:
           the day of the week, 
           the date, 
           add_walk (0/1 did the participant add a walk of 15/30 mins), 
           give_pref (if there is step data, the device identified when entering data otherwise their default device), 
           stepsread (number of steps read)}, 
- looks a bit like this:
Day | Date | HasWalk | Steps | Device | Feedback | Button 
--- | --- | --- | --- | --- | --- | ---
Monday | 20-03-2017 | walk2017-03-20 | steps2017-03-20 | method2017-03-20 (PED) | |saveBtn2017-03-20
Tuesday | 21-03-2017 | walk2017-03-21 (on) | steps2017-03-21 (7890) | method2017-03-21 (PED) | | edit2017-03-21

- if bump is 1 then send newweek to *bumpTarget* which draws the button to set a new target
- for each week to view, call drawMySteps. drawMySteps will select the correct table header and introduction  to the week (i.e. "Your average daily steps at baseline were xxx. This week your target is to increase your step count to XX steps on XX days. One way to do this is a 30 minute walk"). For every day to display, show the day name, the date, did you add a walk  (check box or static tick), step count (static text or control box), method select, star if achieved target and an "Add/Edit" button (Add if no steps yet, Edit if has data).
- for each week to view, call stepsFeedback. Gives feedback based on progress so far [NOTE needs work on tenses/ viewing past]
- and finally! use goBack() to draw a select control to allow user to view weeks in the past. 


#### Adding steps & Editing steps
- Each row has a button, with id "editBtn"+ date of reading or "saveBtn" +date of reading. The date can be used to update the correct row
- If there is no step value, the row button reads "Add" and there is a control box for walk, steps and device. Clicking "Add" triggers *updateSteps()* 
- If there is a steps value, the data will be shown as static text. The row button reads "Edit". This triggers *editSteps()*

*editSteps(controlname)*
The date is taken from the control name.  
Then the date is used to first get the values of the static text and then replace the text with a control so these values can be altered.
Then the name of the button is changed to "Update".

*updateSteps(controlname, edit)*
The date of the step count is taken from the end of the controlname
Edit is true/ false - if half the row is edited, don't lose the old row, use update instead of insert.
The date of the step count is used to get the input data of the walk, device and steps controls. 
Then this is sent as date_set, steps, walk and method to **updateSteps.php**
The page is then refreshed - this updates the field, but also any targets if relevant

#### Adding comments
- when thisAside is drawn by drawHeader a comments box is drawn in with id comment# where # is the week number. 
*recordComment(weekno)*
This gets the value in comments+weekno and sends it to **addComment.php**

#### Setting manual targets
- getWeek.php should handle all automatic target updates. If a participant does not reach their target for an even week, they do not automatically progress to the next target - this avoids target increasing and increasing out of reach, particularly if the participant has a break in step recording. The event that they wish to make their target harder despite not reaching it must be accommodated. this is drawn by drawHeader above the steps table



#### Baseline: 
- Users must be able to enter their steps before being given a target.
- Users must complete a minimum of 3 days within a 7 day epoch. The beginning of that qualifying 7 day epoch becomes the date of baseline. 
- Users who do not enter sufficient step information continue at this level until sufficient data are supplied. 
- When the date of baseline is established, the user is prompted to set a date to begin their step increase. This must be 7 days from baseline and can be up to 7 dates after the current date. 
- Establishment of week 1 should expire after a month. If there is sufficient data within the past month, the earliest valid baseline date will become the new baseline date, and the step target will reflect this new date (completed on 24-02-2017)

#### Odd weeks
Targets are given for 2 weeks, the odd weeks are the first. Feedback should be given on progress akin to that in the booklet

#### Even weeks
* If a participant achieves their target on an even week, they are given their next target
* If a participant does not achieve their target on the even week, they are not given a new target. If they achieve their target in a subsequent week, they then progress to the next target
* If a participant does not achieve their target on the even week, they should be asked if they would like to move on to the next week's worth of targets anyway.  

#### General functionality of the steps table
* Participants can enter the number of steps, the method used to collect the step count, and whether they added a walk or not into their day. 
* Participants can edit the step entries they have already entered.
* Participants cannot add step counts for the future
* Once a target is set, participants recieve feedback on whether they have achieved their goal or not
* Participants can view historical data, looking back over the weeks. 
* Participants can add/edit data in a previous week

### progress report
* show_all_steps.php - extracts all steps by user and outputs an array of steps for each target point 
* stepHistory.php - shows tables of data and a graph for each week
Produce graphs to show the users progress over time

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
* downloadData.php form to request download data - can download users (no pword), steps, targets, practices, methods. Can narrow by user or practice or both
* download.php check user in session is S or R (otherwise no permission). produce csv for download

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
### Targets (doesn't require log in)
* explain_targets.php Show architecture of 12 weeks, explain how steps work (explanation only, can get data from database as extension)

### links page (doesn't require log in)
[DONE] Show the links from the booklet. Should be able to view even if not logged in [checked]

### Handbook (doesn't require log in)
* handbook.php - Show information from handbook as accordion

### Documents
Allow users to download documentation for PACE

## Old files to be deleted
* firstSteps.php - this became redirect.php
* index.php - this became redirect.php
* updateTargets2.php - this became redirect.php
* steps_process.php - this became getWeek.php and drawTable.php
* viewSteps.php 
