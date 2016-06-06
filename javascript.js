	
	
	var list_i = [];
	var list_o = [];
	
	
	document.addEventListener('DOMContentLoaded', function(){
		var listId = sessionStorage.getItem("ID");
		document.getElementById("list_name").innerHTML = "리스트 이름 : " + listId; 
		loadings_(listId);
		list_i.push(listId);
		list_i.push("0");
		
	});
	
	function loadings_(listId){
		
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange= function(){
			if( xhttp.readyState == 4 && xhttp.status == 200 ){
					
					var str = xhttp.responseText;
					if( str !="") {
					arr = strTOarr(str);
					arrlen = arr.length;
					if( arr[2] != "") {
						var i=0;
						for(i=0; i<arrlen; i++){
						add_list(arr[i]);
						}
					}
					}
			}
		};
			xhttp.open("POST", "loadings.php" , true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("Listid=" + listId);
		
	}
	
	
	
	function add_list(value){
		
		if( list_length("in_list") < 20 ){
		
		var ul = document.getElementById("input_list");
		var li = document.createElement("li");
		li.appendChild(document.createTextNode(value));
		li.setAttribute("id", "in"+(list_length("in_list")+1));
		li.setAttribute("name", "in_list");
		li.setAttribute("onclick", "delete_list(this)");
		li.setAttribute("onmouseover", "color()");
		li.setAttribute("style", "cursor:pointer");
		
		ul.appendChild(li);
		list_i.push(value);
		}
		
	}
	function delete_list(obj){
		var id = obj.id;	
		var parent = document.getElementById("input_list");
		var child = document.getElementById(id);
		var data = child.textContent;
		parent.removeChild(child);
		
		var i=0;
		for(i=0;i<list_i.length; i++){
			if(list_i[i] == data ){
				list_i.splice(i,1);
				break;
			}
		}
		
	}
	
	function check_list(value){
			
			var xhttp =  new XMLHttpRequest();
			xhttp.onreadystatechange =function(){
			if( xhttp.readyState == 4 && xhttp.status == 200){
				
				var read = xhttp.responseText;
				var arr = read.split(" ");
				
					if(read == value){
							add_list(value);
					}
					else if(read != value && arr.length == 2){
							var r = confirm("입력하신 재료가 DB에 존재하지 않습니다. 혹시 '"+ arr[0] + "' 입니까?")
							if(r == true){
									
									add_list(arr[0]);
							}
							else{
								alert("일단 재료 추가 후, 재료 정보가 DB 서버로 전송 됩니다.")
								add_list(value);
							}
							
					}
				}	
			};

			xhttp.open("POST", "insert_check.php" , true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("name1=" + value);
		}
		
		function list_length(name){
				var nodelist = document.getElementsByName(name);
				return nodelist.length;
		}
		
		function money(){
			list_i[1] = document.getElementById("money").value;
		}
		
		function finish(){
				money();
				//alert(list_i.length());
				//alert(list_i);
				for(i=0; i<8; i++){
				document.getElementById("name_" + (i+1) ).innerHTML = "";
				document.getElementById("price_" + (i+1) ).innerHTML = "";
				document.getElementById("img_" + (i+1) ).src = "";
				var link = document.getElementById("link_" +(i+1));
				link.setAttribute("href","");
				 }
			var xhttp_2 =  new XMLHttpRequest();
			xhttp_2.onreadystatechange =function(){
			if( xhttp_2.readyState == 4 && xhttp_2.status == 200){
					
					var str = xhttp_2.responseText;
					list_o = strTOarr(str);
					
					output_list(list_o);
				}
			};
			xhttp_2.open("POST", "output.php" , true);
			xhttp_2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp_2.send("name1=" + list_i.toString());
		}
		
		function strTOarr(str){
			
			var arr = str.split(",");
			
			var i=0;
			var temp = [];
			
			for(i=0; i < arr.length; i++){
				temp.push(arr[i]);
			}
		return temp;
		}
		
		function output_list(arr){
			var i=0;
			if(arr.length != 1 ) {
			for(i=0; i<arr.length/4; i++){
				document.getElementById("name_" + (i+1) ).innerHTML = arr[i*4];
				document.getElementById("price_" + (i+1) ).innerHTML = "\\"+arr[i*4+1];
				document.getElementById("img_" + (i+1) ).src = arr[i*4+2];
				var link = document.getElementById("link_" +(i+1));
				link.setAttribute("href",arr[i*4+3]);
				 }
				}

		}
		
		function show_info(obj){			
			var id =  obj.id;
			var money = parseInt(id) + 1 ;
			var picture = parseInt(id) + 2 ;
			var link_addr = parseInt(id) + 3 ;

		document.getElementById("output_img").src = list_o[picture];
		document.getElementById("demo").innerHTML = "필요 돈 " +list_o[money] + "원";
		document.getElementById("link_addr").href = list_o[link_addr];
		document.getElementById("link_addr").innerHTML = "Link" ;
			
		}

