/*
 *
 * Client side controller to render the interface 
 * and to communicate with the server controller.
 *
 */

function render_form(test_form){
  // Render each question
  test_form.querySelectorAll("div.question").forEach(function(question){
    var item_contents = JSON.parse(question.querySelector("script[data-id='item_contents']").textContent);
    question.querySelectorAll("div.fixed .var").forEach(function(v){
      v.innerHTML = item_contents.context[v.dataset.id];
    });
    var answer = question.querySelector("div.answer");
    if (question.dataset.list > 0){
      var ul = document.createElement("ul");
      item_contents.answer.forEach(function(ans, index){
        var li = document.createElement("li");
        var input = document.createElement("input");
        input.setAttribute("type", ( question.dataset.many == 1 ) ? "checkbox" : "radio");
        input.setAttribute("name", ( question.dataset.many == 1 ) ? question.dataset.id+"[]" : question.dataset.id);
        input.setAttribute("id", question.dataset.id+"-"+index);
        input.setAttribute("value", ans);
        var label = document.createElement("label");
        label.setAttribute("for", question.dataset.id+"-"+index);
        label.innerHTML = ans;
        li.appendChild(input);
        li.appendChild(label);
        ul.appendChild(li);
      });
      answer.appendChild(ul);
    }
    else {
      var p = document.createElement("p");
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("name", question.dataset.id);
      input.setAttribute("id", question.dataset.id);
      p.appendChild(input);
      answer.appendChild(p);
    }
  });

  // Evaluate a question
  test_form.querySelectorAll('div.question input[type="button"][data-label="answer"]').forEach(function(button){
    button.addEventListener("click", function(event){
      var form = test_form.querySelector('form[name="test_form"]');
      var formData = new FormData(form);
      formData.append("ids", '["'+this.dataset.id+'"]');
      var xhr = new XMLHttpRequest();
      xhr.open('POST', form.getAttribute("action"));
      xhr.onload = function() {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          for (var id in response){
            document.querySelector('div.answer[data-id="'+id+'"]').dataset.correct = response[id];
          }
        }
        else {
          console.log('Request failed. Return code: ' + xhr.status);
        }
      }
      // Display a hourglass while waiting for the server to answer
      document.querySelector('div.answer[data-id="'+this.dataset.id+'"]').dataset.correct = "working";
      xhr.send(formData);
    });
  });

  // Reset answers
  test_form.querySelector('form[name="test_form"]').addEventListener("reset", function(event){
    this.querySelectorAll("div.question div.answer").forEach(function(answer){
      answer.dataset.correct = "";
    });
  });

  // Evaluate all answers
  test_form.querySelector('form[name="test_form"]').addEventListener("submit", function(event){
    event.preventDefault();
    var formData = new FormData(this);
    // Include questions list on the form
    formData.append("ids", this.querySelector("script[data-id='ids']").textContent);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.getAttribute("action"));
    xhr.onload = function() {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        for (var id in response){
          document.querySelector('div.answer[data-id="'+id+'"]').dataset.correct = response[id];
        }
      }
      else {
        console.log('Request failed. Return code: ' + xhr.status);
      }
    }
    this.querySelectorAll('div.answer').forEach(function(answer){
      // Display a hourglass while waiting for the server to answer
      answer.dataset.correct = "working";
    });
    xhr.send(formData);
  });
}

// Load questions for the selected category
function load_questions(cat, form){
  var action = form.dataset.action;
  var xhr = new XMLHttpRequest();
  xhr.open('GET', action+"&cat="+cat);
  xhr.onload = function() {
    if (xhr.status === 200) {
      form.innerHTML = xhr.responseText;
      render_form(form);
    }
    else {
      console.log('Request failed');
    }
  };
  xhr.send();
}

// Category selection with URI hash
window.addEventListener("hashchange", function(event){
  if ( location.hash == "" ) return;
  var cat = location.hash.substring(1);
  var test_form = document.querySelector("div.test_form");
  load_questions(cat, test_form);
});

// No hash, display category list
if ( location.hash != "" ){
  var cat = location.hash.substring(1);
  var test_form = document.querySelector("div.test_form");
  load_questions(cat, test_form);
}

// On small screens, categories are hidden on a side menu
document.getElementById("menu-trigger").addEventListener("click", function(event){
  var content = document.getElementById("content");
  content.dataset.menu = ( content.dataset.menu == "1" ) ? "0" : "1";
  this.blur();
});
