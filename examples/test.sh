#!/bin/bash

if [ $# -le 0 ]; then 
	echo "Test disabled! Edit to enable" && exit 0;
fi

URL="https://dofthings.org/dataPush/push/8/cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e"
ACTION_URL="/dofthings/8/cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e/esp8266/active/lampOn"
ACTION_URL2="/dofthings/8/cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e/esp8266/active/doorOpen"
SENSORS_VALUE=`shuf -i 20-26 -n 1` # Temperature
METHODS_VALUE=`shuf -i 0-1 -n 1` # Lamp
SENSORS_VALUE2=`shuf -i 40-45 -n 1` # Humidity
METHODS_VALUE2=`shuf -i 0-1 -n 1` # Door
USERNAME=""
PASSWORD=""

echo "TEST";

TS=`date +%s`

VALUE=`date +%S`
JSON_SENSORS=`cat <<EOF
		{	"FeedID":"8",  
			"FeedKeyHash":"cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e",
        	        "deviceName":"esp8266",
	                "deviceID":1,
		        "objectType": "Sensor",
			"objectName": "temperatureBedroom", 
			"objectAction": "NONE",
			"objectValue": $SENSORS_VALUE,
			"timestamp": ${TS} }
EOF
`

JSON_SENSORS2=`cat <<EOF
		{	"FeedID":"8",  
			"FeedKeyHash":"cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e",
        	        "deviceName":"esp8266",
	                "deviceID":1,
		        "objectType": "Sensor",
			"objectName": "humidity", 
			"objectAction": "NONE",
			"objectValue": $SENSORS_VALUE2,
			"timestamp": ${TS} }
EOF
`

VALUE=`date +%S`
JSON_METHODS=`cat <<EOF
		{	"FeedID":"8",  
			"FeedKeyHash":"cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e",
        	        "deviceName":"esp8266",
	                "deviceID":1,
		        "objectType": "Method",
			"objectName": "lampOn", 
			"objectAction": "$ACTION_URL",
			"objectValue": $METHODS_VALUE,
			"timestamp": ${TS} }
EOF
`
VALUE=`date +%S`
JSON_METHODS2=`cat <<EOF
		{	"FeedID":"8",  
			"FeedKeyHash":"cfea32669610a287340b0d8997bcaafc3f816440d821d00c103ef097b214277e",
        	        "deviceName":"esp8266",
	                "deviceID":1,
		        "objectType": "Method",
			"objectName": "doorOpen", 
			"objectAction": "$ACTION_URL",
			"objectValue": $METHODS_VALUE,
			"timestamp": ${TS} }
EOF
`

#Sensors update
/usr/bin/wget	--header=Content-Type:application/json \
	--http-user="$USERNAME" --http-password="$PASSWORD" \
	--post-data "${JSON_SENSORS}" \
	"$URL" \
       	-O -

sleep 1;

/usr/bin/wget	--header=Content-Type:application/json \
	--http-user="$USERNAME" --http-password="$PASSWORD" \
	--post-data "${JSON_SENSORS2}" \
	"$URL" \
       	-O -


sleep 1;

#Methods update
/usr/bin/wget	--header=Content-Type:application/json \
	--http-user="$USERNAME" --http-password="$PASSWORD" \
	--post-data "${JSON_METHODS}" \
	"$URL" \
       	-O -

sleep 1;

#Methods update
/usr/bin/wget	--header=Content-Type:application/json \
	--http-user="$USERNAME" --http-password="$PASSWORD" \
	--post-data "${JSON_METHODS2}" \
	"$URL" \
       	-O -
