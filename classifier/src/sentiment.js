
var displayAndCalculateAffin = function(text) {

    score = computeAfinnScore(text);
    divId = "sentiment";
    nocategory= "NO Specialization";
    Category = score;

    removeInfoMessage(divId);

    if (isNaN(score) || score == 0) {
        addInfoMessage(divId,nocategory);
    }
    else if (score){
        addInfoMessage(divId,Category);
    }
}

var computeAfinnScore = function(text) {
    var words = text.split(/\W/).filter(function(w) { return !(w.length === 0 || !w.trim()); });
    var childdisorders_score = 0;
    var depression_score = 0;
    var anxiety_score = 0;
    var relationship_score = 0;
    var learning_score = 0;
    var addiction_score = 0;
    var stopwords_score =0;
    var match_word_length = 1;

    for(var i=0; i < words.length; i++) {


    word = words[i].toLowerCase();

    
    if(stopwords.hasOwnProperty(word)) {
        Score0= stopwords[word]
        stopwords_score += Score0;
    }
    if(childdisorders.hasOwnProperty(word)) {
        Score1= childdisorders[word]
        childdisorders_score += Score1;
    }
    if (depression.hasOwnProperty(word)) {
        score2= depression[word]
        depression_score += score2; 
    }
    if (anxiety.hasOwnProperty(word)) {
        score3= anxiety[word]
        anxiety_score += score3; 
    }
    if (relationship.hasOwnProperty(word)) {
        score4= relationship[word]
        relationship_score += score4; 
    }
    if (learning.hasOwnProperty(word)) {
        score5= learning[word]
        learning_score += score5; 
    }
    if (addiction.hasOwnProperty(word)) {
        score6= addiction[word]
        addiction_score += score6; 
    }
    
}
    if (isNaN(childdisorders_score)) {childdisorders_score =0;}
    if (isNaN(depression_score)) {depression_score =0;}
    if (isNaN(anxiety_score)) {anxiety_score =0;}
    if (isNaN(relationship_score)) {relationship_score =0;}
    if (isNaN(learning_score)) {learning_score =0;}
    if (isNaN(addiction_score)) {addiction_score =0;}
    if (isNaN(addiction_score)) {addiction_score =0;}
    if (words.length <=0) {words.length =1;}

    var arr = [childdisorders_score,depression_score,anxiety_score,relationship_score,learning_score,addiction_score];
    var max = arr[0];
    for (var i = 1; i < 6; i++) {
        if (max < arr[i]) {
            max = arr[i];
        }
    }


    childdisorders_percentage = "Children disorders = " + ((childdisorders_score/words.length)*100).toFixed(1) +"%";
    depression_percentage = "Depression = " + ((depression_score/words.length)*100).toFixed(1) +"%";
    anxiety_percentage = "Anxiety disorders = " + ((anxiety_score/words.length)*100).toFixed(1) +"%";
    relationship_percentage = "Relationship disorders = " + ((relationship_score/words.length)*100).toFixed(1) +"%";
    learning_percentage = "Learning disorders = " + ((learning_score/words.length)*100).toFixed(1) +"%";
    addiction_percentage = "Addiction = " + ((addiction_score/words.length)*100).toFixed(1) +"%";




    if (max == arr[0] && max !=0) {return 1;}
    else if (max == arr[1] && max !=0) {return 2;}
    else if (max == arr[2] && max !=0) {return 3;}
    else if (max == arr[3] && max !=0) {return 4;}
    else if (max == arr[4] && max !=0) {return 5;}
    else if (max == arr[5] && max !=0) {return 6;}
    else return 0;

    //return Math.round(score/words.length*1000)/1000;
}
