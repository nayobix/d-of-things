// Create a client instance
var randomnumber = Math.floor(Math.random() * 123456);
var mClientMQTT = new Paho.MQTT.Client(location.hostname, Number("1885"), "browser"+randomnumber);
var topic = "";
var systemName = "/dofthings";
var alltopics = [];
var mqttUser = "userro";
var mqttPasswd = "";
var connectOptions = {};
var runIntervalFunc;
var runIntervalTimeMs = 2000;
var runIntervalCount = 0;
var runIntervalCountMax = 5;

function mqttConnect() {
    runIntervalCount++;
    connectOptions = {onSuccess:onConnect, userName: "userro", password: "", useSSL: true};
    // set callback handlers
    mClientMQTT.onConnectionLost = onConnectionLost;
    mClientMQTT.onMessageArrived = onMessageArrived;

    // connect the client
    mClientMQTT.connect(connectOptions);
}

// called when the client connects
function onConnect() {
    // Once a connection has been made, make a subscription and send a message.
        runIntervalFunc = window.setInterval(function(){
                mqttSubscribe();
        }, 2000);
}

// subscribe to all topics
function mqttSubscribe() {
    console.log("mqttSubscribe. Try:: "+runIntervalCount);
    clearInterval(runIntervalFunc);
    if (runIntervalCount < runIntervalCountMax) {
        runIntervalFunc = window.setInterval(function(){
            mqttSubscribe();
        }, runIntervalTimeMs);
    }
    runIntervalCount++;

    for (idx = 0; idx < device_elements.length; idx++) {
        console.log("onConnect idx: "+idx);
        if (device_elements[idx].dataset == null)
            continue;

        topic = systemName + "/" + device_elements[idx].dataset.FeedID;
        topic = topic + "/" + device_elements[idx].dataset.FeedKeyHash;
        topic = topic + "/" + device_elements[idx].dataset.deviceName;
        topic = topic + "/active/result";
        if (alltopics.indexOf(topic) === -1) {
            console.log("Topic: "+topic);
            mClientMQTT.subscribe(topic, {qos: 0});
            alltopics.push(topic);
        }
    }

}

// called when the client loses its connection
function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
      console.log("onConnectionLost:"+responseObject.errorMessage);
      // reconnect after 1 second
      console.log("Reconnecting...");
      setTimeout(mClientMQTT.connect(connectOptions), 1000);
  }
}

// called when a message arrives
function onMessageArrived(message) {
    console.log("onMessageArrived:"+message.payloadString);
    json = JSON.parse(message.payloadString);
    for (idx = 0; idx < device_elements.length; idx++) {
        if (device_elements[idx].dataset.FeedID == json.FeedID && 
                device_elements[idx].dataset.FeedKeyHash == json.FeedKeyHash &&
                device_elements[idx].dataset.deviceName == json.deviceName &&
                device_elements[idx].dataset.objectName == json.objectName &&
                device_elements[idx].dataset.objectValue != json.objectValue) {

                switchClassesAccordingToValue(device_elements[idx].placeholder,
                device_elements[idx].class_base+"_"+device_elements[idx].class_on,
                device_elements[idx].class_base+"_"+device_elements[idx].class_off,
                json.objectValue,
                device_elements[idx].dataset.objectValue
                );

                device_elements[idx].dataset.objectValue = json.objectValue;
        }
    }
}

// send message to topic
function sendMqttMsg(topic, msg) {
    message = new Paho.MQTT.Message(msg);
    message.destinationName = topic;
    mClientMQTT.send(message);
}
