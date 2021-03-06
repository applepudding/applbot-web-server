/*
 * Check for browser support
 */
var supportMsg = document.getElementById('webspeech_status');

if ('speechSynthesis' in window) {
	supportMsg.classList.add('active');
} else {	
	supportMsg.classList.add('nonactive');
}



$(document).ready(function () {
    var synth = window.speechSynthesis;
    
    var voiceSelect = document.querySelector('#input_voice');
    var volumeInput = document.querySelector('#input_volume');
    var mainEvent = document.querySelector('#display_eventMain');
    var mainTimer = document.querySelector('#display_eventTimer');
    var subEvent = document.querySelector('#display_eventSub');
    var delay = document.querySelector('#input_delay');
    var voices = [];    
    var seconds;

    var currentChannel = $('#current_channel').html();
    var myName = localStorage.getItem("applbot-my-name");
    $("#input_myName").val(myName);

    if ( currentChannel == 0)
    {
        $('#main_display').hide();
        $('#main_channel').show();
    }
    else
    {
        $('#main_display').show();
        $('#main_channel').hide();
    }

    $( "#btn_join" ).click(function(event) {    
        event.preventDefault();
        window.location.href = $('#input_channel').val(); 
    });
    $("#btn_home").click(function() {   
        if (currentChannel > 0)
        {
            window.location.href = "/applbot";
        }          
    });
    $("#input_myName").change(function() {
        localStorage.setItem("applbot-my-name", $("#input_myName").val());
        myName = $("#input_myName").val();
    });
/*
    function populateVoiceList() {
        voices = synth.getVoices();
        var selectedIndex = voiceSelect.selectedIndex < 0 ? 0 : voiceSelect.selectedIndex;
        voiceSelect.innerHTML = '';
        for(i = 0; i < voices.length ; i++) {
            var option = document.createElement('option');
            option.textContent = voices[i].name + ' (' + voices[i].lang + ')';
            if(voices[i].default) {
            option.textContent += ' -- DEFAULT';
            }

            option.setAttribute('data-lang', voices[i].lang);
            option.setAttribute('data-name', voices[i].name);
            voiceSelect.appendChild(option);
        }
        voiceSelect.selectedIndex = selectedIndex;
    }
    populateVoiceList();
    if (speechSynthesis.onvoiceschanged !== undefined) {
        speechSynthesis.onvoiceschanged = populateVoiceList;
    }
*/
    // Fetch the list of voices and populate the voice options.
    function loadVoices() {
    // Fetch the available voices.
        var voices = speechSynthesis.getVoices();
    
    // Loop through each of the voices.
        voices.forEach(function(voice, i) {
        // Create a new option element.
            var option = document.createElement('option');
        
        // Set the options value and text.
            option.value = voice.name;
            option.innerHTML = voice.name;
            
        // Add the option to the voice selector.
            voiceSelect.appendChild(option);
        });
    }

    // Execute loadVoices.
    loadVoices();

    // Chrome loads voices asynchronously.
    window.speechSynthesis.onvoiceschanged = function(e) {
    loadVoices();
    };


    // Create a new utterance for the specified text and add it to
    // the queue.
    function speak(text) {
        window.speechSynthesis.cancel();
    // Create a new instance of SpeechSynthesisUtterance.
        var msg = new SpeechSynthesisUtterance();
    
    // Set the text.
        msg.text = text;
    
    // Set the attributes.
        msg.volume = parseFloat(volumeInput.value);
        msg.rate = 1;
        msg.pitch = 1;
    
    // If a voice has been selected, find the voice and set the
    // utterance instance's voice attribute.
        if (voiceSelect.value) {
            msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == voiceSelect.value; })[0];
        }
    
    // Queue this utterance.
        window.speechSynthesis.speak(msg);
    }

    var firstRun = true;
    var data = {};
    data["c"] = currentChannel; //1
    data["id"] = 0;

    if (currentChannel > 0)
    {
        (function worker() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: 'api/get.php', 
                data: data,
                error: ajaxFailure,
                success: sendAjaxSuccess,
                complete: function(){
                        var t = delay.value;
                        setTimeout(worker, t);
                        return;
                    }
            }); 
        })();
    }    
    

    function sendAjaxSuccess(obj) {
        var secondsnow = Math.floor(new Date().getTime() / 1000);
        if (obj["id"] != 0)
        { 
            data["id"] = obj["id"];
            if(firstRun)
            {
                firstRun = false;
            }
            else
            {                
                var toSpeak = obj["msg"];
                var toEventDisplay = obj["event"];
                if (toSpeak != "")
                {
                    toSpeak = personalizedSpeak(toSpeak);
                    
                    if ((toSpeak.toLowerCase() == "left") || (toSpeak.toLowerCase() == "right"))
                    {
                        toSpeak = reverseLeftRight(toSpeak, $("#chk_reverseDirection").prop("checked"));
                    }
                    
                    $("#debug_outputArea").html(toSpeak);   
                    speak(toSpeak);
                    /*                   
                    var utterThis = new SpeechSynthesisUtterance(toSpeak);
                    var selectedOption = voiceSelect.selectedOptions[0].getAttribute('data-name');
                    for(i = 0; i < voices.length ; i++) {
                        if(voices[i].name === selectedOption) {
                        utterThis.voice = voices[i];
                        }
                    }
                    synth.volume = parseFloat(volumeInput.value);
                    synth.rate = 1;
                    synth.pitch = 1;
                    synth.speak(utterThis);
                    */
                }
                if (toEventDisplay != "")
                {
                    var temp_events = toEventDisplay.split("@");
                    var temp_mainEvents = temp_events[0].split(":");   
                    mainEvent.innerHTML = temp_mainEvents[0];
                    mainTimer.innerHTML = (temp_mainEvents[1] ) ;
                    seconds =  secondsnow + (temp_mainEvents[1] -1) ;
                    subEvent.innerHTML = temp_events[1];
                }                
            }            
        }  
        else
        {
            if ( parseFloat(mainTimer.innerHTML) > 0)
            {
                //var temp_delay = 200;             
                //mainTimer.innerHTML = parseFloat(mainTimer.innerHTML) - parseFloat($("#input_delay").val())/1000;
                mainTimer.innerHTML = seconds - secondsnow;
            }
            else
            {
                mainTimer.innerHTML = 0
            }
        }
        return;  
    }   
    function ajaxFailure(e){
        console.log(e);
    return;
    }

    function reverseLeftRight(string, bool)
    {        
        if(bool)
        {
            return (string=="left" ? "right" : "left");
        }
        return string;
        
    }

    function personalizedSpeak(str)
    {
        if(str.indexOf("@") > -1)
        {
            var mainStr = str.split("@");
            for(i=0;i<mainStr.length;i++)
            {
                var subStr = mainStr[i].split(":");
                if(subStr[0] == myName)
                {
                    return subStr[1];
                }
            }
            return "";
        }
        return str;
    }
});