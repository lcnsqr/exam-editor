/*
 *
 * Client side controller to render the interface 
 * and to communicate with the server controller.
 *
 */

// Update item count by category
function update_item_count(count){
  var ul = document.getElementById("item_count");
  while (ul.firstChild) {
    ul.removeChild(ul.firstChild);
  }
  count.forEach(function(cat){
    var li = document.createElement("li");
    li.innerHTML = cat.name + ": <strong>"+cat.count+"</strong>";
    ul.appendChild(li);
  });
}

// Update item currently being displayed on the template
function update_editor(editor){
  // Lista de itens no modelo
  var template_items = JSON.parse(editor.querySelector("script[data-id='template_items']").textContent);
  editor.dataset.templateItemCount = template_items.length;
  editor.querySelector("div.header span.template_item_count").textContent = template_items.length;
  editor.querySelector("div.info .item_nav a[href='#prev']").dataset.key = template_items.indexOf(parseInt(editor.dataset.itemId));
  editor.querySelector("div.info .item_nav a[href='#next']").dataset.key = template_items.indexOf(parseInt(editor.dataset.itemId));
  editor.querySelector("div.info .item_nav span.item_pos").textContent = template_items.indexOf(parseInt(editor.dataset.itemId)) + 1;
  editor.querySelector("div.info .item_nav span.template_item_count").textContent = template_items.length;
  // Load template item
  var item_contents = JSON.parse(editor.querySelector("script[data-id='item_contents']").textContent);
  editor.querySelectorAll("div.info div.fixed .var").forEach(function(v){
    v.innerHTML = item_contents.context[v.dataset.id];
  });
  var ul = editor.querySelector("div.info ul.sample_answer");
  while (ul.firstChild) {
    ul.removeChild(ul.firstChild);
  }
  item_contents.answer.forEach(function(ans){
    var li = document.createElement("li");
    if (editor.dataset.list > 0){
      li.dataset.correct = ans[0];
      li.innerHTML = ans[1];
    }
    else {
      li.innerHTML = ans;
    }
    ul.appendChild(li);
  });
  editor.querySelector("div.info span[data-id='item_id']").textContent = editor.dataset.itemId;
  editor.querySelector("div.info span[data-id='item_cat']").dataset.itemCatId = editor.dataset.itemCatId;
  editor.querySelector("div.info span[data-id='item_cat']").textContent = editor.dataset.itemCat;
  editor.querySelector("div.info span[data-id='item_enabled']").dataset.itemEnabled = editor.dataset.itemEnabled;
  editor.querySelector("div.info span[data-id='item_enabled']").textContent = ( editor.dataset.itemEnabled == 1 ) ? "Sim" : "Não";
  // Overwrite option on the form
  var form_edit = editor.querySelector("div.form_edit form");
  form_edit.querySelector("fieldset.overwrite input[type='checkbox'][name='overwrite']").dataset.itemId = editor.dataset.itemId;
  form_edit.querySelector("fieldset.overwrite span[data-id='item_id']").textContent = editor.dataset.itemId;
}

// Setting of each editor of each template
document.querySelectorAll("div.editor").forEach(function(editor){
  // Template ID of the editor
  var template_id = editor.dataset.templateId;
  // Load template item
  var item_contents = JSON.parse(editor.querySelector("div.info script[data-id='item_contents']").textContent);

  // Update template item
  update_editor(editor);

  // Browse items of the template
  editor.querySelectorAll("div.info .item_nav a").forEach(function(a){
    a.addEventListener("click", function(event){
      event.preventDefault();
      this.blur();
      // List of items of the template
      var template_items = JSON.parse(editor.querySelector("script[data-id='template_items']").textContent);
      if ( template_items.length == 0 ) return;
      // Find the current item_id
      var item_id = template_items[template_items.length - 1];
      if ( a.getAttribute("href") == "#prev" ){
        item_id = ( a.dataset.key > 0 ) ? template_items[parseInt(a.dataset.key) - 1] : template_items[0];
      }
      if ( a.getAttribute("href") == "#next" ){
        item_id = ( a.dataset.key < template_items.length - 1 ) ? template_items[parseInt(a.dataset.key) + 1] : item_id;
      }

      // Receive requested item and update items list
      var xhr = new XMLHttpRequest();
      xhr.open('POST', a.dataset.action);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onload = function() {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          // Update interface
          editor.querySelector("script[data-id='template_items']").textContent = response.template_items;
          editor.querySelector("script[data-id='item_contents']").textContent = response.item.contents;
          editor.dataset.itemId = response.item.item_id;
          editor.dataset.itemCatId = response.item.item_cat_id;
          editor.dataset.itemCat = response.item.item_cat;
          editor.dataset.itemEnabled = response.item.enabled;
          update_editor(editor);
          // Update item count by category
          update_item_count(response.items_per_cat);
        }
        else {
          console.log('Request failed. Return code: ' + xhr.status);
        }
      };

      xhr.send(JSON.stringify({
        item_id: item_id,
        template_id: a.dataset.templateId
      }));

    });
  });

  // Update all fields on the editor form
  var form_edit = editor.querySelector("div.form_edit form");
  editor.querySelectorAll("div.info div.fixed .var").forEach(function(v){
    // Create a new input for each variable on the question
    var clone = document.importNode(document.getElementById("template_var").content, true);
    var textarea = clone.querySelector("textarea");
    textarea.setAttribute("name", v.dataset.id);
    textarea.addEventListener("mouseenter", function(event){
      // Highlight the related text on the model
      document.querySelector("div.editor[data-template-id='"+template_id+"'] div.fixed .var[data-id='"+this.getAttribute("name")+"']").dataset.marker = 1;
    });
    textarea.addEventListener("mouseleave", function(event){
      document.querySelector("div.editor[data-template-id='"+template_id+"'] div.fixed .var[data-id='"+this.getAttribute("name")+"']").dataset.marker = 0;
    });
    // Insert elements on the DOM
    form_edit.querySelector("fieldset.context").appendChild(clone);
  });

  // Additional fields for written answers
  if (editor.dataset.list == 0){
    form_edit.querySelector("input[type='button'][name='btnAddWritten']").addEventListener("click", function(event){
      this.blur();
      var written = form_edit.querySelector("div.written_answer");
      var p = document.createElement("p");
      p.setAttribute("class", "input_placing");
      var textarea = document.createElement("textarea");
      textarea.setAttribute("name", "answer[]");
      var button = document.createElement("input");
      button.setAttribute("type", "button");
      button.setAttribute("name", "btnAddWritten");
      button.setAttribute("value", "➖");
      button.addEventListener("click", function(event){
        this.parentNode.remove();
      });
      p.appendChild(textarea);
      p.appendChild(button);
      written.appendChild(p);
    });
    // Add the new field in the DOM
    form_edit.querySelector("input[type='button'][name='btnAddWritten']").click();
  }

  // Copy the current model item on display
  form_edit.querySelector("input[type='button'][name='btnCopy']").addEventListener("click", function(event){
    var item_contents = JSON.parse(editor.querySelector("script[data-id='item_contents']").textContent);
    // Context
    form_edit.querySelectorAll("fieldset.context textarea").forEach(function(v){
      v.value = item_contents.context[v.getAttribute("name")];
    });
    // Answer(s)
    if (editor.dataset.list == 0){
      // Written answer
      var written = form_edit.querySelector("div.written_answer");
      while (written.firstChild) {
        written.removeChild(written.firstChild);
      }
      item_contents.answer.forEach(function(ans){
        var p = document.createElement("p");
        p.setAttribute("class", "input_placing");
        var textarea = document.createElement("textarea");
        textarea.setAttribute("name", "answer[]");
        textarea.value = ans;
        var button = document.createElement("input");
        button.setAttribute("type", "button");
        button.setAttribute("name", "btnAddWritten");
        button.setAttribute("value", "➖");
        button.addEventListener("click", function(event){
          this.parentNode.remove();
        });
        p.appendChild(textarea);
        p.appendChild(button);
        written.appendChild(p);
      });
    }
    else {
      // Multiple choice
      for (var i = 0; i < editor.dataset.list; i++){
        form_edit.querySelector("fieldset.answer input[data-answer='"+i+"']").checked = (item_contents.answer[i][0] == 1) ? true : false, 
        form_edit.querySelector("fieldset.answer textarea[data-answer='"+i+"']").value = item_contents.answer[i][1];
      }
    }
    form_edit.querySelector("fieldset.cat select[name='cat']").value = editor.dataset.itemCatId;
    form_edit.querySelector("fieldset.enabled input[type='checkbox'][name='enabled']").checked = ( editor.dataset.itemEnabled == 1 ) ? true : false;
    form_edit.querySelector("fieldset.overwrite input[type='checkbox'][name='overwrite']").dataset.itemId = editor.dataset.itemId;
    form_edit.querySelector("fieldset.overwrite span[data-id='item_id']").textContent = editor.dataset.itemId;
  });

  // Save the question
  form_edit.addEventListener("submit", function(event){
    event.preventDefault();
    // Overwrite confirmation
    var overwrite = this.querySelector("fieldset.overwrite input[type='checkbox'][name='overwrite']");
    if ( overwrite.checked && ! window.confirm(overwrite.dataset.label+overwrite.dataset.itemId+" ?") ) return;
    var item_contents = {
      'context': {},
      'answer': []
    };
    // Context
    this.querySelectorAll("fieldset.context textarea").forEach(function(v){
      item_contents.context[v.getAttribute("name")] = v.value;
    });
    // Answer(s)
    if (editor.dataset.list == 0){
      // Written answer
      this.querySelectorAll("fieldset.answer .written_answer textarea").forEach(function(ans){
        item_contents.answer.push(ans.value);
      });
    }
    else {
      // Multiple choice
      for (var i = 0; i < editor.dataset.list; i++){
        item_contents.answer.push([
          // Verify if the alternative is set as correct
          this.querySelector("fieldset.answer input[data-answer='"+i+"']").checked ? 1 : 0, 
          // Text for the alternative
          this.querySelector("fieldset.answer textarea[data-answer='"+i+"']").value
        ]);
      }
    }
    var newItem = {
      contents: JSON.stringify(item_contents),
      template_id: template_id,
      cat_id: this.querySelector("fieldset.cat select[name='cat']").value,
      enabled: ( this.querySelector("fieldset.enabled input[type='checkbox'][name='enabled']").checked ) ? 1 : 0,
      overwrite: ( overwrite.checked ) ? overwrite.dataset.itemId : 0
    };

    // Send new item
    var xhr = new XMLHttpRequest();
    xhr.open('POST', this.getAttribute("action"));
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        // Update interface
        editor.querySelector("script[data-id='template_items']").textContent = response.template_items;
        editor.querySelector("script[data-id='item_contents']").textContent = response.item.contents;
        editor.dataset.itemId = response.item.item_id;
        editor.dataset.itemCatId = response.item.item_cat_id;
        editor.dataset.itemCat = response.item.item_cat;
        editor.dataset.itemEnabled = response.item.enabled;
        update_editor(editor);
        // Update item count by category
        update_item_count(response.items_per_cat);
      }
      else {
        console.log('Request failed. Return code: ' + xhr.status);
      }
    };
    xhr.send(JSON.stringify(newItem));

  });

});

// Controls to Show/hide individual editors
document.querySelectorAll("div.editor > div.header > div.tools a.toggle_editor").forEach(function(a){
  a.addEventListener("click", function(event){
    event.preventDefault()
    if ( this.dataset.visible == 1){
      this.dataset.visible = 0;
      document.querySelector("div.editor > div.body[data-template-id='"+this.dataset.templateId+"']").dataset.visible = 0;
    }
    else {
      this.dataset.visible = 1;
      document.querySelector("div.editor > div.body[data-template-id='"+this.dataset.templateId+"']").dataset.visible = 1;
    }
    this.blur();
  });
});
