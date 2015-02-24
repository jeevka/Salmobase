#!/local/genome/packages/python2/2.7.6/bin/python

# Import modules for CGI handling 
import cgi, cgitb; cgitb.enable()
import os 
from Bio.Blast.Applications import *
import time 
import datetime
import Format_Blast_Results as FM
import Format_Blast_Alignment_Results as FMA
import subprocess
import Seq_Length as SL
import Execute_R as ER
import re
import pickle 

# Name the input files according to current time
DT = datetime.datetime.now().strftime('%Y-%m-%d-%H-%M-%S')
Fname = "Query_Seq/"+ DT + ".fasta"

# Create instance of FieldStorage
form = cgi.FieldStorage()

#############################################################################################
# START OF HTML PART 
#############################################################################################
print "Content-type:text/html\r\n\r\n"
print "<html>"
print "<head>"
print "<title>Salmon BLAST search</title>"
print "</head>"
print "<body>"

############################################################################################
# Get data from fields
############################################################################################
if form.getvalue('query_seq'):
   query_seq = form.getvalue('query_seq')
   qfile = open(Fname,"wb")
   qfile.write(query_seq)
   qfile.close()
else:
   # Check for upload file 
   uploaded_file = form['qfile']
   if uploaded_file.file:
        qfile = open(Fname,"w")
	qfile.write(uploaded_file.file.read())
	qfile.close()


# Output format
output_format = form.getvalue('output_format')

# Get the E Value
e_value = form.getvalue('evalue')

# Calculate the length of input seq
qseq_length = SL.find_length(Fname)

# Output format
#output_format = form.getvalue('output_format')
#print output_format

# Choose Database 
database_chosen = form.getvalue('DB')
if database_chosen == "SG3p6":
	database = "/var/www/cgi-bin/Salmon_3p6_Blast_DB/Salmon_3p6_Masked_220514.fasta"
else:
	database = "/var/www/cgi-bin/Salmon_3p6_Chr_Blast_DB/Salmon_3p6_Chr_Masked_180814.fasta"


#BLAST OUTPUT FILE
OutFile = "Blast_Output/" + DT + ".out"
   
# Choose BLAST Program
# For some reasons Megablast and other blast exe are in different bin folders
blast_chosen = form.getvalue('blast') 
if blast_chosen == "megablast":
	#BLAST = "/local/genome/packages/blast/2.2.16/bin/megablast"
        BLAST = "/local/genome/packages/blast+/2.2.28/bin/blastn" 
        #Mega_BLAST  = NcbiblastnCommandline(cmd=BLAST,task="megablast", query=Fname, db="/var/www/cgi-bin/Salmon_3p6_Blast_DB/Salmon_3p6_Masked_220514.fasta", evalue=e_value, outfmt=output_format, out=OutFile)
	Mega_BLAST  = NcbiblastnCommandline(cmd=BLAST,task="megablast", query=Fname, db=database, evalue=e_value, outfmt=output_format, out=OutFile)
else:
	BLAST = "/local/genome/packages/blast+/2.2.28/bin/" + blast_chosen
	#Mega_BLAST  = NcbiblastnCommandline(cmd=BLAST, query=Fname, db="/var/www/cgi-bin/Salmon_3p6_Blast_DB/Salmon_3p6_Masked_220514.fasta", evalue=e_value, outfmt=output_format, out=OutFile)
	Mega_BLAST  = NcbiblastnCommandline(cmd=BLAST, query=Fname, db=database, evalue=e_value, outfmt=output_format, out=OutFile)

# Get the E Value 
#e_value = form.getvalue('evalue')

#BLAST OUTPUT FILE
#OutFile = "Blast_Output/" + DT + ".out"

###############################################################################################
# Run blastn using Biopython
###############################################################################################
#Mega_BLAST  = NcbiblastnCommandline(cmd=BLAST, query=Fname, db="/var/www/cgi-bin/Test_DB/Salmon_3p6_Masked.fasta", evalue=e_value, outfmt=6, out=OutFile)

#print Mega_BLAST

stdout, stderr = Mega_BLAST()

# Reading the BLAST OUTPUT file
d = open(OutFile,"r")
data = d.readlines()
d.close()

################################################################################################
# Formatting the BLAST Output File
################################################################################################
#Formatted_out = "BLAST_Output_Formatted/" + DT 
# This is for Table output
if int(output_format) == 6:
	FM.main_main(OutFile,DT,qseq_length)
else:	
	# This one deals with Alignment output format
	# This will dump a .p file that we can use later 
	FMA.main_main(OutFile,DT,qseq_length) 
	# Input file for GBRWOSE link in BLAST Alignment result view
	Fname =  "/var/www/cgi-bin/Blast_Output/" + DT + ".out.p"
	# Loading the pickle file which contains genome co-ordinates
	# for GBrowse
	BA_RANGE = pickle.load(open( Fname, "rb" ))

R_input_file = "BLAST_Output_Formatted/"  + DT + "_Formatted.txt"

# Input file for GBRWOSE link in BLAST Alignment result view 
#Fname =  "/var/www/cgi-bin/Blast_Output/" + DT + ".out.p"

# Loading the pickle file which contains genome co-ordinates 
# for GBrowse
# BA_RANGE = pickle.load(open( Fname, "rb" ))

ER.run_execute_R(R_input_file,DT,qseq_length)

summary_image =   "BLAST_Summary_Images/" + DT + ".png"


#############################################################################################
# START OF HTML PART
#############################################################################################
#print "Content-type:text/html\r\n\r\n"
#print "<html>"
#print "<head>"
#print "<title>Salmon BLAST search</title>"
#print "</head>"
#print "<body>"


#################################################################################################
# MAIN DIV
#################################################################################################
print "<div align=center>"

print "<div id=\"headerdiv\">"
print "<font id=\"SB\" color=\"blue\" style=\"font-size:80px\">S a l m o B a s e</font>"
print "</div>"

# Header 
print "<div id=\"header\" align=center style=\"background-color:blue;width:1200px;color:white\">"
print "<h1 style=\"margin-bottom:0\">Salmon BLAST search results</h1>"
print "</div>"

##################################################################################################
# BLAST SUMMARY IMAGE 
##################################################################################################
print "<div id=BLAST_SUMMARY>"
#data_uri = open('BLAST_images/BLAST_SUMMARY.png', 'rb').read().encode('base64').replace('\n', '')
#data_uri = open(summary_image, 'rb').read().encode('base64').replace('\n', '')
MM = 0
try:
	data_uri = open(summary_image, 'rb').read().encode('base64').replace('\n', '')
	img_tag = '<img src="data:image/png;base64,{0}">'.format(data_uri)
	print img_tag
except: 
	print "<h2>No Significant matches found.</h2>"
	MM = 1
#print "<img src=\"/BLAST_images/BLAST_SUMMARY.png\" style=\"height:600px;width:600px;margin-top:20px;\" />"
print "</div>"

#####################################################################################################
# Start of result table 
#####################################################################################################
# If table format is selected  
if int(output_format) == 6:
	print "<table style=\"width:1200px;text-align:left;margin-top:20px;border:1px solid\">"
	if MM == 0:
		print "<tr bgcolor=\"#7ACDEB\">"
		print "<th> Query </th>"
		print "<th> Subject </th>"
		print "<th> Identity </th>" 
		print "<th> Length </th>" 
		print "<th> Mismatches </th>" 
		print "<th> Gaps</th>" 
		print "<th> QStart </th>"
		print "<th> QEnd </th>" 
		print "<th> SStart </th>" 
		print "<th> SEnd </th>" 
		print "<th> Score </th>"
		print "<th> E-Value </th>"
		print "<th> GBrowse View </th>"
		print "</tr>"

	for i in data:
        	temp = i.split()
	        GBrowse = "http://128.39.175.239/cgi-bin/gb2/gbrowse/salmon_GBrowse/?name=" + temp[1] + ":" + str(int(temp[8]) - 5000) + ".." + str(int(temp[9].strip()) + 5000) + ";h_region=" + temp[1] + ":" + str(temp[8]) + ".." + str(temp[9].strip()) + ";"

        	print "<tr>"
        	print "<td> %s </td>" %temp[0]
        	print "<td> %s </td>" %temp[1] 
        	print "<td> %s </td>" %temp[2]
        	print "<td> %s </td>" %temp[3]
        	print "<td> %s </td>" %temp[4]
        	print "<td> %s </td>" %temp[5]
        	print "<td> %s </td>" %temp[6]
        	print "<td> %s </td>" %temp[7]
        	print "<td> %s </td>" %temp[8]
        	print "<td> %s </td>" %temp[9]
		print "<td> %s </td>" %temp[11]
		print "<td> %s </td>" %temp[10]
		print "<td> <a href= %s target=\"_blank\"" %GBrowse
		print  ">"
		print "GBrowse View </a>" 
		print "</td>" 
        	print "</tr>"

	# End of Table
	print "</table>"
# END OF IF
# If alignment format is selected 
else:   
	#print "<div style=\"width:800px;text-align:left;border:1px solid\">"
        N = 0; M = 0;NSeq = 0; MM = 0 
	for i in data:

		# End of BLAST Summary results	
                if re.search("> ",i):
                        print "</table>"
                        M = 1 
			NSeq += 1

		if NSeq == 1 and MM == 0:
			# Open a div after the ">" symbol: Outer div 
                        print "<div style=\"width:900px;text-align:left;margin-top:10px;border:1px solid\">"
			# Inner Div 
			print "<div style=\"width:860px;margin-top:20px;margin-left:10px;margin-right:20px;\">"
			MM = 1
		
		if NSeq > 1 and re.search("> ",i):
			# End of outer div
			print "</div>"
			# End of Inner div
			print "</div>"			

			# Beginning of outer div
			print "<div style=\"width:900px;text-align:left;margin-top:10px;border:1px solid\">"
			# Beginning of Inner Div 
			print "<div style=\"width:860px;margin-left:20px;margin-right:20px;margin-top:10px\">"
			
 		# Print the summary results 
		if N != 0 and M == 0:
			temp = i.split()
			if len(temp) > 0:
		                print "<tr>"
        		        print "<td> %s </td>" %temp[0]
                		print "<td> %s </td>" %temp[1]
	                	print "<td> %s </td>" %temp[2]
				print "<tr>"
		
		# Beginning of the Summary results 
		if re.search("Sequences",i):
			 print "<table style=\"width:900px;text-align:left;margin-top:20px;border:1px solid\">"
		         print "<tr bgcolor=\"#7ACDEB\">"
                	 print "<th> Subject </th>"
	                 print "<th> Score </th>"
         	         print "<th> E-value </th>"
                	 print "</tr>"
			 N += 1
                
		if M == 1:
			if re.search(">",i):
				temp = i.split()
				scaf = i.replace("> ","")				
				scaf = scaf.strip()
				t = BA_RANGE[scaf]
				temp = t[0].split("-")
				GBrowse = "http://128.39.175.239/cgi-bin/gb2/gbrowse/salmon_GBrowse/?name=" + scaf + ":" + str(int(temp[0]) - 5000) + ".." + str(int(temp[1].strip()) + 5000) + ";h_region=" + scaf + ":" + str(temp[0]) + ".." + str(temp[1].strip()) + ";"
		                print i,"<br><br><div style=\"margin-left:0px;width:150px;height:30px;border:1px solid;background-color:A3F2FC;text-align:center\"><a href= %s target=\"_blank\"" %GBrowse
                		print  ">"
		                print "<div style=\"margin-top:5px;\">GBrowse View</div> </a> </div>"
				print "<br>"
                                print "<pre>"

			elif re.search("\|",i):
				print i.rstrip()
				
			else:
				print i.strip()
				


print "</pre>"
#subprocess.call(['chmod','777',OutFile])

#print "<p><iframe src= %s  width=200 height=400 frameborder=0 ></iframe></p>" %OutFile
# closing of inner div 
print "</div>"

print "</div>"

#print "<div>"
#print "<p><iframe src= %s  width=200 height=400 frameborder=0 ></iframe></p>" %OutFile
#print "</div>"

print "<FORM style=\"width:200px;height:80px;margin-left:auto;margin-right:auto;margin-top:15px;\">"
print "<button Type=\"button\" value=\"Back\" onClick=\"history.go(-1);return true;\" style=\"width:150px;height:50px;font-size:25px;\">Back</button>"
print "</FORM>"

# End of MAIN DIV
print "</div>"

print "</body>"
print "</html>"
