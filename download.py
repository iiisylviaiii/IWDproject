from Bio import Entrez
import argparse

Entrez.email = "s2685732@ed.ac.uk"

# Get input information
parser = argparse.ArgumentParser()
parser.add_argument("pfamily", help="Protein Family Name")
parser.add_argument("tgroup",help="Taxonomic Group")
parser.add_argument("--nseq", type=int, help="Number of sequences to fetch", default=None)
args = parser.parse_args()

# Get ID
query = f"{args.pfamily}[protein] AND {args.tgroup}[ORGN]"
handle = Entrez.esearch(db="protein",term=query)
record = Entrez.read(handle)
handle.close()

# Download data
id_list = record["IdList"]
if id_list:
    if args.nseq: 
        handle2 = Entrez.efetch(db="protein",id=id_list,rettype="fasta",retmode="text",retmax=args.nseq)
    else:
        handle2 = Entrez.efetch(db="protein",id=id_list,rettype="fasta",retmode="text")
    record2 = handle2.read()
    handle2.close()
    print(record2)
else:
    print(0)
