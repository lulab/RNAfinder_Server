<!-- ========================================================= -->
<!-- ========================================================= -->
<!-- Display Result calcualted by COME  -->
<!-- Include 1. a smmary table; 2. a detailed table showing all features; 3. a feature table with heatmap -->
<!-- Author: Zhi J. Lu, Hu Boqin, Revised: 12.10.2015  -->
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
	<script src="./bootstrap/js/ie-emulation-modes-warning.js"></script><style type="text/css"></style>
	<script src="./js/jquery.min.js"></script>

<!-- get the parameters in url passed -->
<script>
function getQueryParams(qs) {
    qs = qs.split('+').join(' ');

    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}
</script>



<!-- ========================================================= -->
<!-- js for hide and show -->
<!-- ========================================================= -->
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".flip").click(function(){
    			$(".panel").slideToggle("slow");
  		});
	});
</script>
<style type="text/css"> 
div.panel,p.flip
{
margin:0px;
padding:5px;
text-align:center;
background:#F2F2F2;
border:solid 1px #c3c3c3;
}
div.panel
{
display:none;
}
</style>

<!-- end of hide and show -->



<!-- ========================================================= -->
<!-- js of table plus -->
<!-- ========================================================= -->
<link href="./js/jquery.dataTables.min.css" rel="stylesheet">
<script src="./js/jquery.dataTables.1.10.4.min.js"></script>
<style type="text/css"> 
td.details-control {
    background: url('./images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('./images/details_close.png') no-repeat center center;
}
</style>
<script type="text/javascript"> 
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>GC Content:</td>'+
            '<td>'+d.GC_Content+'</td>'+
            '<td>Protein Conservation:</td>'+
            '<td>'+d.Protein_Conservation+'</td>'+
            '<td>DNA Conservation:</td>'+
            '<td>'+d.DNA_Conservation+'</td>'+
	    '<td>RNA Structure Conservation:</td>'+
            '<td>'+d.RNA_Structure_Conservation+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>H3K4me3:</td>'+
            '<td>'+d.H3K4me3+'</td>'+
            '<td>H3K36me3:</td>'+
            '<td>'+d.H3K36me3+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Nonpoly(A) RNA-seq:</td>'+
            '<td>'+d.NonpolyA_RNAseq+'</td>'+
            '<td>Poly(A)+ RNA-seq:</td>'+
            '<td>'+d.PolyA_RNAseq+'</td>'+
            '<td>Small RNA-seq:</td>'+
            '<td>'+d.Small_RNAseq+'</td>'+
        '</tr>'+
    '</table>';
}

// main function of table plus 
$(document).ready(
function drawtable(table_file)
 {

	var query = getQueryParams(document.location.search);
	var input_ajax = [query.ID,"result.json"].join("/");
	//alert(input_ajax);
	var table = $('#example').DataTable( {
        "ajax": input_ajax,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "Transcript ID" },
            { "data": "Coding Potential" },
            { "data": "Predicted Class" },
            { "data": "RNA_Structure_Conservation" },
            { "data": "PolyA_RNAseq" }
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

}); 

</script>

<!-- end of table plus -->


<!-- ========================================================= -->
<!-- js of heatmap -->
<!-- ========================================================= -->
<script src="./js/highcharts/highcharts.js"></script>
<script src="./js/highcharts/heatmap.js"></script>
<script src="./js/highcharts/exporting.js"></script>
<!-- read the result file and format it to an multidimensional array that myheatmap.js can read -->
<?php
        $resultId=$_GET["ID"];
        $uploadfile = fopen("./".$resultId."/result", "r") or die("2Unable to open file!");
        $resultArray= fread($uploadfile,filesize("./".$resultId."/result"));
        fclose($uploadfile);
        $line = explode("\n",$resultArray);
	$num=0;
        for($i = 0; $i< count($line); $i++){
                if (!preg_match("/[a-zA-Z0-9_]/",$line[$i])) continue;            
                $each = explode("\t",$line[$i]);
                for($j = 0; $j <count($each)-3-1; $j++) { // it will read an extra line, so -1; skip the first 3 col., so -3
                	if (!preg_match("/[a-zA-Z0-9_]/",$each[$j+3])) continue;  
                	$data_array[$num][0]=$j;
                	$data_array[$num][1]=$i;
                	$data_array[$num][2]=$each[$j+3];  // skip the first 3 col. 
			$num++;
            	}
                $ID_array[$i]=$each[0]; 
        }

?>
<!-- pass PHP array to JavaScript array -->
<script type="text/javascript">
var mydata = <?php echo json_encode( $data_array ) ?>;
var IDdata = <?php echo json_encode( $ID_array ) ?>;
</script>
<!-- main js of my heatmap configure -->
<script src="./js/myheatmap.js"></script>
<!-- end of heatmap -->


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
<!-- start the main php for 3 tables/charts  -->
<!-- ========================================================= -->
<?php
		$resultId=$_GET['ID'];
		$uploadfile = fopen("./".$resultId."/result", "r") or die("2Unable to open file!");
		$resultArray= fread($uploadfile,filesize("./".$resultId."/result"));
		fclose($uploadfile);
		$line = explode("\n",$resultArray);
///////////////////////////////////////////////////////////
//1. Display Summary Table 
///////////////////////////////////////////////////////////
	echo "
      	<div> <Br><h2 style = \"text-align: center;\">Coding Potential for your RNA transcripts</h2> </div>
      	<div> <Br><Br><h3 style = \"text-align: center;\">Summary</h3> </div>
        <div class=\"ui-table-container\">
             <table class=\"ui-table\" id=\"results\">
                   <thead>
                        <tr>
                            <th>Transcript ID</th>
                            <th>Coding Potential</th>
                            <th>Predicted Class</th>
                        </tr>
                   </thead>
                   <tbody>
		     ";
		   for($i = 0; $i < count($line); $i++){
			if (!preg_match("/[a-zA-Z0-9_]/",$line[$i])) continue;
			$each = explode("\t",$line[$i]);
			echo "<tr>";
			echo "<td>".$each[0]."</td>";
			echo "<td>".$each[1]."</td>";
			echo "<td>".$each[2]."</td>";
 			echo "</tr>";

		   }
	
	echo"
                   </tbody>
                </table>
		<br>
		<br>
	</div>
";

///////////////////////////////////////////////////////////
//2. Display Detailed Tables and heatmap 
///////////////////////////////////////////////////////////
      		echo '<div> <Br><Br><h3 style ="text-align: center;">Detail</h3> </div>';
		echo '<p><b><a href="./'.$resultId.'">Download Result</a></b></p>';
                echo "<p class=\"flip\"><b>Show/Hide</b></p>";
		echo "<div class=\"panel\">";
//Detailed Table
	echo "<Br><Br>";
	echo "<table id=\"example\" class=\"display\" cellspacing=\"0\" width=\"100%\">";
        echo "<thead>
            <tr>
               <th></th>
               <th>Transcript ID</th>
               <th>Coding potential</th>
               <th>Predicted Class</th>
               <th>RNA Structure Conservation</th>
               <th>Expression (Poly(A)+ RNA-seq)</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
               <th></th>
	       <th>Transcript ID</th>
               <th>Coding Potential</th>
               <th>Predicted Class</th>
               <th>RNA Structure Conservation</th>
               <th>Expression (Poly(A)+ RNA-seq)</th>
            </tr>
        </tfoot>
    </table>";

// end of Detailed Table

///////////////////////////////////////////////////////////
// 3. Display the supporting features ant its heatmap 
///////////////////////////////////////////////////////////
//3.1 print the values
///////////////////////////////////////////////////////////
      		echo '<div> <Br><Br><h4 style ="text-align: center;">Supporting Features</h4> </div>';
		echo "will also show a heatmap if less than 100 transcripts.";
		echo"
    	<table class=\"ui-table\" id=\"results\">
                                    <thead>
                                        <tr>
                                            <th>Transcript ID</th>";
					    $featureArray=array('GC%', 'Protein Conservation', 'DNA Conservation', 'RNA Structure Conservation', 'H3K4me3', 'H3K36me3', 'Nonpoly(A) RNA-seq', 'Poly(A)+ RNA-seq', 'Small RNA-seq');
				for($j = 0; $j < 9; $j++){
					echo "<th>".$featureArray[$j]."</th>";
				}
                                echo"  </tr>
                                    </thead>
			
                                    <tbody>
		     ";
		for($i = 0; $i < count($line); $i++){
		//	if ($line[$i] == "" )
			if (!preg_match("/[a-zA-Z0-9_]/",$line[$i])) continue;
			
			$each = explode("\t",$line[$i]);
			echo "<tr>";
			echo "<td>".$each[0]."</td>";
			for($j = 0; $j < 9; $j++){
				echo "<td>".$each[$j+3]."</td>";
			}
 			echo "</tr>";

		}
		echo"
                                    </tbody>
                                </table>
		<br>
";

///////////////////////////////////////////////////////////
//3.2draw the heamap if less than 100 transcripts
	if(count($line)<=100) {
		echo '<div id="container" style="min-height: 500px;  min-width: 800px; max-width: 800px; margin: 0 auto"></div>';

	}
//end of supporting feature values and heatmap

		echo "</div>";

?>

		<br><br><br>
</body>
</html>
