const api = "http://localhost/api"; // API の URL に置き換える

// fetch用 汎用関数
async function fetchData(url, method = 'GET', body = null) {
  const options = {
    method,
    headers: {
      'Content-Type': 'application/json',
    },
  };

  if (body) {
    options.body = JSON.stringify(body);
  }

  try {
    const response = await fetch(url, options);
    return await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
}



function addTodo() {
  const title = document.getElementById('new-todo').value;
  fetchData(`${api}/todos`, 'POST', { todo: { title } })
    .then(() => {
      document.getElementById('new-todo').value = '';
      fetchTodos();
    });
}

function fetchTodos() {
  fetchData(`${api}/todos`)
    .then(data => {
      const todoList = document.getElementById('todo-list');
      todoList.innerHTML = '';
      for (let todo of data.todos) {
        let listItem = document.createElement('li');
        listItem.className = 'todo-item';
        listItem.innerHTML = `
          ${todo.title}
          <button onclick="editTodo(${todo.id})">編集</button>
          <button onclick="deleteTodo(${todo.id})">削除</button>
        `;
        todoList.appendChild(listItem);
      }
    });
}

function editTodo(id) {
  const newTitle = prompt("新しいTODOを入力してください");
  fetchData(`${api}/todos/${id}`, 'PUT', { todo: { title: newTitle } })
    .then(() => fetchTodos());
}

function deleteTodo(id) {
  fetchData(`${api}/todos/${id}`, 'DELETE')
    .then(() => fetchTodos());
}

fetchTodos();
