#!/usr/bin/env perl 

use Bio::DB::SeqFeature::Store;
#use Bio::DB::Sam;

#my $sam = Bio::DB::Sam::Fai->new(-fasta=>"/Genome_Seq/Sally_Seq_Exon_Feature.fasta");

my $dsn = "salmon:192.168.168.205";

# Open the sequence database
my $db = Bio::DB::SeqFeature::Store->new(-adaptor => 'DBI::mysql',
                                          -dsn     => $dsn,
                                          -user    => 'jeevka',
                                          -pass    => 'gbrowse01ok');

# Input from Gbrowse
$seqid = $ARGV[0];
$start = $ARGV[1];
$end   = $ARGV[2];
$type  = $ARGV[3];
$gname = $ARGV[4];

#################################################################################
# Download the whole gene region 
#################################################################################
if ($type == 1)
{
 $seq = $db->fetch_sequence($seqid,$start,$end);
 print ">",$seqid,"_",$start,"_",$end,"\n";
 print $seq;
}

################################################################################
# Downlod the exon sequences 
################################################################################
if ($type == 2)
{
#@foo = $db->features(-seq_id =>$seqid,-start=>$start,-end=>$end, -type => 'exon',-attribute => 1);
#print ">",$seqid,"_",$start,"_",$end,"_",$gname,"\n";

#	for my $f(@foo){
#            print "Hello:",$f,"\n";
	    #print ">",$f->seq_id,"_",$f->start,"_",$f->end,"_",$f->ref,"\n";
	    #print $f->dna,"\n"; 

# Tophat and Samtools solution for Coding region download 
# Coding seqs are stored in "/var/www/Genome_Seq/" folder 
# after processed in "Seq_Download_Test" folder

$seq = `samtools faidx  /var/www/Genome_Seq/Sally_Seq_Exon_Feature.fasta $gname >&1`; 

print $seq; 

#system("Run_Samtools.sh"); 

#$dna = $sam->seq($gname);
#print $dna;

}
