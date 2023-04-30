var polljs = {
  list : function(){
  // list() : show all the polls

    // FETCH DATA
    var data = new FormData();
    data.append('req', "list");

    // AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "4c-ajax-admin-poll.php", true);
    xhr.onload = function(){
      document.getElementById("poll-list").innerHTML = this.response;
    };
    xhr.send(data);
  },

  del : function(id) {
  // del() : delete poll
  // PARAM id : the poll id

    if (confirm("Delete poll?")) {
      // FETCH DATA
      var data = new FormData();
      data.append('req', "del");
      data.append('poll_id', id);

      // AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "4c-ajax-admin-poll.php", true);
      xhr.onload = function() {
        if (this.response=="OK") {
          polljs.list();
        } else {
          alert("Error deleting poll!");
        }
      };
      xhr.send(data);
    }
  },

  addEdit : function(id) {
  // addEdit() : show the add/edit poll docket
  // PARAM id : the poll id, if none is provided, will be an add new poll

    // FETCH DATA
    var data = new FormData();
    data.append('req', "addEdit");
    if (id != undefined) {
      data.append('poll_id', id);
    }

    // AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "4c-ajax-admin-poll.php", true);
    xhr.onload = function(){
      document.getElementById("poll-list").innerHTML = this.response;
    };
    xhr.send(data);
  },

  remove : function(el) {
  // remove() : remove selected option

    var parent = el.parentNode;
    document.getElementById("ae-poll-opt").removeChild(parent);
  },

  create : function(){
  // create() : add a new option

    var opt = document.createElement('div');
    opt.innerHTML = "<input type='text' class='ae-poll-opt'/> <input type='button' value='Remove' onclick='polljs.remove(this)'/>";
    document.getElementById("ae-poll-opt").appendChild(opt);
  },

  save : function(){
  // save() : save poll

    // COLLECT DATA + CHECKING
    var data = new FormData();
    var error = "";

    // POLL ID
    var check = document.getElementById("ae-poll-id").value;
    if (check=="") { data.append('req', "add"); }
    else {
      data.append('req', "edit");
      data.append('poll_id', check);
    }

    // POLL QUESTION
    check = document.getElementById("ae-poll-text").value;
    if (check=="") {
      error += "Please enter the question.\n";
    } else {
      data.append('poll_question', check);
    }

    // POLL OPTIONS
    check = document.getElementsByClassName("ae-poll-opt");
    if (check.length==0) {
      error += "Please create at least one option.\n";
    } else {
      var pass = true;
      for (let i=0; i<check.length; i++) {
        if (check[i].value=="") {
          pass = false;
        } else {
          data.append('poll_options[]', check[i].value);
        }
      }
      if (!pass) {
        error += "Please fill in all the options";
      }
    }

    // SAVE - AJAX
    if (error=="") {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "4c-ajax-admin-poll.php", true);
      xhr.onload = function(){
        if (this.response=="OK") {
          polljs.list();
        } else {
          alert("ERROR SAVING POLL");
        }
      };
      xhr.send(data);
    } else {
      alert(error);
    }
  }
};

window.addEventListener("load", polljs.list);