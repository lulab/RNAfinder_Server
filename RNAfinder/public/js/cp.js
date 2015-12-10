

var species = document.getElementById("species");

//check upload file local
function readSingleFile(e) {
	var file = e.target.files[0];
	if (!file) {
		return;
	}
	var reader = new FileReader();
	reader.onload = function(e) {
		var contents = e.target.result;
		if(!checkInput(contents)){
			document.getElementById('file-input').value = "";
		}
	};
	reader.readAsText(file);
}


document.getElementById('file-input')
  .addEventListener('change', readSingleFile, false);


function isEmpty(str){
	if (typeof(str) == "undefined") return 1;
	var replace = str.replace(/(^\s*)|(\s*$)/g, "");
	return !replace.length;
}



function checkInput(input){
	var line = input.split("\n");
	if (line.length > 990000) {
		alert("Input file more than 100M!");
		return 0;
	}
	for(var i=0; i<line.length-1; i++){
		if (line[i].match(/^#/g)) continue;
		if (line[i].match(/\s\s+/g)){
			 alert("Please make sure each column is separated by tab");
		     	 return 0;
		}
		var word = line[i].split(/\t/);
		var reads_length=word[4]-word[3];
		if (species.value == "human"){
			//var chrNum = word[0].match(/\d*/g);
			//alert(chrNum); 
			if (!(word[0].match(/^chr(1[0-9]|2[0-2]|[0-9])$/g)||word[0].match(/^chr(X|Y)$/g))){

			//	if (word[0].match(/^chr(1[0-9]|2[0-2]|[0-9])$/ig)) alert ("Chromosome names are not in lower case");
			//	else if (word[0].match(/^chr\d+/ig)) alert("Chromosome names are not chr1-chr22 or chrX!");
			//	else alert("Please check the chromosome name."); 
				alert("Your file contains chromosome \""+word[0]+"\", which is not chr1, chr2, ..., chr22, chrX or chrY");
				return 0;
			} 
		}
		else if (species.value == "mouse"){
			if (!(word[0].match(/^chr(1[0-9]|[0-9])$/g)||word[0].match(/^chr(X|Y)$/g))){
				alert("Your file contains chromosome \""+word[0]+"\", which is not chr1, chr2, ..., chr19, chrX or chrY");
				return 0;
			}
		}
		else if  (species.value == "worm"){
			if (!(word[0].match(/^chr(I|II|III|IV|X|Y)$/g))){
			//	 if (word[0].match(/^chr(I|II|III|IV|X|Y)$/ig)) alert ("Chromosome names are not in lower case");
			//	 else alert("Chromosome name are not chrI, chrII, chrIII, chrIV, chrX, chrY."); 
				
				alert("Your file contains chromosome \""+word[0]+"\", which is not chrI, chrII, chrIII, chrIV, chrV or chrX");
				return 0;
			} 
		}
		else if (species.value == "fly"){
			if (!(word[0].match(/^chr(2R|2L|3L|3R|4|X)$/g))){
				alert("Your file contains chromosome \""+word[0]+"\", which is not chr2L, chr2R, chr3L, chr3R, chr4 or chrX");
				return 0;
			}
		}
		else if (species.value == "plant"){
			if (!(word[0].match(/^chr([1-5])$/g))){
				alert("Your file contains chromosome \""+word[0]+"\", which is not chr1, chr2, chr3, chr4 or chr5");
				return 0;
			}
		}
		for(var j = 0; j<9; j++){
			if(isEmpty(word[j])) {  
				 alert("Please check each column not null, or make sure echo column is separated by tab");
				 return 0;
			}
		}
		if(isNaN(word[3]) || isNaN(word[3]) || reads_length<0){ 
			 alert("Please check the exon length !");
			 return 0;
		}
		if(!(word[2].match(/exon/i)||word[2].match(/transcript/i))){
			 alert("The third column should be \"exon\" or \"transcript\" !");
			 return 0;
		}
		if(!word[8].match(/transcript_id/i)){
			 alert("Please check the transcript_id !");
			 return 0;
		}else{
			var temp1 = word[8].split(word[8].match(/transcript_id/i));
			var temp2 = temp1[1].split("\"");
			if (isEmpty(temp2[1])){
				alert("Please check the transcript_id not null!");
				return 0;
				
			}
		}


		if(!word[8].match(/gene_id/i)){
			 alert("Please check the gene_id !");
			 return 0;
		}else{
			var temp1 = word[8].split(word[8].match(/gene_id/i));
			var temp2 = temp1[1].split("\"");
			if (isEmpty(temp2[1])){
				alert("Please check the gene_id not null!");
				return 0;
				
			}
		}

	}
	return 1;
} 




function validate_form(thisform){
	with (thisform)
{

	 var form = document.forms["demoForm"]; 
	 if (form["file"].files.length > 0 ) { 
	 } else if (text){ 
		if(!checkInput(text.value)) return false;
	 } else {
	 	alert ("Please paste or choose a file."); 
	 	return false;
	 } 

	load();

	}
}

function load(){
x=document.getElementById("change")  //查找元素
x.innerHTML="<link href=\"./load.css\" rel=\"stylesheet\"><div class=\"container\"><div class=\"warning\"></div></div>";
}
