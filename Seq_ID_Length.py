import sys
import re
import pickle

F1 = open(sys.argv[1],"r")
F2 = F1.readlines()

SEQ = {}
raw_seq = ""

for i in F2:    
    if re.search("^>",i) and len(raw_seq) != 0:
        #N_N = raw_seq.count('N')
        SEQ[ID] = len(raw_seq) #- N_N
            
    if re.search("^>",i):
        temp = re.split(">",i)
        #temp1 = re.split(" ",temp[1])
        #temp2 = re.split("\|",temp1[0])
        ID = temp[1].strip()
        raw_seq = ""
            
    if not re.search("^>",i):
        raw_seq += i.strip()

SEQ[ID] = len(raw_seq)

#for i in SEQ:
#    print i,"\t",SEQ[i]
        
pickle.dump(SEQ,open("Salmon_3p6_Seq_Length.p","wp"))