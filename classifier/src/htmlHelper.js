
// refreshes Abstract and sentiment score on textarea change
$('#abstractTextarea').bind('input propertychange', function() {
    refreshPreparedAbstract();
});

var refreshPreparedAbstract = function() {
    var inputText = $('#abstractTextarea').val();
    var processedText = formatText(inputText);
    refreshSentimentScore(processedText);
 };

var refreshSentimentScore = function(processedText) {

     displayAndCalculateAffin(processedText);
}

// Get HTML parameters 
function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}          

// Adds a generic info message in the infoMessages div in the HTML. Returns the number of instances.
var addInfoMessage = function(divId, message) {
    var numberOfInfoMessages = $('#' + divId).length;
    if (numberOfInfoMessages === 0) {
        if (divId == "sentiment") {
            var insertedDiv = '<div id="' + divId + '">' + message + '</div>';
        }
        else
        {
            var insertedDiv = '<div id="' + divId + '">' + message + '</div>';
        }

    	//$('#infoMessages').append(insertedDiv);
        document.getElementById('infoMessages').value = message;
    	
    }
    return numberOfInfoMessages;
};

// removes warning
var removeInfoMessage = function(divId) {
    $('#' + divId).remove();
};
