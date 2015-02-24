<?php
if( isset($_GET['SBsearch']) )
{
    //be sure to validate and clean your variables
    $gene_name = htmlentities($_GET['SBsearch']);
    //then you can use them in a PHP function.
    $gbrowse = "http://128.39.181.180/cgi-bin/gb2/gbrowse/salmon_GBrowse/?name=".$gene_name;
    
    header("Location: $gbrowse");
}
?>

<!DOCTYPE html>
<html>
<title>SalmoBase</title>
<head> 
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body> 

<div id=maindiv>

<div id="header">
 	<font id="SB">S a l m o B a s e</font>
</div>

<!-- Main MENU options -->
<div id=menudiv >  
       <div id=inner_menu_div>
	<ul id=coolMenu">
    		<li><a id=home href="http://10.209.0.204/index.php">Home</a></li>
    		<li><a id=blast_search href="http://10.209.0.204/salmon_blast.php">BLAST Search </a></li>
                <li><a id=gbrowse href="http://10.209.0.204/cgi-bin/gb2/gbrowse/salmon_GBrowse_Chr/" target="_blank">GBrowse</a> </li>
                <li><a id=gbrowse href="http://10.209.0.204/Downloads/">Download</a> </li>
		<li><a id=gbrowse href="http://10.209.0.204/contactus.php">Contact Us</a> </li>
        </ul>
       </div>
</div>

<!--center div -->
<!--div id=centerdiv-->

<!-- img id=salmon_image src="Atlantic_Salmon.JPG"--> 
<div>
<img id=salmon_image src="circos-Ssa.png">
<div id=figure_text>
<b>Conserved synteny blocks</b> on ssa21 and ssa25, ssa03 and ssa06, ssa03 and ssa14 . Sequence scaffolds were ordered by linkage maps. Plot by <a href="http://circos.ca/">Circos</a>.
</div>
</div>


<div id=gene_search> 
	<form action="" method="get">
        <fieldset>
	<legend id=gene_search_legend> Quick gene search:</legend>
  	<input type="text" id="SBsearch" name="SBsearch" >
        <input id=gene_search_submit type="submit" value="Search"></input>
  	<!-- button type="button" onclick= "window.open('http://128.39.181.180/cgi-bin/gb2/gbrowse/salmon_GBrowse/?name=TCONS_00000002')" >Gene search</button--> 
        </fieldset>
	</form>
</div>

<div id=about_salmonbase>
<div id=about_seq_project>
<div id=about_seq_text>
<br>
<b>The Sequencing Project</b>
<p>The International Cooperation to Sequence the Atlantic Salmon Genome (ICSASG) will produce a genome sequence that identifies and physically maps 
all genes in the Atlantic salmon genome and acts as a reference sequence for other Salmonids. 
The motivation for this is to better understand the biology of Salmonids as it relates to sustainable aquaculture, conservation of wild fish and aquatic 
health among other things. The White Paper describing the sequencing project can be found <a href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC2965382/?tool=pubmed">here</a>.</p>
</div>
</div>

<div id=gbrowse_text> 
<div id=gbrowse_text_inner>
<br>
GBrowse has been established by researchers at <a href="http://cigene.no/" target="_blank">CIGENE/IHA</a>, <a href="http://velkommen.nmbu.no/" target="_blank">Norwegian University of Life Sciences</a>, in association with the <a href="www.bioinfo.no" target="_blank">ELIXIR.NO</a>. It presents both the latest <a href="http://128.39.181.180/cgi-bin/gb2/gbrowse/salmon_GBrowse/" target="_blank"><i>S. salar</i> assembly</a> and includes various metadata such as gene content.
</div>
</div>
</div> 


<!--div id=gene_search>
        <form action="" method="get">
        <fieldset>
        <legend id=gene_search_legend> Quick gene search:</legend>
        <input type="text" id="SBsearch" name="SBsearch" >
        <input type="submit" value="Gene search"></input>
        <button type="button" onclick= "window.open('http://128.39.181.180/cgi-bin/gb2/gbrowse/salmon_GBrowse/?name=TCONS_00000002')" >Gene search</button>
        </fieldset>
        </form>
</div-->


<!-- div id=papers onload="Pubmed_File_Parser()" -->

<br>

<div id=fundings> 
<br>
&nbsp;&nbsp;The International Cooperation to Sequence the Atlantic Salmon Genome (ICSASG) is supported by the following organizations: 
        <br> <br>	
        <div id=font_style_1>
	1. <a href="http://www.forskningsradet.no/en/Home+page/1177315753906" target="_blank">Research Council of Norway (RCN)</a> <br> 
	2. <a href="http://www.fhf.no/hot-topics/about-fhf/" target="_blank">Norwegian Seafood Research Fund-FHF</a> <br>
	3. <a href="http://www.genomebc.ca/" target="_blank">Genome BC</a> <br>
	4. <a href="www.english.corfo.cl" target="_blank"> The Chilean Economic Development Agency – CORFO and InnovaChile Committee</a><br>
	5. Marine Harvest, AquaGen, Cermaq and Salmobreed provide support through the FHF <br>
	</div>
</div>
<br>

<!--  about GBrowse --!>

<!--PHP CODE to read the Pubmed -->

<!--?php
$myfile = fopen("/var/www/cgi-bin/Pubmed_data/www.ncbi.nlm.nih.gov/pubmed?term=atlantic+salmon&format=text", "r") or die("Unable to open file!");
// Output one line until end-of-file

while(!feof($myfile)) {
  if (strstr)
  echo fgets($myfile) ;
}

fclose($myfile);

? -->


<!-- Footer -->
<br>
<div id="footer">Copyright © Salmonbase.org</div>

<!--END of center div -->
<!-- /div -->

<!-- END OF MAIN DIV-->
</div>

</body>
</html>

<!-- JAVA SCRIPT CODE -->

<!-- script>
function Pubmed_File_Parser() {
    document.getElementById("demo").innerHTML = "Paragraph changed.";
}
</script -->

<!--CSS CODE -->

<style type="text/css">

body
{
background-color:#214B96;
}

a{
color:white;
}

#maindiv
{
margin-left:auto;
margin-right:auto;
width:900px;
background-color:white;
}

#menudiv
{
width:900px; 
height:30px;
background-color:#214B96;
margin:auto;
text-align:center;
}

#inner_menu_div
{
margin-left:auto;
margin-right:auto;
}

#font_style_1
{
font-size:15px;
margin-left:25px;
}

#header
{
background-color: #FFFFFF;
width: 900px;
height: 100px;
text-align: center;
margin-top:10px;
}

#coolMenu
{
text-color:#FFFFFF;
font-weight:bold;
font-size:20px;
width:900px;
text-align:center;
margin-left:300px;
}

#centerdiv
{
margin-left:auto;
margin-right:auto;
}

#gene_search
{
margin-top:0px;
height:50px;
}

#gene_search_submit
{
width:50em:
height:20em;
}

#SBsearch
{
width:250px;
}

#gene_search_legend
{
font-size:20px;
font-weight:bold;
}

#salmon_image
{
height:400px;
width:440px;
margin-top:10px;
margin-right:10px;
margin-left:0px;
float:left; 
}

#figure_text
{
margin-left:5px;
margin-right:10px;
height:20px;
width:440px;
}

#gbrowse_text
{
width:440px;
height:130px;
margin-left:0px;
margin-top:10px;
background-color:#214B96;
color:white;
border-radius: 15px;
}

#gbrowse_text_inner
{
width:90%;
height:110px;
margin:auto;
}

#about_salmonbase
{
height:365px;
width:445px;
float:left;
margin-right:2px;
margin-top:15px;
}

#about_seq_project
{
background-color:#214B96;
color:white;
width:440px;
height:240px;
margin-left:0px;
margin-top:5px;
border-radius: 15px;
}

#about_seq_text
{
width:90%;
margin:auto;
height:230px;
}

#fundings
{
margin-top:400px;
height:170px;
width:880px;
color:white;
margin-left:10px;
background-color:#214B96;
border-radius: 15px;
}

#GBrowse_text_Not_IN_USE
{
border:1px solid;
}

#latest_papers
{
height:275px;
width:900px;
font-size:25px;
font-weight:bold;
margin-top:370px;
}

#papers
{
font-size:15px;
}

#footer
{
background-color: #FFFFFF;
clear: both;
text-align:center ;
width: 900px;
}

#SB
{
color:#214B96;
font-weight:bold;
font-size:70px;
}

center
{
margin-left:auto
margin-right:auto
}

ul
{
list-style-type:none;
margin:0;
padding:0;
}

li
{
display:inline;
margin-top:5px;
}

li
{
float:left;
}

#home,#blast_search,#gbrowse,#resource,#news
{
display:block;
width:180px;
color:#FFFFFF;
}
</style>
