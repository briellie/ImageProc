#!/bin/bash

. ./config.txt

echo -e "eBay Image Processor - Version ${PROG_VERSION}\n\n"
echo -n "Please enter current date: "
read CURRDATE
#CURRDATE="030413"

echo "Beginning rename..."
${BINLOC}/find ${RAWLOC} -iname '*.jpg' |\
	${BINLOC}/gawk -v resizeloc=${RESIZELOC} -v currdate=${CURRDATE} -v startnum=${STARTNUM} -v binloc=${BINLOC} 'BEGIN{ a=startnum }{ printf "%s/cp -f \"%s\" \"%s/%s_%04d.jpg\"\n", binloc,$0,resizeloc,currdate,a++ }' \
	| ${BINLOC}/bash
	
#echo "Copying..."
#${BINLOC}/cp -f ${RENAMELOC}/* ${RESIZELOC}/
echo "Resizing..."
time ${BINLOC}/${GM_VERSION}/gm mogrify -resize ${IMG_RESIZE} -quality ${IMG_QUALITY} ${IMG_OPTIONS} ${RESIZELOC}/*.jpg

echo "Done!"
echo "Press enter to close."
read DUMMYVAR