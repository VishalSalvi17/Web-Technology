var score = {
  last : 0, // Last updated timestamp
  poll : function () {
  // poll() : do a long poll AJAX to fetch new score

    // APPEND FORM DATA
    var data = new FormData();
    data.append('last', score.last);

    // INIT AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "score.php", true);
    xhr.timeout = 30000; // 1000 ms = 1 sec

    // KEEP FIRING REQUESTS TO GET UPDATES
    xhr.ontimeout = function () {
      // console.log("timeout");
      score.poll();
    };
    xhr.onload = function(){
      // console.log(this.response);
      if (xhr.status==403 || xhr.status==404) {
        alert("ERROR LOADING FILE!");
      } else {
        var res = "";
        try {
          res = JSON.parse(this.response);
          score.update(res);
        } catch (error) {
          // Probably a timeout error from the server
          // console.log(error);
          score.poll();
        }
      }
    };

    // SEND
    xhr.send(data);
  },

  update : function (data) {
  // update() : update last known score

    var message = "<p>HOME: " + data['h'] + "</p>";
    message += "<p>AWAY: " + data['a'] + "</p>";
    message += "<p>UPDATED: " + data['t'] + "</p>";
    document.getElementById("scoreboard").innerHTML = message;
    score.last = data['t'];
    score.poll();
  }
};

window.addEventListener("load", score.poll);