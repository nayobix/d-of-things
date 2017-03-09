# d-of-Things (Dashboard of Things)

dofThings is Open Source Telemetry system for the Internet of Things.

It:
- Stores data pushed from various devices. Data should be pushed in unified JSON form.
- Reacts on violated predefined thresholds - Alarms (email, xmpp) and Actions (xmpp, scripts, urls)
- Visualize data in different forms (physical elements, lamps, charts etc.)
- Has Editor for creating/changing dashboards 
- Has extended logging for feeds, alarms, actions.

It is not just Web Interface for visualizing the data, but it is platform with API 
for push/pull/execute of data/alarms/actions. 
For details of all supported actions check: Includes/dofthings/classes/DataController.php 

# How it works (check examples/test.sh):

1) You create Feed (Add new Feed - /feeds/new/0)

2) Then automaticaly KeyID is created. Check in /keys
	KeyID defines the permissions (push/pull/execute) of the Feed
	Also it defines from which IP the request should be accepted
	The default created KeyID is with full permissions (push/pull/execute)
	and from all IP addresses

3) After the setup of Feed and KeyID, then you got the URI:

For push:	http[s]://<your-hostname>/dataPush/push/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8

4) How JSON should look like for the POST request

It has 2 types of elements:
-Sensor	-	It is passive element, provides only data like temperature, 
		humidity, door status etc

                {       "FeedID":"4",  
                        "FeedKeyHash":"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8",
                        "deviceName":"device1",
                        "deviceID":1,
                        "objectType": "Sensor",
                        "objectName": "sen3", 
                        "objectAction": "NONE",
                        "objectValue": ${VALUE},
                        "timestamp": ${TS} 
		}


-Method	-	It is active element, provides data about current status
		of the element and action URI

                {       "FeedID":"4",  
                        "FeedKeyHash":"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8",
                        "deviceName":"device1",
                        "deviceID":1,
                        "objectType": "Method",
                        "objectName": "openDoor", 
                        "objectAction": "/dofthings/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/device1/active/openDoor",
                        "objectValue": 0,
                        "timestamp": ${TS} 
		}

5) After the first push, then go to Dashboards tab and create new Dashboard

6) Drag and drop some elements from left (chart, button, control panel)

7) Click the dropped element in the active dashboard field and then click on `Add Feed` button right to attach source to the selected element in dashboard

8) Select the sensor/method of the already push data

9) Click on update button to update the elemnt with the selected feed

10) Now save the dashboard from top left corner. You should see dialog window `Created!`

11) Return to main screen now and click on dashboards, you should see the already created dashboard

[12) Extended logging can be always enabled from edit page of the feed]

[13) Check Alarms tab to see how to create alarm]

!!! Remeber that Alarms will work only if valid smtp/xmpp settings are provided in Admin Settings page

More info:
https://dofthings.org/about

# Installation
  Check install.d/INSTALL

# Demo

  https://dofthings.org

  Username: userd

  Password: userd

  Created dashboard is also shared: https://dofthings.org/dashboards/visualize/60

  !!! Data there is random generated

# Used IDE

Netbeans 8.2 (Check nbproject/)

# License

The MIT License

Copyright 2014-present Boyan Vladinov <nayobix@nayobix.org>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
