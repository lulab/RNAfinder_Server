<!-- ========================================================= -->
<!-- ========================================================= -->
<!-- Read page input and run COME  -->
<!-- Include 1.read proof; 2. prepare dir; 3.send job to queue and fetch the result-->
<!-- Authors: Hu Boqin,Zhi J. Lu.  Revised: 12.10.2015  -->
<!-- ========================================================= -->
<!-- ========================================================= -->



<html  lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COME Result</title>

<!-- ========================================================= -->
<!-- define css style -->
<!-- ========================================================= -->
    <!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/table.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">


<!-- ========================================================= -->
<!-- basic js -->
<!-- ========================================================= -->
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 
	<script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script><script>window["_GOOG_TRANS_EXT_VER"] = "1";</script>
	<script src="./js/jquery.min.js"></script> 



</head>

<!-- ========================================================= -->
<!-- ========================================================= -->
<!-- ========================================================= -->
<!-- ========================================================= -->
<body>

    <div class="container">
<!-- ========================================================= -->
<!-- print the common top menu -->
<!-- ========================================================= -->
      <div class="masthead">
        <p>
          <font size="20" face="arial" color="SteelBlue"><b>RNAfinder</b></font> 
          <font size="20" face="arial" color="grey">/<b>COME</b></font>
        </p>
        <ul class="nav nav-justified">
          <li ><a href="./index.html">Home</a></li>
          <li class = "active"><a href="./CP.html">COME</a></li>
          <li><a href="./NP.html">RNAfeature</a></li>
          <li><a href="./Dataset.html">Data Sets</a></li>
          <li><a href="Contact.html">Contact</a></li>
        </ul>
      </div>


<!-- ========================================================= -->
<!-- the main php to run COME  -->
<!-- start with 3 functions, and then the main part to call these functions  -->
<!-- ========================================================= -->
<?php
///////////////////////////////////////////////////////////
//1. a function to format result files (result --> result.json) for display by result.php  
///////////////////////////////////////////////////////////
	function displayResult($resultId){
		//convert the raw table file to a json file
		$uploadfile = fopen("./".$resultId."/result", "r") or die("2Unable to open file!");
  		$resultString= fread($uploadfile,filesize("./".$resultId."/result"));	
		fclose($uploadfile);
		$line = explode("\n",$resultString);
	 	for ($i = 0; $i < count($line); $i++){
                        if (!preg_match("/[a-zA-Z0-9_]/",$line[$i])) continue;
                        $each = explode("\t",$line[$i]);
			$resultArray[$i] = array (	"Transcript ID" => $each[0],
							"Coding Potential" => $each[1],
							"Predicted Class" => $each[2],

							 "GC_Content" => $each[3],
							 'Protein_Conservation' => $each[4], 
							 'DNA_Conservation' => $each[5],
							 'RNA_Structure_Conservation' => $each[6],
							 'H3K4me3' => $each[7],
							 'H3K36me3' => $each[8],
							 'NonpolyA_RNAseq' => $each[9],
							 'PolyA_RNAseq' => $each[10],
							 'Small_RNAseq' => $each[11]
						 );	
		}
		$jsonresultArray=json_encode($resultArray);		
		$jsonfile = fopen("./".$resultId."/result.json", "w") or die("3Unable to write file!");

		fwrite($jsonfile, '{"data":');
		fwrite($jsonfile, $jsonresultArray);
		fwrite($jsonfile, "}");
                fclose($jsonfile);

		//re-direct to the display page
		$result_page="./result.php?ID=".$resultId;
		echo " <div> <h3 style = \"text-align: center;\">Coding Potential for your RNA transcripts</h3> </div>";
 		echo "<div>";
		echo '<a href="'.$result_page.'">Show Result</a>';
 		echo "</div>";
		header("Location: $result_page");  
	}


///////////////////////////////////////
//2. a function to run COME at queue
///////////////////////////////////////
	function codingPotential($tempId){
		$cmd = "name=job1&command=".urlencode("/var/www/html/RNAfinder/submit_job.sh ".$tempId."/input ".$tempId." ".$_POST["Species"]);
		exec("curl 'localhost:4321/submit?".$cmd."'",$res,$res1);
		return $res[0];
		
	}

///////////////////////////////////////
//3. a function to make a dir to store result of come
///////////////////////////////////////
	function makeTemp(){
		exec("mktemp -d  --tmpdir -p result XXXXXXXXXXXXXXX", $tempId);
		return $tempId;	
	}


///////////////////////////////////////
///////////////////////////////////////
// main part of php: read from uploaded file or pasted text; then call other functions to run
///////////////////////////////////////
///////////////////////////////////////
	// get input and write input file for uploaded file
	if ($_FILES["file"]["size"]){
		if ($_FILES["file"]["error"] > 0){
                 echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}
			$filePath = $_FILES["file"]["tmp_name"];
			$gtf=file_get_contents($_FILES['file']['tmp_name']);
			$tempId = makeTemp();  //prepare the dir
			exec("/bin/mv ".$filePath." ./".$tempId[0]."/input");
			if (codingPotential($tempId[0])) displayResult($tempId[0]); //run COME and output result files
			else echo "No result";
	// get input and write input file for pasted text
	}else if ($_POST["text"]){
		$gtf = $_POST["text"]; 
		if(get_magic_quotes_gpc()){   //如果get_magic_quotes_gpc()是打开的
		$gtf=stripslashes($gtf);  //将字符串进行处理
		}
		$tempId = makeTemp();  //prepare the dir
		$myfile = fopen("./".$tempId[0]."/input", "w") or die("Unable to open file!");
		fwrite($myfile, $gtf);
		fclose($myfile);
		if (codingPotential($tempId[0])) displayResult($tempId[0]); //run COME and output result files
		else echo "No result";
	//handle other input errors
	}else if (!$_POST["text"] && !$_FILES["file"]["size"]){
		echo "<script>alert('Please paste or upload gtf file');</script>";
	}else{
		echo "<script>alert('Invalid file');</script>";
	}
?>

</body>
</html>
