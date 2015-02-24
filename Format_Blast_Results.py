from __future__ import division
import sys
import re
import numpy as np
import operator

#################################################################
#################### SUB PROGRAMS ###############################
#################################################################
def store_results_1(data,temp,RL):
	try:
		Cov = float(temp[4])/RL
	except:
		Cov = float(temp[4])/RL

	if data.has_key(temp[0]):
		if data[temp[0]].has_key(temp[1]):
			data[temp[0]][temp[1]] +=  Cov
		else:
			data[temp[0]][temp[1]] =  Cov
	else:
		data[temp[0]] = {}
		data[temp[0]][temp[1]] =  Cov

	return data

def store_results_2(data,temp):
	if data.has_key(temp[1]):
	    data[temp[1]].append(float(temp[2]))
	else:
	    data[temp[1]] =  [float(temp[2])]

	return data

def store_results_3(data,temp):

	if data.has_key(temp[1]):
		data[temp[1]].append(str(temp[6]) + "-" + str(temp[7]))
	else:
		data[temp[1]] =  [str(temp[6]) + "-" + str(temp[7])]

	return data


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
	
	RL = qlength
	
	output_file = "BLAST_Output_Formatted/"  + infile + "_Formatted.txt"
	
	# BLAST OUTPUT FILES
	with open(File_name) as infile:
		for i in infile:
			temp = i.split()
	
			# STORE QUERY LENGTH
			#RL[temp[0]] = int(temp[13].strip())
	
			# Store COV
			COV = store_results_1(COV,temp,RL)
	
			# STORE IDN
			IDN = store_results_2(IDN,temp)
	
			# STORE RANGES
			RANGE = store_results_3(RANGE,temp)
	
	# COV and TQC are similar data with similar structure
	COV = fix_overlapping_cov(RANGE,RL)
	
	#sorted_cov = sorted(COV.iteritems(), key=operator.itemgetter(1))
	
	sorted_cov = sorted(COV, key=COV.get)
	
	FILE = open(output_file,"w")
	if len(sorted_cov) >=5:
	   N = 5
	else: 
	   N = len(sorted_cov) 
	M1 = 0
	for i in xrange(len(sorted_cov)-1,len(sorted_cov)-N,-1):
	    try:
	    	ID = sorted_cov[i]
	    	M = 0
	    	for j in RANGE[ID]:
			temp = j.split("-")
			IDN_G = choose_idn_group(IDN[ID][M])
			txt1 = str(N) + "\t" + str(M1) + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[0]) + "\n"
			txt2 = str(N) + "\t" + str(M1) + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[1]) + "\n"
			FILE.write(txt1)
			FILE.write(txt2)
		
			M += 1
			M1 += 1 
	    	N -= 1
		#FILE.close()
            except: 
                break 


	FILE.close()
# Input File
#File_name = sys.argv[1]

# Output File
#output_file = File_name + "_formatted.txt"

# Call the main program
#main_main(File_name,output_file)
