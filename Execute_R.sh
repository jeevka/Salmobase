#!/bin/bash

. /etc/profile.d/modules.sh

module load R/3.0.2shlib

Rscript BLAST_SUMMARY.R $1 $2 $3 >>ErrorFromR.txt

