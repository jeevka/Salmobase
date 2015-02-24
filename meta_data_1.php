	
<?php

#####################################################################################################
# Updated Codes on 07 Oct 2014 by Jeevan
# MySql is no longer needed for gene expression data 
# So the codes are changed
#####################################################################################################

# E.g. Gname is CIGSSA_000001.t1. We need to split the gene name. 
# Gene expression data is mapped to gene names not transcript name 
$Transcript_name = $_GET['gname'];
$gname_temp = explode(".",$Transcript_name);
$gname = trim($gname_temp[0]);
$Image_file_name = "/var/www/html/GE_Images_Ssa_3p6_Chr/".$gname.".png";
$gene_func_text = $_GET['func'];
$Ortho_Gene = "/var/www/html/Ortho_Genes/".$gname.".png";

# Check whether we have the GE image for the given gene
if (file_exists($Image_file_name)) {
	$Image_file_name = "/GE_Images_Ssa_3p6_Chr/".$gname.".png";
}
# If there is no Gene expression image/data then choose the default one which says there is no GE data
else{
	$Image_file_name = "/GE_Images/Default.jpg";
}

# Check whether we have the Orthologous image for the given gene
if (file_exists($Ortho_Gene)) {
        $Ortho_Gene = "/Ortho_Genes/".$gname.".png";
}
# If there is no Ortholog Gene similarity image/data then choose the default one which says there is no Ortho data data
else{
        $Ortho_Gene = "/Ortho_Genes/Default.jpg";
}

################################################################
#     *******Coders here after are not in use******** 
################################################################
// MySQL Login Details
#$myServer = "192.168.168.205";
#$myUser = "jeevka";
#$myPass = "gbrowse01ok";
#$myDB = "salmon_test";

// Connection MySQL server
#$con=mysqli_connect($myServer,$myUser,$myPass,$myDB) or
#     die("Couldn´t connect MySQL server");

// Escape variables for security
#$ref = mysqli_real_escape_string($con, $_GET['name']);
#$start = mysqli_real_escape_string($con, $_GET['segstart']);
#$end = mysqli_real_escape_string($con, $_GET['segend']);
#$gname = mysqli_real_escape_string($con, $_GET['gname']);
#$GB_Version = mysqli_real_escape_string($con, $_GET['q']);

$ref = $_GET['name'];
$start = $_GET['segstart'];
$end = $_GET['segend'];
$gname = $_GET['gname'];
$GB_Version = $_GET['q'];

#$query = sprintf("SELECT Image_ID FROM Gene_Expression WHERE Scaffold='%s' AND Gene_start >= %s AND Gene_end <= %s",$ref,$start,$end);

#$result = mysqli_query($con,$query);

#$Image_file_name_1 = "/GE_Images/Default.jpg"; 

#while($row = mysqli_fetch_array($result)) {
#  $Image_file_name_1 = "/GE_Images/".$row['Image_ID'];
#}
 
#mysqli_close($con);

?>

<!-- To download the DNA sequence -->
<?php

// to get the gene region
if( isset($_GET['gene_region']) )
{
    //be sure to validate and clean your variables
    $gene_region = htmlentities($_GET['gene_region']);
    $range_1 = htmlentities($_GET['range1']);
    $range_2 = htmlentities($_GET['range2']);
    
    $range_1 = $range_1 - $start;
    $range_2 = $range_2 + $end;		
    echo $gene_region;	
}
?>

<!DOCTYPE html>
<html>
<title> meta data </title>

<body>

<!-- MAIN DIV -->
<div id=maindiv>

<div id="headerdiv">
        <font id="SB" color="blue">S a l m o B a s e</font>
</div>

<div id=centerdiv>

<!--Gene name div in the top -->
<div id="gene_name"> <div id="gene_name_text"> Gene Name:</div> <div id="gene_name_value"><?php echo $gname ?></div> </div>
<!--Gene ID div in the left -->
<div id="gene_ID"> <div id="gene_ID_text">  Gene ID:</div> <div id="gene_name_value"> <?php echo $gname ?> </div> </div>
<!-- Gene Function Div in the right-->
<div id="gene_function"> <div id="gene_function_text">Gene Function:</div> <?php echo $gene_func_text ?> </div>

<!-- Down load sequence opions  -->
<div id=downloadseq>
<form id=download_form  method="get" action="download.php" target="_blank">
<div id=download_div>
	<input type="radio" name="seq_type" id="gene_region" value="1" checked>Gene region<br>
	<input type="radio" name="seq_type" id="exon" value="2">Coding region<br>
	<input type="radio" name="seq_type" id="intron" value="3">Intron region<br>
	<input type="radio" name="seq_type" id="intron" value="4">Protein Sequences<br>
	<input hidden id="hide1" name="ref" value= <?php echo $ref ?>>  
	<input hidden id="hide2" name="r1" value= <?php echo $start ?>> 
	<input hidden id="hide3" name="r2" value= <?php echo $end ?>>
	<input hidden id="hide4" name="gname" value= <?php echo $gname ?>>
	<input hidden id="hide4" name="GB_Version" value= <?php echo $GB_Version ?>>
	Upstream length &nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" id=range1 name="upstream" value=0><br>
	Downstream length: <input type="text" id=range2 name="downstream" value=0> <br> <br>
	<!-- a href=  target="_blank"  style="text-decoration: none"-->
	<button type="submit"> Download Fasta File </button>
</div>
</form>
</div>

<!--Gene expression image div -->
<div id=geneexpression>
        <img src="<?php echo $Image_file_name;  ?>" alt="GE" width="570px" height="500px">
        <div id="geneexpression_text"> Gene expression data (FPKM) for Salmon transcript <?php echo $gname ?> in different tissue samples.</div>
</div>


<!--Ortholog Protein image div -->
<div id=ortho_protein>
        <img src="<?php echo $Ortho_Gene;  ?>" alt="OG" height="500px" width="580px"> 
	<div id="ortho_protein_text"> Comparision of Salmon protein <?php echo $gname ?> with other fish species.</div>
</div>


<!--Ortholog Gene expression image div -->
<div id=ortho_gene>
        <img src="<?php echo $Ortho_Gene;  ?>" alt="OG" height="570px" width="750px">
	<div id="ortho_gene_text"> Comparision of Salmon gene <?php echo $gname ?> with other fish species.</div>
</div>


<!--END OF Center div -->
</div>


<!--End of Main div -->
</div>
</body>
</html>


<style type="text/css">
#maindiv
{
width:1200px;
margin-left:auto;
margin-right:auto;
text-align:left;
}

#headerdiv
{
background-color:#FFFFFF;
text-color:#FFFFFF;
width:1200px;
height:120px;
text-align:center;
}

#hide1
{
visibility:none;
}

#centerdiv
{
border-style: solid;
border-color: #01A9DB;
width:1200px;
height:1348px;
}

#gene_name
{
height:40px;
border-style: solid;
border-color: #01A9DB;
width:580px;
float:right;
margin-top:0px;
margin-right:0px;
font-size:18px;
}

#gene_name_text
{
float:left;
background-color:blue;
color:white;
font-size:20px;
height:40px;
margin-left:0;
margin-top:0;
text-align:center;
width:250px;
}

#gene_name_value
{
float:right;
margin-right:85px;
text-align:middle;
}

#gene_ID
{
height:41px;
border-style: solid;
border-color: #01A9DB;
margin-top:0px;
margin-left:67px; 
width:580px; 
float:right;
}

#gene_ID_text
{
float:left;
background-color:blue;
color:white;
font-size:20px;
height:40px;
margin-left:0;
margin-top:0;
text-align:center;
width:250px;
}

#gene_ID_value
{
float:right;
margin-right:85px;
text-align:middle;
}

#gene_function
{
height:77px;
border-style: solid;
border-color: #01A9DB;
margin-top:0px;
margin-right:0px;
width:580px;
float:right;  
}

#gene_function_text
{
font-size:18px;
}

#geneexpression
{
border-style: solid;
border-color: #01A9DB;
width:608px;
height:550px;
margin-left:0px;
float:left;
margin-top:0px;
}

#geneexpression_text
{
border-style: solid;
border-color: #01A9DB;
border-left-style:none;
height:44px;
width:608px;
font-size: 18px;
}

#aboutgene
{
border:1px solid;
width:560px;
height:50px;
float:right;
margin-right:10px;
margin-top:10px;
}

#downloadseq
{
border-style: solid;
border-color: #01A9DB;
width:608px;
height:170px;
margin-left:0px;
margin-top:0px;
}

#range1
{
width:50px;
}

#range2
{
width:50px;
}

#download_options
{
width:100px;
margin-left:50px;
border:3px solid;
}

#download_div
{
width:230px;
height:150px;
border:1px solid;
margin-left:100px;
margin-top:5px;
}

#download_form_
{
margin-left:25px;
margin-top:0px;
}

#SB
{
font-weight:bold;
font-size:80px;
}

#ortho_protein
{
margin-left:614px;
margin-top:0px;
border-style: solid;
border-color: #01A9DB;
height:550px;
width:581px;
}

#ortho_protein_text
{
border-style: solid;
border-color: #01A9DB;
height:44px;
width:581px;
border-left-style:none;
border-right-style:none;
font-size: 18px;
text-align: center;
vertical-align: middle;
}

#ortho_gene
{
margin-top:0px;
margin-left:0px;
height:610px;
width:750px;
border-style: solid;
border-color: #01A9DB;
}

#ortho_gene_text
{
border-style: solid;
border-color: #01A9DB;
height:33px;
border-left-style:none;
border-right-style:none;
font-size: 18px;
text-align: center;
}

</style>
