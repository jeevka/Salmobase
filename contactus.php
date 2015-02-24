<!DOCTYPE html>
<html>
<title>SalmonBase </title>
<body>

<div id=maindiv>

<div id="header">
        <font id="SB" color="blue">S a l m o B a s e</font>
</div>

<!-- Main MENU options -->
<div id=menudiv >
       <div id=inner_menu_div>
        <ul id=coolMenu">
                <li><a id=home href="http://128.39.181.180/index.php">Home</a></li>
                <li><a id=blast_search href="http://128.39.181.180/salmon_blast.php">BLAST Search </a></li>
                <li><a id=gbrowse href="http://128.39.181.180/cgi-bin/gb2/gbrowse/salmon_GBrowse/" target="_blank">GBrowse</a> </li>
                <li><a id=gbrowse href="http://128.39.181.180/Downloads/">Download</a> </li>
                <li><a id=gbrowse href="http://128.39.181.180/contactus.php">Contact Us</a> </li>
        </ul>
       </div>
</div>

<div id=contact> 

<!--form  action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit"/> Your name:<br />
    <input name="name" type="text" value="" size="30"/> <br /> Your email:<br />
    <input name="email" type="text" value="" size="30"/> <br /> Your message:<br />
    <textarea name="message" rows="7" cols="30"> </textarea> <br />
    <input type="submit" value="Send email"/>
</form--> 

<?php
$action=$_REQUEST['action'];
if ($action=="")    /* display the contact form */
    {
    ?>
    <form  action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit">
    Your name:<br>
    <input name="name" type="text" value="" size="30"/><br>
    Your email:<br>
    <input name="email" type="text" value="" size="30"/><br>
    Your message:<br>
    <textarea name="message" rows="7" cols="30"></textarea><br>
    <input type="submit" value="Send email"/>
    </form>
    <?php
    }
else                /* send the submitted data */
    {
    $name=$_REQUEST['name'];
    $email=$_REQUEST['email'];
    $message=$_REQUEST['message'];
    if (($name=="")||($email=="")||($message==""))
        {
        echo "All fields are required, please fill <a href=\"\">the form</a> again.";
        }
    else{
        $from="From: $name<$email>\r\nReturn-path: $email";
        $subject="Message sent using your contact form";
        mail("jeevan.karloss@nmbu.no", $subject, $message, $from);
        echo "Email sent!";
        }
    }
?>

</div>



</div>
</body>
</html>


<style type="text/css">

#contact
{
width:500px;
height:250px;
margin-left:auto;
margin-right:auto;
margin-top:50px;
border:1px solid;
text-align:center;
#background-color:#53DEF7;
}

#maindiv
{
margin-left:auto;
margin-right:auto;
width:900px
}

#menudiv
{
width:900px; 
height:30px;
background-color:blue;
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
margin-top:20px;
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
margin-top:4px;
height:50px;
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
height:300px;
width:440px;
margin-top:10px;
margin-right:10px;
margin-left:0px;
float:left; 
}

#about_salmonbase
{
height:235px;
width:445px;
float:left;
margin-right:2px;
margin-top:20px;
border:1px solid;
}

#fundings
{
border:1px solid; 
margin-top:250px;
height:170px;
}

#GBrowse_text
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
