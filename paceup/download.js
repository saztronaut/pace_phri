function downloadFile(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:csv/plain;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);
}

function convertArrayToCSV(args){
	 var result, ctr, keys, columnDelimiter, lineDelimiter, data;

     data = args.data || null;
     if (data == null || !data.length) {
         return null;
     }

     columnDelimiter = args.columnDelimiter || ',';
     lineDelimiter = args.lineDelimiter || '\n';

     keys = Object.keys(data[0]);

     result = '';
     result += keys.join(columnDelimiter);
     result += lineDelimiter;

     data.forEach(function(item) {
         ctr = 0;
         keys.forEach(function(key) {
             if (ctr > 0) result += columnDelimiter;

             result += item[key];
             ctr++;
         });
         result += lineDelimiter;
     });

     return result;	
}

function createDownload(filename, url, data){
    doXHR(url, function (){
  	  var $getResponse = this.responseText;
  	  if ($getResponse.startsWith('{"data":')){
    	  var $response= JSON.parse($getResponse);
          var text=$response;
	      var mycsv=convertArrayToCSV(text); //convert the array into CSV format
	      downloadFile(filename, mycsv);}
  	  else{
  		document.getElementById("n_span").innerHTML=$getResponse;
  	  }}
    , data);
}


