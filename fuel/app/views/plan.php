<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>ToDoリスト</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
  </head>
  <body>
    <h2>欲しいものリスト
    </h2>
    <input type="text" name="title" list="payment-select" data-bind="value: newTask" autocomplete="off"><br>
            <datalist id="payment-select">
                <option value="">please choose an option</option>
                <option value="食費">食費</option>
                <option value="光熱費">光熱費</option>
                <option value="交際費">交際費</option>
                <option value="クレジットカード">クレジットカード</option>
            </datalist>

            <input type="text" data-bind="value: newTask" />
    
    <button data-bind="click: addTask">追加</button>

    <ul data-bind="foreach: tasks">
      <li>
        <span data-bind="text: title"></span>
        <button data-bind="click: $parent.removeTask">削除</button>
      </li>
    </ul>

    <script>
      function Task(title) {
        this.title = title;
      }

      function TodoListViewModel() {
        var self = this;

        self.newTask = ko.observable('');
        self.tasks = ko.observableArray([]);

        self.addTask = function() {
          var title = self.newTask();
          if (title) {
            self.tasks.push(new Task(title));
            self.newTask('');
          }
        };
        self.removeTask = function(task) {
          self.tasks.remove(task);
        };
      }

      ko.applyBindings(new TodoListViewModel());
    </script>
  </body>
</html>