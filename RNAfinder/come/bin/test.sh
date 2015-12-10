#!/bin/bash
# Print help message if no parameter given
if [ "$#" == 0 ];then
echo "Usage: ./COME_all.sh input_file output_dir bin_dir species
/path/to/COME/bin/folder/COME_all.sh    /path/to/your/transcripts.gtf    /path/to/your/output    /path/to/COME/bin/folder    model_species_name
/path/to/your/transcripts.gtf is the transcript.gtf file with absolute path
/path/to/your/output is the folder that all the results generated would be saved
/path/to/COME/bin/folder contains our software
model_species_name should be one of these terms: human mouse fly worm plant;
"
exit;
fi
########################	input_parameters
input_file=$1
output_dir=$2
bin_dir=$3
spe=$4

########################	processing
#file=${input_file##*/};
file=${output_dir##*/};


if   [ "$spe"   ==      "human" ];then CUTOFF=0.623;Model=$bin_dir/human.chr.models;	CPL=$bin_dir/human.CPL;
elif [ "$spe"   ==      "mouse" ];then CUTOFF=0.524;Model=$bin_dir/mouse.chr.models;	CPL=$bin_dir/mouse.CPL;
elif [ "$spe"   ==      "worm"  ];then CUTOFF=0.924;Model=$bin_dir/worm.chr.models;	CPL=$bin_dir/worm.CPL;
elif [ "$spe"   ==      "fly"   ];then CUTOFF=0.888;Model=$bin_dir/fly.chr.models;	CPL=$bin_dir/fly.CPL;
elif [ "$spe"   ==      "plant" ];then CUTOFF=0.925;Model=$bin_dir/plant.chr.models;	CPL=$bin_dir/plant.CPL;
else echo "wrong speices specified, only human mouse fly worm plant are avilable now."; exit;
fi


########################	predict coding potential and assign prediction labels
#echo -e "transcriptID\tcoding_potential\tprediction"												>	$output_dir/result;

for i in `seq 1 15`; do
	echo -ne "testID$i\t0.3\tnoncoding\t"  >>      $output_dir/result;
        for j in `seq 1 9`; do
                echo -ne "$j\t"  >>      $output_dir/result;
        done
        echo ""   >>      $output_dir/result;
done

####	clean
#! [[ -d $output_dir/$file ]] || rm -r -f $output_dir/$file;




