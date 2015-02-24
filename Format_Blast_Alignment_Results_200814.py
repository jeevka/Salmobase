from __future__ import division
import sys
import re
import numpy as np
import operator
import pickle

#################################################################
#################### SUB PROGRAMS ###############################
#################################################################
def store_range(RANGE,scaf,qrange,N):
	if RANGE.has_key(scaf):
		RANGE[scaf][N] = qrange  
	else:
		RANGE[scaf] = {1: qrange}
	
	return RANGE

def store_Identity(IDN,scaf,IDN_temp,N):
	if IDN.has_key(scaf):
		IDN[scaf][N] = IDN_temp  
	else:
		IDN[scaf] = {1: IDN_temp}
	
	return IDN


def store_score(score,TScore,scaf):
	if TScore.has_key(scaf):
		TScore[scaf] += float(score)
	else:
		TScore[scaf] = float(score)
	
	return TScore

def update_coverage(Range,SCAF,RL,COV):
	HITS = []
	for i in Range:
		temp1 = Range[i].split("-")
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
        G = "<=80%"
    
    return G
	
##################################################################
##################### MAIN PROGRAM ###############################
##################################################################
def main_main(File_name,infile):
	# GO TO THE MAIN DATA
	COV = {}; IDN = {}; RANGE = {}
	Sub_RANGE = {}
	
	output_file = "BLAST_Output_Formatted/"  + infile + "_Formatted.txt"
	
	M = 0;NExpect = 0
	FQ = 0; FS = 0
	Score_In = 0
	NSeq = 0
	NQuery = 0
	NIdn = 0
	TScore = {}
	NScore = 0
	NL = 0
	# BLAST OUTPUT FILES
	with open(File_name) as infile:
		for i in infile:
			
			# Storing the length of query
			if re.search("Length=",i) and NL == 0:
				RL = i.split("=")[1]
				NL = 1
			
			# First Sequence 
			if re.search(">",i):
				NSeq += 1
				
				# When we reach second sequence we need to store the results again.
				if NSeq > 1:
					# In case if + or - strand
					if int(QStart) < int(QEnd):
						qrange = str(QStart) + "-" + str(QEnd)
					else:
						qrange = str(QEnd) + "-" + str(QStart)
					
					# Increase the NIdn to store the last result.
					NIdn += 1
					
					# Storing the ranges of the Query match
					RANGE = store_range(RANGE,scaf,qrange,NIdn-1)
					
					# storing Identities
					IDN = store_Identity(IDN,scaf,IDN_temp,NIdn-1)
				
				temp = i.split()
				scaf = i.replace("> ","")				
				scaf = scaf.strip()
				
				NIdn = 0
				NQuery = 0
				NScore = 0
			# Storing the Score to order the results.
			if re.search("Score =",i) and NScore == 0:
				score = i.split()[2]
				TScore = store_score(score,TScore,scaf)
				NScore = 1

			# Catching Identities
			if re.search("Identities",i):
				temp = i.split()
				t1 = temp[3].replace(")","")
				t2 = t1.replace("(","")
				t3 = t2.replace(",","")
				identity = t3.replace("%","")
				mlen = temp[2].split("/")[1]
				
				# Store the identity
				IDN_temp = int(identity)
				NIdn += 1
				NQuery = 0
				
				# Store the first identity
				if NIdn == 1:
					IDN = store_Identity(IDN,scaf,IDN_temp,NIdn)
			
			# Catching the first Query start in a hit
			if re.search("Query ",i) and NQuery == 0:
				QStart = i.split()[1]
				NQuery += 1
			
			# Catching every query end to capture the last query end
			if re.search("Query ",i):
				QEnd = i.split()[3]
			
			# When we reach Second Identity within a single sequence
			# We need to store the results.
			if re.search("Identities",i) and NIdn > 1:
				
				# In case if + or - strand
				if int(QStart) < int(QEnd):
					qrange = str(QStart) + "-" + str(QEnd)
				else:
					qrange = str(QEnd) + "-" + str(QStart)
				
				# Storing the ranges of the Query match
				RANGE = store_range(RANGE,scaf,qrange,NIdn-1)
				
				# storing Identities
				IDN = store_Identity(IDN,scaf,IDN_temp,NIdn)
				#print IDN
				#sys.exit()
	
	
	# In case if + or - strand
	if int(QStart) < int(QEnd):
		qrange = str(QStart) + "-" + str(QEnd)
	else:
		qrange = str(QEnd) + "-" + str(QStart)
				
	# Storing the ranges of the Query match
	RANGE = store_range(RANGE,scaf,qrange,NIdn-1)
				
	# storing Identities
	IDN = store_Identity(IDN,scaf,IDN_temp,NIdn)
		
	# COV and TQC are similar data with similar structure
	COV = fix_overlapping_cov(RANGE,RL)
	
	sorted_score = sorted(TScore, key=TScore.get)

	#sorted_cov = sorted(COV, key=COV.get)
	
	FILE = open(output_file,"w")
	
	if len(sorted_score) >= 5:
	   N = 5
	else: 
	   N = len(sorted_score) 
	M1 = 0
	for i in xrange(len(sorted_score)-1,len(sorted_score)-N-1,-1): 
	    	ID = sorted_score[i]
	    	M = 1
	    	for j in RANGE[ID]:
			temp = RANGE[ID][j].split("-")
			IDN_G = choose_idn_group(IDN[ID][M])
			txt1 = str(N) + "\t" + str(M1) + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[0]) + "\n"
			txt2 = str(N) + "\t" + str(M1) + "\t" + ID + "\t" + str(IDN[ID][M]) + "\t" + str(IDN_G) + "\t" + str(temp[1]) + "\n"
			#print txt1.strip()
			#print txt2.strip()
			FILE.write(txt1)
			FILE.write(txt2)
		
			M += 1
                        M1 += 1
	    	N -= 1
		
           
        #sys.exit()
	FILE.close()
	fname = File_name + ".p"
	pickle.dump(RANGE, open(fname, "wb" ) )

# Input File
#File_name = sys.argv[1]

# Output File
#output_file = File_name + "_formatted.txt"

# Call the main program
#main_main(File_name,output_file)
