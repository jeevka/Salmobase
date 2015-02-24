	
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
$gene_name = $gname;
$Image_file_name = "/var/www/html/GE_Images_Ssa_3p6_Chr/".$gname.".png";
$gene_func_text = $_GET['func'];
$Ortho_Gene = "/var/www/html/Ortho_Genes/".$gname.".png";
$Ortho_Protein = "/var/www/html/Images/".$Transcript_name.".png";
#echo $Ortho_Protein;
#echo $Ortho_Gene;
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
        $Ortho_Gene = "/Default_Images/Default_Gene.jpg";
}

# Check whether we have the Orthologous image for the given gene
if (file_exists($Ortho_Protein)) {
        $Ortho_Protein = "/Images/".$Transcript_name.".png";
}
# If there is no Ortholog Gene similarity image/data then choose the default one which says there is no Ortho data data
else{
        $Ortho_Protein = "/Default_Images/Default_Protein.jpg";
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
	<div id="SB_div">
        <font id="SB" color="blue">S a l m o B a s e</font>
	</div>
</div>


<div id=centerdiv>


<!--Gene expression image div -->
<div id=geneexpression>
        <img src="<?php echo $Image_file_name;  ?>" alt="GE" width="570px" height="500px">
        <div id="geneexpression_text"> Gene expression data (FPKM) for Salmon transcript <?php echo $gene_name ?> in different tissue samples.</div>
</div>

<!--Gene name div in first left -->
<div id="gene_name"> <div id="gene_name_text"><div id="gene_name_text_inner"> Gene Name</div></div> <div id="gene_name_value"><?php echo $gname ?></div> </div>
<!--Gene ID div in second left -->
<div id="gene_ID"> <div id="gene_ID_text"> <div id="gene_name_text_inner"> Gene ID</div> </div> <div id="gene_name_value"> <?php echo $gname ?> </div> </div>
<!-- Gene Function Div in the third left -->
<div id="gene_function"> 
	<div id="gene_ontology_text"> 
		<div id="gene_ontology_text_inner"> Gene Ontology</div> 
	</div> 
	<div id="gene_ontology_text_1">
		<div id="gene_ontology_value_inner"><?php echo $gene_func_text ?>. </div> 
	</div>

	<div id="gene_function_text">
			<div id="gene_function_text_inner">Gene Function</div>
	</div> 
	<div id="gene_function_text_1">
			<div id="gene_function_value_inner"><?php echo $gene_func_text ?>.</div>
	</div>
	<!--div id="gene_ontology_text">Gene Ontology:</div> <div id="gene_ontology_text_1"><?php echo $gene_func_text ?>. </div-->
</div>

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


<div id="methods">
	<div id="method_text"> 
	<b> Methods used:</b> Salmon gene sequences were mapped to Rainbow Trout, Zebra Fish, Cod and Stickleback genomes using blastn. Blastp was used to find orthologous protein for Salmon protein sequences in Rainbow Trout, Zebra Fish, Cod and Stickleback protein genomes. In both cases, best blast hit was considered as orthologous gene or protein for Salmon gene or protein sequence. For gene sequences, blastn results were used to make orthologous gene similarity plot. For orthologous protein similarity, Each Salmon protein was aligned against it's orthologous protein in other Fish species mentioned about using ClustalW.<br><br>
	<b>FPKM:</b> FPKM stands for "Fragments Per Kilobase Of Exon Per Million Fragments Mapped".  
	</div>
</div>

<!--Gene expression image div -->
<!--div id=geneexpression>
        <img src=" alt="GE" width="570px" height="500px">
        <div id="geneexpression_text"> Gene expression data (FPKM) for Salmon transcript in different tissue samples.</div>
</div-->


<!--Ortholog Protein image div -->
<div id=ortho_protein>
        <img src="<?php echo $Ortho_Protein;  ?>" alt="OG" height="500px" width="580px"> 
	<div id="ortho_protein_text"> <div id="ortho_protein_inner_text"> Comparision of Salmon protein <?php echo $gname ?> with other fish species.</div> </div>
</div>


<!--Ortholog Gene expression image div -->
<div id=ortho_gene>
        <img src="<?php echo $Ortho_Gene;  ?>" alt="OG" height="500px" width="580px">
	<div id="ortho_gene_text"> <div id="ortho_protein_inner_text"> Comparision of Salmon gene <?php echo $gene_name ?> with other fish species.</div> </div>
</div>


<!--END OF Center div -->
</div>


<!--End of Main div -->
</div>
</body>
</html>


<style type="text/css">
body
{
background-color:#214B96;
}

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
height:1109px;
background-color:white;
}

#gene_name
{
height:30px;
border-style: solid;
border-color: #01A9DB;
width:588px;
float:left;
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
height:30px;
margin-left:0;
margin-top:0;
text-align:center;
width:250px;
}

#gene_name_text_inner
{
position:absolute;
margin-top:5px;
margin-left:70px;
}

#gene_name_value
{
float:right;
margin-left:323px;
position:absolute;
margin-top:7px;
text-align:middle;
font-size:18px;
}

#gene_ID
{
height:30px;
border-style: solid;
border-color: #01A9DB;
margin-top:0px;
margin-right:0px; 
width:588px; 
float:right;
}

#gene_ID_text
{
float:left;
background-color:blue;
color:white;
font-size:20px;
height:30px;
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
height:98px;
border-style: solid;
border-color: #01A9DB;
margin-top:0px;
width:588px;
float:left;  
}

#gene_function_text
{
font-size:18px;
}


#gene_function_text
{
border-style: solid;
border-color: #01A9DB;
width:244px;
height:59px;
background-color:blue;
color:white;
}

#gene_function_text_1
{
border-style: solid;
border-color: #01A9DB;
width:336px;
position:absolute;
margin-left:249px;
margin-top:-64px;
height:60px;
}

#gene_function_text_inner
{
float:left;
font-size:20px;
height:0px;
margin-left:-6px;
margin-top:16px;
text-align:center;
width:246px;
}

#gene_function_value_inner
{
float:left;
font-size:16px;
height:0px;
margin-left:21px;
margin-top:16px;
text-align:center;
width:250px;
}

#gene_ontology_text
{
border-style: solid;
border-color: #01A9DB;
width:244px;
height:29px;
background-color:blue;
color:white;
}

#gene_ontology_text_1
{
width:336px;
position:absolute;
margin-left:249px;
margin-top:-38px;
height:33px;
border-style: solid;
border-color: #01A9DB;
}

#gene_ontology_text_inner
{
float:left;
font-size:20px;
height:0px;
margin-left:0;
margin-top:4px;
text-align:center;
width:246px;
}

#gene_ontology_value_inner
{
float:left;
font-size:16px;
height:0px;
margin-left:23px;
margin-top:10px;
text-align:center;
width:250px;
}

#methods
{
border-style: solid;
border-color: #01A9DB;
height:197px;
width:588px;
}

#method_text
{
margin-top:6px;
margin-left:7px;
font-size:17px;
}

#geneexpression
{
border-style: solid;
border-color: #01A9DB;
width:600px;
height:550px;
margin-left:0px;
float:right;
margin-top:0px;
}

#geneexpression_text
{
border-style: solid;
border-color: #01A9DB;
border-left-style:none;
height:44px;
width:600px;
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
width:588px;
height:170px;
margin-left:0px;
margin-top:176px;
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
margin-left:198px;
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
vertical-align:middle;
}

#SB_div
{
position:absolute;
margin-top:20px;
margin-left:328px;
}

#ortho_protein
{
margin-left:614px;
margin-top:0px;
border-style: solid;
border-color: #01A9DB;
height:550px;
width:600px;
float:right;
}

#ortho_protein_text
{
border-style: solid;
border-color: #01A9DB;
height:40px;
width:600px;
border-left-style:none;
border-right-style:none;
font-size: 18px;
text-align: center;
vertical-align: middle;
}

#ortho_protein_inner_text
{
position:absolute;
margin-top:7px;
margin-left:10px;
}

#ortho_gene
{
margin-top:-557px;
margin-left:0px;
height:552px;
width:588px;
border-style: solid;
border-color: #01A9DB;
float:left; 
}

#ortho_gene_text
{
border-style: solid;
border-color: #01A9DB;
height:42px;
border-left-style:none;
border-right-style:none;
font-size: 18px;
text-align: center;
}

</style>
