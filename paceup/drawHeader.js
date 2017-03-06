  function drawHeader2(week, weekno, comment=''){
	  if (week!='' && weekno!=''){
	  var blurb="";
	  var thisHeader="";
	  var thisAside="";
		if (week=='baseline'||week=='getweek1'||week=='delayweek1' || week=='week0'){
			document.getElementById("thisHeader").innerHTML= "<h2> Baseline week of your walking plan</h2>";
			 blurb="<p> Before you start to increase your walking it is important to know how much you are currently doing. \
				 The best way to do this is for you to wear the pedometer and record our step counts each day for a full week. \
				  There is often quite a difference between weekends and weekdays, so it is important to try and record for a full week. \
				   Don&#8217;t try to increase your walking this week, just do what you normally do, or your targets will be too high and too hard for you to achieve</p>";
				document.getElementById("thisBlurb").innerHTML= blurb;
		         thisAside="<h3> Frequently asked questions on the PACE-UP trial </h3> \
		        		<ul type='circle'> \
		     	    <li> What day of the week should I start recording? </li><br> \
		     	    <p><i> You can start whenever you want </i></p> \
		     	    <li> What if I miss a week through holiday, or illness, or injury? </li><br> \
		     	    <p><i> Just start with the next week, when you are able to</i></p> \
		     	    <li> How do I know what my target should be? </li><br> \
				     	    <p><i> You need to wear the pedometer and record your step count for 7 days \
				     	    to find out what your baseline average should is. This is referred to as your <b>baseline steps</b></i></p>";
			if (weekno=="0"){
				 thisAside+= "<p><b> Please note, any changes you now make will not alter your baseline steps</b></p>";}
				document.getElementById("thisAside").innerHTML= thisAside;
			 }
			else {
				$getweek=weekno;
				document.getElementById("thisHeader").innerHTML= "<h2> Week "+ $getweek +" of your walking plan</h2>";
				console.log("Get week " +$getweek);
					switch ($getweek){	
    case "1":
	case 1:					
				          blurb="<p> Your aim for week 1 is to add in an extra <b>1500</b> steps on three or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
					  thisAside = "<h3> Tips and motivators </h3> <br> \
	<p> Remember walking should be brisk, but not uncomfortable. Fast enough to make \
	 you warm and aware of your breathing, but you should still be able to walk and talk. \
	One way to tell if you are walking at moderate intensity is if you can still talk, but \
	you can&#8217;t sing the words to a song! </p> \
	<p>Make walking part of your daily routine, in order to keep up the changes: </p>\
	<p>Can I fit in an <b>extra</b> walk? </p>\
	<p>Can I <b>increase</b> what I do already?</p> \
	<p>E.g. Get off the bus, tube or train a couple of stops earlier; take a longer route to the \
	shops or library; go for a walk during your lunch break.</p> \
	<p>If you prefer to, you can get your extra 1500 steps or your extra 15 minutes of \
	moderate intensity physical activity on some days by doing more of other activities \
	you enjoy, such as dancing, playing in the park with your children or grandchildren, \
	or playing badminton or tennis, cycling, or mowing the lawn!</p> <br> <br> \
	<br><p class='text-center'><i>Walking is man&#8217;s best medicine. ~ Hippocrates</i></p> \
	<p class='text-center'><i>Make your feet your friend. ~J.M. Barrie</i></p>";
					  break;
					  	case "2":
	case 2:					
				          blurb="<p> Your aim for week 2 is to add in an extra <b>1500</b> steps on three or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.</p>";
					  thisAside = "<h3>Tips and motivators</h3> \
	<p>Make walking part of your daily routine:<p> <br> \
	<ul type='circle'> \
	    <li>Take the stairs when possible, rather than using a lift or escalator </li> \
	    <li>If you are going somewhere by car, try parking it a bit further away, so that you have to walk a little further </li></ul> \
	 <p> Remember your personal benefits from increasing walking (see page 3 of PACE-UP handbook) </p>\
	<p> What things are important to you in your life that might be improved through increasing your activity and fitness levels?  For example:  health benefits, weight loss, increased energy, improved mood, how you feel about your appearance? </p> <br> \
	<p> What might be the impact and gains of these changes for you?  For example:  </p> \
	<ul type='circle'> \
	  <li> I would be able to get back to playing sport with my friends </li> \
	  <li> It would feel great to be able to wear some new outfits </li> \
	  <li> I could do more with my time </li> \
	  <li> I could keep playing actively with my children or grandchildren </li></ul> \
		<form><div class='form-group' id='form2'> \
		 <label for = 'comment2'>  My personal gains... </label> \
		 <textarea class='form-control' rows= '4' id='comment2'>"+ comment +"</textarea></div>\
		 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"2\")'>Save</button></form> \
	<p>If you are falling behind your targets</p> \
	<ul type='circle'> \
	  <li>Don&#8217;t give up </li> \
	  <li>If necessary &#8217;tread water&#8217; , that is, do the same for one week, rather than give up completely </li> \
	  <li>Turn to week 5 of your walking plan for some tips on overcoming obstacles </li></ul> \
	  <br><p class='text-center'> <i>Walking:  the most ancient exercise and still the best modern exercise.  ~Carrie Latet</i></p>";
				          break;					
					  	case "3":		
	case 3:		
				          blurb="<p> Your aim for week 3 is to add in an extra <b>1500</b> steps on five or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.</p>";
				          thisAside = "<h3>Keep it up!</h3>	\
		<p>Remember to praise and reward yourself for any success that you have achieved so far, \
		no matter how small it seems!  This will help motivate you to keep going.</p>\
		<p>Examples:</p> \
		<ul type='circle'>\
		<li>Spend time noticing any changes in your fitness or appearance</li>\
		<li>Plan something you enjoy such as meeting a friend or watching a football match</li>\
		 <li>Give yourself some time to relax such as having a bath, a cup of tea or read a paper </li>	\
		 <li>Wear those clothes you have been waiting to get in to </li></ul>\
		 <p><b>Walking with others makes the activity more enjoyable</b>, so you may be more likely to go for the walk and to keep going. </p>\
		 	<p> Could you: </p>	<ul type='circle'>\
		 	<li>Plan some walks with friends and family?  </li>	\
		 	<li>Plan a walk to an activity you enjoy?</li>\
		 	 <li>Join a walking group to meet like-minded walkers and make some new friends at the same time? </li> \
		 	<li>Walk the dog or a neighbour&#8217;s dog? </li></ul> \
		 	<form><div class='form-group' id='form3'>\
		 	<label for = 'comment3'>  My notes </label> \
		 	<textarea class='form-control' rows= '4' id='comment3'>"+ comment +"</textarea></div>\
		 	<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"3\")'>Save</button></form>\
		    <br><p class='text-center'> <i>People say that losing weight is no walk in the park.  When I hear that I think, yes, that is the problem.  ~Chris Adams </i></p>";
		    					  	case "4":	
	case 4:	
				          blurb="<p> Your aim for week 4 is to add in an extra <b>1500</b> steps on five or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
					  thisAside = "<h2> Keep motivated!</h2> \
	<p>Well done so far!  Are you remembering to give yourself praise and small rewards for any progress that you make?  </p> \
	<p> Please remember to record your daily step counts.  Seeing the progress you are making in black and white can really help to keep you going. </p> \
	<p>Asking for support and encouragement from family and friends can also be very helpful for keeping up the changes. </p> \
	<p>Notice the changes and benefits. What do I notice and what do others see? Pay attention to any compliments! </p> \
					            		<form><div class='form-group' id='form4'> \
		 <label for = 'comment4'>  My notes </label> \
		 <textarea class='form-control' rows= '4' id='comment4'>"+ comment +"</textarea></div>\
		 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"4\")'>Save</button></form> \
			<br><p class='text-center' <i>The best remedy for a short temper is a long walk.  ~Jacqueline Schiff</i></p>";
					  break;
	case 5:	
	case "5":				
				          blurb="<p> Your aim for week 5 is to add in an extra <b>3000</b> steps on three or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.<p>";
					  thisAside = "<h3>Now we are moving!</h3> \
	<p>Often increasing your walking means planning ahead and overcoming obstacles </p> \
	<p>Think about some of the obstacles that make you less likely to walk and how you could overcome them: </p> \
	<p><b>Obstacle:</b>  &#8217I don&#8217t have the time to do a 30 minute walk. I am so pushed for time already &#8217  </p> \
	<p><b>Solution:</b>  You don&#8217t have to do your 30 minute walk in one go, you can break it up into walks of 10 or 15 minutes, spread throughout the day. </p> \
	<p><b>Obstacle:</b> &#8217It&#8217s raining and I&#8217ll be soaked when I arrive for the meeting&#8217 </p> \
	<p><b>Solution:</b> Dress for the weather or plan the walk on a different day or in a different place like an indoor shopping centre </p> \
	<p>What are the barriers that make you less likely to walk?   These might include:</p> \
	<ul type='circle'> \
	<li>Places that make it more difficult to be active, e.g. at work in an office </li> \
	<li>Other activities that might get in the way </li> \
	<li>People who make it more difficult to keep up your walking  </li> \
	<li>Thoughts and feelings, e.g. feeling fed up, tired or lethargic </li> \
	<li>Physical symptoms and reactions e.g. back pain or a physical health problem </li> </ul> \
	<p>Think about how you might overcome these obstacles.  List a range of possible solutions and be prepared to experiment to find out what works best. </p> \
	<form><div class='form-group'id='form5'> \
	 <label for = 'comment5'>  List a range of possible solutions and be prepared to experiment to find out what works best. </label> \
	 <textarea class='form-control' rows= '4' id='comment5' placeholder 'You can use this box to record your list'>"+ comment +"</textarea></div>\
	 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"5\")'>Save</button></form> \
	<br><p class='text-center'><i> Motivation is what gets you started. Habit is what keeps you going. Anonymous</i> </p>";
					  break;					
	case 6:	
	case "6":				
				          blurb="<p> Your aim for week 6 is to add in an extra <b>3000</b> steps on three or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.<p>";
					  thisAside = "<h3> How to make these changes a permanent part of your life</h3> \
	<p><b>Interest: </b> Are there new walks you could try?  Where might you enjoy walking in your local area?  </p> \
	<ul type='circle'> \
	<li>The local park </li> \
	<li>Countryside or woodlands </li> \
	<li>River Thames or Wandle </li> \
	<li>Tourist attractions in central London </li> \
	<li>Look at our <a href='#' onclick='redirect(\"./links.php\")'>suggested websites</a> </li></ul> \
	<p><b>Time/means:</b> What can you not do in order to make time for your walks and make it a priority?</p> \
			 <p><b>  Gains:  What changes have you noticed so far? </b></p> \
			<form><div class='form-group' id='form6'> \
			 <textarea class='form-control' rows= '4' id='comment6'>"+ comment +"</textarea></div>\
			 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"6\")'>Save</button></form><br> \
	<p>Take a moment to think about what you have achieved so far.  </p> \
	<p>Has there been any change in your walking pattern and step-count since starting this programme?  Do you feel any different?  Are there changes in your weight, waist size, mood or energy levels?  </p> \
	<p><b>If so, well done!  Give yourself a pat on the back.</b>  Keeping these changes going can lead to real benefits that last over time.</p> \
	<br><p class='text-center'> <i>I have two doctors, my left leg and my right.  ~G.M. Trevelyan</i></p>";
					  break;
					case 7:	
					case "7":			
				          blurb="<p> Your aim for week 7 is to add in an extra <b>3000</b> steps on five or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.<p>";
					  thisAside = "<h3>Maintain the gain</h3>\
       <p>Safe and steady exercise (pacing) gets you fit and keeps you healthy!</p> \
       <p>Many people believe they should only be active on &#8217;good&#8217; days when they feel 100% fit and well.  \
However, gentle activity has many benefits such as increasing energy, reducing tiredness and improving your mood. </p><br>\
<p>If you are tired or under the weather try reducing your walking to a lower level rather than stopping altogether.  \
Then build up again as you start to feel better.  This will help to build up your fitness steadily over time. </p> \
<p><b>Tips for safe exercise </b></p> \
	<ul type='circle'> \
<li>Alternate heavier physical exercise with more moderate or gentle activity the following day (e.g. follow a long walk with a gentle stroll the next day)</li> \
<li>Stop before you get exhausted</li> \
<li>Try to balance activities across the week </li> \
<li>Start slowly and build up gradually.  Schedule in rest breaks if you need them</li> \
<li>Break the activity into smaller stages (e.g. 10 minutes) if you need to</li> \
<li>Minimise the amount of time you spend being sedentary (sitting)</li> \
<li>Avoid vigorous activity if you are unwell, injured or fatigued, and check with your doctor if you are unsure</li> </ul>\
				            		<form><div class='form-group' id='form7'> \
		 <label for = 'comment7'>  My notes </label> \
		 <textarea class='form-control' rows= '3' id='comment7'>"+ comment +"</textarea></div>\
		 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"7\")'>Save</button></form> \
<br><p class='text-center'><i>Walking gets the feet moving, the blood moving, the mind moving. And movement is life.</i></p> \
<p><i>Carrie Latet </i></p>";
				          break;					
				          					case 8:	
					case "8":				
				          blurb="<p> Your aim for week 8 is to add in an extra <b>3000</b> steps on five or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.</p>";
				          thisAside = "<h3>Be busy being active!</h3>\
<p>Remember being busy and being active are not the same thing! You can be very busy all day but still\
 get little physical activity. The pedometer helps you to see how active you really are.</p> \
<p>What makes it easier for you to keep up your walking? </p> \
<ul type='circle'> \
<li>Places, e.g. walking to the park to eat lunch</li> \
<li>People who encourage and support you in making the change.  What could you ask them to do?</li> \
<li>Thoughts, attitudes or emotions that motivate you and make it more likely to happen.  What could you say to yourself to help?</li> \
<li>Notice the benefits and gains to your health, stamina, appearance</li> </ul> \
<p>Now, think about how these positive places, people and attitudes could help you keep up your walking.</p> <br><br>\
<form><div class='form-group' id='form8'> \
<label for = 'comment8'>  Write down your tips here. </label> \
<textarea class='form-control' rows= '4' id='comment8' placeholder 'You can use this box to record your list'>"+ comment +"</textarea></div>\
<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"8\")'>Save</button></form> \
<p class='text-center'><i> If you are seeking creative ideas, go out walking.  Angels whisper to a man when he goes for a walk.  ~Raymond Inmon  </i></p>";
					  break;				
					case 9:					
				          blurb="<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, \
adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.</p> \
	<p>One good way to do this is to add in a 30 minute walk.</p>\
<p>If you haven’t achieved this, these weeks are another opportunity for you to achieve this goal.  \
If you have achieved this, you could try increasing your walking speed.</p>";
					  thisAside = "<h3>Change does not happen in a straight line!</h3> \
<p>Successfully making a change like increasing your walking is not a smooth process and usually involves some ups and downs.  \
Most people experience some setbacks before things pick up again.</p> \
<p>Don’t get disheartened or give up when you experience a setback - see it as an opportunity for learning what went wrong.  </p>\
<p>Key points for coping with setbacks:</p> \
			<ul type='circle'> \
<li>Don’t be too hard on yourself – and don’t give up!  Missing a few walks is not a failure unless you let it become one.  If you need to, drop back to an earlier stage and start building up again from there.</li> \
<li>Avoid ‘risky’ situations, for example, don’t sit down to watch your favourite TV programme 10 minutes before you are due to go for a walk</li> \
<li>Plan to overcome possible obstacles: for example, carry a banana in your bag to eat if you get hungry out walking</li> \
<li>Remember to give yourself rewards for your successes</li> \
<li>Remind yourself why you wanted to be involved in this programme, to increase your walking, and the reasons why it is important for you to increase your activity and fitness levels</li></ul> \
				            		<form><div class='form-group' id='form9'> \
		 <label for = 'comment9'>  My notes </label> \
		 <textarea class='form-control' rows= '3' id='comment9'>"+ comment +"</textarea></div>\
		 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"9\")'>Save</button></form> \
<br><p class='text-center'><i> The sum of the whole is this: walk and be happy; walk and be healthy. The best way to lengthen out our days is to walk steadily and with a purpose. ~ Charles Dickens</i></p>";
					  break;
					case 10:					
				          blurb="<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, \
adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> \
	<p>One good way to do this is to add in a 30 minute walk.</p>";
					  thisAside = "<h3>Make it a Healthy Habit!</h3>\
<p>Walking at moderate intensity for 30 minutes on 5 or more days per week regularly will bring health benefits. You can increase the health benefits by walking for longer or by walking faster. </p> \
<p>Alternatively comparable benefits can be achieved through 75 minutes of vigorous intensity activity spread across the week or combinations of moderate and vigorous activity. Vigorous intensity activity will make you warmer and breathe much harder and make your heart beat rapidly, making it difficult to carry on a conversation. Examples include: running, sports such as football or swimming.</p> \
<br><p><b>Building regular exercise habits </b></p> \
<p>By making exercise into a habit, it will be easier to keep going in future.  For example, walking at the same time of day will help to build good habits.</p> \
<p><b>Create an “If…Then Plan”</b></p> \
<p>If-then plans can be helpful to prevent setbacks e.g:</p> \
<ul type='circle'> <li><b>If</b> I am tempted to go to the pub instead of going walking <b>then</b> I will ring my friend and ask him to come with me </li></ul> \
<p>Or they can be used for <b>pacing:</b></p> \
<ul type='circle'> <li><b>If</b> I am very tired, <b>then</b> I will try a gentle 10 minute walk rather than putting it off completely</li></ul> \
<p>Or they can be used to build good habits, e.g.:</p>\
<ul type='circle'> <li><b>If</b> I am going to the shopping centre, <b>then</b> I will walk up the stairs instead of taking the lift</li></ul></p> \
<form><div class='form-group' id='form10'> \
<label for = 'comment10'>  What if-then else plans could help you to keep up your walking goals? </label> \
<textarea class='form-control' rows= '4' id='comment10' placeholder 'You can use this box to record your list'>"+ comment +"</textarea></div>\
<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"10\")'>Save</button></form> \
<br><br><p class='text-center'><i> In every walk with nature one receives far more than he seeks.</i></p> \
<p class='text-center'><i>~ John Muir</i></p>";
					  break;	
					  			case 11:					
				          blurb="<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, \
adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> \
	<p>One good way to do this is to add in a 30 minute walk.</p>";
				          thisAside = "<h3>I’ve Changed!</h3> \
<p>Think about how you will keep up your walking when this programme finishes.  The health benefits will only stay with you if you keep up your regular walking.</p> \
<p>Have you got a friend you could commit to walking regularly with?</p>\
<p>Could you join a local walking group or go on local health walks? </p> \
<p>Why not < a href='#' onclick='redirect(\"./handbook.php\")'> revisit the handbook for some tips on keeping going?</a></p> \
			<form><div class='form-group' id='form11'> \
		 <label for = 'comment11'>  My notes </label> \
		 <textarea class='form-control' rows= '3' id='comment11'>"+ comment +"</textarea></div>\
		 <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"11\")'>Save</button></form> \
<br><br><p class='text-center'><i>Thoughts come clearly while one walks.  ~Thomas Mann</i></p> ";
					  break;	
					  					case 12:					
				          blurb="<p> Weeks 9-12 of your walking plan are about trying to maintain what you have achieved, \
adding in an extra <b>3000</b> steps to your baseline steps on <b>most days of the week</b>.If you have achieved this, you could try increasing your walking speed.</p> \
	<p>One good way to do this is to add in a 30 minute walk.</p>";
					  thisAside = "<h3>Congratulations – you have now completed the 12-week walking programme!</h3> \
<p>Why not take a few minutes to think about the changes you have made over this time? </p>\
<p>How long are you walking for each day compared with when you started?  What changes have you made in your daily and weekly step counts?  </p>\
<p>What are you doing differently?  How have your activities changed?</p> \
<p>What are the main benefits of the walking programme that you have noticed?</p> \
<p>Go back over the Tips and motivators (on the other side of your diary sheets) and think about the ones that helped the most.<p> \
<form><div class='form-group' id='form12'> \
<label for = 'comment12'>  Write some reminders below so you can keep up the changes:</label> \
<textarea class='form-control' rows= '4' id='comment12' placeholder 'You can use this box to record your reminders'>"+ comment +"</textarea></div>\
<button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"12\")'>Save</button></form> \
<h3>How to keep going when your <img src=\"images/logo_mini.png\"> walking programme finishes </h3> \
<ul type='circle'> <li>Keep the habit of going for a 30 minute walk or doing 30 minutes of other moderate activity to keep up your step-count, most days of the week.</li> \
 <li>Keep your pedometer and use it sometimes to show you how active you are. It is easy to be very busy without being very active, the pedometer shows you accurately how many steps you are taking.</li> \
<li>Remind yourself about what you have achieved by increasing your activity and any positive benefits it has had on your health, weight, mood, sleeping etc. This may motivate you to keep up good habits, or to try again if you feel you have slipped back.</li> \
 <li>Enlist a friend or family member to walk with you, it is easier to walk regularly and walk further if you have some company.</li> \
<li>Try out new walks near you or think about a walking group, the websites listed have lots of ideas for local walks, or your local library will have information.</li> </ul>";
					  break; 
					  default:					
				      blurb="<p> Congratulations – you have now completed the 12-week walking programme!</p>";
					  thisAside = "<h3>How to keep going when your <img src='images/logo_mini.png'> walking programme finishes </h3>\
					  <ul type='circle'> <li>Keep the habit of going for a 30 minute walk or doing 30 minutes of other moderate activity to keep up your step-count, most days of the week.</li> \
					   <li>Keep your pedometer and use it sometimes to show you how active you are. It is easy to be very busy without being very active, the pedometer shows you accurately how many steps you are taking.</li> \
					   <li>Remind yourself about what you have achieved by increasing your activity and any positive benefits it has had on your health, weight, mood, sleeping etc. This may motivate you to keep up good habits, or to try again if you feel you have slipped back.</li> \
					   <li>Enlist a friend or family member to walk with you, it is easier to walk regularly and walk further if you have some company.</li> \
					   <li>Try out new walks near you or think about a walking group, the websites listed have lots of ideas for local walks, or your local library will have information.</li> </ul>\
					   <form><div class='form-group' id='form12'> \
					   <label for = 'comment12'>  Here are your reminders from week 12, feel free to add to them:</label> \
					   <textarea class='form-control' rows= '4' id='comment12' placeholder 'You can use this box to record your reminders'>"+ comment +"</textarea></div>\
					   <button type='button' class='btn btn-default' id='saveComment' onclick='recordComment(\"12\")'>Save</button></form> ";

					  }
				document.getElementById("thisBlurb").innerHTML= blurb;
			document.getElementById("thisAside").innerHTML= thisAside;
			}
			}
				
	}
      	