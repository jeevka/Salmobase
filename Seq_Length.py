import sys
import re

def find_length(file_name):
    F1 = open(file_name,"r")
    F2 = F1.readlines()
    
    SEQ = {}
    raw_seq = ""
    
    for i in F2:
        #if re.search("^>",i): # and len(raw_seq) != 0:
            #N_N = raw_seq.count('N')
        #    SEQ[ID] = len(raw_seq) #- N_N
    
        if re.search("^>",i):
            temp = re.split(">",i)
            #temp1 = re.split(" ",temp[1])
            #temp2 = re.split("\|",temp1[0])
            ID = temp[1].strip()
            raw_seq = ""
    
        if not re.search("^>",i):
            raw_seq += i.strip()

    return len(raw_seq)
