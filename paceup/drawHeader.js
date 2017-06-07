function drawHeader2(week, weekno, comment) {
    //show supplementary BCT and introductory text to go with corresponding week.
    //output thisHeader (the header for the week) blurb (the introductory text for the week) and thisAside (the bulk of the BCT)
    var draw = [];
    if (week != "") {
        var blurb = "";
        var thisHeader = "";
        var thisAside = "";
        var thisTitle = "";
        if (week == "baseline" || week == "getweek1" || week == "delayweek1" || week== "week0") {
            thisHeader += "<h2> Baseline week of your walking plan</h2>";
            blurb += "<p> Before you start to increase your walking it is important to know how much you are currently doing.";
            blurb += "The best way to do this is for you to wear the pedometer and record your step counts each day for a full week.";
            blurb += "There is often quite a difference between weekends and weekdays, so it is important to try and record for a full week.";
            blurb += "Don&#8217;t try to increase your walking this week, just do what you normally do, or your targets will be too high and too hard for you to achieve</p>";
            thisTitle += "Frequently asked questions on the PACE-UP programme";
            thisAside += "<div class='row'><div class='col-lg-8 col-md-9'><h3>Pedometer instructions</h3>";
            thisAside += "<ul type='circle'>";
            thisAside += "<li>Open the Digi-Walker pedometer and press the yellow reset button to zero.</li>";
            thisAside += "<li>Close the case. Please keep the case closed during use and only open it to see the readings. (The pedometer will not count steps if the case is open).</li>";
            thisAside += "<li>Attach the pedometer to your belt or to the top of your trousers or skirt, over the front of your hip. There is a clip to attach next to it, to make sure that it stays on securely. </li>";
            thisAside += "<li>The Digi-Walker name must be the correct way up to somebody looking at you, if it is upside down it will not record.</li>";
            thisAside += "<li>We suggest that you put the pedometer on as soon as possible after getting out of bed and wear it all day, except for sleeping and showering.</li>";
            thisAside += "<li>At the end of the day write down the number of steps that you have done on your PACE-UP diary and zero the pedometer for the next day. </li></ul></div>";
            thisAside += "<div class='col-lg-4 col-md-3'><img src='images/pedometer.png' class='logo' alt=pedometer'></div></div>";
            thisAside += "<h3> Frequently asked questions on the PACE-UP trial </h3><br>";
            thisAside += "<ul type='circle'>";
            thisAside += "<li> What day of the week should I start recording? </li><br>";
            thisAside += "<p><i> You can start whenever you want </i></p>";
            thisAside += "<li> What if I miss a week through holiday, or illness, or injury? </li><br>";
            thisAside += "<p><i> Just start with the next week, when you are able to</i></p>";
            thisAside += "<li> How do I know what my target should be? </li><br>";
            thisAside += "<p><i> You need to wear the pedometer and record your step count for 7 days ";
            thisAside += "to find out what your baseline average should is. This is referred to as your <b>baseline steps</b></i></p>";
        } else if (week === "finished") {
            thisHeader += "<h2>Beyond PACE-UP Next Steps </h2>";
            blurb += "<p>Congratulations, you have finished the PACE-UP Next Steps programme</p>";
            thisAside += "<h3>How to keep going </h3><br>";
            thisAside += "<ul type='circle'> <li>Keep the habit of going for a 30 minute walk or doing 30 minutes of other moderate activity to keep up your step-count, most days of the week.</li>";
            thisAside += "<li>Keep your pedometer and use it sometimes to show you how active you are. It is easy to be very busy without being very active, the pedometer shows you accurately how many steps you are taking.</li>";
            thisAside += "<li>Remind yourself about what you have achieved by increasing your activity and any positive benefits it has had on your health, weight, mood, sleeping etc. This may motivate you to keep up good habits, or to try again if you feel you have slipped back.</li>";
            thisAside += "<li>Enlist a friend or family member to walk with you, it is easier to walk regularly and walk further if you have some company.</li>";
            thisAside += "<li>Try out new walks near you or think about a walking group, the websites listed have lots of ideas for local walks, or your local library will have information.</li> </ul>";
            thisAside += "<form><div class='form-group' id='form" + weekno + "'> ";
            thisAside += "<label for = 'comment" + weekno + "'>  Feel free to add your own notes here:</label> ";
            thisAside += "<textarea class='form-control' rows= '4' id='comment" + weekno + "' placeholder 'You can use this box to record your reminders'>" + comment + "</textarea></div>";
            thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"" + weekno + "\")'>Save</button></form>";
            thisAside += "<br>";
        } else {
            $getweek = weekno;
            thisHeader = "<h2> Week " + $getweek + " of your walking plan</h2>";
            switch ($getweek) {
            case "1":
            case 1:
                blurb = "<p> Your aim for week 1 is to add in an extra <b>1500</b> steps on three or more days this ";
                blurb += "week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
                thisTitle = "Tips and motivators 1";
                thisAside = "<h3> Tips and motivators </h3> <br>";
                thisAside += "<p> Remember walking should be brisk, but not uncomfortable. Fast enough to make ";
                thisAside += "you warm and aware of your breathing, but you should still be able to walk and talk. ";
                thisAside += "One way to tell if you are walking at moderate intensity is if you can still talk, but ";
                thisAside += "you can&#8217;t sing the words to a song! </p> ";
                thisAside += "<p>Make walking part of your daily routine, in order to keep up the changes: </p>";
                thisAside += "<p>Can I fit in an <b>extra</b> walk? </p>";
                thisAside += "<p>Can I <b>increase</b> what I do already?</p> ";
                thisAside += "<p>E.g. Get off the bus, tube or train a couple of stops earlier; take a longer route to the ";
                thisAside += "shops or library; go for a walk during your lunch break.</p> ";
                thisAside += "<p>If you prefer to, you can get your extra 1500 steps or your extra 15 minutes of ";
                thisAside += "moderate intensity physical activity on some days by doing more of other activities ";
                thisAside += "you enjoy, such as dancing, playing in the park with your children or grandchildren, ";
                thisAside += "or playing badminton or tennis, cycling, or mowing the lawn!</p> <br> <br> ";
                thisAside += "<br><p class='text-center'><i>Walking is man&#8217;s best medicine. ~ Hippocrates</i></p> ";
                thisAside += "<p class='text-center'><i>Make your feet your friend. ~J.M. Barrie</i></p>";
                break;
            case "2":
            case 2:
                blurb = "<p> Your aim for week 2 is to add in an extra <b>1500</b> steps on three or more days this ";
                blurb += "week to your baseline steps. One good way to do this is to add in a 15 minute walk.</p>";
                thisTitle = "Tips and motivators 2";
                thisAside = "<h3>Tips and motivators</h3><br> ";
                thisAside += "<p>Make walking part of your daily routine:<p> <br> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>Take the stairs when possible, rather than using a lift or escalator </li> ";
                thisAside += "<li>If you are going somewhere by car, try parking it a bit further away, so that you have to walk a little further </li></ul> ";
                thisAside += "<p> Remember your personal benefits from increasing walking (see page 3 of PACE-UP handbook) </p>";
                thisAside += "<p> What things are important to you in your life that might be improved through increasing your activity and fitness levels?  For example:  health benefits, weight loss, increased energy, improved mood, how you feel about your appearance? </p> <br> ";
                thisAside += "<p> What might be the impact and gains of these changes for you?  For example:  </p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li> I would be able to get back to playing sport with my friends </li> ";
                thisAside += "<li> It would feel great to be able to wear some new outfits </li> ";
                thisAside += "<li> I could do more with my time </li> ";
                thisAside += "<li> I could keep playing actively with my children or grandchildren </li></ul> ";
                thisAside += "<form><div class='form-group' id='form2'> ";
                thisAside += "<label for = 'comment2'>  My personal gains... </label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment2'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"2\")'>Save</button></form> ";
                thisAside += "<p>If you are falling behind your targets</p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>Don&#8217;t give up </li> ";
                thisAside += "<li>If necessary &#8217;tread water&#8217; , that is, do the same for one week, rather than give up completely </li> ";
                thisAside += "<li>Turn to week 5 of your walking plan for some tips on overcoming obstacles </li></ul> ";
                thisAside += "<br><p class='text-center'> <i>Walking:  the most ancient exercise and still the best modern exercise.  ~Carrie Latet</i></p>";
                break;
            case "3":
            case 3:
                blurb = "<p> Your aim for week 3 is to add in an extra <b>1500</b> steps on five or more days this ";
                blurb += "week to your baseline steps. One good way to do this is to add in a 15 minute walk.</p>";
                thisTitle = "Keep it up!";
                thisAside = "<h3>Keep it up!</h3><br>";
                thisAside += "<p>Remember to praise and reward yourself for any success that you have achieved so far, ";
                thisAside += "no matter how small it seems!  This will help motivate you to keep going.</p>";
                thisAside += "<p>Examples:</p> ";
                thisAside += "<ul type='circle'>";
                thisAside += "<li>Spend time noticing any changes in your fitness or appearance</li>";
                thisAside += "<li>Plan something you enjoy such as meeting a friend or watching a football match</li>";
                thisAside += "<li>Give yourself some time to relax such as having a bath, a cup of tea or read a paper </li> ";
                thisAside += "<li>Wear those clothes you have been waiting to get in to </li></ul>";
                thisAside += "<p><b>Walking with others makes the activity more enjoyable</b>, so you may be more likely to go for the walk and to keep going. </p>";
                thisAside += "<p> Could you: </p> <ul type='circle'>";
                thisAside += "<li>Plan some walks with friends and family?  </li> ";
                thisAside += "<li>Plan a walk to an activity you enjoy?</li>";
                thisAside += "<li>Join a walking group to meet like-minded walkers and make some new friends at the same time? </li> ";
                thisAside += "<li>Walk the dog or a neighbour&#8217;s dog? </li></ul> ";
                thisAside += "<form><div class='form-group' id='form3'>";
                thisAside += "<label for = 'comment3'>  Your notes </label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment3'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"3\")'>Save</button></form>";
                thisAside += "<br><p class='text-center'> <i>People say that losing weight is no walk in the park.  When I hear that I think, yes, that is the problem.  ~Chris Adams </i></p>";
                break;
            case "4":
            case 4:
                blurb = "<p> Your aim for week 4 is to add in an extra <b>1500</b> steps on five or more days this ";
                blurb += "week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
                thisTitle = "Keep motivated!";
                thisAside += "<h3> Keep motivated!</h3> <br>";
                thisAside += "<p>Well done so far!  Are you remembering to give yourself praise and small rewards for any progress that you make?  </p> ";
                thisAside += "<p> Please remember to record your daily step counts.  Seeing the progress you are making in black and white can really help to keep you going. </p> ";
                thisAside += "<p>Asking for support and encouragement from family and friends can also be very helpful for keeping up the changes. </p> ";
                thisAside += "<p>Notice the changes and benefits. What do I notice and what do others see? Pay attention to any compliments! </p> ";
                thisAside += "<form><div class='form-group' id='form4'>";
                thisAside += "<label for = 'comment4'>  Your notes </label>";
                thisAside += "<textarea class='form-control' rows= '4' id='comment4'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"4\")'>Save</button></form> ";
                thisAside += "<br><p class='text-center' <i>The best remedy for a short temper is a long walk.  ~Jacqueline Schiff</i></p>";
                break;
            case 5:
            case "5":
                blurb = "<p> Your aim for week 5 is to add in an extra <b>3000</b> steps on three or more days this ";
                blurb += "week to your baseline steps.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.<p>";
                thisTitle = "Now we are moving!";
                thisAside = "<h3>Now we are moving!</h3> <br>";
                thisAside += "<p>Often increasing your walking means planning ahead and overcoming obstacles </p> ";
                thisAside += "<p>Think about some of the obstacles that make you less likely to walk and how you could overcome them: </p> ";
                thisAside += "<p><b>Obstacle:</b>  &#8217I don&#8217t have the time to do a 30 minute walk. I am so pushed for time already &#8217  </p> ";
                thisAside += "<p><b>Solution:</b>  You don&#8217t have to do your 30 minute walk in one go, you can break it up into walks of 10 or 15 minutes, spread throughout the day. </p> ";
                thisAside += "<p><b>Obstacle:</b> &#8217It&#8217s raining and I&#8217ll be soaked when I arrive for the meeting&#8217 </p> ";
                thisAside += "<p><b>Solution:</b> Dress for the weather or plan the walk on a different day or in a different place like an indoor shopping centre </p> ";
                thisAside += "<p>What are the barriers that make you less likely to walk?   These might include:</p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>Places that make it more difficult to be active, e.g. at work in an office </li> ";
                thisAside += "<li>Other activities that might get in the way </li> ";
                thisAside += "<li>People who make it more difficult to keep up your walking  </li> ";
                thisAside += "<li>Thoughts and feelings, e.g. feeling fed up, tired or lethargic </li> ";
                thisAside += "<li>Physical symptoms and reactions e.g. back pain or a physical health problem </li> </ul> ";
                thisAside += "<p>Think about how you might overcome these obstacles.  List a range of possible solutions and be prepared to experiment to find out what works best. </p> ";
                thisAside += "<form><div class='form-group'id='form5'> ";
                thisAside += "<label for = 'comment5'>  List a range of possible solutions and be prepared to experiment to find out what works best. </label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment5' placeholder 'You can use this box to record your list'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"5\")'>Save</button></form> ";
                thisAside += "<br><p class='text-center'><i> Motivation is what gets you started. Habit is what keeps you going. Anonymous</i> </p>";
                break;
            case 6:
            case "6":
                blurb = "<p> Your aim for week 6 is to add in an extra <b>3000</b> steps on three or more days this ";
                blurb += "week to your baseline steps.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.<p>";
                thisTitle = "How to make these changes a permanent part of your life";
                thisAside = "<h3> How to make these changes a permanent part of your life</h3><br> ";
                thisAside += "<p><b>Interest: </b> Are there new walks you could try?  Where might you enjoy walking in your local area?  </p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>The local park </li> ";
                thisAside += "<li>Countryside or woodlands </li> ";
                thisAside += "<li>Riverside walks</li> ";
                thisAside += "<li>Tourist attractions in central London </li> ";
                thisAside += "<li>Look at our <a href=\"./links.php\">suggested websites</a> for some ideas </li></ul> ";
                thisAside += "<p><b>Time/means:</b> What can you not do in order to make time for your walks and make it a priority?</p> ";
                thisAside += "<p><b>  Gains:  What changes have you noticed so far? </b></p> ";
                thisAside += "<form><div class='form-group' id='form6'> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment6'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"6\")'>Save</button></form><br> ";
                thisAside += "<p>Take a moment to think about what you have achieved so far.  </p> ";
                thisAside += "<p>Has there been any change in your walking pattern and step-count since starting this programme?  Do you feel any different?  Are there changes in your weight, waist size, mood or energy levels?  </p> ";
                thisAside += "<p><b>If so, well done!  Give yourself a pat on the back.</b>  Keeping these changes going can lead to real benefits that last over time.</p> ";
                thisAside += "<br><p class='text-center'> <i>I have two doctors, my left leg and my right.  ~G.M. Trevelyan</i></p>";
                break;
            case 7:
            case "7":
                blurb = "<p> Your aim for week 7 is to add in an extra <b>3000</b> steps on five or more days this ";
                blurb += "week to your baseline steps.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.<p>";
                thisTitle = "Maintain the gain";
                thisAside = "<h3>Maintain the gain</h3><br>";
                thisAside += "<p>Safe and steady exercise (pacing) gets you fit and keeps you healthy!</p> ";
                thisAside += "<p>Many people believe they should only be active on &#8217;good&#8217; days when they feel 100% fit and well.  ";
                thisAside += "However, gentle activity has many benefits such as increasing energy, reducing tiredness and improving your mood.</p>";
                thisAside += "<p>If you are tired or under the weather try reducing your walking to a lower level rather than stopping altogether. ";
                thisAside += "Then build up again as you start to feel better.  This will help to build up your fitness steadily over time. </p>";
                thisAside += "<p><b>Tips for safe exercise </b></p> ";
                thisAside += "<ul type='circle'>";
                thisAside += "<li>Alternate heavier physical exercise with more moderate or gentle activity the following day (e.g. follow a long walk with a gentle stroll the next day)</li> ";
                thisAside += "<li>Stop before you get exhausted</li> ";
                thisAside += "<li>Try to balance activities across the week </li>";
                thisAside += "<li>Start slowly and build up gradually.  Schedule in rest breaks if you need them</li>";
                thisAside += "<li>Break the activity into smaller stages (e.g. 10 minutes) if you need to</li> ";
                thisAside += "<li>Minimise the amount of time you spend being sedentary (sitting)</li> ";
                thisAside += "<li>Avoid vigorous activity if you are unwell, injured or fatigued, and check with your doctor if you are unsure</li> </ul>";
                thisAside += "<form><div class='form-group' id='form7'> ";
                thisAside += "<label for = 'comment7'>  Your notes </label> ";
                thisAside += "<textarea class='form-control' rows= '3' id='comment7'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"7\")'>Save</button></form>";
                thisAside += "<br><p class='text-center'><i>Walking gets the feet moving, the blood moving, the mind moving. And movement is life.</i></p> ";
                thisAside += "<p class='text-center'><i>Carrie Latet </i></p>";
                break;
            case 8:
            case "8":
                blurb = "<p> Your aim for week 8 is to add in an extra <b>3000</b> steps on five or more days this ";
                blurb += "week to your baseline steps.</p>";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.</p>";
                thisTitle = "Be busy being active!";
                thisAside += "<h3>Be busy being active!</h3><br>";
                thisAside += "<p>Remember being busy and being active are not the same thing! You can be very busy all day but still";
                thisAside += " get little physical activity. The pedometer helps you to see how active you really are.</p> ";
                thisAside += "<p>What makes it easier for you to keep up your walking? </p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>Places, e.g. walking to the park to eat lunch</li> ";
                thisAside += "<li>People who encourage and support you in making the change.  What could you ask them to do?</li> ";
                thisAside += "<li>Thoughts, attitudes or emotions that motivate you and make it more likely to happen.  What could you say to yourself to help?</li> ";
                thisAside += "<li>Notice the benefits and gains to your health, stamina, appearance</li> </ul> ";
                thisAside += "<p>Now, think about how these positive places, people and attitudes could help you keep up your walking.</p> <br><br>";
                thisAside += "<form><div class='form-group' id='form8'> ";
                thisAside += "<label for = 'comment8'>  Write down your tips here. </label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment8' placeholder 'You can use this box to record your list'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"8\")'>Save</button></form> ";
                thisAside += "<p class='text-center'><i> If you are seeking creative ideas, go out walking.  Angels whisper to a man when he goes for a walk.  ~Raymond Inmon  </i></p>";
                break;
            case 9:
            case "9":
                blurb = "<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, ";
                blurb += "adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.</p>";
                blurb += "<p>If you haven&#8217t achieved this, these weeks are another opportunity for you to achieve this goal.  ";
                blurb += "If you have achieved this, you could try increasing your walking speed.</p>";
                thisTitle = "Change does not happen in a straight line";
                thisAside += "<h3>Change does not happen in a straight line!</h3> <br>";
                thisAside += "<p>Successfully making a change like increasing your walking is not a smooth process and usually involves some ups and downs.  ";
                thisAside += "Most people experience some setbacks before things pick up again.</p> ";
                thisAside += "<p>Don&#8217t get disheartened or give up when you experience a setback - see it as an opportunity for learning what went wrong.  </p>";
                thisAside += "<p>Key points for coping with setbacks:</p> ";
                thisAside += "<ul type='circle'> ";
                thisAside += "<li>Don&#8217t be too hard on yourself – and don&#8217t give up!  Missing a few walks is not a failure unless you let it become one.  If you need to, drop back to an earlier stage and start building up again from there.</li> ";
                thisAside += "<li>Avoid ‘risky’ situations, for example, don&#8217t sit down to watch your favourite TV programme 10 minutes before you are due to go for a walk</li> ";
                thisAside += "<li>Plan to overcome possible obstacles: for example, carry a banana in your bag to eat if you get hungry out walking</li> ";
                thisAside += "<li>Remember to give yourself rewards for your successes</li> ";
                thisAside += "<li>Remind yourself why you wanted to be involved in this programme, to increase your walking, and the reasons why it is important for you to increase your activity and fitness levels</li></ul> ";
                thisAside += "<form><div class='form-group' id='form9'> ";
                thisAside += "<label for = 'comment9'>  My notes </label> ";
                thisAside += "<textarea class='form-control' rows= '3' id='comment9'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"9\")'>Save</button></form> ";
                thisAside += "<br><p class='text-center'><i> The sum of the whole is this: walk and be happy; walk and be healthy. The best way to lengthen out our days is to walk steadily and with a purpose. ~ Charles Dickens</i></p>";
                break;
            case 10:
            case "10":
                blurb = "<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, ";
                blurb += "adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.</p>";
                thisTitle = "Make it a Healthy Habit!";
                thisAside += "<h3>Make it a Healthy Habit!</h3><br>";
                thisAside += "<p>Walking at moderate intensity for 30 minutes on 5 or more days per week regularly will bring health benefits. You can increase the health benefits by walking for longer or by walking faster. </p> ";
                thisAside += "<p>Alternatively comparable benefits can be achieved through 75 minutes of vigorous intensity activity spread across the week or combinations of moderate and vigorous activity. Vigorous intensity activity will make you warmer and breathe much harder and make your heart beat rapidly, making it difficult to carry on a conversation. Examples include: running, sports such as football or swimming.</p> ";
                thisAside += "<br><p><b>Building regular exercise habits </b></p> ";
                thisAside += "<p>By making exercise into a habit, it will be easier to keep going in future.  For example, walking at the same time of day will help to build good habits.</p> ";
                thisAside += "<p><b>Create an “If…Then Plan”</b></p> ";
                thisAside += "<p>If-then plans can be helpful to prevent setbacks e.g:</p> ";
                thisAside += "<ul type='circle'> <li><b>If</b> I am tempted to go to the pub instead of going walking <b>then</b> I will ring my friend and ask him to come with me </li></ul> ";
                thisAside += "<p>Or they can be used for <b>pacing:</b></p> ";
                thisAside += "<ul type='circle'> <li><b>If</b> I am very tired, <b>then</b> I will try a gentle 10 minute walk rather than putting it off completely</li></ul> ";
                thisAside += "<p>Or they can be used to build good habits, e.g.:</p>";
                thisAside += "<ul type='circle'> <li><b>If</b> I am going to the shopping centre, <b>then</b> I will walk up the stairs instead of taking the lift</li></ul></p> ";
                thisAside += "<form><div class='form-group' id='form10'> ";
                thisAside += "<label for = 'comment10'>  What if-then else plans could help you to keep up your walking goals? </label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment10' placeholder 'You can use this box to record your list'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"10\")'>Save</button></form> ";
                thisAside += "<br><br><p class='text-center'><i> In every walk with nature one receives far more than he seeks.</i></p> ";
                thisAside += "<p class='text-center'><i>~ John Muir</i></p>";
                break;
            case 11:
            case "11":
                blurb = "<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, ";
                blurb += "adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.</p>";
                thisTitle = "I've Changed!";
                thisAside += "<h3>I’ve Changed!</h3><br> ";
                thisAside += "<p>Think about how you will keep up your walking when this programme finishes.  The health benefits will only stay with you if you keep up your regular walking.</p> ";
                thisAside += "<p>Have you got a friend you could commit to walking regularly with?</p>";
                thisAside += "<p>Could you join a local walking group or go on local health walks? </p> ";
                thisAside += "<p>Why not <a href=\"./handbook.php\"> revisit the handbook for some tips on keeping going?</a></p> ";
                thisAside += "<form><div class='form-group' id='form11'> ";
                thisAside += "<label for = 'comment11'>  My notes </label> ";
                thisAside += "<textarea class='form-control' rows= '3' id='comment11'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"11\")'>Save</button></form> ";
                thisAside += "<br><br><p class='text-center'><i>Thoughts come clearly while one walks.  ~Thomas Mann</i></p> ";
                break;
            case 12:
            case "12":
                blurb = "<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, ";
                blurb += "adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> ";
                blurb += "<p>One good way to do this is to add in a 30 minute walk.</p>";
                thisTitle = "How to keep going when your PACE-UP -Next Steps Programme finishes";
                thisAside += "<h3>Congratulations – you have reached week 12 of the walking programme!</h3><br> ";
                thisAside += "<p>Why not take a few minutes to think about the changes you have made over this time? </p>";
                thisAside += "<p>How long are you walking for each day compared with when you started?  What changes have you made in your daily and weekly step counts?  </p>";
                thisAside += "<p>What are you doing differently?  How have your activities changed?</p> ";
                thisAside += "<p>What are the main benefits of the walking programme that you have noticed?</p> ";
                thisAside += "<p>Go back over the Tips and motivators (on the other side of your diary sheets) and think about the ones that helped the most.<p>";
                thisAside += "<form><div class='form-group' id='form12'> ";
                thisAside += "<label for = 'comment12'>  Write some reminders below so you can keep up the changes:</label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment12' placeholder 'You can use this box to record your reminders'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"12\")'>Save</button></form> ";
                thisAside += "<h3>How to keep going when your <img src=\"images/logo_mini.png\"> walking programme finishes </h3> <br>";
                thisAside += "<ul type='circle'> <li>Keep the habit of going for a 30 minute walk or doing 30 minutes of other moderate activity to keep up your step-count, most days of the week.</li>";
                thisAside += "<li>Keep your pedometer and use it sometimes to show you how active you are. It is easy to be very busy without being very active, the pedometer shows you accurately how many steps you are taking.</li>";
                thisAside += "<li>Remind yourself about what you have achieved by increasing your activity and any positive benefits it has had on your health, weight, mood, sleeping etc. This may motivate you to keep up good habits, or to try again if you feel you have slipped back.</li>";
                thisAside += "<li>Enlist a friend or family member to walk with you, it is easier to walk regularly and walk further if you have some company.</li> ";
                thisAside += "<li>Try out new walks near you or think about a walking group, the websites listed have lots of ideas for local walks, or your local library will have information.</li> </ul>";
                break;
            default:
                thisTitle = "Beyond the 12 weeks of the PACE-UP Next Steps programme";
                blurb = "<p>How to keep you walking</p>";
                thisAside = "<h3>How to keep going </h3><br>";
                thisAside += "<a href=\"./summary.php\"> Click here to see a summary of your progress over the 12 week programme</a>";
                thisAside += "<ul type='circle'> <li>Keep the habit of going for a 30 minute walk or doing 30 minutes of other moderate activity to keep up your step-count, most days of the week.</li> ";
                thisAside += "<li>Keep your pedometer and use it sometimes to show you how active you are. It is easy to be very busy without being very active, the pedometer shows you accurately how many steps you are taking.</li>";
                thisAside += "<li>Remind yourself about what you have achieved by increasing your activity and any positive benefits it has had on your health, weight, mood, sleeping etc. This may motivate you to keep up good habits, or to try again if you feel you have slipped back.</li> ";
                thisAside += "<li>Enlist a friend or family member to walk with you, it is easier to walk regularly and walk further if you have some company.</li> ";
                thisAside += "<li>Try out new walks near you or think about a walking group, the websites listed have lots of ideas for local walks, or your local library will have information.</li> </ul>";
                thisAside += "<form><div class='form-group' id='form" + weekno + "'>";
                thisAside += "<label for = 'comment" + weekno + "'>  Feel free to add your own notes here:</label> ";
                thisAside += "<textarea class='form-control' rows= '4' id='comment" + weekno + "' placeholder 'You can use this box to record your reminders'>" + comment + "</textarea></div>";
                thisAside += "<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"" + weekno + "\")'>Save</button></form>";
                thisAside += "<br> <a href=\"./AddNewTarget.php\"> Click here to add a new target</a>";
            }
        }
        draw["blurb"] = blurb;
        draw["thisAside"] = thisAside;
        draw["thisHeader"] = thisHeader;
        draw["thisTitle"] = thisTitle;
    }
    return draw;
}