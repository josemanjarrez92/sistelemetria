    var counter = 1;

    function addInput(divName){

	  var newdiv = document.createElement('div');
	  counter++;
	  var str1 = "<div class='form-group'><?php select_sensor("+(counter+1);
	  var str2 = str1+");?><button class='btn btn-success btn-block' onclick='addInput(";
	  var str3 = str2+'"sensors"';
	  var str4 = str3+")';><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button></div>";

	  newdiv.innerHTML = "<input type='text' name='myInputs[]'></input>";

	  document.getElementById(divName).appendChild(newdiv);

    }
     function removeInput(divName,idInput){

	  document.getElementById(divName).removeChild(idInput);

	  counter=counter-1;
	
    }