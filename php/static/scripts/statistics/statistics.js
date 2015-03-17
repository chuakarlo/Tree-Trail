var data = [], locations = [], tree_types = [], title = '';

function addData(quantity, name, id, types) {
	
	if(typeof data[name] == 'undefined') {
		data[name] = [];
		locations[name] = name;
	}
	
	if(typeof data[name][types] == 'undefined') {
		data[name][types] = [id, quantity];
		
		if(typeof tree_types[types] == 'undefined') tree_types[types] = types;
	} else {
		data[name][types][1] += quantity;
	}
}

function init() {


	for(x = 0 ;x < rows; x++) { addData(data2['quantity'][x],data2['name'][x],data2['id'][x],data2['types'][x]); }

	var div_checkbox = document.getElementById('checkboxes');
	
	if(rows != 0) {
		var select = document.getElementById('drop-generate');
		while (select.firstChild) select.removeChild(select.firstChild);

		for (x in locations) {
			var option = document.createElement("option");
			option.value = locations[x];
			option.innerHTML = locations[x];
			select.appendChild(option);
		}		
		
		while (div_checkbox.firstChild) div_checkbox.removeChild(div_checkbox.firstChild);

		var checkbox = document.createElement('div');
		checkbox.className = "checkbox";
		var count = 0;
		for(y in locations) {
			for (x in tree_types) {
						
				var div = document.createElement("div");
					div.className = 'checklist';
				var label = document.createElement("label");
					label.className = "checkbox-inline";
				
				var input = document.createElement("input");
					input.className = tree_types[x];
					input.type = "checkbox";
					input.name = "tree_types";					
					input.checked = false;
					if(typeof data[locations[y]][tree_types[x]] != 'undefined') {
						input.id = data[locations[y]][tree_types[x]][1];
					} else {
						input.id = 0;
					}
					input.value = tree_types[x];
				
				label.appendChild(input);
				label.appendChild(document.createTextNode(tree_types[x]));
				// console.log(tree_types[x]);
				div.appendChild(label);
				
				checkbox.appendChild(div);
				
				if(count % 3 == 2) {
					div_checkbox.appendChild(checkbox);
					checkbox = document.createElement('div');
					checkbox.className = "checkbox";
				}
				count++;
			}
			count--;
			if(count % 3 != 2) div_checkbox.appendChild(checkbox);

			break;
		}
	} else {
		div_checkbox.appendChild(document.createTextNode('No Data Available'));
	}	
}




$( document ).ready(function() {

	
	
	var location_array = new Array();
	var quantity_array = new Array();

	var myBarChart=null;
	
	$('#generate').click(function() {
	  	title = 'Tree Population in the Municipality of '+document.getElementById('drop-generate').value;
				 
	  	if(myBarChart==null)
	  	{
	  		$(':checkbox').each(function() {
				if(this.checked && this.id != "checkAll") {
					value = this.id;
					location_array.push($(this).val());
					quantity_array.push(value);
				}
			});
		  
				var BarChart = {
					labels : location_array,
					datasets : [
						{
							fillColor : "#5cb85c",
					        strokeColor : "#3d8b3d",
							data : quantity_array
						}
					]

				}

		  myBarChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(BarChart, {scaleFontSize : 13, scaleFontColor : "#000"});
		  location_array = [];
		  quantity_array = [];
		  document.getElementById('title').innerHTML = 'Tree Population in the Municipality of '+document.getElementById('drop-generate').value;
		
		  document.getElementById('title').style.visibility = 'visible';
	  	}
  	});


	$('#drop-generate').change(function() {
		document.getElementById('title').innerHTML = 'Tree Population in the Municipality of '+document.getElementById('drop-generate').value;
		
		var div_checkbox = document.getElementById('checkboxes');
	
		// while (div_checkbox.firstChild) div_checkbox.removeChild(div_checkbox.firstChild);

		var checkbox = document.createElement('div');
		checkbox.className = "checkbox";
		var count = 0;
		
		var array = document.getElementsByTagName("input");


		for(var ii = 0; ii < array.length; ii++)
		{

		   if(array[ii].type == "checkbox")
		   {
				if(array[ii].className == tree_types[array[ii].className]) {
					console.log(data);
					console.log(this.value);
					console.log(array[ii].className);
					if(typeof data[locations[this.value]][array[ii].className] != 'undefined') {
						array[ii].id = data[locations[this.value]][array[ii].className][1];
					} else {
						array[ii].id = 0;
					}				
				}
		   }
		}
		
		// for (x in tree_types) {
			
			// var div = document.createElement("div");
				// div.className = 'checklist';
			// var label = document.createElement("label");
				// label.className = "checkbox-inline";
			
			// var input = document.createElement("input");
				// input.className = tree_types[x];
				// input.type = "checkbox";
				// input.name = "tree_types";					
				// input.checked = true;
				// if(typeof data[locations[this.value]][tree_types[x]] != 'undefined') {
					// input.id = data[locations[this.value]][tree_types[x]][1];
				// } else {
					// input.id = 0;
				// }
				// input.value = tree_types[x];
				// input.onclick = function() {
					// changeCheck(this);
				// };

			// label.appendChild(input);
			// label.appendChild(document.createTextNode(tree_types[x]));
			
			// div.appendChild(label);
			
			// checkbox.appendChild(div);
			
			// if(count % 3 == 2) {
				// div_checkbox.appendChild(checkbox);
				// checkbox = document.createElement('div');
				// checkbox.className = "checkbox";
			// }
			// count++;
		// }
		// count--;
		// if(count % 3 != 2) div_checkbox.appendChild(checkbox);
		createNewChart();
		// myBarChart.destroy();
			// location_array = [];
	  		// quantity_array = [];

			// $(':checkbox:checked').each(function() {
				// value = this.id;
				// location_array.push($(this).val());
				// quantity_array.push(value);
			// });
			
			// var BarChart = {
				// labels : location_array,
				// datasets : [
					// {
						// fillColor : "#5cb85c",
		                // strokeColor : "#3d8b3d",
						// data : quantity_array
					// }
				// ]
				
			// }

			// myBarChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(BarChart, {scaleFontSize : 13, scaleFontColor : "#000"});
		
		
	});
	
	function changeCheck(foo) {
		// console.log(this);
		checkBoxChange(foo);
	}
	
	$(':checkbox').change(function() {
		// console.log(this);
		if(this.id == "checkAll" ) {
			checkAllCheckBox(this);
		} else {
			checkBoxChange(this);
		}
	});
	
	function checkAllCheckBox(variable) {
		$(':checkbox').each(function() {
			this.checked = variable.checked;
		});
		
		createNewChart();
	}
	
	function checkBoxChange(checkbox) {
		if(!(myBarChart.datasets[0].bars.length))
		{
			value = checkbox.id;
			location_array.push(checkbox.value);
			quantity_array.push(value);

			var BarChart = {
				labels : location_array,
				datasets : [
					{
						fillColor : "#5cb85c",
		                strokeColor : "#3d8b3d",
						data : quantity_array
					}
				]
			}
			
		  myBarChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(BarChart, {scaleFontSize : 13, scaleFontColor : "#000"});
		}
		else if(checkbox.checked)
		{
			myBarChart.addData([checkbox.id], (checkbox.value));
		}
		else if(!(checkbox.checked))
		{
			createNewChart();
		}
	}

	function createNewChart() {
		myBarChart.destroy();
		location_array = [];
		quantity_array = [];

		$(':checkbox:checked').each(function() {
			if(this.id != "checkAll") {
				value = this.id;
				location_array.push(this.value);
				quantity_array.push(value);
			}
		});
		
		var BarChart = {
			labels : location_array,
			datasets : [
				{
					fillColor : "#5cb85c",
					strokeColor : "#3d8b3d",
					data : quantity_array
				}
			]
			
		}

		myBarChart = new Chart(document.getElementById("canvas").getContext("2d")).Bar(BarChart, {scaleFontSize : 13, scaleFontColor : "#000"});

	}
	
});
