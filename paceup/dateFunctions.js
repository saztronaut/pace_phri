	function forwardsDate(datevar){
		thisday= new Date(datevar);
		var print_date= thisday.getDate()+"-"+ (thisday.getMonth()+ 1) +"-" + thisday.getFullYear();
		return print_date;
	}
	
	function valDate(datevar) {
		thisday = newDate(datevar);
		if (thisday.getMonth()<9){
			var val_date= thisday.getFullYear() +"-0"+ (thisday.getMonth()+ 1) +"-" + thisday.getDate();				
		} else{
		var val_date= thisday.getFullYear() +"-"+ (thisday.getMonth()+ 1) +"-" + thisday.getDate();}
		return val_date;
	}
	
	function giveDay(datevar){
		var daystxt = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		var mydate= new Date(datevar);
		var today = new Date();
		var myday = "";
		var timediff= Math.floor((today.getTime()-mydate.getTime())/(24*60*60*1000));
		if (timediff==0){
			myday="Today";
		} else if (timediff==-1){
			myday="Tomorrow";
		} else if (timediff==1){
			myday="Yesterday";
		} else{
		
		myday= daystxt[mydate.getDay()];}
		return myday;
		
	}