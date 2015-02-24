from __future__ import division
import sys
import re
import numpy as np
import operator
import pickle

#################################################################
#################### SUB PROGRAMS ###############################
#################################################################
def store_results_1(IDN,scaf,IDN_temp):
	if IDN.has_key(scaf):
		IDN[scaf].append(IDN_temp)
	else:
		IDN[scaf] = [IDN_temp]
	
	return IDN
	

def update_coverage(Range,SCAF,RL,COV):
	dis = 0
	OL = 0
	HITS = []
        
	for i in xrange(len(Range)):
		temp1 = Range[i].split("-")

		###########################################
		# Length of the hit must be >=100 basepairs
		###########################################

		if int(temp1[1]) > int(temp1[0]):
			HITS = HITS + range(int(temp1[0]),int(temp1[1]))
		else:
			HITS = HITS + range(int(temp1[1]),int(temp1[0]))

	HITS1 = list(set(HITS))
	HITS1.sort()
	l2 = len(HITS1)
        COV[SCAF] = l2/int(RL)
        
        return COV


def fix_overlapping_cov(RANGE,RL):
    COV = {}
    
    for i in RANGE:
        COV = update_coverage(RANGE[i],i,RL,COV)
        
    return COV

def choose_idn_group(IDN):
    if IDN >= 98:
        G = ">=98%"
    elif IDN >=95 and IDN < 98:
        G = "95-98%"
    elif IDN >90 and IDN < 95:
        G = "91-94%"
    elif IDN >=81 and IDN <=90:
        G = "81-90%"
    else:
        G = "<80%"
    
    return G
	
##################################################################
##################### MAIN PROGRAM ###############################
##################################################################
def main_main(File_name,infile,qlength):
	# GO TO THE MAIN DATA
	COV = {}; IDN = {}; RANGE = {}
	Sub_RANGE = {}
	
	RL = qlength
	
	output_file = "BLAST_Output_Formatted/"  + infile + "_Formatted.txt"
	
	M = 0;NExpect = 0
	FQ = 0; FS = 0
	# BLAST OUTPUT FILES
	with open(File_name) as infile:
		for i in infile:
			
			# Second seq results  
			if re.search("> ",i) and M == 1:
				#IDN[scaf] = np.mean(IDN_temp)
				#COV[scaf] = np.mean(COV_temp)
				qrange = str(QStart) + "-" + str(QEnd)
				srange = str(SStart) + "-" + str(SEnd)
				
				# Storing the Identities 
				IDN = store_results_1(IDN,scaf,IDN_temp)
				
				# Storing the ranges of the Query match
				RANGE = store_results_1(RANGE,scaf,qrange)
				
				# Storing the ranges of the Subject match
				Sub_RANGE = store_results_1(Sub_RANGE,scaf,srange)
				
				FQ = 0
				FS = 0
				temp = i.split()
				scaf = i.replace("> ","")				
				scaf = scaf.strip()
			
			#### TWO HITS WITHIN SAME SCAFFOLD IS NOT CONSIDERED HERE #######
			######## FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX ################
			
			#if re.search("Expect",i) or re.search("> ",i) and NExpect >= 1:
			#	# Storing the ranges of the Subject match
			#	srange = str(SStart) + "-" + str(SEnd)
			#	Sub_RANGE = store_results_1(Sub_RANGE,scaf,srange)				
							
			# First seq results	
			if re.search(">",i) and M == 0:
				temp = i.split()
				scaf = i.replace("> ","")
				scaf = scaf.strip()
				M = 1
				
			if re.search("Expect",i):
				temp = i.split()
				evalue = temp[7]
				NExpect += 1
				
			if re.search("Identities",i):
				temp = i.split()
				t1 = temp[3].replace(")","")
				t2 = t1.replace("(","")
				t3 = t2.replace(",","")
				identity = t3.replace("%","")
				mlen = temp[2].split("/")[1]
				
				# Store the identity
				IDN_temp = int(identity)	
			
			# Start and end of of every query and 
			if re.search("Query ",i) and FQ == 0:
				QStart = i.split()[1]
				FQ = 1

			if re.search("Query ",i):
				QEnd = i.split()[3]
				
			# Start and end of of every query and 
			if re.search("Sbjct ",i) and FS == 0:
				SStart = i.split()[1]
				FS = 1

			if re.search("Sbjct ",i):
				SEnd = i.split()[3]
				
				
	qrange = str(QStart) + "-" + str(QEnd)
	IDN = store_results_1(IDN,scaf,IDN_temp)
	RANGE = store_results_1(RANGE,scaf,qrange)
	
	srange = str(QStart) + "-" + str(QEnd)
	Sub_RANGE = store_results_1(Sub_RANGE,scaf,srange)
	
	# COV and TQC are similar data with similar structure
	COV = fix_overlapping_cov(RANGE,RL)
	
	
	sorted_cov = sorted(COV, key=COV.get)
	
	FILE = open(output_file,"w")
	
	if len(sorted_cov) >=5:
	   N = 5
	else: 
	   N = len(sorted_cov) 

	for i in xrange(len(sorted_cov)-1,len(sorted_cov)-N,-1):
	    try:
	    	ID = sorted_cov[i]
	    	M = 0
	    	for j in RANGE[ID]:
			temp = j.split("-")
			IDN_G = choose_idn_group(IDN[ID][M])
			txt1 = str(N)  + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[0]) + "\n"
			txt2 = str(N)  + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[1]) + "\n"
			#print txt1.strip()
			#print txt2.strip()
			#sys.exit()
			FILE.write(txt1)
			FILE.write(txt2)
		
			M += 1
	    	N -= 1
            except: 
                break 


	FILE.close()
	fname = File_name + ".p"
	pickle.dump(Sub_RANGE, open(fname, "wb" ) )

# Input File
#File_name = sys.argv[1]

# Output File
#output_file = File_name + "_formatted.txt"

# Call the main program
#main_main(File_name,output_file,1181)
