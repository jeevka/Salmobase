from subprocess import call

def run_execute_R(file_name,Rout_file_name,qseq_length):
        slength = str(qseq_length)
	call(["sh", "Execute_R.sh",file_name,Rout_file_name,slength])
	
        return 0

#call(["R", "CMD","BATCH", "BLAST_SUMMARY.R"])
