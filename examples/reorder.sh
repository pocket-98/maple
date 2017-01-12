#!/bin/bash

s=1

for i in $(ls *txt); do
	num=$(echo $i | cut -d"." -f1)
	file=$(echo $i | sed "s/$num.//g")
	num=$(echo $num | sed 's/^0*//g')
	((num = num + s))
	if [ $num -lt 10 ]; then
		num="0$num"
	fi
	echo "mv" "$i" "$num.$file"
	#mv "$i" "$num.$file"
done

