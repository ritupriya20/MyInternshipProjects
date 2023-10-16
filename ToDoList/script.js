document.addEventListener('DOMContentLoaded', function() {
    loadTasks();
});

function loadTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = '';

    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];

    tasks.forEach(function(task, index) {
        const li = document.createElement('li');
        li.innerHTML = `
            <span class="${task.completed ? 'completed' : ''}">${task.text}</span>
            <button onclick="editTask(${index})"><img src="edit.png" class="picture" alt="not avail">Edit</button>
            <button onclick="deleteTask(${index})"><img src="delete.png" class="picture" alt="not avail">Delete</button>
            <button onclick="toggleCompletion(${index})"><img src="complete.jpg" class="picture" alt="not avail">Complete</button>
        `;
        taskList.appendChild(li);
    });
}

function addTask() {
    const newTaskText = document.getElementById('newTask').value.trim();
    if (newTaskText === '') return;

    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
    tasks.push({ text: newTaskText, completed: false });
    localStorage.setItem('tasks', JSON.stringify(tasks));

    document.getElementById('newTask').value = '';
    loadTasks();
}

function editTask(index) {
    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
    const newText = prompt('Edit Task:', tasks[index].text);

    if (newText !== null && newText.trim() !== '') {
        tasks[index].text = newText.trim();
        localStorage.setItem('tasks', JSON.stringify(tasks));
        loadTasks();
    }
}

function deleteTask(index) {
    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
    tasks.splice(index, 1);
    localStorage.setItem('tasks', JSON.stringify(tasks));
    loadTasks();
}

function toggleCompletion(index) {
    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
    tasks[index].completed = !tasks[index].completed;
    localStorage.setItem('tasks', JSON.stringify(tasks));
    loadTasks();
}
