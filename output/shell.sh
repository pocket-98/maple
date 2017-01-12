#!/bin/bash
HOME=/var/www

start="startstartstartstartstart;"
end="endendendendend;"
string=""
for item in $@
do
    string=$string$start$item$end
done
echo $string | /usr/local/bin/cmaple -q -T 15,200000 -t
