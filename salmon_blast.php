
<!DOCTYPE html>
<html>
<title>Salmon Blast search </title>

<head>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
</head>

<body> 

<!-- MAIN DIV -->
<div id=maindiv>

<div id="headerdiv">
	<font id="SB" color="blue">S a l m o B a s e</font>
</div>

<!-- Main MENU options -->
<div id=menudiv >
        <ul id=coolMenu">
                <li><a href="http://salmobase.org/index.php">HOME</a></li>
                <li><a href="http://salmobase.org/salmon_blast.php">BLAST Search </a></li>
                <li><a href="http://salmobase.org/cgi-bin/gb2/gbrowse/salmon_GBrowse/" target="_blank" >GBrowse </a> </li>
		<li> <a id=gbrowse href="http://salmobase.org/Downloads/">Download</a> </li>
                <li> <a id=gbrowse href="http://salmobase.org/contactus.php/">Contact Us</a> </li>
        </ul>
</div>


<!-- Main DIV which contains all the BLAST options -->
<fieldset id="contentdiv">
 <legend id=blast_title> BLAST Search </legend> <br>

<!--Query Seq DIV -->
<form enctype="multipart/form-data" action="/cgi-bin/salmon_blast.py" method="post">
  <textarea id=query_seq name="query_seq"></textarea>  <br><br>
  
  Or, upload file  <input type="file" name="qfile" id="qfile"><br>
                   
<!-- Database selection-->
<h3>Choose database </h3>
<select id="database" name="database">
  <option value="SG3p6">Salmon Genome Assembly 3.6</option>
  <option value="SG3p6_Chr">Salmon Genome Assembly 3.6_Chr</option>
  <option value="SG3p6_Chr">Protein (Salmon 3.6 Chr)</option>
</select> <br><br>

<!-- BLAST SELCTION-->
<input type="radio" id="blast" name="blast" value="blastn"> blastn<br>
<input type="radio" id="blast" name="blast" value="megablast" checked> megablast<br>
<input type="radio" id="blast" name="blast" value="tblastn"> tblastn<br>
<input type="radio" id="blast" name="blast" value="blastp"> blastp<br>
<h3> Choose output format </h3>

<input type="radio" id="output_format" name="output_format" value="6" checked>  Table<br>
<input type="radio" id="output_format" name="output_format" value="0"> Alignment<br>

<!-- select id=output_format_options>
  <option  name="output_format" selected="selected" value="6">Table</option>
  <option  name="output_format" value="0">Alignment</option>
</select--> <br> 

E-value: <input type="text" name="evalue" value=0.05 style="width:40px"><br> <br>

<!-- SUBMIT BLAST Button-->
<button id=blast_submit type="submit" value="BLAST" />BLAST</button>
</form>

<!--END OF Query Seq DIV -->
</fieldset>

<div id="footer">Copyright © Salmobase.org</div>

<!-- end of main div-->
</div>

</body>
</html>


<style type="text/css">
#maindiv
{
width:900px;
margin-left:auto;
margin-right:auto;
text-align:left;
}

#headerdiv
{
background-color:#FFFFFF;
text-color:#FFFFFF;
width:900px;
height:120px;
text-align:center;
}

#SB
{
font-weight:bold;
font-size:80px;
}

#menudiv
{
width:900px;
height:30px;
background-color:blue;
margin:auto;
text-align:center;
}

#coolMenu
{
text-color:#FFFFFF;
font-weight:bold;
font-size:15px;
}

#contentdiv
{
background-color:#FFFFFF;
height:700px;
width:900px;
border: 1px solid;
margin-top:10px;
}

#blast_title
{
font-size:30px;
font-weight:bold;
}

#query_seq
{
height:250px;
width:650px;
}

#database
{
width:225px;
}

#blast_submit
{
height:30px;
width:120px;
font-size:20px;
}

#footer
{
height:80px;
width:900px;
text-align:center;
margin-top:10px;
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
margin-top:5px
}

li
{
float:left;
}

a
{
display:block;
width:180px;
color:#FFFFFF;
}

</style>
